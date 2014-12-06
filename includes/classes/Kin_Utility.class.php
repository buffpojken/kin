<?php
class Kin_Utility {

	public function bodyClass( $classes=NULL ) {
		if( isset( $_GET['path_page'] ) ) { 
			echo ' class="'.$_GET['path_page'].'"'; 
		} else { 
			echo ' class="home"'; 
		}
	}
	
	public function siteTitle() {
		if( isset( $_GET['path_page'] ) ) {
		
			if( isset( $_GET['path_section'] ) ) {
		
				if( $_GET['path_page'] == 'profile' ) {
				
					$name = new Kin_User($_GET['path_section']);
					$output = $name->name . ' ' . $name->surname . ' · ' . $this->siteOptions('SITE_NAME', FALSE);
				
				} elseif( $_GET['path_page'] == 'messages' ) {
				
					$message = new Kin_Private_Messages;
					$message = $message->latestThreadReply($_GET['path_section']);
					$output = $message->subject . ' · Messages · ' . $this->siteOptions('SITE_NAME', FALSE);
				
				} else {
				
					$output = ucfirst($_GET['path_section'] . ' · ' . $this->siteOptions('SITE_NAME', FALSE));
				
				}
			
			} else {
		
				$output = ucfirst($_GET['path_page'] . ' · ' . $this->siteOptions('SITE_NAME', FALSE));
		
			}
		
		} else {
		
			$output = $this->siteOptions('SITE_NAME', FALSE);
		
		}
		echo $output;
	}
	
	public function siteOptions($key, $echo=TRUE) {
		global $db;
		$key = $db->escape( $key );
		$option = $db->get_var( "SELECT option_value FROM ".DB_TABLE_PREFIX."options WHERE option_key = '{$key}'" );
		if( $option ) {
			if( $echo ) {
				echo $option;
			} else {
				return $option;
			}
		}
	}
	
	public function hasCurrentUserLikedThis($updateID) {
		global $db;
		$updateID = $db->escape($updateID);
		$result = $db->get_var("SELECT id FROM ".DB_TABLE_PREFIX."likes WHERE userID ='{$_SESSION['userID']}' AND updateID = '{$updateID}'");
		if( $result ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function timeSince($timestamp,$echo=TRUE) {
		$date = new DateTime();
		$date->setTimestamp(strtotime($timestamp));
		$interval = $date->diff(new DateTime('now'));
		if( $interval->y != 0 ) {
			if( $interval->y == 1 ) {
				$format .= '%y year, ';
			} else {
				$format .= '%y years, ';
			}
		}
		if( $interval->m != 0 ) {
			if( $interval->m == 1 ) {
				$format .= '%m month, ';
			} else {
				$format .= '%m months, ';
			}
		}
		if( $interval->d != 0 ) {
			if( $interval->d == 1 ) {
				$format .= '%d day, ';
			} else {
				$format .= '%d days, ';
			}
		}
		if( $interval->h != 0 ) {
			if( $interval->h == 1 ) {
				$format .= '%h hr ';
			} else {
				$format .= '%h hrs ';
			}
		}
		if( $interval->h != 0 && $interval->i != 0 ) {
			if( $interval->i == 1 ) {
				$format .= 'and %i min ago';
			} else {
				$format .= 'and %i mins ago';
			}
		} elseif( $interval->i != 0 ) {
			if( $interval->i == 1 ) {
				$format .= '%i min ago';
			} else {
				$format .= '%i mins ago';
			}
		}
		if( $echo ) {
			echo $interval->format( $format );
		} else {
			return $interval->format( $format );
		}
	}
	
	public function updateSiteSettings( $input ) {}

}