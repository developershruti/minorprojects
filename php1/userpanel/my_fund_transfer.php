<?php
include ("includes/surya.dream.php");
protect_user_page();

if ($_SESSION['sess_security_code']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code.php");
	 exit;
}
	 
//print_r($_POST);
 /// check account balance 
$acc_balance =  db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' ");
if ($acc_balance <1) { 
  	$arr_error_msgs[] =  "No suficient account balance for transfer" ;  
 	$stop='stop';
} 


if(is_post_back()) { 
$pay_userid = db_scalar("select u_id from ngo_users where u_username = '$pay_username' ");	
// check user name
$arr_error_msgs = array();
$total_count = db_scalar("select count(*) from ngo_users where u_username = '$pay_username'");
if ($total_count==0) { $arr_error_msgs[] =  $u_username." Username does not exit!  " ;} 
if ($acc_balance<$pay_amount) {
			$arr_error_msgs[] = "No suficient account balance for transfer";
} 

$sql_gen = "select sum(topup_amount) as total_topup,topup_rate from ngo_users_recharge where topup_userid='$_SESSION[sess_uid]'";
$result_gen = db_query($sql_gen);
$line_gen = mysqli_fetch_array($result_gen);

$total_topup = $line_gen['total_topup'];
$topup_rate = $line_gen['topup_rate'];
$minimum_tranfer =($total_topup/100)*$topup_rate ;
 
if ($acc_balance<$minimum_tranfer) {
			$arr_error_msgs[] = "Minimum transfer amount is $".$minimum_tranfer;
}


if (count($arr_error_msgs) ==0) {
	
	if ($_POST[Submit]=='Continue') {
		$arr_error_msgs[] = "Are you sure want to transfer fund into $pay_username account ?";
		$action = 'Continue';
   
   	} else if  ($_POST[Submit]=='Confirm Payment') {
		$action = 'Confirm';
	//print_r($_POST);
		
		$pay_for1 = "Fund received from user $_SESSION[sess_username] - ".$pay_for;
		$sql1 = "insert into ngo_users_payment set  pay_drcr='Cr',  pay_userid = '$pay_userid',pay_refid = '$_SESSION[sess_uid]' ,pay_plan='FUND_RECEIVE' ,pay_for = '$pay_for1' ,pay_ref_amt='' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE) ";
		db_query($sql1);
		
		$pay_for2 = "Fund transfered to user $pay_username - ".$pay_for;
		$sql2 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_userid' ,pay_plan='FUND_TRANSFER' ,pay_for = '$pay_for2' ,pay_ref_amt='' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE) ";
		db_query($sql2);
		
		$message = "" .SITE_NAME." Fund Transfered to Your ID:".$_SESSION[sess_username]."  Total Pin:".$code_cunter.", For the Welth:".$post." on date:".date("d-M-Y");
		#send_sms($u_mobile,$message);
	 	$arr_error_msgs[] ="Fund transfered successfully to $pay_username account";
	 
	 
	}
}
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
} 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?=$META_TITLE?>
</title>
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
<link href="stylesheet/style.css" rel="stylesheet" type="text/css" />
<?php include("includes/fvalidate.inc.php");?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>
<body onload="MM_preloadImages('<?=SITE_WS_PATH?>/images/button_home2.jpg','<?=SITE_WS_PATH?>/images/button_company2.jpg','<?=SITE_WS_PATH?>/images/button_opportunity2.jpg','<?=SITE_WS_PATH?>/images/button_faq2.jpg','<?=SITE_WS_PATH?>/images/button_feedback2.jpg','<?=SITE_WS_PATH?>/images/button_login2.jpg','<?=SITE_WS_PATH?>/images/button_join2.jpg','<?=SITE_WS_PATH?>/images/button_logout2.jpg','<?=SITE_WS_PATH?>/images/button_myaccount2.jpg','<?=SITE_WS_PATH?>/images/button_contactus2.jpg')">
<table width="1004" border="0" align="center" cellpadding="0" cellspacing="0"  class="main_table">
  <tr>
    <td ><? include("includes/header.inc.php")?></td>
  </tr>
  <tr>
    <td  height="300" valign="top"><!--main table start-->
      <br />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"class="mainbox">
        
        <tr>
          <td align="left" valign="top" class="title">&nbsp;Fund Transfer </td>
        </tr>
         
        <tr>
          <td align="right" valign="top"> 
            <!--main  content table start -->
             
            
            <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0"  >
           
              <tr>
                
                <td  height="300" align="center" valign="top"><br />
<form method="post" name="form1" id="form1"  <?= validate_form()?>>
                    <table width="500"  border="0" cellpadding="1" cellspacing="1" class="txtbox">
                      <tr>
                        <td colspan="2" class="title">Fund Tranfer</td>
                      </tr>
                      <tr>
                        <td colspan="2" class="td_box"><? include("error_msg.inc.php");?></td>
                      </tr> 
					   <?   if ($action == '')  { ?>
                      <tr>
                        <td align="right" class="maintxt">Account Balance : </td>
                        <td class="maintxt"><strong>
						<?php   echo price_format($acc_balance); ?></strong></td>
                      </tr>
                      <tr>
                        <td align="right" class="maintxt">Transfer Date : </td>
                        <td class="maintxt"><?php echo  date_format2(db_scalar("select now()")); ?></td>
                      </tr>
					 
 					  <tr>
                        <td align="right" class="maintxt"> Receiver Username : </td>
                        <td class="maintxt"><input type="text" name="pay_username" value="<?=$pay_username?>" alt="blank" emsg="Username can not be blank" />                          </td>
                      </tr>
                      <tr>
                        <td width="32%" align="right" class="maintxt">Transfer Amount : </td>
                        <td width="68%" class="maintxt"><input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />                        </td>
                      </tr>
                       <tr>
                        <td align="right" valign="top" class="maintxt">Naration : </td>
                        <td class="maintxt"><textarea name="pay_for" cols="30" rows="3" alt="blank" emsg="Naration can not be blank" ><?=$pay_for?></textarea></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>
						<? if ($stop=='') {?> 
						<input name="Submit" type="submit"  value="Continue" /> 
						&nbsp;&nbsp;<input name="Reset" type="reset"  value=" Reset " />
						<?  } ?>						</td>
                      </tr>
					  <? } else if ($action == 'Continue') { ?>
 					  <tr>
                        <td align="right" class="maintxt">Account Balance : </td>
                        <td class="maintxt"><strong>
						<?php   echo price_format($acc_balance); ?></strong></td>
                      </tr>
                      <tr>
                        <td align="right" class="maintxt">Transfer Date : </td>
                        <td class="maintxt"><?php echo date_format2(date("m-d-Y")); ?></td>
                      </tr>
					  
					   <tr>
                        <td align="right" class="maintxt"> Receiver Username : </td>
                        <td class="maintxt"><input type="hidden" name="pay_username" value="<?=$pay_username?>" /> <?=$pay_username?></td>
                      </tr>
                      <tr>
                        <td width="32%" align="right" class="maintxt">Transfer Amount : </td>
                        <td width="68%" class="maintxt"><input type="hidden" name="pay_amount" value="<?=$pay_amount?>"   /><?=price_format($pay_amount)?>                        </td>
                      </tr>
                       <tr>
                        <td align="right" valign="top" class="maintxt">Naration : </td>
                        <td class="maintxt"><input type="hidden" name="pay_for" value="<?=$pay_for?>" /> <?=$pay_for?> </td>
                      </tr>
                      <tr>
                        <td class="txtbox">&nbsp;</td>
                        <td class="txtbox">
						 
						<input name="Submit" type="submit"  value="Confirm Payment" />  </td>
                      </tr>
					  
					  <? }  ?>
                    </table>
                </form></td>
				 
              </tr>
            </table>
            <!--main content table end -->          </td>
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
