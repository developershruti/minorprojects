<?php
include ("../includes/surya.dream.php");
// Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_user_details");
sajax_handle_client_request();
// END Ajax code 

/*if ($_SESSION['sess_status']=='Inactive') {
 	 header("location: my_ewallet_acc_activation.php");
	 exit;
} */  

protect_user_page();
 $arr_error_msgs =array();

if ($_SESSION['sess_security_code']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code.php");
	 exit;
}

/*if ($_SESSION['sess_security_code']=='') {
 	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
 	 header("location: security_code.php");
 	 exit;
 }*/  	 

/*if ($_SESSION['sess_status']=='Inactive') {
  	 header("location: my_ewallet_acc_activation.php");
 	 exit;
 }*/  

$pay_group='CW';
 if($_SESSION['sess_plan'] != 'Admin') {
///$arr_error_msgs[] = "Account activation start soon, till time you can refer your friends and deposit USDT & get ready for activation";
}
 



$u_bank_lock  = db_scalar("select u_bank_lock from ngo_users where u_id = '$_SESSION[sess_uid]'"); 
if ($u_bank_lock=='yes') { 
	$arr_error_msgs[] =  db_scalar("select u_blocked_msg from ngo_users where u_id = '$_SESSION[sess_uid]'"); ; 
 }
 //if ($pay_group=='LR') {$arr_error_msgs[] =   "Selected payment processor is on hold, you can't re-invest fund in $pay_group!";}
 $cw_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group='CW'"); 
 //// cashwallet balance
 #$tw_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group='RW'"); 
 if(is_post_back()) {
  /// and code_useto>=ADDDATE(now(),INTERVAL 570 MINUTE)
	$topup_userid = db_scalar("select u_id from ngo_users where u_username = '$topup_username' ");
	if ($topup_userid=='') { $arr_error_msgs[] =  $topup_username." Username does not exist!  " ;} 

/*if ($total_investment!='10.00') { 
$topup_active_count= db_scalar("select count(*) from ngo_users_recharge  where topup_userid ='$topup_userid' and topup_amount='10.00'")+0;	
if ($topup_active_count<1) { $arr_error_msgs[] = "Please Activate Your Account With Registration Promo Code"; } 
} */

#$user_password = db_scalar("select u_password2 from ngo_users where u_password2 = '$user_password' and u_id='$_SESSION[sess_uid]'");	
 	#if ($user_password =='') { $arr_error_msgs[] =  "E-Bank Password does not match!";}
     $MINIMUM_INVESTMENT  = 50;
  	if ($total_investment<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "Minimum package amount is ". price_format($MINIMUM_INVESTMENT); }

 	// and    pay_group='$pay_group'

	// $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group='$pay_group'"); 
 ///if ($total_investment >$account_balance) {$arr_error_msgs[] =   "Insufficient Wallet Balance balance!";}
	if ($total_investment<=0) { $arr_error_msgs[] =  "Package amount is missing!";}

	$topup_amount= $total_investment;
	/*$tw_amount_max = ($topup_amount/100)*50;	
	if ($tw_amount !='' || $tw_amount>$tw_amount_max) {  ///$arr_error_msgs[] 	=   "Insufficient NYXA-Account  account balance!";
	  if ($tw_amount >$tw_balance) {$arr_error_msgs[] 	=   "  Wallet balance Low!";}
	}
	if ($tw_amount >0 && $tw_amount>$tw_amount_max) {$arr_error_msgs[] ="Use maximum  ".price_format($tw_amount_max)." from  Wallet!";}/
	 $cw_amount 	  	= $topup_amount - $tw_amount;
*/	
	 $cw_amount 	  	= $topup_amount ;
	#$cw_amount_min 	= ($topup_amount/100)*60;
	#if ($cw_amount <$cw_amount_min) {$arr_error_msgs[] 	=   "You must be use minimum ".price_format($cw_amount_min)." from Cash Reserve!";}
	 if ($cw_amount >$cw_balance) {$arr_error_msgs[] 	=   "Wallet balance Low!";}
 	 $topup_amount_active = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and topup_amount='$topup_amount' and topup_status='Paid' ");	
  	if ($topup_amount_active>0) {
		$arr_error_msgs[] = "Your account is already topped up with $topup_username";
 	}  
 
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 		//print_r($arr_error_msgs);
 if (count($arr_error_msgs) ==0) { 
 	if ($_POST['Submit']=='Continue') {
 		//$arr_error_msgs[] = "Are you sure want to investment - $total_investment";
  		$arr_error_msgs[] = "Are you sure want to activate your account?";
 		$action = 'Continue';
   } else if  ($_POST['Submit']=='Confirm Payment') {
 		$action = 'Confirm';
 		$topup_amount 	=$total_investment;
 		$topup_amount2 	=$total_investment;
  		$topup_rate = 4.00; //4.00% cashback daily
  		$topup_days_for = 30; ///30 Days
 
    	 $sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid',topup_by_userid='$_SESSION[sess_uid]'  ,topup_group='A', topup_plan='TOPUP' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate'   ,topup_amount='$topup_amount' ,topup_amount2='$topup_amount2' ,topup_date=ADDDATE(now(),INTERVAL  330 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 330 MINUTE),topup_exp_date=ADDDATE(now(),INTERVAL $topup_days_for DAY)  ,topup_status='Paid' ";

		db_query($sql);
 		$topup_id = mysqli_insert_id($GLOBALS['dbcon']);

		$arr_error_msgs[] =  "$topup_username account activate successfully with package ".price_format($total_investment)." " ;  
 		$pay_for1 = "Purchase Package - $topup_username" ;
 
		if($cw_amount>0) {
			$pay_for1 = "Purchased Package - ".$topup_username;
			$sql2 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$topup_id' ,pay_plan='TOPUP_FEES' ,pay_group='CW' ,pay_for = '$pay_for1' ,pay_ref_amt='$topup_amount' ,pay_unit = '$' ,pay_rate = '60', pay_amount = '$cw_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) "; 	
			db_query($sql2);
		}
		
		
		
		
		///////////////Level Income / Referral Income Instant on topup start ////////////////////////////// 
		$u_ref_userid = $topup_userid;//$u_ref_userid = $_SESSION['sess_uid'];
		$ctr2=0;
		while ($ctr2<10) { 
		$ctr2++;
		$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
		//$referral_verify_email_status = db_scalar("select u_verify_email_status from ngo_users where u_id='$u_ref_userid' ");
		$sponsor_topup_count2 = db_scalar("select count(*) from ngo_users_recharge where topup_userid='$u_ref_userid' and topup_status='Paid' ")+0;
 		if ($u_ref_userid!='' && $u_ref_userid!=0 && $sponsor_topup_count2>=1){
 			
			if($ctr2==1)				  { $pay_rate3 =5; $pay_plan3 ='DIRECT_INCOME'; $pay_plan_name = 'Direct Income'; }  
			else if($ctr2>=2  && $ctr2<=3){ $pay_rate3 =2; $pay_plan3 ='LEVEL_INCOME'; $pay_plan_name = 'Level Income';}  
 			else if($ctr2>=4 && $ctr2<=10){ $pay_rate3 =1; $pay_plan3 ='LEVEL_INCOME'; $pay_plan_name = 'Level Income';}
			 
 			$pay_amount3 = ($topup_amount/100)*$pay_rate3;
			$pay_ref_amt3 = $pay_amount3;
			$pay_for3 ="$pay_plan_name From Level $ctr2 By $package_name / ".$topup_serialno; 
   			$sql3 = "insert into ngo_users_payment set pay_drcr='Cr' ,pay_userid ='".$u_ref_userid."' ,pay_refid ='".$topup_id."', pay_topupid ='".$topup_id."', pay_group='WI', pay_plan='$pay_plan3' ,pay_for = '$pay_for3' ,pay_ref_amt='$pay_ref_amt3' ,pay_unit = '%' ,pay_rate = '$pay_rate3', pay_amount = '$pay_amount3'  , pay_status = 'Paid', pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='Instant' ";
			db_query($sql3);
 		} 
	}	
	
 		///////////////Level Income / Referral Income Instant on topup end ////////////////////////////// 	
		
		/*
		if($tw_amount>0) {
			$pay_for1 = "Purchased Package - ".$topup_username;
				  $sql4 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$topup_id' ,pay_plan='TOPUP_FEES' ,pay_group='RW' ,pay_for = '$pay_for1' ,pay_ref_amt='$topup_amount' ,pay_unit = '$' ,pay_rate = '40', pay_amount = '$tw_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) "; 	
			db_query($sql4);
		}

		$pay_for1 = "Promotional Token on  Package Purchase" ;
		$pay_rate = "1";
		$pay_amount =30;
		$sql1 = "insert into ngo_users_coin set  pay_drcr='Cr',  pay_userid = '$topup_userid',pay_refid = '$topup_id' ,pay_plan='TOPUP_BONUS' ,pay_group='PROMO' ,pay_for = '$pay_for1' ,pay_ref_amt='$topup_amount' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
 
		db_query($sql1);
*/

 		$action = '';
 		$_POST='';
 		$act='done';
   

 } 

}

}

$_SESSION['arr_error_msgs'] = $arr_error_msgs;



 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='$pay_group' "); 

  //

 

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
              <h4 class="mb-sm-0">Package Purchase</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">My Wallet</a></li>
                  <li class="breadcrumb-item active">Package Purchase</li>
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
                <h4 class="card-title mb-0 flex-grow-1">PACKAGE PURCHASE</h4>
              </div>
              <!-- end card header -->
              <div class="card-body">
                <div class="live-preview">
                  <form method="post" name="form1" id="form1"   class="forms-sample" <?= validate_form()?>  >
                    <div class="row">
                      <?  if ($act!='done') { ?>
                      <?   if ($action == '')  { ?>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="firstNameinput" class="form-label">Wallet Balance</label>
                          <?=price_format($account_balance)?>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="firstNameinput" class="form-label">User ID</label>
                          <input type="text" class="form-control"   name="topup_username" value="<?=$topup_username?>" alt="blank" emsg="Username can not be blank"  placeholder="User Id" onChange="do_get_user_details();" required/>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="firstNameinput" class="form-label">Package Amount</label>
                          <select name="total_investment" class="form-control"  id="total_investment"    alt="select" emsg="Please Select Package"  required>
                            <option value="" >Select Package</option>
							<? for ($i = 50; $i <= 25000; $i += 50) {  //echo $i . "<br>";?>
                            <option value="<?=$i?>" <? if($total_investment==$i) {?> selected="selected" <? } ?>>Package <?=price_format($i);?></option>
							<? } ?>
                          </select>
                          <input type="hidden" name="pay_group" value="<?=$pay_group?>"  />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <button type="submit" name="Submit" value="Continue" class="btn btn-primary mr-2">Continue</button>
                        </div>
                      </div>
                      <? } else if ($action == 'Continue') { ?>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="firstNameinput" class="form-label">Wallet Balance</label>
                          <?=price_format($account_balance)?>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="firstNameinput" class="form-label">User ID : </label>
                          <input type="hidden" value="<?=$topup_username?>" name="topup_username">
                          <?=$topup_username?>
                          (
                          <?=db_scalar("select u_fname from ngo_users where u_username='$topup_username' limit 0,1")?>
                          ) </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="firstNameinput" class="form-label">Package Amount : </label>
                          <?=price_format($total_investment)?>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <input name="total_investment"  type="hidden"   value="<?=$total_investment?>"  />
                          <input type="hidden" name="pay_group" value="<?=$pay_group?>" />
                          <button type="submit" name="Submit" value="Confirm Payment" class="btn btn-primary mr-2">Confirm Payment</button>
                        </div>
                      </div>
                      <? }  ?>
                      <?  } else {  ?>
                      <div class="col-md-12">
                        <div class="mb-3"> <a href="my_ewallet_investment.php" class="btn btn-primary">Click Here </a> to purchase new package. </div>
                      </div>
                      <? }   ?>
                      <!--end col-->
                    </div>
                    <!--end row-->
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
