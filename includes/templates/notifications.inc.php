<?php 
if( isset( $_GET['path_section'] ) && $_GET['path_section']=='redirect' ) {
	if( is_numeric( $_GET['path_item'] ) ) {
		$link = $notifications->getLink( $_SESSION['userID'], $_GET['path_item'] );
		$notifications->markNotificationAsRead($_GET['path_item']);
		HEADER('Location: ' . $link);
		exit;
	} else {
		HEADER('Location: /notifications');
		exit;
	}
}
?>
<div class="page-header">
	<h1>Notifications</h1>
</div>
<?php if( isset( $_POST['action'] ) && $_POST['action']=='bulkEditNotifications' ) {
	foreach( $_POST['notifications'] as $notification ) {
		$notifications->markNotificationAsRead($notification);
	}
} ?>
<h3>Unread</h3>
<?php if( $notificationsData = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."notifications WHERE recipientID ='{$_SESSION['userID']}' AND isRead='0' ORDER BY timestamp ASC" ) ) { ?>
<form role="form" method="post" action="">
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th></th>
				<th>When</th>
				<th>Message</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $notificationsData as $notificationData ) {
			echo '<tr>';
			echo '<td><input type="checkbox" name="notifications[]" value="'.$notificationData->id.'" /></td>';
			echo '<td><span class="label label-default">'.$utility->timeSince($notificationData->timestamp, FALSE).'</span></td>';
			echo '<td><a href="/notifications/redirect/'.$notificationData->id.'">'.$notificationData->message.'</a></td>';
			echo '<tr>';
		} ?>
		</tbody>
	</table>
	<button type="submit" class="btn btn-default btn-xs">Set marked as read</button>
	<input type="hidden" name="action" value="bulkEditNotifications" />
</form>
<?php } else {
	echo '<p class="text-center">You have no unread notifications.</p>';
} ?>

<hr />

<h3>Read</h3>
<?php if( $notificationsData = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."notifications WHERE recipientID ='{$_SESSION['userID']}' AND isRead='1' ORDER BY timestamp DESC" ) ) { ?>
<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>When</th>
			<th>Message</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $notificationsData as $notificationData ) {
		echo '<tr>';
		echo '<td><span class="label label-default">'.$utility->timeSince($notificationData->timestamp, FALSE).'</span></td>';
		echo '<td><a href="/notifications/redirect/'.$notificationData->id.'">'.$notificationData->message.'</a></td>';
		echo '<tr>';
	} ?>
	</tbody>
</table>
<?php } else {
	echo '<p class="text-center">You have no read notifications.</p>';
} ?>
