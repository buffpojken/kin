<?php
if( isset( $_SESSION['userID'] ) && isset( $_POST['action'] ) && isset( $_POST['ajax'] ) && $_POST['ajax']==1 ) {
	global $db;
	switch( $_POST['action'] ) {
		case 'postUpdate':
			$update = $db->escape( $_POST['statusUpdate'] );
			$latestUpdate = $db->escape( $_POST['latestUpdate'] );
			
			$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."updates(userID,message) VALUES('{$_SESSION['userID']}', '{$update}')");
			
			if( $updates = $db->get_results( "SELECT id FROM ".DB_TABLE_PREFIX."updates WHERE id > '{$latestUpdate}' ORDER BY id DESC" ) ) {
				foreach( $updates as $update ) {
					$data = new Kin_Updates($update->id);
					$author = new Kin_User($data->userID);
					?>
					<li class="update" data-update-id="<?php echo $data->id; ?>">
						<header class="update-header">
							<img src="/uploads/avatars/<?php echo $data->userID; ?>-40x40.jpg" class="portrait" />
							<h4><a href="/profile/<?php echo $author->username; ?>"><?php echo $author->name; ?> <?php echo $author->surname; ?></a></h4>
							<p class="metadata"><a href="/profile/<?php echo $author->username; ?>/updates/<?php echo $update->id; ?>">Just now</a></p>
						</header>
						<?php echo $data->message; ?><br />
						<footer class="update-footer">
							<p>
								<a href="#" class="likeUpdate" id="like-<?php echo $data->id; ?>" data-id="<?php echo $data->id; ?>"><?php if( $utility->hasCurrentUserLikedThis($data->updateID) ) { echo 'Unlike'; } else { echo 'Like'; } ?></a> · 
								<a href="/profile/<?php echo $author->username; ?>/updates/<?php echo $update->id; ?>">Comment</a>
								<span class="likes-description"><?php $data->likeDescriptionOutput($update->id); ?></span>
							</p>
						</footer>
					</li>
				<?php }
			}	
		break;
		case 'likeUpdate':
			$updateID = $db->escape( $_POST['updateID'] );
			$db->query("INSERT INTO ".DB_TABLE_PREFIX."likes(userID,updateID) VALUES('{$_SESSION['userID']}', '{$updateID}')");
		break;
		case 'unlikeUpdate':
			$updateID = $db->escape( $_POST['updateID'] );
			$db->query("DELETE FROM ".DB_TABLE_PREFIX."likes WHERE userID = '{$_SESSION['userID']}' AND updateID='{$updateID}'");
		break;
	}	
	exit;
}