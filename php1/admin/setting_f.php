<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
	if($sett_id!='') {
		$sql = "update ngo_setting set sett_title ='$sett_title', sett_value = '$sett_value', sett_unit = '$sett_unit', sett_desc = '$sett_desc' ,sett_admin='$_SESSION[sess_admin_login_id]' ,sett_lastupdate=ADDDATE(now(),INTERVAL 750 MINUTE)   where sett_id = $sett_id";
		db_query($sql);
	//} else{
		//$sql = "insert into ngo_setting set sett_page_name ='$sett_page_name', sett_title = '$sett_title', sett_desc = '$sett_desc',sett_admin='$_SESSION[sess_admin_login_id]',sett_date=now() ";
		//
	#header("Location: setting_list.php");
	#exit;
}
}
$sett_id = $_REQUEST['sett_id'];
if($sett_id!='') {
	$sql = "select * from ngo_setting where sett_id = '$sett_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
	}
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">Setting</div></td>
  </tr>
</table>
<div align="right"><a href="setting_list.php">Back to 
        setting        List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
      <td width="181" align="right" class="tdLabel">Setting Title :</td>
      <td width="790" class="tdData"><input name="sett_title" type="text" id="sett_title" value="<?=$sett_title?>"  alt="blank" class="textfield"></td>
      </tr>
	  <tr>
      <td width="181" align="right" class="tdLabel">Value : </td>
      <td width="790" class="tdData"><input name="sett_value" type="text" id="sett_value" value="<?=$sett_value?>"  alt="blank" class="textfield"></td>
      </tr>

     	    <tr>
     	      <td align="right" class="tdLabel">Unit : </td>
     	      <td class="tdData"><input name="sett_unit" type="text" id="sett_unit" value="<?=$sett_unit?>"  alt="blank" class="textfield" /></td>
   	      </tr>
     	    <tr>
     	      <td align="right" valign="top" class="tdLabel">Description : </td>
     	      <td class="tdData"><textarea name="sett_desc" cols="50" rows="4" class="textfield" id="sett_desc"  ><?=$sett_desc?></textarea></td>
   	      </tr>
     	    <tr>
	    <td align="right" class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="sett_id" value="<?=$sett_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>