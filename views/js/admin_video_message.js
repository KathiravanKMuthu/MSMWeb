var app = angular.module('MSMApp', ['ngRoute', 'datatables']);

app.controller("mainController", function ($scope, $compile, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $http) {

    console.log("Inside video mainController");
    var vm = this;

    function getParameterByName(url, name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(url);
      return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    vm.dtInstance = null;
    vm.selected = {};
    vm.buttonEdit = {};
    vm.updateId = "";

    vm.dtOptions = DTOptionsBuilder.newOptions().withOption('ajax', {
            "contentType": "application/json; charset=utf-8",
            dataType: "json",
            "url": "../api/read_all_video_messages.php",
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
            var thumb = getParameterByName(data, 'v'),
                url = 'http://img.youtube.com/vi/' + thumb + '/default.jpg';
            return '<a href=\"' + data + '\" target=\"_blank\"> <img src=\"' + url + '\"/> </a>';
        }),
        DTColumnBuilder.newColumn('time_created').withTitle('Published Date').renderWith(function (data, type, full, meta) {
            return moment(data, "YYYY-MM-DD HH:mm Z");
        })
    ];

    vm.callSearch = function () {
        vm.dtInstance.reloadData();
        console.log(vm.dtInstance.DataTable.data());
    }

    vm.callVideoInsert = function () {

        var parameter = $.param({
                title: vm.title,
                description: vm.description,
                picture: vm.picture
            });

        var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            };

        $http.post('../api/create_video_message.php', parameter, config)
            .then(function(response) {
                $scope.successMsg = response.message;
                vm.title = "";
                vm.description = "";
                vm.picture = "";
            }, function(response) {
                $scope.errorMsg = response.error;
            });
    }

});