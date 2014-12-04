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
error_reporting('E_ERROR');

//==================================
//! EMAIL SETUP
//==================================
define('SMTP_SERVER', '');
define('SMTP_PORT', '');
define('SMTP_USER', '');
define('SMTP_PASS', '');

//==================================
//! PATHS
//==================================
define('INCLUDE_PATH',realpath(dirname(__FILE__)).'/includes');
define('CLASSES_PATH',realpath(dirname(__FILE__)).'/includes/classes');
define('LIBRARY_PATH',realpath(dirname(__FILE__)).'/includes/libraries');
define('TEMPLATE_PATH',realpath(dirname(__FILE__)).'/includes/templates');
define('EMAIL_TEMPLATE_PATH',realpath(dirname(__FILE__)).'/assets/email_templates');
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