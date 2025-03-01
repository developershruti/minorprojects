<?php
include ("../includes/surya.dream.php");
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$token_price =  db_scalar("select sett_value from ngo_setting where sett_code = 'TOKEN_RATE' ");
$page_action = 'DaPP';
protect_user_page();

$arr_error_msgs =array();

 
if (count($_GET) >0) { 
  	 
$topup_userid =$_SESSION['sess_uid']; // db_scalar("select u_id from ngo_users where u_id = '$_SESSION[sess_uid]' ");	
$MINIMUM_INVESTMENT  = 0.1;
$MAXIMUM_INVESTMENT  = 250000000;
if ($topup_amount<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "Minimum Deposit amount is : ". price_format($MINIMUM_INVESTMENT); }
if ($topup_amount>$MAXIMUM_INVESTMENT) { $arr_error_msgs[] = "Maximum Deposit amount is ". price_format($MINIMUM_INVESTMENT); }	
 
if ($topup_amount<=0) { $arr_error_msgs[] = "Deposit amount is missing!";}
$cw_amount =  (double)$topup_amount ;



//$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		 // print_r($arr_error_msgs);
  if (count($arr_error_msgs) ==0) { 
  			
		if ($_GET['Submit']=='Continue') {
			$arr_error_msgs[] = "Are you sure want to Deposit USDT?";
			$action = 'Continue';
		} else if  ($_GET['creq_txnhash']!='') {

	$creq_txnhash = $_GET['creq_txnhash'];
	//$topup_amount = $buy_amount;
	$action = 'Confirm';
	$ip =  gethostbyaddr($_SERVER['REMOTE_ADDR']); 
	
////////////start //////////////////////////// 	
	$toAddress = "0xe840BfB33Af8FDD5AC1aFb7c10055A94564aB64EXXXXXXXXXXXXXXX";
	$txnhash =$creq_txnhash;	
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
	  
	 /*  echo '<pre>';
	print_r($jsonRes);
	echo '</pre>';  */
	//exit;
	 
 	$amount_usdt  	  = $jsonRes->data->transferAmount;
	//$amount_bnb 	  = $jsonRes->data->value;
	$from_address  	  = strtolower($jsonRes->data->from);
 	$status 		  = $jsonRes->data->status;
	$userAddr 		  = strtolower($_SESSION['sess_username']);
}

curl_close($curl);
///////////////end/////////////////////
// || $from_address!=$userAddr
if($status!='success' || $amount_usdt!=$topup_amount){
	$arr_error_msgs[] =  "Something went wrong! Please try again later." ;
	//$_SESSION['arr_error_msgs'] = $arr_error_msgs;
	$action = 'Continue';
 
} else {
  		$total_count1 = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and  topup_serialno='$creq_txnhash'");
        if($total_count1==0) {
		$action = 'Confirm';
 		
		$pay_for1 = "Depsit USDT : ".price_format($amount_usdt);
		$sql2 = "insert into ngo_users_token_swap set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '0' ,pay_plan='DEPOSIT_USDT' ,pay_group='CW' ,pay_for = '$pay_for1' ,pay_ref_amt='$buy_amount' ,pay_ref_amt2='$topup_amount',pay_unit = 'TS' ,pay_rate = '100', pay_amount = '$topup_amount', pay_amount2 = '$topup_amount', pay_transaction_no = '$creq_txnhash' , pay_transaction_no2 = 'Fund Received' ,pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql2);
		$pay_id = mysqli_insert_id($GLOBALS['dbcon']);
		$action = 'Confirm'; 
		 
		$pay_for = "Received from USDT Deposit , TxnHash: ".$creq_txnhash ;
		$pay_rate=100;
		//$pay_amount = $topup_amount*$pay_rate;
		$pay_amount = round( $topup_amount/$token_price,5);
		$sql2 = "insert into ngo_users_ewallet set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]'  , pay_group='CW' ,pay_plan='DEPOSIT_USDT' ,pay_transaction_no='$creq_txnhash' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount', pay_ref_amt2='$topup_amount' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount',  pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE)  ,pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql2);
		$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
	
	 
 		 



 	$date = db_scalar("  select ADDDATE(now(),INTERVAL 570 MINUTE) ");		
 	$u_email = db_scalar("select u_email from ngo_users where u_id = '$topup_userid' ");			 
 	$message="
 	Dear ". $_SESSION['sess_username'].", 
 	<br>
 	<br>You have successfully purchase Package with: 
 	<br>
 	<br>Package Amount :".price_format($topup_amount)." 
 	<br>
 	<br>Purchase Date: ".$date."
 	<br>
 	<br>Once again, Thank you!
 	<br>
 	<br>". SITE_NAME ."
 	<br>". SITE_URL ."
 	";
 	$u_email = $_SESSION['sess_email'];
 	$HEADERS  = "MIME-Version: 1.0 \n";
 	$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
 	$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
 	$SUBJECT  = SITE_NAME." SUCCESSFULLY PURCHASED";
 	#@mail($u_email, $SUBJECT, $message,$HEADERS);


 	$arr_error_msgs[] =  "Your investment completed successfully!";
 	//$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 	//$action = 'Confirm';
 	##header("Location:my_ewallet_purchase.php?action=Confirm&creq_txnhash=$creq_txnhash&bschash=$creq_txnhash");
	##exit;
}
}
 }
 #$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 # header("Location: ".$_SERVER['HTTP_REFERER']);
 
} 
 }

$_SESSION['arr_error_msgs'] = $arr_error_msgs;

//$account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' "); 

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
          <div class="col-lg-6 centered">
            <div class="card">
              <div class="card-body">
                <? 
			   if ($action != 'Confirm') { ?>
                <p align="center"  >
                  <? include("error_msg.inc.php");?>
                </p>
                <? } ?>
                <form name="depositform" id="depositform" method="get" action="<?=$_SERVER['PHP_SELF']?>"  enctype="multipart/form-data"  <? ///= validate_form()?>>
                  <?   if ($action == '')  { ?>
                  <!--<div class="input-item input-with-label">
                        <label for="email-address" class="input-item-label">BIGDICE Rate : </label>
                         <?=price_format($token_price)?>  
                      </div>-->
                  <div class="form-group">Deposit Amount (USDT):<br>
                    <input name="topup_amount"  type="text"  class="form-control"  placeholder="Purchase Worth Amount (USDT)"  value=""  alt="numeric|1" emsg="Please enter minimum amount $1"     />
                  </div>
                  <div class="form-group mt-2">
                    <input name="Submit" id="Submit" type="submit"  class="btn btn-primary busdBuy"  value="Continue" />
                  </div>
                  <? } else if ($action == 'Continue') { ?>
                  <!--<div class="input-item input-with-label">
                        <label for="email-address" class="input-item-label">BIGDICE Rate : </label>
                         <?=price_format($token_price)?>  
                      </div>-->
                  <div class="form-group">
                    <label for="buy_package" class="input-item-label"> Deposit  Amount (USDT) :</label>
                    <?=price_format($topup_amount)?>
                    <input name="topup_amount"  id="topup_amount" type="hidden"   value="<? if(isset($topup_amount)) { echo $topup_amount ;}?>" >
                  </div>
                  <!-- <div class="form-group">
                        <label for="buy_package" class="input-item-label">Swaping Token QTY   : </label>
                        <? 
                			//	$topup_amount =  $_GET['topup_amount'] ; 
                			 $buy_amount = round( $topup_amount/$token_price,5);
                				// $buy_amount=$topup_amount;
                				?>
                        &nbsp;&nbsp;<?=price_format2($buy_amount)?>
                       
                        
                       
                </div>-->
                  <div class="gaps-1x"></div>
                  <div class="d-sm-flex justify-content-between align-items-center">
                    <input name="buy_amount"  id="buy_amount" type="hidden"   value="<? if(isset($topup_amount)) { echo $topup_amount ;}?>" >
                    <input type="hidden" name="creq_txnhash"  id="creq_txnhash" class="input-bordered" value="<? if(isset($creq_txnhash)) { echo $creq_txnhash ;}?>"   />
                    <input type="hidden" name="creq_status" id="creq_status"  class="input-bordered" value="<? if(isset($creq_status)) { echo $creq_status ;}?>"   />
                    <button type="button" name="depositUSDT" id="depositUSDT" value="Confirm Payment" class="btn btn-primary">Confirm Payment</button>
                  </div>
                  <div class="sub-text"> <br>
                    <strong>1. Connect Wallet</strong> :   Make sure you are connected with wallet (Trust Wallet / Metamask) <br>
                    <strong>2. Confirm Payment   :</strong>After smart contract call confirmation please wait for blockchain network to confirm your transfer <br>
                    <strong>3. Deposit Success:</strong> Please wait  for some time (5-15 Second) once payment confirm by network , you will get a confirmation mesasge "Your Purchase order has been processed successfully" </div>
                  <? } else if ($action == 'Confirm') { ?>
                  <div class="form-group">
                    <label for="email-address" class="input-item-label"> Deposit Completed successfully</label>
                  </div>
                  <div class="form-group">
                    <label for="email-address" class="input-item-label"> Transaction Hash :</label>
                    <strong>
                    <?=$creq_txnhash?>
                    </strong> </div>
                  <? } ?>
                </form>
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
