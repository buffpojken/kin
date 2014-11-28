<div class="page-header">
	<h1>Profile</h1>
</div>
<?php
if( isset( $_POST['action'] ) && $_POST['action']=='updatePassword' ) {
	$user->updatePassword($_POST['current_password'],$_POST['new_password_one'],$_POST['new_password_two']);
}
if( isset( $_POST['action'] ) && $_POST['action']=='updateProfile' ) {
	$user->updateProfile($_POST,$_FILES['profile_portrait']);
}
?>
<form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
	<fieldset>
		<legend>Core information</legend>
		<div class="form-group">
			<label for="profile_name" class="col-sm-3 control-label">Name</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="profile_name" name="profile_name" value="<?php $user->getUserData($_SESSION["userID"],'name', TRUE); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="profile_surname" class="col-sm-3 control-label">Surname</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="profile_surname" name="profile_surname" value="<?php $user->getUserData($_SESSION["userID"],'surname', TRUE); ?>" />
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
				<input type="text" class="form-control" id="profile_username" name="profile_username" placeholder="<?php $user->getUserData($_SESSION["userID"],'username', TRUE); ?>" disabled="disabled" />
			</div>
		</div>
		<div class="form-group">
			<label for="profile_email" class="col-sm-3 control-label">Email</label>
			<div class="col-sm-9">
				<input type="email" class="form-control" id="profile_email" name="profile_email" value="<?php $user->getUserData($_SESSION["userID"],'email', TRUE); ?>" />
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