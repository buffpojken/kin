<?php
class Kin_Comments {
	
	var $commentID;
	var $updateID;
	var $userID;
	var $timestamp;
	var $comment;
	
	function __construct($commentIdentifier=FALSE) {
		if( $commentIdentifier ) {
			global $db;
			$commentIdentifier = $db->escape($commentIdentifier);
			$comment = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."comments WHERE id = '{$commentIdentifier}'");
			$this->commentID = $comment->id;
			$this->updateID = $comment->updateID;
			$this->userID = $comment->userID;
			$this->timestamp = $comment->timestamp;
			$this->comment = $comment->comment;
			return $this;
		}
	}
}