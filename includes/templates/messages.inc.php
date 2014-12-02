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
		$message->markMessageAsRead();
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
	<table class="table table-striped">
		<tbody>
			<tr>
				<td></td>
				<td><?php echo nl2br($message->message); ?></td>
			</tr>
			<?php 
			if( $repliesData = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."messages WHERE threadID ='{$message->threadID}' AND id<>'{$message->messageID}' ORDER BY timestamp ASC" ) ) {
				foreach( $repliesData as $replyData ) {
					$replyMessage = new Kin_Private_Messages($replyData->id);
					$replySender = new Kin_User($replyMessage->senderID); ?>
			<tr>
				<td class="text-center" class="user-info">
					<a href="/profile/<?php echo $replySender->username; ?>/">
					<?php
					if( file_exists( UPLOADS_PATH . '/avatars/'.$replySender->userID.'-40x40.jpg' ) ) {
						echo '<img src="/uploads/avatars/'.$replySender->userID.'-40x40.jpg" class="portrait" /><br />' . PHP_EOL;
					} else {
						$firstInitial = substr($replySender->name, 0, 1);
						$lastInitial = substr($replySender->surname, 0, 1);
						echo '<img src="http://placehold.it/40/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait" /><br />' . PHP_EOL;
					} ?>
					<?php echo $replySender->name . ' ' . $replySender->surname; ?></a><br />
					<?php $utility->timeSince($replyMessage->timestamp, TRUE); ?>
				</td>
				<td><?php echo nl2br($replyMessage->message); ?></td>
			</tr>
				<?php }
			} ?>
		</tbody>
	</table>
	<?php }
} else { ?>	
	<div class="page-header">
		<h1>Messages</h1>
	</div>
	<?php if( isset( $_POST['action'] ) && $_POST['action']=='bulkEditMessages' ) {
		foreach( $_POST['messages'] as $message ) {
			$messageUtility->moveMessagesToArchive($message);
		}
	} ?>
	<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs nav-justified" role="tablist">
			<li role="presentation" class="active"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Inbox</a></li>
			<li role="presentation"><a href="#outbox" aria-controls="outbox" role="tab" data-toggle="tab">Outbox</a></li>
		</ul><br />
		
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="inbox">
				<?php if( $messagesData = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."messages WHERE senderID <>'{$_SESSION['userID']}' AND recipientID ='{$_SESSION['userID']}' GROUP BY threadID ORDER BY id DESC" ) ) { ?>
				<form role="form" method="post" action="">
					<table class="table table-hover">
						<thead>
							<tr>
								<!--<th></th>-->
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
							#echo '<td align="right"><input type="checkbox" name="messages[]" value="'.$message->messageID.'" /></td>';
							if( $message->isRead == 0 ) {
								echo '<td><a href="/messages/'.$message->messageID.'/"><strong>'.$message->subject.'</strong></a></td>';
							} else {
								echo '<td><a href="/messages/'.$message->messageID.'/">'.$message->subject.'</a></td>';
							}
							echo '<td><a href="/messages/'.$message->messageID.'/">'.$message->subject.'</a></td>';
							echo '<td><a href="/profile/'.$sender->username.'/">' . $sender->name . ' ' . $sender->surname .'</a></td>';
							echo '<td>' . $utility->timeSince($message->timestamp, FALSE).'</td>';
							echo '<tr>';
						} ?>
						</tbody>
					</table>
					<!--<button type="submit" class="btn btn-default btn-sm">Move selected to archive</button>
					<input type="hidden" name="action" value="bulkEditMessages" />-->
				</form>
				<?php  } else {
					echo '<p class="text-center">You have no messages.</p>';
				} ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="outbox">
				<?php if( $messagesData = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."messages WHERE senderID ='{$_SESSION['userID']}' AND recipientID <>'{$_SESSION['userID']}' GROUP BY threadID ORDER BY id DESC" ) ) { ?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Subject</th>
							<th>To</th>
							<th>When</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach( $messagesData as $messageData ) {
						$message = new Kin_Private_Messages($messageData->id);
						$recipient = new Kin_User($message->recipientID);
						echo '<tr>';
						echo '<td><a href="/messages/'.$message->messageID.'/">'.$message->subject.'</a></td>';
						echo '<td><a href="/profile/'.$recipient->username.'/">' . $recipient->name . ' ' . $recipient->surname .'</a></td>';
						echo '<td>' . $utility->timeSince($message->timestamp, FALSE).'</td>';
						echo '<tr>';
					} ?>
					</tbody>
				</table>
				<?php  } else {
					echo '<p class="text-center">You have not sent any messages messages.</p>';
				} ?>
			</div>
		</div>
	</div>
<?php } ?>