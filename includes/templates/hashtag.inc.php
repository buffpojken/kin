<?php if( !isset( $_GET['path_section'] ) ) {
	HEADER('Location: /');
	exit;
} ?>
<div class="page-header">
	<h1>#<?php echo $_GET['path_section']; ?></h1>
</div>


<?php if( $updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE message LIKE '%#{$_GET['path_section']}%' ORDER BY id DESC LIMIT 25" ) ) { ?>
	<p>There are <strong><?php echo count($updates); ?></strong> posts with the <strong>#<?php echo $_GET['path_section']; ?></strong> hashtag.</p>
	<ul id="updates">
	<?php foreach( $updates as $update ) {
		require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
	} ?>
	</ul>
<?php } else { ?>
	<p>There are <strong>0</strong> posts with the <strong>#<?php echo $_GET['path_section']; ?></strong> hashtag.</p>
<?php } ?>
