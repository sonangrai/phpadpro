<?php 
/* 
 * Basic Site Settings and API Configuration 
 */ 
 
// Database configuration 
define('DB_HOST', 'mysql013.phy.heteml.lan'); 
define('DB_USERNAME', '_ad_vr_db'); 
define('DB_PASSWORD', 'gdgxp27r');
define('DB_NAME', '_ad_vr_db'); 
define('DB_USER_TBL', 'a_user'); 
 
// Twitter API configuration 
define('TW_CONSUMER_KEY', 'hyA6gi2gmVaxDkpo39AkI2rf2'); 
define('TW_CONSUMER_SECRET', 'D0ACZHrKPREoJkItFMyU5FmbdlaaymXjpxVyB6TCm64SY1Z1HX'); 
define('TW_REDIRECT_URL', 'http://ad-vr.com/'); 
 
// Start session 
if(!session_id()){ 
    session_start(); 
} 
 
// Include Twitter client library  
require_once 'inc/twitteroauth.php';