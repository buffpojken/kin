<?php
if( isset( $_SESSION['userID'] ) && isset( $_REQUEST['action'] ) && isset( $_REQUEST['ajax'] ) && $_REQUEST['ajax']==1 ) {
	global $db;
	switch( $_REQUEST['action'] ) {
		case 'postComment':
			$comment = $db->escape( $hashtags->createHashtagLinks($_REQUEST['comment_message']) );
			$updateID = $db->escape( $_REQUEST['updateID'] );
			$latestComment = $db->escape( $_REQUEST['latestComment'] );
			$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."comments(userID,updateID,comment) VALUES('{$_SESSION['userID']}', '{$updateID}', '{$comment}')");
			if( $latestComment == 0 ) {
				$comments = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."comments WHERE updateID ='{$updateID}' ORDER BY id DESC LIMIT 1" );
			} else {
				$comments = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."comments WHERE updateID ='{$updateID}' AND id > '{$latestComment}' ORDER BY id DESC" );
			}
			if( $comments ) {
				foreach( $comments as $comment ) {
					require( TEMPLATE_PATH . '/partials/comments-loop.inc.php' );
				}
			}
		break;
		case 'postUpdate':
			$update = $db->escape( $hashtags->createHashtagLinks($_REQUEST['statusUpdate']) );
			$latestUpdate = $db->escape( $_REQUEST['latestUpdate'] );
			$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."updates(userID,message) VALUES('{$_SESSION['userID']}', '{$update}')");
			if( $latestUpdate == 0 ) {
				$updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates ORDER BY id DESC LIMIT 1" );
			} else {
				$updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE id > '{$latestUpdate}' ORDER BY id DESC" );
			}
			if( $updates ) {
				foreach( $updates as $update ) {
					require( TEMPLATE_PATH . '/partials/updates-loop.inc.php' );
				}
			}	
		break;
		case 'likeUpdate':
			$updateID = $db->escape( $_REQUEST['updateID'] );
			$db->query("INSERT INTO ".DB_TABLE_PREFIX."likes(userID,updateID) VALUES('{$_SESSION['userID']}', '{$updateID}')");
			$update = new Kin_Updates($updateID);
			$author = new Kin_User($update->userID);
			$notifications->createNotification( $update->userID, $user->name .' ' . $user->surname . ' has liked your post.' , '/profile/'.$author->username.'/updates/'.$updateID );
			unset($update);
			unset($author);
		break;
		case 'unlikeUpdate':
			$updateID = $db->escape( $_REQUEST['updateID'] );
			$db->query("DELETE FROM ".DB_TABLE_PREFIX."likes WHERE userID = '{$_SESSION['userID']}' AND updateID='{$updateID}'");
		break;
	}	
	exit;
}