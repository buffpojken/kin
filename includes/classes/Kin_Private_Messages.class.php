<?php
class Kin_Private_Messages {
	
	var $messageID;
	var $replyToID;
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
			$this->replyToID = $message->replyToID;
			$this->senderID = $message->senderID;
			$this->recipientID = $message->recipientID;
			$this->timestamp = $message->timestamp;
			$this->subject = $message->subject;
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
	
}