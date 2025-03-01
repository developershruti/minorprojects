<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
// Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_referal_details");
sajax_handle_client_request();
// END Ajax code
 protect_admin_page2();
if(is_post_back()) {
@extract($_POST);
 	$pay_userid = db_scalar("select u_id from ngo_users where u_username = '$pay_username' ");	
	
	if ($pay_userid!='' && $pay_amount!='') {
  		// Deduct registration charges from account
 			$paid_count = db_scalar("select count(*) as total_paid from ngo_users_ewallet where  pay_userid = '$pay_userid' and pay_drcr='Cr' ");
			$pay_for    = $pay_group ." Fund " .$pay_for;
			$sql2 = "insert into ngo_users_ewallet set  pay_drcr='$pay_drcr',pay_group='$pay_group',  pay_userid = '$pay_userid' ,pay_plan='$pay_plan' ,pay_for = '$pay_for'   ,pay_unit = 'Fix' ,pay_rate = '100', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
  			$result = db_query($sql2);
 			
			///DIRECT_LEVEL
			/*
			
			if($pay_plan=='PAID_FUND' && $pay_drcr=='Cr' ){ 
  				$u_ref_userid = $pay_userid;
 						$ctr=0;
						while ($ctr<=5) { 
						$ctr++;
 						$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
						if ($u_ref_userid!='' && $u_ref_userid!=0 ){
						$acc_balance =  db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_ewallet where pay_userid='$u_ref_userid'")+0;
						if($acc_balance>=500) {
						if($paid_count==0){
							if($ctr==1){ $pay_rate =10;}
							else if($ctr==2){ $pay_rate =5;}
							else if($ctr==3){ $pay_rate =3;}
							else if($ctr==4){ $pay_rate =1;}
							else if($ctr==5){ $pay_rate =1;}
						} else {
							if($ctr==1){ $pay_rate =5;}
							else if($ctr==2){ $pay_rate =2;}
							else if($ctr==3){ $pay_rate =1;}
							else if($ctr==4){ $pay_rate =1;}
							else if($ctr==5){ $pay_rate =1;}
						}						
							$pay_amount_ref = ($pay_amount/100)*$pay_rate;
 							$pay_for ="Referral Reward Level $ctr";
							$sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$bid_userid' ,pay_topupid='$pay_topupid',pay_plan='LEVEL_INCOME' ,pay_group='$pay_group' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount_ref' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='SPOT' ";
						//	db_query($sql2);
						 }
						} 
					}
			}
			
			*/
				/*$sql_test = "select u_username,u_fname,u_mobile  from   ngo_users  where  u_mobile!='' and u_id='$pay_userid'";
 				$result_test = db_query($sql_test);
				$line_test= mysqli_fetch_array($result_test);
				@extract($line_test);
				
				$message =  "CONGRATULATION ".$u_fname." TODAY AMOUNT (Rs:".$pay_amount.") TRANSFERED IN YOUR ID:".$pay_username." FOR DETAILS PLZ LOGIN IN YOUR ACCOUNT, ".SITE_NAME; 
			   // send_sms($u_mobile,$message);*/
				
				
			header("Location: users_ewallet_drcr_f.php?act=done");
			exit;
			
 		} else {
		$msg="Required fields are missing.!";
		}
		
 }			

if ($act=='done') { $msg="Transaction Completed successfully!";}
 
 ?>

<? include("top.inc.php");?>

<script language="javascript">
<? sajax_show_javascript(); ?>
 
     //------check ref availability code start------------------------------------------------
 function do_get_referal_details() {
	document.getElementById('referal_details').innerHTML = "Loading...";
	ref_userid= document.form1.pay_username.value;
	x_get_referal_details('referal_details', ref_userid, do_get_referal_details_cb);
 }
function do_get_referal_details_cb(z) {
  	document.getElementById('referal_details').innerHTML = z;
 }  
 
 
   </script>
 <link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">Credit/Debit in Fund Wallet </div></td>
  </tr>
</table>
<div align="right"><a href="users_ewallet_drcr_list.php">Back to Fund Wallet List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="errorMsg"><?=$msg?></td>
	    </tr>
	 
		 <tr>
	    <td align="right" class="tdLabel">   Username : </td>
	    <td class="tdData"><input type="text" name="pay_username" value="<?=$pay_username?>" alt="blank" emsg="Username can not be blank"  onChange="do_get_referal_details();"/>	 <div align="left" id="referal_details"  class="errors"> </div> 	    </td>
	    </tr>
		
	  <tr> 
	    <td width="20%" align="right" class="tdLabel">Total Amount : </td>
	    <td width="80%" class="tdData">
		<input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" /> 	    </td>
	    </tr>
	  <tr>
	    <td align="right" class="tdLabel">Payment Group</td>
	    <td class="tdData"><? echo  array_dropdown($ARR_WALLET_GROUP,$pay_group,'pay_group',$extra); //echo payment_processor_dropdown($pay_group,$extra); ?></td>
	    </tr>
		 <tr>
	    <td align="right" class="tdLabel">Payment Type</td>
	    <td class="tdData"><? echo  array_dropdown($ARR_WALLET_TYPE_ADM,$pay_plan,'pay_plan',$extra); //echo payment_processor_dropdown($pay_group,$extra); ?></td>
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