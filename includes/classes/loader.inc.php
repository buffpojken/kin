<?php
if ( $handle = opendir( CLASSES_PATH ) ) {

    while ( false !== ( $entry = readdir( $handle ) ) ) {
		
        if ( $entry != "." && $entry != ".." && $entry != 'loader.inc.php' ) {
			require_once $entry;
            #echo "<p>$entry</p>\n";
        }
    }

    closedir( $handle );
}