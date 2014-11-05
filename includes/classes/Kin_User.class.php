<?php 
class Kin_User {
	
	public $name = "Frank";
	
	public function authorize($email, $password) {
		echo 'authorize';
	}
	
	public function getUserData($uid) {
		echo 'getUserData';
	}

}