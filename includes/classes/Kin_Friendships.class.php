<?php
class Kin_Friendships {
	
	public function areWeFriends( $userID ) {
		global $db;
		$userID = $db->escape( $userID );
		$result = $db->get_var( "SELECT isConfirmed FROM ".DB_TABLE_PREFIX."friendships 
								 WHERE (userID='{$_SESSION['userID']}' AND friendID='{$userID}') 
								 OR (userID='{$userID}' AND friendID='{$_SESSION['userID']}') AND isConfirmed='1'" );
		if( $result ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function destroyFriendship( $friendID ) {
		if( $this->areWeFriends($friendID) ) {
			global $db;
			$friendID = $db->escape( $friendID );
			$result = $db->query( "DELETE FROM ".DB_TABLE_PREFIX."friendships WHERE (userID ='{$_SESSION['userID']}' AND friendID ='{$friendID}') OR (userID ='{$friendID}' AND friendID ='{$_SESSION['userID']}')" );
			if( $result ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	public function requestFriendship( $userID ) {
		if( !$this->areWeFriends($userID) ) {
			global $db;
			global $notifications;
			global $user;
			$userID = $db->escape( $userID );
			$result = $db->query( "INSERT INTO ".DB_TABLE_PREFIX."friendships(userID, friendID) VALUES('{$_SESSION['userID']}','{$userID}')" );
			if( $result ) {
				$notifications->createNotification( 
					$userID, 
					$user->getUserData($_SESSION["userID"],'name', FALSE).' '.$user->getUserData($_SESSION["userID"],'surname', FALSE) . ' has requested the honour of your friendship.',
					'/friends/requests/' 
				);
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	public function acceptFriendship( $friendID ) {
		global $db;
		global $notifications;
		$friendID = $db->escape( $friendID );
		$result = $db->query( "UPDATE ".DB_TABLE_PREFIX."friendships SET isConfirmed='1' WHERE userID='{$friendID}' AND friendID='{$_SESSION['userID']}'" );
		if( $result ) {
			$notifications->createNotification( 
					$userID, 
					$user->getUserData($friendID,'name', FALSE).' '.$user->getUserData($friendID,'surname', FALSE) . ' has approved your friend request. Yay.',
					'/profile/'.$user->getUserData($friendID,'username', FALSE).'/' 
				);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function rejectFriendship( $friendID ) {
		global $db;
		$friendID = $db->escape( $friendID );
		$result = $db->query( "UPDATE ".DB_TABLE_PREFIX."friendships SET isRejected='1' WHERE userID='{$friendID}' AND friendID='{$_SESSION['userID']}'" );
		#$db->debug();
		if( $result ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}