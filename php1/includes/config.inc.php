<?php
if(!defined('LOCAL_MODE')) {
	die('<span style="font-family: tahoma, arial; font-size: 11px">config file cannot be included directly');
}
if (LOCAL_MODE) {
    // Settings for local midas server do not edit here
    $ARR_CFGS["db_host"] = 'localhost';
	$ARR_CFGS["db_name"] = '2025_kenzotrade_com'; // 
    $ARR_CFGS["db_user"] = 'root';
    $ARR_CFGS["db_pass"] = '';
	define('SITE_SUB_PATH', '/2025/kenzotrade.com');
 } else {
    // Settings for live server edit whenever shifting site to different server
	$ARR_CFGS["db_host"] = 'localhost';
	$ARR_CFGS["db_name"] = 'db_kenzotrade_com'; //2024_kenzotrade.com
    $ARR_CFGS["db_user"] = 'kenzodbuser';
    $ARR_CFGS["db_pass"] = '4oCtm4LquY-MwpQz4oCtmQz4oCtm4LquY-MwpQz4oCtm4';
	define('SITE_SUB_PATH', '');
}
define('SITE_WS_PATH', 'http://'.$_SERVER['HTTP_HOST'].SITE_SUB_PATH);
define('THUMB_CACHE_DIR', 'thumb_cache');
define('PLUGINS_DIR', 'includes/plugins');

define('UP_FILES_FS_PATH', SITE_FS_PATH.'/uploaded_files');
define('UP_FILES_WS_PATH', SITE_WS_PATH.'/uploaded_files');

define('DEFAULT_START_YEAR', 2011);
define('DEFAULT_END_YEAR', date('Y')+10);

define('ADMIN_EMAIL', 'info@kenzotrade.com');
define('SUPPORT_EMAIL', 'support@kenzotrade.com');
define('SITE_NAME', 'Kenzo Trade');
define('SITE_TITLE', 'Kenzo Trade');
define('SITE_URL', 'www.kenzotrade.com');
define('TEST_MODE', false);
define('DEF_PAGE_SIZE', 10);
define('SITE_CSS', 'style.css');
?>