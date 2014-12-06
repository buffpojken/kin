<?php 
	
	// This class encapsulates specific business logic regarding how subscriptions
	// work and how they are managed.
	class Kin_SubscriptionManager{

		public static function createSubscription($updateID, $userID){
			global $db; 
			$updateID = $db->escape($updateID);
			$userID 	= $db->escape($userID); 
			$subscriptionCount = $db->get_var("SELECT count(*) from ".DB_TABLE_PREFIX."subscriptions WHERE updateID = '$updateID' and userID = '$userID'"); 
			// Subscriptions should be treated as singletons projected over updateID and userID
			if($subscriptionCount == 1){
				return true; 
			}else{
				$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."subscriptions(updateID, userID) VALUES($updateID, $userID);"); 
				return $result;
			}
		}

	}


?>

