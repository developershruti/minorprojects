<?
include ("../includes/surya.dream.php");
$pg='afterlogin'; 
if(is_post_back()) {
 $arr_error_msgs = array();
 $arr_success_msgs = array();
  
 
 
 if ($_POST['Submit']=='Continue') {
 	/*$sql = "select * from ngo_users where  u_password2 = '$u_password2' and u_id='$_SESSION[sess_uid]'  ";
	$result = db_query($sql);
	if ($line= mysqli_fetch_array($result)) {
		@extract($line);
	*/
	///$user_last_otp_datetime = db_scalar("select u_last_otp_datetime from ngo_users where u_id = '$_SESSION[sess_uid]'  ");
 	 
	
	//$data_day = db_scalar("select DATE_FORMAT(DATE_ADD( NOW() , INTERVAL 330 MINUTE ), '%a')  as date");
	
	/// Daily OTP Limit Check Start 
	//$today_otp_attempts_count = db_scalar("select count(*) from ngo_users_otp_log where elog_userid = '$_SESSION[sess_uid]'  ");
	
	
	
 	if($_SESSION['confirmation_code3']==''){ 
 		$confirmation_code3 = rand(100000,999999);
 		$_SESSION['confirmation_code3'] = $confirmation_code3;	
 		} else { 
 		$confirmation_code3 = $_SESSION['confirmation_code3'];
 		$_SESSION['confirmation_code3'] = $confirmation_code3;	 
 		} 
		
		$ip 		= gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$today 		= db_scalar(" select ADDDATE(now(),INTERVAL 750 MINUTE) ");
		$to_email 		= db_scalar("select u_email from ngo_users where u_id='$_SESSION[sess_uid]'");
		$usr_fname 		= db_scalar("select u_fname from ngo_users where u_id='$_SESSION[sess_uid]'");
		 
		//Dear #value You need an OTP to access DBC Financial Transaction/ Account Addition. NEVER SHARE IT WITH ANYONE. DBC NEVER CALLS TO VERIFY IT. The OTP is #value
		//$message 	=  SITE_NAME ." Account login confirmation code is : " .$confirmation_code3;
		//$message = "Dear $u_fname You need an OTP to access Kezex Financial Transaction/ Account Addition. NEVER SHARE IT WITH ANYONE. The OTP is " .$confirmation_code3;
		//$message = "Dear $u_fname You need an OTP to verify Kezex.io NEVER SHARE IT WITH ANYONE. The OTP is " .$confirmation_code3;
		/*Hello [User],

Your OTP for verification is: [OTP].

Please do not share this OTP with anyone. It is valid for [X] minutes.

Thank you,
[Your Company Name]*/
		/*$html_message = "<p>Hello ".$usr_fname.", <br/>

Your OTP for verification is: ".$confirmation_code3.".<br/>

Please do not share this OTP with anyone.<br/>

Thank you,<br/>
".SITE_NAME." Team<p>";*/


$html_message = '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Confirmation</title>
<style>
    /* Add your custom styles here */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
    }
    .container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
	 .header {
            text-align: center;
            padding: 20px 0;
			background-color: #1A2157;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            padding: 20px; background-color: #eee;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            color: #666666;
            line-height: 1.6;
        }
        .content a {
            color: #1a73e8;
            text-decoration: none;
        }
       
    h1, h4 {
        text-align: center;
        color: #333!important;
    }
    p {
        margin-bottom: 20px;
        line-height: 1.6;
    }
    .btn {
        display: inline-block;
        background-color: #007bff!important;
        color: #fff!important;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 3px;
    }
 	 .footer {
            text-align: center;
            padding: 20px;
            color: #999999;
            font-size: 12px;
			background-color: #1A2157;
        }
</style>
</head>
<body>

<div class="container">
 <div class="header">
            <img src="'.SITE_WS_PATH.'/assets/images/logo/logo.png" alt="'.SITE_NAME.'">
             
        </div>
 <div class="content">
    <h4>Account Verification OTP </h4>
   Hello "'.$usr_fname.'", <br/>

Your OTP for verification is: "'.$confirmation_code3.'".<br/>

Please do not share this OTP with anyone.<br/>
     
    
    <p>If you have any questions or need further assistance, please dont hesitate to <a href="'.SITE_URL.'/contact.php" target="_blank">contact</a> us.</p>
    <p>Best regards,<br>'.SITE_NAME.'</p>
</div>
<div class="footer">
            <p>Best regards,<br>'.SITE_NAME.' Team</p>
        </div>
</div>
 



</body>
</html>
';



 	 	//send_sms_whatsapp($_SESSION['sess_mobile'],$message);
	/// send_sms_whatsapp($usr_mobile,$message);
	 $subject = 'One-Time Password for Email Verification'; 
   	 send_email_mailtrap($to_email, $usr_fname, $subject, $html_message);
 	//$u_email  = $_SESSION['sess_email'];
	/*$HEADERS  = "MIME-Version: 1.0 \n";
	$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
	$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
	$SUBJECT  = SITE_NAME." OTP ";*/
	//if ($u_email!='') {  @mail($u_email, $SUBJECT, $message,$HEADERS); }
	////////////////////////////////////////////////
	
	
	
	$arr_error_msgs[] = "Kindly check your Email Inbox for the OTP code.";
	$action='Continue';
	
	///// update in user table 
	
	//$sql_otps = "update ngo_users set u_last_otp_datetime = ADDDATE(now(),INTERVAL 0 MINUTE) where u_id = '$_SESSION[sess_uid]'  ";
    //$result_otps = db_query($sql_otps);
	///
	
	

} else if ($_POST['Submit']=='Submit') {

	

	if ($_SESSION['confirmation_code3'] ==$_POST['confirmation_code4']) { 

			$_SESSION['sess_security_code4'] = $confirmation_code4;

			// update account status 
			$sql_update="update ngo_users set u_verify_email_status='Verified' where u_id='".$_SESSION['sess_uid']."'";
 		    db_query($sql_update);
 			$_SESSION['sess_verify_email_status']	= 'Verified';
			///$_SESSION['sess_verify_email_status'] = $u_verify_email_status;
 			 /// Self Registration Bonus 
 			 $signup_bonus_count = db_scalar("select count(pay_id) from ngo_users_ewallet where pay_plan='SIGNUP_BONUS' and pay_userid ='".$_SESSION['sess_uid']."' and pay_refid ='".$_SESSION['sess_uid']."' and pay_group='RW'  ")+0;
			 
			 if ($signup_bonus_count==0) {
 			 $pay_for3 = "Sign Up Bonus";
			 $pay_amount=50; // $50 to self 
 			$sql3 = "insert into ngo_users_ewallet set pay_drcr='Cr' ,pay_userid ='".$_SESSION['sess_uid']."' ,pay_refid ='".$_SESSION['sess_uid']."' ,pay_group='RW',pay_plan='SIGNUP_BONUS' ,pay_for = '$pay_for3' ,pay_ref_amt='$pay_amount' ,pay_unit = '$' ,pay_rate = '$pay_amount', pay_amount = '$pay_amount'  , pay_status = 'Paid', pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='INSTANT' ";
 			db_query($sql3); 
			
			
			
			///////// Level Sign up referral bonus 
 			$u_ref_userid = $_SESSION['sess_uid'];
 			$ctr=0;
			while ($ctr<3) { 
			$ctr++;
			$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
			//$referral_verify_email_status = db_scalar("select u_verify_email_status from ngo_users where u_id='$u_ref_userid' "); // temp disabled sksksk
			$referral_verify_email_status = 'Verified';  // every one will be treat as verified account
 			//$topup_amount_active_count = db_scalar("select count(*) from ngo_users_recharge_stack where topup_userid='$u_ref_userid' ")+0;
			//&& $topup_amount_active_count>=1
 			if ($u_ref_userid!='' && $u_ref_userid!=0 && $referral_verify_email_status=='Verified'){
  				if($ctr==1)		{ $pay_rate =25; } // $25
				else if($ctr==2){ $pay_rate =10;} // $10
				else if($ctr==3){ $pay_rate =5;} //// $5
			//	else if($ctr==4){ $pay_rate =1;}
 			//if($ctr==1){ $pay_plan ='DIRECT_INCOME';} else {$pay_plan ='LEVEL_INCOME';}
				$pay_plan2 ='SIGNUP_REFERRAL_BONUS';
 				//$pay_ref_amt = $topup_amount /$token_price;
				$pay_ref_amt = $pay_rate;
 				//$pay_amount_ref = ($pay_ref_amt/100)*$pay_rate;
				$pay_amount_ref = $pay_ref_amt;
				$pay_for2 ="Sign Up Referral Level $ctr # Bonus From ".$_SESSION['sess_username'];
 				//$sql2 = "insert into ngo_users_coin set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id',pay_plan='$pay_plan' ,pay_group='WI' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount_ref' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='SPOT' ";
				$sql2 = "insert into ngo_users_ewallet set pay_drcr='Cr' ,pay_userid ='".$u_ref_userid."' ,pay_refid ='".$_SESSION['sess_uid']."' ,pay_group='RW',pay_plan='$pay_plan2' ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '$' ,pay_rate = '$pay_rate', pay_amount = '$pay_ref_amt'  , pay_status = 'Paid', pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='INSTANT' ";
				db_query($sql2);
				  
 			} 
 		}
			 
			 
			 
			 
			 
			 /// Free Referral Earning Model distribution start 
		    /*if($_SESSION['sess_verify_status'] == 'Verified' && $_SESSION['sess_verify_email_status'] == 'Verified'){	
 			$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='".$_SESSION['sess_uid']."'");
			
			$referral_verify_status = db_scalar("select u_verify_status from ngo_users where u_id='$u_ref_userid' ");
			$referral_verify_email_status = db_scalar("select u_verify_email_status from ngo_users where u_id='$u_ref_userid' ");
  			
			if($referral_verify_status == 'Verified' && $referral_verify_email_status == 'Verified'){	
			
			$txn_join_date = db_scalar("select u_date from ngo_users where u_id='".$_SESSION['sess_uid']."' ");
			
			 
			
			if($txn_join_date<'2024-03-09'){ 
			$pay_rate=0.50; // promotional rate ///0.50 
			} else if($txn_join_date>='2024-03-09' && $txn_join_date<='2024-03-15'){  
			$pay_rate=0.25; // promotional rate ///0.25  
			} else { 
			$pay_rate=0.15; //  // regular rate  0.15 //
			} 
 			
 			$pay_ref_amt = $pay_rate; //$pay_ref_amt = $topup_amount;
			$ref_topup_amount= $pay_ref_amt; 
			//$ref_topup_amount= db_scalar("select max(topup_amount) from ngo_users_recharge  where topup_userid ='$u_ref_userid'  ")+0;
 			$pay_amount = $pay_rate;
			$payout_count = db_scalar("select count(pay_id) from ngo_users_payment where pay_refid ='".$_SESSION['sess_uid']."' and pay_userid = '$u_ref_userid' and pay_plan='FREE_DIRECT_INCOME' ")+0;
  			if ($payout_count==0) {
   		 	$pay_for2 = "Free Referral Earning from ".$_SESSION['sess_username'];
			$sql2 = "insert into ngo_users_payment set pay_drcr='Cr' ,pay_userid ='$u_ref_userid' ,pay_refid ='".$_SESSION['sess_uid']."' ,pay_group='FI',pay_plan='FREE_DIRECT_INCOME' ,pay_plan_level='0'  ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='SPOT' ";
 			db_query($sql2);
					} 
 				} 
			} */
		 
		   /// Free Referral Earning Model distribution end 
			 
			 
			 }
			 
			 $_SESSION['confirmation_code3'] = NULL;	
			 $arr_success_msgs[] = "You have successfully verified your email id.";
			 $_SESSION['arr_success_msgs'] = $arr_success_msgs;
 			 header("location: myaccount.php");
 			 exit;	
			
			
			/*if ($_SESSION['sess_back']!='') {

			 	header("location: ".$_SESSION['sess_back']);

				$_SESSION['sess_back']='';	

				exit;	

			} else {

 				 header("location: myaccount.php");

				 exit;	

 			}*/

 		} else {
 			$arr_error_msgs[] =  "Invalid OTP Code! Please Try Again";
 			$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 			header("location: verify_acc_otp.php");
 			exit;	
  		}
 
}



 

   /*

   $sql = "select * from ngo_users where  u_password2 = '$u_password2' and u_id='$_SESSION[sess_uid]'  ";

	$result = db_query($sql);

	if ($line= mysqli_fetch_array($result)) {

		@extract($line);

 			$_SESSION['sess_security_code'] = $u_password2;

   			if ($_SESSION['sess_back']!='') {

			 	header("location: ".$_SESSION['sess_back']);

				$_SESSION['sess_back']='';	

				exit;	

			} else {

 				 header("location: myaccount.php");

				 exit;	

 			}*/

 }



 

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
              <h4 class="mb-sm-0">Verify Email OTP </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard </a></li>
                  <li class="breadcrumb-item active">Verify Email OTP </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
		 <? // include("error_msg.inc.php");?>
          <div class="col-xxl-6 centered">
		   <? include("error_msg.inc.php");?>
            <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Continue to verify your Email! </h4>
               </div>
              <!-- end card header -->
              <div class="card-body">
                 <div class="live-preview">
 								
											
<table  width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="td_box" >
  <tr>
    <td valign="top" align="center"><?
 
							   if ($action == '')  { ?>
      <form id="form2" name="form2" method="post" style="margin:0px;"    enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <p align="center">To activate your account Verify your Email Id. A verification code will be sent to your email. To get your OTP, log in to your email account, check both your Inbox and Spam folder, and note that the OTP is valid for 10 minutes. </p>
        <table border="0"  width="100%" align="center" cellpadding="2" cellspacing="2" class="td_box">
          <!-- <tr>

                                <td align="left" valign="top" class="maintxt">Transaction Password : </td>

                                <td align="left" valign="top" class="maintxt"><input name="u_password2" type="password" class="inpts"   id="u_password2" size="30" alt="blank" emsg="Please Enter security code" /></td>

                              </tr>-->
          <tr>
            <td align="center"  width="100%" valign="top" class="maintxt"  >Your Email :
              <span class="badge bg-primary text-lg " style="font-size:15px"><?=db_scalar("select u_email from ngo_users where u_id='$_SESSION[sess_uid]'")?></span> <br>
<?php /*?><p class="text-danger "><br>
Dear Bigson.live User,

We are temporarily disabling our email verification service due to high traffic and a significant volume of bounced emails. We are working to resolve the issue and will restore the service shortly.

We appreciate your patience and understanding during this time.

Best regards,
The Bigson.live Team</p><?php */?>
To update your email address, please <a href="profile_edit" class="btn btn-sm btn-primary blink_text">click here.</a>            </td>
          </tr>
          <tr>
            <td align="center" valign="top" style="text-align:center;"  colspan="2" ><br>
              <?  if($_SESSION['sess_verify_email_status'] == 'Pending'){ ?>
              <input name="Submit" type="submit"  class="btn btn-primary" value="Continue" /> 
              <? } ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" valign="top" ></td>
          </tr>
        </table>
      </form>
      <? } else if ($action == 'Continue') { ?>
      <form id="form2" name="form2" method="post" style="margin:0px;" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <br>
        A Verification Code sent to your email inbox, To get your OTP, check both your Inbox and Spam folder, and note that the OTP is valid for 10 minutes. please enter code below. <br>
        <br>
        <table  border="0" width="100%"align="center" cellpadding="2" cellspacing="2" class="td_box">
          <tr>
            <td align="right" valign="top" class="maintxt">Enter OTP code : </td>
            <td align="left" valign="top" class="maintxt"><input name="confirmation_code4" type="text" class="form-control" id="confirmation_code4" maxlength="6" size="30" alt="blank" emsg="Please Enter OTP code" /></td>
          </tr>
          <tr>
            <td   align="left" valign="top">&nbsp;</td>
            <td   align="left" valign="top"><input name="Submit" type="submit" class="btn btn-primary" value="Submit" /></td>
          </tr>
          <tr>
            <td colspan="2" valign="top" ></td>
          </tr>
        </table>
      </form>
      <? }  ?>
    </td>
  </tr>
</table>


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

