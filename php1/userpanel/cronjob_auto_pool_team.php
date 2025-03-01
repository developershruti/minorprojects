<?php
include ("includes/surya.dream.php");
  
 	#$data_day = db_scalar("select DATE_FORMAT(DATE_ADD( NOW() , INTERVAL 0 MINUTE ), '%a')  as date");
 	///if ($data_day!='Sat' && $data_day!='Sun') {  
	#$pay_plan='DAILY_RETURN';
	#$datefrom ='2018-01-01';
	#$dateto = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL  570 MINUTE), '%Y-%m-%d')");
	// $dateto ='2019-02-12';
	#$pay_date = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL 570 MINUTE), '%Y-%m-%d')");
 		$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status!='Block' and topup_status='Paid' and topup_amount='20'  ";
		//$sql_gen = "select  * from ngo_users where u_closeid>=3 ";
 	
	//$topup_group =  db_scalar(" select DATE_FORMAT(ADDDATE('$pay_date',INTERVAL 0 MINUTE), '%a') as dated");
   	//if ($topup_group!='') { $sql_gen .= " and topup_group='$topup_group' ";} 
	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 	{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
 	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";} 
	//$sql_gen .= " limit 1,200000";
	print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	
	 	$direct_count = db_scalar("select count(*) from ngo_users  where  u_ref_userid='$u_id' and u_id in (select topup_userid from ngo_users_recharge where topup_amount='20') ");

	print "<br> ==> ". $u_userid = $u_id;
	$level = 5;
	$ctr =0;
	$required=1;
	$str_count2=0;
	$str_count=0;
	$referid='';
	//////////////////////////////////////////////////////////////
 if ($u_userid!='' && $direct_count>=4) {
 	$id = array();
	$refid= array();
	$id[]=$u_userid;
	$required =1;
	//while ($sb!='stop'){
	 $referid=$u_userid; 
 	while ($ctr<$level){
	$ctr++;
	$required = $required*4;
	if ($referid!='') {
	$sql_test = "select *  from ngo_users  where  u_ref_userid in ($referid)  order by u_id asc ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
	if ($count>0) {
		$str_count = db_scalar("select count(*) from ngo_users where u_ref_userid in ($referid) and u_id in (select topup_userid from ngo_users_recharge where topup_amount='20')");
		$str_count2 = $str_count2+$str_count;
 			while ($line_test= mysqli_fetch_array($result_test)){  
					$refid[]=$line_test[u_id]; 
			 }
			$refid = array_unique($refid); 
			$referid = implode(",",$refid);
  		}
	}  
		
		print " <br> $u_userid ===> Level $ctr :  $str_count | Running : $str_count2 | required: $required    ";
 			if ($str_count2>=$required) { 
				//$status='Achieved';
				$pool = $ctr;
				if ($pool==1) 	   {$pool_amount=0.2;}
				else if ($pool==2) {$pool_amount=8;}
				else if ($pool==3) {$pool_amount=32;}
				else if ($pool==4) {$pool_amount=128;}
				else if ($pool==5) {$pool_amount=256;}
				else if ($pool==6) {$pool_amount=1024;}
				else if ($pool==7) {$pool_amount=4915;}
				else if ($pool==8) {$pool_amount=25214;}
				else if ($pool==9) {$pool_amount=1048576;}
 				//else if ($pool==10){$pool_amount=23619.6;}
				$today_count = db_scalar("select count(*) from ngo_users_payment where pay_userid ='$u_userid' and pay_refid ='$ctr' and pay_plan='POOL_INCOME1' ");
 				if ($today_count==0) {
  					$pay_for = "Autopool Blackpearl level $ctr Income"; 
				print "<br> ".	$sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_userid ='$u_userid' ,pay_refid ='$ctr', pay_plan_level='$ctr'  ,pay_plan='POOL_INCOME1' ,pay_group='WI'  ,pay_for = '$pay_for' ,pay_ref_amt='$pool_amount' ,pay_unit = '%' ,pay_rate = '$pool_amount', pay_amount = '$pool_amount' ,pay_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 570 MINUTE),pay_admin='INSTANT' ";
				 	db_query($sql2);
 					}
				
				
			
			}  
			 
			
 	 } 
  }
 
 
	 
	 
 	//////////////////////////////////////////////////////////////

 }
     


 
?>
<p style="color:#FF0000;">
<?=$msg?>
</p>