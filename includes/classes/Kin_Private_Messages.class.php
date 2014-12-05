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
			$message = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."messages WHERE id = '{$messageIdentifier}'");
			$this->id = $message->id;
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
	
	function latestThreadReply($threadID) {
		global $db;
		$threadID = $db->escape($threadID);
		$message = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."messages WHERE threadID = '{$threadID}' ORDER BY id DESC LIMIT 1");
		$this->id = $message->id;
		$this->threadID = $message->threadID;
		$this->senderID = $message->senderID;
		$this->recipientID = $message->recipientID;
		$this->timestamp = $message->timestamp;
		$this->subject = $message->subject;
		$this->message = $message->message;
		$this->isRead = $message->isRead;
		return $this;
	}
	
	public function canCurrentUserReadThis($threadID) {
		global $db;
		$threadID = $db->escape($threadID);
		$result = $db->get_var( "SELECT COUNT(id) FROM ".DB_TABLE_PREFIX."messages WHERE threadID='{$threadID}' AND (senderID = '{$_SESSION['userID']}' OR recipientID = '{$_SESSION['userID']}')" );
		if( $result > 0 ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function markMessageAsRead( $threadID,$messageID ) {
		global $db;
		$messageID = $db->escape($messageID);
		$threadID = $db->escape($threadID);
		$db->query( "UPDATE ".DB_TABLE_PREFIX."messages SET isRead='1' WHERE threadID='{$threadID}'" );
	}
	
	public function sendMessage($recipientID,$subject,$message) {
		global $db;
		global $hashtags;
		$threadID = $db->get_var( "SELECT threadID FROM ".DB_TABLE_PREFIX."messages ORDER BY threadID DESC LIMIT 1" );
		$threadID = $threadID + 1;
		$senderID = $db->escape($_SESSION['userID']);
		$recipientID = $db->escape($recipientID);
		$subject = $db->escape($subject);
		$message = $hashtags->createHashtagLinks( $db->escape( $message ) );
		$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."messages(threadID,senderID,recipientID,subject,message) VALUES('{$threadID}','{$senderID}','{$recipientID}','{$subject}','{$message}')"); 
		if ( $result ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function sendReply($recipientID,$message,$threadID,$subject) {
		global $db;
		global $hashtags;
		$threadID = $db->escape( $threadID );
		$senderID = $db->escape( $_SESSION['userID'] );
		$recipientID = $db->escape( $recipientID );
		$subject = $db->escape( $subject );
		$message = $hashtags->createHashtagLinks( $db->escape( $message ) );
		$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."messages(threadID,senderID,recipientID,subject,message) VALUES('{$threadID}','{$senderID}','{$recipientID}','{$subject}','{$message}')"); 
		if ( $result ) {
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