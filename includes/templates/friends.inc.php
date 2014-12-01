<div class="page-header">
	<h1>Friends</h1>
</div>
<ul class="row" id="users">
<?php 
	if( $friends = $db->get_results( "(SELECT userID as profileID FROM ".DB_TABLE_PREFIX."friendships WHERE friendID ='".$_SESSION['userID']."') UNION (SELECT friendID as profileID FROM ".DB_TABLE_PREFIX."friendships WHERE userID ='".$_SESSION['userID']."')" ) ) {
	foreach( $friends as $friend ) {
		$profile = new Kin_User($friend->profileID);
		$output .= '<li class="user col-sm-4"><a href="/profile/'.$profile->username.'">' . PHP_EOL;
		$output .= '<img src="/uploads/avatars/'.$profile->userID.'-150x150.jpg" class="portrait" />' . PHP_EOL;
		$output .= '<h4>'.$profile->name . ' ' . $profile->surname . '</h4>' . PHP_EOL;
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