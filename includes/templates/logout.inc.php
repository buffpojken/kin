<?php
session_destroy();
setcookie ( 'kin_social_login', $_COOKIE['kin_social_login'], time() - 60 * 60 * 24 * 14 );
HEADER('Location: /');
exit;