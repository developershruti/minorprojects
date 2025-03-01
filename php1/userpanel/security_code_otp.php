<?
include ("../includes/surya.dream.php"); 
 if(is_post_back()) {
 if ($_POST[Submit]=='Continue') {
 	/*$sql = "select * from ngo_users where  u_password2 = '$u_password2' and u_id='$_SESSION[sess_uid]'  ";
	$result = db_query($sql);
	if ($line= mysql_fetch_array($result)) {
		@extract($line);
	*/	
		$confirmation_code = rand(100000,999999);
 		$_SESSION['confirmation_code'] = $confirmation_code;	
		$ip 		= gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$today 		= db_scalar(" select ADDDATE(now(),INTERVAL 750 MINUTE) ");
		//Dear #value You need an OTP to access DBC Financial Transaction/ Account Addition. NEVER SHARE IT WITH ANYONE. DBC NEVER CALLS TO VERIFY IT. The OTP is #value
		//$message 	=  SITE_NAME ." Account login confirmation code is : " .$confirmation_code;
		$message = "Dear $u_fname You need an OTP to access Rozipay Financial Transaction/ Account Addition. NEVER SHARE IT WITH ANYONE. The OTP is " .$confirmation_code;
    send_sms('91'.$_SESSION['sess_mobile'],$message);
     

   	$message="

 	 Dear $u_fname,

  You need an OTP to access Financial Transaction  

	 NEVER SHARE IT WITH ANYONE. ".SITE_NAME.". NEVER CALLS TO VERIFY ANYTHING. 

	 OTP CODE IS :  ".$confirmation_code." 

	 Thanks 

	 ".SITE_NAME."

 	  ";

	#$u_email  = $_SESSION[sess_email];
	#$HEADERS  = "MIME-Version: 1.0 \n";
	#$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
	#$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
	#$SUBJECT  = SITE_NAME." OTP ";
  #if ($u_email!='') {  @mail($u_email, $SUBJECT, $message,$HEADERS); }
  
$to = $_SESSION['sess_email']; //'surya.dream@gmail.com';
$subject =SITE_NAME." OTP ";
//$message = 'Hello messages';

sendmail($to, $subject, $message);


  
	////////////////////////////////////////////////
	$arr_error_msgs[] = "Please Enter Email/Mobile Verification  code bellow.";
	$action='Continue';

} else if  ($_POST[Submit]=='Submit') {

	

	if ($_SESSION['confirmation_code'] ==$_POST[confirmation_code2]) { 

			$_SESSION['sess_security_code2'] = $confirmation_code2;

			if ($_SESSION['sess_back']!='') {

			 	header("location: ".$_SESSION['sess_back']);

				$_SESSION['sess_back']='';	

				exit;	

			} else {

 				 header("location: myaccount.php");

				 exit;	

 			}

 		} else {

			$arr_error_msgs[] =  "Invalid OTP Code! Please Try Again";

			$_SESSION['arr_error_msgs'] = $arr_error_msgs;

			header("location:security_code_otp.php");

			exit;	

			

 		}

	

}



 

   /*

   $sql = "select * from ngo_users where  u_password2 = '$u_password2' and u_id='$_SESSION[sess_uid]'  ";

	$result = db_query($sql);

	if ($line= mysql_fetch_array($result)) {

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
<!DOCTYPE html>
<html lang="en">
  <? include("includes/extra_head.php")?> 
   <? include ("../includes/fvalidate.inc.php"); ?>
</head>
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
          <div class="profile">
            <!-- Profile Banner -->
            <div class="profile__banner">
              <!-- Profile Banner Top -->
              <div class="profile__banner-detail">
                <!-- Avatar Wrapper -->
                <div class="dt-avatar-wrapper">
                  <!-- Avatar -->
                  <?
									  // print UP_FILES_FS_PATH.'/profile/'.$u_photo ;
								  if (($u_photo!='')&& (file_exists(UP_FILES_FS_PATH.'/profile/'.$u_photo))) { 
								 
								  ?>
											     <img src="<?=UP_FILES_WS_PATH.'/profile/'.$u_photo?>"   class="dt-avatar dt-avatar__shadow size-90 mr-sm-4">	<!--<img src="<?=show_thumb(UP_FILES_WS_PATH.'/profile/'.$u_photo,100,150,'resize')?>" align="center" />-->
												<? }  else { ?>
												<img src="images/no_pic.png"  align="center"    class="dt-avatar dt-avatar__shadow size-90 mr-sm-4" width=""/>
												<? }  ?> 
                  <!-- /avatar -->
                  <!-- Info -->
                  <div class="dt-avatar-info"> <span class="dt-avatar-name display-4 mb-2 font-weight-light"><?=$u_fname?></span> <span class="f-16"><?=$u_email?></span> </div>
                  <!-- /info -->
                </div>
                <!-- /avatar wrapper -->
                 
              </div>
              <!-- /profile banner top -->
              <!-- Profile Banner Bottom -->
               
              <!-- /profile banner bottom -->
            </div>
            <!-- /profile banner -->
            <!-- Profile Content -->
            <div class="profile-content">
              <!-- Grid -->
              <div class="row">
                <!-- Grid Item -->
                <div class="col-xl-4 order-xl-2">
                  <!-- Grid -->
                  <div class="row">
                    <!-- Grid Item -->
                     
                    <!-- /grid item -->
                    <!-- Grid Item -->
                    <div class="col-xl-12 col-md-6 col-12 order-xl-1">
                      <!-- Card -->
                      <div class="dt-card dt-card__full-height">
                        <!-- Card Header -->
                         
                        <!-- /card header -->
                        <!-- Card Body -->
                        <? include("includes/right.php")?>
                        <!-- /card body -->
                      </div>
                      <!-- /card -->
                    </div>
                    <!-- /grid item -->
                  </div>
                  <!-- /grid -->
                </div>
                <!-- /grid item -->
                <!-- Grid Item -->
                <div class="col-xl-8 order-xl-1">
                  <!-- Card -->
                  <div class="card">
                    <!-- Card Header -->
                    <div class="card-header card-nav bg-transparent border-bottom d-sm-flex justify-content-sm-between">
                      <h3 class="mb-2 mb-sm-n5">  OTP Verification  </h3>
                       
                    </div>
                    <div class="dt-card__body">
  <table  width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="td_box" >
        <tr>
         <td valign="top"  height="300"   align="center"><?
 
							   if ($action == '')  { ?>
          <form id="form2" name="form2" method="post" style="margin:0px;"    enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
           <br>
           Verify your email before make any transaction. A Verification Code will be send to following Email <br>
           <br>
           <table  border="1"  width="600"align="center" cellpadding="2" cellspacing="2" class="td_box">
            <!-- <tr>

                                <td align="left" valign="top" class="maintxt">Transaction Password : </td>

                                <td align="left" valign="top" class="maintxt"><input name="u_password2" type="password" class="inpts"   id="u_password2" size="30" alt="blank" emsg="Please Enter security code" /></td>

                              </tr>-->
            <tr>
             <td align="right"  width="30%" valign="top" class="maintxt">Your Mobile and Email : &nbsp;&nbsp; </td>
             <td align="left" valign="top" class="maintxt">&nbsp;&nbsp;
             <?=$_SESSION[sess_mobile]?>/ <?=$_SESSION[sess_email]?></td>
            </tr>
            <tr>
             <td   align="left" valign="top">&nbsp;</td>
             <td   align="left" valign="top"><input name="Submit" type="submit"  class="sbmt" value="Continue" /></td>
            </tr>
            <tr>
             <td colspan="2" valign="top" ></td>
            </tr>
           </table>
          </form>
          <? } else if ($action == 'Continue') { ?>
          <form id="form2" name="form2" method="post" style="margin:0px;"    enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
           <br>
           <br>
           A Verification Code sent to your Mobile and Email,  please enter code bellow. <br>
           <br>
           <br>
           <table  border="1"  width="600"align="center" cellpadding="2" cellspacing="2" class="td_box">
            <tr>
             <td align="left" valign="top" class="maintxt">Enter OTP code : </td>
             <td align="left" valign="top" class="maintxt"><input name="confirmation_code2" type="text" class="inpts"   id="confirmation_code2" size="30" alt="blank" emsg="Please Enter OTP code" /></td>
            </tr>
            <tr>
             <td   align="left" valign="top">&nbsp;</td>
             <td   align="left" valign="top"><input name="Submit" type="submit" class="sbmt" value="Submit" /></td>
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
                    <!-- /card body -->
                  </div>
                  <!-- /card -->
                  <!-- Card -->
                   
                  <!-- /card -->
                  <!-- Card -->
                   
                  <!-- /card -->
                </div>
                <!-- /grid item -->
              </div>
              <!-- /grid -->
            </div>
            <!-- /profile content -->
          </div>
        </div>
        <!-- Footer -->
        
        <!-- /footer --> <? include("includes/footer.php")?>
      </div>
      
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
 
<!-- /contact user information -->
<!-- masonry script -->

 <? include("includes/extra_footer.php")?>
</body>
 
</html>

   