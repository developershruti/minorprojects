<?php
include ("includes/surya.dream.php");
  
 #	$data_day = db_scalar("select DATE_FORMAT(DATE_ADD( NOW() , INTERVAL 330 MINUTE ), '%a')  as date");
 	#if ($data_day!='Sat' && $data_day!='Sun') { }
	
  	$pay_plan='DAILY_WINING_PROFITS';
	$datefrom ='2024-01-01';
	//$dateto = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL  330 MINUTE), '%Y-%m-%d')");
  	$pay_date = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL 0 MINUTE), '%Y-%m-%d')"); //330
	$dateto =$pay_date;
	//$pay_date ='2023-01-19';
   	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where u_id=topup_userid  and u_status!='Banned' and topup_status='Paid' "; ///and topup_plan='TOPUP' 
  	//$topup_group =  db_scalar(" select DATE_FORMAT(ADDDATE('$pay_date',INTERVAL 0 MINUTE), '%a') as dated");
   	//if ($topup_group!='') { $sql_gen .= " and topup_group='$topup_group' ";} 
 	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 	{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
 	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";} 
	//$sql_gen .= "  limit 0,10  ";
 	 /// print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
  	if ($pay_date >= $topup_date) { 
	
				  $status = '';  /// set this null 
 
 				  $total_referer_active = db_scalar("select count(DISTINCT(topup_userid)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and u_ref_userid ='$u_id' ")+0;
				  $total_direct_business = db_scalar("select sum(topup_amount) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and u_ref_userid ='$u_id'  ")+0;
				  $total_team_level = downline_total_ids($u_id);
 				  $team_business_total = direct_total_business_date_range($u_id ,$sql_part, 3);
				  $team_business = $team_business_total - $total_direct_business;
				  
				  $team_member_total = (direct_total_team_date_range($u_id ,$sql_part, 3))- $total_referer_active;
				  
				  
 				  $my_rank_achieved = db_scalar("select u_rank from ngo_users where u_id ='$u_id' ")+0; 
				  
				  //'1'=>'Coral'  Start
				  if($my_rank_achieved==0){ 
				  $total_referer_active_required = 3; // 3 member 
				  $my_total_referer_active = db_scalar("select count(DISTINCT(topup_userid)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and u_ref_userid ='$u_id' ")+0;
 				  
				  $total_direct_business_required = 300; //300$ direct business
				  
				  $team_member_total_required = 10; // 10 on 2 & 3 level
				  $team_business_required = 700; // 700$ from 2 & 3 level 
				  
				  $instant_reward_amount = 100;  //$100 instant reward one time
				  $instant_reward_name = 'Coral Reward'; 
				  //'0'=>'N/A', '1'=>'Coral', '2'=>'Pearls', '3'=>'Diamond', '4'=>'Topaz', '5'=>'Sapphire', '6'=>'Emerald'
				  $current_u_rank = 1;   /// achieving currently
				  $current_u_rank_name = $ARR_RANK_REWARD_NAME[$current_u_rank]; 
 				  $weekly_incentive_amount = 30; // Weekly get $30 Every Friday... 
				   
 				  
				  ///'2'=>'Pearls' Start
				  } else if($my_rank_achieved==1){ 
				  
				  
				  $total_referer_active_required = 3; // 3 Coral direct required 
				  $my_total_referer_active = db_scalar("select count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_rank>=1 and u_status='Active' and u_ref_userid ='$u_id' ")+0;
 				  $team_business_required = 2500; // 2500$ from 2 & 3 level 
 				  $instant_reward_amount = 350;  //$350 instant reward one time
				  $instant_reward_name = 'Pearls Reward'; 
				  //'0'=>'N/A', '1'=>'Coral', '2'=>'Pearls', '3'=>'Diamond', '4'=>'Topaz', '5'=>'Sapphire', '6'=>'Emerald'
				  $current_u_rank = 2;  /// achieving currently
				  $current_u_rank_name = $ARR_RANK_REWARD_NAME[$current_u_rank]; 
 				  
				  $weekly_incentive_amount = 75; // Weekly get $75 Every Friday...  
				  
				  
				  
				  } else if($my_rank_achieved==2){  
				  
				  $total_referer_active_required = 3; // 3 Pearls direct required 
				  $my_total_referer_active = db_scalar("select count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_rank>=2 and u_status='Active' and u_ref_userid ='$u_id' ")+0;
 				  $team_business_required = 10000; // 10000$ from 2 & 3 level 
 				  $instant_reward_amount = 1000;  //$1000 instant reward one time
				  $instant_reward_name = 'Diamond Reward'; 
				  //'0'=>'N/A', '1'=>'Coral', '2'=>'Pearls', '3'=>'Diamond', '4'=>'Topaz', '5'=>'Sapphire', '6'=>'Emerald'
				  $current_u_rank = 3;  /// achieving currently
				  $current_u_rank_name = $ARR_RANK_REWARD_NAME[$current_u_rank]; 
 				  
				  $weekly_incentive_amount = 500; // Weekly get $500 Every Friday...  
				  
				  
				  
				  
				  
				  } else if($my_rank_achieved==3){  
				  
				  $total_referer_active_required = 3; // 3 Diamond direct required 
				  $my_total_referer_active = db_scalar("select count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_rank>=3 and u_status='Active' and u_ref_userid ='$u_id' ")+0;
 				  $team_business_required = 25000; // 25000$ from 2 & 3 level 
 				  $instant_reward_amount = 5000;  //$5000 instant reward one time
				  $instant_reward_name = 'Topaz Reward'; 
				  //'0'=>'N/A', '1'=>'Coral', '2'=>'Pearls', '3'=>'Diamond', '4'=>'Topaz', '5'=>'Sapphire', '6'=>'Emerald'
				  $current_u_rank = 4;  /// achieving currently
				  $current_u_rank_name = $ARR_RANK_REWARD_NAME[$current_u_rank]; 
 				  
				  $weekly_incentive_amount = 2500; // Weekly get $2500 Every Friday...  
				  
				  
				  
				  
				  
				  } else if($my_rank_achieved==4){  
				  
				  
				  $total_referer_active_required = 3; // 3 Topaz direct required 
				  $my_total_referer_active = db_scalar("select count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_rank>=4 and u_status='Active' and u_ref_userid ='$u_id' ")+0;
 				  $team_business_required = 75000; // 75000$ from 2 & 3 level 
 				  $instant_reward_amount = 15000;  //$5000 instant reward one time
				  $instant_reward_name = 'Sapphire Reward'; 
				  //'0'=>'N/A', '1'=>'Coral', '2'=>'Pearls', '3'=>'Diamond', '4'=>'Topaz', '5'=>'Sapphire', '6'=>'Emerald'
				  $current_u_rank = 5;  /// achieving currently
				  $current_u_rank_name = $ARR_RANK_REWARD_NAME[$current_u_rank]; 
 				  
				  $weekly_incentive_amount = 7500; // Weekly get $7500 Every Friday...  
				  
				  
				  } else if($my_rank_achieved==5){ 
				  
				  $total_referer_active_required = 3; // 3 Sapphire direct required 
				  $my_total_referer_active = db_scalar("select count(DISTINCT(u_id)) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_rank>=5 and u_status='Active' and u_ref_userid ='$u_id' ")+0;
 				  $team_business_required = 250000; // 250000$ from 2 & 3 level 
 				  $instant_reward_amount = 50000;  //$5000 instant reward one time
				  $instant_reward_name = 'Emerald Reward'; 
				  //'0'=>'N/A', '1'=>'Coral', '2'=>'Pearls', '3'=>'Diamond', '4'=>'Topaz', '5'=>'Sapphire', '6'=>'Emerald'
				  $current_u_rank = 6;  /// achieving currently
				  $current_u_rank_name = $ARR_RANK_REWARD_NAME[$current_u_rank]; 
 				  $weekly_incentive_amount = 25000; // Weekly get $25000 Every Friday...
 				  
				  }  
				  
				  
			
			///////////////// Now Check all Required Criteria & send instant reward bonus start 
			 
			  /// check condition for First Reward 
				  if($my_rank_achieved ==0){
				  	
					if($my_total_referer_active >= $total_referer_active_required  && $total_direct_business >= $total_direct_business_required && $team_member_total >= $team_member_total_required && $team_business >= $team_business_required){
					
					$status = 'Achieved'; 
					
					
					} else { 
					
					$status = 'Not'; 
					
					} 
				  
				  
				  
				  
				  ///// check condition of second & after that 
				  }  else  {
				  
				  
				  if($my_total_referer_active >= $total_referer_active_required && $team_business >= $team_business_required){
					
					$status = 'Achieved'; 
					
					
					} else { 
					
					$status = 'Not'; 
					
					} 
				  
				  
				  }  
				  
				  
			print "u_id => $u_id |---| Previous Reward Achieved : $ARR_RANK_REWARD_NAME[$my_rank_achieved] |---| Current Reward Achieved : $instant_reward_name |---| Status : Paid Already <br/>"; 	  
				  
				  /// if reward achieved then distribution start
 				if($status == 'Achieved'){
			$pay_plan = 'REWARDS';		
  			$paid_count = db_scalar("select count(pay_id) from ngo_users_payment  where pay_refid='$current_u_rank' and pay_plan_level='$current_u_rank' and pay_userid = '$u_id' and pay_plan='$pay_plan' ")+0; ///and pay_amount='$instant_reward_amount' 
  			
			
			
			
			if ($paid_count==0) {
				/// 
			$pay_for = $instant_reward_name;
			$pay_amount = $instant_reward_amount;
			
  			$sql_reward = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_id',  pay_refid='$current_u_rank'  ,pay_topupid='$topup_id' ,pay_plan_level='$current_u_rank',pay_plan='$pay_plan' ,pay_group='RI',pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_amount', pay_amount = '$pay_amount' ,pay_date='$pay_date', pay_status='Paid', pay_datetime =ADDDATE(now(),INTERVAL 0 MINUTE) ";
  		  	db_query($sql_reward);
		  	$pay_refid = mysqli_insert_id($GLOBALS['dbcon']); 
 				
				
			/// update rank in table for users
			db_query("update ngo_users set u_rank='$current_u_rank' where u_id = '$u_id' ");
			
			print "u_id => $u_id |---| Reward Achieved : $instant_reward_name |---| Status : Paid Now <br/><br/>"; 
 				
				
				} 
				
				
				
				}   
				  
			 
			 	  
				  
				  
				  
				  
				  
				  
				  
				  
				  
		     ///////////////// Now Check all Required Criteria & send instant reward bonus start 
	
	
	
	
	
	
	
		 
 	 	 
   }
  }   

 
    
print "Ok";

 
?>

<?=$msg?>