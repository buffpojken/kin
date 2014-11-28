<form role="form" id="post-update">
	<div class="form-group">
		<label for="statusUpdate">So ... what are you up to?</label>
		<textarea class="form-control" name="statusUpdate" id="statusUpdate" class="" rows="1"></textarea>
	</div>
	<button type="submit" class="btn btn-default">Post</button>
</form>

<ul id="updates">
<?php
$updates = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."updates ORDER BY timestamp DESC" );
foreach( $updates as $update ) { ?>
	<li class="update">
		<header class="update-header">
			<img src="/uploads/avatars/<?php echo $_SESSION['userID']; ?>-40x40.jpg" class="portrait" />
			<h4><?php $user->getUserData($update->userID,'name', TRUE); ?> <?php $user->getUserData($update->userID,'surname', TRUE); ?></h4>
			<p class="metadata">
			<?php
			date_default_timezone_set('Europe/Copenhagen');
			$date = new DateTime();
			$date->setTimestamp(strtotime($update->timestamp));
			$interval = $date->diff(new DateTime('now'));
			echo $interval->format('%y years, %m months, %d days, %h hours and %i minutes ago'); ?>
			</p>
		</header>
		<?php echo $update->message; ?>
		<footer class="update-footer">
			<p>
				<a href="#">Like</a> · 
				<a href="#">Comment</a>
			</p>
		</footer>
	</li>
<?php } ?>
</ul>