<?php
session_start();
ob_start();
require_once('config.inc.php');
require_once( GLOBALS_PATH . '/header.inc.php' );

if( $_GET["action"] == "logout" ) {
	session_destroy();
	HEADER('Location: /');
}
?>
		
		<div id="site-body" class="container">
			<div class="row">
				<?php require_once( GLOBALS_PATH . '/sidebar.inc.php' ); ?>
				<div class="col-md-6">
				<?php if( isset ( $_SESSION["user"] ) ) {
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
			</div>
		</div>
		
	</body>
</html>
<?php ob_end_flush(); ?>