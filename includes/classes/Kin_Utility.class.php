<?php
class Kin_Utility {

	public function bodyClass( $classes=NULL ) {
		if( isset( $_GET['path_page'] ) ) { 
			echo ' class="'.$_GET['path_page'].'"'; 
		} else { 
			echo ' class="home"'; 
		}
	}

	function var_debug($variable,$strlen=100,$width=25,$depth=10,$i=0,&$objects = array())
	{
	  $search = array("\0", "\a", "\b", "\f", "\n", "\r", "\t", "\v");
	  $replace = array('\0', '\a', '\b', '\f', '\n', '\r', '\t', '\v');
	 
	  $string = '';
	 
	  switch(gettype($variable)) {
	    case 'boolean':      $string.= $variable?'true':'false'; break;
	    case 'integer':      $string.= $variable;                break;
	    case 'double':       $string.= $variable;                break;
	    case 'resource':     $string.= '[resource]';             break;
	    case 'NULL':         $string.= "null";                   break;
	    case 'unknown type': $string.= '???';                    break;
	    case 'string':
	      $len = strlen($variable);
	      $variable = str_replace($search,$replace,substr($variable,0,$strlen),$count);
	      $variable = substr($variable,0,$strlen);
	      if ($len<$strlen) $string.= '"'.$variable.'"';
	      else $string.= 'string('.$len.'): "'.$variable.'"...';
	      break;
	    case 'array':
	      $len = count($variable);
	      if ($i==$depth) $string.= 'array('.$len.') {...}';
	      elseif(!$len) $string.= 'array(0) {}';
	      else {
	        $keys = array_keys($variable);
	        $spaces = str_repeat(' ',$i*2);
	        $string.= "array($len)\n".$spaces.'{';
	        $count=0;
	        foreach($keys as $key) {
	          if ($count==$width) {
	            $string.= "\n".$spaces."  ...";
	            break;
	          }
	          $string.= "\n".$spaces."  [$key] => ";
	          $string.= var_debug($variable[$key],$strlen,$width,$depth,$i+1,$objects);
	          $count++;
	        }
	        $string.="\n".$spaces.'}';
	      }
	      break;
	    case 'object':
	      $id = array_search($variable,$objects,true);
	      if ($id!==false)
	        $string.=get_class($variable).'#'.($id+1).' {...}';
	      else if($i==$depth)
	        $string.=get_class($variable).' {...}';
	      else {
	        $id = array_push($objects,$variable);
	        $array = (array)$variable;
	        $spaces = str_repeat(' ',$i*2);
	        $string.= get_class($variable)."#$id\n".$spaces.'{';
	        $properties = array_keys($array);
	        foreach($properties as $property) {
	          $name = str_replace("\0",':',trim($property));
	          $string.= "\n".$spaces."  [$name] => ";
	          $string.= var_debug($array[$property],$strlen,$width,$depth,$i+1,$objects);
	        }
	        $string.= "\n".$spaces.'}';
	      }
	      break;
	  }
	 
	  if ($i>0) return $string;
	 
	  $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	  do $caller = array_shift($backtrace); while ($caller && !isset($caller['file']));
	  if ($caller) $string = $caller['file'].':'.$caller['line']."\n".$string;
	 
	  error_log($string);
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

	public function userSubscribesTo($updateID){
		return Kin_SubscriptionManager::isUserSubscribedTo($updateID, $_SESSION['userID']);
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
	
	public function getOnlineUsers(){
		if ( $directory_handle = opendir( session_save_path() ) ) {
			$count = 0;
			while ( false !== ( $file = readdir( $directory_handle ) ) ) {
				if($file != '.' && $file != '..'){
					// Comment the 'if(...){' and '}' lines if you get a significant amount of traffic 
					if(time()- fileatime(session_save_path() . '\\' . $file) < MAX_IDLE_TIME * 60) { 
						$count++;
					}
				}
				closedir($directory_handle);
				return $count; 
			}
		} else { 
			return false; 
		}
	}

}