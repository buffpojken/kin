<?php
//==================================
//! SITE SETTINGS
//==================================
define('ENCRYPTION_SALT', '');
define('DB_TABLE_PREFIX', '');
define('KIN_VERSION', '1.0');
date_default_timezone_set('Europe/Copenhagen');

//==================================
//! ERROR HANDLING AND DEBUG
//==================================
error_reporting('E_NONE');

//==================================
//! PATHS
//==================================
define('INCLUDE_PATH',realpath(dirname(__FILE__)).'/includes');
define('CLASSES_PATH',realpath(dirname(__FILE__)).'/includes/classes');
define('LIBRARY_PATH',realpath(dirname(__FILE__)).'/includes/libraries');
define('TEMPLATE_PATH',realpath(dirname(__FILE__)).'/includes/templates');
define('GLOBALS_PATH',realpath(dirname(__FILE__)).'/includes/globals');
define('UPLOADS_PATH',realpath(dirname(__FILE__)).'/uploads');

//==================================
//! DATABASE CONNECTION
//==================================
require_once(LIBRARY_PATH."/ezsql/ez_sql_core.php");
require_once(LIBRARY_PATH."/ezsql/ez_sql_mysqli.php");
$dbUser = "";
$dbPass = "";
$dbName = "";
$dbHost = "";
$db = new ezSQL_mysqli($dbUser,$dbPass,$dbName,$dbHost);

//==================================
//! CLASS LOADER
//==================================
//require(CLASSES_PATH . '/loader.inc.php');
require(CLASSES_PATH . '/Kin_User.class.php');
require(CLASSES_PATH . '/Kin_Updates.class.php');
require(CLASSES_PATH . '/Kin_Notification.class.php');
require(CLASSES_PATH . '/Kin_Utility.class.php');
$utility = new Kin_Utility;
$notifications = new Kin_Notification;
