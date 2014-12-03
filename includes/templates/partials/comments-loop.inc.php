<?php
$data = new Kin_Comments($comment->id);
$author = new Kin_User($data->userID);
?>	
<li class="comment" data-update-id="<?php echo $comment->id; ?>">
	<header class="comment-header">
		<?php
		if( file_exists( UPLOADS_PATH . '/avatars/'.$author->userID.'-40x40.jpg' ) ) {
			echo '<img src="/uploads/avatars/'.$author->userID.'-40x40.jpg" class="portrait" />' . PHP_EOL;
		} else {
			$firstInitial = substr($author->name, 0, 1);
			$lastInitial = substr($author->surname, 0, 1);
			echo '<img src="http://placehold.it/40/158cba/ffffff&text='.$firstInitial.'+'.$lastInitial.'" class="portrait" />' . PHP_EOL;
		} ?>
		<h4><a href="/profile/<?php echo $author->username; ?>"><?php echo $author->name; ?> <?php echo $author->surname; ?></a></h4>
		<p class="metadata"><?php echo $utility->timeSince($data->timestamp); ?></p>
	</header>
	<section class="comment-body">
		<?php echo nl2br($data->comment); ?>
	</section>
</li>