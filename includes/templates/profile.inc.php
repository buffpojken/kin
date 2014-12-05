<?php
if( isset( $_GET['path_section'] ) ) {
	if( !$user->profileExists($_GET['path_section']) ) {
		HEADER('Location: /');
		exit;
	} else {
		$profile = new Kin_User($_GET['path_section']);
		if( isset( $_POST['action'] ) && $_POST['action']=='unfriend' ) {
			if( $friendships->destroyFriendship( $_POST['userID'] ) ) {
				echo '<div class="alert alert-success" role="alert"><strong>That did it!</strong> You are no longer friends with ' . $profile->name . ' ' . $profile->surname . '. Don\'t regret it now.</div>';
			} else {
				echo '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> We couldn\'t revoke your friendship. Please try again.</div>';
			}
		}
		if( isset( $_POST['action'] ) && $_POST['action']=='friend' ) {
			if( $friendships->requestFriendship( $_POST['userID'] ) ) {
				echo '<div class="alert alert-success" role="alert"><strong>Awesome!</strong> We\'ve told ' . $profile->name . ' ' . $profile->surname . ' that you think you should be friends. Now you just gotta wait!</div>';
			} else {
				echo '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> We were unable to send your friend request. Please try again.</div>';
			}
		}
		?>
		<div id="profileCard" class="well well-sm">
			<?php
			if( file_exists( UPLOADS_PATH . '/avatars/'.$profile->userID.'-150x150.jpg' ) ) {
				echo '<img src="/uploads/avatars/'.$profile->userID.'-150x150.jpg" class="portrait pull-left" />' . PHP_EOL;
			} else {
				$firstInitial = substr($profile->name, 0, 1);
				$lastInitial = substr($profile->surname, 0, 1);
				echo '<img src="http://placehold.it/150/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait pull-left" />' . PHP_EOL;
			} ?>
			<h1><?php echo $profile->name . ' ' . $profile->surname; ?></h1>
			<?php if( $profile->userID != $_SESSION['userID'] ) { ?>
			<form role="form" method="post" action="">
				<?php if( $friendships->areWeFriends( $profile->userID ) ) { ?>
				<div class="btn-group" role="group" aria-label="...">
					<!--<button type="button" class="btn btn-default btn-sm">Send message</button>-->
					<button type="submit" name="action" value="unfriend" class="btn btn-danger btn-sm">Unfriend</button>
					<input type="hidden" name="userID" value="<?php echo $profile->userID; ?>" />
				</div>
				<?php } else { ?>
				<div class="btn-group" role="group" aria-label="...">
					<!--<button type="button" class="btn btn-default btn-sm">Send message</button>-->
					<button type="submit" name="action" value="friend" class="btn btn-default btn-sm">Add friend</button>
					<input type="hidden" name="userID" value="<?php echo $profile->userID; ?>" />
				</div>
				<?php } ?>
			</form>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		
		<?php if( isset( $_GET['path_item'] ) ) {
			if( $_GET['path_item']=='updates' && is_numeric( $_GET['path_action'] ) ) {
			$updateID = $_GET['path_action'];
			?>
		<ul class="updates">
		<?php
		if( $updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE id = '{$updateID}' LIMIT 1" ) ) {
			foreach( $updates as $update ) {
				require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
			}
			if( $comments = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."comments WHERE updateID = '{$updateID}' ORDER BY timestamp ASC" ) ) {
				foreach( $comments as $comment ) {
					require( TEMPLATE_PATH . '/partials/comments-loop.inc.php' );
				}
			} else {
				echo '<li class="no-comments">Whoa! No one has commented on this yet!</li>';
			}
		} else {
			echo '<li class="no-updates">Sadly, '.$profile->name.' hasn\'t posted any updates yet.</li>';
		} ?>
		</ul>
		<?php
		require( TEMPLATE_PATH . '/partials/comment-form.inc.php' ); 
			} else {
				HEADER('Location: /');
				exit;
			}
		} else { ?>
			
		<ul class="updates">
		<?php
		if( $updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE userID = '{$profile->userID}' ORDER BY id DESC LIMIT 15" ) ) {
			foreach( $updates as $update ) {
				require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
			}
		} else {
			echo '<li class="no-updates">Sadly, '.$profile->name.' hasn\'t posted any updates yet.</li>';
		} ?>
		</ul>
		<?php }
	}
} else { ?>
<div class="page-header">
	<h1>Profile</h1>
</div>
<?php
if( isset( $_POST['action'] ) && $_POST['action']=='updatePassword' ) {
	$user->updatePassword($_POST['current_password'],$_POST['new_password_one'],$_POST['new_password_two']);
}
if( isset( $_POST['action'] ) && $_POST['action']=='updateProfile' ) {
	$user->updateProfile($_POST,$_FILES['profile_portrait']);
} ?>
<form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
	<fieldset>
		<legend>Core information</legend>
		<div class="form-group">
			<label for="profile_name" class="col-sm-3 control-label">Name</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="profile_name" name="profile_name" value="<?php echo $user->name; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="profile_surname" class="col-sm-3 control-label">Surname</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="profile_surname" name="profile_surname" value="<?php echo $user->surname; ?>" />
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Portrait</legend>
		<div class="form-group">
			<label for="profile_portrait" class="col-sm-3 control-label">Upload portrait</label>
			<div class="col-sm-9">
				<input type="file" class="form-control" id="profile_portrait" name="profile_portrait" />
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Technical stuff</legend>
		<div class="form-group">
			<label for="profile_username" class="col-sm-3 control-label">Username</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="profile_username" name="profile_username" placeholder="<?php echo $user->username; ?>" disabled="disabled" />
			</div>
		</div>
		<div class="form-group">
			<label for="profile_email" class="col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
				<input type="email" class="form-control" id="profile_email" name="profile_email" value="<?php echo $user->email; ?>" />
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" class="btn btn-default">Save changes</button>
		</div>
	</div>
	<input type="hidden" name="action" value="updateProfile" />
</form>

<hr />

<form class="form-horizontal" role="form" method="post" action="">
	<fieldset>
		<legend>Password</legend>
		<div class="form-group">
			<label for="current_password" class="col-sm-3 control-label">Current password</label>
			<div class="col-sm-9">
				<input type="password" class="form-control" id="current_password" name="current_password" />
			</div>
		</div>
		<div class="form-group">
			<label for="new_password_one" class="col-sm-3 control-label">New password</label>
			<div class="col-sm-9">
				<input type="password" class="form-control" id="new_password_one" name="new_password_one" />
			</div>
		</div>
		<div class="form-group">
			<label for="new_password_two" class="col-sm-3 control-label">Repeat password</label>
			<div class="col-sm-9">
				<input type="password" class="form-control" id="new_password_two" name="new_password_two" />
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" class="btn btn-default">Change password</button>
		</div>
	</div>
	<input type="hidden" name="action" value="updatePassword" />
</form>
<?php } ?>