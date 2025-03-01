<?php
include ("../includes/surya.dream.php");
 protect_user_page();
 $arr_error_msgs = array();
 
 

if($action == '') {
   
 		$new_address=   $ARR_BEP20_ADDRESS[$_SESSION['sess_BEP20']];//'0xb70F4Ae0e4Cd83C85BF96211cCeb46299824619B';
}
///$pgs='buy_token';
 
 if(is_post_back()) {
 	@extract($_POST);
  if ($action == 'Submit')  {
  
    $u_bitcoin = strtolower(db_scalar( "select u_bitcoin from ngo_users where  u_id ='$_SESSION[sess_uid]'"));
    if ($u_bitcoin=='') { $arr_error_msgs[] =  "Must be update your USDT BEP20 Address to proceed it.";}
  		if ($pay_trnid=='') { $arr_error_msgs[] =  "Submit Txn ID for complete transaction";}
		//$pay_amount = $pay_amount +($pay_amount/100)*1;
		 $deposit_count = db_scalar("select count(*) from ngo_coinpayment where pay_group='BEP20' and pay_trnid='$pay_trnid'");
		 if ($deposit_count >0) { $arr_error_msgs[] =  "Txn ID already submitted, please check and submit ";}
		
		
		
		 /////////////////////////////////////
		 		
// check payment details on bscscan  start /////////////////////	 $ARR_BEP20_ADDRESS[2]; 
  $toAddress =   $ARR_BEP20_ADDRESS[$_SESSION['sess_BEP20']];// "0xb70F4Ae0e4Cd83C85BF96211cCeb46299824619B"; //$_GET['toAddress']; //'0xe6b54DC91A8e540e0769c385766fF93c07Fa4dC5';
  $txnhash = $pay_trnid; //db_scalar("select topup_code from ngo_users_recharge2 where topup_userid = '$u_id' and  topup_amount=0.10");
  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => '13.233.68.158:3000/checkhash',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'{
   "hash":"'.$txnhash.'","address":"'.$toAddress.'"  
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
if ($response === false) {
   $arr_error_msgs[] = 'Curl error: ' . curl_error($curl);
 } else {
 	$jsonRes= json_decode($response);
	 
	 /*echo '<pre>';
	print_r($jsonRes);
	echo '</pre>'; 
	exit;
	
	*/
 
/*
stdClass Object
(
    [data] => stdClass Object
        (
            [transferAmount] => 1.1
            [value] => 0
            [from] => 0xF18bef8865703a993258B99b61b04158ea88dC2D
            [recipientAddress] => 0x909e085086b8aB9138c0EdE0703c805b831d18B8
            [status] => success
        )

)
*/			
			
	$amount_usdt  =$jsonRes->data->transferAmount +0;
	$amount_bnb =$jsonRes->data->value;
	$from_address  =strtolower($jsonRes->data->from);
	$recipientAddress  =strtolower($jsonRes->data->recipientAddress);
	$status =$jsonRes->data->status;
  }

curl_close($curl);
 	
	if ($u_bitcoin!=$from_address) { $arr_error_msgs[] =  "Wrong sender account address, you can't  proceed it.";}
	if($status!='success'){  $arr_error_msgs[] =  "Something went wrong, please try again."; }
	
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		 if (count($arr_error_msgs) ==0) {
		 
		 	 
		 if($status=='success'){ 
 	//	$pay_amount=0;
	
	$total_count1 = db_scalar("select count(*) from ngo_coinpayment where pay_trnid='$pay_trnid' and pay_group='BEP20'");
         if($total_count1==0 ) {
 		  $sql = "insert into ngo_coinpayment set pay_userid='$_SESSION[sess_uid]' ,pay_group='BEP20', pay_amount='$amount_usdt' , pay_ref_amt1='$pay_amount', pay_ipntype='$from_address' ,pay_trnid='$pay_trnid' , pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) , pay_txn_date=ADDDATE(now(),INTERVAL 330 MINUTE), pay_datetime=ADDDATE(now(),INTERVAL 330 MINUTE),pay_status='Paid',pay_currency1='USDT',pay_currency2='USDT'";
		db_query($sql);
 		$pay_id = mysqli_insert_id($GLOBALS['dbcon']);
		// pay_userid = '$_SESSION[sess_uid]' and 
		 $total_count2 = db_scalar("select count(*) from ngo_users_ewallet where pay_transaction_no='$pay_trnid'  and pay_plan='BEP20USDT'");
         if($total_count2==0 ) {
  			$pay_for = "Deposit TXN ID:".$pay_trnid;
			// $pay_amount_usdt = round(($pay_amount/14.2),2);
             $sql = "insert into ngo_users_ewallet set  pay_userid = '$_SESSION[sess_uid]', pay_drcr='Cr', pay_group='CW', pay_unit = '$pay_ipntype' , pay_refid = '$pay_id' ,pay_plan='BEP20USDT' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount'  ,pay_rate = '100', pay_amount = '$amount_usdt',pay_status='Paid',pay_transaction_no='$pay_trnid', pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE)  ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
         db_query($sql);
		 $pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
	 
		 header("location:deposit_process_history?action=done");
 		 exit;
		}
		}
 	}
 		 
	 }
  }
}

$_SESSION['arr_error_msgs'] = $arr_error_msgs;
/* $sql = "select * from ngo_deposit_req where  creq_id ='$creq_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
*/
  
  
  
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
              <h4 class="mb-sm-0">USDT Deposit</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">My Wallet</a></li>
                  <li class="breadcrumb-item active">USDT Deposit </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <!--end row-->
       <div class="row">
          <div class="col-lg-12">
            <div class="card newbordercolor">
              <div class="card-body">
			  
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p>  
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  >
					<tr>
                        <td   align="left" valign="top" >
	<br><strong>1. Copy address :</strong>  Copy the deposit address. 
    <br><strong>2. Initiate a withdrawal :</strong> Initiate a withdrawal on the withdrawal platform. 
	<br><strong>3. Network confirmation  :</strong> Wait for the blockchain network to confirm your transfer.  
	<br><strong>4. Deposit successful:</strong>  After the network confirmation, we will credit the crypto for you.  
 
						</td>
						</tr>
                      <tr>
                        <td   align="left" valign="top" >
				
<p style="color:#FFFF00; font-size:16px;">
<br>Please update your BSC (BEP20) wallet address with a decentralized wallet provider, such as MetaMask, SafePal, Trust Wallet, etc. 
<br>Warning: Do not use exchange or hot wallet addresses like Binance, Bybit, Kraken, etc., as this may lead to transaction issues.
</p>
						<? 
						
						//print $_SESSION['sess_BEP20'];
						
						
		 ///  $FUND_DEPOSIT_STATUS  = round(db_scalar("select sett_value from ngo_setting where sett_code = 'FUND_DEPOSIT_STATUS'"),0); 
		  $FUND_DEPOSIT_STATUS =1;
		if ($FUND_DEPOSIT_STATUS=='1') { ?>
                          <br />
                          <?   if ($action == '')  { ?>
                          <form method="post" name="form1" id="form1"  <?= validate_form()?>>
                            <table width="100%"  border="0" cellpadding="1" cellspacing="1" class="td_box">
                              <tr>
                                <td align="left" colspan="2"> 
								 
								
								<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?=$new_address?>&choe=UTF-8" width="220" height="220" /> 
								<!--<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?=$new_address?>&choe=UTF-8" width="220" height="220" /> 
                                  <p align="left" class="on-mobile-text-center"><br>-->
							    </td>
                              </tr>
                              <tr>
                               
							    <td width="21%" align="left">BEP20 USDT Deposit Address : </td>
								 <td align="left">
								  
                                    
                                    <span style="color:#000; float:left;">
                                    <input class="on-mobile-input" style="width:auto; width:450px; background:none; color:#fff; border:none;" type="text" value="<?=$new_address?>" readonly="" id="myInput1">
                                </span> <a style="cursor:pointer; padding:.6rem .9rem; margin-left:0px; margin-top:-5px;margin-right:10px; float:left;" title="Copy Link" onClick="myFunctionCopy3()" class="badge btn-primary"><i class="bx bx-copy text-dark"></i>  </a><!--<i class="fa fa-copy" onClick="myFunctionCopy3()" style="color:#ffd000; cursor:pointer;"></i>--></p></td>
                              </tr>
                              <tr>
                                <td width="21%" align="left">Amount(BEP20 USDT) : </td>
                                <td width="79%" align="left"> 
                                  <input type="text" name="pay_amount" id="pay_amount" class="form-control input-type-1" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />                                </td>
                              </tr>
                              <tr>
                                <td align="left">&nbsp;</td>
                                <td height="100" align="left">
                                   
 								  <input type="hidden" name="new_address" id="new_address" value="<?=$new_address?>" />
								<input type="hidden" name="pay_ipntype" id="pay_ipntype" value="<?=$pay_ipntype?>" />
                                  <input type="hidden" name="action" value="Continue" />
                                  <input name="Submit" type="submit"  class="btn btn-primary mt-3" value="Continue" />
                                  &nbsp;&nbsp;
                                  <!--<input name="Reset" type="reset" class="button" value=" Reset " />-->                                </td>
                              </tr>
                              <tr>
                                <td height="100" colspan="2" align="left"> 
  
<ul>

<!--<li> Expected arrival :  1 network confirmations</li>
<li> Expected unlock :  1 network confirmations</li>
--><li> Minimum deposit :  1 USDT</li>
   <li>Send only&nbsp;<span data-bn-type="text">BEP20 USDT</span>&nbsp;to this deposit address.</li>
  <li>Ensure the network is&nbsp;<span data-bn-type="text">Binance (BEP20)</span>.</li>
  <li>Do not send NFTs to this address.&nbsp; </li>
</ul></td>
                              </tr>
                            </table>
                          </form>
                          <? } else if ($action == 'Continue') { ?>
                          <form method="post" name="form1" id="form1"  <?= validate_form()?>>
                            <table width="100%"  border="0" cellpadding="1" cellspacing="1" class="td_box" >
                              <tr>
                                <td  align="center"class="td_box"><input type="text" name="pay_trnid" class="form-control input-type-1 " placeholder="USDT Txansaction / HASH Code" value="<?=$pay_trnid?>"  />
                                </td>
                              </tr>
                              <tr>
                                <td align="center">
								<input type="hidden" name="new_address" id="new_address" value="<?=$new_address?>" />
								<input type="hidden" name="pay_ipntype" id="pay_ipntype" value="<?=$pay_ipntype?>" />
								<input type="hidden" name="pay_amount" id="pay_amount" value="<?=$pay_amount?>" />
								<input type="hidden" name="action" value="Submit" />
                                  <input name="Submit" type="submit"  class="btn btn-primary mt-3" value="Submit"  />
                                </td>
                              </tr>
                              <tr>
                                <td align="left"><br>
                                  <br>
                                  <span style="color:#FFffff" > Note: Go to you wallet and copy  correct Txid/HASH  ID from wallet and input in above box to complete your transaction.</span> </td>
                              </tr>
                            </table>
                          </form>
                          <? } else if ($action == 'Finish') { ?>
                          <table width="100%"  border="0" cellpadding="1" cellspacing="1" >
                            <tr class="tdhead">
                              <td align="left" valign="middle"   class="tdhead"> <h2>Deposit Confirmation  </h2></td>
                            </tr>
                            <tr>
                              <td  align="left"class="td_box"><br>
                                <br>
                                Your deposit request submitted successfully, status will update soon. <br>
                                <br>
                              </td>
                            </tr>
                          </table>
                          <? }  ?>
                          <?  } else { ?>
                          <br />
                          <span class="error" >Deposit request temporarily not available at this time.</span> <br />
                          <br />
                          <br />
                          <br />
                          <br />
                          <?  }  ?>
                        </td>
                      </tr>
                    </table>
					
			 </div>
            </div>
          </div>
          <!--end col-->
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