<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
	///if($sett_id!='') {
		$sql = "update ngo_setting set  sett_value = '$sett_value'  where sett_code = 'BANK_WITHDRAWAL_STATUS'";
		db_query($sql);
		$msg = "Status updated successfully.";
	//} else{
		//$sql = "insert into ngo_setting set sett_page_name ='$sett_page_name', sett_title = '$sett_title', sett_desc = '$sett_desc',sett_admin='$_SESSION[sess_admin_login_id]',sett_date=now() ";
		//
	#header("Location: setting_update.php");
	#exit;
//}
}
 
//if($sett_id!='') {
	$sql = "select * from ngo_setting where sett_code = 'BANK_WITHDRAWAL_STATUS'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
	}
//}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">Setting Update </div></td>
  </tr>
</table>
<div align="center"></div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	   <tr><td  > </td>
    <td class="errorMsg"><?=$msg?> </td>
  </tr><tr>
      <td width="181" align="right" class="tdLabel"> LR Withdrawal Option :  </td>
      <td width="790" class="tdData"> <?=array_dropdown($ARR_OPEN_CLOSE, $sett_value, 'sett_value','style="width:80px;"');?>
	  
      </td>
	  </tr>
     	    <tr>
	    <td align="right" class="tdLabel" >&nbsp;</td>
	    <td class="tdData"> 
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>