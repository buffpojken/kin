<?php
//==================================
//! SITE SETTINGS
//==================================
define('ENCRYPTION_SALT', '[[INSTALLER_REPLACE_ENCRYPTION_SALT]]');
define('DB_TABLE_PREFIX', '[[INSTALLER_REPLACE_DATABASE_PREFIX]]');

//==================================
//! ERROR HANDLING AND DEBUG
//==================================
error_reporting('E_ALL');

//==================================
//! PATHS
//==================================
define('INCLUDE_PATH',realpath(dirname(__FILE__)).'/includes');
define('CLASSES_PATH',realpath(dirname(__FILE__)).'/includes/classes');
define('LIBRARY_PATH',realpath(dirname(__FILE__)).'/includes/libraries');
define('TEMPLATE_PATH',realpath(dirname(__FILE__)).'/includes/templates');

//==================================
//! DATABASE CONNECTION
//==================================
require_once(LIBRARY_PATH."/ezsql/ez_sql_core.php");
require_once(LIBRARY_PATH."/ezsql/ez_sql_mysqli.php");
$dbUser = "[[INSTALLER_REPLACE_DATABASE_USERNAME]]";
$dbPass = "[[INSTALLER_REPLACE_DATABASE_PASSWORD]]";
$dbName = "[[INSTALLER_REPLACE_DATABASE_NAME]]";
$dbHost = "[[INSTALLER_REPLACE_DATABASE_HOST]]";
$db = new ezSQL_mysqli($dbUser,$dbPass,$dbName,$dbHost);

//==================================
//! CLASS LOADER
//==================================
require(CLASSES_PATH . '/loader.inc.php');

//==================================
//! SITE SETTINGS
//==================================
$locale = getSysOption('language');
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("messages", "./Locale");
textdomain("messages");