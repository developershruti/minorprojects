<?
error_reporting(E_ALL ^ E_NOTICE);

// Start output buffering
// Set variable $NO_OB = true if output buffering is not needed in a file
/*
if(!isset($NO_OB) && LOCAL_MODE==false) {
	ob_start("ob_gzhandler");
}
*/
if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "sb") {
    define('LOCAL_MODE', true);
} else {
 	define('LOCAL_MODE', false);
}

// File system path
$tmp = dirname(__FILE__);
$tmp = str_replace('\\' ,'/',$tmp);
$tmp = substr($tmp, 0, strrpos($tmp, '/'));
define('SITE_FS_PATH', $tmp); 

// include all the library files needed here
require_once(SITE_FS_PATH."/includes/config.inc.php");
require_once(SITE_FS_PATH."/includes/funcs_lib.inc.php");
require_once(SITE_FS_PATH."/includes/funcs_cur.inc.php");
require_once(SITE_FS_PATH."/includes/arrays.inc.php");

//protect_admin_page(); 
 
if(strtolower($_SERVER['HTTPS'])=='on') {
	define('IN_SSL', true);
	//define('HTTP_OR_HTTPS_PATH', SITE_SSL_PATH);
} else {
	define('IN_SSL', false);
	define('HTTP_OR_HTTPS_PATH', SITE_WS_PATH);
}

session_start();

// Script start time used to test site performance
define('SCRIPT_START_TIME', getmicrotime());
//echo("<br>SCRIPT_START_TIME: ".SCRIPT_START_TIME);

// magic_quotes_gpc needs to be "on"
if(get_magic_quotes_gpc()==0) {
	$_GET		= ms_addslashes($_GET);
	$_POST		= ms_addslashes($_POST);
	$_COOKIE	= ms_addslashes($_COOKIE);
	@extract($_GET);
	@extract($_POST);
} else {
	$_GET		= ms_trim($_GET);
	$_POST		= ms_trim($_POST);
	$_COOKIE	= ms_trim($_COOKIE);
	@import_request_variables('gp');
}

// magic_quotes_runtime needs to be "off"
if(get_magic_quotes_runtime()) {
	set_magic_quotes_runtime(0);
}

// load plugins
if ($handle = opendir(SITE_FS_PATH.'/'.PLUGINS_DIR)) { 
   while (false !== ($file = readdir($handle))) { 
       if ($file != "." && $file != "..") { 
		   $curr_dir = SITE_FS_PATH.'/'.PLUGINS_DIR.'/'.$file;
           if(is_dir($curr_dir)) {
			   if(file_exists($curr_dir.'/midas_plugin.php')) {
				   require_once($curr_dir.'/midas_plugin.php');
			   }
		   }
       } 
   } 
   closedir($handle); 
} 


// Protect admin pages
$_SERVER['PHP_SELF'] = str_replace('/'.$_SERVER['HTTP_HOST'],'',$_SERVER['PHP_SELF']);
$PHP_SELF = $_SERVER['PHP_SELF'];

 $admin_pos  = strpos($PHP_SELF, '/admin/');
if($admin_pos !== false) {
	// Remove following comment to enable admin login check
	protect_admin_page();
}

/********************************/
/*Sk Hide .php extension start */
/********************************/
 $actual_link = get_current_actual_url();
 $new_link =  str_replace(".php","",$actual_link, $count1);
 ///when .php found then it return 1 otherwise return 0
 if($count1>0) {
 	   // header("Location: $new_link");
	   // exit;  
/* echo "<script>
    window.location = '$new_link';
</script>";*/
 } 
 /********************************/
/*Sk Hide .php extension end */
/********************************/

?>