<?php
include ("includes/surya.dream.php");
  

$sql = "select sum(bid_0) as bid_0 ,sum(bid_1) as bid_1,sum(bid_2) as bid_2 ,sum(bid_3) as bid_3 ,sum(bid_4) as bid_4 ,sum(bid_5) as bid_5 ,sum(bid_6) as bid_6 ,sum(bid_7) as bid_7 ,sum(bid_8) as bid_8 ,sum(bid_9) as bid_9   from ngo_users_bid where bid_status='New'  ";
$result = db_query($sql);
$line_raw = mysqli_fetch_assoc($result);
//@extract($line_raw);
/*	print "<pre>";
print_r($line_raw);
print "</pre>";
*/	  
$min_value =  (min($line_raw));
$arr_bid_column=array();
foreach($line_raw as $key=>$value) { 
	if ($value <=$min_value) { 
	//$bid_column = $key; 
	$arr_bid_column[] = $key; 
	 // print "<br> = $key : $value "; 
	} 
}
 	/// get winning row  for draw
	//print_r($arr_bid_column);
	if(count($arr_bid_column)>0) {$number_count  = count($arr_bid_column)-1;} else { $number_count  = count($arr_bid_column);} 
	$number = rand(0,$number_count);
	$bid_column = $arr_bid_column[$number]; 

	
	
 // print " <br> bid Column : $bid_column";
  
  $sett_unit = db_scalar("select sett_unit from ngo_setting where sett_code ='WINNING_NUMBER' ");
 if($sett_unit!=''){
  //	print " <br> Manual Column : $sett_unit";
  	$bid_column = $sett_unit; 
 	db_query("update ngo_setting set sett_value = '0', sett_unit = NULL ,sett_lastupdate=ADDDATE(now(),INTERVAL 330 MINUTE)   where sett_code ='WINNING_NUMBER'");
  }
 
 
  
  
 			$winning_number = $ARR_BID_COLUMN[$bid_column];
 			$sql_gen = "select * from ngo_users_bid  where  bid_status='New' and $bid_column>0 ";
			$result_gen = db_query($sql_gen);
			$total_bid_count = mysqli_num_rows($result_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
			@extract($line_gen);
			$bid_number = $ARR_BID_COLUMN[$bid_column];
		//	$bid_gameno = $bid_desc;
			   print "<br> =  $draw_status : $bid_number : $bid_draw_no"; 
			 
			 $today_count = db_scalar("select count(pay_id) from ngo_users_ewallet where pay_plan='TRADE_REWARD' and pay_userid = '$bid_userid' and pay_refid='$bid_id'  ");
		// print  "<br> ==> $today_count  | $draw_status";
		// $draw_status=='Win' && 
  			if ($today_count==0) {
 				//db_query("update ngo_users_bid set bid_status='Win', bid_draw_date='$bid_draw_date',bid_draw_win_no='$bid_draw_no' where  bid_id = '$bid_id'");
				//if($winning_number==0 || $winning_number==5) { $pay_rate = 7.5; } else {$pay_rate = $bid_rate;}
 				$pay_rate = $bid_rate;
 				$bid_amount = $$bid_column;
 				$pay_amount = $bid_amount * $pay_rate;
 				if($pay_amount>0){
				 $msg.= $u_id.' ,';
 				 $pay_for ="Trade Reward on #$bid_gameno Win No $winning_number ";
 				 $sql = "insert into ngo_users_ewallet set pay_drcr='Cr', pay_userid = '$bid_userid',pay_refid = '$bid_id' ,pay_transaction_no='$bid_gameno' ,pay_plan='TRADE_REWARD',pay_group='CW' ,pay_for = '$pay_for' ,pay_ref_amt='$bid_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
				
 				db_query($sql);
				$pay_topupid = mysqli_insert_id($GLOBALS['dbcon']);
				
				/// Level distribution 
 				 ////////////////////////////////////////////
 				 // Direct Income level
 				//$topup_amount = 100;  
				/*
				if ($bid_rate==10000) {
					 
				$u_ref_userid = $bid_userid;
 				$pay_rate =.5;
				$pay_amount =  $bid_amount * 0.5;
					if($pay_amount>0){
					$ctr=0;
						while ($ctr<=5) { 
						$ctr++;
						$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
						if ($u_ref_userid!='' && $u_ref_userid!=0 ){
 							$pay_for ="Bid Level $ctr Bonus ";
							$sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$bid_userid' ,pay_topupid='$pay_topupid',pay_plan='LEVEL_INCOME' ,pay_group='$pay_group' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='SPOT' ";
							#db_query($sql2);
						 }
						} 
					}
			}	
			*/
 				}  
				/////////////////////////////////////////////
    		}  
 		 
   			}
			// Insert draw history 
			//if ($total_bid_count==0) { $bid_number = rand(0,36);} 
			$bid_datetime = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE) ");
 			//$Ymd = date("Ymd",strtotime($bid_datetime));
			
			if($bid_gameno=='') { 
				$bid_today_count = db_scalar("select  (count(*)+1) as total from ngo_users_bid_history where bid_date =DATE_FORMAT( ADDDATE(now(),INTERVAL 330 MINUTE) , '%Y-%m-%d') ");
				if($bid_today_count<=9) {$bid_no='00'.$bid_today_count;} 
				else if($bid_today_count>=10 && $bid_today_count<=99) {$bid_no='0'.$bid_today_count;}
				else if($bid_today_count>=100 ) {$bid_no= $bid_today_count;}
				$bid_gameno =  date("Ymd",strtotime($bid_datetime)).$bid_no; 
			}
					
			$bid_desc = "Trade Win Numner :$winning_number - Time: $bid_datetime ";
			$sql_history = "insert into ngo_users_bid_history set bid_gameno='$bid_gameno',  bid_draw_no = '$winning_number',bid_desc = '$bid_desc' ,bid_date =ADDDATE(now(),INTERVAL 330 MINUTE),bid_datetime =ADDDATE(now(),INTERVAL 330 MINUTE)";
			
			db_query($sql_history);
			
			/// update prediction table 
			 
  			$sql_pred = "select * from ngo_users_bid_prediction where bid_gameno = '$bid_gameno' and bid_status='Waiting'  ";
			$result_pred = db_query($sql_pred);
			$line_pred = mysqli_fetch_array($result_pred);
			
			if($line_pred['bid_color']=='Brass') {
				if($winning_number==1 || $winning_number==3 || $winning_number==5 || $winning_number==7 || $winning_number==9) { 
					#if($winning_number==5) { $prediction_amount= $line_pred['bid_amount']*1.5; } else {$prediction_amount= $line_pred['bid_amount']*2;}
					if($winning_number==5) { $prediction_amount= $line_pred['bid_amount']*0.5; } else {$prediction_amount= $line_pred['bid_amount']*1;}
					$bid_status ='Win';
				} else { 
					$prediction_amount= -$line_pred['bid_amount'];
					$bid_status ='Loss';
				} 
 			} else if($line_pred['bid_color']=='Gold') {
				if($winning_number==0 || $winning_number==2 || $winning_number==4 || $winning_number==6 || $winning_number==8) { 
					#if($winning_number==0) { $prediction_amount= $line_pred['bid_amount']*1.5; } else {$prediction_amount= $line_pred['bid_amount']*2;}
					if($winning_number==0) { $prediction_amount= $line_pred['bid_amount']*0.5; } else {$prediction_amount= $line_pred['bid_amount']*1;}
					$bid_status ='Win';
				} else { 
					$prediction_amount= -$line_pred['bid_amount'];
					$bid_status ='Loss';
				} 
			}
			
			
		  	$sql = "update ngo_users_bid_prediction set bid_status='$bid_status' , bid_amount2='$prediction_amount' where bid_gameno = '$bid_gameno' and bid_status='Waiting' ";
			$result = db_query($sql);
	 ////end prediction update
			
			
			/// delete bid hostory 24 hrs old 
			##$sql_update = "delete from ngo_users_bid_history where bid_datetime < ADDDATE(now(),INTERVAL -2880 MINUTE) ";
			//db_query($sql_update);
 			
			// delete biding transaction after draw
			//$sql_update = "delete from ngo_users_bid where bid_status='New' ";
			$sql_update = "update ngo_users_bid set bid_status='Win' ,bid_draw_win_no='$winning_number' where  bid_status='New' and $bid_column>0 ";
			db_query($sql_update);
			$sql_update = "update ngo_users_bid set bid_status='Loss' ,bid_draw_win_no='$winning_number' where  bid_status='New' ";
			db_query($sql_update);
			
				 
 		

 
?>