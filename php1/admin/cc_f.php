<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
      //   
	if ($cc_id!='') {
		$sql = "update ngo_cc set  cc_userid='$cc_userid' ,cc_pay_mode='$cc_pay_mode' ,cc_admin='$_SESSION[sess_admin_login_id]' ,cc_cheque_no='$cc_cheque_no' ,cc_cheque_date='$cc_cheque_date' ,cc_bank='$cc_bank' , cc_amount='$cc_amount' , cc_given_userid='$cc_given_userid', cc_given_name='$cc_given_name', cc_cheque_userid='$cc_cheque_userid',cc_rec_date='$cc_rec_date' ,cc_remark='$cc_remark',cc_misc='$cc_misc' ,cc_contact='$cc_contact' where cc_id='$cc_id'";
		db_query($sql);
	} else {
		$sql = "insert into ngo_cc set  cc_userid='$cc_userid' ,cc_pay_mode='$cc_pay_mode' ,cc_admin='$_SESSION[sess_admin_login_id]' ,cc_cheque_no='$cc_cheque_no' ,cc_cheque_date='$cc_cheque_date' ,cc_bank='$cc_bank' , cc_amount='$cc_amount' , cc_given_userid='$cc_given_userid', cc_given_name='$cc_given_name', cc_cheque_userid='$cc_cheque_userid',cc_rec_date='$cc_rec_date' ,cc_remark='$cc_remark',cc_misc='$cc_misc' ,cc_contact='$cc_contact'";
		db_query($sql);
	}
 	header("Location: receive_list.php");
	exit;
 	 
}

$sql = "select * from ngo_cc where  cc_id ='$cc_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);

if ($_POST[Submit_Convert]=='Convert In Word') { $cc_inword = "" .convert_number($cc_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Add/ update CC </div></td>
  </tr>
</table>
<div align="right"><a href="receive_list.php">Back to Receive List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="cc_id" value="<?=$cc_id?>"  />
  <table width="90%" height="200" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
    <tr>
      <td width="22%" height="10"></td>
      <td width="78%"></td>
    </tr>
    <tr>
      <td align="right"><strong>Name : </strong></td>
      <td class="tableDetails"><input name="cc_name" type="text" id="cc_name" value="<?=$cc_name?>" alt="blank" emsg="Please enter  Name " /></td>
    </tr>
	<tr>
	  <td align="right"><strong>Mobile : </strong></td>
	  <td class="tableDetails"><input name="cc_mobile" type="text" id="cc_mobile" value="<?=$cc_mobile?>"   /></td>
	  </tr>
	<tr>
	  <td align="right"><strong>Tele : </strong></td>
	  <td class="tableDetails"><input name="cc_phone" type="text" id="cc_phone"  value="<?=$cc_phone?>" /></td>
	  </tr>
	<tr>
	  <td align="right"><strong>Address :</strong></td>
	  <td class="tableDetails"><input name="cc_address" type="text" id="cc_address"  value="<?=$cc_address?>" /></td>
	  </tr>
	<tr>
      <td align="right"><strong>City : </strong></td>
      <td class="tableDetails"><input name="cc_city" type="text" id="cc_city"  value="<?=$cc_city?>" /></td>
    </tr>
    <tr>
      <td align="right"><strong>Calling Start  Date :</strong></td>
      <td class="tableDetails"> <?=get_date_picker("cc_date_start", $cc_date_start)?></td>
    </tr>
     <tr>
      <td align="right"><strong>Last Call  Date : </strong></td>
      <td class="tableDetails"> 
	  
	  <?=get_date_picker("cc_date_last", $cc_date_last)?></td>
    </tr>
	 <tr>
	   <td align="right"><strong>Next Calling Date : </strong></td>
	   <td class="tableDetails"><?=get_date_picker("cc_date_next", $cc_date_next)?></td>
	   </tr>
	<tr>
      <td align="right"><strong>Remark: </strong></td>
      <td class="tableDetails"> 
	    <input name="cc_remark" type="text" id="cc_remark" value="<?=$cc_remark?>" size="50" />       </td>
    </tr>
    <tr>
      <td align="right"><strong>Conversation Details : </strong></td>
      <td class="tableDetails"><textarea name="cc_conversation" cols="50" rows="5" id="cc_conversation"><?=$cc_conversation?></textarea>      </td>
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