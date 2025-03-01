<?php
include ("../includes/surya.dream.php");
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
$pay_group='CW';
$arr_error_msgs =array();
  $u_bank_lock  = db_scalar("select u_bank_lock from ngo_users where u_id = '$_SESSION[sess_uid]'"); 
if ($u_bank_lock=='yes') { 
	//$arr_error_msgs[] =  "YOU ARE NOW ALLOWED TO RE-INVEST, PLEASE CONTACT BACK OFFICE." ; 
	$arr_error_msgs[] =  db_scalar("select u_blocked_msg from ngo_users where u_id = '$_SESSION[sess_uid]'"); ; 
 }
 //if ($pay_group=='LR') {$arr_error_msgs[] =   "Selected payment processor is on hold, you can't re-invest fund in $pay_group!";}
 if(is_post_back()) {
  /// and code_useto>=ADDDATE(now(),INTERVAL 630 MINUTE)
	$topup_userid = db_scalar("select u_id from ngo_users where u_username = '$topup_username' ");
	if ($topup_userid=='') { $arr_error_msgs[] =  $topup_username." Username does not exist!  " ;} 
 	/*if ($total_investment!='10.00') { 
  $topup_active_count= db_scalar("select count(*) from ngo_users_recharge  where topup_userid ='$topup_userid' and topup_amount='10.00'")+0;	
 if ($topup_active_count<1) { $arr_error_msgs[] = "Please Activate Your Account With Registration Promo Code"; } 
 } */
 	#$user_password = db_scalar("select u_password2 from ngo_users where u_password2 = '$user_password' and u_id='$_SESSION[sess_uid]'");	
	#if ($user_password =='') { $arr_error_msgs[] =  "E-Bank Password does not match!";}
	//and pay_group='$pay_group'
    $MINIMUM_INVESTMENT  = 50;
 	if ($total_investment<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Minimum package amount is ". price_format($MINIMUM_INVESTMENT); }
 	// and    pay_group='$pay_group'
	 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group='$pay_group'"); 
	if ($total_investment<=0) { $arr_error_msgs[] =  "Package amount is missing!";}
 	if ($total_investment >$account_balance) {$arr_error_msgs[] =   "Insufficient Wallet Balance balance!";}
	$topup_amount_active = db_scalar("select max(topup_amount) from ngo_users_recharge where topup_userid = '$topup_userid' ");	
 	if ($total_investment<=$topup_amount_active) {
	  $arr_error_msgs[] = "$topup_username account must be upgrade with greater than $topup_amount_active amount ";
  } 
  

if ($topup_amount_active==30) { $topup_required = 50;}
else if ($topup_amount_active==50) { $topup_required = 100;}
else if ($topup_amount_active==100) { $topup_required = 500;}
else if ($topup_amount_active==500) { $topup_required = 1000;}
else if ($topup_amount_active==1000) { $topup_required = 2500;}
else if ($topup_amount_active==2500) { $topup_required = 5000;}
else if ($topup_amount_active==5000) { $topup_required = 10000;}
else if ($topup_amount_active==10000) { $topup_required = 20000;}
else if ($topup_amount_active==20000) { $topup_required = 40000;}

if ($total_investment>$topup_required) {
    $arr_error_msgs[] = "$topup_username account must be upgrade with $topup_required amount ";
} 

$topup_amount 	=$total_investment;

if ($topup_amount==50) { $direct_required = 6;}
else if ($topup_amount==100) { $direct_required = 8;}
else if ($topup_amount==500) { $direct_required = 10;}
else if ($topup_amount==1000) { $direct_required = 12;}
else if ($topup_amount==2500) { $direct_required = 14;}
else if ($topup_amount==5000) { $direct_required = 16;}
else if ($topup_amount==10000) { $direct_required = 18;}
else if ($topup_amount==20000) { $direct_required = 20;}
else if ($topup_amount==40000) { $direct_required = 22;}

 $total_referer  = db_scalar("select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and topup_amount='30'  and u_ref_userid ='$topup_userid' ")+0;
if ($total_referer<$direct_required) {
	 $arr_error_msgs[] = "Must be refer $direct_required active users before upgrade your account ";
 } 
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//print_r($arr_error_msgs);
if (count($arr_error_msgs) ==0) { 
 	if ($_POST['Submit']=='Continue') {
		//$arr_error_msgs[] = "Are you sure want to investment - $total_investment";
 		$arr_error_msgs[] = "Are you sure want to activate your account?";
 		$action = 'Continue';
   	} else if  ($_POST['Submit']=='Confirm Payment') {
		$action = 'Confirm';
		$topup_amount 	=$total_investment;
		$topup_amount2 	=$total_investment;
 		$topup_circle = 1;
		$topup_rate =0.00; //1% cashback daily
 		$topup_days_for =365; ///200 Days
   	 	//$topup_serialno = rand(10,99).db_scalar("select topup_id from ngo_users_recharge order by topup_id desc limit 0,1").rand(10,99);
 		//$topup_code =  'SL'.rand(10,99).$topup_serialno.rand(10,99);
     	 $sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid',topup_by_userid='$_SESSION[sess_uid]',topup_serialno='0' ,topup_group='C1', topup_code='$topup_code', topup_plan='TOPUP' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate'   ,topup_amount='$topup_amount' ,topup_amount2='$topup_amount2' ,topup_date=ADDDATE(now(),INTERVAL  630 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 630 MINUTE),topup_exp_date=ADDDATE(now(),INTERVAL 365 DAY)  ,topup_status='Paid' ";

		db_query($sql);
		$topup_id = mysqli_insert_id($GLOBALS['dbcon']);
		$arr_error_msgs[] =  "$topup_username account upgraded successfully with package ".price_format($total_investment)." " ;  
 		$pay_for1 = "Purchase Package - $topup_username" ;

		$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$topup_id' ,pay_plan='TOPUP_FEES' ,pay_group='$pay_group' ,pay_for = '$pay_for1' ,pay_ref_amt='$topup_amount' ,pay_unit = 'Fix' ,pay_rate = '100', pay_amount = '$total_investment',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 630 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE) ";
		///exit;
		db_query($sql1);
 		$action = '';
		$_POST='';
		$act='done';
  	////////////////////////////////////////////
    $u_ref_userid_first =db_scalar("select u_ref_userid from ngo_users where u_id='$topup_userid' ");
    $u_ref_userid = $topup_userid;
    
		$ctr=0;
		while ($ctr<10) { 
 		   $ctr++;
		  /* print  $ctr;
		print "<br/>";*/
		   $u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid'  ");
		   $total_topup= db_scalar("select  max(topup_amount)  from ngo_users_recharge  where topup_userid ='$u_ref_userid'  ")+0;
 		if ($u_ref_userid!='' && $u_ref_userid!=0 && $total_topup >=$topup_required){
			// set rate
			if($total_investment==50){ 
					//2nd level super upline ko 50% jayega
					if ($ctr==2) {$pay_rate = 25;} else {$pay_rate = 0; }
			} else if($total_investment==100) { 
					//3rd  level super upline ko 50% jayega
					if ($ctr==3) {$pay_rate = 25;} else {$pay_rate = 0; }
			} else if($total_investment==500) { 
					//4th  level super upline ko 50% jayega
					if ($ctr==4) {$pay_rate = 25;} else {$pay_rate = 0; }   
			} else if($total_investment==1000) { 
					//5th  level super upline ko 50% jayega
					if ($ctr==5) {$pay_rate = 25;} else {$pay_rate = 0; }   
			} else if($total_investment==2500) { 
					//6th  level super upline ko 50% jayega
					if ($ctr==6) {$pay_rate = 25;} else {$pay_rate = 0; }   
			} else if($total_investment==5000) { 
					//7th  level super upline ko 50% jayega
					if ($ctr==7) {$pay_rate = 25;} else {$pay_rate = 0; } 
			} else if($total_investment==10000) { 
					//8th  level super upline ko 50% jayega
					if ($ctr==8) {$pay_rate = 25;} else {$pay_rate = 0; } 
			} else if($total_investment==20000) { 
					//9th  level super upline ko 50% jayega
					if ($ctr==9) {$pay_rate = 25;} else {$pay_rate = 0; } 
      } else if($total_investment==40000) { 
					//10th  level super upline ko 50% jayega
					///if ($ctr==9) {$pay_rate = 25;} else {$pay_rate = 0; } 
					if ($ctr==10) {$pay_rate = 25;} else {$pay_rate = 0; } 
      }
 			//$total_direct = db_scalar("select count(u_id) from ngo_users where u_ref_userid='$u_ref_userid' "); 
			///$total_direct = db_scalar("select count(u_id) from ngo_users where u_ref_userid='$u_ref_userid' and u_id in (select topup_userid from ngo_users_recharge where topup_amount='$topup_amount' ) "); 
 			// if($total_direct>=$ctr){ 
			//$pay_rate = 10;
			/*print "====================== <br/>";
			print $ctr;
			echo "<br/>";
			print $pay_rate;
			echo "<br/>";
			print "====================== <br/>";
			exit;*/
			$pay_amount = ($total_investment/100)* $pay_rate;
		if($pay_amount>0){

      $total_topup_first= db_scalar("select  max(topup_amount)  from ngo_users_recharge  where topup_userid ='$u_ref_userid_first'  ")+0;
      if ($total_topup_first >=$topup_required){
			  $pay_for ="Fasttrack Upgrade 1 Income  from - $topup_username";
			   $sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_group='FASTTRACK_INCOME',pay_userid ='$u_ref_userid_first' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id' ,pay_plan='FASTTRACK_INCOME' ,pay_plan_level='1'  ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 630 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE),pay_admin='INSTANT' ";
       db_query($sql2);
      }


	   if ($ctr>=2) {
	   $pay_for3 ="Fasttrack Upgrade  $ctr Income  from - $topup_username";
     $sql3 = "insert into ngo_users_payment set pay_drcr='Cr',pay_group='FASTTRACK_INCOME',pay_userid ='$u_ref_userid' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id' ,pay_plan='FASTTRACK_INCOME' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for3' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 630 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE),pay_admin='INSTANT' ";
	   db_query($sql3);
		} 
			
			//$arr_error_msgs[] =  "Your investment completed successfully!";
			}
		  ///}///direct condition
		} 
	}   
///////////////////////////////////////////// 
if ($topup_username!='') {
		 //$mobile = db_scalar("select u_mobile from ngo_users where u_username='$topup_username'");
		///send sms to user 
		///$message =  "DEAR  ".$topup_username." YOUR ACCOUNT  INVESTED SUCCESSFULLY WITH PACKAGE ".$topup_amount."; 
		// $message =  "Dear ".$topup_username." You have successfully purchased package ".$topup_amount.". Thanks ".SITE_URL;  
		/// send_sms($mobile,$message);
 }
} 
}

}

$_SESSION['arr_error_msgs'] = $arr_error_msgs;



 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='$pay_group' "); 

  //

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<? include("includes/extra_head.php")?>
<? include ("../includes/fvalidate.inc.php"); ?>
<script language="javascript">
<? sajax_show_javascript(); ?>
 
//------check username availability code start------------------------------------------------
 
function do_get_user_details() {
	
	//
	document.getElementById('details').innerHTML = "Loading...";
	topup_username= document.form1.topup_username.value;
	//alert(topup_username);
   	x_get_user_details('user_details', topup_username, do_get_user_details_cb);
 
 }
function do_get_user_details_cb(z) {
	//alert(z);
 	document.getElementById('details').innerHTML = z;
   }
   </script>
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
          <!-- Page Header -->
          <div class="dt-page__header " style="    border-bottom: 1px solid #ddd;">
            <h1 class="dt-page__title"> Package Upgradation </h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
            <div class="col-xl-3"> &nbsp; </div>
            <div class="col-xl-6">
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0" >
                  <!-- Tables -->
                  <div class="table-responsive" style="padding:10px;">
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p>
                    <form method="post" name="form1" id="form1"   class="forms-sample" <?= validate_form()?>  >
                      <?  if ($act!='done') { ?>
                      <?   if ($action=='')  { ?>
                      <p   ><strong>Wallet Balance :
                        <?=price_format($account_balance)?>
                        </strong></p>
                      <span> Username : </span>
                      <input type="text" class="form-control"    name="topup_username" value="<?=$topup_username?>" alt="blank" emsg="Username can not be blank"  placeholder="Username" onChange="do_get_user_details();" required/>
                      <div align="left" id="details" > </div>
                      <span> Upgrade Amount: </span>
                      <td valign="top"><!-- <input name="total_investment"  type="text" class="txtbox" value="<?=$total_investment?>"  alt="numeric|2" emsg="Please enter minimum amount $10"     />-->
                        <?

		///$sql ="select utype_charges , utype_name from ngo_users_type where  utype_status='Active' and utype_charges>0  order by utype_id asc";  

		/*$sql ="select utype_charges , utype_name from ngo_users_type where  utype_status='Active' and utype_charges>0  order by utype_charges asc"; 

		echo make_dropdown($sql, 'total_investment', $total_investment,  'class="txtbox" alt="select" emsg="Please select Package " style="width:240px;height:50px;"','--select--');*/

		?>
                        <select name="total_investment" class="form-control"   id="total_investment"  alt="select" emsg="Please Select Package"  required >
                          <option value="" >Select Package</option>
                          <option value="50" <? if($total_investment==50) {?> selected="selected" <? } ?>>Activation $50.00</option>
                          <option value="100" <? if($total_investment==100) {?>  selected="selected" <? } ?>>Activation $100.00</option>
                          <option value="500" <? if($total_investment==500) {?>  selected="selected" <? } ?>  >Activation $500.00</option>
                          <option value="1000" <? if($total_investment==1000) {?>  selected="selected" <? } ?>  >Activation $1000.00</option>
                          <option value="2500" <? if($total_investment==2500) {?>  selected="selected" <? } ?>  >Activation $2500.00</option>
                          <option value="5000" <? if($total_investment==5000) {?>  selected="selected" <? } ?>  >Activation $5000.00</option>
                          <option value="10000" <? if($total_investment==10000) {?>  selected="selected" <? } ?>  >Activation $10000.00</option>
                          <option value="20000" <? if($total_investment==20000) {?>  selected="selected" <? } ?>  >Activation $20000.00</option>
                          <option value="40000" <? if($total_investment==40000) {?>  selected="selected" <? } ?>  >Activation $40000.00</option>
                          <!--<option value="20" <? if($total_investment==10) {?>  selected="selected" <? } ?>  >Activation $20.00</option>-->
                          <!--<option value="50" <? if($total_investment==50) {?> selected="selected" <? } ?>>Activation $50.00</option>-->
                          <!--<option value="200" <? if($total_investment==200) {?>  selected="selected" <? } ?>  >Activation  $200.00</option>-->
                          <!-- <option value="3000" <? if($total_investment==3000) {?>  selected="selected" <? } ?>  >Activation $3000.00</option>-->
                          <? 

 					// Array ( [topup_amount] => 1000 [package] => 16 [user_password] => 33333 [Submit] =>   Submit   )

 					/*$ctr = 1 ;

					while ($ctr<=1000 ) { 

					$amount = 100*$ctr;*/

 					?>
                          <!--<option value="<?=$amount?>" <? if ($amount==$total_investment) { echo 'selected="selected"';} ?>><?=price_format($amount)?> </option>-->
                          <? /*$ctr++; }*/  ?>
                        </select>
                        <input type="hidden" name="pay_group" value="<?=$pay_group?>" />
                        <br>
                        <button type="submit" name="Submit" value="Continue"  class="btn btn-primary mr-2">Continue</button></td>
                      <? } else if ($action == 'Continue') { ?>
                      <p ><strong> Wallet Balance :
                        <?=price_format($account_balance)?>
                        </strong></p>
                      <p ><strong>Topup Username :
                        <?=$topup_username?>
                        (
                        <?=db_scalar("select u_fname from ngo_users where u_username='$topup_username' limit 0,1")?>
                        )</strong></p>
                      <strong>
                      <input type="hidden" value="<?=$topup_username?>" name="topup_username">
                      </strong>
                      <p ><strong> Package Amount:
                        <?=price_format($total_investment)?>
                        </strong></p>
                      <input name="total_investment"  type="hidden"   value="<?=$total_investment?>"    />
                      <input type="hidden" name="pay_group" value="<?=$pay_group?>" />
                      <br>
                      <button type="submit" name="Submit" value="Confirm Payment" class="btn btn-primary mr-2">Confirm Payment</button>
                      <? }  ?>
                      <?  } else {  ?>
                      <br>
                      <br>
                      <div class="td_box" align="center" > <a href="my_ewallet_upgrade.php">Click Here </a> To Upgrade new package again. </div>
                      <? }   ?>
                    </form>
                  </div>
                  <!-- /tables -->
                </div>
                <!-- /card body -->
              </div>
              <!-- /card -->
            </div>
            <!-- /grid item -->
          </div>
          <!-- /grid -->
        </div>
        <!-- Footer -->
        <? include("includes/footer.php")?>
        <!-- /footer -->
      </div>
      <!-- /site content wrapper -->
      <!-- Theme Chooser -->
      <!-- /theme chooser -->
      <!-- Customizer Sidebar -->
      <!-- /customizer sidebar -->
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
<? include("includes/extra_footer.php")?>
</body>
</html>
