<?php
include ("../includes/surya.dream.php");
// Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_user_details");
sajax_handle_client_request();
// END Ajax code 
 
/*if ($_SESSION['sess_status']=='Inactive') {
 	 header("location: my_ewallet_acc_activation.php");
	 exit;
} */  

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

  /// and code_useto>=ADDDATE(now(),INTERVAL 570 MINUTE)

	$topup_userid = db_scalar("select u_id from ngo_users where u_username = '$topup_username' ");

	if ($topup_userid=='') { $arr_error_msgs[] =  $topup_username." Username does not exist!  " ;} 

 	/*if ($total_investment!='10.00') { 

  $topup_active_count= db_scalar("select count(*) from ngo_users_recharge  where topup_userid ='$topup_userid' and topup_amount='10.00'")+0;	

 if ($topup_active_count<1) { $arr_error_msgs[] = "Please Activate Your Account With Registration Promo Code"; } 

 

 } */

 	#$user_password = db_scalar("select u_password2 from ngo_users where u_password2 = '$user_password' and u_id='$_SESSION[sess_uid]'");	

	#if ($user_password =='') { $arr_error_msgs[] =  "E-Bank Password does not match!";}

	//and pay_group='$pay_group'

    $MINIMUM_INVESTMENT  = 34;

 	if ($total_investment<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Minimum package amount is ". price_format($MINIMUM_INVESTMENT); }

 	// and    pay_group='$pay_group'

	 $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group='$pay_group'"); 

	if ($total_investment<=0) { $arr_error_msgs[] =  "Package amount is missing!";}

	 

 	 if ($total_investment >$account_balance) {$arr_error_msgs[] =   "Insufficient Wallet Balance balance!";}

	

	 $topup_amount_active = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' ");	

 	if ($topup_amount_active>0) {

		$arr_error_msgs[] = "$topup_username account Already activated ";

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

		
		
		$topup_amount 	=30; //// actual investment is including GST. 34$

		$topup_amount2 	=$total_investment;

 		

		$topup_circle = 1;

		$topup_rate =0.00; //1% cashback daily

 		$topup_days_for =365; ///200 Days

 		

  	 	//$topup_serialno = rand(10,99).db_scalar("select topup_id from ngo_users_recharge order by topup_id desc limit 0,1").rand(10,99);

 		//$topup_code =  'SL'.rand(10,99).$topup_serialno.rand(10,99);

  

    	 $sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid',topup_by_userid='$_SESSION[sess_uid]',topup_serialno='0' ,topup_group='C1', topup_code='$topup_code', topup_plan='TOPUP' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate'   ,topup_amount='$topup_amount' ,topup_amount2='$topup_amount2' ,topup_date=ADDDATE(now(),INTERVAL  570 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 570 MINUTE),topup_exp_date=ADDDATE(now(),INTERVAL 365 DAY)  ,topup_status='Paid' ";

		db_query($sql);

		$topup_id = mysqli_insert_id($GLOBALS['dbcon']);

		$arr_error_msgs[] =  "$topup_username account activate successfully with package ".price_format($total_investment)." " ;  

		

		$pay_for1 = "Purchase Package - $topup_username" ;

		$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$topup_id' ,pay_plan='TOPUP_FEES' ,pay_group='$pay_group' ,pay_for = '$pay_for1' ,pay_ref_amt='$topup_amount' ,pay_unit = 'Fix' ,pay_rate = '100', pay_amount = '$total_investment',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";

		///exit;

		db_query($sql1);

 		$action = '';

		$_POST='';

		$act='done';

		

		///////////////update pool////////////////////////////// 



	$next_sponsor = db_scalar("select u_id from ngo_users,ngo_users_recharge where  u_id=topup_userid  and topup_amount='20' and u_id  not in( select u_sponsor_id from ngo_users where u_sponsor_id!='' group by u_sponsor_id having count(u_sponsor_id)>=4)  order by topup_id asc limit 0,1")+0;

 	//print "<br> ===========> $u_id  | $next_sponsor | $total_sponsor |  $topup_id  ";

	 if($next_sponsor>0) { 
 	db_query("update ngo_users set u_sponsor_id='$next_sponsor' where u_id='$topup_userid' ");
     }



////////////////////////////////////////////

		$u_ref_userid =$topup_userid;

		$ctr=0;

		while ($ctr<50) { 

		   $ctr++;

		   $u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");

		   $total_topup= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_userid ='$u_ref_userid'  ")+0;

 		if ($u_ref_userid!='' && $u_ref_userid!=0 && $total_topup >=1){

			// set rate

			if ($ctr==1) {
			$pay_group='DIRECT_INCOME';
 			$pay_plan='DIRECT_INCOME';
 $total_direct= db_scalar("select  count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active'  and u_ref_userid ='$u_ref_userid' ")+0;
			if ($total_direct==1) {
			 $pay_rate = 20;
			 }else if ($total_direct==2) {
			 $pay_rate = 30;
			 }else if ($total_direct==3) {
			 $pay_rate = 40;
			  }else if ($total_direct>=4) {
			 $pay_rate = 50;
			  
   			 } 
			
			}

			else if ($ctr>=2 && $ctr<=10) {$pay_rate = 0.50;  $pay_group='LEVEL_INCOME'; $pay_plan='LEVEL_INCOME'; } ///pay_rate is not % it $ value that will be distributed
			
			else if ($ctr>=11 && $ctr<=20) {$pay_rate = 0.10;  $pay_group='LEVEL_INCOME'; $pay_plan='LEVEL_INCOME'; } ///pay_rate is not % it $ value that will be distributed
			
			else if ($ctr>=21 && $ctr<=50) {$pay_rate = 0.05;  $pay_group='LEVEL_INCOME'; $pay_plan='LEVEL_INCOME'; } ///pay_rate is not % it $ value that will be distributed
 			/*if($ctr<5) { $total_direct =4;} else {

				$total_direct = db_scalar("select count(u_id) from ngo_users where u_ref_userid='$u_ref_userid' "); 

			}
 			if($total_direct>=$ctr){ */
 			//$pay_rate = 10;
			if ($ctr==1) {
 			$pay_amount = ($topup_amount/100)* $pay_rate;
 			} else { 
			$pay_amount =  $pay_rate;
			} 
 
			if($pay_amount>0){

			$pay_for ="ID Activation Level $ctr Income  Refno-$topup_id";

			$sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_group='$pay_group',pay_userid ='$u_ref_userid' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE),pay_admin='SPOT' ";

			db_query($sql2);

			//$arr_error_msgs[] =  "Your investment completed successfully!";

			}

		 ///}

		} 

	} 

/////////////////////send coin on topup worth 20$ start
/*
		$coin_rate = db_scalar("SELECT  sett_value FROM ngo_setting where sett_code='COIN_RATE' ");

		//HC = HOLDING COIN

 		$coin_worth_amount = 20;

		///$total_coin = round($coin_worth_amount/$coin_rate);

		$total_coin = ($coin_worth_amount/$coin_rate);

 		$pay_for111 = "Promotional Coin @ $coin_rate" ;

		$sql11 = "insert into ngo_users_coin set  pay_drcr='Cr',  pay_userid = '$topup_userid',pay_refid = '0' ,pay_plan='COIN_BUY' ,pay_group='HC' ,pay_for = '$pay_for111' ,pay_ref_amt='$total_investment' ,pay_unit = 'C' ,pay_rate = '$coin_rate', pay_amount = '$total_coin',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE) ";

 		db_query($sql11);
*/
		

/////////////////////send coin on topup worth 20$ end	

	

	  

///////////////////////////////////////////// 

 if ($topup_username!='') {

		 $mobile = db_scalar("select u_mobile from ngo_users where u_username='$topup_username'");

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
            <h1 class="dt-page__title">Package Activation </h1>
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
                      <?   if ($action == '')  { ?>
                      <p ><strong>Wallet Balance :
                        <?=price_format($account_balance)?>
                        </strong></p>
                      <br>
                      <div class="form-group"> <span for="exampleInputUsername1">Activate (User Id) :</span>
                        <input type="text" class="form-control"   name="topup_username" value="<?=$topup_username?>" alt="blank" emsg="Username can not be blank"  placeholder="User Id" onChange="do_get_user_details();" required/>
                        <div align="left" id="details" > </div>
                      </div>
                      <div class="form-group"> <span for="exampleInputEmail1">Activation Amount:</span>
                        <!-- <input name="total_investment"  type="text" class="txtbox" value="<?=$total_investment?>"  alt="numeric|2" emsg="Please enter minimum amount $10"     />-->
                        <?

		///$sql ="select utype_charges , utype_name from ngo_users_type where  utype_status='Active' and utype_charges>0  order by utype_id asc";  

		/*$sql ="select utype_charges , utype_name from ngo_users_type where  utype_status='Active' and utype_charges>0  order by utype_charges asc"; 

		echo make_dropdown($sql, 'total_investment', $total_investment,  'class="txtbox" alt="select" emsg="Please select Package " style="width:240px;height:50px;"','--select--');*/

		?>
                        <select name="total_investment" class="form-control"  id="total_investment"    alt="select" emsg="Please Select Package"  required>
                          <option value="" >Select Package</option>
                          <option value="34" <? if($total_investment==34) {?> selected="selected" <? } ?>>Activation $34.00</option>
                          <!--  <option value="20" <? if($total_investment==20) {?>  selected="selected" <? } ?>  >Activation $20.00</option>

               <option value="50" <? if($total_investment==50) {?> selected="selected" <? } ?>>Activation $50.00</option>

               <option value="100" <? if($total_investment==100) {?>  selected="selected" <? } ?>>Activation $100.00</option>

               <option value="200" <? if($total_investment==200) {?>  selected="selected" <? } ?>  >Activation  $200.00</option>

               <option value="500" <? if($total_investment==500) {?>  selected="selected" <? } ?>  >Activation $500.00</option>

               <option value="1000" <? if($total_investment==1000) {?>  selected="selected" <? } ?>  >Activation $1000.00</option>

               <option value="2000" <? if($total_investment==2000) {?>  selected="selected" <? } ?>  >Activation $2000.00</option>

               <option value="5000" <? if($total_investment==5000) {?>  selected="selected" <? } ?>  >Activation $5000.00</option>

               <option value="10000" <? if($total_investment==10000) {?>  selected="selected" <? } ?>  >Activation $10000.00</option>

               <option value="20000" <? if($total_investment==20000) {?>  selected="selected" <? } ?>  >Activation $20000.00</option>

               <option value="50000" <? if($total_investment==50000) {?>  selected="selected" <? } ?>  >Activation $50000.00</option>-->
                          <? 

 					// Array ( [topup_amount] => 1000 [package] => 16 [user_password] => 33333 [Submit] =>   Submit   )

 					/*$ctr = 1 ;

					while ($ctr<=1000 ) { 

					$amount = 100*$ctr;*/

 					?>
                          <!--<option value="<?=$amount?>" <? if ($amount==$total_investment) { echo 'selected="selected"';} ?>><?=price_format($amount)?> </option>-->
                          <? /*$ctr++; }*/  ?>
                        </select>
                        <input type="hidden" name="pay_group" value="<?=$pay_group?>"  />
                      </div>
                      <button type="submit" name="Submit" value="Continue" class="btn btn-primary mr-2">Continue</button>
                      <? } else if ($action == 'Continue') { ?>
                      <p ><strong> Wallet Balance :
                        <?=price_format($account_balance)?>
                        </strong></p>
                      <br>
                      <p ><strong>Topup Username:
                        <input type="hidden" value="<?=$topup_username?>" name="topup_username">
                        <?=$topup_username?>
                        (
                        <?=db_scalar("select u_fname from ngo_users where u_username='$topup_username' limit 0,1")?>
                        ) </strong></p>
                      <br>
                      <p ><strong>Package Amount :
                        <?=price_format($total_investment)?>
                        </strong></p>
                      <input name="total_investment"  type="hidden"   value="<?=$total_investment?>"  />
                      <input type="hidden" name="pay_group" value="<?=$pay_group?>" />
                      <button type="submit" name="Submit" value="Confirm Payment" class="btn btn-primary mr-2">Confirm Payment</button>
                      <? }  ?>
                      <?  } else {  ?>
                      <br>
                      <br>
                      <div class="td_box" align="center"  > <a href="my_ewallet_investment.php">Click Here </a> To Activate Another Account. </div>
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
