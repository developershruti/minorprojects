<?php
include ("../includes/surya.dream.php");

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
$pay_group_coin='TW';
$arr_error_msgs[] =   "We are working on Rozipay Token configuration, once it is complete you can buy token.";
$coin_open = db_scalar("SELECT  round(sett_value,0) FROM ngo_setting where sett_code='COIN_BUY_OPEN' ");
if($coin_open==0) { $arr_error_msgs[] =   "Tone is not available for buy, please try it later"; }
 


$coin_rate = db_scalar("SELECT  sett_value FROM ngo_setting where sett_code='COIN_RATE' ");

///$pay_group_coin='HC'; ///Holding Coin
//$pay_group='CW';

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
   # $MAXIMUM_INVESTMENT  = db_scalar("SELECT  round(sett_value,0) FROM ngo_setting where sett_code='COIN_LIMIT_USER' ");
    // 0.50;
 	#if ($total_investment>$MAXIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Maximum coin buy amount limit is ". price_format($MAXIMUM_INVESTMENT); }
 	// and pay_group='$pay_group'
	 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]'  and pay_group='$pay_group'"); 
	if ($total_investment<=0) { $arr_error_msgs[] =  "Token  amount is missing!";}
	//if ($pay_group_coin=='') { $arr_error_msgs[] =  "Token  Group is missing!";}
 	if ($total_investment >$account_balance) {$arr_error_msgs[] =   "Low account balance balance!";}
  
$datetoday = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL  330 MINUTE), '%Y-%m-%d')"); 
/*
$today_buy_sum = db_scalar("SELECT SUM(pay_ref_amt)  as Balance FROM ngo_users_coin where pay_userid='$_SESSION[sess_uid]'  and pay_group='$pay_group_coin'  and pay_date='$datetoday' "); 
// $coin_user_daily_limit = db_scalar("SELECT  round(sett_value,0) FROM ngo_setting where sett_code='COIN_LIMIT_USER' ")-$today_buy_sum;
$coin_user_daily_limit = $MAXIMUM_INVESTMENT-$today_buy_sum;
//$total_investment2 = ($total_investment/100)*75;
///$total_coin 	=($total_investment2/$coin_rate);


if ($total_investment > $coin_user_daily_limit ) { $arr_error_msgs[] =  "Your today limit for Buy coin is $coin_user_daily_limit !";}
$coin_total_daily_limit = db_scalar("SELECT  round(sett_value,0) FROM ngo_setting where sett_code='COIN_LIMIT_DAY' ");
$today_total_buy_sum = db_scalar("SELECT SUM(pay_ref_amt) as Balance FROM ngo_users_coin where  pay_group='$pay_group_coin' and pay_date='$datetoday' "); 
if ($today_total_buy_sum>=$coin_total_daily_limit) { $arr_error_msgs[] =  "Today total limit for Buy coin is over!";}
 */
if ($total_investment<=0) { $arr_error_msgs[] =  "Token Buy amount is missing!";}
 



$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//print_r($arr_error_msgs);
if (count($arr_error_msgs) ==0) { 
 	
	
	if ($_POST[Submit]=='Continue') {

    
		//$arr_error_msgs[] = "Are you sure want to investment - $total_investment";
 		$arr_error_msgs[] = "Are you sure want to Buy token "; //.$ARR_COIN_GROUP[$pay_group_coin];
 
		$action = 'Continue';
   
   	} else if  ($_POST[Submit]=='Confirm Payment') {
    $action = 'Confirm';
    /// 25% deduction on coin purchase
    //$total_investment2 = ($total_investment/100)*75;
		$total_coin 	=$total_investment/$coin_rate;
  

		$pay_for1 = "Token Buy $ARR_COIN_GROUP[$pay_group_coin] @ $coin_rate" ;
		$sql1 = "insert into ngo_users_coin set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '0' ,pay_plan='COIN_BUY' ,pay_group='$pay_group_coin' ,pay_for = '$pay_for1' ,pay_ref_amt='$total_investment' ,pay_unit = 'C', pay_rate = '$coin_rate', pay_amount = '$total_coin',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		///exit;
		db_query($sql1);
		$pay_id1 = mysqli_insert_id($GLOBALS['dbcon']);
		///$last_id = mysqli_insert_id($conn);
 		$arr_error_msgs[] =  "Token Buy successfully with amount ".price_format($total_investment)." " ;  
 		$pay_for1 = "Token Buy $ARR_COIN_GROUP[$pay_group_coin] @$coin_rate";
		$sql1 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$pay_id1' ,pay_plan='$pay_group' ,pay_group='$pay_group' ,pay_for = '$pay_for1' ,pay_ref_amt='$total_investment' ,pay_unit = 'Fix' ,pay_rate = '100', pay_amount = '$total_investment',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		///exit;
		db_query($sql1);
 		$action = '';
		$_POST='';
		$act='done';
		
	 
 } 
}
}
$_SESSION['arr_error_msgs'] = $arr_error_msgs;

 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_group='$pay_group' "); 
  //
 
?>
 <!DOCTYPE html>
<html lang="en">
  <? include("includes/extra_head.php")?> 
   <? //include ("../includes/fvalidate.inc.php"); ?>
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
                  <div class="col-xl-12 col-md-6 col-12 order-xl-1">
                      <!-- Card -->
                      <div class="dt-card dt-card__full-height">
 
                      <div class="dt-card__body">
						 <div class="dt-card__heading">
                            <h3 class="dt-card__title">ACCOUNT BALANCE : <?  
					 $acc_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' AND pay_group='$pay_group' ") ;
					// echo round($acc_balance); AND pay_group='$pay_group'
					echo price_format($acc_balance); 
					 ?></h3>
                          </div>
 					       
						 
						   
 					      <div class="media"> <br>
<br>

                            <!-- Media Body --> 
                              <table width="150px;" style="margin-top:25px; " class="table table-striped table-bordered table-advance table-hover">
                                   <thead><tr>
								   			<th>Token Details</th>
								   </tr>
								   </thead>
 								   
								    <tbody>
									<tr>
                                        <td align="left" style="text-align:left;">Token Name&nbsp;&nbsp;&nbsp;: ABC   </td>
 										</tr>
                                     <tr>
                                        <td  align="left" style="text-align:left;">Token Symbol : ABC </td>
										</tr>
                    <tr>
                                        <td  align="left" style="text-align:left;">Token Price : <?=price_format($coin_rate)?> </td>
										</tr>

                    
                                     <?php /*?><tr>
                                        <td  align="left" style="text-align:left;">Total Supply&nbsp;&nbsp;&nbsp;:  20,000,000 EPT</td>
										</tr><?php */?> 
                                    
                                </tbody></table> 
                            <!-- /media body -->
                          </div>
						  
						  
						   
                       
					   
					   
					   
                        </div>
						
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
                      <h3 class="mb-2 mb-sm-n5">BUY RIP TOKEN </h3>
                       
                    </div>
                    <!-- /card header -->
                    <!-- Card Body -->
                     <div class="dt-card__body">

                <!-- Form -->  <p align="center" style="color:#FF0000"> <? include("error_msg.inc.php");?>   <?=$msgs?> </p>
            <form method="post" name="form" id="contactform"  action="#" class="forms-sample"  enctype="multipart/form-data"  <?= validate_form()?>>
		 
  
           <?  if ($act!='done') { ?>
           <table width="650" border="0" cellpadding="2" cellspacing="2"  class="table table-striped table-hover  " style="width:65%;" >
		 
					  
            <?   if ($action == '')  { ?>
            
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt"><strong> Purchase Amount: </strong></td>
             <td valign="top" style="text-align:left; ">
			   <input name="total_investment"  type="text" class="txtbox" value="<?=$total_investment?>"   emsg="Please enter minimum amount"     />  
             
             </td>
            </tr>
            <tr>
             <td valign="top"></td>
             <td valign="top" style="text-align:left; "><input type="hidden" name="pay_group" value="<?=$pay_group?>" />
              <input name="Submit" type="submit" class="btn btn-primary text-uppercase" style="color:#000000" value="Continue" /></td>
            </tr>
            <? } else if ($action == 'Continue') { ?>
             
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt"><strong> Purchase Amount: </strong></td>
             <td valign="top" style="text-align:left; "><?=price_format($total_investment)?>
              <input name="total_investment"  type="hidden"   value="<?=$total_investment?>"    />
             </td>
            </tr>
			
            <tr>
             <td style="text-align:right; "  valign="top" class="maintxt"><strong> Total Coin: </strong></td>
             <td valign="top" style="text-align:left; "><?=($total_investment/$coin_rate)?>
              </td>
            </tr>
            <tr>
             <td valign="top"></td>
             <td valign="top" style="text-align:left; "><input type="hidden" name="pay_group" value="<?=$pay_group?>" />
              <input name="Submit" type="submit" class="btn btn-primary text-uppercase" style="color:#000000" value="Confirm Payment" />
             </td>
            </tr>
            <? }  ?>
           </table>
           <?  } else {  ?>
           <br>
           <br>
           <div class="td_box" align="center"> <a href="my_token_buy?pay_group=<?=$pay_group?>">Click Here </a> To Buy again new token. </div>
           <? }   ?>
        
		    
                </form>
                <!-- /form -->

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




   
       