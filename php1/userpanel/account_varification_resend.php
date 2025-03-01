<?php
include ("includes/surya.dream.php");  
 

if(is_post_back()) {
 	extract($_POST);
	$total_count = db_scalar("select count(*) from ngo_users where  u_email='$u_email' and u_username='$u_username' and u_status='Active'");
	if ($total_count >0){
  	$sql="select * from ngo_users where  u_email='$u_email' and u_username='$u_username' and u_status='Active'";
	$result = db_query($sql);
	if($line=mysqli_fetch_array($result)){
 	 @extract($line); 
	 
	 
	$message = "Dear ".$u_fname." " .$u_lname."  Your" .SITE_NAME.".  User ID is :".$u_username." ,Password is :".$u_password." and Tr Password is :".$u_password2." for more details visit ".SITE_URL;
	$mobile = '91'.$u_mobile;
	#send_sms($mobile,$message);
			
			
 	$message="
	Dear $u_fname
	
	Here are your ".SITE_NAME." login details:
	
	-------------------------------
	Your User ID is  : $u_username 
	Your Password is  : $u_password 
	Transaction Password is : $u_password2 
	-------------------------------
	
	Sincerely, 
 	
	". SITE_NAME;
	
		$HEADERS  = "MIME-Version: 1.0 \n";
		$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
		$HEADERS .= "From: ".SITE_NAME." <".ADMIN_EMAIL.">\n";
 		$SUBJECT  = SITE_NAME ." Login Information";
	 	
 		if (mail($u_email, $SUBJECT, $message,$HEADERS)) {
		 $status ="done";
		 $arr_error_msgs[] ="Email sent successfully!  ";
 		# header("Location: forgot_password_thanks.php");
		# exit;
		}
 	}
   } else {
    $arr_error_msgs[] ="Email address does not match with register one! ";
    }
   $_SESSION['arr_error_msgs'] = $arr_error_msgs;
}

?>
<!DOCTYPE html>
<head>
<title>
<?=$META_TITLE?>
</title>
<meta charset=utf-8 >
<meta name="robots" content="index, follow" >
<meta name="keywords" content="" >
<meta name="description" content="" >
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="favicon.ico">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,700,300' rel='stylesheet' type='text/css'>
<!-- CSS begin -->
<?php include("includes/extra_file.inc.php");?>
<?php include("includes/fvalidate.inc.php");?>
</head>
<body id="top">
<?php include("includes/header.inc.php");?>
<!-- PAGE TITLE -->
<div class="container m-bot-25 clearfix">
  <div class="sixteen columns">
    <h1 class="page-title">Forgot Password</h1>
  </div>
</div>
 <!-- CONTENT -->
<div class="container m-bot-25 clearfix">
  <div class="sixteen columns">
    <div class="content-container-white">
      <div class="border-top-dashed under-content-caption">
            <h2><span class="bold">Forgot</span> Password</h2>
             
          
			
		<form id="form2" name="form2" method="post" action="<?=$_SERVER['PHP_SELF']?>" <?= validate_form()?>>
         
          <table width="75%" border="0" cellpadding="3" cellspacing="3"  align="center" class="td_box2">
               
               <tr>
                <td height="20" colspan="3"  align="left" valign="top" class="maintxt"><? include("error_msg.inc.php");?></td>
              </tr>
             
             
             <?
			 if ($status =='done') {
			 ?>
			<!--  <tr>
                
                <td height="14" colspan="2" valign="top" >Your password information has been sent to your email address. </td>
              </tr>-->
			 <?
			 } else {
			 ?>
			  <tr>
                <td height="20" colspan="3"  align="left" valign="top" class="maintxt">Please enter your E-mail Address to retrieve your password.</td>
              </tr>
              
              <tr>
                <td colspan="3" valign="top"  align="center">&nbsp;</td>
              </tr>
			  <tr>
			    <td align="left" valign="top">&nbsp;</td>
			    <td align="left" valign="top"> User ID </td>
			    <td align="left" valign="top"><input name="u_username" type="text"  class="txtbox" id="u_username" size="20" alt="blank" emsg="Please enter your user ID" /></td>
			  </tr>
			  <tr>
			    <td width="36" align="left" valign="top">&nbsp;</td>
                <td width="128" align="left" valign="top"> E-mail Address </td>
                <td width="282" align="left" valign="top"><input name="u_email" type="text"  class="txtbox" id="u_email" size="20" alt="blank" emsg="Please enter your E-mail Address to retrieve your password" /></td>
              </tr>
              <tr>
                <td align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
                <td align="left" valign="top"> <input name="Submit" type="submit" class="button"   value="&nbsp;Submit&nbsp;" />				 </td>
              </tr>
              <? } ?>
              <tr>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td height="20" valign="top">&nbsp;</td>
              </tr>
          </table>
        </form> 
	  </p>
      </div>
    </div>
    <div class="content-under-container-white"></div>
  </div>
</div>
 
<?php include("includes/footer.inc.php");?>
<p id="back-top"> <a href="#top" title="Back to Top"><span></span></a> </p>
</body>
</html>