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

<h3>Unread</h3>
<?php if( $notificationsData = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."notifications WHERE recipientID ='{$_SESSION['userID']}' AND isRead='0'" ) ) { ?>
<form role="form">
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
			echo '<td><input type="checkbox" name="notification[]" value="'.$notificationData->id.'" /></td>';
			echo '<td><span class="label label-default">'.$notificationData->timestamp.'</span></td>';
			echo '<td><a href="/notifications/redirect/'.$notificationData->id.'">'.$notificationData->message.'</a></td>';
			echo '<tr>';
		} ?>
		</tbody>
	</table>
	<button type="button" class="btn btn-default btn-xs">Set marked as read</button>
</form>
<?php } else {
	echo '<p class="text-center">You have no unread notifications.</p>';
} ?>

<hr />

<h3>Read</h3>
<?php if( $notificationsData = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."notifications WHERE recipientID ='{$_SESSION['userID']}' AND isRead='1'" ) ) { ?>
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
		echo '<td><input type="checkbox" name="notification[]" value="'.$notificationData->id.'" /></td>';
		echo '<td><span class="label label-default">'.$notificationData->timestamp.'</span></td>';
		echo '<td>'.$notificationData->message.'</td>';
		echo '<tr>';
	} ?>
	</tbody>
</table>
<?php } else {
	echo '<p class="text-center">You have no unread notifications.</p>';
} ?>
