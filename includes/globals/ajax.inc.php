<?php
if( isset( $_SESSION['userID'] ) && isset( $_POST['action'] ) && isset( $_POST['ajax'] ) && $_POST['ajax']==1 ) {
	global $db;
	switch( $_POST['action'] ) {
	case 'postUpdate':
		$update = $db->escape( $_POST['statusUpdate'] );
		$latestUpdate = $db->escape( $_POST['latestUpdate'] );
		
		$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."updates(userID,message) VALUES('{$_SESSION['userID']}', '{$update}')");
		
		if( $updates = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."updates WHERE id > '{$latestUpdate}' ORDER BY id DESC" ) ) {
			foreach( $updates as $update ) {
				$output .= '<li class="update" data-update-id="' . $update->id . '">' . PHP_EOL;
				$output .= '<header class="update-header">' . PHP_EOL;
				$output .= '<img src="/uploads/avatars/' . $update->userID . '-40x40.jpg" class="portrait" />' . PHP_EOL;
				$output .= '<h4><a href="/profile/' . $user->getUserData($update->userID,'username') . '">' . $user->getUserData($update->userID,'name') . ' ' . $user->getUserData($update->userID,'surname') . '</a></h4>' . PHP_EOL;
				$output .= '<p class="metadata"><a href="/profile/' . $user->getUserData($update->userID,'username') . '/updates/' . $update->id . '">Just now</a></p>' . PHP_EOL;
				$output .= '</header>' . PHP_EOL;
				$output .= $update->message . PHP_EOL;
				$output .= '<footer class="update-footer">' . PHP_EOL;
				$output .= '<p><a href="#">Like</a> · <a href="#">Comment</a></p>' . PHP_EOL;
				$output .= '</footer>' . PHP_EOL;
				$output .= '</li>' . PHP_EOL;
				echo $output;
			}
		}
		
	break;
	}	
	exit;
}