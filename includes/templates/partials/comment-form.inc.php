<form role="form" id="post-comment" method="post" action="">
	<div class="form-group">
		<div class="input-group">
			<input type="text" class="form-control" id="comment_message" name="comment_message" placeholder="Enter your comment here ...">
			<span class="input-group-btn">
				<button class="btn btn-success" type="submit">Post!</button>
			</span>
		</div>
	</div>
	<input type="hidden" name="action" value="postComment" />
	<input type="hidden" name="updateID" value="<?php echo $updateID; ?>" />
</form>