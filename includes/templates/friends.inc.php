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
	if( $friendRequests = $db->get_results( "SELECT friendID FROM ".DB_TABLE_PREFIX."friendships WHERE friendID='{$_SESSION['userID']}' AND isConfirmed='0' AND isRejected='0'" ) ) {
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
	<?php
	if( isset( $_POST['action'] ) && $_POST['action']=='unfriend' ) {
		if( $friendships->destroyFriendship( $_POST['userID'] ) ) {
			echo '<div class="alert alert-success" role="alert"><strong>That did it!</strong> You are no longer friends with ' . $user->getUserData($_POST['userID'],'name', FALSE). ' ' .$user->getUserData($_POST['userID'],'surname', FALSE) . '. Don\'t regret it now.</div>';
		} else {
			echo '<div class="alert alert-danger" role="alert"><strong>Whoops!</strong> We couldn\'t revoke your friendship. Please try again.</div>';
		}
	} ?>
	<p>
		<ul class="nav nav-tabs nav-justified">
			<li role="presentation" class="active"><a href="/friends/">Friend List</a></li>
			<li role="presentation"><a href="/friends/requests/">Friend Requests</a></li>
		</ul>
	</p>
	<table class="table table-striped">
	<?php if( $friends = $user->returnFriendsUserIDs( $_SESSION['userID'] ) ) {
		foreach( $friends as $friend ) {
			$profile = new Kin_User($friend);
			?>
		<tr>
			<td width="5%">
			<?php
			if( file_exists( UPLOADS_PATH . '/avatars/'.$profile->userID.'-40x40.jpg' ) ) {
				echo '<a href="/profile/'.$profile->username.'"><img src="/uploads/avatars/'.$profile->userID.'-40x40.jpg" class="portrait" /></a>';
			} else {
				$firstInitial = substr($profile->name, 0, 1);
				$lastInitial = substr($profile->surname, 0, 1);
				echo '<a href="/profile/'.$profile->username.'"><img src="http://placehold.it/40/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait" /></a>';
			} ?>
			</td>
			<td><a href="/profile/<?php echo $profile->username; ?>"><strong><?php echo $profile->name . ' ' . $profile->surname; ?></strong></a></td>
			<td align="right">
				<form role="form" method="post" action="" class="text-right">
					<button type="submit" class="btn btn-xs btn-danger" name="action" value="unfriend">Unfriend</button>
					<input type="hidden" name="userID" value="<?php echo $friend; ?>" />
				</form>
			</td>
		</tr>
	<?php } ?>
	</table>
<?php } } ?>