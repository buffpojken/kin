<?php 
class Kin_User {
	
	var $userID;
	var $name;
	var $surname;
	var $username;
	var $email;
	var $siteAdmin;
	
	function __construct($userIdentificer) {
		global $db;
		$userIdentifier = $db->escape($userIdentifier);
		if( is_numeric( $userIdentificer ) ) {
			$data = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."users WHERE id = '{$userIdentificer}'");
		} else {
			$data = $db->get_row("SELECT * FROM ".DB_TABLE_PREFIX."users WHERE username = '{$userIdentificer}'");
		}
		$this->userID = $data->id;
		$this->name = $data->name;
		$this->surname = $data->surname;
		$this->username = $data->username;
		$this->email = $data->email;
		$this->siteAdmin = $data->siteAdmin;
		return $this;
	}
	
	public function authorize($email, $password, $cookie) {
		
		global $db;
		$email = $db->escape($email);
		$hashedPassword = sha1( $password . ENCRYPTION_SALT );
		
		$userID = $db->get_var( "SELECT id FROM ".DB_TABLE_PREFIX."users WHERE email = '{$email}' AND passwordResetHash = '0'" );
		$db->debug();
		if( !is_numeric( $userID ) ) {
			$errors['db_info'] = "We were unable to find any user with that combination of email and password. Please try again.";
		}
		if( empty( $email ) || !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$errors['invalid_email'] = "You haven't entered a valid email address.";
		}
		if( empty( $password ) ) {
			$errors['empty_password'] = "You must enter a password.";
		}
		
		if( $this->getUserData( $userID, 'password' ) == $hashedPassword ) {
			$_SESSION['userID'] = $userID;
			HEADER('Location: /');
		} else {
			$errors['db_info'] = "We were unable to find any user with that combination of email and password. Please try again.";
		}
		if( count( $errors ) > 0 ) {
			echo '<div class="alert alert-danger" role="alert">';
			echo '<strong>Oh snap!</strong><br /><ul>';
			foreach( $errors as $error ) {
				echo '<li>'.$error.'</li>';
			}
			echo '</ul></div>';
		}
		if( $cookie == 'yes' ) {
			setcookie ( 'kin_social_login', $this->getUserData($userID,'userHash'), time() + 60 * 60 * 24 * 14 );
		}
	}
	
	public function updatePassword( $currentPassword, $newPassword, $newPasswordRepeated ) {
		global $db;
		$storedPassword = $this->getUserData( $_SESSION['userID'] ,'password' );
		if( $storedPassword != sha1( $currentPassword . ENCRYPTION_SALT ) ) {
			$errors['invalid_current_password'] = "Your current password is wrong. Please try again.";
		} else {
			if( strlen( $newPassword ) < 5  || strlen( $newPasswordRepeated ) < 5 ) {
				$errors['new_password_too_short'] = "The new password you've chosen is too short. It should be at least 5 characters long. Please try again.";
			} else {
				if( $newPassword != $newPasswordRepeated ) {
					$errors['new_passwords_dont_match'] = "You must enter your new password in exactly the same way in both fields. Please try again.";
				} else {
					$hashNewPassword = sha1( $newPassword . ENCRYPTION_SALT );
					$result = $db->query( "UPDATE ".DB_TABLE_PREFIX."users SET password='{$hashNewPassword}' WHERE id= '{$_SESSION['userID']}'" );
					$messages['password_updated'] = "Congratulations. Your password has been updated.";
				}
			}
		}
		if( count( $errors ) > 0 ) {
			echo '<div class="alert alert-danger" role="alert">';
			echo '<strong>Oh snap!</strong><br /><ul>';
			foreach( $errors as $error ) {
				echo '<li>'.$error.'</li>';
			}
			echo '</ul></div>';
		}
		if( count( $messages ) > 0 ) {
			echo '<div class="alert alert-success" role="alert">';
			echo '<strong>Success!</strong><br /><ul>';
			foreach( $messages as $message ) {
				echo '<li>'.$message.'</li>';
			}
			echo '</ul></div>';
		}
	}
	
	public function updateProfile( $data, $portrait ) {
		global $db;
		if( isset( $data['profile_name'] ) ) {
			$data['profile_name'] = $db->escape($data['profile_name']);
			$result = $db->query( "UPDATE ".DB_TABLE_PREFIX."users SET name='{$data['profile_name']}' WHERE id= '{$_SESSION['userID']}'" );
			if( $result != 0 ) {
				$errors['profile_name'] = "We were unable to update your name. Please try again.";
			}
		}
		if( isset( $data['profile_surname'] ) ) {
			$data['profile_surname'] = $db->escape($data['profile_surname']);
			$result = $db->query( "UPDATE ".DB_TABLE_PREFIX."users SET surname='{$data['profile_surname']}' WHERE id= '{$_SESSION['userID']}'" );
			if( $result != 0 ) {
				$errors['profile_surname'] = "We were unable to update your surname. Please try again.";
			}
		}
		if( isset( $data['profile_email'] ) ) {
			$data['profile_email'] = $db->escape($data['profile_email']);
			$result = $db->query( "UPDATE ".DB_TABLE_PREFIX."users SET email='{$data['profile_email']}' WHERE id= '{$_SESSION['userID']}'" );
			if( $result != 0 ) {
				$errors['profile_email'] = "We were unable to update your email address. Please try again.";
			}
		}
		if( isset( $portrait ) && $portrait['error'] != 4 ) {
			require_once(LIBRARY_PATH."/upload/class.upload.php");
			$upload = new Upload($portrait);
			#echo '<pre>'.print_r($upload, true).'</pre>';
			if ($upload->uploaded) {
				if( file_exists( UPLOADS_PATH . '/avatars/'.$_SESSION['userID'].'.jpg' ) ) {
					unlink(UPLOADS_PATH . '/avatars/'.$_SESSION['userID'].'.jpg');
				}
				$upload->file_new_name_body = $_SESSION['userID'];
				$upload->image_convert         = 'jpg';
				$upload->Process(UPLOADS_PATH . '/avatars/');
				if( !$upload->processed) {
					$errors['portrait_original'] = $upload->error;
				}
				
				if( file_exists( UPLOADS_PATH . '/avatars/'.$_SESSION['userID'].'-40x40.jpg' ) ) {
					unlink(UPLOADS_PATH . '/avatars/'.$_SESSION['userID'].'-40x40.jpg');
				}
				$upload->file_new_name_body = $_SESSION['userID'].'-40x40';
				$upload->image_resize          = true;
				$upload->image_ratio_crop      = true;
				$upload->image_convert         = 'jpg';
				$upload->image_y               = 40;
				$upload->image_x               = 40;
				$upload->Process(UPLOADS_PATH . '/avatars/');
				if( !$upload->processed) {
					$errors['portrait_mini'] = $upload->error;
				}
				
				if( file_exists( UPLOADS_PATH . '/avatars/'.$_SESSION['userID'].'-150x150.jpg' ) ) {
					unlink(UPLOADS_PATH . '/avatars/'.$_SESSION['userID'].'-150x150.jpg');
				}
				$upload->file_new_name_body = $_SESSION['userID'].'-150x150';
				$upload->image_resize          = true;
				$upload->image_ratio_crop      = true;
				$upload->image_convert         = 'jpg';
				$upload->image_y               = 150;
				$upload->image_x               = 150;
				$upload->Process(UPLOADS_PATH . '/avatars/');
				if( !$upload->processed) {
					$errors['portrait_sidebar'] = $upload->error;
				}
				$upload->Clean();
			}
		}
		if( count( $errors ) > 0 ) {
			echo '<div class="alert alert-danger" role="alert">';
			echo '<strong>Oh snap!</strong><br /><ul>';
			foreach( $errors as $error ) {
				echo '<li>'.$error.'</li>';
			}
			echo '</ul></div>';
		} else {
			echo '<div class="alert alert-success" role="alert">';
			echo '<strong>Success!</strong><br />Everything has been updated! Have fun!</div>';
		}
	}
	
	public function getUserData( $uid, $column, $echo = FALSE ) {
		global $db;
		$uid = $db->escape( $uid );
		$column = $db->escape( $column );
		$userData = $db->get_var( "SELECT {$column} FROM ".DB_TABLE_PREFIX."users WHERE id = '{$uid}'" );
		if( $echo ) {
			echo $userData;
		} else {
			return $userData;
		}
	}
	
	public function profileExists($username) {
		global $db;
		$username = $db->escape($username);
		$result = $db->get_var("SELECT id FROM ".DB_TABLE_PREFIX."users WHERE username = '{$username}'");
		if( $result ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function isCurrentUserFriendsWithThisProfile($profileID) {
		global $db;
		$profileID = $db->escape($profileID);
		$result = $db->get_var( "SELECT id FROM ".DB_TABLE_PREFIX."friendships WHERE userID = '{$_SESSION['userID']}' AND friendID = '{$profileID}'" );
		if( count($result)==0 ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

}