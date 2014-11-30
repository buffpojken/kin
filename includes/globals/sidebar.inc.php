<div class="col-md-3" id="sidebar">
	<?php if( isset( $_SESSION["userID"] ) ) { ?>
	<aside class="widget" id="profile">
		<img src="/uploads/avatars/<?php echo $_SESSION['userID']; ?>-150x150.jpg" class="portrait" />
		<h4>Hi, <?php $user->getUserData($_SESSION["userID"],'name', TRUE); ?> <?php $user->getUserData($_SESSION["userID"],'surname', TRUE); ?></h4>
		<p><a href="/profile">Profile</a> · <a href="/friends">Friends</a> · <a href="/?action=logout">Log out</a></p>
	</aside>
	<?php } ?>
	<p class="copyright">
		Proudly powered by <a href="#">Kin</a>.<br />
		Version <?php echo KIN_VERSION; ?>
	</p>
</div>