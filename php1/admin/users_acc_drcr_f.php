<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
@extract($_POST);
 	$pay_userid = db_scalar("select u_id from ngo_users where u_username = '$pay_username' ");	
	
	if ($pay_userid!='' && $pay_amount!='') {
  		// Deduct registration charges from account
			$u_parent_id = db_scalar("select pay_id from ngo_users_payment  order by pay_id desc limit 0,1")+1;
			$pay_id_refno =  'K'.rand(100,999).$u_parent_id.rand(100,999);
		//	$pay_for =  $ARR_PAYMENT_TYPE[$pay_plan];
			$sql2 = "insert into ngo_users_payment set  pay_id_refno='$pay_id_refno',  pay_drcr='$pay_drcr',  pay_userid = '$pay_userid'  ,pay_group='$pay_group',pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = 'F' ,pay_rate = '100', pay_amount = '$pay_amount',pay_status='Unpaid' ,pay_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE) ";
			$result = db_query($sql2);
			
			
			/*$sql_test = "select u_username,u_fname,u_mobile  from   ngo_users  where  u_mobile!='' and u_id='$pay_userid'";
			$result_test = db_query($sql_test);
			$line_test= mysqli_fetch_array($result_test);
			@extract($line_test);
			
			$message =  "CONGRATULATION ".$u_fname." TODAY AMOUNT (Rs:".$pay_amount.") TRANSFERED IN YOUR ID:".$pay_username." FOR DETAILS PLZ LOGIN IN YOUR ACCOUNT, ".SITE_NAME; 
			#send_sms($u_mobile,$message);*/
				
				
			header("Location: users_acc_drcr_f.php?act=done");
			exit;
			
 		} else {
		$msg="Required fields are missing.!";
		}
		
 }			

if ($act=='done') { $msg="Transaction Completed successfully!";}
 
 ?>

<? include("top.inc.php");?>
 <link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">Credit/Debit Reward Wallet  </div></td>
  </tr>
</table>
<div align="right"><a href="users_acc_drcr_list.php">Back to Reward Wallet List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="errorMsg"><?=$msg?></td>
	    </tr>
 		 <tr>
	    <td align="right" class="tdLabel"> Username : </td>
	    <td class="tdData"><input type="text" name="pay_username" value="<?=$pay_username?>" alt="blank" emsg="Username can not be blank" /> 
	    Ex. marsh </td>
	    </tr>
		
	  <tr> 
	    <td width="20%" align="right" class="tdLabel">TotalAmount : </td>
	    <td width="80%" class="tdData">
		<input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />
 	    </td>
	    </tr>
	  <tr>
	    <td align="right" class="tdLabel">Transaction Type  : </td>
	    <td class="tdData">
			<?=array_dropdown($ARR_PAYMENT_GROUP, $pay_group, 'pay_group');?>
			 </td>
	    </tr>
		<tr>
	    <td align="right" class="tdLabel">Payment Type  : </td>
	    <td class="tdData">
			<?=array_dropdown($ARR_PAYMENT_TYPE, $pay_plan, 'pay_plan');?>
			 </td>
	    </tr>
		<tr>
	    <td align="right" class="tdLabel">Transaction Type Dr/Cr  : </td>
	    <td class="tdData">
			<select name="pay_drcr" alt="select" emsg="Transaction Type  can not be blank" >
			  <option>Please Select</option>
			  <option value="Cr">Credit(+)</option>
			  <option value="Dr">Debit(-)</option>
			  </select></td>
	    </tr>
      	    <tr>
     	      <td align="right" class="tdLabel">Transaction Date  : </td>
     	      <td class="tdData"><?=get_date_picker("pay_date", $pay_date)?></td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">Naration : </td>
     	      <td class="tdData"><textarea name="pay_for" cols="50" rows="4" alt="blank" emsg="Naration can not be blank" ><?=$pay_for?></textarea></td>
   	      </tr>
     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="code_id" value="<?=$code_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>