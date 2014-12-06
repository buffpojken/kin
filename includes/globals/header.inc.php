<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- WEBAPP STUFF -->
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">.
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<!-- TITLE -->
		<title><?php $utility->siteTitle(); ?></title>
		<!-- CSS -->
		<link rel="stylesheet" href="/assets/css/lumen.min.css" title="Bootstrap" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="/assets/js/chosen_v1.2.0/chosen.min.css" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="/assets/css/kin.css" type="text/css" media="screen" charset="utf-8">
		<!-- JS -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
		<script src="/assets/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/assets/js/chosen_v1.2.0/chosen.jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/assets/js/bootstrap-fileinput.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/assets/js/min/kin-min.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body<?php $utility->bodyClass(); ?>>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
			<?php if( isset( $_SESSION["userID"] ) ) { ?>
			<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#kin-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/"><?php $utility->siteOptions('SITE_NAME', TRUE); ?></a>
				</div>
			
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="kin-navbar-collapse">
					<ul class="nav navbar-nav">
						<li<?php if( $_GET['path_page']=='' ) { echo ' class="active"'; } ?>><a href="/">Wall</a></li>
						<li<?php if( $_GET['path_page'] =='friends' ) { echo ' class="active"'; } ?>><a href="/friends">Friends</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li<?php if( $_GET['path_page'] =='messages' ) { echo ' class="active"'; } ?>>
							<a href="/messages/" data-toggle="tooltip" data-placement="bottom" title="Messages">
								<span class="glyphicon glyphicon-inbox hidden-xs" aria-hidden="true"></span> 
								<span class="hidden-sm hidden-md hidden-lg">Messages</span>
								<!--<?php $unreadCount = $messageUtility->unreadMessageCount( $_SESSION["userID"] ); if( $unreadCount > 0 ) { echo '<span class="badge">'.$unreadCount.'</span>'; } ?>-->
							</a>
						</li>
						<li<?php if( $_GET['path_page'] =='notifications' ) { echo ' class="active"'; } ?>>
							<a href="/notifications/" data-toggle="tooltip" data-placement="bottom" title="Notifications">
								<span class="glyphicon glyphicon-info-sign hidden-xs" aria-hidden="true"></span> 
								<span class="hidden-sm hidden-md hidden-lg">Notifications</span>
								<?php $unreadCount = $notifications->unreadNotificationCount( $_SESSION["userID"] ); if( $unreadCount > 0 ) { echo '<span class="badge">'.$unreadCount.'</span>'; } ?>
							</a>
						</li>
						<?php if( $user->getUserData($_SESSION["userID"],'siteAdmin') == 1 ) { ?>
						<li<?php if( $_GET['path_page'] =='administration' ) { echo ' class="active"'; } ?>>
							<a href="/administration/" data-toggle="tooltip" data-placement="bottom" title="Administration">
								<span class="glyphicon glyphicon-cog hidden-xs" aria-hidden="true"></span> 
								<span class="hidden-sm hidden-md hidden-lg">Administration</span>
							</a>
						</li>
						<?php } ?>
						<li<?php if( $_GET['path_page'] =='logout' ) { echo ' class="active"'; } ?>>
							<a href="/logout/" data-toggle="tooltip" data-placement="bottom" title="Logout">
								<span class="glyphicon glyphicon-log-out hidden-xs" aria-hidden="true"></span> 
								<span class="hidden-sm hidden-md hidden-lg">Notifications</span>
							</a>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			<?php } else { ?>
				<div class="navbar-header">
					<a class="navbar-brand" href="/"><?php $utility->siteOptions('SITE_NAME', TRUE); ?></a>
				</div>
			<?php } ?>
			</div><!-- /.container-fluid -->
		</nav>