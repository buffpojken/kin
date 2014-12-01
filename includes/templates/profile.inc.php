<?php
if( isset( $_GET['path_section'] ) ) {
	if( !$user->profileExists($_GET['path_section']) ) {
		HEADER('Location: /');
		exit;
	} else {
		$profile = new Kin_User($_GET['path_section']);		
		?>
		<div id="profileCard" class="well well-sm">
			<img src="/uploads/avatars/<?php echo $profile->userID; ?>-150x150.jpg" class="portrait pull-left" />
			<h1><?php echo $profile->name . ' ' . $profile->surname; ?></h1>
			<?php if( $profile->isCurrentUserFriendsWithThisProfile($profile->userID) && $profile->userID != $_SESSION['userID'] ) { ?>
			<p>You already friends. <a href="#">Unfriend?</a></p>
			<?php } elseif( $profile->userID != $_SESSION['userID'] ) { ?>
			<p>You're not friends. <a href="#">Send friend request?</a></p>
			<?php } ?>
			<div class="clearfix"></div>
		</div> 
		
		<?php if( isset( $_GET['path_item'] ) ) {
			if( $_GET['path_item']=='updates' && is_numeric( $_GET['path_action'] ) ) { ?>
		<ul id="updates">
		<?php
		if( $updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE id = '{$_GET['path_action']}' LIMIT 1" ) ) {
			foreach( $updates as $update ) {
				require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
			}
		} else {
			echo '<li class="no-updates">Sadly, '.$profile->name.' hasn\'t posted any updates yet.</li>';
		} ?>
		</ul>
			<?php } else {
				HEADER('Location: /');
				exit;
			}
		} else { ?>
			
		<ul id="updates">
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