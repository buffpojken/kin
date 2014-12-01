<?php
class Kin_Hashtags {
	
	public function createHashtagLinks( $message ) {
		preg_match_all("/(#\w+)/", $message, $hastags);
		foreach($hastags as $k=>$v) {
			$matches[$k] = $v[0];
		}
		$matches = array_unique($matches);
		if( count($matches) > 0 ) {
			foreach($matches as $match) {
				$hashtag = $match;
				$hashtag = str_replace('#', '', $hashtag);
				$message = str_replace($match, '<a href="/hashtag/'.$hashtag.'">'.$match.'</a>', $message);
			}
		}
		return $message;
	}
	
}