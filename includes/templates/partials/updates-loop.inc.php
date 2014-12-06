<?php
$data = new Kin_Updates($update->id);
$author = new Kin_User($data->userID);
?>	
<li class="update" data-update-id="<?php echo $update->id; ?>">
	<header class="update-header">
		<a href="#" class="subscription-management-link subscription-management-<?php echo $update->id ?>" data-update-id="<?php echo $update->id ?>">
			<?php if($utility->userSubscribesTo($data->updateID) ){ echo 'Unfollow'; } else {echo 'Follow'; } ?>
		</a>
		<?php
		if( file_exists( UPLOADS_PATH . '/avatars/'.$author->userID.'-40x40.jpg' ) ) {
			echo '<img src="/uploads/avatars/'.$author->userID.'-40x40.jpg" class="portrait" />' . PHP_EOL;
		} else {
			$firstInitial = substr($author->name, 0, 1);
			$lastInitial = substr($author->surname, 0, 1);
			echo '<img src="http://placehold.it/40/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait" />' . PHP_EOL;
		} ?>
		<h4><a href="/profile/<?php echo $author->username; ?>"><?php echo $author->name; ?> <?php echo $author->surname; ?></a></h4>
		<p class="metadata"><a href="/profile/<?php echo $author->username; ?>/updates/<?php echo $update->id; ?>"><?php echo $utility->timeSince($data->timestamp); ?></a></p>
	</header>
	<section class="update-body">
		<?php echo nl2br($data->message); ?>
	</section>
	<footer class="update-footer">
		<p>
			<a href="#" class="likeUpdate" id="like-<?php echo $update->id; ?>" data-id="<?php echo $update->id; ?>"><?php if( $utility->hasCurrentUserLikedThis($data->updateID) ) { echo 'Unlike'; } else { echo 'Like'; } ?></a> · 
			<?php $data->commentsLink( $update->id, $author->username ); ?>
			<span class="like-description"><?php $data->likeDescriptionOutput($update->id); ?></span>
		</p>
	</footer>
</li>