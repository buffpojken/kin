<div class="page-header">
	<h1>Friends</h1>
</div>
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
		$output .= '<h5>'.$profile->name . ' ' . $profile->surname . '</h5>' . PHP_EOL;
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