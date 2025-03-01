<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
@extract($_POST);
 	$pay_userid = db_scalar("select u_id from ngo_users where u_username = '$pay_username' ");	
	
	if ($pay_userid!='' && $pay_amount!='') {
  		// Deduct registration charges from account
 			 $pay_for = $pay_group ." ".$pay_for;
  			 $sql2 = "insert into ngo_users_coin set  pay_drcr='$pay_drcr',pay_group='$pay_group_coin',  pay_userid = '$pay_userid' ,pay_plan='ADM_COIN' ,pay_for = '$pay_for'   ,pay_unit = 'Fix' ,pay_rate = '100', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
  			$result = db_query($sql2);
			
			
				/*$sql_test = "select u_username,u_fname,u_mobile  from   ngo_users  where  u_mobile!='' and u_id='$pay_userid'";
 				$result_test = db_query($sql_test);
				$line_test= mysqli_fetch_array($result_test);
				@extract($line_test);*/
				
				//$message =  "CONGRATULATION ".$u_fname." TODAY AMOUNT (Rs:".$pay_amount.") TRANSFERED IN YOUR ID:".$pay_username." FOR DETAILS PLZ LOGIN IN YOUR ACCOUNT, ".SITE_NAME; 
			   // send_sms($u_mobile,$message);
				
				
			header("Location: users_coin_f.php?act=done");
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
    <td id="pageHead"><div id="txtPageHead">Credit/Debit User  Coin account </div></td>
  </tr>
</table>
<div align="right"><a href="users_ewallet_drcr_list.php">Back to code List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="errorMsg"><?=$msg?></td>
	    </tr>
	 
		 <tr>
	    <td align="right" class="tdLabel">   Username : </td>
	    <td class="tdData"><input type="text" name="pay_username" value="<?=$pay_username?>" alt="blank" emsg="Username can not be blank" />	    </td>
	    </tr>
		
	  <tr> 
	    <td width="20%" align="right" class="tdLabel">Total Token : </td>
	    <td width="80%" class="tdData">
		<input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit Token can not be blank" /> 	    </td>
	    </tr>
	 <tr>
	    <td align="right" class="tdLabel">Total Group</td>
	    <td class="tdData"><?  echo  array_dropdown($ARR_COIN_GROUP,$pay_group_coin,'pay_group_coin',$extra); //echo payment_processor_dropdown($pay_group,$extra); ?></td>
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
	    <td class="tdData"> 
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>