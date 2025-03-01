<?php
include ("includes/surya.dream.php");
protect_user_page();
 
 /// check account balance 
 
$sql_hc="SELECT SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit,SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit, (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'";
$result_hc=db_query($sql_hc);
$row_hc=mysqli_fetch_array($result_hc);
 	
				 
?> 
<!DOCTYPE html>
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>
<?=SITE_URL?>
</title>
<? include("includes/extra_file.inc.php")?>
 <!-- IE Fix for HTML5 Tags -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<!-- header start here -->
<? include("includes/header.inc.php")?>
<!-- header end here -->
<!-- pagetitle start here -->
<section id="pagetitle-container">
  <div class="row">
    <div class="twelve column">
      <h1>Pin-Wallet Details</h1>
      <h3>View your Pin-Wallet Balance</h3>
    </div>
    <div class="twelve column breadcrumb">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li class="current-page"><a href="#">Pin-Wallet Balance</a></li>
      </ul>
    </div>
  </div>
</section>
<!-- pagetitle end here -->
<!-- content section start here -->
<section class="content-wrapper">
  <div class="row">
    <div class="four column mobile-two">
      <div class="note-folded green"  style="width:950px;">
      <h4>Account  Balance</h4>
      <p>


      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="mainbox">
         <tr>
          <td align="right" valign="top"> 
            <!--main  content table start -->
             <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td height="300" align="center" valign="top"><br />
                  <br />
                <table width="61%"  border="0" cellpadding="2" cellspacing="2" class="td_box">
                       <tr>
                        <td  colspan="3" class="tdhead">E-wallet  Summary</td>
                       </tr> 
                      <tr>
                        <td colspan="2">&nbsp;</td>
                        <td width="50%"><? include("error_msg.inc.php");?></td>
                      </tr> 
					  
                       <tr>
                         <td width="9%" height="30" align="right">&nbsp;</td>
                         <td width="41%" align="left">Total Credit Amount :</td>
                         <td><strong>
                           <?php   echo  price_format($row_hc['credit']+0); ?>
                         </strong></td>
                       </tr>
                       <tr>
                         <td height="30" align="right">&nbsp;</td>
                         <td height="30" align="left">Total Debit Amount :</td>
                         <td><strong>
                           <?php   echo  price_format($row_hc['debit']+0); ?>
                         </strong></td>
                       </tr>
                      <tr>
                        <td height="30" align="right">&nbsp;</td>
                        <td height="30" align="left">E-wallet Account Balance :</td>
                        <td><strong class="subtitle">
						<?php   echo  price_format($row_hc['balance']+0); ?></strong></td>
                      </tr>
                </table>                
                <br />			    </td>
              </tr>
            </table>
            <!--main content table end -->          </td>
        </tr>
      </table>
	  
      </p>
    </div>
  </div>
  <div class="twelve column">  <hr/> </div>
  </div>
   </div>
</section>
<? include("includes/footer.inc.php")?>
</body>
</html>
