<?php 
$messageUtility = new Kin_Private_Messages();
if( isset( $_GET['path_section'] ) ) {
	if( !is_numeric( $_GET['path_section'] )  ) {
		HEADER('Location: /messages/');
		exit;
	} elseif( is_numeric( $_GET['path_section'] ) && !$messageUtility->canCurrentUserReadThis($_SESSION['userID'], $_GET['path_section']) ) {
		HEADER('Location: /messages/');
		exit;
	} else { 
		$message = new Kin_Private_Messages( $_GET['path_section'] );
		$sender = new Kin_User( $message->senderID );
	?>
	<div class="page-header">
		<h1><?php echo $message->subject; ?></h1>
	</div>
	<p class="metadata">
		<a href="/messages/">Back to inbox</a> · 
		from <?php echo $sender->name . ' ' . $sender->surname; ?> · 
		received <?php $utility->timeSince($message->timestamp, TRUE); ?>
	</p>
	<table class="table">
		<tr>
			<td></td>
			<td><?php echo nl2br($message->message); ?></td>
		</tr>
		<?php 
		if( $repliesData = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."messages WHERE replyToID ='{$message->messageID}' AND id <> replyToID ORDER BY timestamp DESC" ) ) {
			foreach( $repliesData as $replyData ) {
				$replyMessage = new Kin_Private_Messages($replyData->id);
				$replySender = new Kin_User($replyMessage->senderID); ?>
		<tr>
			<td><a href="/profile/<?php echo $sender->username; ?>/"><?php echo $replySender->name . ' ' . $replySender->surname; ?></a><br /><?php $utility->timeSince($replyMessage->timestamp, TRUE); ?></td>
			<td><?php echo nl2br($replyMessage->message); ?></td>
		<tr>
			<?php }
		} ?>
	</table>
	<?php }
} else { ?>	
	<div class="page-header">
		<h1>Messages</h1>
	</div>
	<?php if( $messagesData = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."messages WHERE recipientID ='{$_SESSION['userID']}' GROUP BY replyToID ORDER BY timestamp DESC" ) ) { ?>
	<form role="form" method="post" action="">
		<table class="table table-condensed">
			<thead>
				<tr>
					<th></th>
					<th>Subject</th>
					<th>From</th>
					<th>When</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $messagesData as $messageData ) {
				$message = new Kin_Private_Messages($messageData->id);
				$sender = new Kin_User($message->senderID);
				echo '<tr>';
				echo '<td><input type="checkbox" name="notifications[]" value="'.$message->messageID.'" /></td>';
				echo '<td><a href="/messages/'.$message->messageID.'/">'.$message->subject.'</a></td>';
				echo '<td><a href="/profile/'.$sender->username.'/">' . $sender->name . ' ' . $sender->surname .'</a></td>';
				echo '<td>' . $utility->timeSince($message->timestamp, FALSE).'</td>';
				echo '<tr>';
			} ?>
			</tbody>
		</table>
		<button type="submit" class="btn btn-default btn-xs">Set marked as read</button>
		<input type="hidden" name="action" value="bulkEditMessages" />
	</form>
	<?php  } else {
		echo '<p class="text-center">You have no unread messages.</p>';
	}
} ?>