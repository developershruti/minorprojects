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
 	/* $min = 1.5;
	 $max = 2.5;
 	$randomFloat = getRandomFloat($min, $max);
	echo $randomFloat;
	echo "<br/>";
	print $topup_rate = round($randomFloat, 2);
	exit; */
  	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status!='Banned' and topup_status='Paid' "; ///and topup_plan='TOPUP' 
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
 	//$DAILY_PAYOUT_DAYS = db_scalar("select sett_value from ngo_setting where  sett_code ='DAILY_PAYOUT_DAYS'");
 	if ($pay_date >= $topup_date) { ///$pay_date >= $topup_date
		$payout_total = db_scalar("select count(*) from ngo_users_payment  where pay_userid = '$u_id' and  pay_topupid='$topup_id'  ")+0;
 		if ($payout_total >=$topup_days_for ) {
			//db_query("update ngo_users_recharge set topup_status='Close' where topup_userid = '$u_id' and  pay_topupid='$topup_id'  ");
		}
 	 	$today_count = db_scalar("select count(pay_id) from ngo_users_payment  where pay_topupid='$topup_id' and pay_date='$pay_date' and pay_userid = '$u_id' and pay_plan='$pay_plan' ");
  		if ($today_count<=3) { //$today_count==0 // Total 4 time winning aayega..
		
		
		/////////////
		
		if($topup_code=='AI BET 1 STANDARD'){ 
			$min = 2.50;
  		} else if($topup_code=='AI BET 1 PREMIUM'){ 
			$min = 3.10;
 		} else if($topup_code=='AI BET 2 STANDARD'){ 
			$min = 2.90;
		} else if($topup_code=='AI BET 2 PREMIUM'){ 
			$min = 3.50;
 		} else if($topup_code=='AI BET 3 STANDARD'){ 
			$min = 3.60;
		} else if($topup_code=='AI BET 3 PREMIUM'){ 
			$min = 4.40;
		} else if($topup_code=='AI BET 4 PREMIUM'){ 
			$min = 4.50;
		} else if($topup_code=='AI BET 4 EXCLUSIVE'){ 
			$min = 5.40;
		} else if($topup_code=='AI BET 5 PREMIUM'){ 
			$min = 5.50;
		} else if($topup_code=='AI BET 5 EXCLUSIVE'){ 
			$min = 6.60;
		} else if($topup_code=='AI BET 6 PREMIUM'){ 
			$min = 6.70;
		} else if($topup_code=='AI BET 6 EXCLUSIVE'){ 
			$min = 7.80;
		}

	// Example usage:
	//$min = 1.5;
	//$max = 2.5;
	$max = $topup_rate;
	$randomFloat = getRandomFloat($min, $max);
	//echo $randomFloat;
	$topup_rate_actual = round($randomFloat, 2);
	//$topup_rate = float($randomFloat, 2);
	 
	/////////////
		
		
		
		
		
			$actual_topup = $topup_amount/4;
    		$pay_amount = ($actual_topup/100) * $topup_rate_actual;
			$payable_amount = $pay_amount;
   			print  "<BR> $u_id ==| Topup : $topup_amount | Actual Topup : $actual_topup | Max Topup Rate : $topup_rate | Actual Random Rate : $topup_rate_actual | Amount  : $pay_amount  ";
  			if($pay_amount>0){
			$msg.= $u_id.' ,';
 			$pay_for = $topup_code." Daily Wining Profits From #$topup_serialno On Amount $".$actual_topup." Wins Rate $topup_rate_actual".'%';
			
			
			
			///Checking Self Capping Start =======  Check For Self's Working Capping // Working capping is 300% of topup amount
			$self_total_topup = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$u_id' ")+0;
			$self_total_capping = $self_total_topup * 3; //300% of topup amount 
			
  			//$total_self_earning_working = db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$u_id' and pay_group='WI' and pay_drcr='Cr' ")+0;
			// ROI, REFERAL ROI, Referral Income (LEVEL INCOME ON TOPUP) WILL BE CALCULATE IN CAPPING ///  (Note : WEEKLY_INCENTIVE & REWARDS CAPPING ME CALCULATE NAHI HOGA.. ISKA PAY GROUP RI DIYA HAI)
  			$total_self_earning_working = db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$u_id' and pay_group!='RI' and pay_drcr='Cr' ")+0;
			// check for available capping 
			if($self_total_capping>$total_self_earning_working){
			$self_available_capping = $self_total_capping - $total_self_earning_working;
			} else if($self_total_capping<=$total_self_earning_working){
			$self_available_capping = 0;
			//$pay_for2 ="Flush Out : Wining Referral Income From Level $ctr By #".$topup_serialno; 
			$pay_for = 'Flush Out : '.$topup_code." Daily Wining Profits From #$topup_serialno On Amount $".$actual_topup." Wins Rate $topup_rate_actual".'%';
			} 
			
			
			if($pay_amount>$self_available_capping){ 
			$pay_amount = $self_available_capping;
 			}
 			///Checking Self Capping End =======  Check For Self's Working Capping 
			
			
			
			$pay_plan_level = $today_count+1; /// for 1-4 time roi credit count
   		 	#$sql = "insert into ngo_users_payment2 set pay_drcr='Cr', pay_userid = '$u_id'  ,pay_topupid='$topup_id' ,pay_plan_level='$topup_group' ,pay_plan='$pay_plan' ,pay_group='ROI',pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$topup_rate', pay_amount = '$pay_amount' ,pay_date='$pay_date' ,pay_datetime =ADDDATE(now(),INTERVAL 690 MINUTE) ";
			$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_id'  ,pay_topupid='$topup_id' ,pay_plan_level='$pay_plan_level',pay_plan='$pay_plan' ,pay_group='ROI',pay_for = '$pay_for' ,pay_ref_amt='$actual_topup' ,pay_unit = '%' ,pay_rate = '$topup_rate_actual', pay_amount = '$pay_amount' ,pay_date='$pay_date', pay_status='Paid', pay_datetime =ADDDATE(now(),INTERVAL 0 MINUTE) ";
  		  	db_query($sql);
		  	$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
			/*$total_roi_earned = db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid='$u_id' and pay_topupid='$topup_id' and pay_drcr='Cr' and pay_plan='$pay_plan' ");
 			$total_roi_limit = $topup_amount * 2; // earn max 200%*/
			
			$total_roi_rate_earned = db_scalar("select sum(pay_rate) from ngo_users_payment where pay_userid='$u_id' and pay_topupid='$topup_id' and pay_drcr='Cr' and pay_plan='$pay_plan' ");
  			//$total_roi_rate_limit = 200; // earn max 200%
			//$total_roi_rate_limit = 200; // earn max 200%
			$total_roi_rate_limit = 800; // earn max 800% (Daily approx 2% x 4 time so total 800%;)
 			
			
			if($total_roi_rate_earned>=$total_roi_rate_limit){ //$total_roi_earned>=$total_roi_limit
 				db_query("update ngo_users_recharge set topup_status='Close' where topup_id = '$topup_id' and topup_userid='$u_id'  ");
 			} 
			
///////////////Level Income / Referral Income Instant on topup start ////////////////////////////// 
 		$u_ref_userid = $u_id;//$u_ref_userid = $_SESSION['sess_uid'];
		$ctr=0;
		while ($ctr<3) { 
		$ctr++;
		$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
		//$referral_verify_email_status = db_scalar("select u_verify_email_status from ngo_users where u_id='$u_ref_userid' ");
		$sponsor_topup_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid='$u_ref_userid' ")+0;
		if ($u_ref_userid!='' && $u_ref_userid!=0 && $sponsor_topup_count>=1){
			if($ctr==1)		{ $pay_rate2 =15; } //  
			else if($ctr==2){ $pay_rate2 =10;} //  
			else if($ctr==3){ $pay_rate2 =5;} ////  
			$pay_plan2 ='WINING_REFERRAL_BONUS';
			//$pay_amount2 = ($pay_amount/100)*$pay_rate2;
			$pay_amount2 = ($payable_amount/100)*$pay_rate2;
			$pay_ref_amt = $pay_amount2;
			$pay_for2 ="Wining Referral Income From Level $ctr By #".$topup_serialno; 
			///Checking Capping Start =======  Check For Sponsor's Working Capping // Working capping is 300% of topup amount
			$sponsor_total_topup = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$u_ref_userid' ")+0;
			$sponsor_total_capping = $sponsor_total_topup * 3; //300% of topup amount 
			
  			//$total_earning_working = db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$u_ref_userid' and pay_group='WI' and pay_drcr='Cr' ")+0;
			// ROI, REFERAL ROI, Referral Income (LEVEL INCOME ON TOPUP) WILL BE CALCULATE IN CAPPING ///  (Note : WEEKLY_INCENTIVE & REWARDS CAPPING ME CALCULATE NAHI HOGA.. ISKA PAY GROUP RI DIYA HAI)
  			$total_earning_working = db_scalar("SELECT SUM(pay_amount) FROM ngo_users_payment where pay_userid='$u_ref_userid' and pay_group!='RI' and pay_drcr='Cr' ")+0;
			// check for available capping 
			if($sponsor_total_capping>$total_earning_working){
			$sponsor_available_capping = $sponsor_total_capping - $total_earning_working;
			} else if($sponsor_total_capping<=$total_earning_working){
			$sponsor_available_capping = 0;
			$pay_for2 ="Flush Out : Wining Referral Income From Level $ctr By #".$topup_serialno; 
			} 
			if($pay_amount2>$sponsor_available_capping){ 
			$pay_amount2 = $sponsor_available_capping;
 			}
 			///Checking Capping End =======  Check For Sponsor's Working Capping  
  			$sql2 = "insert into ngo_users_payment set pay_drcr='Cr' ,pay_userid ='".$u_ref_userid."' ,pay_refid ='".$pay_refid."', pay_topupid ='".$topup_id."', pay_group='WI', pay_plan='$pay_plan2' ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$pay_rate2', pay_amount = '$pay_amount2'  , pay_status = 'Paid', pay_date=ADDDATE(now(),INTERVAL 0 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='Instant' ";
			db_query($sql2);			  
		} 
	}
 	///////////////Level Income / Referral Income Instant on topup end ////////////////////////////// 
			
			
			
  	 }
    }
   }
  }   

 
    
print "Ok";

 
?>

<?=$msg?>