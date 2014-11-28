<?php
class Kin_Utility {
	
	public function updateTimeSince($timestamp) {
		$date = new DateTime();
		$date->setTimestamp(strtotime($timestamp));
		$interval = $date->diff(new DateTime('now'));
		#echo '<pre>' . print_r( $interval, true ) . '</pre>';
		if( $interval->y != 0 ) {
			$format .= '%y years, ';
		}
		if( $interval->m != 0 ) {
			$format .= '%m months, ';
		}
		if( $interval->d != 0 ) {
			$format .= '%d days, ';
		}
		if( $interval->h != 0 ) {
			$format .= '%h hours ';
		}
		if( $interval->h != 0 && $interval->i != 0 ) {
			$format .= 'and %i minutes ago';
		} elseif( $interval->i != 0 ) {
			$format .= '%i minutes ago';
		}
		echo $interval->format( $format );
	}

}