<?php
include ("includes/surya.dream.php");
// Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_user_details");
sajax_handle_client_request();
// END Ajax code 
protect_user_page();
/*if ($_SESSION['sess_security_code']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code.php");
	 exit;
}*/  	 
/*if ($_SESSION['sess_status']=='Inactive') {
 	 header("location: my_ewallet_acc_activation.php");
	 exit;
}*/  

$arr_error_msgs =array();

//$arr_error_msgs[] =   "You can start buy coin from dated 21 Oct 2019";
$coin_open = db_scalar("SELECT  round(sett_value,0) FROM ngo_setting where sett_code='COIN_BUY_OPEN' ");
if($coin_open==0) { $arr_error_msgs[] =   "You can not buy coin at this time, please try it later"; }

$coin_rate = db_scalar("SELECT  sett_value FROM ngo_setting where sett_code='COIN_RATE' ");
///$pay_group_coin='HC'; ///Holding Coin
$pay_group='CW';
  $u_bank_lock  = db_scalar("select u_bank_lock from ngo_users where u_id = '$_SESSION[sess_uid]'"); 
if ($u_bank_lock=='yes') { 
	//$arr_error_msgs[] =  "YOU ARE NOW ALLOWED TO RE-INVEST, PLEASE CONTACT BACK OFFICE." ; 
	$arr_error_msgs[] =  db_scalar("select u_blocked_msg from ngo_users where u_id = '$_SESSION[sess_uid]'"); ; 
 }
 //if ($pay_group=='LR') {$arr_error_msgs[] =   "Selected payment processor is on hold, you can't re-invest fund in $pay_group!";}
 if(is_post_back()) {
  /// and code_useto>=ADDDATE(now(),INTERVAL 570 MINUTE)
	/*$topup_userid = db_scalar("select u_id from ngo_users where u_username = '$topup_username' ");
	if ($topup_userid=='') { $arr_error_msgs[] =  $topup_username." Username does not exist!  " ;} 
 	if ($total_investment!='10.00') { 
  $topup_active_count= db_scalar("select count(*) from ngo_users_recharge  where topup_userid ='$topup_userid' and topup_amount='10.00'")+0;	
 if ($topup_active_count<1) { $arr_error_msgs[] = "Please Activate Your Account With Registration Promo Code"; } 
 
 } */
 	#$user_password = db_scalar("select u_password2 from ngo_users where u_password2 = '$user_password' and u_id='$_SESSION[sess_uid]'");	
	#if ($user_password =='') { $arr_error_msgs[] =  "E-Bank Password does not match!";}
	//and pay_group='$pay_group'
    $MINIMUM_INVESTMENT  = 10;
 	if ($total_investment<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Minimum coin purchase amount is ". price_format($MINIMUM_INVESTMENT); }
 	// and    pay_group='$pay_group'
	 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group='$pay_group'"); 
	if ($total_investment<=0) { $arr_error_msgs[] =  "Purchase amount is missing!";}
	 if ($pay_group_coin=='') { $arr_error_msgs[] =  "Coin Group is missing!";}
 	 if ($total_investment >$account_balance) {$arr_error_msgs[] =   "Insufficient Wallet Balance balance!";}
    
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//print_r($arr_error_msgs);
if (count($arr_error_msgs) ==0) { 
 	
	
	if ($_POST[Submit]=='Continue') {
		//$arr_error_msgs[] = "Are you sure want to investment - $total_investment";
 		$arr_error_msgs[] = "Are you sure want to purcahse ".$ARR_COIN_GROUP[$pay_group_coin];
 
		$action = 'Continue';
   
   	} else if  ($_POST[Submit]=='Confirm Payment') {
		$action = 'Confirm';
		$total_coin 	=$total_investment/$coin_rate;
  
		
		$pay_for1 = "Purchase $ARR_COIN_GROUP[$pay_group_coin] @ $coin_rate" ;
		$sql1 = "insert into ngo_users_coin set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '0' ,pay_plan='COIN_BUY' ,pay_group='$pay_group_coin' ,pay_for = '$pay_for1' ,pay_ref_amt='$total_investment' ,pay_unit = 'C', pay_rate = '$coin_rate', pay_amount = '$total_coin',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
		///exit;
		db_query($sql1);
		$pay_id1 = mysqli_insert_id($GLOBALS['dbcon']);
		///$last_id = mysqli_insert_id($conn);
 		$arr_error_msgs[] =  "Coin Purchase  successfully with amount ".price_format($total_investment)." " ;  
 		$pay_for1 = "Purchased $ARR_COIN_GROUP[$pay_group_coin] @$coin_rate | $total_coin coin";
		$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_id1' ,pay_plan='COIN_BUY' ,pay_group='$pay_group' ,pay_for = '$pay_for1' ,pay_ref_amt='$total_investment' ,pay_unit = 'Fix' ,pay_rate = '100', pay_amount = '$total_investment',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";
		///exit;
		db_query($sql1);
 		$action = '';
		$_POST='';
		$act='done';
		
		
	///level income on buy coin start 2/1/1/1/1/1/1/1/1%
 		
		$u_ref_userid =$_SESSION[sess_uid];
		$ctr=0;
		while ($ctr<10) { 
 		   $ctr++;
		   /// print $ctr;
		   $u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
		   $total_topup= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_userid ='$u_ref_userid'  ")+0;
 		if ($u_ref_userid!='' && $u_ref_userid!=0 && $total_topup >=0){
			// set rate
			if ($ctr==1) {$pay_rate = 2;}
			else if ($ctr==2) {$pay_rate = 1; }
			else if ($ctr==3) {$pay_rate = 1; }
			else if ($ctr==4) {$pay_rate = 1; }
			else if ($ctr>=5 && $ctr<10) {$pay_rate = 1; } 
			else { $pay_rate = 0;  }  
 			//$pay_rate = 10;
			$pay_amount = ($total_investment/100)* $pay_rate;
			if($pay_amount>0){
			$pay_for ="Purchase $pay_group_coin Cardano Gold Revenue Level $ctr Income   Refno-$pay_id";
			$sql22 = "insert into ngo_users_payment set pay_drcr='Cr',pay_group='PURCHASE_CG_REVENUE',pay_userid ='$u_ref_userid' ,pay_refid ='$pay_id1' ,pay_topupid='$pay_id1' ,pay_plan='PURCHASE_CG_REVENUE' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$total_investment' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE),pay_admin='INSTANT' ";
			db_query($sql22);
			//$arr_error_msgs[] =  "Your investment completed successfully!";
			}
		 ///}
		} 
	  } 	
		
		
		
	////////////////////////////////////////////	
		
		
		
		
		
		
		
 } 
}
}
$_SESSION['arr_error_msgs'] = $arr_error_msgs;

 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='$pay_group' "); 
  //
 
?>
 <!DOCTYPE html>
<html lang="en">


 <? include("includes/extra_file.inc.php")?>

<body>
    <!-- Page Preloder -->
   <? include("includes/loader.php")?>
    <!--====== Header Section Start ======-->
       <? include("includes/top_header.php")?>
    <!-- MAINMENU-AREA START-->
     <? include("includes/header.inc.php")?>
    <!--====== Header Section End ======-->
     <!--====== Hero Section Start ======-->
    <section style="background-image:url(assets/images/quote-baaner.png);" class="page-top">
    <div class="overlay"></div>
    <div class="page-top-info">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Purchase <?=$ARR_COIN_GROUP[$pay_group_coin];?>   </h1>
                    <ol class="breadcrumb">
              			<li class="breadcrumb-item"><a href="index.php">Home</a></li>
              			<li class="breadcrumb-item active" aria-current="page">Coin Purchase </li>
            		</ol>
                </div>
            </div>
        </div>
    </div>
</section>
      <!--====== Hero Section End ======-->
    <!-- ==== Contact Section Start ==== -->
    <section class="quote-section fix" >
        <div class="container pt100">      
             
            <div class="row">
                <div class="quote-body">
                    <div class="contact-section fix " id="contact">
                        <div class="container pt100 mb100">
                            <div class="row">
                                <div class="col-md-12 col-md-offset-0"> 
 
 
   
       <div class="error">
        <? include("error_msg.inc.php");?>
       </div>
       
       <table width="100%" border="0"  cellpadding="0" cellspacing="0"  >
        <tr>
         <td height="200" align="center" valign="" ><form method="post" name="form1" id="form1"  class="contact-form" <?= validate_form()?>  >
           <?  if ($act!='done') { ?>
           <table width="650" border="0" cellpadding="2" cellspacing="2"  class="table table-striped table-hover  " style="width:65%;" >
		   <thead>
					  <tr class="tdhead">
                        <th colspan="2"><strong>Buy <?=$ARR_COIN_GROUP[$pay_group_coin];?> </strong></th>
                      </tr>
                      </thead>
            <?   if ($action == '')  { ?>
            <tr>
             <td style="text-align:right; "   valign="top" class="maintxt" nowrap="nowrap"><strong> Wallet Balance : </strong></td>
             <td valign="top" style="text-align:left; " ><span class="blue_link"><strong>
              <?=price_format($account_balance)?>
              </strong> </span></td>
            </tr>
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt" nowrap="nowrap"><strong> Coin Rate: </strong></td>
             <td valign="top" style="text-align:left; "><span class="blue_link"><strong>
              <?=price_format($coin_rate)?>
              </strong> </span></td>
            </tr>
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt"><strong> Purchase Amount: </strong></td>
             <td valign="top" style="text-align:left; ">
			   <input name="total_investment"  type="text" class="txtbox" value="<?=$total_investment?>"  alt="numeric|2" emsg="Please enter minimum amount $10"     />  
             
             </td>
            </tr>
            <tr>
             <td valign="top"></td>
             <td valign="top" style="text-align:left; "><input type="hidden" name="pay_group" value="<?=$pay_group?>" />
              <input name="Submit" type="submit" class="site-btn transition-ease hero" style="color:#000000" value="Continue" /></td>
            </tr>
            <? } else if ($action == 'Continue') { ?>
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt"><strong>Activation Wallet Balance : </strong></td>
             <td valign="top" style="text-align:left; "><span class="blue_link">
              <?=price_format($account_balance)?>
              </span> </td>
            </tr>
			 <tr>
             <td style="text-align:right; "  valign="top" class="maintxt" nowrap="nowrap"><strong> Coin Rate: </strong></td>
             <td valign="top" style="text-align:left; "><span class="blue_link"><strong>
              <?=price_format($coin_rate)?>
              </strong> </span></td>
            </tr>
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt"><strong> Purchase Amount: </strong></td>
             <td valign="top" style="text-align:left; "><?=price_format($total_investment)?>
              <input name="total_investment"  type="hidden"   value="<?=$total_investment?>"    />
             </td>
            </tr>
			
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt"><strong> Total Coin: </strong></td>
             <td valign="top" style="text-align:left; "><?=round($total_investment/$coin_rate)?>
              </td>
            </tr>
            <tr>
             <td valign="top"></td>
             <td valign="top" style="text-align:left; "><input type="hidden" name="pay_group" value="<?=$pay_group?>" />
              <input name="Submit" type="submit" class="site-btn transition-ease hero" style="color:#000000" value="Confirm Payment" />
             </td>
            </tr>
            <? }  ?>
           </table>
           <?  } else {  ?>
           <br>
           <br>
           <div class="td_box" align="center"> <a href="my_coin_buy.php?pay_group_coin=<?=$pay_group_coin?>">Click Here </a> To Buy again new coin. </div>
           <? }   ?>
          </form>
		  
		  
		  </td>
        </tr>
       </table>
     
	 </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ==== Footer Massege Section Start ==== -->
<!-- ==== Footer Massege Section End ==== -->
<!-- Footer -->
<? include("includes/footer.inc.php")?>
<!-- end Footer -->
<!--====== Javascripts & Jquery ======-->
<? include("includes/extra_footer.inc.php")?>
</body>
</html>             