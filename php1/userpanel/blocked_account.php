<?php
include ("includes/surya.dream.php");
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
      <h1>Account Blocked</h1>
      <h3>Your Account has been Blocked</h3>
    </div>
    <div class="twelve column breadcrumb">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li class="current-page"><a href="#">Account Blocked</a></li>
      </ul>
    </div>
  </div>
</section>
<!-- pagetitle end here -->
<!-- content section start here -->
<section class="content-wrapper">
<div class="row">
<div class="twelve column">
<div class="four column mobile-two">
<div class="note-folded" style="width:920px; height:500px;" align="left">
<h4>Account Blocked</h4>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="td_box">
  <tr>
    <td height="50" valign="top"><br>
    </td>
  </tr>
  <tr>
    <td height="330" align="center" valign="top" class="error"><h3> ID is  <span style="color:#FF0000;">blocked</span> as it was not upgraded within 48 hours of registration.<br>
        <br>
          <p class="error">
          <?=$_SESSION['sess_blocked_msg']?>
        </p>
         <br>
        Contact support for assistance.
        <p>&nbsp;</p>
        Thank You </h3>
      </p>
      &nbsp;&nbsp; </td>
  </tr>
</table>

  </div>
      </div>
      <hr/>
    </div>
  </div>
</section>
<!-- content section end here -->
<!-- bottom content start here -->
<!-- bottom content end here -->
<!-- footer start here -->
<? include("includes/footer.inc.php")?>
</body>
 </html>

