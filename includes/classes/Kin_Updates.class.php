<?php
class Kin_Update {
	
	public function hasCurrentUserLikedThis($updateID) {
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
	
}