<?php
include ("../includes/surya.dream.php");
protect_user_page();

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
// Ajax code 
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

$pay_group='CW';	
$arr_error_msgs = array();
 
//print_r($_POST);
 /// check account balance 
$acc_balance =  round(db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group= '$pay_group' "),2);
if ($acc_balance <1) { 
  	$arr_error_msgs[] =  "Insufficient account balance for transfer" ;  
 	$stop='stop';
} 


if(is_post_back()) { 
$pay_userid = db_scalar("select u_id from ngo_users where u_username = '$pay_username' ");	
// check user name


/*
$u_acc_type= db_scalar("select u_acc_type from ngo_users where u_status='Active' and u_id ='$pay_userid' ");
if($u_acc_type!='Franchise') { 
	$u_acc_type2= db_scalar("select u_acc_type from ngo_users where u_status='Active' and u_id ='$_SESSION[sess_uid]' ");
	if($u_acc_type2!='Franchise') { 
	//print "...........................";
		$arr_error_msgs[] = "You can transfer only on franchise Account";
	}
}
*/


$total_count = db_scalar("select count(*) from ngo_users where u_username = '$pay_username'");
if ($total_count==0) { $arr_error_msgs[] =  $u_username." Username does not exit!  " ;} 
if ($acc_balance<$pay_amount) {
			$arr_error_msgs[] = "Insufficient account balance for transfer - $acc_balance";
} 

if ($pay_amount<=0) {
			$arr_error_msgs[] = "Invalid Amount, You can't transfer it ";
} 
///$MINIMUM_EWALLET_TRANSFER = db_scalar("select sett_value from ngo_setting where  sett_code ='MINIMUM_EWALLET_TRANSFER' limit 0,1")+0;
$MINIMUM_EWALLET_TRANSFER = 10;

if ($pay_amount<$MINIMUM_EWALLET_TRANSFER) {
			$arr_error_msgs[] = "Minimum transfer amount is ". price_format($MINIMUM_EWALLET_TRANSFER);
} 


 if (count($arr_error_msgs) ==0) {
	
	if ($_POST['Submit']=='Continue') {
		$arr_error_msgs[] = "Are you sure want to transfer fund into $pay_username account ?";
		$action = 'Continue';
		
		$deduction_rate = 0;
		$pay_rate = 100 - $deduction_rate;
   
   	} else if  ($_POST['Submit']=='Confirm Payment') {
		$action = 'Confirm';
	//print_r($_POST);
		$pay_ref_amt = $pay_amount;
		
	 
		 $deduction_rate = 0; ///6% deduction on fund transfer to user and withdrawal
		$pay_rate = 100 - $deduction_rate;
	
		$deduction_amount = ($pay_amount/100)*$deduction_rate;
		
		$transfer_pay_amount = ($pay_amount/100)*$pay_rate;
		
		$pay_for1 = "Fund received from user $_SESSION[sess_username] - ".$pay_for;
		$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Cr',  pay_userid = '$pay_userid',pay_refid = '$_SESSION[sess_uid]' ,pay_plan='FUND_RECEIVE' ,pay_for = '$pay_for1' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate'  ,pay_group='$pay_group' , pay_amount = '$transfer_pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
		db_query($sql1);
		
		$pay_for2 = "Fund transfered to user $pay_username - ".$pay_for;
		$sql2 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_userid' ,pay_plan='FUND_TRANSFER' ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate' ,pay_group='$pay_group', pay_amount = '$transfer_pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
		db_query($sql2);
		
		if ($deduction_amount>0) { 
		$pay_for2 = "Deduction @ $deduction_rate % on ".price_format($pay_ref_amt);
 		$sql3 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_refid' ,pay_plan='DEDUCTION'  ,pay_group='$pay_group' ,pay_transaction_no='$pay_plan',pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$deduction_rate', pay_amount = '$deduction_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
		db_query($sql3);
		}
		
		 
	 	$arr_error_msgs[] ="Fund transfered successfully to $pay_username account";
	 
	 
	}
}
} 
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
<head>
<? include("includes/extra_head.php")?>
<script language="javascript">
<? sajax_show_javascript(); ?>
 
//------check username availability code start------------------------------------------------
 
function do_get_user_details() {
	
	//
	document.getElementById('details').innerHTML = "Loading...";
	pay_username= document.form1.pay_username.value;
	//alert(pay_username);
   	x_get_user_details('user_details', pay_username, do_get_user_details_cb);
 
 }
function do_get_user_details_cb(z) {
	//alert(z);
 	document.getElementById('details').innerHTML = z;
   }
   </script>
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
              <h4 class="mb-sm-0"> Transfer Fund Wallet</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">My Wallet</a></li>
                  <li class="breadcrumb-item active">Transfer Fund Wallet </li>
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
                <h4 class="card-title mb-0 flex-grow-1">  Transfer Wallet To Other</h4>
              </div>
              <!-- end card header -->
              <div class="card-body">
                <div class="live-preview">
                  <!--main  content table start -->
                  <form method="post" name="form1" id="form1"  class="forms-sample"  <?= validate_form()?>>
                    <?   if ($action == '')  { ?>
                    <p><strong> Wallet Balance :
                      <?=price_format($acc_balance); ?>
                      </strong></p>
                    <!-- <p style="color:#fff"><strong>Transfer Date : <?php echo  date_format2(db_scalar("select now()")); ?></strong></p>-->
                    <label for="firstNameinput" class="form-label">Receiver Username </label>
                    <input type="text"  class="form-control" name="pay_username" value="<?=$pay_username?>" alt="blank" emsg="Username can not be blank" placehlder="Receiver Username" onChange="do_get_user_details();" required/>
                    <div align="left" id="details" > </div>
                   
                    <label for="firstNameinput" class="form-label">Transfer fund</label>
                    <input type="text"  name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" class="form-control" required/>
                    <p class="form-label"><strong>Specification (If Any):</strong></p>
                    <textarea name="pay_for" cols="30"  rows="5" alt="blank" class="form-control" emsg="Naration can not be blank"  required><?=$pay_for?>
</textarea>
                    
                    <? if ($stop=='') {?>
                    <input name="Submit" type="submit" class="btn btn-primary mr-2 mt-2" value="Continue" />
                    <!--
						&nbsp;&nbsp;<input name="Reset" type="reset"  value=" Reset " />-->
                    <?  } ?>
                    <? } else if ($action == 'Continue') { ?>
                    <p class="form-label"><strong>Account Balance :
                      <?php   echo  ($acc_balance+0); ?>
                      </strong></p>
                    <p class="form-label"> Transfer Date : <?php echo  date_format2(db_scalar("select now()")); ?> </p>
                    <p class="form-label"> Receiver Username :
                      <input type="hidden" name="pay_username" value="<?=$pay_username?>" />
                      <?=$pay_username?>
                    </p>
                    <p class="form-label"> Transfer Fund :
                      <input type="hidden" name="pay_amount" value="<?=$pay_amount?>"   />
                      <?= ($pay_amount+0)?>
                    </p>
                    <p class="form-label"> Deduction  :
                      <?=$deduction_rate?>
                      % </p>
                    <p class="form-label"><strong>Specification (If Any):
                      <input type="hidden" name="pay_for" value="<?=$pay_for?>" />
                      <?=$pay_for?>
                      </strong></p>
                    <button type="submit" name="Submit"class="btn btn-primary mr-2" value="Confirm Payment">Confirm Payment</button>
                    <? }  ?>
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
