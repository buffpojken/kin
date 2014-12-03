<div class="col-md-3" id="sidebar">
	<?php if( isset( $_SESSION["userID"] ) ) { ?>
	<aside class="widget" id="profile">
		<?php
		if( file_exists( UPLOADS_PATH . '/avatars/'.$_SESSION["userID"].'-150x150.jpg' ) ) {
			echo '<img src="/uploads/avatars/'.$_SESSION["userID"].'-150x150.jpg" class="portrait" />' . PHP_EOL;
		} else {
			$firstInitial = substr($user->getUserData($_SESSION["userID"],'name', FALSE), 0, 1);
			$lastInitial = substr($user->getUserData($_SESSION["userID"],'surname', FALSE), 0, 1);
			echo '<img src="http://placehold.it/150/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait" />' . PHP_EOL;
		} ?>
		<h4>Hi, <?php $user->getUserData($_SESSION["userID"],'name', TRUE); ?> <?php $user->getUserData($_SESSION["userID"],'surname', TRUE); ?></h4>
		<p><a href="/profile" class="btn btn-default">Profile</a></p>
	</aside>
	<?php if( $_GET['path_page']=='messages' ) { ?>
	<aside class="widget">
		<p><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#composeMessage">Compose new message</button></p>
	</aside>
	<?php }
	} ?>
</div>