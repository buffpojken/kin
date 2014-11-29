<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Kin</title>
		<!-- CSS -->
		<link rel="stylesheet" href="/assets/css/bootstrap.css" title="Bootstrap" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="/assets/css/kin.css" title="Bootstrap" type="text/css" media="screen" charset="utf-8">
		<!-- JS -->
		<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		<script type="text/javascript" src="/assets/js/jquery-1.11.1.min.js"></script>
		<script src="/assets/js/bootstrap.min.js" charset="utf-8"></script>
		<script src="/assets/js/kin.js" charset="utf-8"></script>
	</head>
	<body<?php $utility->bodyClass(); ?>>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
			<?php if( isset( $_SESSION["userID"] ) ) { ?>
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
						<li<?php if( $_GET['path_page']=='' ) { echo ' class="active"'; } ?>><a href="/">Wall</a></li>
						<!--<li<?php if( $_GET['path_page'] =='messages' ) { echo ' class="active"'; } ?>><a href="/messages">Messages</a></li>-->
						<li<?php if( $_GET['path_page'] =='friends' ) { echo ' class="active"'; } ?>><a href="/friends">Friends</a></li>
						<!--<li<?php if( $_GET['path_page'] =='notifications' ) { echo ' class="active"'; } ?>><a href="/notifications">Notifications</a></li>-->
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?php $user->getUserData($_SESSION["userID"],'name', TRUE); ?> <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/profile">Profile</a></li>
								<?php if( $user->getUserData($_SESSION["userID"],'siteAdmin') == 1 ) { ?>
								<li class="divider"></li>
								<li><a href="/administration">Administration</a></li>	
								<?php } ?>
								<li class="divider"></li>
								<li><a href="?action=logout">Sign out</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			<?php } else { ?>
				<div class="navbar-header">
					<a class="navbar-brand" href="/">Kin</a>
				</div>
			<?php } ?>
			</div><!-- /.container-fluid -->
		</nav>