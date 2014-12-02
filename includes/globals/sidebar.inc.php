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
		<p><a href="/profile">Profile</a> · <a href="/friends">Friends</a> · <a href="/logout">Log out</a></p>
	</aside>
	<?php } ?>
</div>