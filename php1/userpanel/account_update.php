<?php include ("includes/surya.dream.php");
$login = "hide";
$ip =  gethostbyaddr($_SERVER['REMOTE_ADDR']);
if(is_post_back()) {
 	
	
$sql_update="update ngo_users set  u_bank_name='$u_bank_name', u_bank_acno='$u_bank_acno', u_bank_acc_holder='$u_bank_acc_holder', u_bank_branch='$u_bank_branch' ,u_bank_ifsc_code='$u_bank_ifsc_code' ,u_bank_micr_code='$u_bank_micr_code' ,u_liberty_reserve='$u_liberty_reserve', u_ok_pay='$u_ok_pay',u_perfect_money='$u_perfect_money', u_alert_pay='$u_alert_pay'  where u_id='".$_SESSION['sess_uid']."'";
db_query($sql_update);


//// update topup amount

$parent_id = db_scalar("select topup_id from ngo_users_recharge  order by topup_userid desc limit 0,1")+rand(1,15);
$topup_serialno =  rand(100,999).$parent_id;
			  
 
$topup_plan = "50% Monthly ";
$topup_rate = 50;
$sql = "insert into  ngo_users_recharge set topup_userid = '$_SESSION[sess_uid]' ,topup_by_userid='$_SESSION[sess_uid]',topup_serialno='$topup_serialno', topup_code='', topup_group='GH' ,topup_plan='$topup_plan',topup_days_for='$topup_days_for' ,topup_rate='$topup_rate' ,topup_amount='$topup_amount' ,topup_bonus='$topup_bonus' ,topup_amount2='$topup_amount2' ,topup_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_exp_date= ADDDATE(now(),INTERVAL 31 DAY) ,topup_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_status='Unpaid' ";
db_query($sql);
$topup_id = mysql_insert_id();
		
 	
	header("location: backoffice/myaccount.php");
	exit;
		 
		 
	 
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
    <h1 class="page-title">Bank account and Give help Update</h1>
  </div>
</div>
<!-- CONTENT -->
<div class="container m-bot-25 clearfix">
  <div class="sixteen columns">
    <div class="content-container-white">
      <div class="border-top-dashed under-content-caption">

            <h2><span class="bold">Bank account and Give help </span> update</h2>
             
          <div class="blog-text-container clearfix">
          <div >
            <? include("error_msg.inc.php");?>
          </div>
          <form name="registration" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data"  <?= validate_form()?>>
				  <input type="hidden" name="old_u_photo" value="<?=$u_photo?>" >
           
                  <table width="100%" border="0" align="center"   class="white_box" cellpadding="0" cellspacing="0">
                        
				  <tr>
                        <td   colspan="3">&nbsp;</td>
                    </tr>
                     
					  	 <!--  
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="maintxt">Last Name </td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="u_lname" type="text" class="txtbox" id="u_lname" style="width:200px;" value="<?=$u_lname?>" alt="blank" emsg="Please enter last name"/>
                        </span></td>
                      </tr>-->

                       
					    <?  if ($u_bank_register!='') { $disable =' readonly="readonly"';}
						
						// $disable =' readonly="readonly"';
						?>
						
						 <!-- <tr>
						  
						   <td colspan="3" align="left" valign="top" class="maintxt"><strong> Online  Account Details</strong>  </td>
				      </tr>-->
						 <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td width="256" align="left" valign="top" class="maintxt">Liberty Reserve Account ID: </td>
                        <td width="689" align="left" valign="top"><input name="u_liberty_reserve" type="text" class="txtbox" id="u_liberty_reserve" style="width:200px;" value="<?=$u_liberty_reserve?>" /></td>
                      </tr>
					 <!--	 
 
                    <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="right" valign="top" class="maintxt"> Ok Pay Account ID: <br /></td>
                        <td align="left" valign="top"><input name="u_ok_pay" type="text" class="txtbox" id="u_ok_pay" style="width:200px;" value="<?=$u_ok_pay?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="right" valign="top" class="maintxt">Perfect Money Account ID: </td>
                        <td align="left" valign="top"><input name="u_perfect_money" type="text" class="txtbox" id="u_perfect_money" style="width:200px;" value="<?=$u_perfect_money?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"></td>
                        <td align="right" valign="top" class="maintxt">Alert Pay Account ID: </td>
                        <td align="left" valign="top"><input name="u_alert_pay" type="text" class="txtbox" id="u_alert_pay" style="width:200px;" value="<?=$u_alert_pay?>" /></td>
                      </tr>-->
					  
                      
                    <!--  <tr>
                        <td width="106" align="left" valign="top">&nbsp;</td>
                        <td colspan="2" align="left" valign="top"><strong class="subtitle">Bank Account Details </strong></td>
                      </tr>-->
					  
                     
                       <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="maintxt">Account Holder Name<span class="error"> *</span> </td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="u_bank_acc_holder" type="text" class="txtbox" id="u_bank_acc_holder" style="width:200px;" <?=$disable?> value="<?=$u_bank_acc_holder?>" alt="blank" emsg="Please enter account holder name"/>
                        </span></td>
                      </tr>
					  <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="maintxt">Account Number<span class="error"> *</span> </td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="u_bank_acno" type="text" class="txtbox" id="u_bank_acno" style="width:200px;" <?=$disable?> value="<?=$u_bank_acno?>" alt="blank" emsg="Please enter account number"/>
                        </span></td>
                      </tr>
					  
                       <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td width="256" align="left" valign="top" class="maintxt">Bank Name<span class="error"> *</span> </td>
                        <td width="689" align="left" valign="top"><span class="maintxt">
                          <input name="u_bank_name" type="text" class="txtbox" id="u_bank_name" style="width:200px;"  <?=$disable?>   value="<?=$u_bank_name?>" alt="blank" emsg="Please enter bank name"/>
                        </span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="maintxt">Branch <span class="error"> *</span> </td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="u_bank_branch" type="text" class="txtbox" id="u_bank_branch" style="width:200px;" <?=$disable?> value="<?=$u_bank_branch?>" alt="blank" emsg="Please enter branch name"/>
                        </span></td>
                      </tr>
					  <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="maintxt">IFSC Code<span class="error"> *</span> </td>
                        <td align="left" valign="top"> <input name="u_bank_ifsc_code" type="text" class="txtbox" id="u_bank_ifsc_code" <?=$disable?> style="width:200px;" value="<?=$u_bank_ifsc_code?>" alt="blank" emsg="Please enter IFSC Code"/></td>
                      </tr>
					 
				  
                     
					   <tr>
					   <td align="left" valign="top">&nbsp;</td>
                        <td   align="left" valign="top">&nbsp;</td>
                        <td colspan="2" align="left" valign="top"><strong class="subtitle">Give Help Details </strong></td>
                      </tr>
					  
					 
					  <tr>
					  <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top" nowrap="nowrap" class="maintxt"> Give Help Amount :  </td>
                      <td valign="top" nowrap="nowrap"  > 
					  
					  
					  <select name="topup_amount" class="txtbox" style="width:200px;" alt="select" emsg="Please enter helping amount"  >
					    <option value="" >Please Select</option>
					<option value="2500"> INR 2,500.00</option>
					
					<? 
					
					// Array ( [topup_amount] => 1000 [package] => 16 [user_password] => 33333 [Submit] =>   Submit   )
					 
					$ctr = 1;
 					while ($ctr<=10) { 
					$amount = 5000*$ctr;
					$ctr++;
					
					?>
					  <option value="<?=$amount?>"><?=price_format($amount)?></option>
					  <? } ?>
					  </select>		 <? //if ($amount==$topup_amount) { echo 'selected="selected"';} ?>		       </td>
                    </tr>
					
					
					  
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="maintxt">&nbsp;</td>
                        <td align="left"><input name="Submit" type="submit" class="button" value="&nbsp;Submit&nbsp;" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="maintxt">&nbsp;</td>
                        <td align="left"><span class="error">*</span> These fields are mandatory. </td>
                      </tr>
                  </table>
		    </form>
		   
		
		
      </div>
      <div class="content-under-container-white"></div>
    </div>
	
   </div>
  <!-- RIGHT SIDE -->
</div>
</div>
</div>
</div>
</div>
<!-- FOOTER -->
<?php include("includes/footer.inc.php");?>
<p id="back-top"> <a href="#top" title="Back to Top"><span></span></a> </p>
</body>
</html>