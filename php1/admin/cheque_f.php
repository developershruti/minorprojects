<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
      //  check_userid, check_bank, check_amount, check_inword, check_date, check_status, check_rec_name, check_rec_date from eversmiletm.ngo_cheque
//print_r($_POST);
 		$check_userid = db_scalar("select u_id from ngo_users where u_username='$check_username'");
 		$check_rec_id =  db_scalar("select u_id from ngo_users where u_username='$check_rec_id'");
		if ($check_inword=='') { 
 		$check_inword = "" .convert_number($check_amount). " only" ;
		}
 		if ($check_id!='') {
			$sql = "update ngo_cheque set  check_userid='$check_userid' ,check_type='$check_type',check_cheque_no='$check_cheque_no',check_bank='$check_bank' ,check_amount='$check_amount' ,check_inword='$check_inword' , check_date='$check_date' , check_status='$check_status', check_rec_id='$check_rec_id', check_rec_name='$check_rec_name',check_rec_date='$check_rec_date' ,check_remark='$check_remark' ,check_contact='$check_contact' ,check_for='$check_for' ,check_closeid='$check_closeid' ,check_payment_mode='$check_payment_mode',check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now() where check_id='$check_id'";
			db_query($sql);
 		} else {
			$sql = "insert into ngo_cheque set  check_userid='$check_userid',check_type='$check_type' ,check_bank='$check_bank' ,check_cheque_no='$check_cheque_no' ,check_amount='$check_amount' ,check_inword='$check_inword' , check_date='$check_date' , check_status='$check_status', check_rec_id='$check_rec_id', check_rec_name='$check_rec_name', check_rec_date='$check_rec_date',check_contact='$check_contact' ,check_remark='$check_remark' ,check_for='$check_for' ,check_closeid='$check_closeid' ,check_payment_mode='$check_payment_mode',check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now()";
			db_query($sql);
  		}
 	header("Location: cheque_list.php");
	exit;
 	 
}

$sql = "select * from ngo_cheque where  check_id ='$check_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
$check_username = db_scalar("select u_username from ngo_users where u_id='$check_userid'");
$check_rec_id = db_scalar("select u_username from ngo_users where u_id='$check_rec_id'");
//if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "" .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Create/ Update Cheque </div></td>
  </tr>
</table>
<div align="right"><a href="cheque_list.php">Back to Cheque List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="check_id" value="<?=$check_id?>"  />
  <table width="90%" height="200" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
    <tr>
      <td width="22%" height="10"></td>
      <td width="78%"></td>
    </tr>
    <tr>
      <td align="right"><strong>User ID : </strong></td>
      <td class="tableDetails"><input name="check_username" type="text" id="check_username" value="<?=$check_username?>" alt="blank" emsg="Please enter user id " /></td>
    </tr>
	<tr>
      <td align="right"><strong>  Amount :</strong></td>
	  <td class="tableDetails"><input name="check_amount" type="text" id="check_amount"  value="<?=$check_amount?>" alt="blank" emsg="Please enter Amount " />
          <!--  <a href="#" onclick="javascript: convert_inword();">
        <input name="Submit_Convert" type="submit" id="Submit_Convert" value="Convert In Word"  />
        </a> -->      </td>
	  </tr>
	<tr>
      <td align="right" valign="top"><strong> Amount In word : </strong></td>
	  <!--alt="blank" emsg="Please enter amount in word "-->
      <td class="tableDetails"><textarea name="check_inword" cols="40" rows="3" id="check_inword" ><?=$check_inword?></textarea></td>
	  </tr>
	<tr>
      <td align="right"><strong>Payment Mode</strong></td>
	  <td class="tableDetails"><?=payment_mode_dropdown('check_payment_mode',$check_payment_mode)?>      </td>
	  </tr>
	<tr>
      <td align="right"><strong>Payment Type :</strong></td>
	  <td class="tableDetails"><? //=checktype_dropdown("check_type", $check_type)?>      <input name="check_type" type="text" id="check_type"  value="<?=$check_type?>" alt="blank" emsg="Please enter payment type " /></td>
	  </tr>
	<tr>
      <td align="right"><strong>Cheque No : </strong></td>
      <td class="tableDetails"><input name="check_cheque_no" type="text" id="check_cheque_no"  value="<?=$check_cheque_no?>" /></td>
    </tr>
   <!-- <tr>
      <td align="right" valign="top"><strong> AmountIn word : </strong></td> 
      <td class="tableDetails"><textarea name="check_inword" cols="40" rows="3" id="check_inword" ><?=$check_inword?></textarea></td>
    </tr>-->
    <tr>
      <td align="right"><strong>Cheque Date :</strong></td>
      <td class="tableDetails"><?=get_date_picker("check_date", $check_date)?>      </td>
    </tr>
    <tr>
      <td align="right"><strong>Bank Name:</strong></td>
      <td class="tableDetails"><input name="check_bank" type="text" id="check_bank"  value="<?=$check_bank?>" /> <? //=bank_dropdown('check_bank',$check_bank)?></td>
    </tr>
    
    <tr>
      <td align="right"><strong>Receiver ID/ Name : </strong></td>
      <td class="tableDetails"><input name="check_rec_id" type="text" id="check_rec_id"  value="<?=$check_rec_id?>" size="10" />
      <input name="check_rec_name" type="text" id="check_rec_name"  value="<?=$check_rec_name?>" /></td>
    </tr>
     <tr>
      <td align="right"><strong>Receive Date : </strong></td>
      <td class="tableDetails"> 
	  <!--<input name="check_rec_date" type="text" id="check_rec_date"  value="<? //=$check_rec_date?>" />-->
	  <?=get_date_picker("check_rec_date", $check_rec_date)?></td>
    </tr>
	<tr>
      <td align="right"><strong>Contact Number: </strong></td>
      <td class="tableDetails"> 
	  <input name="check_contact" type="text" id="check_contact"  value="<?=$check_contact?>" />       </td>
    </tr>
	<tr>
      <td align="right"><strong>Remark: </strong></td>
      <td class="tableDetails"> 
	  <textarea name="check_remark" cols="50" rows="5" id="check_remark"><?=$check_remark?></textarea>       </td>
    </tr>
	<tr>
      <td align="right"><strong> Cheque Status : </strong></td>
      <td class="tableDetails"><?=checkstatus_dropdown('check_status',$check_status)?></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel"><strong>Cheque For: </strong></td>
      <td class="tableDetails"><input name="check_for" type="text" id="check_for"  value="<?=$check_for?>" /></td>
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