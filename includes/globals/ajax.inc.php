<?php
if( isset( $_SESSION['userID'] ) && isset( $_POST['action'] ) && isset( $_POST['ajax'] ) && $_POST['ajax']==1 ) {
	global $db;
	switch( $_POST['action'] ) {
		case 'postUpdate':
			$update = $db->escape( $_POST['statusUpdate'] );
			$latestUpdate = $db->escape( $_POST['latestUpdate'] );
			
			$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."updates(userID,message) VALUES('{$_SESSION['userID']}', '{$update}')");
			
			if( $updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE id > '{$latestUpdate}' ORDER BY id DESC" ) ) {
				foreach( $updates as $update ) {
					require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
				}
			}	
		break;
		case 'likeUpdate':
			$updateID = $db->escape( $_POST['updateID'] );
			$db->query("INSERT INTO ".DB_TABLE_PREFIX."likes(userID,updateID) VALUES('{$_SESSION['userID']}', '{$updateID}')");
		break;
		case 'unlikeUpdate':
			$updateID = $db->escape( $_POST['updateID'] );
			$db->query("DELETE FROM ".DB_TABLE_PREFIX."likes WHERE userID = '{$_SESSION['userID']}' AND updateID='{$updateID}'");
		break;
	}	
	exit;
}