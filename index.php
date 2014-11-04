<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Kin</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" title="Bootstrap" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="assets/css/kin.css" title="Bootstrap" type="text/css" media="screen" charset="utf-8">
		<!-- JS -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js" charset="utf-8"></script>
	</head>
	<body>
		<nav class="navbar navbar-default" role="navigation">
			<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">Kin</a>
				</div>
			
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Wall</a></li>
						<li><a href="#">Messages</a></li>
						<li><a href="#">Groups</a></li>
						<li><a href="#">Friends</a></li>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, %name% <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Profile</a></li>
								<li><a href="#">Settings</a></li>
								<li><a href="#">Notifications</a></li>
								<li class="divider"></li>
								<li><a href="#">Sign out</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Foobar</p>
				</div>
			</div>
		</div>
		
	</body>
</html>
