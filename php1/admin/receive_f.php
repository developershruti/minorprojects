<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
      //   
 		 //rece_userid,  rece_pay_mode, rece_admin, rece_cheque_no, rece_cheque_date, rece_bank, rece_amount, rece_given_userid, rece_given_name, rece_cheque_userid, rece_rec_date, rece_contact,   rece_remark
	
 		if ($rece_id!='') {
			$sql = "update ngo_receive set  rece_userid='$rece_userid' ,rece_pay_mode='$rece_pay_mode' ,rece_admin='$_SESSION[sess_admin_login_id]' ,rece_cheque_no='$rece_cheque_no' ,rece_cheque_date='$rece_cheque_date' ,rece_bank='$rece_bank' , rece_amount='$rece_amount' , rece_given_userid='$rece_given_userid', rece_given_name='$rece_given_name', rece_cheque_userid='$rece_cheque_userid',rece_rec_date='$rece_rec_date' ,rece_remark='$rece_remark',rece_misc='$rece_misc' ,rece_contact='$rece_contact' where rece_id='$rece_id'";
			db_query($sql);
 		} else {
			$sql = "insert into ngo_receive set  rece_userid='$rece_userid' ,rece_pay_mode='$rece_pay_mode' ,rece_admin='$_SESSION[sess_admin_login_id]' ,rece_cheque_no='$rece_cheque_no' ,rece_cheque_date='$rece_cheque_date' ,rece_bank='$rece_bank' , rece_amount='$rece_amount' , rece_given_userid='$rece_given_userid', rece_given_name='$rece_given_name', rece_cheque_userid='$rece_cheque_userid',rece_rec_date='$rece_rec_date' ,rece_remark='$rece_remark',rece_misc='$rece_misc' ,rece_contact='$rece_contact'";
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
      <td align="right"><strong>User ID : </strong></td>
      <td class="tableDetails"><input name="rece_userid" type="text" id="rece_userid" value="<?=$rece_userid?>" alt="blank" emsg="Please enter user id " /></td>
    </tr>
	<tr>
	  <td align="right"><strong>Payment Mode: </strong></td>
	  <td class="tableDetails"> <? //=payment_mode_dropdown('rece_pay_mode',$rece_pay_mode)?>
	  <input name="rece_pay_mode" type="text" id="rece_pay_mode" value="<?=$rece_pay_mode?>" alt="blank" emsg="Please enter payment mode " />   </td>
	  </tr>
	<tr>
	  <td align="right"><strong>  Amount :</strong></td>
	  <td class="tableDetails"><input name="rece_amount" type="text" id="rece_amount"  value="<?=$rece_amount?>" alt="blank" emsg="Please enter Amount " /></td>
	  </tr>
	<tr>
      <td align="right"><strong>Cheque No : </strong></td>
      <td class="tableDetails"><input name="rece_cheque_no" type="text" id="rece_cheque_no"  value="<?=$rece_cheque_no?>" /></td>
    </tr>
    <tr>
      <td align="right"><strong>Cheque Date :</strong></td>
      <td class="tableDetails"> <?=get_date_picker("rece_cheque_date", $rece_cheque_date)?></td>
    </tr>
    <tr>
      <td align="right"><strong>Bank Name:</strong></td>
      <td class="tableDetails"><? //=bank_dropdown('rece_bank',$rece_bank)?>
        <input name="rece_bank" type="text" id="rece_bank"  value="<?=$rece_bank?>" /></td>
    </tr>
     
    <tr>
      <td align="right"><strong>User ID on cheque:</strong> </td>
      <td class="tableDetails"><input name="rece_cheque_userid" type="text" id="rece_cheque_userid" value="<?=$rece_cheque_userid?>"   /></td>
    </tr>
    <tr>
      <td align="right"><strong>Given By User  ID/ Name : </strong></td>
      <td class="tableDetails"><input name="rece_given_userid" type="text" id="rece_given_userid"  value="<?=$rece_given_userid?>" size="10" />
      <input name="rece_given_name" type="text" id="rece_given_name"  value="<?=$rece_given_name?>" /></td>
    </tr>
     <tr>
      <td align="right"><strong>Receive Date : </strong></td>
      <td class="tableDetails"> 
	  <!--<input name="rece_rec_date" type="text" id="rece_rec_date"  value="<? //=$rece_rec_date?>" />-->
	  <?=get_date_picker("rece_rec_date", $rece_rec_date)?></td>
    </tr>
	<tr>
      <td align="right"><strong>Contact Number: </strong></td>
      <td class="tableDetails"> 
	  <input name="rece_contact" type="text" id="rece_contact"  value="<?=$rece_contact?>" />       </td>
    </tr>
	<tr>
      <td align="right"><strong>Remark: </strong></td>
      <td class="tableDetails"> 
	  <textarea name="rece_remark" cols="50" rows="5" id="rece_remark"><?=$rece_remark?></textarea>       </td>
    </tr>
    <tr>
      <td align="right"><strong>MISC: </strong></td>
      <td class="tableDetails"><textarea name="rece_misc" cols="50" rows="5" id="rece_misc"><?=$rece_misc?></textarea>
      </td>
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