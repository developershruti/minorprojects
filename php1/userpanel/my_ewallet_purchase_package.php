<?php
include ("../includes/surya.dream.php");
$bet_pack_id= encryptor('decrypt', $bet_pack_id_e);

/////////////

// Example usage:
/*$min = 1.5;
$max = 5.5;
$randomFloat = getRandomFloat($min, $max);
echo $randomFloat;
exit;*/
/////////////


// Ajax code 
$pg='afterlogin';
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

$arr_error_msgs =array();

/*$SERVICE_STATUS  = round(db_scalar("select sett_value from ngo_setting where sett_code = 'ID_ACTIVATION'"),0); 
if ($SERVICE_STATUS=='0') { $arr_error_msgs[] =  "Package purchase is currently unavailable, please try after some time" ; }
*/
  

$cw_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,'')) as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='CW'");
$rw_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,'')) as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='RW'"); 

 $u_bank_lock  = db_scalar("select u_bank_lock from ngo_users where u_id = '$_SESSION[sess_uid]'"); 
if ($u_bank_lock=='yes') { 
 	$arr_error_msgs[] =  db_scalar("select u_blocked_msg from ngo_users where u_id = '$_SESSION[sess_uid]'"); ; 
 }
 
 
 
 if(is_post_back()) {

$topup_userid = db_scalar("select u_id from ngo_users where u_username = '$topup_username' ");
	if ($topup_userid=='') { $arr_error_msgs[] =  $topup_username." User ID does not exist!  " ;} 
 	/*if ($topup_amount!='10.00') { 
  $topup_active_count= db_scalar("select count(*) from ngo_users_recharge  where topup_userid ='$topup_userid' and topup_amount='10.00'")+0;	
 if ($topup_active_count<1) { $arr_error_msgs[] = "Please Activate Your Account With Registration Promo Code"; } 
 } */
    $MINIMUM_INVESTMENT  = 10;
 	if ($topup_amount<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "Minimum Package amount is ". price_format($MINIMUM_INVESTMENT); }
	
	
	$bet_pack_status = db_scalar("select bet_pack_status from ngo_packages where bet_pack_id='$bet_pack_id' ");
	if($bet_pack_status=='Inactive'){
	$arr_error_msgs[] =  "Unfortunately, this package is currently unavailable.";
	} 
	
	
 	// and    pay_group='$pay_group'
	// $account_balance = db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_group='$pay_group'"); 
		if ($topup_amount<=0) { $arr_error_msgs[] =  "Package amount is missing!";}
	
	
	/*if ($topup_amount<=250) 	 { $rw_rate = 10;} // Refer wallet / Bonus wallet
	else if ($topup_amount==500) { $rw_rate = 20;}
	else if ($topup_amount==750) { $rw_rate = 30;}
	else if ($topup_amount>=1000){ $rw_rate = 50;}*/
	
	$rw_rate = 10; /// Promotional / refer wallet will be used maximum
	
	if($rw_balance>0){ 
		$rw_amount_max 	= ($topup_amount/100)*$rw_rate;
		if((double)$rw_balance>=(double)$rw_amount_max) { $rw_amount = $rw_amount_max;} else {$rw_amount = $rw_balance;} 
 	} else { $rw_amount=0;}
	
	if ((double)$rw_amount >(double)$rw_balance) 	{$arr_error_msgs[] 	="Your Promotional Bonus Wallet Balance is Insufficient";}

 	//$cw_amount =  (double)$topup_amount- (double)$rw_amount;
	//$cw_amount =  (double)$topup_amount ; // final code comment temp sk
	$cw_amount =  (double)$topup_amount - (double)$rw_amount;
	if ((double)$cw_amount >(double)$cw_balance) {$arr_error_msgs[] 	=   "Insufficient fund wallet balance! ";}
	
	//$total_chargeable_amount = (double)$cw_amount + (double)$rw_amount+0;
	//if ((double)$total_chargeable_amount >(double)$topup_amount) 	{ $arr_error_msgs[] 	=   "Something Went Wrong! Please Enter Valid Amount"; }

 
  //	if ($topup_amount >$account_balance) {$arr_error_msgs[] =   "Insufficient wallet balance!";}
  //$topup_package_active = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and topup_status='Paid' ");	
  
  /*$topup_amount_active = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and topup_amount='$topup_amount' and topup_status='Paid' ");	
  	if ($topup_amount_active>0) {
 		$arr_error_msgs[] = "You have already purchased this package! Please try to buy a different package.";
 	}  */
    

$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 //print_r($arr_error_msgs);
 if (count($arr_error_msgs) ==0) { 
 
	if ($_POST['Submit']=='Continue') {

		//$arr_error_msgs[] = "Are you sure want to investment - $total_investment";
  		$arr_error_msgs[] = "Are you sure want to purchase this package?";
 		$action = 'Continue';
 
   	} else if  ($_POST['Submit']=='Confirm Payment') {

		$action = 'Confirm';
 		$topup_days_for =75; /// 
 		
		if($bet_pack_id==1){ 
		$topup_rate = 2.90; //  UPTO 
 		$topup_code ='AI BET 1 STANDARD'; 
		$topup_days_for =75; /// Approx Days 
 		} else if($bet_pack_id==2){ 
		$topup_rate = 3.80; //  UPTO 
 		$topup_code ='AI BET 1 PREMIUM'; 
		$topup_days_for =60; /// Approx Days
 		} else if($bet_pack_id==3){ 
		$topup_rate = 3.40; //  UPTO 
 		$topup_code ='AI BET 2 STANDARD'; 
		$topup_days_for =65; /// Approx Days
		} else if($bet_pack_id==4){ 
		$topup_rate = 4.20; //  UPTO 
 		$topup_code ='AI BET 2 PREMIUM'; 
		$topup_days_for =65; /// Approx Days
		} else if($bet_pack_id==5){ 
		$topup_rate = 4.30; //  UPTO 
 		$topup_code ='AI BET 3 STANDARD'; 
		$topup_days_for =52; /// Approx Days
 		} else if($bet_pack_id==6){ 
		$topup_rate = 5.20; //  UPTO 
 		$topup_code ='AI BET 3 PREMIUM'; 
		$topup_days_for =43; /// Approx Days
		} else if($bet_pack_id==7){ 
		$topup_rate = 5.30; //  UPTO 
 		$topup_code ='AI BET 4 PREMIUM'; 
		$topup_days_for =42; /// Approx Days
		} else if($bet_pack_id==8){ 
		$topup_rate = 6.40; //  UPTO 
 		$topup_code ='AI BET 4 EXCLUSIVE'; 
		$topup_days_for =35; /// Approx Days
		} else if($bet_pack_id==9){ 
		$topup_rate = 6.50; //  UPTO 
 		$topup_code ='AI BET 5 PREMIUM'; 
		$topup_days_for =34; /// Approx Days
		} else if($bet_pack_id==10){ 
		$topup_rate = 7.50; //  UPTO 
 		$topup_code ='AI BET 5 EXCLUSIVE'; 
		$topup_days_for =29; /// Approx Days
		} else if($bet_pack_id==11){ 
		$topup_rate = 7.70; //  UPTO 
 		$topup_code ='AI BET 6 PREMIUM'; 
		$topup_days_for =28; /// Approx Days
		} else if($bet_pack_id==12){ 
		$topup_rate = 8.60; //  UPTO 
 		$topup_code ='AI BET 6 EXCLUSIVE'; 
		$topup_days_for =25; /// Approx Days
		}
 		 
  	 	 $topup_serialno = rand(10,99).db_scalar("select topup_id from ngo_users_recharge order by topup_id desc limit 0,1").rand(10,99);
  		 // $topup_code =  'SL'.rand(10,99).$topup_serialno.rand(10,99); 
		 //$topup_code =  'P'.rand(10,99).$topup_serialno.rand(10,99);
 		//$topup_amount_bonus = $topup_amount + $rw_amount; // // final code comment temp sk
		$topup_amount_bonus = $cw_amount + $rw_amount;
    	$sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid',topup_by_userid='$_SESSION[sess_uid]',topup_serialno='$topup_serialno' , topup_group='$topup_group', topup_code='$topup_code', topup_plan='TOPUP',topup_days_for='$topup_days_for', topup_rate='$topup_rate' ,topup_amount='$topup_amount_bonus', topup_bonus='$rw_amount', topup_amount2='$cw_amount', topup_date=ADDDATE(now(),INTERVAL 0 MINUTE), topup_datetime=ADDDATE(now(),INTERVAL 330 MINUTE),topup_exp_date=ADDDATE(now(),INTERVAL $topup_days_for DAY), topup_status='Paid' ";
 		db_query($sql);
 		$topup_id = mysqli_insert_id($GLOBALS['dbcon']);
 		$arr_success_msgs[] =  "Your purchase of this package for ".price_format($topup_amount)." was successful. " ;  
		$_SESSION['arr_success_msgs'] = $arr_success_msgs;
		

		$pay_for1 = "Purchase Package Fee For-$topup_username ,RefNo:#$topup_serialno" ;
		$pay_rate =  100;
		if($cw_amount>0){
			$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$topup_id' ,pay_plan='TOPUP_FEES' ,pay_group='CW' ,pay_for = '$pay_for1' ,pay_ref_amt='$topup_amount' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$cw_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 0 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
			db_query($sql1);
		
		}
		if($rw_amount>0){
			$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$topup_id' ,pay_plan='TOPUP_FEES' ,pay_group='RW' ,pay_for = '$pay_for1' ,pay_ref_amt='$topup_amount' ,pay_unit = 'Fix' ,pay_rate = '$rw_rate', pay_amount = '$rw_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 0 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
			db_query($sql1);
 		}
    		
		$action = '';
 		$_POST='';
 		$act='done';
		
		
		
		///////////////Level Income / Referral Income Instant on topup start ////////////////////////////// 
		
		$u_ref_userid = $topup_userid;//$u_ref_userid = $_SESSION['sess_uid'];
		$ctr=0;
		while ($ctr<3) { 
		$ctr++;
		$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
		//$referral_verify_email_status = db_scalar("select u_verify_email_status from ngo_users where u_id='$u_ref_userid' ");
		$sponsor_topup_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid='$u_ref_userid' ")+0;
		 
		if ($u_ref_userid!='' && $u_ref_userid!=0 && $sponsor_topup_count>=1){
			if($ctr==1)		{ $pay_rate2 =10; } //  
			else if($ctr==2){ $pay_rate2 =5;} //  
			else if($ctr==3){ $pay_rate2 =3;} ////  
			$pay_plan2 ='LEVEL_INCOME';
			//$pay_amount2 = ($pay_amount/100)*$pay_rate2;
			$pay_amount2 = ($topup_amount_bonus/100)*$pay_rate2;
			$pay_ref_amt = $pay_amount2;
			$pay_for2 ="Referral Income From Level $ctr By #".$topup_serialno; 
			
			///Checking Capping Start =======  Check For Sponsor's Working Capping // Working capping is 300% of topup amount
			
			$sponsor_total_topup = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$u_ref_userid' ")+0;
			$sponsor_total_capping = $sponsor_total_topup * 3; //300% of topup amount 
			// ROI, REFERAL ROI, Referral Income (LEVEL INCOME ON TOPUP) WILL BE CALCULATE IN CAPPING ///  (Note : WEEKLY_INCENTIVE & REWARDS CAPPING ME CALCULATE NAHI HOGA.. ISKA PAY GROUP RI DIYA HAI)
  			$total_earning_working = db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$u_ref_userid' and pay_group!='RI' and pay_drcr='Cr' ")+0;
 			
			// check for available capping 
			if($sponsor_total_capping>$total_earning_working){
			$sponsor_available_capping = $sponsor_total_capping - $total_earning_working;
			} else if($sponsor_total_capping<=$total_earning_working){
			$sponsor_available_capping = 0;
			$pay_for2 ="Flush Out : Referral Income From Level $ctr By #".$topup_serialno; 
			} 
 			
			
			if($pay_amount2>$sponsor_available_capping){ 
			$pay_amount2 = $sponsor_available_capping;
 			}
 			///Checking Capping End =======  Check For Sponsor's Working Capping  
  			$sql2 = "insert into ngo_users_payment set pay_drcr='Cr' ,pay_userid ='".$u_ref_userid."' ,pay_refid ='".$topup_id."', pay_topupid ='".$topup_id."', pay_group='WI', pay_plan='$pay_plan2' ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$pay_rate2', pay_amount = '$pay_amount2'  , pay_status = 'Paid', pay_date=ADDDATE(now(),INTERVAL 0 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='Instant' ";
			db_query($sql2);
			  
		} 
	}
 	///////////////Level Income / Referral Income Instant on topup end ////////////////////////////// 
 		
  	///////////////update pool////////////////////////////// 
 /*	$next_sponsor = db_scalar("select u_id from ngo_users,ngo_users_recharge where  u_id=topup_userid  and topup_amount='20' and u_id  not in( select u_sponsor_id from ngo_users where u_sponsor_id!='' group by u_sponsor_id having count(u_sponsor_id)>=4)  order by topup_id asc limit 0,1")+0;

 	//print "<br> ===========> $u_id  | $next_sponsor | $total_sponsor |  $topup_id  ";

	 if($next_sponsor>0) { 
 	db_query("update ngo_users set u_sponsor_id='$next_sponsor' where u_id='$topup_userid' ");
     }*/
 
////////////////////////////////////////////

	 ////////////////////////////////////////////
		//////////Direct Start
		 /*$u_ref_userid= db_scalar("select u_ref_userid from ngo_users where u_id = '$topup_userid' and u_status!='Banned'");
		 $total_topup_sponsor = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid ='$u_ref_userid'  ")+0; ///topup_status='Paid' and  
 		 $payout_count1 = db_scalar("select count(pay_id) from ngo_users_payment where pay_userid = '$u_ref_userid' and pay_refid = '$topup_userid' and pay_topupid='$topup_id' and pay_plan='BET_SPONSOR_BONUS_INCOME' ");
 		 
 				if ($payout_count1==0 && $u_ref_userid!='' && $total_topup_sponsor>0) { /// && $total_topup_sponsor>0
 				$pay_rate = 1; // FOR ALL PACKAGE
  				$pay_amount = ($topup_amount/100)*$pay_rate;
 				if($pay_amount>0){
 				#print " <br> = $u_ref_userid  = $total_referer ";on $u_username ref no:$topup_id
 			 	$pay_for ="Bet Sponsor Bonus @$pay_rate% From : $topup_username";
  				 $sql = "insert into ngo_users_payment set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id' ,pay_plan='BET_SPONSOR_BONUS_INCOME'  ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_plan_level='1'  ,pay_unit = '%' ,pay_rate = '$pay_rate',pay_group = 'WI', pay_amount = '$pay_amount', pay_admin = 'Instant' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
				 db_query($sql);
 				
 				}
 		 	}*/
		//////////Direct End
 
///////////////////////////////////////////// 
 
 } 

}

}

$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 
$pggroup = "allwallet"; 
$pgtitle = "All Wallet"; 
$pg = "purchase_package";
 

?>
 <!doctype html>
 <html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
 
<head>
<? include("includes/extra_head.php")?>
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
<body>
<!-- Begin page -->
<div id="layout-wrapper">
   <? include("includes/header.inc.php")?>
   <!-- ========== App Menu ========== -->
   <? include("includes/sidebar.php")?>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0">AI Bet Packages </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">AI Casino Package</a></li>
                  <li class="breadcrumb-item active">AI Bet Packages </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
		 <? /// include("error_msg.inc.php");?>
          <div class="col-xxl-3  ">
		  
            <div class="card newbordercolor">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">AI Package Details</h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 
                <div class="live-preview">
 
  <img width="100%" src="./assets/images/ai-packages/P0<?=$bet_pack_id?>.jpg"/>
  
 </div>
                  
              </div>
			  <p style="text-align:center; padding:0px 10px 0px 10px;"> 
 <a   href="ai-casino-packages.php" class="btn btn-primary text-uppercase">Back To AI Bet Packages </a></p>
            </div>
          </div>
          <!-- end col -->
          <div class="col-xxl-9  ">
             <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Purchase Package <a style="float:right;" href="ai-casino-packages.php" class="btn btn-primary text-uppercase">Back To AI Bet Packages </a></h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 
                <div class="live-preview">
  
                  <p align="left" >
                    <? include("error_msg.inc.php");?>
                    <?=$msgs?>
                  </p>
                   <form method="post" name="form1" id="form1"   class="forms-sample" <?= validate_form()?>  >
                    <?  if ($act!='done') { ?>
                    <?   if ($action == '')  { ?>
                    <p ><strong>Fund Wallet Balance :
                      <?=price_format($cw_balance)?>
                      </strong> <a href="deposit_process_bep20" class="btn btn-dark"  >Deposit</a></p>
					   <p ><strong> Promotional Bonus Wallet Balance :
                      <?=price_format($rw_balance)?>
                      </strong></p>
                    <div class="form-group mb-10">
                      <?php /*?> <span for="exampleInputUsername1">User ID :</span><?php */?>
                      <input type="text" class="form-control form-control-custom form-control-custom--outline form-control-custom--outline-thin t-text-white "   name="topup_username" value="<?=$topup_username?>" alt="blank" emsg="Username can not be blank"  placeholder="User Id" onChange="do_get_user_details();" required/>
                      <div align="left" id="details" > </div>
                    </div>
                    <div class="form-group mb-10"> 

                      <!--<span for="exampleInputEmail1">Package Amount:</span>-->
                      <!-- <input name="topup_amount"  type="text" class="txtbox" value="<?=$topup_amount?>"  alt="numeric|2" emsg="Please enter minimum amount $10"     />-->
                      <?

		///$sql ="select utype_charges , utype_name from ngo_users_type where  utype_status='Active' and utype_charges>0  order by utype_id asc";  

		/*$sql ="select utype_charges , utype_name from ngo_users_type where  utype_status='Active' and utype_charges>0  order by utype_charges asc"; 

		echo make_dropdown($sql, 'topup_amount', $topup_amount,  'class="txtbox" alt="select" emsg="Please select Package " style="width:240px;height:50px;"','--select--');*/

		?>
                      <select name="topup_amount" class="form-control form-control-custom form-control-custom--outline form-control-custom--outline-thin t-text-white "  id="topup_amount"   required>
                        <!--  <option value="" >Select Package Amount</option>-->
                        	<? if($bet_pack_id==1){ ?>
							<option value="10" <? if($topup_amount==10) {?> selected="selected" <? } ?>>$10.00 AI BET 1 STANDARD </option>
							<? } else if($bet_pack_id==2){ ?>
							<option value="10" <? if($topup_amount==10) {?> selected="selected" <? } ?>>$10.00 AI BET 1 PREMIUM  </option>
							<? } else if($bet_pack_id==3){ ?>
							<option value="50" <? if($topup_amount==50) {?> selected="selected" <? } ?>>$50.00 AI BET 2 STANDARD </option>
							<? } else if($bet_pack_id==4){ ?>
							<option value="50" <? if($topup_amount==50) {?> selected="selected" <? } ?>>$50.00 AI BET 2 PREMIUM </option>
							<? } else if($bet_pack_id==5){ ?>
							<option value="250" <? if($topup_amount==250) {?> selected="selected" <? } ?>>$250.00 AI BET 3 STANDARD </option>
							<? } else if($bet_pack_id==6){ ?>
							<option value="250" <? if($topup_amount==250) {?> selected="selected" <? } ?>>$250.00 AI BET 3 PREMIUM </option>
							<? } else if($bet_pack_id==7){ ?>
							<option value="500" <? if($topup_amount==500) {?> selected="selected" <? } ?>>$500.00 AI BET 4 PREMIUM </option>
							<? } else if($bet_pack_id==8){ ?>
							<option value="500" <? if($topup_amount==500) {?> selected="selected" <? } ?>>$500.00 AI BET 4 EXCLUSIVE</option>
							<? } else if($bet_pack_id==9){ ?>
							<option value="1000" <? if($topup_amount==1000) {?> selected="selected" <? } ?>>$1000.00 AI BET 5 PREMIUM </option>
							<? } else if($bet_pack_id==10){ ?>
							<option value="1000" <? if($topup_amount==1000) {?> selected="selected" <? } ?>>$1000.00 AI BET 5 EXCLUSIVE </option>
							<? } else if($bet_pack_id==11){ ?>
							<option value="2500" <? if($topup_amount==2500) {?> selected="selected" <? } ?>>$2500.00 AI BET 6 PREMIUM </option>
							<? } else if($bet_pack_id==12){ ?>
							<option value="2500" <? if($topup_amount==2500) {?> selected="selected" <? } ?>>$2500.00 AI BET 6 EXCLUSIVE </option>
							<? } ?>
                         
                        <? 

 					// Array ( [topup_amount] => 1000 [package] => 16 [user_password] => 33333 [Submit] =>   Submit   )

 					/*$ctr = 1 ;

					while ($ctr<=1000 ) { 

					$amount = 100*$ctr;*/

 					?>
                        <!--<option value="<?=$amount?>" <? if ($amount==$topup_amount) { echo 'selected="selected"';} ?>><?=price_format($amount)?> </option>-->
                        <? /*$ctr++; }*/  ?>
                      </select>
                      
                    </div>
					 <input name="bet_pack_id"  type="hidden"   value="<?=$bet_pack_id?>"  />
                    <button type="submit" name="Submit" value="Continue" class="btn btn-primary mr-2">Continue</button>
                    <? } else if ($action == 'Continue') { ?>
                    <p ><strong> Fund Wallet Balance :
                      <?=price_format($cw_balance)?>
                      </strong></p>

					   <p ><strong> Promotional Bonus Wallet Balance :
                      <?=price_format($rw_balance)?>
                      </strong></p>
                     
                    <p ><strong>User Id :
                      <input type="hidden" value="<?=$topup_username?>" name="topup_username">
                      <?=$topup_username?>
                      (
                      <?=db_scalar("select u_fname from ngo_users where u_username='$topup_username' limit 0,1")?>
                      ) </strong></p>
                    
                    <p ><strong>Package Amount :
                      <?=price_format($topup_amount)?>
                      </strong></p>
                     <input name="topup_amount"  type="hidden"   value="<?=$topup_amount?>"  />
					 
					  <p ><strong>Amount Used from Promotional Bonus Wallet  :
                      <?=price_format($rw_amount)?>
                      </strong></p>
					  <input name="bet_pack_id"  type="hidden"   value="<?=$bet_pack_id?>"  />
                    
                    <button type="submit" name="Submit" value="Confirm Payment" class="btn btn-primary mr-2">Confirm Payment</button>
                    <? }  ?>
                    <?  } else {  ?>
                    <br>
                    <br>
                    <div class="td_box" align="center"  > 
					<a href="ai-casino-packages.php" class="btn btn-primary text-uppercase">Purchase AI Bet Packages Again? Click here  </a>
					
					 </div>
                    <? }   ?>
                  </form>
 </div>
                 
              </div>
            </div>
          </div>
        </div>
        <!--end row-->
        
      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
      <? include("includes/footer.php")?>
  </div>
  <!-- end main content-->
</div>
<!-- END layout-wrapper -->
<? include("includes/extra_footer.php")?>
</body>
 
</html>               