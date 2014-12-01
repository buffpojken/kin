<?php
class Kin_Updates {
	
	var $updateID;
	var $userID;
	var $timestamp;
	var $message;
	var $likeCount;
	var $commentCount;
	
	function __construct($updateIdentifier) {
		global $db;
		$updateIdentifier = $db->escape($updateIdentifier);
		$data = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."updates WHERE id = '{$updateIdentifier}'");
		$likeCount = $db->get_var("SELECT COUNT(id) as cnt FROM ".DB_TABLE_PREFIX."likes WHERE updateID = '{$data->id}'");
		$commentCount = $db->get_var("SELECT COUNT(id) as cnt FROM ".DB_TABLE_PREFIX."comments WHERE updateID = '{$data->id}'");
		$this->updateID = $data->id;
		$this->userID = $data->userID;
		$this->timestamp = $data->timestamp;
		$this->message = $data->message;
		$this->likeCount = $data->likeCount;
		$this->commentCount = $data->commentCount;
		return $this;
	}
	
	public function hasCurrentUserLikedThis( $updateID ) {
		global $db;
		$userID = $db->escape($_SESSION['userID']);
		$updateID = $db->escape($updateID);
		$result = $db->get_var("SELECT id FROM ".DB_TABLE_PREFIX."likes WHERE userID ='{$userID}' AND updateID ='{$updateID}'");
		if( is_numeric( $result ) ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function returnUpdateData( $updateID, $column, $echo = FALSE ) {
		global $db;
		$uid = $db->escape( $uid );
		$column = $db->escape( $column );
		$updateData = $db->get_var( "SELECT {$column} FROM ".DB_TABLE_PREFIX."updates WHERE id = '{$uid}'" );
		if( $echo ) {
			echo $updateData;
		} else {
			return $updateData;
		}
	}
	
	public function likeDescriptionOutput( $updateID ) {
		global $db;
		$updateID = $db->escape( $updateID );
		$likes = $db->get_col( "SELECT userID FROM ".DB_TABLE_PREFIX."likes WHERE updateID = '{$updateID}'" );
		$likeCount = count($likes);
		$output .= ' · ';
		if( $likeCount == 1 ) {
			if( in_array( $_SESSION['userID'], $likes ) ) {
				$output .= 'You like this';
			} else {
				$output .= '1 person likes this.';
			}
			echo $output;
		} elseif( $likeCount > 1 ) {
			if( in_array( $_SESSION['userID'], $likes ) ) {
				$output .= 'You and ' . $likeCount - 1 . ' others like this';
			} else {
				$output .= $likeCount . ' person likes this.';
			}
			echo $output;
		}
	}
	
}