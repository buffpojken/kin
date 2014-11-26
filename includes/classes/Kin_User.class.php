<?php 
class Kin_User {
	
	public function authorize($email, $password, $cookie) {
		
		global $db;
		$email = $db->escape($email);
		$hashedPassword = sha1( $password . ENCRYPTION_SALT );
		
		$userData = $db->get_row("SELECT password, id, username, name, surname FROM ".DB_TABLE_PREFIX."users WHERE email = '{$email}'");
		if( count( $userData ) <> 1 ) {
			$errors['db_info'] = "We were unable to find any user with that combination of email and password. Please try again.";
		}
		if( empty( $email ) || !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$errors['invalid_email'] = "You haven't entered a valid email address.";
		}
		if( empty( $password ) ) {
			$errors['empty_password'] = "You must enter a password.";
		}
		if( $hashedPassword != $userData->password ) {
			$errors['db_info'] = "We were unable to find any user with that combination of email and password. Please try again.";
		} 
		
		if( count( $errors ) > 0 ) {
			echo '<div class="alert alert-danger" role="alert">';
			echo '<strong>Oh snap!</strong><br /><ul>';
			foreach( $errors as $error ) {
				echo '<li>'.$error.'</li>';
			}
			echo '</ul></div>';
		} else {
			$_SESSION['user'] = $userData;
			HEADER('Location: /');
		}
	}
	
	public function evict() {
		
	}
	
	public function getUserData($uid) {
		echo 'getUserData';
	}

}