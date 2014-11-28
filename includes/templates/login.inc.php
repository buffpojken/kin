<form role="form" method="post" action="">
	<legend>Come on in ...</legend>
	
	<?php 
	if( isset( $_POST['action'] ) && $_POST['action']=='executeLogin' ) {
		
		$user->authorize( $_POST['login_email'], $_POST['login_password'], $_POST['login_cookie'] );
		
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
	<input type="hidden" name="action" value="executeLogin" />
</form>