<?php
$data = new Kin_Updates($update->id);
$author = new Kin_User($data->userID);
?>	
<li class="update" data-update-id="<?php echo $update->id; ?>">
	<header class="update-header">
		<img src="/uploads/avatars/<?php echo $data->userID; ?>-40x40.jpg" class="portrait" />
		<h4><a href="/profile/<?php echo $author->username; ?>"><?php echo $author->name; ?> <?php echo $author->surname; ?></a></h4>
		<p class="metadata"><a href="/profile/<?php echo $author->username; ?>/updates/<?php echo $update->id; ?>"><?php echo $utility->timeSince($data->timestamp); ?></a></p>
	</header>
	<?php echo $data->message; ?><br />
	<footer class="update-footer">
		<p>
			<a href="#" class="likeUpdate" id="like-<?php echo $update->id; ?>" data-id="<?php echo $update->id; ?>"><?php if( $utility->hasCurrentUserLikedThis($data->updateID) ) { echo 'Unlike'; } else { echo 'Like'; } ?></a> · 
			<a href="/profile/<?php echo $author->username; ?>/updates/<?php echo $update->id; ?>">Comment</a>
			<span class="like-description"><?php $data->likeDescriptionOutput($update->id); ?></span>
		</p>
	</footer>
</li>