<form role="form" method="post" action="" id="post-update">
	<div class="form-group">
		<label for="statusUpdate">So ... what are you up to?</label>
		<textarea class="form-control" name="statusUpdate" id="statusUpdate" class="" rows="1"></textarea>
	</div>
	<button type="submit" class="btn btn-default btn-xs">Post</button>
	<input type="hidden" name="action" value="postUpdate" />
	<input type="hidden" name="ajax" value="1" />
</form>

<div role="tabpanel">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-justified" role="tablist">
		<li role="presentation" class="active"><a href="#friends" aria-controls="friends" role="tab" data-toggle="tab">Friends</a></li>
		<li role="presentation"><a href="#everyone" aria-controls="everyone" role="tab" data-toggle="tab">Everone</a></li>
	</ul><br />
	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="friends">
			<ul class="updates">
			<?php
			$friendIDs = implode(",", $user->returnFriendsUserIDs( $_SESSION['userID'] ));
			$updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE userID IN ($friendIDs) ORDER BY id DESC LIMIT 15" );
			foreach( $updates as $update ) {
				require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
			} ?>
			</ul>
		</div>
		<div role="tabpanel" class="tab-pane" id="everyone">
			<ul class="updates">
			<?php
			$updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates ORDER BY id DESC LIMIT 15" );
			foreach( $updates as $update ) {
				require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
			} ?>
			</ul>
		</div>
	</div>
</div>