<div class="page-header">
	<h1>Friends</h1>
</div>
<ul class="row" id="users">
<?php 
if( $friendsIDs = $db->get_results( "SELECT friendID FROM ".DB_TABLE_PREFIX."friendships", ARRAY_N ) ) {
	$friendIDs = implode(",", $friendsIDs);
	if( $users = $db->get_results( "SELECT * FROM ".DB_TABLE_PREFIX."users WHERE id IN ({$friendIDs}) ORDER BY name ASC" ) ) {
		foreach($users as $user) { ?>
		<li class="col-sm-6 user">
			<img src="/uploads/avatars/<?php echo $_SESSION['userID']; ?>-150x150.jpg" class="portrait" />
			<h4><a href="/profile/<?php echo $user->username; ?>"><?php echo $user->name; ?> <?php echo $user->surname; ?></a></h4>
		</li>
		<?php }
	} 
} else { ?>
	<li class="col-sm-12">
		<p class="text-center">No active friends found. Bummer!</p>
	</li>
<?php } ?>
</ul>