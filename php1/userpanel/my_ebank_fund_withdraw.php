<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL); 
include ("../includes/surya.dream.php");
protect_user_page();
$arr_error_msgs = array();
/*
if ($_SESSION['sess_security_code2']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code_otp.php");
	 exit;
  }
 #print_r($_POST);
*/
 if ($_SESSION['sess_security_code']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code.php");
	 exit;
} 
  
/* if ($_SESSION['sess_security_code']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code.php");
	 exit;
	} */ 
 /*
$data_day = db_scalar("select DATE_FORMAT(DATE_ADD( NOW() , INTERVAL '12:30' HOUR_MINUTE ), '%d')  as date");
if ($data_day!='01' && $data_day!='11' && $data_day!='21') {
 	 $arr_error_msgs[] = "Bank withdrawal request open  on 1st 11th and  21st of every month!";
}
*/

#$arr_error_msgs[] = "Team is working on RIP Token withdraw functionality, please wait for a while ";
 #$open_time = db_scalar("SELECT DATE_FORMAT( ADDDATE( NOW( ) , INTERVAL 570 MINUTE ) ,  '%T' ) AS time");
#if ($open_time<='11:00:00' || $open_time>='16:00:00') {$arr_error_msgs[] =  'Fund withdrawal request open only  between 11.00 AM to 4.00 PM!'; } 

/*$open_time = db_scalar("SELECT DATE_FORMAT( ADDDATE( NOW( ) , INTERVAL 330 MINUTE ) ,  '%T' ) AS time");
if ($open_time<='11:00:00' || $open_time>='18:00:00') { 
	$arr_error_msgs[] =  'Dear Particient, We are facing issue when we process bank withdrawal in night because most of bank IMPS/NEFT services rejected or failed in night,  please  submit your Fund withdrawal request between 11.00 AM to 6.00 PM! so that we can process all request in day time. ';
 } 
*/ 
#if ($pay_group=='') { $arr_error_msgs[] =  "Something Went Wrong Please Try Again!" ;}
# if ($pay_group!='') { $sql_part ="  and pay_group='$pay_group'";}

 ///if ($pay_plan!='') { $sql_part ="  and pay_plan='$pay_plan'";}
 //  and pay_group='$pay_group'
$acc_balance =  db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' $sql_part ");
//$acc_balance=3000;
///check Total Direct 
 /*$total_direct= db_scalar("select  count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and topup_amount>='20.00'  and u_ref_userid ='$_SESSION[sess_uid]' ")+0;
  if ($total_direct < 4) { 
  	$arr_error_msgs[] =  "4 Direct Sponsor Compulsory To make withdraw" ;  
 	
  }*//*$stop='stop';*/

///check Total Direct  start
/* $total_direct= db_scalar("select  count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and topup_amount>='30.00'  and u_ref_userid ='$_SESSION[sess_uid]' ")+0;
 
  if ($total_direct < 4) { 
  	$arr_error_msgs[] =  "4 Direct Sponsor Compulsory for make Withdraw" ;  
 	//$stop='stop'; 
  }*/
     
if ($acc_balance <1) { 
  	$arr_error_msgs[] =  "Insufficient account balance for Withdrawal" ;  
 	$stop='stop';
}

#$u_bank_acno = db_scalar("select u_bank_acno from ngo_users where  u_id='$_SESSION[sess_uid]' limit 0,1"); 
#if ($u_bank_acno=='') {$arr_error_msgs[] =  "Please update your Bank account details before Withdrawal" ;  } 
 
if($pay_unit=='Bank') { 
	
	//$arr_error_msgs[] =  "Bank Withdrawal Comming Soon..." ;
	 //$u_bank_acno = db_scalar("select u_bank_acno from ngo_users where  u_id='$_SESSION[sess_uid]' limit 0,1"); 
	//if ($u_bank_acno=='') {$arr_error_msgs[] =  "Please update your Bank account details before Withdrawal" ;  } 
} else if($pay_unit=='USDT') { 

} 
	$u_bitcoin = db_scalar("select u_bitcoin from ngo_users where  u_id='$_SESSION[sess_uid]' limit 0,1"); 
	if ($u_bitcoin=='') {$arr_error_msgs[] =  "Please update your USDT Wallet Address before Withdrawal" ;  }  

 
// $MINIMUM_FUND_WITHDRAWAL  = db_scalar("select sett_value from ngo_setting where sett_code = 'MINIMUM_FUND_WITHDRAWAL'"); 
if(is_post_back()) { 
 // check user name
$topup_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$_SESSION[sess_uid]'");
if ($topup_count==0) { $arr_error_msgs[] =  " Your account is not Active, please activate your account !  " ;} 
if ($acc_balance<$pay_amount) { $arr_error_msgs[] = "Insufficient account balance for transfer"; } 
if ($pay_amount<=0) { $arr_error_msgs[] = "Invalid Amount, You can't transfer it "; }

/*
$MINIMUM_FUND_WITHDRAWAL  = db_scalar("select sett_value from ngo_setting where sett_code = 'MINIMUM_FUND_WITHDRAWAL'"); 
if ($pay_amount<$MINIMUM_FUND_WITHDRAWAL) { $arr_error_msgs[] = "<br>Minimum bank withdraw amount is ". price_format($MINIMUM_FUND_WITHDRAWAL); }
 */
$min_withdraw_amount = 2; 
if ($pay_amount<$min_withdraw_amount) { $arr_error_msgs[] =  "Minimum withdrawal amount is ".price_format($min_withdraw_amount) ;}
 
$pay_date = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL 330 MINUTE), '%Y-%m-%d')");
$withdrawal_count = db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$_SESSION[sess_uid]'  and pay_plan='FUND_WITHDRAW' and pay_date='$pay_date' ")+0;
if ($withdrawal_count>=1) { $arr_error_msgs[] = "You can take one withdrawal in a day, please try withdrawal next day "; }

$withdrawal_count = db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$_SESSION[sess_uid]'  and pay_plan='FUND_WITHDRAW' and pay_status='Unpaid' ")+0;
if ($withdrawal_count>=1) { $arr_error_msgs[] = "A withdraw request already under process, please wait till pending withdraw request processed successfully. "; }

if ($pay_amount<$MINIMUM_FUND_WITHDRAWAL) { $arr_error_msgs[] = "<br>Minimum withdraw amount is ". price_format($MINIMUM_FUND_WITHDRAWAL); }
if (count($arr_error_msgs) ==0) {
	if ($_POST['Submit']=='Continue') {
		$arr_error_msgs[] = "Are you sure want to  withdraw ?";
		$action = 'Continue';
		/*if ( $pay_group=='WI' ) { 
 			$tds_pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='DEDUCTION' limit 0,1");
			
 	 	}*/
		$tds_pay_rate =0;
   	} else if  ($_POST['Submit']=='Confirm Payment') {
		$action = 'Confirm';
	//print_r($_POST);
		$pay_ref_amt = $pay_amount;
		//if ( $pay_group=='WI' ) { }
		//$tds_pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='DEDUCTION' limit 0,1");
		$tds_pay_rate =0;
 		$tds_pay_amount = ($pay_amount/100)*$tds_pay_rate;
		
		//if ($tds_pay_amount<8) { $tds_pay_amount = '8';} 
		
		$pay_rate = 100 -$tds_pay_rate; 
		$withdraw_pay_amount = ($pay_amount-$tds_pay_amount);
		
		
		$pay_for1 = "Withdrawal Request".$pay_for;
		$sql2 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$_SESSION[sess_uid]' ,pay_plan='FUND_WITHDRAW' ,pay_group='$pay_group' ,pay_transaction_no='$pay_plan' ,pay_for = '$pay_for1' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '$pay_unit' ,pay_rate = '$pay_rate', pay_amount = '$withdraw_pay_amount',pay_status='Unpaid' ,pay_date='$pay_date' ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql2);
		$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
 
		if($tds_pay_amount>0) {
		$pay_for2 = "Deduction @ $tds_pay_rate % on ".price_format($pay_ref_amt)." - ".$pay_for;
 		$sql2 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_refid' ,pay_plan='DEDUCTION' ,pay_group='$pay_group',pay_transaction_no='$pay_plan' ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '$pay_unit' ,pay_rate = '$tds_pay_rate', pay_amount = '$tds_pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql2);
    } 
	
	/////////////auto payment/////////////
	
$SERVICE_STATUS  = 1;// round(db_scalar("select sett_value from ngo_setting where sett_code = 'WITHDRAWAL_AUTO_PAID'"),0); 
if ($SERVICE_STATUS=='1') { 

	if($withdraw_pay_amount<=20) { 
	
	
$usdtAmount = $withdraw_pay_amount  ; // 0.01;
$toAddress  = db_scalar("select u_bitcoin from ngo_users where u_id = '$_SESSION[sess_uid]'"); //'0xe486164910D90610092B6e33dDd0b729BbE4f54f';//
///admin withdrawal wallet address from usdt swap out
$adminAddress 	 = '0xfdcd1AAae16791d12181eF4E3bF2af9399FE8Ef0';
$adminPrivateKey = '7b7a2a597dbc5e9705fcb4ab759916fdbe78ee716abd47df79b14563c84b0414';
  
  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://13.233.68.158:3000/withdraw_usdt',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'amount='.$usdtAmount.'&address='.$toAddress.'&admin_address='.$adminAddress.'&private_key='.$adminPrivateKey.'',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
  ),
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_SSL_VERIFYHOST => false,
));

$response = curl_exec($curl);
if ($response === false) {
   	$arr_error_msgs[] = 'Curl error: ' . curl_error($curl);
 } else {
 	$jsonRes= json_decode($response);
	  /* echo '<pre>';
	  print_r($jsonRes);
	  echo '</pre>';  */
	 
	  
	$from =$jsonRes->data->from;
	$to =$jsonRes->data->to;
	$status =$jsonRes->data->status;
	$transactionHash =$jsonRes->data->transactionHash;
     if($transactionHash!='') {
  		$sql3 = "update ngo_users_payment set  pay_transaction_no='$transactionHash'  ,pay_status='Paid' ,pay_admin='Auto' ,pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE) where pay_id='$pay_refid'";
		db_query($sql3);
		$arr_error_msgs[] =" Withdrawal request processed successfully, please check your bank account for details.";
		$arr_error_msgs[] =" Txn Hash:".$transactionHash;
	}
  // echo json_encode("bnb_success");
 // die;
}

curl_close($curl);
 
	
	}
 }
		////////////end//////////////////
		
    
    ///////////IMPS///////////
    if ($withdraw_pay_amount<=100) { 
    ///$imps_amount = round($withdraw_pay_amount*70,0);
   /// bizz91_send_payout($_SESSION['sess_username'],$imps_amount,$pay_refid);
    }


    ///////////IMPS END////////
    //$message = "Dear Admin Rozipay User ID ".$_SESSION['sess_username']."  Request for a withdrawal of amount   ".$withdraw_pay_amount." - ".SITE_URL;
    //$msg= send_sms('9999559375',$message);
		
if($pay_unit=='Bank') { 
  //$arr_error_msgs[] ="Your Bank Withdrawal request processed successfully, please check your bank account for details.";
   $success_msg =" Withdrawal request processed successfully, please check your bank account for details.";
} else if($pay_unit=='USDT') { 
	$arr_error_msgs[] =" Withdrawal request submited  successfully, It will be processed shortly. ";
} 


		 
 	 	
	 
	 
	}
}
} 
$_SESSION['arr_error_msgs'] = $arr_error_msgs;

?>
<!doctype html>
 <html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
 
<head>
<? include("includes/extra_head.php")?>

</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
   <? include("includes/header.inc.php")?>
   <!-- ========== App Menu ========== -->
   <? include("includes/sidebar.php")?>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0">Withdraw Request</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Withdraw</a></li>
                  <li class="breadcrumb-item active">Withdraw Request</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
		 <? include("error_msg.inc.php");?>
          <div class="col-xxl-6 centered">
		  
            <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Withdrawal Request</h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 
                <div class="live-preview">
 
 
  
                    <p align="center" style="color:#0000000">
                      <? include("error_msg.inc.php");?>
                    </p> 
                <? 
			// $FUND_WITHDRAWAL_STATUS  = round(db_scalar("select sett_value from ngo_setting where sett_code = 'FUND_WITHDRAWAL_STATUS'"),0); 
			  $FUND_WITHDRAWAL_STATUS =1;
			 if ($FUND_WITHDRAWAL_STATUS=='1') { ?>
                  <form method="post" name="form1" id="form1" class="send-form-style2 send-form-style"  <?= validate_form()?>>
                     <table  width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="table table-striped"  style="width:100%;"  >

                     <?   if ($status == '')  { ?>

                     

                      <tr>
                      
                        <td width="100%" style="text-align:left" colspan="2"><strong>
                         <h3> <?php   echo $success_msg ; ?> </h3>
                          </strong></td>
                      </tr>

       <? }
       
       if ($action == '')  { ?>
					 <?php /*?><thead>
					  <tr class="tdhead">
                        <th colspan="2"><strong>Withdrawal Request </strong></th>
                      </tr>
                      </thead><?php */?>
                     
                      <tr>
                        <td   nowrap="nowrap" style="text-align:right">   <? //=$ARR_PAYMENT_TYPE[$pay_group];?> Account Balance : </td>
                        <td width="60%" style="text-align:left"><strong>
                          <?php   echo  price_format($acc_balance+0) ; ?>
                          </strong></td>
                      </tr>
                      <!--
                      <tr>
                        <td width="40%" style="text-align:right">Withdrawal  Mode : </td>
                        <td width="60%" style="text-align:left"><div class="form-element">
						 <select name="pay_unit"   class="form-control" alt="select" emsg="Please select Mode" required >
                            <option value="" >Please Select Mode</option>
                           <option value="Bank" <? if ($pay_unit=='Bank') { echo 'selected="selected"';} ?>>Bank</option> 
							 <option value="Bitcoin" <? if ($pay_unit=='Bitcoin') { echo 'selected="selected"';} ?>>Bitcoin</option>
							 
                          </select>
						  </div>
					    </td>
					   </tr> -->
                      <tr>
                        <td   style="text-align:right">Withdrawal  Amount : </td>
                        <td   style="text-align:left"> <input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" style="width:200px;" emsg="Amount can not be blank" />  <div class="form-element">
                          <?php /*?><select name="pay_amount"  class="form-control"  alt="select" emsg="Please select amount"  required>
                            <option value="" >Please Select</option>
                            <? 
 					$ctr = 1;
					#$ctr2= 100;
					$amount2 =15;
					while ($ctr<=20) { 
					$amount = $ctr*$amount2;
					//$amount += $amount;
					$ctr++;
					
					?>
                            <option value="<?=$amount?>" <? if ($amount==$pay_amount) { echo 'selected="selected"';} ?>>
                            <?=price_format($amount)?>
                            </option>
                            <? } ?>
                          </select><?php */?> </div>
                        </td>
                      </tr>
                      <!--<tr>
                        <td style="text-align:right" valign="top">Note: </td>
                        <td style="text-align:left"><div class="form-element"><textarea name="pay_for" class="form-control" cols="50"   rows="3" alt="blank" emsg="Naration can not be blank"  required ><?=$pay_for?>
</textarea> </div></td>
                      </tr>-->
                      <tr>
                        <td>&nbsp;</td>
                        <td height="30" style="text-align:left"><? if ($stop=='') {?>
                          <input type="hidden" name="pay_group" value="<?=$pay_group?>">
						  <!--<input type="hidden" name="pay_plan" value="<?=$pay_plan?>">-->
                          <input name="Submit" type="submit" class="btn btn-primary  "  value="Continue" />
                         <!-- &nbsp;&nbsp;
                          <input name="Reset" type="reset"  value=" Reset " />-->
                          <?  } ?>
                        </td>
                      </tr>
                      <? } else if ($action == 'Continue') { ?>
                      <!-- <tr>
                         <td style="text-align:right">Plan Name : </td>
                         <td style="text-align:left"><strong>
                           <?php   //echo  $plan; ?>
                         </strong></td>
                      </tr>-->
                     <?php /*?> <thead>
					  <tr class="tdhead">
                        <th colspan="2"><strong>Withdrawal Request Confirmation </strong></th>
                      </tr>
                      </thead><?php */?>
                      <tr>
                        <td style="text-align:right"> Account Balance : </td>
                        <td style="text-align:left"><strong>
                          <?php   echo  price_format($acc_balance) ; ?>
                          </strong></td>
                      </tr>
                      <!--
                       <tr>
                        <td width="40%" style="text-align:right">Withdrawal  Mode : </td>
                        <td width="60%" style="text-align:left"><input type="hidden" name="pay_unit" value="<?=$pay_unit?>"   />
                           <?=$pay_unit?> 
                        </td>
                      </tr> -->
                      <tr>
                        <td width="40%" style="text-align:right">Withdrawal  Amount : </td>
                        <td width="60%" style="text-align:left"><input type="hidden" name="pay_amount" value="<?=$pay_amount?>"   />
                          <? echo price_format($pay_amount); if ($tds_pay_rate>0) {?> (  Deduction@
                          <?=$tds_pay_rate?>
                          %)
                          <? } ?>
                        </td>
                      </tr>
                      <tr>
                      <!--  <td style="text-align:right" valign="top">Note: </td>
                        <td style="text-align:left"><input type="hidden" name="pay_for" value="<?=$pay_for?>" />
                          <?=$pay_for?>
                        </td>
                      </tr>-->
                      <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:left"><input type="hidden" name="pay_group" value="<?=$pay_group?>">
						 <!--<input type="hidden" name="pay_plan" value="<?=$pay_plan?>">-->
                          <input name="Submit" type="submit" class="btn btn-primary  " value="Confirm Payment" />
                        </td>
                      </tr>
                      <? }  ?>
                    </table>
                  </form>
			   
			   
                  <?  } else { ?>
                  <br />
                  <br />
                 
                  <br />
                  <span class="error">Withdrawal request closed.</span>
                  <?  }  ?>
				  
				  
    </div>
                 
              </div>
            </div>
          </div>
          <!-- end col -->
          
        </div>
        <!--end row-->
        
      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
      <? include("includes/footer.php")?>
  </div>
  <!-- end main content-->
</div>
<!-- END layout-wrapper -->
<? include("includes/extra_footer.php")?>
</body>
 
</html>
