<?php
class Kin_Hashtags {
	
	public function createHashtagLinks( $message ) {
		preg_match_all("/(#\w+)/", $message, $matches);
		if( count($matches) > 0 ) {
			foreach($matches as $match) {
				str_replace($match, '<a href="/hashtag/'.$match.'">'.$match.'</a>', $message);
			}
		}
	}
	
}