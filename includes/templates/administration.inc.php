<?php if( $user->getUserData($_SESSION["userID"],'siteAdmin') != 1 ) {
	HEADER('Location: /');
	exit();
} ?>
<div class="page-header">
	<h1>Administration</h1>
</div>