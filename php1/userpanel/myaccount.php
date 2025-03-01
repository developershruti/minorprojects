<?php
include ("../includes/surya.dream.php");
protect_user_page();
$sql_details = "select * from ngo_users where  u_id ='$_SESSION[sess_uid]'";
$result_details = db_query($sql_details);
$line_details= mysqli_fetch_array($result_details);
@extract($line_details); 
$arr_error_msgs =array();
$sql_hc="SELECT  
SUM(IF(pay_plan='LEVEL_INCOME',pay_amount,'')) as LEVEL_INCOME ,
SUM(IF(pay_plan='POOL_INCOME',pay_amount,''))as POOL_INCOME ,
SUM(IF(pay_plan='REWARD_INCOME',pay_amount,'')) as REWARD_INCOME ,
SUM(IF(pay_plan='BANK_WITHDRAW',pay_amount,'')) as BANK_WITHDRAW 
FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]'";
$result_hc=db_query($sql_hc);
$row_hc=mysqli_fetch_array($result_hc); 
@extract($row_hc); 
$_SESSION['arr_error_msgs'] = $arr_error_msgs; 
 
$sql_popup = "select * from ngo_image where image_title ='DASHBOARD'";
$result_popup = db_query($sql_popup);
$line_popup= mysqli_fetch_array($result_popup);
@extract($line_popup); 




?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
<head>
<? include("includes/extra_head.php")?>
<? if($image_status=='Active'){ ?>
<style type="text/css">
.dmpopupback {
	background-color: rgba(0, 0, 0, 0.64);
 	right: 0px;
	left: 0px;
	top: 0px;
	bottom: 0px;
	position: fixed;
	z-index: 9999;
	height:800px;
}
#dmloadpopup {
	width: 60%;
	margin: 0px auto;
	position: fixed;
	left: 0px;
	right: 0px;
	z-index: 99999;
	opacity: 0;
}
#dmloadpopup img {
	width: 100%;
}
#close {
	position: absolute;
	top: 0px;
	right: 0px;
	z-index: 99999;
	background-color: #ff0000;
	width: 30px;
	height: 30px;
	text-align: center;
	line-height: 30px;
	font-family: sans-serif;
	font-weight: bold;
	cursor: pointer;
	color:#FFFFFF;
}
@media (max-width:500px) {
#dmloadpopup {
	width: 90%;
}
</style>
<? } ?>
</head>



<body >
<!-- Begin page -->
<div id="layout-wrapper">
  <? include("includes/header.inc.php")?>
  <!-- ========== App Menu ========== -->
  <? include("includes/sidebar.php")?>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content" style="opacity: 1;">
    <div class="page-content" style="background: url('../images/demo-cryptocurrency-bg-05.jpg') fixed ; opacity: 1;" >
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0">Dashboard</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                  <li class="breadcrumb-item active">Overview</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
		 <? include("error_msg.inc.php");?>



 
			   
			   
		<!--<button onclick="playSound()">Click me!</button>
		 <audio id="myAudio" src="assets/audio/announcement.mp3"></audio>
		 <script>
    function playSound() {
      var audio = document.getElementById("myAudio");
      audio.play();
    }
  </script>-->	
   
  
 <?php /*?> <button class="play-sound">Click me!</button><?php */?>
  <style>
  .text-white {
     color:#000!important;
}
  .bg-soft-primary {
     background-color: #152123 !important;
    border: solid 1px #fff!important;
}
.bg-red-fill {
    background:#97e14d!important;
}

.shruti{
  color: #97e14d !important;

}
.toget{
  color: #152123 !important;
  
}
  
  </style>
  
  
   <div class="row">
			 
			
			 
			
			
                            <!--end col-->
              <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill"  >
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx bx-wallet text-success shruti shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white" >My Wallet Balance</h5>
                      </div>
                    </div>
                    <div class="mt-2 pt-1">
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""> <?=price_format($acc_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='CW' "));?> </span> <a href="deposit_process_bep20" class="btn btn-dark" style="float:right;">Deposit</a> </h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx bx-cart text-success shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white">Active Package </h5>
                      </div>
                    </div>
					<? $unit_you = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$_SESSION[sess_uid]' and topup_status='Paid'") ?>
                    <div class="mt-2 pt-1">
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""> <?=price_format($unit_you)?>  </span> <a href="my_ewallet_investment" class="btn btn-dark" style="float:right;">Purchase</a></h4>
                    </div>
                  </div>
                </div>
              </div>
			  <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx bx-dollar text-success shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white"> My Earning | <span class="text-light">Balance</span></h5>
                      </div>
                    </div>
                    <div class="mt-2 pt-1">
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""><?=price_format(db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_drcr='Cr' "));?> | <span class="text-light"><?=price_format(db_scalar("select  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance from ngo_users_payment where pay_userid='$_SESSION[sess_uid]' "));?></span> </span> <a href="my_ebank_fund_withdraw.php" class="btn btn-dark" style="float:right;">Withdraw</a></h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx bx-money text-success shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white">Capping  | <span class="text-light">Available</span> </h5>
                      </div>
                    </div>
                    <div class="mt-2 pt-1">
					<? 	$total_capping = $unit_you*3;
					 	$total_working = db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_group!='RI' and pay_drcr='Cr' ")+0;
						$capping_balance = $total_capping -$total_working; 
					 ?>
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""><?=price_format($total_capping)?> | <span class="text-light"><?=price_format($capping_balance)?> </span> </span> <a href="my_ewallet_investment" class="btn btn-dark" style="float:right;">Extend</a></h4>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
			
		<!--Rank Reward-->	
	<div class="row">
			 
			 <?
			 		$total_referer_all = db_scalar("select  count(*) from ngo_users where u_status='Active' and u_ref_userid ='$_SESSION[sess_uid]'  ")+0;
				  //$total_referer = db_scalar("select  count(*) from ngo_users where u_status='Active' and u_ref_userid ='$_SESSION[sess_uid]'  ")+0;
				  //$total_referer_active = db_scalar("select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and u_ref_userid ='$_SESSION[sess_uid]'  ")+0;
				  $total_referer_active = db_scalar("select count(DISTINCT(topup_userid)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and u_ref_userid ='$_SESSION[sess_uid]' ")+0;
				  $total_direct_business = db_scalar("select sum(topup_amount) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and u_ref_userid ='$_SESSION[sess_uid]'  ")+0;
				  $total_team_level = downline_total_ids($_SESSION['sess_uid']);
 				  $team_business_total = direct_total_business_date_range($_SESSION['sess_uid'] ,$sql_part, 3);
 				  $team_business = $team_business_total - $total_direct_business;
				  
				  $team_member_total = (direct_total_team_date_range($_SESSION['sess_uid'] ,$sql_part, 3))- $total_referer_active;
				  
				  
 				  $my_rank_achieved = db_scalar("select u_rank from ngo_users where u_id ='$_SESSION[sess_uid]' ")+0;
 				  ?> 
			 
			
			
                            <!--end col-->
               <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill"  >
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx ri-group-line text-success shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white" >  Total Direct | Active Direct </h5>
                      </div>
                    </div>
                    <div class="mt-2 pt-1">
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""><?=$total_referer_all?> Member | <?=$total_referer_active;?> Member   </span> <!--<a href="direct_list.php" class="btn btn-dark" style="float:right;">Details</a>--></h4>
                    </div>
                  </div>
                </div>
              </div>
			  
			  
			  <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill"  >
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx ri-team-line text-success shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white" >Direct Business </h5>
                      </div>
                    </div>
                    <div class="mt-2 pt-1">
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""><?=price_format($total_direct_business);?>   </span>  </h4>
                    </div>
                  </div>
                </div>
              </div>
			  
			  
			  
			  <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill"  >
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx ri-briefcase-line text-success shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white" >Team Business | <span class="text-light">Members</span> </h5>
                      </div>
                    </div>
                    <div class="mt-2 pt-1">
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""><?=price_format($team_business+0);?> | <span class="text-light"><?=$team_member_total?> Member</span>   </span>  </h4>
                    </div>
                  </div>
                </div>
              </div>
			  
			  
			  
			  <div class="col-xl-3 col-md-6">
                <div class="card card-height-100 bg-red-fill"  >
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm flex-shrink-0"> <span class="avatar-title bg-soft-primary rounded fs-3"> <i class="bx ri-medal-line text-success shruti"></i> </span> </div>
                      <div class="flex-grow-1 ps-3">
                        <h5 class="text-muted text-uppercase fs-13 mb-0 text-white" >Yesterday Earning </h5>
                      </div>
                    </div>
                    <div class="mt-2 pt-1">
                      <h4 class="fs-15 fw-semibold ff-secondary mb-0 text-white"><span class="co unter-value" data-target=""><?=price_format(db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_drcr='Cr' and pay_date = DATE_SUB(CURDATE(), INTERVAL 1 DAY)"));?>  </span>  </h4>
                    </div>
                  </div>
                </div>
              </div>
               
			   
               
              
            </div>
     
			     
             
			   <div class="row">
       
		<?php /*?><div class="col-xxl-3 floated-left" style="float:left;">
          <div class="card">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-xxl-12">
                  <div class="">
                    <div class="card-header border-0 align-items-center d-flex">
                      <h4 class="card-title mb-0 flex-grow-1">To Get Latest Update</h4>
                    </div>
                    <!-- end card header -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-2">
              <div class="row">
			  
			 
                <div class="col-md-12 col-sm-6 pb-15">
                  <div class="counter" style="text-align:center; padding:0px;"> <span class="counter-text toget">
                   Follow Us On Telegram
                    </span>
                    <div class="counter-icon"> <span><i class="ri-telegram-line"></i></span> </div>
                    <p style="text-align:center; padding:5px;"><a target="_blank" href="https://t.me/xxxxxx" class="btn btn-primary text-uppercase blink_text" style="margin-top:-28px;">Follow Now </a></p>
                  </div>
                </div>
				 
                 
                 
                 
              </div>
            </div>
          </div>
        </div><?php */?>
		<div class="col-xxl-12 floated-left"  >
          <div class="card">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-xxl-12">
                  <div class="">
                    <div class="card-header border-0 align-items-center d-flex">
                      <h4 class="card-title mb-0 flex-grow-1">Account Overview</h4>
                    </div>
                    <!-- end card header -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-2">
              <div class="row">
			  
			 
			  
			  
			  
			  
			  
			  
			  
			  
			  
              <!--  <div class="col-md-4 col-sm-6 pb-15">
                  <div class="counter"> <span class="counter-text">
                    <?=$_SESSION['sess_username']?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-file-user-line"></i></span> </div>
                    <h3>User ID</h3>
                  </div>
                </div>-->
                <div class="col-md-4 col-sm-6 pb-15">
                  <div class="counter pink"> <span class="counter-text toget" title="<?=$_SESSION['sess_fname']?>">
                    
					<?=str_stop($_SESSION['sess_fname'],20);?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-file-user-line"></i></span> </div>
                    <h3>Full Name</h3>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 pb-15">
                  <div class="counter orange"> <span class="counter-text toget" title="<?=$_SESSION['sess_email']?>">
                    <?=str_stop($_SESSION['sess_email'],20);?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-mail-line"></i></span> </div>
                    <h3>Your Email  <?  if($_SESSION['sess_verify_email_status'] == 'Verified'){ ?><i class="ri-mail-check-fill text-success shruti"></i><? } else {  ?><i class="ri-mail-close-fill text-danger"></i>
						<? }   ?>  </h3>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 pb-15">
                  <div class="counter blue"> <span class="counter-text toget">
                    <?=$line_details['u_country_code']?>&nbsp;<?=$_SESSION['sess_mobile']?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-smartphone-line"></i></span> </div>
                    <h3>Mobile</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		
		 
		<?php /*?><div class="col-xxl-3 floated-left" style="float:left;">
          <div class="card">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-xxl-12">
                  <div class="">
                    <div class="card-header border-0 align-items-center d-flex">
                      <h4 class="card-title mb-0 flex-grow-1">Leading Earners</h4>
                    </div>
                    <!-- end card header -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-2 mb-10" style="m">
              <div class="row">
 
				<div class="col-md-12 col-sm-6 pb-15">
                  <div class="counter"> <span class="counter-text toget">
                   Top Leading Earners
                    </span>
                    <div class="counter-icon"> <span><i class="ri-award-line"></i></span> </div>
                    
					<p>
					<marquee direction="up" height="222" scrollamount="4"  width="100%" style="background:#fff;" onMouseOver="this.stop();" onMouseOut="this.start();">
              <table class="table table-bordered" width="100%">
			  <?  
 
$sql_achiever = "select * from ngo_users where u_id>2 and u_id in (select pay_userid from ngo_users_ewallet WHERE pay_group='RW') AND u_verify_email_status='Verified' order by rand() limit 50 ";  
$result_achiever = db_query($sql_achiever);
$total_achiever = mysqli_num_rows($result_achiever);
if ($total_achiever>0){
while($line_achiever= mysqli_fetch_array($result_achiever)){;
$ctr_achiever++;
 		?>
                  
				  <tr><td>
				   <?=str_stop($line_achiever['u_username'], 25);?>
				   </td><td>  <img src="../assets/images/chippp.png" alt="jaqport-thumb" class="rounded-circle"> </td><td>
                 
                    <h6><?=price_format(db_scalar("SELECT SUM(pay_amount) FROM ngo_users_ewallet where pay_userid='$line_achiever[u_id]' and pay_group='RW' and pay_drcr='Cr' ")+0);?></h6>
                  </td> 
				  </tr>
				
 <? } } ?>
 				 
                </table>
                 
               
			  </marquee>
				<p>	
					 
                  </div>
                </div>
                 
                 
                 
              </div>
            </div>
          </div>
        </div><?php */?>
		
		
		
		<div class="col-xxl-12"  >
          <div class="card">
            <div class="card-body p-0 ">
              <div class="row g-0">
                <div class="col-xxl-12">
                  <div class="">
                    <div class="card-header border-0 align-items-center d-flex">
                      <h4 class="card-title mb-0 flex-grow-1">Earning Overview</h4>
                    </div>
                    <!-- end card header -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-2 ">
			 
              <div class="row ">
                <div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter"> <span class="counter-text toget">
                     <?=price_format(db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_plan='DAILY_RETURN' and pay_drcr='Cr' "));?>
                     </span>
                    <div class="counter-icon"> <span><i class="ri-hand-coin-line"></i></span> </div>
                    <h3>Total Daily Profit</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter pink"> <span class="counter-text toget">
                   <?=price_format(db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_plan='DIRECT_INCOME' and pay_drcr='Cr' "));?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-share-line"></i></span> </div>
                    <h3>Total Referral Bonus</h3>
                  </div>
                </div>
				
				<div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter blue"> <span class="counter-text toget"> 
				  <?=price_format(db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_plan='LEVEL_INCOME' and pay_drcr='Cr' "));?>
                    
                    </span>
                    <div class="counter-icon"> <span><i class="ri-coin-fill"></i></span> </div>
                    <h3>Total Level Bonus</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter orange"> <span class="counter-text toget">
                   <?=price_format(db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_plan='FUND_WITHDRAW' and pay_drcr='Dr' "));?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-wallet-line"></i></span> </div>
                    <h3>Total Fund Withdrawal</h3>
                  </div>
                </div> 
                  
              </div>
            </div>
          </div>
		  
		   
        </div>
		
		 
		
		</div>
        <?php /*?><div class="col-xxl-12">
          <div class="card">
            <div class="card-body p-0 ">
              <div class="row g-0">
                <div class="col-xxl-12">
                  <div class="">
                    <div class="card-header border-0 align-items-center d-flex">
                      <h4 class="card-title mb-0 flex-grow-1">Earning Overview</h4>
                    </div>
                    <!-- end card header -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-2 ">
              <div class="row ">
                <div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter"> <span class="counter-value">
                    <?=db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_drcr='Cr' ")+0;?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-hand-coin-line"></i></span> </div>
                    <h3>Total Earned</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter pink"> <span class="counter-value">
                    <?=($BANK_WITHDRAW);?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-coins-line"></i></span> </div>
                    <h3>Total Withdrawal</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter blue"> <span class="counter-value">
                    <?=$earn_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Dr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM  ngo_users_payment where pay_userid='$_SESSION[sess_uid]'")?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-coin-fill"></i></span> </div>
                    <h3>Earning Balance</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 pb-15">
                  <div class="counter orange"> <span class="counter-value">
                    <?=(db_scalar("SELECT SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))  as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='CW'  "))+0;?>
                    </span>
                    <div class="counter-icon"> <span><i class="ri-wallet-line"></i></span> </div>
                    <h3>Wallet Balance</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><?php */?>
        <?php /*?><div class="col-xxl-12">
          <div class="card">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-xxl-12">
                  <div class="">
                    <div class="card-header border-0 align-items-center d-flex">
                      <h4 class="card-title mb-0 flex-grow-1">Free Game Play Station</h4>
                    </div>
                    <!-- end card header -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-2">
              <div class="row ">
                <?  
$columns = "select * ";
$sql = " from ngo_games where published='1'  "; // published='1'
///if (!$keyword=='') { $sql .= " and news_title like '%$keyword%'"; }
//$sql_count = "select count(*) ".$sql; 
$sql .= "order by rand() ";
$sql .= " limit 8 ";
 $sql = $columns.$sql;
$result = db_query($sql);
//$reccnt = db_scalar($sql_count);
?>
                <?
 		  
			$total_game=mysqli_num_rows($result);
			if ($total_game>0){
			//$ctr = $start;
			while ($line_game= mysqli_fetch_array($result)){;
			$ctr++;
		 
			 ?>
                <div class="col-md-3 col-sm-6 mb-5">
                  <div class="counter p-0 pb-15"> <a href="game-player.php?game_id=<?=encryptor('encrypt', $line_game['game_id']);?>"> <img width="100%" src="<?=$line_game['image'];?>"/>
                    <div class="counter-icon" title="Play Now"> <span><i class="ri-airplay-fill"></i></span> </div>
                    <h3>
                      <?=str_stop($line_game['game_name'], 25);?>
                    </h3>
                    </a> </div>
                </div>
                <? } } else {?>
                <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:98%; margin-left:auto; margin-right:auto;">
                  <tr class="maintxt">
                    <td colspan="7"  class="error"  >Games not found </td>
                  </tr>
                </table>
                <? } ?>
              </div>
            </div>
          </div>
        </div><?php */?>
         
        <!--end col-->
        <!--end col-->
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
