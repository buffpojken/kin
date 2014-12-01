<form role="form" method="post" action="" id="post-update">
	<div class="form-group">
		<label for="statusUpdate">So ... what are you up to?</label>
		<textarea class="form-control" name="statusUpdate" id="statusUpdate" class="" rows="1"></textarea>
	</div>
	<button type="submit" class="btn btn-default btn-xs">Post</button>
	<input type="hidden" name="action" value="postUpdate" />
	<input type="hidden" name="ajax" value="1" />
</form>

<ul id="updates">
<?php
$updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates ORDER BY id DESC LIMIT 15" );
foreach( $updates as $update ) {
	require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
} ?>
</ul>