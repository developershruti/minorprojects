<?php
include ("includes/surya.dream.php");
protect_user_page();
 
//print_r($_SESSION);
$sql = "select * from ngo_users ,ngo_offer_ref where u_id=offer_userid and u_status='Active' and u_id ='$_SESSION[sess_uid]'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
 
//print_r($line);

//  $SITE_CSS = $_SESSION[sess_css];
//print $_SESSION['sess_status'];
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$META_TITLE?> </title>
<meta name="keywords" content="<?=$META_KEYWORD?>">
<meta name="description" content="<?=$META_DESC?>" />
<LINK REL="SHORTCUT ICON" HREF="<?=SITE_WS_PATH?>/images/ngo_icon.ico">

<?php //include("includes/fvalidate.inc.php");?>
<link href="<?=SITE_WS_PATH?>/stylesheet/vergemenu.css" rel="stylesheet" type="text/css">
<link href="<?=SITE_WS_PATH?>/stylesheet/style.css" rel="stylesheet" type="text/css" />
<link href="<?=SITE_WS_PATH?>/stylesheet/dropdown.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?=SITE_WS_PATH?>/stylesheet/libcss/default.advanced.css" media="all" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/js/jquery/jquery.dropdown.js"></script>
<![endif]-->
<script language="JavaScript" type="text/javascript" src="includes/general.js"></script>
<? include("includes/extra_head_include.php")?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<link href="stylesheet/style.css" rel="stylesheet" type="text/css" />
</head>
<body>																	
<table width="1004" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#65C1F3" class="main_table">


<tr>
<td >
<? include("includes/header.inc.php")?>
    </td>
  </tr>
  <tr>
   <td  height="400">
   <!--main table start-->
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
       
      <td valign="top">
	   <!--main  content table start -->
		<? include("includes/header_img.php")?>
        <br />
        <table width="99%" border="0" align="center" cellpadding="2" cellspacing="2" >
       
	   <tr>
         <td height="50" valign="top" class="title"> Reward Achived </td>
       </tr>
         <tr>
         <td height="400" align="center" valign="top" class="error"><br>
           <table width="80%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
             <tr>
               <th height="25" align="right" nowrap="nowrap" class="subtitle">&nbsp;</th>
               <th align="left" nowrap="nowrap" class="subtitle">&nbsp;</th>
             </tr>
             <tr>
               <th width="29%" height="25" align="right" nowrap="nowrap" class="subtitle">Total Referer : </th>
               <th width="71%" align="left" nowrap="nowrap" class="subtitle"><?=$offer_total_ref ?></th>
               </tr>
             <tr>
               <th height="25" align="right" nowrap="nowrap" class="subtitle">Reward : </th>
               <th align="left" nowrap="nowrap" class="subtitle"><?=$offer_reward?></th>
               </tr>
             <tr>
               <th height="25" align="right" nowrap="nowrap" class="subtitle">Bonus Amount : </th>
               <th align="left" nowrap="nowrap" class="subtitle"><?=$offer_working_bonus?></th>
               </tr>
             <tr >
               <th height="25" align="right" nowrap="nowrap" class="subtitle">Rec Id : </th>
               <th align="left" nowrap="nowrap" class="subtitle"><?=$offer_rec_userid?></th>
             </tr>
             <tr >
               <th height="25" align="right" nowrap="nowrap" class="subtitle">Rec Name : </th>
               <th align="left" nowrap="nowrap" class="subtitle"><?=$offer_rec_name?></th>
             </tr>
             <tr >
               <th height="25" align="right" nowrap="nowrap" class="subtitle">Rec Contact Number : </th>
               <th align="left" nowrap="nowrap" class="subtitle"><?=$offer_rec_contact?></th>
             </tr>
             <tr>
               <th height="25" align="right" nowrap="nowrap" class="subtitle">Rec Date : </th>
               <th align="left" nowrap="nowrap" class="subtitle"><?=date_format2($offer_rec_date)?></th>
             </tr>
             <tr>
               <th height="25" align="right" nowrap="nowrap" class="subtitle">&nbsp;</th>
               <th align="left" nowrap="nowrap" class="subtitle">&nbsp;</th>
             </tr>
             <?
$sql = "select * from ngo_users ,ngo_offer_ref where u_id=offer_userid and u_status='Active' and offer_reward!=''";
$result = db_query($sql);
$line_raw = mysqli_fetch_array($result);
$line = ms_display_value($line_raw);
@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
  ?>
           </table>			 </td>
         </tr>
      </table>
	    
	    <!--main content table end -->
		</td>
    </tr>
 </table>
  <!--main table end -->
  </td>
  </tr>
   <tr>
    <td ><? include("includes/footer.inc.php")?>
    </td>
  </tr>
  
</table>
</body>
</html>
