<?php
include ("includes/surya.dream.php");  
 

if(is_post_back()) {
 	extract($_POST);
	///print "select count(*) from ngo_users where  u_email='$u_email' and u_username='$u_username' and u_status='Active'";
	$total_count = db_scalar("select count(*) from ngo_users where   u_username='$u_username' and u_status='Active'");
	if ($total_count >0){
  	$sql="select * from ngo_users where  u_username='$u_username' and u_status='Active'";
	$result = db_query($sql);
	if($line=mysqli_fetch_array($result)){
 	 @extract($line); 
	 
		 
	$message = "Dear $u_fname Your User ID is :$u_username ,Password is :$u_password and Tr Password is :$u_password2";
 	///send_sms($u_mobile,$message);
				
			
 	$message="
	Dear $u_fname
	
	Here are your ".SITE_NAME." login details:
	
	-------------------------------
	Your User ID is  : $u_username 
	Your Password is  : $u_password 
	Transaction Password is  : $u_password2  
	-------------------------------
	
	Sincerely, 
 	
	". SITE_NAME;
	
		$HEADERS  = "MIME-Version: 1.0 \n";
		$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
		$HEADERS .= "From: ".SITE_NAME." <".ADMIN_EMAIL.">\n";
 		$SUBJECT  = SITE_NAME ." Login Information";
	 	
 		if (mail($u_email, $SUBJECT, $message,$HEADERS)) {
		 $status ="done";
		 $arr_error_msgs[] ="Password sent on your email successfully!  ";
 		# header("Location: forgot_password_thanks.php");
		# exit;
		}
 	}
   } else {
    $arr_error_msgs[] ="Username address does not match with register one! ";
    }
  
}
 $_SESSION['arr_error_msgs'] = $arr_error_msgs;
?>
<!doctype html>
<html class="no-js" lang="en-US">
  
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
 
<? include("includes/extra_file2.inc.php")?>

<body class="page-template-default page page-id-16 theme-profund give-test-mode give-page woocommerce-account woocommerce-page woocommerce-no-js woocommerce elementor-default" data-spy="scroll" data-target=".mainmenu-area">
 
<? include("includes/extra_head.inc.php")?>
 <? include("includes/header.inc.php")?>
<header class="header-area center" style="background-image:url(wp-content/uploads/2019/08/section-4.jpg);">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h3 class="page-title">Forgot Password </h3>
        <div class="bread sub-title"><a href="index.php" ><span class="icon"><i class="flaticon-home"></i></span>Home</a><span class="separator">|</span><span class="current">Forgot Password</span></div>
        <!-- .breadcrumbs -->
      </div>
    </div>
  </div>
</header>
<div class="section-padding page-contents">
  <div class="container">
    <div class="post-16 page type-page status-publish hentry" >
      <div class="woocommerce">
        <div class="woocommerce-notices-wrapper"></div>
        <h2>Forgot Password</h2>
       <?
			 if ($status =='done') {
			 ?>
            <div class="error"> Your password information has been sent to your email address.</div>
            <?
			 } else {
			 ?>
			 <? include("error_msg.inc.php");?>
                           <form   name="form2"    method="post"   id="contactform" class="woocommerce-form woocommerce-form-login login"  action="<?=$_SERVER['PHP_SELF']?>" <?= validate_form()?>>
          <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="username">Username&nbsp;<span class="required">*</span></label>
 			<input name="u_username" type="text" placeholder="Your Id Number"   class="woocommerce-Input woocommerce-Input--text input-text"  alt="blank" emsg="Please enter Your Id Number  "  >
          </p>
          
          <p class="form-row">
            
            <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="Log in">Submit <span class="dir-part"></span> <i class="fa fa-paper-plane"></i></button>
          </p>
          
		  
		   <? } ?>
        </form>
      </div>
    </div>
  </div>
</div>
<? include("includes/footer.inc.php")?>
<? include("includes/extra_footer.inc.php")?>
</body>
</html>
