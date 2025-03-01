<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
  
 		if ($rece_id!='') {
			$sql = "update ngo_receive set  rece_deposit_bank='$rece_deposit_bank' ,rece_deposit_account='$rece_deposit_account' ,rece_deposit_name='$rece_deposit_name' ,rece_deposit_date='$rece_deposit_date' ,rece_deposit_status='$rece_deposit_status' ,rece_deposit_remark='$rece_deposit_remark'  where rece_id='$rece_id'";
			db_query($sql);
 		 
  		}
 	header("Location: receive_list.php");
	exit;
 	 
}

$sql = "select * from ngo_receive where  rece_id ='$rece_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);

if ($_POST[Submit_Convert]=='Convert In Word') { $rece_inword = "" .convert_number($rece_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Create/ update Cheque </div></td>
  </tr>
</table>
<div align="right"><a href="receive_list.php">Back to Receive List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="rece_id" value="<?=$rece_id?>"  />
  <table width="90%" height="200" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
    <tr>
      <td width="22%" height="10"></td>
      <td width="78%"></td>
    </tr>
    <tr>
      <td align="right"><strong>Cheque Details : </strong></td>
      <td class="tableDetails"> UserID:<strong><?=$rece_userid?></strong>, Cheque No:<strong><?=$rece_cheque_no?></strong>, Cheque Date:<strong><?=$rece_cheque_date?></strong> , Amount : <strong><?=$rece_amount?></strong> </td>
    </tr>
    <tr>
      <td align="right"><strong>Bank Name :</strong></td>
      <td class="tableDetails"><?=bank_dropdown('rece_deposit_bank',$rece_deposit_bank)?></td>
    </tr>
    <tr>
      <td align="right"><strong>Deposit  Date :</strong></td>
      <td class="tableDetails"><?=get_date_picker("rece_deposit_date", $rece_deposit_date)?></td>
    </tr>
    <tr>
      <td align="right"><strong>Deposit Name  : </strong></td>
      <td class="tableDetails"><input name="rece_deposit_name" type="text" id="rece_deposit_name" value="<?=$rece_deposit_name?>" alt="blank" emsg="Please enter deposit Name " /></td>
    </tr>
	<tr>
	  <td align="right"><strong>  Cheque Status :</strong></td>
	  <td class="tableDetails"><input name="rece_deposit_status" type="text" id="rece_deposit_status"  value="<?=$rece_deposit_status?>" alt="blank" emsg="Please enter Cheque Status " /></td>
	  </tr>
	<tr>
      <td align="right" valign="top"><strong>Remark: </strong></td>
      <td class="tableDetails"> 
	  <textarea name="rece_deposit_remark" cols="50" rows="5" id="rece_deposit_remark"><?=$rece_deposit_remark?></textarea>       </td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
      <td class="tableDetails"><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
      <td class="tableDetails">&nbsp;</td>
    </tr>
  </table>
  <br />
  <br />
  </form>
<? include("bottom.inc.php");?>