<form role="form" method="post" action="" id="post-update">
	<div class="form-group">
		<label for="statusUpdate">So ... what are you up to?</label>
		<textarea class="form-control" name="statusUpdate" id="statusUpdate" class="" rows="1"></textarea>
	</div>
	<button type="submit" class="btn btn-default">Post</button>
	<input type="hidden" name="action" value="postUpdate" />
	<input type="hidden" name="ajax" value="1" />
</form>

<ul id="updates">
<?php
$updates = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."updates ORDER BY id DESC LIMIT 15" );
foreach( $updates as $update ) {
	#$update = new Kin_Update;
?>
	<li class="update" data-update-id="<?php echo $update->id; ?>">
		<header class="update-header">
			<img src="/uploads/avatars/<?php echo $_SESSION['userID']; ?>-40x40.jpg" class="portrait" />
			<h4><a href="/profile/<?php $user->getUserData($update->userID,'username', TRUE); ?>"><?php $user->getUserData($update->userID,'name', TRUE); ?> <?php $user->getUserData($update->userID,'surname', TRUE); ?></a></h4>
			<p class="metadata"><a href="/profile/<?php $user->getUserData($update->userID,'username', TRUE); ?>/updates/<?php echo $update->id; ?>"><?php echo $utility->timeSince($update->timestamp); ?></a></p>
		</header>
		<?php echo $update->message; ?>
		<footer class="update-footer">
			<p>
				<a href="#" class="likeUpdate" id="like-<?php echo $update->id; ?>" data-id="<?php echo $update->id; ?>">Like</a> · 
				<a href="#">Comment</a>
				<span class="likes-wrapper"></span>
			</p>
		</footer>
	</li>
<?php } ?>
</ul>