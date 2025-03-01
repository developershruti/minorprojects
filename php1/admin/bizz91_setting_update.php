<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
	
		//,bizz_api_key='$bizz_api_key',bizz_token='$bizz_token',bizz_token_expiry='$bizz_token_expiry',bizz_balance='$bizz_balance'
	//	$sql = "update ngo_bizz91 set  bizz_username='$bizz_username' ,bizz_password='$bizz_password',bizz_status='$bizz_status', bizz_date =ADDDATE(now(),INTERVAL 630 MINUTE)";
	//	db_query($sql);
	/*
	$_SESSION['bizz_username']= $bizz_username;
	$_SESSION['bizz_password']=$bizz_password;
	$_SESSION['bizz_status']=$bizz_status;
 */
//print_r($_SESSION);

//print "<br> ==================> $bizz_status";
 //print "$bizz_username | $bizz_password  | $bizz_status ";
 	//$bizz_status = 'Active';
	if($bizz_status=='Active') { 
		// get to token and other setting value 
			//print "<br>  Ley=".	
			$bizz_api_key = bizz91_get_api_key($bizz_username , $bizz_password ,$bizz_status );
			//print "<br>  token=".
			$bizz_token = bizz91_get_token($bizz_username , $bizz_api_key ,$bizz_status);
				$_SESSION['bizz_token'] = $bizz_token;
				$_SESSION['bizz_status'] = $bizz_status;
			if($_SESSION['bizz_token']!='') {
				header("Location: users_with.php");
				exit;
			} else {
				$msg = "Error : Token not generated.";
			}
	} else if($bizz_status=='Inactive') {
	//	Print " Start => ";
		 
				 $status = bizz91_get_token_expire($bizz_username , $_SESSION['bizz_api_key'] ,$bizz_status);


	}


		

}
 
//if($sett_id!='') {
	/*
	$sql = "select * from ngo_bizz91 where 1";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
	}
	*/
//}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">Bizz91  Setting Update </div></td>
  </tr>
</table>
<div align="center"></div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	   <tr><td  > </td>
    <td class="errorMsg"><?=$msg?> </td>
  </tr>
  
  <tr>
      <td width="181" align="right" class="tdLabel">Username :  </td>
      <td width="790" class="tdData"> <input type="text" value="<?=$bizz_username?>" name="bizz_username"> </td>
	  </tr>
	  <tr>
      <td width="181" align="right" class="tdLabel">Password :  </td>
      <td width="790" class="tdData"> <input type="text" value="<?=$bizz_password?>" name="bizz_password"> </td>
	  </tr>

	  <tr>
      <td width="181" align="right" class="tdLabel">Status :  </td>
      <td width="790" class="tdData">  <?=status_dropdown('bizz_status', $bizz_status)?>  </td>
	  </tr>
	   <!--
	  <tr>
      <td width="181" align="right" class="tdLabel">API Key :  </td>
      <td width="790" class="tdData">  <?=$bizz_api_key?>  </td>
	  </tr>
	  <tr>
      <td width="181" align="right" class="tdLabel">Token :  </td>
      <td width="790" class="tdData">  <?=$bizz_token?> </td>
	  </tr>
 
	  <tr>
      <td width="181" align="right" class="tdLabel">Token Expiry :  </td>
      <td width="790" class="tdData"> <?=$bizz_token_expiry?> </td>
	  </tr>
	  <tr>
      <td width="181" align="right" class="tdLabel">Acc Balance :  </td>
      <td width="790" class="tdData"> <?=$bizz_balance?> </td>
	  </tr>

	  <tr>
      <td width="181" align="right" class="tdLabel">Last Update :  </td>
      <td width="790" class="tdData"> <?=$bizz_date?> </td>
	  </tr>
-->
     	    <tr>
	    <td align="right" class="tdLabel" >&nbsp;</td>
	    <td class="tdData"> 
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>