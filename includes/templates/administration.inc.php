<?php if( $user->getUserData($_SESSION["userID"],'siteAdmin') != 1 ) {
	HEADER('Location: /');
	exit();
} ?>
<div class="page-header">
	<h1>Administration</h1>
</div>
<?php if( isset( $_POST['action'] ) && $_POST['action']=='importUsers' ) {
	$fileContent = file_get_contents($_FILES['import_users_csv']['tmp_name']);
	$xml = simplexml_load_string($fileContent);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
	foreach($array['custom']['row'] as $friendship) {
		$i = 0;
		$id = $db->escape( $friendship['id'] );
		$initiator= $db->escape( $friendship['initiator_user_id'] );
		$friend = $db->escape( $friendship['friend_user_id'] );
		$confirmed = $db->escape( $friendship['is_confirmed'] );
		$timestamp = $db->escape( $friendship['date_created'] );
		if( $db->query( "INSERT INTO ".DB_TABLE_PREFIX."friendships(id,userID,friendID,isConfirmed,timeCreated) VALUES('{$id}','{$initiator}','{$friend}','{$confirmed}','{$timestamp}')" ) ) {
			$i++;
		}
		#$db->debug();
	}
	if( $i > 0 ) {
		echo '<p class="text-success">'.$i.' friendships successfully imported.</p>';
	}
} ?>
<form role="form" method="post" action="" enctype="multipart/form-data">
	<legend>Import data</legend>
	<div class="form-group">
		<label for="import_users_csv" class="col-sm-3 control-label">Upload CSV</label>
		<div class="col-sm-9">
			<input type="file" class="form-control" id="import_users_csv" name="import_users_csv" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" class="btn btn-default">Import</button>
		</div>
	</div>
	<input type="hidden" name="action" value="importUsers" />
</form>