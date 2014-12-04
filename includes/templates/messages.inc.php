<?php 
$messageUtility = new Kin_Private_Messages();
if( isset( $_GET['path_section'] ) ) {
	echo '<p><a href="/messages/" class="btn btn-default">Return to inbox</a></p><hr />';
	if( is_numeric( $_GET['path_section'] ) && $messageUtility->canCurrentUserReadThis($_SESSION['userID'], $_GET['path_section']) ) {
		$threadID = $db->escape($_GET['path_section']);
		if( $messagesIDs = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."pm_messages WHERE threadID ='{$threadID}' ORDER BY id ASC" ) ) {
			foreach( $messagesIDs as $messageID ) {
				$message = new Kin_Private_Messages( $messageID->id );
				$author = new Kin_User( $message->authorID );
				if( $_SESSION['userID'] != $message->authorID ) {
					$messageUtility->markMessageAsRead($message->threadID);
				}
				?>
				<div class="media">
					<a class="media-left" href="/profile/<?php echo $author->username; ?>/">
					<?php
					if( file_exists( UPLOADS_PATH . '/avatars/'.$author->userID.'-40x40.jpg' ) ) {
						echo '<img src="/uploads/avatars/'.$author->userID.'-40x40.jpg" class="portrait" />' . PHP_EOL;
					} else {
						$firstInitial = substr($author->name, 0, 1);
						$lastInitial = substr($author->surname, 0, 1);
						echo '<img src="http://placehold.it/40/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait" />' . PHP_EOL;
					} ?>
					</a>
					<div class="media-body">
					<h4 class="media-heading"><?php echo nl2br($message->subject); ?> <small>from <a href="/profile/<?php echo $author->username; ?>/"><?php echo $author->name . ' ' . $author->surname; ?></a><br /> <?php echo $utility->timeSince($message->timestamp); ?></small></h4>
						<p><?php echo nl2br($message->message); ?></p>
					</div>
				</div>
			<?php } ?>
			<hr />
		<?php } else {
			HEADER('Location: /messages/');
			exit;
		}
	?>
	<?php } else {
		HEADER('Location: /messages/');
		exit;
	}
} else { ?>	
	<div class="page-header">
		<h1>Messages</h1>
	</div>
	<?php if( isset( $_POST['action'] ) && $_POST['action']=='sendMessage' ) {
		if( $messageUtility->sendMessage( $_POST['message_recipient'], $_POST['message_subject'], $_POST['message_content'] ) ) {
			echo '<div class="alert alert-success" role="alert"><strong>Hooray!</strong> Your message was sent!</div>';
		} else {
			echo '<div class="alert alert-danger" role="alert"><strong>Boo!</strong> Your message wasn\'t sent!</div>';
		}
	} ?>
	<?php if( isset( $_POST['action'] ) && $_POST['action']=='bulkEditMessages' ) {
		foreach( $_POST['messages'] as $message ) {
			$messageUtility->moveMessagesToArchive($message);
		}
	}
	
	if( $threads = $db->get_results( "SELECT ".DB_TABLE_PREFIX."pm_threads.id, ".DB_TABLE_PREFIX."pm_threads.senderID, ".DB_TABLE_PREFIX."pm_threads.recipientID FROM ".DB_TABLE_PREFIX."pm_threads INNER JOIN ".DB_TABLE_PREFIX."pm_messages ON ".DB_TABLE_PREFIX."pm_threads.id = ".DB_TABLE_PREFIX."pm_messages.threadID WHERE ".DB_TABLE_PREFIX."pm_threads.senderID ='{$_SESSION['userID']}' OR ".DB_TABLE_PREFIX."pm_threads.recipientID ='{$_SESSION['userID']}' GROUP BY ".DB_TABLE_PREFIX."pm_messages.threadID ORDER BY ".DB_TABLE_PREFIX."pm_messages.id DESC" ) ) { ?>
	<form role="form" method="post" action="">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Subject</th>
					<th>From</th>
					<th>To</th>
					<th>When</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $threads as $thread ) {
				$message = $messageUtility->latestThreadReply($thread->id);
				$sender = new Kin_User($thread->senderID);
				$recipient = new Kin_User($thread->recipientID);
				echo '<tr>';
				if( $message->isRead == 1 && $thread->senderID != $_SESSION['userID'] ) {
					echo '<td><a href="/messages/'.$thread->id.'/">'.$message->subject.'</a></td>';
				} else {
					echo '<td><a href="/messages/'.$thread->id.'/"><strong>'.$message->subject.'</strong></a></td>';
				}
				echo '<td><a href="/profile/'.$sender->username.'/">' . $sender->name . ' ' . $sender->surname .'</a></td>';
				echo '<td><a href="/profile/'.$recipient->username.'/">' . $recipient->name . ' ' . $recipient->surname .'</a></td>';
				echo '<td>' . $utility->timeSince($message->timestamp, FALSE).'</td>';
				echo '<tr>';
			} ?>
			</tbody>
		</table>
		<!--<button type="submit" class="btn btn-default btn-sm">Move selected to archive</button>
		<input type="hidden" name="action" value="bulkEditMessages" />-->
	</form>
	<?php  } else {
		#$db->debug();
		echo '<p class="text-center">You have no messages.</p>';
	} ?>
<?php } ?>

<div class="modal fade" id="composeMessage" tabindex="-1" role="dialog" aria-labelledby="composeMessage" aria-hidden="true">
	<div class="modal-dialog">
		<form class="modal-content" method="post" action="">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Compose message</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="message_recipient">Please select the recipient</label>
					<select class="form-control chosen-select" name="message_recipient" id="message_recipient">
					<?php
					if( $recipients = $db->get_results("SELECT * FROM ".DB_TABLE_PREFIX."users WHERE hidden='0' ORDER BY name ASC") ) {
						foreach( $recipients as $recipient ) {
							echo '<option value="'.$recipient->id.'">'.$recipient->name.' '.$recipient->surname.'</option>';
						}
					} else {} ?>
					</select>
				</div>
				<div class="form-group">
					<label for="message_subject">Subject</label>
					<input type="text" class="form-control" name="message_subject" id="message_subject" placeholder="Write subject here ... " />
				</div>
				<div class="form-group">
					<label for="message_content">Message</label>
					<textarea class="form-control" name="message_content" id="message_content" rows="6"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Send message</button>
			</div>
			<input type="hidden" name="action" value="sendMessage" />
		</form>
	</div>
</div>