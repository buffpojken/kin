<?php
session_start();
ob_start();
require_once('config.inc.php');
require_once( GLOBALS_PATH . '/ajax.inc.php' );
require_once( GLOBALS_PATH . '/header.inc.php' );

if( $_GET["action"] == "logout" ) {
	session_destroy();
	HEADER('Location: /');
}
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