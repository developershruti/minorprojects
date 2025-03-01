<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
      //  check_userid, check_bank, check_amount, check_inword, check_date, check_status, check_rec_name, check_rec_date from eversmiletm.ngo_cheque_return
//print_r($_POST);
 		 
		$check_inword = "Rs. " .convert_number($check_amount). " only" ;
 		if ($check_id!='') {
			$sql = "update ngo_cheque_return set  check_userid='$check_userid' ,check_cheque_no='$check_cheque_no',check_bank='$check_bank' ,check_amount='$check_amount' ,check_inword='$check_inword' , check_date='$check_date' , check_type='$check_type', check_rec_id='$check_rec_id', check_rec_name='$check_rec_name',check_rec_date='$check_rec_date' ,check_contact='$check_contact' ,check_remark='$check_remark',check_editby = '$_SESSION[sess_admin_login_id]' ,check_edit_date = now()  where check_id='$check_id'";
			db_query($sql);
			header("Location: cheque_return_list.php");
			exit;
 		} else {
		 	$total_ref = db_scalar("select count(check_id) from ngo_cheque_return where check_bank='$check_bank' and check_cheque_no='$check_cheque_no'");
			if ($total_ref !=0) { $msg  =  "Already a record exist with same cheque number and bank name !";} 
			else {
 			$sql = "insert into ngo_cheque_return set  check_userid='$check_userid',check_bank='$check_bank' ,check_cheque_no='$check_cheque_no' ,check_amount='$check_amount' ,check_inword='$check_inword' , check_date='$check_date' , check_type='$check_type', check_rec_id='$check_rec_id', check_rec_name='$check_rec_name', check_rec_date='$check_rec_date',check_contact='$check_contact' ,check_remark='$check_remark' ,check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now() ";
			db_query($sql);
			header("Location: cheque_return_list.php");
			exit;
			}
   		}
 }
 

$sql = "select * from ngo_cheque_return where  check_id ='$check_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);

//if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "Rs. " .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Add/ update Cheque Return </div></td>
  </tr>
</table>
<div align="right"><a href="cheque_return_list.php">Back to Cheque Return List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="check_id" value="<?=$check_id?>"  />
  <table width="90%" height="200" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
    <tr>
       
      <td  colspan="2" class="errorMsg"><?=$msg?></td>
    </tr>
    <tr>
      <td width="194" align="right"><strong>Cheque User ID : </strong></td>
      <td width="788" class="tableDetails"><input name="check_userid" type="text" id="check_userid" value="<?=$check_userid?>" alt="blank" emsg="Please enter user id " /></td>
    </tr>
	<tr>
      <td align="right"><strong>Cheque No : </strong></td>
      <td class="tableDetails"><input name="check_cheque_no" type="text" id="check_cheque_no"  value="<?=$check_cheque_no?>" /></td>
    </tr>
    <tr>
      <td align="right"><strong>Cheque Bank Name:</strong></td>
      <td class="tableDetails"><?=bank_dropdown('check_bank',$check_bank)?></td>
    </tr>
    <tr>
      <td align="right"><strong>Cheque Amount :</strong></td>
      <td class="tableDetails"> 
        <input name="check_amount" type="text" id="check_amount"  value="<?=$check_amount?>" alt="blank" emsg="Please enter Amount " /> 
        <a href="#" onclick="javascript: convert_inword();"></a>  </td>
    </tr>
    
  <tr>
      <td align="right"><strong>Cheque Date :</strong></td>
      <td class="tableDetails"> <?=get_date_picker("check_date", $check_date)?>       </td>
    </tr>
    <tr>
      <td align="right"><strong>Cheque Type :</strong></td>
      <td class="tableDetails"> <?=checktype_dropdown("check_type", $check_type)?>       </td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td class="tableDetails">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><strong>Return ID/ Name : </strong></td>
      <td class="tableDetails"><input name="check_rec_id" type="text" id="check_rec_id"  value="<?=$check_rec_id?>" size="10" />
      <input name="check_rec_name" type="text" id="check_rec_name"  value="<?=$check_rec_name?>" /></td>
    </tr>
     <tr>
      <td align="right"><strong>Return Date : </strong></td>
      <td class="tableDetails"> 
	 <!-- <input name="check_rec_date" type="text" id="check_rec_date"  value="<? //=$check_rec_date?>" />-->
        <?=get_date_picker("check_rec_date", $check_rec_date)?> </td>
    </tr>
	<tr>
      <td align="right"><strong>Contact Number: </strong></td>
      <td class="tableDetails"> 
	  <input name="check_contact" type="text" id="check_contact"  value="<?=$check_contact?>" />       </td>
    </tr>
	<tr>
      <td align="right" valign="top"><strong>Return Purpose : </strong></td>
      <td class="tableDetails"> 
	  <textarea name="check_remark" cols="50" rows="5" id="check_remark"><?=$check_remark?></textarea>       </td>
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