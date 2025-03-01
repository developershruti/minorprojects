<?php
include ("includes/surya.dream.php");
  
 	#$data_day = db_scalar("select DATE_FORMAT(DATE_ADD( NOW() , INTERVAL 0 MINUTE ), '%a')  as date");
 	///if ($data_day!='Sat' && $data_day!='Sun') {  
	#$pay_plan='DAILY_RETURN';
	#$datefrom ='2018-01-01';
	#$dateto = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL  570 MINUTE), '%Y-%m-%d')");
	// $dateto ='2019-02-12';
	#$pay_date = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL 570 MINUTE), '%Y-%m-%d')");
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status!='Block' and topup_status='Paid' and topup_amount>=50 ";
		//$sql_gen = "select  * from ngo_users where u_closeid>=3 ";
 	
	//$topup_group =  db_scalar(" select DATE_FORMAT(ADDDATE('$pay_date',INTERVAL 0 MINUTE), '%a') as dated");
   	//if ($topup_group!='') { $sql_gen .= " and topup_group='$topup_group' ";} 
	
 	//if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";} 
	$sql_gen .= " limit 1,200000";

	print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	

  	////////////////////////////////////////////
	  $u_ref_userid_first = $u_ref_userid ;//db_scalar("select u_ref_userid from ngo_users where u_id='$topup_userid' ");
	  //$u_ref_userid = $topup_userid;
	  $total_investment = $topup_amount;

	  $total_pay_count= db_scalar("select  count(*) from ngo_users_payment  where pay_plan='FASTTRACK_INCOME' and pay_userid ='$u_ref_userid_first' and pay_topupid='$topup_id' ")+0;

	  //print " <br> ===>  Referal ID : $u_ref_userid_first | Topup Ref Id : $topup_userid | Paid Count : $total_pay_count";
	  if ($total_pay_count==0){
		  $ctr=0;
		  $ctr2=0;
		  $pay_rate = 0;

	if($total_investment==50){ 
			//2nd level super upline ko 50% jayega
			$ctr2=2;
	} else if($total_investment==100) { 
			//3rd  level super upline ko 50% jayega
			$ctr2=3;
	} else if($total_investment==500) { 
			//4th  level super upline ko 50% jayega
			$ctr2=4;
	} else if($total_investment==1000) { 
			//5th  level super upline ko 50% jayega
			$ctr2=5;
	} else if($total_investment==2500) { 
			//6th  level super upline ko 50% jayega
			$ctr2=6;
	} else if($total_investment==5000) { 
			//7th  level super upline ko 50% jayega
			$ctr2=7;
	} else if($total_investment==10000) { 
			//8th  level super upline ko 50% jayega
			$ctr2=8;
	} else if($total_investment==20000) { 
			//9th  level super upline ko 50% jayega
			$ctr2=9;
  } else if($total_investment==40000) { 
			//10th  level super upline ko 50% jayega
			///if ($ctr==9) {$pay_rate = 25;} else {$pay_rate = 0; } 
			$ctr2=10;
  }

  //print "<br> 1= $u_ref_userid_first | 2= $u_ref_userid' | Level = $ctr | Topup = $topup_amount ";
  $pay_rate = 25;
  $pay_amount = ($total_investment/100)* $pay_rate;
  if($pay_amount>0){

  $total_pay_count1= db_scalar("select  count(*) from ngo_users_payment  where pay_plan='FASTTRACK_INCOME' and pay_userid ='$u_ref_userid_first' and pay_topupid='$topup_id' ")+0;
  $total_topup_first= db_scalar("select  max(topup_amount)  from ngo_users_recharge  where topup_userid ='$u_ref_userid_first'  ")+0;
  if ($total_topup_first >=$total_investment && $total_pay_count1==0){
		  $pay_for ="Fasttrack Upgrade 1 Income  from - $u_username";
		  print "<br> === Direct=". $sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_group='FASTTRACK_INCOME',pay_userid ='$u_ref_userid_first' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id' ,pay_plan='FASTTRACK_INCOME' ,pay_plan_level='1'  ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 630 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE),pay_admin='CRON' ";
   db_query($sql2);
  }

  
  while ($ctr<$ctr2) { 
			  $ctr++;
			// get second sponsor id accooding to plan
			print "<br>sponsor =". $u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid'  ");

  }
  print "<br> 2======= $u_ref_userid_first | 2======== $u_ref_userid' | Level = $ctr : $ctr2| Topup = $topup_amount | Topup_id =$topup_id ";
		$total_pay_count2= db_scalar("select  count(*) from ngo_users_payment  where pay_plan='FASTTRACK_INCOME' and pay_userid ='$u_ref_userid' and pay_topupid='$topup_id' ")+0;
		$total_topup_sponsor= db_scalar("select  max(topup_amount)  from ngo_users_recharge  where topup_userid ='$u_ref_userid'  ")+0;
		if ($total_topup_sponsor >=$total_investment && $total_pay_count2==0){
		 if ($ctr>=2) {
		 $pay_for3 ="Fasttrack Upgrade  $ctr Income  from - $u_username";
		print "<br> === Level 2=".  $sql3 = "insert into ngo_users_payment set pay_drcr='Cr',pay_group='FASTTRACK_INCOME',pay_userid ='$u_ref_userid' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id' ,pay_plan='FASTTRACK_INCOME' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for3' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 630 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE),pay_admin='CRON' ";
		 db_query($sql3);
		  } 
		
			}
			///}///direct condition
		  } 
	  }   
  ///////////////////////////////////////////// 




}
     


 
?>
<p style="color:#FF0000;">
<?=$msg?>
</p>