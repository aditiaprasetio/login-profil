<!doctype html>
<html lang="en" ng-app>
	<head>
    <meta charset="utf-8">
		<title>My HTML File</title>
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" />
		<!--<script src="bower_components/angular/angular.js"></script>-->
		<script src="<?php echo base_url('assets\js\angular-1.6.6\angular.js'); ?>"></script>
	</head>
	<body ng-controller="MyController">
	   <input ng-model="foo" value="bar">
	   <!-- Button tag with ngClick directive, and
			string expression 'buttonText'
			wrapped in "{{ }}" markup -->
		<button ng-click="changeFoo()">{{buttonText}}</button>
	   <script src="angular.js"></script>
	</body>
</html>
