<?php
if ( $handle = opendir( CLASSES_PATH ) ) {

    while ( false !== ( $entry = readdir( $handle ) ) ) {
		
        if ( $entry != "." && $entry != ".." && $entry != 'loader.inc.php' ) {
			require_once $entry;
            #echo "$entry\n";
        }
    }

    closedir( $handle );
}