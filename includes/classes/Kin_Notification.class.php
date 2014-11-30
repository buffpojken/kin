<?php
class Kin_Notification {
	
	public function createNotification( $recipientID, $message ) {
		global $db;
		$recipientID = $db->escape($recipientID);
		$message = $db->escape($message);
		$result = $db->query( "INSERT INTO ".DB_TABLE_PREFIX."notifications(recipientID,message) VALUES('{$recipientID}','{$message}')" );
		$db->debug();		
	}
	
	public function unreadNotificationCount( $recipientID ) {
		global $db;
		$recipientID = $db->escape($recipientID);
		$count = $db->get_var( "SELECT COUNT(id) FROM ".DB_TABLE_PREFIX."notifications WHERE recipientID ='{$recipientID}' AND isRead='0'" );
		return $count;
	}
	
	public function getLink( $recipientID, $notificationID ) {
		global $db;
		$recipientID = $db->escape($recipientID);
		$notificationID = $db->escape($notificationID);
		$link = $db->get_var( "SELECT link FROM ".DB_TABLE_PREFIX."notifications WHERE recipientID ='{$recipientID}' AND id='{$notificationID}'" );
		return $link;
	}	
}