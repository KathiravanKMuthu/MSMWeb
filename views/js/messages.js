var app = angular.module('MSMApp', ['ngRoute', 'datatables', 'ngFileUpload', 'ngFlash']);

app.controller("mainController", function ($scope, $compile, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, Upload, $timeout, $http, Flash) {
    var vm = this;

    vm.dtInstance = {};
    vm.selected = {};
    vm.buttonEdit = {};
    vm.updateId = "";
    $scope.date = new Date();

    vm.dtOptions = DTOptionsBuilder.newOptions().withOption('ajax', {
            "contentType": "application/json; charset=utf-8",
            dataType: "json",
            "url": "../api/read_all_daily_messages.php",
            "type": 'GET'
        })
        .withOption('createdRow', function (row, data, dataIndex) {
            // recompile so we can bind angular directive to the DT
            $compile(angular.element(row).contents())($scope);
    }).withDisplayLength(50);

    vm.dtColumns = [
        DTColumnBuilder.newColumn('id').withTitle('id').notVisible(),
        DTColumnBuilder.newColumn('title').withTitle('Title'),
        DTColumnBuilder.newColumn('description').withTitle('Description').notSortable().renderWith(function (data, type, full, meta) {
            return data.substr(0,300) + '......';
        }),
        DTColumnBuilder.newColumn('picture').withTitle('Picture').notSortable().renderWith(function (data, type, full, meta) {
            return '<img style="width:100px;height:80px" src=\"images/' + data + '\"/>';
        }),
        DTColumnBuilder.newColumn('time_created').withTitle('Published Date').renderWith(function (data, type, full, meta) {
            return moment(data, "YYYY-MM-DD HH:mm Z").format("DD-MMM-YYYY HH:mm A");
        }),
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable().renderWith(function (data, type, full, meta) {
            return '<button class="btn btn-danger" ng-click="vm.deleteMessage(' + data.id + ')" )"="">' +
            '   <i class="fa fa-trash-o"></i>' +
            '</button>';
        })
    ];

    vm.callSearch = function () {
        vm.dtInstance.reloadData();
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
            {
                errorMsg = response.status + ': ' + response.data;
                var id = Flash.create('danger', errorMsg, 0, {container: 'flashForm'}, true);
            }
            else
            {
                var id = Flash.create('info', 'Successfully published the message', 0, {container: 'flashForm'}, true);
            }
        }, function (evt) {
            // Math.min is to fix IE which reports 200% sometimes
            imageFile.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });

    }

    vm.deleteMessage = function(messageId) {
        var parameter = $.param({
                id: messageId
        });

        var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };

        $http.post('../api/delete_message.php', parameter, config)
            .then(function(response) {
                var id = Flash.create('info', response.data.message, 0, {container: 'flashDataTable'}, true);
                vm.reloadData = reloadData();
                vm.dtInstance = {};
            }, function(response) {
                errorMsg = response.status + ': ' + response.data;
                var id = Flash.create('danger', errorMsg, 0, {container: 'flashDataTable'}, true);
            });
    }

    function reloadData() {
        var resetPaging = true;
        vm.dtInstance.reloadData(callback, resetPaging);
    }

    function callback(json) {
        console.log(json);

        vm.dtOptions = DTOptionsBuilder.newOptions().withOption('ajax', {
                "contentType": "application/json; charset=utf-8",
                dataType: "json",
                "url": "../api/read_all_daily_messages.php",
                "type": 'GET'
            })
            .withOption('createdRow', function (row, data, dataIndex) {
                // recompile so we can bind angular directive to the DT
                $compile(angular.element(row).contents())($scope);
        }).withDisplayLength(50);
    }

});
