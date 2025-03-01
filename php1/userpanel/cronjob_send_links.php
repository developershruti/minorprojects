<?php
include ("includes/surya.dream.php");
  
//echo "$today_date - Email sent successfully ";
  	$pay_date = db_scalar("select ADDDATE(now(),INTERVAL 630 MINUTE)");
 	///$dateto = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL 630 MINUTE), '%Y-%m-%d')");
   	$sql_gen = "select  * from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status!='Banned' and topup_status='Unpaid'";
 	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
	 //print $sql_gen;
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
			@extract($line_gen);
		 
 						$link_total_sent =db_scalar("select sum(gift_amount) from ngo_users_gift  where gift_topupid = '$line_gen[topup_id]'");
						if($link_total_sent<100) { 
						 $u_parent_id = db_scalar("select gift_id from ngo_users_gift  order by gift_id desc limit 0,1")+1;
						 $gift_id_refno =  'im'.rand(100,999).$u_parent_id.rand(100,999);
 						 $gift_amount 	=50;
						 $company_id  =  rand(1,3);
						/* $gift_refno =  db_scalar("select pay_id from ngo_users_payment where pay_userid='$company_id' and pay_status='Unpaid' ");
						 $payment_count =db_scalar("select count(*) from ngo_users_gift  where gift_group='COMPANY' and gift_userid in (2,3,4,5,6,7,8) and gift_topupid = '$line_gen[topup_id]'");
						 if($gift_refno!='' && $payment_count==0){ 
						 $sql_insert="insert into ngo_users_gift set gift_userid = '$company_id',gift_id_refno = '$gift_id_refno' ,gift_by_userid='$line_gen[topup_userid]' ,gift_topupid='$line_gen[topup_id]',gift_group='COMPANY',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 2880 MINUTE),gift_datetime=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_status='New'";
						 db_query($sql_insert);
						 }
						 
						$u_ref_userid  =  db_scalar("select u_ref_userid from ngo_users where u_id='$line_gen[topup_userid]' and u_status='Active'");
						if($u_ref_userid=='') { $u_ref_userid = $company_id;}
						$gift_amount 	=10;
						$gift_refno =  db_scalar("select pay_id from ngo_users_payment where pay_userid='$u_ref_userid' and pay_status='Unpaid' ");
					
 						/// send link to spornsor
						 $payment_count =db_scalar("select count(*) from ngo_users_gift  where gift_group='DIRECT' and  gift_userid='$u_ref_userid' and gift_topupid = '$line_gen[topup_id]'");
						 if($gift_refno!='' && $payment_count==0){ 
						$sql_insert="insert into ngo_users_gift set gift_userid = '$u_ref_userid',gift_id_refno = '$gift_id_refno' ,gift_by_userid='$line_gen[topup_userid]' ,gift_topupid='$line_gen[topup_id]',gift_group='DIRECT',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 2880 MINUTE),gift_datetime=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_status='New'";
						 db_query($sql_insert);
						 }*/
						//$gift_amount2 = $gift_amount-$gift_amount1;
						// send link to receiver	
						$gift_amount 	=50;
						$u_sponsor_id  =  db_scalar("select u_sponsor_id from ngo_users where u_id='$line_gen[topup_userid]' and u_status='Active'");
						//if($u_sponsor_id=='') { $u_sponsor_id = $company_id;}
						$gift_refno =  db_scalar("select pay_id from ngo_users_payment where pay_userid='$u_sponsor_id' and pay_status='Unpaid' ");
						 $payment_count =db_scalar("select count(*) from ngo_users_gift  where gift_group='SPONSOR' and gift_userid='$u_sponsor_id' and gift_topupid = '$line_gen[topup_id]'");
						 if($gift_refno!='' && $payment_count==0){ 
						$sql_insert="insert into ngo_users_gift set gift_userid = '$u_sponsor_id',gift_id_refno = '$gift_id_refno' ,gift_by_userid='$line_gen[topup_userid]' ,gift_topupid='$line_gen[topup_id]',gift_group='SPONSOR',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 2880 MINUTE),gift_datetime=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_status='New'";
						 db_query($sql_insert);
						 }
						
						 $gift_amount 	=50;
						 $upline_sponsor_id  =  db_scalar("select u_sponsor_id from ngo_users where u_id='$u_sponsor_id' and u_status='Active'");
						 if($upline_sponsor_id=='') { $upline_sponsor_id = $company_id;}
						 $gift_refno =  db_scalar("select pay_id from ngo_users_payment where pay_userid='$upline_sponsor_id' and pay_status='Unpaid' ");
						 $payment_count =db_scalar("select count(*) from ngo_users_gift  where gift_group='SPONSOR2' and gift_userid='$upline_sponsor_id' and gift_topupid = '$line_gen[topup_id]'");
						 if($gift_refno!='' && $payment_count==0){ 
						 $sql_insert="insert into ngo_users_gift set gift_userid = '$upline_sponsor_id',gift_id_refno = '$gift_id_refno' ,gift_by_userid='$line_gen[topup_userid]' ,gift_topupid='$line_gen[topup_id]',gift_group='SPONSOR2',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 2880 MINUTE),gift_datetime=ADDDATE(now(),INTERVAL 570 MINUTE) ,gift_status='New'";
						 db_query($sql_insert);
						 }
						 
						 
						 
						} 
						
						
/*		// send help confirmation msg sms to user 
		$to_fname = db_scalar("select CONCAT(u_fname,'/',u_username,'/',u_mobile ) from ngo_users  where  u_id='$gift_userid' ") ;
		$to_mobile =  db_scalar("select u_mobile from ngo_users  where  u_id='$gift_userid' ") ;
		//  send sms to provider help mobile
		$from_mobile = $line_gen[u_mobile] ;
		//"Dear Sender name & user name, please GIVE HELP of Rs 5000 to Mr, Receiver Name/ User name /mobile no with in 120 hrs. Thanks My Helping World"
		$from_message = "Dear $line_gen[u_fname] ($line_gen[u_username]), please GIVE HELP of Rs $gift_amount to $to_fname with in 48 hrs. Thanks " .SITE_URL ;
		send_sms($from_mobile,$from_message);
		//  send sms to get help mobile
		
		// "Dear Reciever name & user name, please GET HELP of Rs 5000 from Sender Name/ User name /mobile no with in 120 hrs. Thanks My Helping World"
		$to_message = "Dear $to_fname, please GET HELP of Rs $gift_amount from Sender $line_gen[u_fname]/$line_gen[u_username]/$line_gen[u_mobile] with in 48 hrs. Thanks " .SITE_URL ;
		send_sms($to_mobile,$to_message);
*/						
						
						
						
	 // send Provide Help email 
	$to_email =  $line_gen[u_email] ; 		 
	$to_message="
	Dear ". $line_gen[u_fname]  .", 
	
	Help  Details
	
	You have a request to send a help amount $gift_amount to  ($to_fname) within 48 hrs 
	 
	http://". SITE_URL ." 
	Help Amount = ". $gift_amount ."
	Receiver Name = ".$to_fname. "
 	 
	Thank you !
	
	". SITE_NAME ."
	http://". SITE_URL ."
	";
	$HEADERS  = "MIME-Version: 1.0 \n";
	$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
	$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
	$SUBJECT  = SITE_NAME." Support Help Details ";
	 if ($to_email!='') {  @mail($to_email, $SUBJECT, $to_message,$HEADERS); }
	$_SESSION[POST]='';
	//
	
	// send Get Help email 
	$from_email =  db_scalar("select u_email from ngo_users where u_id='$gift_userid' limit 0,1");		 
	$from_message="
	Dear ". $to_fname.", 
	
	Get Help 
	
	You have received an offer to receive Support amount $gift_amount from  ($line_gen[u_fname]) within 48 hrs 
	 
	http://". SITE_URL ." 
	Help Amount = ". $gift_amount ."
	Sender Name = ".$line_gen[u_fname]. "
 	 
	Thank you !
	
	". SITE_NAME ."
	http://". SITE_URL ."
	";
	$HEADERS  = "MIME-Version: 1.0 \n";
	$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
	$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
	$SUBJECT  = SITE_NAME." Support Help Details ";
	 if ($from_email!='') {  @mail($from_email, $SUBJECT, $from_message,$HEADERS); }
	$_SESSION[POST]='';
	//
					
	
					
		 
	}
	//-------------------------
   
   
   
   
  
  
/*$today_date = db_scalar("select ADDDATE(now(),INTERVAL 630 MINUTE) ");
$message = " Referral Bonus Cron job file calle..neelimagroup.com... Time : $today_date " ;
$u_email = "shashikant157@@gmail.com";
$HEADERS  = "MIME-Version: 1.0 \n";
$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
$SUBJECT  = SITE_NAME." Referral Bonus Cron Job neelimagroup.com  File Called ";
@mail($u_email, $SUBJECT, $message,$HEADERS);   */


 
?>