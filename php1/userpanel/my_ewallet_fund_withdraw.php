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

$pay_group='RW';	
$arr_error_msgs = array();
 
//print_r($_POST);
 /// check account balance 
$acc_balance =  round(db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group= '$pay_group' "),2);
if ($acc_balance <1) { 
  	$arr_error_msgs[] =  "No suficient account balance for transfer" ;  
 	$stop='stop';
} 


$u_ripwallet = db_scalar("select u_ripwallet from ngo_users where  u_id='$_SESSION[sess_uid]' limit 0,1"); 
if ($u_ripwallet=='') {$arr_error_msgs[] =  "Please update your RIP Token Addressin your update profile section before Withdrawal" ;  } 



if(is_post_back()) { 
//$pay_userid = db_scalar("select u_id from ngo_users where u_username = '$pay_username' ");	
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

/*
$total_count = db_scalar("select count(*) from ngo_users where u_username = '$pay_username'");
if ($total_count==0) { $arr_error_msgs[] =  $u_username." Username does not exit!  " ;} 
if ($acc_balance<$pay_amount) {
			$arr_error_msgs[] = "No suficient account balance for transfer - $acc_balance";
} 
*/

//0xb772b3947C1e142f44c5b84Eaec03d481B5EB868

$first_number = strtoupper(substr($pay_for, 0,1));  
if ( strlen($pay_for)!=42) { $arr_error_msgs[] =  "Invalid RIP Token address ($pay_for)!";}


if ($pay_amount<=0) {
			$arr_error_msgs[] = "Invalid Amount, You can't transfer it ";
} 
///$MINIMUM_EWALLET_TRANSFER = db_scalar("select sett_value from ngo_setting where  sett_code ='MINIMUM_EWALLET_TRANSFER' limit 0,1")+0;
$MINIMUM_EWALLET_TRANSFER = 100;

if ($pay_amount<$MINIMUM_EWALLET_TRANSFER) {
			$arr_error_msgs[] = "Minimum Withdraw is ". price_format($MINIMUM_EWALLET_TRANSFER);
} 


 if (count($arr_error_msgs) ==0) {
	
	if ($_POST['Submit']=='Continue') {
		$arr_error_msgs[] = "Are you sure want to withdraw RIP Token ?";
		$action = 'Continue';
		
		$deduction_rate = 5;
		$pay_rate = 100 - $deduction_rate;
   
   	} else if  ($_POST['Submit']=='Confirm Payment') {
		$action = 'Confirm';
	//print_r($_POST);
		$pay_ref_amt = $pay_amount;
		
		  
		///$deduction_rate = 0; ///6% deduction on fund transfer to user and withdrawal
		$deduction_rate = 5;
		$pay_rate = 100 - $deduction_rate;
		$deduction_amount = ($pay_amount/100)*$deduction_rate;
		$transfer_pay_amount = ($pay_amount/100)*$pay_rate;
		
		#$pay_for1 = "Fund received from user $_SESSION[sess_username] - ".$pay_for;
		#$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Cr',  pay_userid = '$pay_userid',pay_refid = '$_SESSION[sess_uid]' ,pay_plan='FUND_RECEIVE' ,pay_for = '$pay_for1' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate'  ,pay_group='$pay_group' , pay_amount = '$transfer_pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
		#db_query($sql1);
		
		$pay_for2 = "RIP Token Withdraw Request ";
		$sql2 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '0' ,pay_plan='FUND_WITHDRAW' ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate' ,pay_group='$pay_group', pay_amount = '$transfer_pay_amount',pay_status='Unpaid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql2);
		$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
		
		if ($deduction_amount>0) { 
		$pay_for2 = "Network Charges @ $deduction_rate % on ".price_format($pay_ref_amt);
 		$sql3 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_refid' ,pay_plan='DEDUCTION'  ,pay_group='$pay_group' ,pay_transaction_no='$pay_plan',pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$deduction_rate', pay_amount = '$deduction_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql3);
		}
		
		 
	 	$arr_error_msgs[] ="RIP Token Withdraw successfully";
	 
	 
	}
}
} 
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<? include("includes/extra_head.php")?>
<? include ("../includes/fvalidate.inc.php"); ?>
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
   </script></head>
<body class="dt-layout--default dt-sidebar--fixed dt-header--fixed">
<!-- Loader -->
<?  include("includes/loader.php")?>
<!-- /loader -->
<!-- Root -->
<div class="dt-root">
  <div class="dt-root__inner">
    <!-- Header -->
    <? include("includes/header.inc.php")?>
    <!-- /header -->
    <!-- Site Main -->
    <main class="dt-main">
      <!-- Sidebar -->
      <? include("includes/sidebar.php")?>
      <!-- /sidebar -->
      <!-- Site Content Wrapper -->
      <div class="dt-content-wrapper">
        <!-- Site Content -->
        <div class="dt-content">
          <!-- Page Header -->
          <div class="dt-page__header " style="    border-bottom: 1px solid #ddd;">
            <h1 class="dt-page__title"> RIP Token Withdraw </h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
            <div class="col-xl-3"> &nbsp; </div>
            <div class="col-xl-6">
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0" >
                  <!-- Tables -->
                  <div class="table-responsive" style="padding:10px;">
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p> 
 
             <!--main  content table start -->
             
				<form method="post" name="form1" id="form1"  class="forms-sample"  <?= validate_form()?>>
                    			
					   <?   if ($action == '')  { ?>
                     <p><strong> RIP Wallet  Balance : <?=price_format($acc_balance); ?></strong></p>
                        
						 
					   <p><strong>RIP Token Withdraw:</strong></p> 
                        <input type="text"  name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="RIP Token Withdraw can not be blank" class="form-control" required/>                         

						<p><strong>RIP Token Address:</strong></p> 
						<input type="text"  name="pay_for" value="<?=$u_ripwallet?>" alt="blank" emsg="RIP Token address can not be blank" class="form-control" required/>   
                       <!-- <textarea name="pay_for" cols="30"  rows="5" alt="blank" class="form-control" emsg="RIP Token address can not be blank"  required><?=$pay_for?></textarea> -->
                      <br>

						<? if ($stop=='') {?> 
						<input name="Submit" type="submit" class="btn btn-primary mr-2" value="Continue" /> <!--
						&nbsp;&nbsp;<input name="Reset" type="reset"  value=" Reset " />-->
						<?  } ?>						
					  <? } else if ($action == 'Continue') { ?>
 					  <p><strong>RIP Token  Balance : <?php   echo  ($acc_balance+0); ?></strong></p>
                        <br>
  
                        <p> RIP Token Withdraw : 
                        <input type="hidden" name="pay_amount" value="<?=$pay_amount?>"   /><?= ($pay_amount+0)?> </p>
						  <p> Deduction  :   <?=$deduction_rate?>%  </p> <br>
                     
                       <p ><strong>RIP Token Address:
                        <input type="hidden" name="pay_for" value="<?=$pay_for?>" /> <?=$pay_for?> </strong></p>
                      
						 <br>

						<button type="submit" name="Submit"class="btn btn-primary mr-2" value="Confirm Payment">Confirm Payment</button>
                      
					  
					  <? }  ?>
              
               </form>
			     </div>
                  <!-- /tables -->
                </div>
                <!-- /card body -->
              </div>
              <!-- /card -->
            </div>
            <!-- /grid item -->
          </div>
          <!-- /grid -->
        </div>
        <!-- Footer -->
        <? include("includes/footer.php")?>
        <!-- /footer -->
      </div>
      <!-- /site content wrapper -->
      <!-- Theme Chooser -->
      <!-- /theme chooser -->
      <!-- Customizer Sidebar -->
      <!-- /customizer sidebar -->
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
<? include("includes/extra_footer.php")?>
</body>
</html>
