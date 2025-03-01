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
$arr_error_msgs = array();

#if ($pay_group=='' || $pay_group2=='') { $arr_error_msgs[] =  "Something Went Wrong Please Try Again!" ;}
 
#if ($pay_group=='NON_WORKING') { $arr_error_msgs[] =  "You can use  Non-Working income in Re-Activate your account only." ;}

 ////if ($pay_group!='') { $sql_part ="  and pay_group='$pay_group'";}
 
///$acc_balance =  db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]'   $sql_part ")+0;
//if ($pay_group!='') { $sql_part ="  and pay_group='$pay_group'";}
 
 
 // and pay_group='$pay_group'  
$acc_balance =  db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' ")+0;
 
if ($acc_balance <1) { 
  	$arr_error_msgs[] =  "No suficient account balance for transfer" ;  
 	$stop='stop';
} 


///check Total Direct  start
 $total_direct= db_scalar("select  count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and topup_amount>='30.00'  and u_ref_userid ='$_SESSION[sess_uid]' ")+0;
 
 if ($total_direct < 4) { 
  	$arr_error_msgs[] =  "4 Direct Sponsor Compulsory for make any Transfer" ;  
 	//$stop='stop'; 
  }
 //$MINIMUM_EWALLET_TRANSFER = db_scalar("select sett_value from ngo_setting where  sett_code ='MINIMUM_EWALLET_TRANSFER' limit 0,1");
$MINIMUM_EWALLET_TRANSFER = 10;
 

if(is_post_back()) { 

  /*
if ($pay_amount < $MINIMUM_EWALLET_TRANSFER) {
			$arr_error_msgs[] = "Minimum ewallet fund transfer $MINIMUM_EWALLET_TRANSFER ";
}  
*/
$pay_userid = db_scalar("select u_id from ngo_users where u_username = '$pay_username' ");	
 
 
// check user name

#$total_count = db_scalar("select count(*) from ngo_users where u_username = '$pay_username'");
#if ($total_count==0) { $arr_error_msgs[] =  $u_username." Username does not exit!  " ;} 

if ($acc_balance<$pay_amount) {
			$arr_error_msgs[] = "No suficient account balance for transfer  ";
} 

if ((double)$pay_amount<=0) {
			$arr_error_msgs[] = "Invalid value, You can't transfer it ";
} 

                                                                                                        
/*$MINIMUM_EWALLET_TRANSFER = db_scalar("select sett_value from ngo_setting where  sett_code ='MINIMUM_EWALLET_TRANSFER' limit 0,1")+0;
*/
$MINIMUM_EWALLET_TRANSFER =5;
if ($pay_amount<$MINIMUM_EWALLET_TRANSFER) {
			$arr_error_msgs[] = "Minimum transfer value is ". price_format($MINIMUM_EWALLET_TRANSFER);
} 

if (count($arr_error_msgs) ==0) {
	
	if ($_POST['Submit']=='Continue') {
		$arr_error_msgs[] = "Are you sure want to transfer value into $pay_username account ?";
		$action = 'Continue';
   
   	} else if  ($_POST['Submit']=='Confirm Payment') {
		$action = 'Confirm';
	//print_r($_POST);
		
		$pay_ref_amt = $pay_amount;
 		$deduction_rate = 10;
 		$deduction_amount = ($pay_amount/100)*$deduction_rate;
		
		$pay_rate = 100 - $deduction_rate; 
		$transfer_pay_amount = ($pay_amount/100)*$pay_rate;
		
		$pay_for1 = "Fund received from $ARR_PAYMENT_GROUP[$pay_group]  $_SESSION[sess_username] - ".$pay_for;
		$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$_SESSION[sess_uid]' ,pay_plan='FUND_RECEIVE',pay_transaction_no='$pay_plan',pay_group='CW' ,pay_for = '$pay_for1' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$transfer_pay_amount', pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql1);
		$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
		
		$pay_for2 = "$ARR_PAYMENT_GROUP[$pay_group] transfered  in  Wallet - ".$pay_for;
		$sql2 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_refid' ,pay_plan='FUND_TRANSFER' ,pay_group='WI'  ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$transfer_pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
		db_query($sql2);
 		
		if ($deduction_amount >0) { 
		$pay_for2 = "Deduction @ $deduction_rate % on ".price_format($pay_ref_amt)." ".$ARR_PAYMENT_GROUP[$pay_group];
 		$sql2 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_refid' ,pay_plan='DEDUCTION'  ,pay_group='$pay_group' ,pay_transaction_no='0',pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$deduction_rate', pay_amount = '$deduction_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		db_query($sql2);
		}
		
 	 	$arr_error_msgs[] ="Fund transfered successfully in my wallet";
 	 
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
              <h4 class="mb-sm-0">Transfer To Club Wallet </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Withdraw & Transfer</a></li>
                  <li class="breadcrumb-item active">Transfer To Club Wallet </li>
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
                <h4 class="card-title mb-0 flex-grow-1">Transfer To Club Wallet </h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 
                <div class="live-preview">
 
 
  
                    <p align="center" >
                      <? include("error_msg.inc.php");?>
                    </p> 
  
    
  
              
<form method="post" name="form1" id="form1"  <?= validate_form()?>  class="forms-sample">
                 
                     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="table table-striped" >
                      
                       
					   <?   if ($action=='')  { ?>
                    
					   <tr>
                        <td align="right" width="50%"  style=" text-align:right;">Account Balance : </td>
                        <td align="left" valign="middle" style=" text-align:left;"><strong>
						<?php   echo  $acc_balance+0; ?></strong></td>
                      </tr>
                     
                      <tr>
                        <td  align="right" valign="middle" style=" text-align:right;">Transfer Fund : </td>
                        <td width="50%" align="left" valign="middle"style=" text-align:left;"><input type="text" class="form-control" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank"  required/>                        </td>
                      </tr>

                       <tr>
                        <td align="right" valign="top" style=" text-align:right;">Note : </td>
                        <td align="left" style=" text-align:left;"> <input type="text" class="form-control" name="pay_for" value="<?=$pay_for?>" alt="blank" emsg="Note can not be blank"  required/>  <!--<textarea name="pay_for" cols="30" rows="3" alt="blank" class="form-control" emsg="Naration can not be blank" required><?=$pay_for?></textarea> --> </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left">
						<? if ($stop=='') {?> 
						<input type="hidden" name="pay_group" value="<?=$pay_group?>">
						<input name="Submit" type="submit" class="btn btn-primary text-uppercase"   value="Continue" /> 
						<!--&nbsp;&nbsp;<input name="Reset" type="reset"  value=" Reset " />-->
						<?  } ?>						</td>
                      </tr>
					  <? } else if ($action=='Continue') { ?>
 					 <!--  <tr>
                         <td align="right">Plan Name : </td>
                         <td align="left"><strong>
                           <?php  // echo  $plan; ?>
                         </strong></td>
                       </tr>-->
					   <tr>
                        <td align="right" style="  text-align:right;">Account Balance : </td>
                        <td align="left" style=" text-align:left;"><strong>
						<?php   echo price_format($acc_balance); ?></strong></td>
                      </tr>
                      <tr>
                     <!--   <td align="right">Transfer Date : </td>
                        <td align="left"><?php echo  date_format2(db_scalar("select now()")); ?></td>
                      </tr>-->
                      <tr>
                        <td  align="right" style=" text-align:right;">Transfer Fund : </td>
                        <td width="50%" align="left" style=" text-align:left;"><input type="hidden" name="pay_amount" value="<?=$pay_amount?>"   required/><?=price_format($pay_amount)?></td>
                      </tr>
                       <tr>
                        <td align="right" valign="top" style=" text-align:right;">Specification (If Any):  </td>
                        <td align="left" style=" text-align:left;"><input type="hidden" name="pay_for" value="<?=$pay_for?>" required/> <?=$pay_for?> </td>
                      </tr>
                      <tr>
                        
                        <td align="center" colspan="2">
						 <input type="hidden" name="pay_group" value="<?=$pay_group?>">
						<input name="Submit" type="submit"  class="btn btn-primary text-uppercase"  value="Confirm Payment" />  </td>
                      </tr>
					  
					  <? }  ?>
                    </table>
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
