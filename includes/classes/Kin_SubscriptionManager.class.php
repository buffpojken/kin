<?php 
	
	// This class encapsulates specific business logic regarding how subscriptions
	// work and how they are managed.
	class Kin_SubscriptionManager{

		public static function activateSubscription($updateID, $userID){
			global $db; 
			$updateID = $db->escape($updateID);
			$userID 	= $db->escape($userID); 
			$subscriptionStatus = $db->get_row("SELECT count(*) as count, active from ".DB_TABLE_PREFIX."subscriptions WHERE updateID = '$updateID' and userID = '$userID'"); 
			// Subscriptions should be treated as singletons projected over updateID and userID
			if($subscriptionStatus->count == 1 && $subscriptionStatus->active == 1){
				return true; 
			}else if($subscriptionStatus->count == 1 && $subscriptionStatus->active == 0){
				$result = $db->query("UPDATE ".DB_TABLE_PREFIX."subscriptions SET active = 1 WHERE updateID = '$updateID' and userID = '$userID'"); 
				return $result;
			}else{
				$result = $db->query("INSERT INTO ".DB_TABLE_PREFIX."subscriptions(updateID, userID) VALUES($updateID, $userID);"); 
				return $result;
			}
		}

		public static function toggleSubscription($updateID, $userID){
			error_log($updateID);
			if(static::isUserSubscribedTo($updateID, $userID)){
				error_log("fisk");
				$result = static::deactivateSubscription($updateID, $userID); 
				return array('result' => $result, 'subscribed' => false);
			}else{
				error_log("bos");
				$result = static::activateSubscription($updateID, $userID); 

				return array('result' => $result, 'subscribed' => true);
			}
		}

		public static function isUserSubscribedTo($updateID, $userID){
			global $db; 
			$updateID = $db->escape($updateID);
			$userID 	= $db->escape($userID); 
			$count 		= $db->get_var("SELECT count(*) from ".DB_TABLE_PREFIX."subscriptions WHERE updateID = '$updateID' and userID = '$userID' and active = 1"); 
			error_log("SELECT count(*) from ".DB_TABLE_PREFIX."subscriptions WHERE updateID = '$updateID' and userID = '$userID' and active = 1");
			return $count > 0; 
		}

		public static function commentPostedOnUpdate($update, $posterUserID, $commentBody){
			global $user;
			global $notifications;
			$subscriptionList = static::getSubscribers($update->updateID, $posterUserID); 
			foreach($subscriptionList as $subscription){				
				if($subscription->userID != $update->userID){
					$notifications->createNotification( 
						$subscription->userID, 
						$user->getUserData($posterUserID,'name', FALSE) .' '. $user->getUserData($posterUserID,'surname', FALSE) . ' commented on an update you follow: ' . substr($commentBody, 0, 40) . "...", 
						'/profile/'.$user->getUserData($update->userID,'username', FALSE).'/updates/'. $update->updateID
					);
				}else{
					$notifications->createNotification( 
						$subscription->userID, 
						$user->getUserData($posterUserID,'name', FALSE) .' '. $user->getUserData($posterUserID,'surname', FALSE) . ' commented on your update: ' . substr($commentBody, 0, 40) . "...", 
						'/profile/'.$user->getUserData($update->userID,'username', FALSE).'/updates/'. $update->updateID
					);
				}
			}
			return true; 
		}

		public static function likePostedOnUpdate($update, $likerID){
			global $user;
			global $notifications;
			$subscriptionList = static::getSubscribers($update->updateID, $likerID); 
			foreach($subscriptionList as $subscription){				
				if($subscription->userID != $update->userID){
					$notifications->createNotification( 
						$subscription->userID, 
						$user->getUserData($likerID,'name', FALSE) .' '. $user->getUserData($likerID,'surname', FALSE) . ' liked an update you follow.', 
						'/profile/'.$user->getUserData($update->userID,'username', FALSE).'/updates/'. $update->updateID
					);
				}else{
					$notifications->createNotification( 
						$subscription->userID, 
						$user->getUserData($likerID,'name', FALSE) .' '. $user->getUserData($likerID,'surname', FALSE) . ' liked your update.', 
						'/profile/'.$user->getUserData($update->userID,'username', FALSE).'/updates/'. $update->updateID
					);
				}
			}
			return true; 
		}

		public static function deactivateSubscription($updateID, $userID){
			global $db; 
			$updateID = $db->escape($updateID);
			$userID 	= $db->escape($userID);
			$update = new Kin_Updates($updateID);
			$result 	= $db->get_results("UPDATE ".DB_TABLE_PREFIX."subscriptions SET active = 0 WHERE updateID = '$updateID' and userID = '$userID'");				
			return true; 
		}

		private static function getSubscribers($updateId, $excludeId){
			global $db;
			$updateID 						= $db->escape($updateId);
			$excludeId 						= $db->escape($excludeId);
			$subscriptionList 		= $db->get_results("SELECT * FROM ".DB_TABLE_PREFIX."subscriptions WHERE updateID = '$updateID' and active = 1 and userID != '$excludeId'");			
			return $subscriptionList;
		}

	}
?>

