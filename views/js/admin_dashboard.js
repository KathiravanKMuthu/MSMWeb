var app = angular.module('MSMApp', ['ngRoute', 'datatables', 'ngFileUpload']);

app.controller("mainController", function ($scope, $compile, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, Upload, $timeout) {

    console.log("Inside mainController");
    var vm = this;

    vm.dtInstance = null;
    vm.selected = {};
    vm.buttonEdit = {};
    vm.updateId = "";

    vm.dtOptions = DTOptionsBuilder.newOptions().withOption('ajax', {
            "contentType": "application/json; charset=utf-8",
            dataType: "json",
            "url": "../api/read_all_daily_messages.php",
            "type": 'GET'
        })
        .withOption('createdRow', function (row, data, dataIndex) {
			console.log("Inside createdRow");
            // recompile so we can bind angular directive to the DT
            $compile(angular.element(row).contents())($scope);
   });


    vm.dtColumns = [
        DTColumnBuilder.newColumn('id').withTitle('id').notVisible(),
        DTColumnBuilder.newColumn('title').withTitle('Title'),
        DTColumnBuilder.newColumn('description').withTitle('Description'),
        DTColumnBuilder.newColumn('picture').withTitle('Picture').notSortable().renderWith(function (data, type, full, meta) {
            return '<img style="width:150px;height:150px" src=\"images/' + data + '\"/>';
        }),
        DTColumnBuilder.newColumn('time_created').withTitle('Published Date').renderWith(function (data, type, full, meta) {
            return moment(data, "YYYY-MM-DD HH:mm Z");
        })
    ];

    vm.callSearch = function () {
        vm.dtInstance.reloadData();
        console.log(vm.dtInstance.DataTable.data());
    }

    vm.callInsert = function (imageFile) {
        var upload = Upload.upload({
            url: '../api/create_message.php',
            data: { picture: imageFile, title: vm.title, description: vm.description },
        });

        upload.then(function (resp) {
            console.log('file is uploaded successfully. ');

            $timeout(function () {
                imageFile.result = '';
                vm.dtInstance.reloadData();
                vm.title = '';
                vm.description = '';
                $scope.picture = '';
            });
        }, function (response) {
            if (response.status > 0)
                $scope.errorMsg = response.status + ': ' + response.data;
            else
                $scope.successMsg = "Successfully published the message";
        }, function (evt) {
            // Math.min is to fix IE which reports 200% sometimes
            imageFile.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });

    }  
});