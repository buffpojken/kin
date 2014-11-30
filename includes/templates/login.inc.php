<form role="form" method="post" action="">
	<legend>Come on in ...</legend>
	
	<?php 
	if( isset( $_POST['action'] ) && $_POST['action']=='executeLogin' ) {
		$user = new Kin_User();
		$user->authorize( $_POST['login_email'], $_POST['login_password'], $_POST['login_cookie'] );
		
	}
	if( isset( $_POST['action'] ) && $_POST['action']=='startPasswordReset' ) {
		$user = new Kin_User();
		$user->startPasswordReset( $_POST['reset_email'] );
	} ?>
	<div class="form-group">
		<label for="login_email">Email address</label>
		<input type="email" class="form-control" id="login_email" name="login_email" placeholder="Enter email">
	</div>
	<div class="form-group">
		<label for="login_password">Password</label>
		<input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
	</div>
	<div class="checkbox">
		<label for="login_cookie">
			<input type="checkbox" name="login_cookie" id="login_cookie" value="yes" /> Remember me
		</label>
	</div>
	<button type="submit" class="btn btn-default">Log in</button>
	<button type="button" class="btn btn-link" data-toggle="modal" data-target="#passwordResetModal">I forgot my password!</button>
	<input type="hidden" name="action" value="executeLogin" />
</form>

<div class="modal fade" id="passwordResetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="modal-dialog" method="post" action="">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Password Reset</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="reset_email">Please enter your email address</label>
					<input type="email" class="form-control" name="reset_email" id="reset_email" placeholder="Enter email" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-primary">Reset my password</button>
				<input type="hidden" name="action" value="startPasswordReset" />
			</div>
		</div>
	</form>
</div>