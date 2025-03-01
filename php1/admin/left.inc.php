<?
/*if ($_SESSION['sess_admin_super'] !='Super') { 
	session_start();
	session_destroy();
	header("Location: index.php");
	exit();
}*/
if ($_SESSION['sess_admin_type']=='main') {
?>

<div id="leftnav">
   <ul>
    <hr />
	<li><a href="admin_desktop.php">Static Report</a></li>
	<li><a href="users_list.php">Manage Users</a></li>
	<!--<li><a href="users_acc_summary_list.php">Users PL Summary</a></li>-->
	<li><a href="users_ewallet_drcr_list.php">Manage Wallet </a></li>
	
	<li><a href="packages_setting_list.php">Packages Setting</a></li>
	
	
	<li><a href="recharge_topup_list.php">Manage Package List</a></li>
	<!--<li><a href="users_ewallet_drcr_list.php?pay_group=CW">Manage Capital Wallet </a></li>
	<li><a href="users_acc_drcr_list.php">Manage Reward Wallet</a></li>
	<li><a href="recharge_topup_list.php">Fresh Business List</a></li>-->

	<!--<li><a href="users_bidding_draw.php">Running Game Summary</a></li> 
	<li><a href="users_bidding_list.php">All Game History</a></li>
	<li><a href="users_ewallet_bet_summary.php">Game PL Summary</a></li>-->
	<li><a href="users_acc_drcr_list.php">Manage Earnings</a></li>
	<li><a href="users_acc_withdrawal_list.php">Manage Withdraw List</a></li> 
	<!--<li><a href="users_acc_withdrawal_list_auto.php">Paid Redeem List</a></li-->  
 
	
	
<?php /*?><li><a href="users_coin_list.php">Manage Token </a></li><?php */?>
	
	
	<!--<li><a href="import_power_dummy_7port.php">4X4 Users Placement</a></li>
	<li><a href="users_4_direct_list.php">Member having 4 paid Referral </a></li> 
	<li><a href="club_01_achieved_member_list.php?menu=club&club=1">Club Achieved Member List</a></li>
	<li><a href="club_01_direct_achieved_member_list.php?menu=club&club=1">Referral Club Achiever List</a></li>-->
 	
	<?php /*?>sk final <li><a href="club_achieved_member_list.php">Club Achieved Member List</a></li> 
 	 
  	<?php */?>
	
 	
	<!--<li><a href="setting_f.php?sett_id=2">Withdrawal Open/Close</a></li> 
	<li><a href="gift_list.php">Manage Crowdfund List</a></li>-->
 	
	<!--<li><a href="users_ewallet_drcr_list.php?pay_group=SW">Shopping Wallet </a></li> 
	<li><a href="users_acc_summary_list.php">Income & Wallet Summary</a></li>
<li><a href="users_ewallet_drcr_list_coin.php">Manage Bunch Point </a></li> 

<li><a href="users_ewallet_re_generation_list.php">Manage Re-Generation Pool </a></li>-->

 <!--<li><a href="users_binance_history.php">Binance History</a></li>
    <li><a href="users_coinpayment_history.php">User Gateway History</a></li>
	<li><a href="deposit_request_list.php">  Deposit Request List </a></li>
	-->
	
<!--	
 	<li><a href="btc_payment_list.php">Bitcoin Payment Details </a></li>
	<li><a href="bizz91_deposit_webhook_list.php"> Webhook Request List </a></li>-->
	
<!--	
 	<li><a href="dynamic_users_update_list.php">User Counter</a></li>
	<li><a href="send_sms_all.php">Send SMS on User List</a></li>
	<li><a href="send_sms_other.php">SMS on Other Number</a></li>


	<li><a href="referral_list.php">Referal List</a></li>
 	<li><a href="gallery_list.php">Manage Photo Galary</a></li>
-->	

  	<li><a href="bounty_request_list.php">Bounty Request List</a></li>
	<li><a href="users_deposit_bin_history.php">BEP20 USDT Deposit List</a></li>
	<li><a href="news_list.php">Manage News</a></li>
	<li><a href="popup_list.php">Manage Popup</a></li>
	<li><a href="staticpage_list.php">Manage Static Pages</a></li>
	<li><a href="feedback_list.php"> Manage Feedback page</a></li>

 	<li><a href="complain_list.php">Complain List</a></li>
	<!--<li><a href="reward_referer.php"> Reward Achiever List</a></li>
	<li><a href="reward_redeem_list.php">Redeem Reward List</a></li>

	<li><a href="testimonial_list.php">Testimonial List </a></li>	-->
	<li><a href="contact_us_list.php">Contact Us List </a></li>
	<li><a href="setting_list.php">Manage Setting </a></li>
  	<li><a href="admin_list.php">Manage admin</a></li>
	<li><a href="change_pwd.php">Change Password</a></li>
	<li><a href="logout.php">Logout</a></li>

 	<!--
	
	<li><a href="users_coin_list.php">Manage Coin List</a></li>
	<li><a href="users_coin_summary_list.php">Manage Coin Summary</a></li>
		-->
	
  </ul>
</div>
<? }

else{
	$admin_login_id= $_SESSION['sess_admin_login_id'];
	$sql_admin_pms="select adm_permission from ngo_admin where adm_login='$admin_login_id'";
	$result_admin_pms=db_query($sql_admin_pms);
	if(mysqli_num_rows($result_admin_pms)>0){
	  $row_admin_pms=mysqli_fetch_array($result_admin_pms);
	   @extract($row_admin_pms);
	   if($adm_permission!=''){
			 $arr_total_permission=explode(",",$adm_permission);
			?>
<div id="leftnav">
  <ul>
    <?
 	foreach($arr_total_permission as $key){?>
    <li><a href="<?php echo $ARR_ADMIN_PAGES[$key];?>"><?php echo $ARR_ADMIN_LINK_PERMISSION[$key]; ?></a></li>
    <?php }
		 }
	  } 
   ?>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</div>
<?php }?>
