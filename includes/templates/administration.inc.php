<?php if( $user->getUserData($_SESSION["userID"],'siteAdmin') != 1 ) {
	HEADER('Location: /');
	exit();
} ?>
<div class="page-header">
	<h1>Administration</h1>
</div>
<?php if( isset( $_POST['action'] ) && $_POST['action']=='updateSiteSettings' ) {
	$utility->updateSiteSettings($_POST);
}
?>
<form role="form" method="post" action="" class="form-horizontal">
	<fieldset>
		<legend>General Settings</legend>
		<div class="form-group">
			<label for="site_title" class="col-sm-2 control-label">Site Title</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="site_title" id="site_title" placeholder="Enter the name of your social network here" value="<?php $utility->siteOptions('SITE_NAME', TRUE); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="site_description" class="col-sm-2 control-label">Site Description</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="site_description" id="site_description" placeholder="Enter the description of your social network here" value="<?php $utility->siteOptions('SITE_DESCRIPTION', TRUE); ?>" />
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Footer</legend>
		<div class="form-group">
			<label for="site_title" class="col-sm-2 control-label">Scripts</label>
			<div class="col-sm-10">
				<textarea class="form-control" name="site_footer_scripts" id="site_footer_scripts" rows="4"><?php $utility->siteOptions('SITE_FOOTER_SCRIPTS', TRUE); ?></textarea>
				<span id="helpBlock" class="help-block">Enter any javascript here (ie. Google Analytics tracking code). It will be included right before the closing body-tag.</span>
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">Save changes</button>
		</div>
	</div>
	<input type="hidden" name="action" value="updateSiteSettings" />
</form>