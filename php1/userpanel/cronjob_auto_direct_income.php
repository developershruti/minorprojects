<?php
include ("includes/surya.dream.php");
  
 	#$data_day = db_scalar("select DATE_FORMAT(DATE_ADD( NOW() , INTERVAL 0 MINUTE ), '%a')  as date");
 	///if ($data_day!='Sat' && $data_day!='Sun') {  
	#$pay_plan='DAILY_RETURN';
	#$datefrom ='2018-01-01';
	#$dateto = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL  570 MINUTE), '%Y-%m-%d')");
	// $dateto ='2019-02-12';
	#$pay_date = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL 570 MINUTE), '%Y-%m-%d')");
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status!='Block' and topup_status='Paid' and topup_amount=30 and topup_id>24867";
		//$sql_gen = "select  * from ngo_users where u_closeid>=3 ";
 	
	//$topup_group =  db_scalar(" select DATE_FORMAT(ADDDATE('$pay_date',INTERVAL 0 MINUTE), '%a') as dated");
   	//if ($topup_group!='') { $sql_gen .= " and topup_group='$topup_group' ";} 
	
 	//if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";} 
	$sql_gen .= " limit 1,2000000000";

	print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	

  	////////////////////////////////////////////
	  $u_ref_userid_first = $u_ref_userid ;//db_scalar("select u_ref_userid from ngo_users where u_id='$topup_userid' ");
	  //$u_ref_userid = $topup_userid;
	  $total_investment = $topup_amount;
	  $total_pay_count= db_scalar("select  count(*) from ngo_users_payment  where pay_plan='DIRECT_INCOME' and pay_userid ='$u_ref_userid' and pay_topupid='$topup_id' ")+0;


	 
	  if ( $total_pay_count ==0){
////////////////////////////////////////////
 print "<br> $u_username | $topup_id | $u_ref_userid | $total_pay_count";
$u_ref_userid =$topup_userid;

$ctr=0;

while ($ctr<10) { 
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
	#else if ($ctr>=11 && $ctr<=20) {$pay_rate = 0.10;  $pay_group='LEVEL_INCOME'; $pay_plan='LEVEL_INCOME'; } ///pay_rate is not % it $ value that will be distributed		
	#else if ($ctr>=21 && $ctr<=50) {$pay_rate = 0.05;  $pay_group='LEVEL_INCOME'; $pay_plan='LEVEL_INCOME'; } ///pay_rate is not % it $ value that will be distributed
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
	print "<br> $u_username ==>".$sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_group='$pay_group',pay_userid ='$u_ref_userid' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE),pay_admin='SPOT' ";
	db_query($sql2);
	//$arr_error_msgs[] =  "Your investment completed successfully!";
	}
 ///}
} 
} 

/////////////////////////////////
}
     
	}

 
?>
<p style="color:#FF0000;">
<?=$msg?>
</p>