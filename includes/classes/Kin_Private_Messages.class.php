<?php
class Kin_Private_Messages {
	
	var $messageID;
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
			$message = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."messages WHERE id = '{$messageIdentifier}'");
			$this->messageID = $message->id;
			$this->threadID = $message->threadID;
			$this->senderID = $message->senderID;
			$this->recipientID = $message->recipientID;
			$this->timestamp = $message->timestamp;
			$this->subject = $message->subject;
			$this->message = $message->message;
			$this->isRead = $message->isRead;
			return $this;
		}
	}
	
	public function canCurrentUserReadThis($userID,$messageID) {
		global $db;
		$userID = $db->escape($userID);
		$messageID = $db->escape($messageID);
		$result = $db->get_var( "SELECT COUNT(id) FROM ".DB_TABLE_PREFIX."messages WHERE id='{$messageID}' AND (senderID = '{$userID}' OR recipientID = '{$userID}')" );
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
		$threadID = $db->get_var( "SELECT threadID FROM ".DB_TABLE_PREFIX."messages ORDER BY threadID DESC LIMIT 1" );
		$threadID = $threadID + 1;
		$senderID = $db->escape($_SESSION['userID']);
		$recipientID = $db->escape($recipientID);
		$subject = $db->escape($subject);
		$message = $db->escape($message);
		$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."messages(threadID,senderID,recipientID,subject,message) VALUES('{$threadID}','{$senderID}','{$recipientID}','{$subject}','{$message}')"); 
		if ( $result ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}