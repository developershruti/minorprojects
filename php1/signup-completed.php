<?php
include ("includes/surya.dream.php");  
$page='registration' ;
//protect_user_page();

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<?php include("includes/extra_head.inc.php") ?>
</head>
<body>
<!-- preloader start -->
<?php include("includes/loader.inc.php") ?>
<!-- preloader end -->
<!-- ==========Header Section Starts Here========== -->
<?php include("includes/header.inc.php") ?>
<!-- ==========Header Section Ends Here========== -->
<!-- ===========Banner Section start Here========== -->
<section class="pageheader-section" style="background-image: url(assets/images/pageheader/bg.jpg);">
  <div class="container">
    <div class="section-wrapper text-center text-uppercase">
      <h2 class="pageheader-title">Registration </h2>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Registration</li>
        </ol>
      </nav>
    </div>
  </div>
</section>
<!-- ===========Banner Section Ends Here========== -->
<!-- Login Section Section Starts Here -->
<div class="login-section padding-top padding-bottom">
  <div class=" container">
    <div class="account-wrapper">
      <h3 class="title">Registration Completed</h3>
      <? include("error_msg.inc.php");?>
      <form name="registration" class="login-form "  id="contact-form" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data"  <?= validate_form()?> >
        <? 
if ($u_id=='') {
	if ($_SESSION['sess_recid']!='') {$u_id=$_SESSION['sess_recid'];} else {$u_id = $_SESSION['sess_uid'];} 
}
								
$sql = "select * from ngo_users where  u_id ='$u_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
							  ?>
        <table width="100%" border="0" style="margin-left:auto; margin-right:auto;"   >
          <tr>
            <td width="38%"  align="left" style="text-align:left;" > Name </td>
            <td width="4%" align="center">:</td>
            <td width="58%" align="left" valign="top" style="text-align:right;"><?=$u_fname." ".$u_lname?></td>
          </tr>
          <?php /*?><tr>
                      <td width="50%" align="left" style="text-align:left;" > Mobile </td><td align="center">: </td>
					  <td width="50%" align="left" valign="top" style="text-align:left;"> <?=$u_mobile?>
                      </td>
                    </tr><?php */?>
          <tr>
            <td  align="left" valign="top" style="text-align:left;" > User ID </td>
            <td align="center">:</td>
            <td  align="left" valign="top" style="text-align:right;"><?=$u_username?>
            </td>
          </tr>
          <tr>
            <td   align="left" valign="top" style="text-align:left;" >Password </td>
            <td align="center">:</td>
            <td  align="left" valign="top" style="text-align:right;"><?=$u_password?>
            </td>
          </tr>
          <tr>
            <td   align="left" valign="top" style="text-align:left;" nowrap="nowrap" >Security Key </td>
            <td align="center">:</td>
            <td  align="left" valign="top" style="text-align:right;"><?=$u_password2?>
            </td>
          </tr>
          <tr>
            <td   align="left" valign="top" style="text-align:left;" >Sign Up Date </td>
            <td align="center">:</td>
            <td  align="left" valign="top" style="text-align:right;"><?=date_format2($u_date)?>
            </td>
          </tr>
          <?php /*?><tr>
            <td   align="left" valign="top" style="text-align:left;"  nowrap="nowrap">Sponsor Id &nbsp;&nbsp;&nbsp;</td>
            <td align="center">: </td>
            <td  align="left" valign="top" style="text-align:right;"><?=db_scalar("select u_username from ngo_users where u_id = '$u_ref_userid'");?>
            </td>
          </tr><?php */?>
          <tr>
            <td   align="left" valign="top" style="text-align:left;" >Email </td>
            <td align="center">: </td>
            <td  align="left" valign="top" style="text-align:right;">&nbsp;
              <?=$u_email?>
            </td>
          </tr>
          <?php /*?><tr>
                      <td   align="left" valign="top" style="text-align:left;" >City  </td><td align="center">: </td> </td>
					  <td width="50%" align="left" valign="top" style="text-align:left;"> <?=$u_city?>
                      </td>
                    </tr><?php */?>
        </table>
      </form>
      <div class="account-bottom"> <span class="d-block cate pt-10">Back To login <a href="login.php">Click Here</a></span>
        <?php /*?><span class="or"><span>or</span></span>
        <h5 class="subtitle">Register With Social Media</h5>
        <ul class="match-social-list d-flex flex-wrap align-items-center justify-content-center mt-4">
          <li><a href="#"><img src="assets/images/match/social-1.png" alt="vimeo"></a></li>
          <li><a href="#"><img src="assets/images/match/social-2.png" alt="youtube"></a></li>
          <li><a href="#"><img src="assets/images/match/social-3.png" alt="twitch"></a></li>
        </ul><?php */?>
      </div>
    </div>
  </div>
</div>
<!-- Login Section Section Ends Here -->
<!-- ================ footer Section start Here =============== -->
<?php include("includes/footer.inc.php") ?>
<!-- ================ footer Section end Here =============== -->
<?php include("includes/extra_footer.inc.php") ?>
</body>
</html>
