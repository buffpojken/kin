<?php
if( isset( $_POST['action'] ) && isset( $_POST['ajax'] ) && $_POST['ajax']==1 ) {
	global $db;
	switch( $_POST['action'] ) {
	case 'postUpdate':
		$update = $db->escape( $_POST['statusUpdate'] );
		$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."updates(userID,message) VALUES('{$_SESSION['userID']}', '{$update}')");
		$db->debug();
	break;
	}	
	exit;
}