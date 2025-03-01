<?php
include ("includes/surya.dream.php");  
 if(is_post_back()) {
     extract($_POST);
     
     $u_username = ms_form_value($u_username);
     //$password = ms_form_value($password);
	/*if ($captcha==$_SESSION['CAPTCHA_CODE']){ */
		
	$total_count = db_scalar("select count(*) from ngo_users where  u_username='$u_username' and u_status='Active'");
	if ($total_count >0){
  	$sql="select * from ngo_users where  u_username='$u_username' and u_status='Active'";
	$result = db_query($sql);
	if($line=mysqli_fetch_array($result)){
 	 @extract($line); 
	 ///Dear #value Your User ID is :#value ,Password is :#value and Tr Password is :#value
	///$message = "Dear ".$u_fname." Your User ID is :".$u_username." ,Password is :".$u_password." and Tr Password is :".$u_password2.""; 
 	///$message = "Dear ".$u_fname.", Your login Username is ".$u_username." ,Password is ".$u_password." ,Txn Password is ".$u_password." Thanks  Support Team - ".SITE_URL;
 	#send_sms('91'.$u_mobile,$message);
	
 	/*$message="
	Dear $u_fname
	
	Your Account Information of ".SITE_NAME." are as follows:
	
	-------------------------------
	Your User ID is  : $u_username 
	Your Password is  : $u_password
	Your Transaction Password is : $u_password  
 
	-------------------------------
	
	Sincerely, 
 	
	". SITE_NAME;
    
    $to = $u_email; 
    $subject =SITE_NAME." Login Information";*/
    //$message = 'Hello messages';
    # sendmail($to, $subject, $message);
            
		#$HEADERS  = "MIME-Version: 1.0 \n";
		#$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
		#$HEADERS .= "From: ".SITE_NAME." <".ADMIN_EMAIL.">\n";
 		#$SUBJECT  = SITE_NAME ." Login Information";
 		#if (mail($u_email, $SUBJECT, $message,$HEADERS)) {
		# $status ="done";
		# $arr_error_msgs[] ="Password has been sent at your mobile/Emailsuccessfully!  ";
 		# header("Location: forgot_password_thanks.php");
		# exit;
		#}
			
	$to_email 		=  $u_email;
		$usr_fname = $u_fname;
		
		$html_message= '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Account Information </title>
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
    h1 {
        text-align: center;
        color: #333;
    }
    p {
        margin-bottom: 20px;
        line-height: 1.6;
    }
    .btn {
        display: inline-block;
        background-color: #BD3FF2;
        color: #fff!important;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 3px;
    }
</style>
</head>
<body>

<div class="container">
    <h1>Login Information </h1>
    <p>Dear '.$u_fname.',</p>
<p>Your account information is provided below.  <br/>
URL : '.SITE_URL.'/login.php <br/>
Username : '.$u_username.' <br/>
Password : '.$u_password.'<br/>
Transaction Password : '.$u_password2.' <p>

<p>You can now <a href="'.SITE_URL.'/login.php" target="_blank"  class="btn">log in</a> to access your account.</p>
<p>If you have any questions or need further assistance, please dont hesitate to <a href="'.SITE_URL.'/contact-us.php" target="_blank">contact</a> us.</p>
<p>Best regards,<br>'.SITE_NAME.'</p>
</div>

</body>
</html>
';

	   $subject = SITE_NAME ." Login Information";
   	   # send_email_mailtrap($to_email, $usr_fname, $subject, $html_message);
	   
	   $arr_success_msgs[] ="We have successfully emailed your account details!"; 
		
 	}
   
    } else {
    $arr_error_msgs[] ="Username does not exist! ";
    }
	/*} else {
	$arr_error_msgs[] ="Captcha string does not match"; 
 	
	}*/
   $_SESSION['arr_error_msgs'] = $arr_error_msgs;
   $_SESSION['arr_success_msgs'] = $arr_success_msgs;
}



?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php include("includes/extra_head.inc.php") ?>
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
                        <h3 class="text-center mb-4 text-white">Recover Password</h3>
                        <p class="text-center text-white mb-4">Enter your User ID to recover your password</p>
                       
                        <? include("error_msg.inc.php");?>
                        <form  id="contactForm" class="account-form text-start"  name="form2" method="post" action="<? ///=$_SERVER['PHP_SELF']?>" <?= validate_form()?>  > 
                            <div class="form-group mb-4">
                                <span class="form-label fw-medium mb-2 text-white">User ID *</span>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>

                                    <input name="u_username" type="text" class="form-control py-2 text-dark"
                                        id="email"  style="color:black; font-weight:bold" placeholder="User ID" size="20" alt="blank" emsg="Please enter your User ID"
                                        tabindex="1" alt="blank" emsg="Please enter your User ID">

                               
                                        <!-- <input name="u_username" type="text"  class="form-control" id="email" placeholder="User ID" size="20" alt="blank" emsg="Please enter your User ID" /> -->

                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 py-2 mb-3">
                                <i class="fas fa-key me-2"></i>Recover Password
                            </button>

                            <div class="text-center">
                                <p class="mb-0 text-white">
                                    Remember your password? <a href="login.php" class="text-warning">Login</a>
                                </p>
                                <p class="mb-0 text-white">
                                    Don't have an account? <a href="signup.php" class="text-warning">Sign Up</a>
                                </p>
                            </div>
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
</body>

</html>