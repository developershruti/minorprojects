<?
function get_fck_editor($control_name, $value='', $width='100%', $height='500', $css_stylesheet='', $dropdown_data='', $lang='en', $mode = 'full',  $theme='')
{
	if(!defined('WITHIN_FCK')) {
		require(dirname(__FILE__)."/fckeditor.php") ;
		define('WITHIN_FCK', '1');
	}
	
	$sBasePath = SITE_SUB_PATH.'/'.PLUGINS_DIR.'/FCKeditor/';
	$oFCKeditor = new FCKeditor($control_name) ;
	$oFCKeditor->BasePath	= $sBasePath ;
	$oFCKeditor->Value		= $value;
	$oFCKeditor->Width		= $width;
	$oFCKeditor->Height		= $height;

	//$oFCKeditor->Config['UserFilesPath']	= SITE_SUB_PATH.'/uploaded_files/fck/';
	//$oFCKeditor->Config['UserFilesAbsolutePath']	= UP_FILES_FS_PATH.'/fck';
	$oFCKeditor->Create() ;
}

?>