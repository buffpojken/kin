<?php if( isset( $_GET['path_section'] ) && $_GET['path_section']=='requests' ) { ?>
	<div class="page-header">
		<h1>Friend Requests</h1>
	</div>
	<p>
		<ul class="nav nav-tabs nav-justified">
			<li role="presentation"><a href="/friends/">Friend List</a></li>
			<li role="presentation" class="active"><a href="/friends/requests/">Friend Requests</a></li>
		</ul>
	</p>
	<?php if( isset( $_POST['action'] ) && $_POST['action']=='acceptFriendship' ) {
		if( $friendships->acceptFriendship( $_POST['friendID'] ) ) {
			echo '<div class="alert alert-success" role="alert"><strong>Delightful!</strong> You accepted '.$user->getUserData($_POST['friendID'],'name', FALSE) .' '. $user->getUserData($_POST['friendID'],'surname', FALSE).'s friend request. Good for you!</div>';
		} else {
			echo '<div class="alert alert-danger" role="alert"><strong>Crap!</strong> Something bad happened and we couldn\'t finish your request. Please try again.</div>';
		}
	}
	if( isset( $_POST['action'] ) && $_POST['action']=='rejectFriendship' ) {
		if( $friendships->rejectFriendship( $_POST['friendID'] ) ) {
			echo '<div class="alert alert-success" role="alert"><strong>D\'awwww!</strong> You rejected '.$user->getUserData($_POST['friendID'],'name', FALSE) .' '. $user->getUserData($_POST['friendID'],'surname', FALSE).'s friend request.</div>';
		} else {
			echo '<div class="alert alert-danger" role="alert"><strong>Aw man!</strong> Something bad happened and we couldn\'t finish your request. Please try again.</div>';
		}
	} ?>
	<table class="table table-striped">
	<?php 
	if( $friendRequests = $db->get_results( "SELECT friendID FROM ".DB_TABLE_PREFIX."friendships WHERE userID='{$_SESSION['userID']}' AND isConfirmed='0' AND isRejected='0'" ) ) {
		foreach( $friendRequests as $friendRequest ) {
			$profile = new Kin_User($friendRequest->friendID);
			$firstInitial = substr($profile->name, 0, 1);
			$lastInitial = substr($profile->surname, 0, 1);
			$output .= '<tr>' . PHP_EOL;
			$output .= '<td>'.$profile->name . ' ' . $profile->surname . ' wants to be your friend.</td>' . PHP_EOL;
			$output .= '<td align="right"><form role="form" method="post" action=""><div class="btn-group btn-group-sm" role="group"><button type="submit" class="btn btn-sm btn-success" name="action" value="acceptFriendship">Accept</button><button type="submit" class="btn btn-sm btn-danger" name="action" value="rejectFriendship">Reject</button></div><input type="hidden" name="friendID" value="'.$friendRequest->friendID.'" /></form></td>';
			$output .= '</tr>' . PHP_EOL;
			unset($profile);
		}
		echo $output;
	} else { ?>
		<tr>
			<td class="text-center">No active friend requests found.</td>
		</tr>
	<?php } ?>
	</table>
<?php } else { ?>
	<div class="page-header">
		<h1>Friends</h1>
	</div>
	<p>
		<ul class="nav nav-tabs nav-justified">
			<li role="presentation" class="active"><a href="/friends/">Friend List</a></li>
			<li role="presentation"><a href="/friends/requests/">Friend Requests</a></li>
		</ul>
	</p>
	<ul class="row" id="users">
	<?php 
		if( $friends = $user->returnFriendsUserIDs( $_SESSION['userID'] ) ) {
		foreach( $friends as $friend ) {
			$profile = new Kin_User($friend);
			$firstInitial = substr($profile->name, 0, 1);
			$lastInitial = substr($profile->surname, 0, 1);
			$output .= '<li class="user col-sm-6"><a href="/profile/'.$profile->username.'">' . PHP_EOL;
			if( file_exists( UPLOADS_PATH . '/avatars/'.$profile->userID.'-40x40.jpg' ) ) {
				$output .= '<img src="/uploads/avatars/'.$profile->userID.'-40x40.jpg" class="portrait" />' . PHP_EOL;
			} else {
				$output .= '<img src="http://placehold.it/40/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait" />' . PHP_EOL;
			}
			$output .= '<strong>'.$profile->name . ' ' . $profile->surname . '</strong>' . PHP_EOL;
			$output .= '</a></li>' . PHP_EOL;
			unset($profile);
		}
		echo $output;
	} else { ?>
		<li class="col-sm-12">
			<p class="text-center">No active friends found. Bummer!</p>
		</li>
	<?php } ?>
	</ul>
<?php } ?>