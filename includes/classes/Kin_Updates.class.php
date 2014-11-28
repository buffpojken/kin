<?php
class Kin_Updates {
	
	public function isThisLiked($userID, $updateID) {
		global $db;
		$userID = $db->escape($userID);
		$updateID = $db->escape($updateID);
		$result = $db->get_var("SELECT id FROM ".DB_TABLE_PREFIX."likes WHERE userID ='{$userID}' AND updateID ='{$updateID}'");
	}
	
}