<?php
include ("../includes/surya.dream.php");
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
$page_action = 'DaPP';
protect_user_page();
$token_price =  db_scalar("select sett_value from ngo_setting where sett_code = 'TOKEN_RATE' ");
$arr_error_msgs =array();
$action = 'Start';

 //$arr_error_msgs[] =  "We regret to inform you that our withdrawal service is currently undergoing scheduled maintenance to enhance our system. As a result, withdrawals are temporarily unavailable at this time." ;

/*$u_fname  = db_scalar("select u_fname from ngo_users where u_id = '$_SESSION[sess_uid]'"); 
 if ($u_fname=='') { 
	$arr_error_msgs[] =  "Update your profile details before make withdrawal" ;  
	$stop='stop';
 }
	*/ 
	 

if (count($_GET) >=1) { 



#$topup_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$_SESSION[sess_uid]'");
#if ($topup_count==0) { $arr_error_msgs[] =  " Your account is not Active, first stack in your account after that you can do transaction !  " ;}  

$u_id = db_scalar("select  u_id from ngo_users where u_status!='Inactive' and u_id = '$_SESSION[sess_uid]'");
if ($u_id =='') { $arr_error_msgs[] =  "Inactive Account, you can't swap token at this time";}

 if(isset($_GET['buy_amount'])) { $buy_amount	 	= $_GET['buy_amount']; }
if(isset($_GET['topup_amount'])) {$topup_amount 	= $_GET['topup_amount'];}
if(isset($_GET['token_price'])) {$token_price		= $_GET['token_price'];}
if(isset($_GET['creq_txnhash'])) {$creq_txnhash 	= $_GET['creq_txnhash'];}
if(isset($_GET['creq_status'])) {$creq_status 		= $_GET['creq_status'];}

if($topup_amount<1) {  $arr_error_msgs[] =  "Minimum Swaping value $1  required!";} 

#$with_date = db_scalar(" select DATE_FORMAT(ADDDATE(now(),INTERVAL 330 MINUTE), '%Y-%m-%d') as dated");
#$total_swap = db_scalar("select count(*)  FROM ngo_users_token_swap where pay_userid='$_SESSION[sess_uid]'  and pay_plan='TOKEN_SWAP' and pay_date='$with_date'")+0;	
#if ($total_swap >=1) { $arr_error_msgs[] =  "Sorry, Only one swapping allowed in a day, you have already swapped today.";}
 
if(isset($_GET['topup_amount'])) { $topup_amount =$_GET['topup_amount'];}
//$topup_userid = db_scalar("select u_id from ngo_users where u_id = '$_SESSION[sess_uid]' ");	
  
	$buy_amount = round( $topup_amount/$token_price,5);
 	if (!isset($buy_amount)) { $arr_error_msgs[] =  "Swaping token is missing!";}

if(isset($buy_amount)) {
	$MINIMUM_INVESTMENT  = 1;
	//$MAXIMUM_INVESTMENT  = $total_swap_limit; //50000;
	if ($topup_amount<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Minimum Swaping amount for your account is : ". price_format($MINIMUM_INVESTMENT); }
	//if ($buy_amount>$MAXIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Maximum Swaping limit for your account is ". price_format2($MAXIMUM_INVESTMENT); }	
}
	  // print_r($arr_error_msgs);
	 if(isset($_GET['creq_txnhash'])) { 
		$creq_txnhash =$_GET['creq_txnhash'];
		if  ($creq_txnhash!='') {
			$total_count = db_scalar("select count(*)  FROM ngo_users_token_swap where pay_transaction_no = '$creq_txnhash' ")+0;	
			if ($total_count>=1) { 
				$arr_error_msgs[] =  "Sorry, This Txnhash id ($creq_txnhash) already used ";
			}
		}
	 }
 if (count($arr_error_msgs) ==0) { 
 
 
 if ($_GET['Submit']=='Continue') {
 		$arr_error_msgs[] = "Are you want to swap token ?";
		$action = 'Continue';
 		 	
 } else if ($_GET['creq_txnhash']!='') {

	$action = 'Confirm';
	$ip =  gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$buy_amount = $_GET['buy_amount'];
	$creq_status = $_GET['creq_status'];
 		  
	if($creq_status=='true') {
		///deduction 2-3 % applied
 		$usdtAmount = $topup_amount ; // 0.01;
 	
		$pay_for1 = "Deposit BIGDICE Token   @".price_format($token_price)." | Qty: ".price_format2($buy_amount)."";
		$sql2 = "insert into ngo_users_token_swap set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '0' ,pay_plan='DEPOSIT_TOKEN' ,pay_group='CW' ,pay_for = '$pay_for1' ,pay_ref_amt='$buy_amount' ,pay_ref_amt2='$topup_amount',pay_unit = 'TS' ,pay_rate = '$token_price', pay_amount = '$topup_amount', pay_amount2 = '$usdtAmount', pay_transaction_no = '$creq_txnhash' , pay_transaction_no2 = 'Fund Received' ,pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql2);
		$pay_id = mysqli_insert_id($GLOBALS['dbcon']);
		$action = 'Confirm'; 
 		
	$pay_for = "Received from BIGDICE TxnHash: ".$creq_txnhash ;
 	$pay_rate=100;
	//$pay_amount = $topup_amount*$pay_rate;
	//$pay_amount = round( $topup_amount/$token_price,5);
 	$sql2 = "insert into ngo_users_ewallet set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]'  , pay_group='CW' ,pay_plan='DEPOSIT_TOKEN' ,pay_transaction_no='$creq_txnhash' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount', pay_ref_amt2='$buy_amount' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$topup_amount',  pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE)  ,pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
	db_query($sql2);
	$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
	
		 	
 	
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
              <h4 class="mb-sm-0"> Deposit BIGDICE</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Game Wallet</a></li>
                  <li class="breadcrumb-item active">Deposit BIGDICE</li>
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
                <h4 class="card-title mb-0 flex-grow-1"> Deposit BIGDICE</h4>
              </div>
              <!-- end card header -->
              <div class="card-body">
                <div class="live-preview">
				
             
              
			   <form name="depositform" id="depositform" method="get" action="<?=$_SERVER['PHP_SELF']?>"  enctype="multipart/form-data"  <?  //= validate_form()?>>
 			   <div class="form-group">
                     <? include("error_msg.inc.php");?>
                  </div>
				  
                  <? 
				  //  print $action;
				  
				  if ($action == 'Start')  { ?>
                  <div class="form-group">
                    <label for="email-address" class="input-item-label">BIGDICE Rate :</label>
                    <?=price_format($token_price)?>
                  </div>
                  <div class="form-group">
				   <label for="email-address" class="input-item-label">Token QTY (BIGDICE) :</label>
                    <input name="topup_amount"  type="text"  class="form-control"  placeholder="Token QTY (BIGDICE)"  value=""  alt="numeric|2" emsg="Please enter minimum amount 10"     />
                   
                  </div>
                   
                  <div class="form-group mt-2">
                    <input name="Submit" id="Submit" type="submit"  class="btn btn-primary busdBuy"  value="Continue" />
                  </div>
				   <? } else if ($action == 'Continue')  { ?>
                  
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="personal-data">
                      <div class="gaps-1x"></div>
                      <div class="input-item input-with-label">
                        <label for="email-address" class="input-item-label">BIGDICE Rate : </label>
                         <?=price_format($token_price)?>  
                      </div>
 					 <!-- <div class="input-item input-with-label">
                        <label for="topup_amount" class="input-item-label">Swaping Amount (USDT) :  </label>
                        <?=price_format($topup_amount)?>
                       </div>-->
					  <div class="form-group">
                        <label for="buy_package" class="input-item-label">Swaping Token QTY   : </label>
                        <? 
                			//	$topup_amount =  $_GET['topup_amount'] ; 
                			 	//$buy_amount = round( $topup_amount/$token_price,5);
                				 $buy_amount=$topup_amount;
                				?>
                        &nbsp;&nbsp;<?=price_format2($buy_amount)?>
                        <input name="buy_amount"  id="buy_amount" type="hidden"   value="<? if(isset($buy_amount)) { echo $buy_amount ;}?>" >
                        <input name="topup_amount"  id="topup_amount" type="hidden"   value="<? if(isset($topup_amount)) { echo $topup_amount ;}?>" >
                      </div>
                      
                       
                  </div>
                  <div class="gaps-1x"></div>
                  <div class="d-sm-flex justify-content-between align-items-center">
                   
                    <input name="token_price"  id="token_price" type="hidden"   value="<? if(isset($token_price)) { echo $token_price ;}?>" >
                    <input type="hidden" name="creq_txnhash"  id="creq_txnhash" class="input-bordered" value="<? if(isset($creq_txnhash)) { echo $creq_txnhash ;}?>"   />
                    <input type="hidden" name="creq_status" id="creq_status"  class="input-bordered" value="<? if(isset($creq_status)) { echo $creq_status ;}?>"   />
                    
                    <button type="button" name="Submit" id="Submit" value="Confirm Payment"   class="btn btn-primary"  onClick="token_deposit();"  >Confirm Payment</button>
                    
                  </div>
				  <? } else if ($action == 'Confirm')  { ?>
                  
				  
				   <div class="form-group">
                    <label for="email-address" class="input-item-label">Swapped Token (BIGDICE):</label>
                    <?=price_format2($buy_amount)?>
					 <br>  
                       <label for="email-address" class="input-item-label"> Transaction Hash (BIGDICE):</label>
                      <?=$_GET['creq_txnhash']?>
					    <br>
                  </div>
				   <!--
				  <div class="form-group">
                   <label for="email-address" class="input-item-label">  Swapped Amount (USDT):</label>
                       <?=price_format($usdtAmount)?> , Swaping Fees @  <?=$deduction_rate?>% 
                      <br> 
					  <label for="email-address" class="input-item-label">Transaction Hash (USDT):</label>
                       <?=$transactionHash?>
                  </div>
                     -->
                     
                    <? } ?>
                </form>
				
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