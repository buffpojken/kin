<div class="page-header">
	<h1>Messages</h1>
</div>
<?php if( $messagesData = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."messages WHERE recipientID ='{$_SESSION['userID']}' GROUP BY replyToID ORDER BY timestamp DESC" ) ) { ?>
<form role="form" method="post" action="">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th></th>
				<th>Subject</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $messagesData as $messageData ) {
			$sender = new Kin_User($messageData->senderID);
			echo '<tr>';
			echo '<td><input type="checkbox" name="notifications[]" value="'.$messageData->id.'" /></td>';
			echo '<td>';
			echo '<a href="/messages/'.$messageData->id.'">'.$messageData->subject.'</a><br />';
			echo $utility->timeSince($messageData->timestamp, FALSE).' from ' . $sender->name . ' ' . $sender->surname;
			echo '</td>';
			echo '<tr>';
		} ?>
		</tbody>
	</table>
	<button type="submit" class="btn btn-default btn-xs">Set marked as read</button>
	<input type="hidden" name="action" value="bulkEditMessages" />
</form>
<?php  } else {
	echo '<p class="text-center">You have no unread messages.</p>';
} ?>