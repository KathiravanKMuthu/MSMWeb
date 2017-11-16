<html ng-app="MSMApp">
<head>
    <meta charset="utf-8">
    <title>Morning Scriptures for VMM</title>
	<link rel="shortcut icon" href="images/favicon.ico">

    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" />

    <!-- ANGULAR -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.0/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.0/angular-route.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.0/angular-animate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.0/angular-resource.min.js"></script>
	
    <script src="js/angularDatatables/angular-datatables.directive.js"></script>
    <script src="js/angularDatatables/angular-datatables.instances.js"></script>
    <script src="js/angularDatatables/angular-datatables.util.js"></script>
    <script src="js/angularDatatables/angular-datatables.renderer.js"></script>
    <script src="js/angularDatatables/angular-datatables.factory.js"></script>
    <script src="js/angularDatatables/angular-datatables.options.js"></script>
    <script src="js/angularDatatables/angular-datatables.js"></script>

    <script src="js/ng-file-upload-shim.min.js"></script> <!-- for no html5 browsers support -->
    <script src="js/ng-file-upload.min.js"></script>
	
    <!-- <BOOTSTRAP> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- CUSTOM -->
	<script src="js/admin_dashboard.js"></script>
    <link rel="stylesheet" href="css/main.css">

</head>
<body ng-controller="mainController as vm">
    <nav class="navbar navbar-fixed-top navbar-default">
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
                <li><h2>Welcome VMM Admin !!!</h2></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin_logout.php" class="btn btn-lg"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
        </div>
    </nav><!-- navbar -->

    <div class="container">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <div class="panel panel-info">
            <div class="panel-heading"><h3>New Scripture</h3></div>
            <div class="panel-body">
                <form class="form-horizontal formRocket" role="form" name="myForm">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Title:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" ng-model="vm.title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lastname">Description:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" ng-model="vm.description" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lastname">Picture:</label>
                        <div class="col-sm-8">
                            <input type="file" ngf-select ng-model="picture" name="imageFile" accept="image/*" ngf-max-size="2MB" required ngf-model-invalid="errorFile" class="btn btn-success">
                            <i ng-show="myForm.file.$error.required">*required</i><br>
                            <i ng-show="myForm.file.$error.maxSize">File too large {{errorFile.size / 1000000|number:1}}MB: max 2M</i>
                            <img ng-show="myForm.file.$valid" ngf-thumbnail="picture" class="thumb"> <button ng-click="picture = null" ng-show="picture" class="btn btn-danger">Remove</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="err" ng-show="errorMsg">{{errorMsg}}</span>
                    </div>
                    <div class="form-group">
                        <p align="center">
                            <button type="button" class="btn btn-success btn-md" ng-disabled="!myForm.$valid" ng-model="vm.buttonInsert" ng-click="vm.callInsert(picture)">
                                 Publish the scripture
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading"><h3>History</h3></div>
        <div class="panel-body">
            <table datatable="" ng-model="vm.clientLength" class="table table-striped table-bordered" dt-options="vm.dtOptions" dt-column-defs="vm.dtColumnDefs"
                   dt-columns="vm.dtColumns" dt-instance="vm.dtInstance"></table>
        </div>
    </div>
</body>
</html>