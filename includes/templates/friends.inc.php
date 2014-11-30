<div class="page-header">
	<h1>Friends</h1>
</div>
<ul class="row" id="users">
<?php 
if( $friendIDs = $db->get_col( "SELECT friendID FROM ".DB_TABLE_PREFIX."friendships WHERE userID = '{$_SESSION['userID']}'" ) ) {
	foreach( $friendIDs as $friendID ) {
		$friend = new Kin_User($friendID);
		$output .= '<li class="user col-sm-4"><a href="/profile/'.$friend->username.'">' . PHP_EOL;
		$output .= '<img src="/uploads/avatars/'.$friend->userID.'-150x150.jpg" class="portrait" />' . PHP_EOL;
		$output .= '<h4>'.$friend->name . ' ' . $friend->surname . '</h4>' . PHP_EOL;
		$output .= '</a></li>' . PHP_EOL;
	}
	echo $output;
} else { ?>
	<li class="col-sm-12">
		<p class="text-center">No active friends found. Bummer!</p>
	</li>
<?php } ?>
</ul>