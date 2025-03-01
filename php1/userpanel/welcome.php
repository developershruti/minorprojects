<?php
include ("includes/surya.dream.php");

$PAGE='welcome';
protect_user_page();
 

//print_r($_SESSION);and u_status='Active' 
//inner join ngo_users_type on ngo_users.u_utype=ngo_users_type.utype_id  and 
$sql = "select * from ngo_users where u_id ='$_SESSION[sess_uid]'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
 
 
$sql2 = "select *  from ngo_users_recharge inner join ngo_users on topup_userid=u_id  and topup_userid='$_SESSION[sess_uid]' " ;
$result2 = db_query($sql2);
$line2= mysqli_fetch_array($result2);
@extract($line2);

 $topup_amount = db_scalar("select utype_charges from ngo_users_type where utype_charges='$topup_amount'");
//print_r($line);

//  $SITE_CSS = $_SESSION[sess_css];
//print $_SESSION['sess_status'];
 
 
?>
 
 <!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

 <head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?=$META_TITLE?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php include("includes/extra_file.inc.php");?>
 <script type="text/javascript" src="js/modernizr.custom.11889.js" ></script>
 <?php include("includes/fvalidate.inc.php");?>
     </head>
<body>

	<!-- Primary Page Layout
	================================================== -->

<div id="wrap">
 <?php include("includes/header.inc.php");?>

 <!-- end-header -->
<section id="headline2">
<div class="container">
<h3>Welcome</h3>
</div>
</section>

<section class="container page-content" >

<section id="main-content">
 
<div class="columns" >
 
</div>
  
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="2"  >
                <tbody>
                  <tr><td width="10" ></td> 
                    <td    > 
Welcom to <?=SITE_NAME?><br />
 
                      Date:  <?=date_format2($line2['topup_date']);?><br />
                      <br />
                      <?=$u_fname." ".$u_lname;?><br />
                      <?=$u_address;?><br />
                      <?=$u_city;?><br />
                      Reference Number: <?= $line2['topup_id']; ?><br />
                      <br />
                      Dear <?=$u_fname." ".$u_lname;?>,<br />
                      <br />
                      <?=SITE_NAME?> would like to thank you for being our donor and contributing the amount of ($10) .<br />
                      <br />
                      We hereby acknowledge that no goods or services were exchanged against this donation. With your donation, we were able to provide goods or services  to the benefiting from the donation .<br />
                      <br />
                      Please retain this record to avail  benefits on your contribution as permitted by the law. We sincerely hope, you will also continue to support our initiatives in the near future.<br />
                      <br />
                      Thank you once again.<br />
                      <br />
                      With kind regards,<br />
                      <br />
                       <br />
                      <?=SITE_NAME?><br />                   </td>
                  </tr>
            </table>
	     
	  <br class="clear" />
 

</section>

<!-- end-main-conten -->
   <? include("includes/right.inc.php")?>
<!-- end-sidebar-->
<div class="white-space"></div>
</section><!-- container -->
        
            
           
        <!-- #main -->
    
        <!-- #sidebar -->
      </div>
      <!-- .inner -->
    </section>
    <!-- .pagemid -->
    <? include("includes/footer.inc.php")?>
    <!-- .footer -->
  </div>
  <!-- .wrapper -->
</div>
</body>
</html>