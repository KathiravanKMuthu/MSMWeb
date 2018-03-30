var app = angular.module('MSMApp', ['ngRoute', 'datatables', 'ngFileUpload', 'ngFlash']);

app.controller("mainController", function ($scope, $compile, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $http, Flash) {
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
    $scope.date = new Date();
    
    vm.dtOptions = DTOptionsBuilder.newOptions().withOption('ajax', {
            "contentType": "application/json; charset=utf-8",
            dataType: "json",
            "url": "../api/read_all_video_messages.php",
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
            var thumb = getParameterByName(data, 'v'),
                url = 'http://img.youtube.com/vi/' + thumb + '/default.jpg';
            return '<a href=\"' + data + '\" target=\"_blank\"> <img style="height:80px;width:100px" src=\"' + url + '\"/> </a>';
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
                var id = Flash.create('info', 'Successfully published the message', 0, {container: 'flashForm'}, true);
                vm.title = "";
                vm.description = "";
                vm.picture = "";
                vm.dtInstance.reloadData();
            }, function(response) {
                errorMsg = response.status + ': ' + response.data;
                var id = Flash.create('danger', errorMsg, 0, {container: 'flashForm'}, true);
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
        vm.dtOptions = DTOptionsBuilder.newOptions().withOption('ajax', {
                "contentType": "application/json; charset=utf-8",
                dataType: "json",
                "url": "../api/read_all_video_messages.php",
                "type": 'GET'
            })
            .withOption('createdRow', function (row, data, dataIndex) {
                // recompile so we can bind angular directive to the DT
                $compile(angular.element(row).contents())($scope);
        }).withDisplayLength(50);
    }
});