<?php include("includes/surya.dream.php");
$pg = "register";

/// Ajax code 
require_once(SITE_FS_PATH . "/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_referal_details");
sajax_handle_client_request();
// END Ajax code
///if ($_GET['ref']!='') {  $_SESSION['ref']= $_GET['ref'];  } 
if ($u_ref_userid == '') {
	$u_ref_userid = $_SESSION['ref'];
}
//if ($_SESSION['u_ref_side']!='') { $u_ref_side = $_SESSION['u_ref_side'];}
//if ($_SESSION['ref']!='') { $u_ref_side = $_SESSION['ref_side'];}

if (is_post_back()) {
	if ($u_ref_userid == '') {
		$u_ref_userid = $_SESSION['ref'];
	}

	$arr_error_msgs = array();
	@extract($_SESSION['POST']);
	@extract($_POST);
	$ip =  gethostbyaddr($_SERVER['REMOTE_ADDR']);

	// $arr_error_msgs[] =  "We are upgrading our server services to serve you better. Kindly have patience for some time. As we start our Sign up process back, you will be informed accordingly.";
	/*$total_count = db_scalar("select count(*) from ngo_users where u_username = '$u_username'");
		if ($total_count >0) { $arr_error_msgs[] =  "An account already exists for username:" .$u_username;}  */

	#$total_ref = db_scalar("select count(u_id) from ngo_users where u_id = '$u_ref_userid' ");
	$u_ref_userid = ms_form_value($u_ref_userid);
	if ($u_ref_userid != '') {

		if ($u_ref_userid == 'xxxxxxxxxxxxxxxxxxxxxxxx') {
			$total_ref = db_scalar("select count(u_id) from ngo_users where u_username = '$u_ref_userid'") + 0;
		} else {
			//$total_ref = db_scalar("select count(u_id) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_username = '$u_ref_userid' and topup_group='ACT' and topup_status='Paid' ")+0;
			$total_ref = db_scalar("select count(u_id) from ngo_users where u_username = '$u_ref_userid'") + 0;
		}
		if ($total_ref == 0) {
			$arr_error_msgs[] =  "Invalid Sponsor ID, Please try again!";
		}
	} /*else {
		 $u_ref_userid =   db_scalar("select u_username from ngo_users where u_id <=2");
		}*/

	$email_count = db_scalar("select count(*) from ngo_users where u_email = '$u_email'");
	if ($email_count > 0) {
		$arr_error_msgs[] =  "This e-mail is already registered with us.";
	}
	///if ($u_ref_side =='') { $arr_error_msgs[] =  "Please select referer side";}
	#$mobile_count = db_scalar("select count(*) from ngo_users where u_mobile = '$u_mobile'");
	#if ($mobile_count >0) { $arr_error_msgs[] =  "This mobile no is already registered with us.";}

	if ($u_fname == '') {
		$arr_error_msgs[] = "Your Name is required!";
	}
	if ($u_country_code == '') {
		$arr_error_msgs[] = "Country code is mandatory!";
	}
	if ($u_mobile == '') {
		$arr_error_msgs[] = "Mobile number required!";
	}
	if ($u_email == '') {
		$arr_error_msgs[] = "Email is required!";
	}
	#if ($u_city =='') { $arr_error_msgs[] = "City name required!";}
	#if ($u_state =='') { $arr_error_msgs[] = "State name required!";}
	/*if ($u_country == '') {
		$arr_error_msgs[] = "Please select your country name!";
	}*/

	/*if ($captcha != $_SESSION['CAPTCHA_CODE']) {
		$arr_error_msgs[] = "Captcha string does not match";
	}*/

	if ($u_password == '') {
		$arr_error_msgs[] = "Please enter valid password!";
	}
	#if (strlen($u_mobile)<10) { $arr_error_msgs[] =  "Invalid cell number ($u_mobile)!";}

	//$first_number = strtoupper(substr($u_mobile, 0,1));  
	///if ($first_number <=6 || strlen($u_mobile)<20) { $arr_error_msgs[] =  "Invalid cell number ($u_mobile)!";}

	/*
		if ($_POST['conf_num2']!=$_SESSION['conf_num1']){ 
			$arr_error_msgs[] ="Confirmation number does not match"; 
 		}*/


	#$total_limit = db_scalar("select count(u_id) from ngo_users where u_fname = '$u_fname' and u_dob = '$u_dob' and  u_ref_userid = '$u_ref_userid' and  u_bank_acno='$u_bank_acno' and u_mobile = '$u_mobile'");
	#if ($total_ref >=7) { $arr_error_msgs[] =  "Maximum limit over! you can only open 7 account for same name,mobile,DOB, Bank Acc";}

	$ip =  gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
	//check if there is no error

	if (count($arr_error_msgs) == 0) {
		$u_ref_userid = db_scalar("select  u_id from ngo_users where u_username = '$u_ref_userid'");
		///$u_sponsor_id = get_sponsor_id($u_ref_userid,$u_ref_side);
		$u_parent_id = db_scalar("select u_parent_id from ngo_users  order by u_id desc limit 0,1") + rand(1, 9);

		// $abc= array('A','B','C','D','E','F','G','H','I','J','K','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'); 
		$abc = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		//	$abc= array('1','2','3','4','5','6','7','8','9'); 
		$arr = array_rand($abc, 2);
		$conf_num = "";
		$conf_num .= $abc[$arr[0]];
		$conf_num .= $abc[$arr[1]];
		//$conf_num.=$abc[$arr[2]];
		//$conf_num.=$abc[$arr[3]];
		//$conf_num.=$abc[$arr[4]];
		//$prefix=$conf_num;
		$prefix = 'KT';
		$u_username = $prefix . rand(1, 9) . $u_parent_id . rand(1, 9);  /// u_parent_id = 1000
		//$u_username = 'CE'.rand(10,99).$u_parent_id.rand(1,9);
		// $u_username = rand(1,9).$u_parent_id.rand(1,9);
		///,u_ref_side='$u_ref_side', u_sponsor_id = '$u_sponsor_id',u_ref_side='$u_ref_side', u_lname = '$u_lname' 
		$u_fname = ms_form_value($u_fname);
		$u_address = ms_form_value($u_address);
		$u_city = ms_form_value($u_city);
		$u_email = ms_form_value($u_email);
		//$u_country_code = ms_form_value($u_country_code);
		$u_mobile = ms_form_value(trim($u_mobile));
		$u_state = ms_form_value($u_state);
		$u_country = ms_form_value($u_country);
		$u_password = ms_form_value($u_password);
		// u_state = '$u_state',, u_city = '$u_city', u_country = '$u_country'
		$sql = "insert into ngo_users set  u_parent_id = '$u_parent_id',u_username='$u_username',u_email='$u_email', u_password = '$u_password',u_password2 = '$u_password', u_fname = '$u_fname'  , u_country_code = '$u_country_code', u_mobile = '$u_mobile',u_ref_userid = '$u_ref_userid', u_verify_email_status='Verified', u_status='Active', u_date= ADDDATE(now(),INTERVAL 330 MINUTE), u_datetime= ADDDATE(now(),INTERVAL 330 MINUTE), u_last_login=ADDDATE(now(),INTERVAL 330 MINUTE) ";
    
		$result = db_query($sql);
		$topup_userid = mysqli_insert_id($GLOBALS['dbcon']);
		$_SESSION['sess_recid'] = $topup_userid;
		$_SESSION['CAPTCHA_CODE'] = NULL; // RESET CAPTCHA CODE FROM SESSION AFTER SUCCESSFUL LOGIN
		// Send dummy
		// email 
		/*$message="
Hi ". $u_fname .", 

Thank you for becoming a member of the ". SITE_NAME .".  

Your login information is provided below.  
 
Username = ". $u_username ."
Password = ". $u_password. " 
Transaction Password = ". $u_password. " 
 
To ensure that you continue receiving our emails, please add us to your address book or safe list.

Once again, Thank you for being a part of our team!

". SITE_NAME ."
". SITE_URL ."
";
 
  			#$HEADERS  = "MIME-Version: 1.0 \n";
			#$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
			#$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
			#$SUBJECT  = SITE_NAME." Registration";
 			#if ($u_email!='') { @mail($u_email, $SUBJECT, $message,$HEADERS); }
 
			$to = $u_email; 
			$subject =SITE_NAME." Registration";*/
		//$message = 'Hello messages';
		#sendmail($to, $subject, $message);


		//// send mail code end //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			

		$to_email 		=  $u_email;
		$usr_fname = $u_fname;

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
            <img src="' . SITE_WS_PATH . '/assets/images/logo/logo.png" alt="' . SITE_NAME . '">
             
        </div>
 <div class="content">
    <h4>Registration Confirmation</h4>
    <p>Dear ' . $u_fname . ',</p> 
	<p>Thank you for joining membership of the ' . SITE_NAME . ',</p>
<p>Your Account credentials details is provided below. <br/>
URL : ' . SITE_URL . '/login.php <br/>
Username : ' . $u_username . ' <br/>
Password : ' . $u_password . '<br/>
Security Password : ' . $u_password . ' <p>
    <p>Thank you for registering with us. Your account has been successfully created.</p>
    <p>You can now <a href="' . SITE_URL . '/login.php" target="_blank"  class="btn">log in</a> to access your account.</p>
    <p>If you have any questions or need further assistance, please dont hesitate to <a href="' . SITE_URL . '/contact.php" target="_blank">contact</a> us.</p>
    <p>Best regards,<br>' . SITE_NAME . '</p>
</div>
<div class="footer">
            <p>Best regards,<br>' . SITE_NAME . ' Team</p>
        </div>
</div>
 



</body>
</html>
';

		$subject = SITE_NAME . " Registration completed successfully ";
		send_email_mailtrap($to_email, $usr_fname, $subject, $html_message);
		//// send mail code end //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				


		$_SESSION['POST'] = '';
		header("Location: signup_completed.php");
		exit;
	}
}
/*$_SESSION[POST]='';
if ($pin!='') {
	$sql_code= "select * from ngo_code where code_userid='$_SESSION[sess_uid]' and code_string='$pin'";
	$result_code = db_query($sql_code);
	$line_code = mysql_fetch_array($result_code);
	///$u_slno = $line_code['code_id'];
	$u_code = $line_code['code_string'];
}*/


?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<?php include("includes/extra_head.inc.php") ?>
<script language="javascript">
		<? sajax_show_javascript(); ?>

		//------check ref availability code start------------------------------------------------
		function do_get_referal_details() {
			document.getElementById('referal_details').innerHTML = "Loading...";
			ref_userid = document.registration.u_ref_userid.value;
			x_get_referal_details('referal_details', ref_userid, do_get_referal_details_cb);
		}

		function do_get_referal_details_cb(z) {
			document.getElementById('referal_details').innerHTML = z;
		}
	</script>
</head>
<body data-mobile-nav-style="classic" class="custom-cursor">
<!-- ==========Header Section Starts Here========== -->
<?php include("includes/header.inc.php") ?>
<!-- ==========Header Section Ends Here========== -->
<!-- ===========Banner Section start Here========== -->
<section id="home" class="bg-light-gray cover-background" style="background-image: url('images/demo-cryptocurrency-hero-bg.jpg')">
  <div class="container position-relative">
    <div class="row pt-12 mb-14 xxl-pt-10 xl-pt-6 xxl-mb-10 sm-pt-70px xs-mb-35px">
      <div class="col-md-6 mx-auto">
        <div class="login-wrapper p-5 rounded-4 shadow" style="background: linear-gradient(to right, green, darkblue);">
          <h3 class="text-center mb-4 text-white">Create Account</h3>
          <? include("error_msg.inc.php"); ?>
          <form name="registration" class="account-form text-start" id="registration" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" <?= validate_form() ?>>
            <div class="form-group mb-4">
              <span class="form-label fw-medium mb-2 text-white">Sponsor ID *</span>
              <div class="input-group"> <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                <input name="u_ref_userid" type="text" class="form-control py-2 text-dark" 
                                        id="u_ref_userid" style="color:black; font-weight:bold"
                                        value="<? if ($_SESSION['sess_uid'] == '') { ?><?= $u_ref_userid ?><? } else { ?><?= $_SESSION['sess_username'] ?><? } ?>" 
                                        tabindex="1" alt="blank" emsg="Please Enter Sponsor ID" 
                                        onChange="do_get_referal_details();" placeholder="Enter sponsor ID" />
              </div>
              <div id="referal_details" class="form-text text-warning mt-1"></div>
            </div>
            <div class="form-group mb-4">
              <span class="form-label fw-medium mb-2 text-white">Password *</span>
              <div class="input-group"> <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control py-2 text-dark password-input" 
                                        onpaste="return false" placeholder="Create strong password"
                                        name="u_password" id="u_password" style="color:black; font-weight:bold"
                                        tabindex="2" alt="blank" emsg="Please Enter Password">
                <span class="input-group-text cursor-pointer toggle-password"><i class="fas fa-eye"></i></span> </div>
            </div>
            <div class="form-group mb-4">
              <span class="form-label fw-medium mb-2 text-white">Full Name *</span>
              <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input name="u_fname" type="text" class="form-control py-2 text-dark" 
                                        id="u_fname" value="<?= $u_fname ?>" style="color:black; font-weight:bold"
                                        tabindex="3" alt="blank" emsg="Please Enter Name" 
                                        placeholder="Enter your full name" />
              </div>
            </div>
            <div class="form-group mb-4">
              <span class="form-label fw-medium mb-2 text-white">Mobile Number *</span>
              <div class="input-group"> <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <select name="u_country_code" id="u_country_code" style="float:right; margin-right:5px; color:black; font-weight:bold; " alt="select" emsg="Select Country Code" tabindex="4" class="form-select py-2 text-dark"   >
                  <option class="form-control py-2 text-dark"  value="">Country Code</option>
                  <? if ($u_country_code != '') { ?>
                  <option value="<?= $u_country_code ?>" selected="selected">
                  <?= $u_country_code ?>
                  </option>
                  <? } ?>
                  <option class="form-control py-2 text-dark"   value="+93" style="background: url(images/flags/af.png) no-repeat; padding-left: 20px;">India +91 </option>
                  <option class="form-control py-2 text-dark"   value="+355" style="background: url(images/flags/al.png) no-repeat; padding-left: 20px;">Albania +355 </option>
                  <option class="form-control py-2 text-dark"  value="+213" style="background: url(images/flags/dz.png) no-repeat; padding-left: 20px;">Algeria +213 </option>
                  <option class="form-control py-2 text-dark"   value="+1684" style="background: url(images/flags/as.png) no-repeat; padding-left: 20px;">American Samoa +1684 </option>
                  <option  class="form-control py-2 text-dark" value="+376" style="background: url(images/flags/ad.png) no-repeat; padding-left: 20px;">Andorra +376 </option>
                  <option class="form-control py-2 text-dark"  value="+244" style="background: url(images/flags/ao.png) no-repeat; padding-left: 20px;">Angola +244 </option>
                  <option class="form-control py-2 text-dark"   value="+1264" style="background: url(images/flags/ai.png) no-repeat; padding-left: 20px;">Anguilla +1264 </option>
                  <option class="form-control py-2 text-dark"   value="+0" style="background: url(images/flags/aq.png) no-repeat; padding-left: 20px;">Antarctica +0 </option>
                  <option class="form-control py-2 text-dark"  value="+1268" style="background: url(images/flags/ag.png) no-repeat; padding-left: 20px;">Antigua And Barbuda +1268 </option>
                  <option class="form-control py-2 text-dark"  value="+54" style="background: url(images/flags/ar.png) no-repeat; padding-left: 20px;">Argentina +54 </option>
                  <option class="form-control py-2 text-dark"  value="+374" style="background: url(images/flags/am.png) no-repeat; padding-left: 20px;">Armenia +374 </option>
                  <option class="form-control py-2 text-dark"  value="+297" style="background: url(images/flags/aw.png) no-repeat; padding-left: 20px;">Aruba +297 </option>
                  <option class="form-control py-2 text-dark"  value="+61" style="background: url(images/flags/au.png) no-repeat; padding-left: 20px;">Australia +61 </option>
                  <option class="form-control py-2 text-dark"  value="+43" style="background: url(images/flags/at.png) no-repeat; padding-left: 20px;">Austria +43 </option>
                  <option class="form-control py-2 text-dark"  value="+994" style="background: url(images/flags/az.png) no-repeat; padding-left: 20px;">Azerbaijan +994 </option>
                  <option class="form-control py-2 text-dark"  value="+1242" style="background: url(images/flags/bs.png) no-repeat; padding-left: 20px;">Bahamas +1242 </option>
                  <option class="form-control py-2 text-dark"  value="+973" style="background: url(images/flags/bh.png) no-repeat; padding-left: 20px;">Bahrain +973 </option>
                  <option class="form-control py-2 text-dark"  value="+880" style="background: url(images/flags/bd.png) no-repeat; padding-left: 20px;">Bangladesh +880 </option>
                  <option class="form-control py-2 text-dark"  value="+1246" style="background: url(images/flags/bb.png) no-repeat; padding-left: 20px;">Barbados +1246 </option>
                  <option class="form-control py-2 text-dark"  value="+375" style="background: url(images/flags/by.png) no-repeat; padding-left: 20px;">Belarus +375 </option>
                  <option value="+32" style="background: url(images/flags/be.png) no-repeat; padding-left: 20px;">Belgium +32 </option>
                  <option class="form-control py-2 text-dark"  value="+501" style="background: url(images/flags/bz.png) no-repeat; padding-left: 20px;">Belize +501 </option>
                  <option class="form-control py-2 text-dark"  value="+229" style="background: url(images/flags/bj.png) no-repeat; padding-left: 20px;">Benin +229 </option>
                  <option class="form-control py-2 text-dark" value="+229" style="background: url(images/flags/bj.png) no-repeat; padding-left: 20px;">Benin +229 </option>
                  <option class="form-control py-2 text-dark" value="+1441" style="background: url(images/flags/bm.png) no-repeat; padding-left: 20px;">Bermuda +1441 </option>
                  <option class="form-control py-2 text-dark" value="+975" style="background: url(images/flags/bt.png) no-repeat; padding-left: 20px;">Bhutan +975 </option>
                  <option class="form-control py-2 text-dark" value="+591" style="background: url(images/flags/bo.png) no-repeat; padding-left: 20px;">Bolivia +591 </option>
                  <option class="form-control py-2 text-dark" value="+387" style="background: url(images/flags/ba.png) no-repeat; padding-left: 20px;">Bosnia And Herzegovina +387 </option>
                  <option class="form-control py-2 text-dark" value="+267" style="background: url(images/flags/bw.png) no-repeat; padding-left: 20px;">Botswana +267 </option>
                  <option class="form-control py-2 text-dark" value="+0" style="background: url(images/flags/bv.png) no-repeat; padding-left: 20px;">Bouvet Island +0 </option>
                  <option class="form-control py-2 text-dark" value="+55" style="background: url(images/flags/br.png) no-repeat; padding-left: 20px;">Brazil +55 </option>
                  <option class="form-control py-2 text-dark" value="+246" style="background: url(images/flags/io.png) no-repeat; padding-left: 20px;">British Indian Ocean Territory +246 </option>
                  <option class="form-control py-2 text-dark" value="+673" style="background: url(images/flags/bn.png) no-repeat; padding-left: 20px;">Brunei Darussalam +673 </option>
                  <option class="form-control py-2 text-dark" value="+359" style="background: url(images/flags/bg.png) no-repeat; padding-left: 20px;">Bulgaria +359 </option>
                  <option class="form-control py-2 text-dark" value="+226" style="background: url(images/flags/bf.png) no-repeat; padding-left: 20px;">Burkina Faso +226 </option>
                  <option class="form-control py-2 text-dark" value="+257" style="background: url(images/flags/bi.png) no-repeat; padding-left: 20px;">Burundi +257 </option>
                  <option class="form-control py-2 text-dark" value="+855" style="background: url(images/flags/kh.png) no-repeat; padding-left: 20px;">Cambodia +855 </option>
                  <option class="form-control py-2 text-dark" value="+237" style="background: url(images/flags/cm.png) no-repeat; padding-left: 20px;">Cameroon +237 </option>
                  <option class="form-control py-2 text-dark" value="+1" style="background: url(images/flags/ca.png) no-repeat; padding-left: 20px;">Canada +1 </option>
                  <option value="+238" style="background: url(images/flags/cv.png) no-repeat; padding-left: 20px;">Cape Verde +238 </option>
                  <option class="form-control py-2 text-dark" value="+1345" style="background: url(images/flags/ky.png) no-repeat; padding-left: 20px;">Cayman Islands +1345 </option>
                  <option class="form-control py-2 text-dark" value="+236" style="background: url(images/flags/cf.png) no-repeat; padding-left: 20px;">Central African Republic +236 </option>
                  <option class="form-control py-2 text-dark" value="+235" style="background: url(images/flags/td.png) no-repeat; padding-left: 20px;">Chad +235 </option>
                  <option class="form-control py-2 text-dark" value="+56" style="background: url(images/flags/cl.png) no-repeat; padding-left: 20px;">Chile +56 </option>
                  <option class="form-control py-2 text-dark"  value="+86" style="background: url(images/flags/cn.png) no-repeat; padding-left: 20px;">China +86 </option>
                  <option class="form-control py-2 text-dark" value="+61" style="background: url(images/flags/cx.png) no-repeat; padding-left: 20px;">Christmas Island +61 </option>
                  <option class="form-control py-2 text-dark" value="+672" style="background: url(images/flags/cc.png) no-repeat; padding-left: 20px;">Cocos (Keeling) Islands +672 </option>
                  <option class="form-control py-2 text-dark" value="+57" style="background: url(images/flags/co.png) no-repeat; padding-left: 20px;">Colombia +57 </option>
                  <option class="form-control py-2 text-dark" value="+269" style="background: url(images/flags/km.png) no-repeat; padding-left: 20px;">Comoros +269 </option>
                  <option class="form-control py-2 text-dark" value="+242" style="background: url(images/flags/cg.png) no-repeat; padding-left: 20px;">Congo +242 </option>
                  <option class="form-control py-2 text-dark" value="+242" style="background: url(images/flags/cd.png) no-repeat; padding-left: 20px;">Congo, The Democratic Republic Of The +242 </option>
                  <option class="form-control py-2 text-dark" value="+682" style="background: url(images/flags/ck.png) no-repeat; padding-left: 20px;">Cook Islands +682 </option>
                  <option class="form-control py-2 text-dark" value="+506" style="background: url(images/flags/cr.png) no-repeat; padding-left: 20px;">Costa Rica +506 </option>
                  <option class="form-control py-2 text-dark" value="+225" style="background: url(images/flags/ci.png) no-repeat; padding-left: 20px;">Cote D'Ivoire +225 </option>
                  <option class="form-control py-2 text-dark" value="+385" style="background: url(images/flags/hr.png) no-repeat; padding-left: 20px;">Croatia +385 </option>
                  <option class="form-control py-2 text-dark" value="+53" style="background: url(images/flags/cu.png) no-repeat; padding-left: 20px;">Cuba +53 </option>
                  <option class="form-control py-2 text-dark" value="+357" style="background: url(images/flags/cy.png) no-repeat; padding-left: 20px;">Cyprus +357 </option>
                  <option class="form-control py-2 text-dark" value="+977" style="background: url(images/flags/np.png) no-repeat; padding-left: 20px; ">Nepal +977 </option>
                  <option class="form-control py-2 text-dark" value="+31" style="background: url(images/flags/nl.png) no-repeat; padding-left: 20px;">Netherlands +31 </option>
                  <option class="form-control py-2 text-dark" value="+599" style="background: url(images/flags/an.png) no-repeat; padding-left: 20px;">Netherlands Antilles +599 </option>
                  <option class="form-control py-2 text-dark" value="+687" style="background: url(images/flags/nc.png) no-repeat; padding-left: 20px;">New Caledonia +687 </option>
                  <option class="form-control py-2 text-dark" value="+64" style="background: url(images/flags/nz.png) no-repeat; padding-left: 20px;">New Zealand +64 </option>
                  <option class="form-control py-2 text-dark" value="+505" style="background: url(images/flags/ni.png) no-repeat; padding-left: 20px;">Nicaragua +505 </option>
                  <option class="form-control py-2 text-dark" value="+227" style="background: url(images/flags/ne.png) no-repeat; padding-left: 20px;">Niger +227 </option>
                  <option class="form-control py-2 text-dark" value="+234" style="background: url(images/flags/ng.png) no-repeat; padding-left: 20px;">Nigeria +234 </option>
                  <option class="form-control py-2 text-dark" value="+683" style="background: url(images/flags/nu.png) no-repeat; padding-left: 20px;">Niue +683 </option>
                  <option class="form-control py-2 text-dark" value="+672" style="background: url(images/flags/nf.png) no-repeat; padding-left: 20px;">Norfolk Island +672 </option>
                  <option class="form-control py-2 text-dark" value="+1670" style="background: url(images/flags/mp.png) no-repeat; padding-left: 20px;">Northern Mariana Islands +1670 </option>
                  <option class="form-control py-2 text-dark" value="+47" style="background: url(images/flags/no.png) no-repeat; padding-left: 20px;">Norway +47 </option>
                  <option class="form-control py-2 text-dark" value="+968" style="background: url(images/flags/om.png) no-repeat; padding-left: 20px;">Oman +968 </option>
                  <option class="form-control py-2 text-dark" value="+92" style="background: url(images/flags/pk.png) no-repeat; padding-left: 20px;">Pakistan +92 </option>
                  <option class="form-control py-2 text-dark" value="+680" style="background: url(images/flags/pw.png) no-repeat; padding-left: 20px;">Palau +680 </option>
                  <option class="form-control py-2 text-dark" value="+970" style="background: url(images/flags/ps.png) no-repeat; padding-left: 20px;">Palestinian Territory, Occupied +970 </option>
                  <option class="form-control py-2 text-dark" value="+507" style="background: url(images/flags/pa.png) no-repeat; padding-left: 20px;">Panama +507 </option>
                  <option class="form-control py-2 text-dark" value="+675" style="background: url(images/flags/pg.png) no-repeat; padding-left: 20px;">Papua New Guinea +675 </option>
                  <option class="form-control py-2 text-dark" value="+595" style="background: url(images/flags/py.png) no-repeat; padding-left: 20px;">Paraguay +595 </option>
                  <option class="form-control py-2 text-dark" value="+51" style="background: url(images/flags/pe.png) no-repeat; padding-left: 20px;">Peru +51 </option>
                  <option class="form-control py-2 text-dark" value="+63" style="background: url(images/flags/ph.png) no-repeat; padding-left: 20px;">Philippines +63 </option>
                  <option class="form-control py-2 text-dark" value="+0" style="background: url(images/flags/pn.png) no-repeat; padding-left: 20px;">Pitcairn +0 </option>
                </select>
                <input name="u_mobile" type="text" class="form-control py-2 text-dark"
                                        id="u_mobile" value="<?= $u_mobile ?>" style="color:black; font-weight:bold"
                                        tabindex="5" alt="number" emsg="Please Enter Mobile Number"
                                        placeholder="Enter mobile number" />
              </div>
            </div>
            <div class="form-group mb-4">
              <span class="form-label fw-medium mb-2 text-white">Email Address *</span>
              <div class="input-group"> <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input name="u_email" type="text" class="form-control py-2 text-dark"
                                        id="u_email" value="<?= $u_email ?>" style="color:black; font-weight:bold"
                                        tabindex="6" alt="email" emsg="Please Enter Email Id"
                                        placeholder="Enter your email address" />
              </div>
            </div>
            <?php /*?><div class="form-group mb-4">
              <span class="form-label fw-medium mb-2 text-white">City *</span>
              <div class="input-group"> <span class="input-group-text"><i class="fas fa-city"></i></span>
                <input name="u_city" type="text" class="form-control py-2 text-dark"
                                        id="u_city" value="<?= $u_city ?>" style="color:black; font-weight:bold"
                                        tabindex="7" alt="blank" emsg="Enter city name"
                                        placeholder="Enter your city" />
              </div>
            </div><?php */?>
            <?php /*?><div class="form-group mb-4">
              <span class="form-label fw-medium mb-2 text-white">Country *</span>
              <div class="input-group"> <span class="input-group-text"><i class="fas fa-globe"></i></span>
                <?php
                                    $sql = "select countries_name, countries_name from ngo_countries order by countries_id";
                                    echo make_dropdown($sql, 'u_country', $u_country, 
                                        'class="form-select py-2 text-dark" style="color:black; font-weight:bold" alt="select" emsg="Select Your Country"', 
                                        'Select your country');
                                    ?>
              </div>
            </div><?php */?>
            <!-- 
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <span class="form-check-label text-white" for="terms">
                                    I agree to the <a href="terms.php" class="text-warning">Terms & Conditions</a>
                                </span>
                            </div> -->
            <button type="submit" class="btn btn-warning w-100 py-3 mb-3 fw-bold text-uppercase"> <i class="fas fa-user-plus me-2"></i>Create Account </button>
            <p class="text-center mb-0 text-white"> Already have an account? <a href="login.php" class="text-warning fw-bold">Login</a> </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ===========Banner Section Ends Here========== -->
<!-- ================ footer Section start Here =============== -->
<?php include("includes/footer.inc.php") ?>
<!-- ================ footer Section end Here =============== -->
<?php include("includes/extra_footer.inc.php") ?>
<script>
    // Add password visibility toggle
    document.querySelector('.toggle-password').addEventListener('click', function() {
        const password = document.querySelector('.password-input');
        const icon = this.querySelector('i');
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    </script>
</body>
</html>
