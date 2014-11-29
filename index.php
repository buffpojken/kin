<?php
session_start();
ob_start();
require_once('config.inc.php');
require_once( GLOBALS_PATH . '/ajax.inc.php' );
if( !isset( $_SESSION['userID'] ) && isset( $_COOKIE['kin_social_login'] ) ) {
	$userHash = $db->escape( $_COOKIE['kin_social_login'] );
	$userID = $db->get_var( "SELECT id FROM ".DB_TABLE_PREFIX."users WHERE userHash = '{$userHash}'" );
	if( is_numeric( $userID ) ) {
		$_SESSION['userID'] = $userID;
		setcookie ( 'kin_social_login', $_COOKIE['kin_social_login'], time() + 60 * 60 * 24 * 14 );
		HEADER('Location: /');
	}
}
if( isset( $_SESSION['userID'] ) ) {
	$user = new Kin_User( $_SESSION['userID'] );
}
if( $_GET['action'] == 'logout' ) {
	session_destroy();
	setcookie ( 'kin_social_login', '', time() - 60 * 60 * 24 * 14 );
	HEADER('Location: /');
}

require_once( GLOBALS_PATH . '/header.inc.php' );
?>
		
		<div id="site-body" class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-2">
				<?php if( isset ( $_SESSION["userID"] ) ) {
					if( isset( $_GET["path_page"] ) ) {
						if( file_exists( TEMPLATE_PATH . '/' . $_GET["path_page"] . '.inc.php' ) ) {
							require_once( TEMPLATE_PATH . '/' . $_GET["path_page"] . '.inc.php' );
						} else {
							require_once( TEMPLATE_PATH . '/404.inc.php' );
						}
					} else {
						require_once( TEMPLATE_PATH . '/wall.inc.php' );
					}
				} else {
					require_once( TEMPLATE_PATH . '/login.inc.php' );
				} ?>
				</div>
				<?php require_once( GLOBALS_PATH . '/sidebar.inc.php' ); ?>
			</div>
		</div>
		<!--<footer class="row" id="footer">
			<div class="col-sm-12">
				<p class="text-center">Lorem ipsum dolor sit amet.</p>
			</div>
		</footer>-->
	</body>
</html>
<?php ob_end_flush(); ?>