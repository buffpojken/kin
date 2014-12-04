<?php
class Kin_Private_Messages {
	
	var $id;
	var $threadID;
	var $senderID;
	var $recipientID;
	var $timestamp;
	var $subject;
	var $message;
	var $isRead;
	
	function __construct($messageIdentifier=FALSE) {
		if( $messageIdentifier ) {
			global $db;
			$messageIdentifier = $db->escape($messageIdentifier);
			$message = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."pm_messages WHERE id = '{$messageIdentifier}'");
			$this->id = $message->id;
			$this->threadID = $message->threadID;
			$this->authorID = $message->authorID;
			$this->timestamp = $message->timestamp;
			$this->subject = $message->subject;
			$this->message = $message->message;
			$this->isRead = $message->isRead;
			return $this;
		}
	}
	
	function latestThreadReply($threadID) {
		global $db;
		$threadID = $db->escape($threadID);
		$message = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."pm_messages WHERE threadID = '{$threadID}' ORDER BY id DESC LIMIT 1");
		$this->id = $message->id;
		$this->threadID = $message->threadID;
		$this->authorID = $message->authorID;
		$this->timestamp = $message->timestamp;
		$this->subject = $message->subject;
		$this->message = $message->message;
		$this->isRead = $message->isRead;
		return $this;
	}
	
	public function canCurrentUserReadThis($userID,$threadID) {
		global $db;
		$userID = $db->escape($userID);
		$threadID = $db->escape($threadID);
		$result = $db->get_var( "SELECT COUNT(id) FROM ".DB_TABLE_PREFIX."pm_threads WHERE id='{$threadID}' AND (senderID = '{$userID}' OR recipientID = '{$userID}')" );
		if( $result > 0 ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function markMessageAsRead( $messageID=FALSE ) {
		global $db;
		if( $messageID ) {
			$messageID = $db->escape($messageID);
		} else {
			$messageID = $this->messageID;
		}
		$db->query( "UPDATE ".DB_TABLE_PREFIX."messages SET isRead='1' WHERE id='{$messageID}'" );
	}
	
	public function sendMessage($recipientID,$subject,$message) {
		global $db;
		global $notifications;
		$threadID = $db->get_var( "SELECT threadID FROM ".DB_TABLE_PREFIX."messages ORDER BY threadID DESC LIMIT 1" );
		$threadID = $threadID + 1;
		$senderID = $db->escape($_SESSION['userID']);
		$recipientID = $db->escape($recipientID);
		$subject = $db->escape($subject);
		$message = $db->escape($message);
		$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."messages(threadID,senderID,recipientID,subject,message) VALUES('{$threadID}','{$senderID}','{$recipientID}','{$subject}','{$message}')"); 
		if ( $result ) {
			$author = new Kin_User($_SESSION['userID']);
			$notifications->createNotification( $recipientID, $author->name . ' ' . $author->surname . ' has sent you a private message.', '/messages/'. $db->insert_id );
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function sendReply($recipientID,$message,$threadID) {
		global $db;
		global $notifications;
		$threadID = $db->escape($threadID);
		$senderID = $db->escape($_SESSION['userID']);
		$recipientID = $db->escape($recipientID);
		$message = $db->escape($message);
		$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."messages(threadID,senderID,recipientID,message) VALUES('{$threadID}','{$senderID}','{$recipientID}','{$message}')"); 
		if ( $result ) {
			$author = new Kin_User($_SESSION['userID']);
			$notifications->createNotification( $recipientID, $author->name . ' ' . $author->surname . ' has sent you a private message.', '/messages/'. $db->insert_id );
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function unreadMessageCount( $recipientID ) {
		global $db;
		$recipientID = $db->escape($recipientID);
		$count = $db->get_var( "SELECT COUNT(id) FROM ".DB_TABLE_PREFIX."messages WHERE senderID <>'{$recipientID}' AND recipientID ='{$recipientID}' AND isRead='0' GROUP BY threadID" );
		return $count;
	}
}