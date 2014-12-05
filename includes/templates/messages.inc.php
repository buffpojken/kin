	<div class="page-header">
		<h1>Messages</h1>
	</div>
	<div class="btn-group" role="group" aria-label="...">
	<?php if( isset( $_GET['path_section'] ) ) { ?>
		<a href="/messages/" class="btn btn-default">Back to inbox</a>
	<?php } ?>
		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#composeMessage">Compose message</button>
	</div>
	<hr />
<?php 
if( isset( $_POST['action'] ) && $_POST['action']=='sendMessage' ) {
	if( $messageUtility->sendMessage($_POST['message_recipient'],$_POST['message_subject'],$_POST['message_content']) ) {
		echo '<div class="alert alert-success" role="alert"><strong>Delightful!</strong> Your message is now on it\'s way to your friend. Rejoice!</div>';
	} else {
		echo '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> Something went wrong and your message wasn\'t sent. Please try again.</div>';
	}
}
$messageUtility = new Kin_Private_Messages();
if( isset( $_GET['path_section'] ) ) {
	if( !$messageUtility->canCurrentUserReadThis($_GET['path_section']) && !is_numeric($_GET['path_section']) ) {
		HEADER('Location: /');
		exit;
	} else {
		if( isset( $_POST['action'] ) && $_POST['action']=='sendMessageReply' ) {
			if( $messageUtility->sendReply($_POST['recipientID'],$_POST['reply_content'],$_POST['threadID'],$_POST['subject']) ) {
				echo '<div class="alert alert-success" role="alert"><strong>Delightful!</strong> Your message is now on it\'s way to your friend. Rejoice!</div>';
			} else {
				echo '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> Something went wrong and your reply wasn\'t sent. Please try again.</div>';
			}
		}
		$threadID = $db->escape($_GET['path_section']);
		if( $messageIDs = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."messages WHERE threadID = '{$threadID}' ORDER BY timestamp ASC" ) ) { ?>
	<ul class="media-list">
		<?php foreach( $messageIDs as $messageID ) {
			$message = new Kin_Private_Messages($messageID->id); 
			$author = new Kin_User($message->senderID); ?>
		<li class="media">
			<a class="media-left" href="#">
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
				<h4 class="media-heading"><?php echo $message->subject; ?></h4>
				<p><?php echo nl2br($message->message); ?></p>
			</div>
		</li>
		<?php } ?>
	</ul>
	<hr />
	<form class="form-horizontal" role="form" method="post" action="">
		<div class="form-group">
			<label for="reply_content" class="col-sm-2 control-label">Reply</label>
			<div class="col-sm-6">
				<textarea class="form-control" id="reply_content" name="reply_content" rows="5"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-6">
				<button type="submit" class="btn btn-default">Send your reply</button>
			</div>
		</div>
		<input type="hidden" name="action" value="sendMessageReply" />
		<input type="hidden" name="subject" value="<?php echo $message->subject; ?>" />
		<input type="hidden" name="threadID" value="<?php echo $_GET['path_section']; ?>" />
		<input type="hidden" name="recipientID" value="<?php echo $author->userID; ?>" />
	</form>
			
			
		<?php } else {
			HEADER('Location: /');
			exit;
		}
	}
} else { ?>	
	<?php
	if( $threads = $db->get_results( "SELECT threadID FROM ".DB_TABLE_PREFIX."messages WHERE recipientID='{$_SESSION['userID']}' AND senderID<>'{$_SESSION['userID']}' GROUP BY threadID ORDER BY id DESC" ) ) { ?>
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
			<?php foreach($threads as $thread) { 
				$message = $messageUtility->latestThreadReply($thread->threadID);
				$author = new Kin_User($message->senderID);
				$recipient = new Kin_User($message->recipientID);
			?>
				<tr>
					<td><a href="/messages/<?php echo $thread->threadID; ?>/"><?php echo $message->subject; ?></a></td>
					<td><?php echo $author->name . ' ' . $author->surname; ?></td>
					<td><?php echo $recipient->name . ' ' . $recipient->surname; ?></td>
					<td><?php echo $message->timestamp; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<!--<button type="submit" class="btn btn-default btn-sm">Move selected to archive</button>
		<input type="hidden" name="action" value="bulkEditMessages" />-->
	</form>
	<?php  } else {
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