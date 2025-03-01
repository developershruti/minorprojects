<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 #print_r($_POST);
  
if ($u_userid!='') {
	$id = array();
	$id[]=$u_userid;
	while ($sb!='stop'){
	if ($referid=='') {$referid=$u_userid;}
	$sql_test = "select u_id  from ngo_users  where  u_sponsor_id in ($referid)  ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$id_in = implode(",",$id);
	if ($id_in!='') {
 		$u_id = db_scalar("select u_id from ngo_users where u_id in ($id_in) ");
		if ($u_id=='') { $msg = "Invalid User ID ";}
 	}
 
}
 
  

 if($pay_plan=='DIRECT') {
   	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid   and u_ref_userid!=0  and u_status!='Banned' and topup_status='Paid'  ";
  	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 	{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
	# print $sql_gen;
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
			@extract($line_gen);
			if ($u_ref_userid!='' && $u_ref_userid!=0){
				$payout_count1 = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_ref_userid'  and pay_refid = '$u_id' and pay_plan='$pay_plan' and pay_topupid='$topup_id'  ");
			if ($payout_count1==0) {
				$msg.= $u_id.' ,';
				//$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='$pay_plan' limit 0,1");
				//$pay_amount = $pay_rate-(($pay_rate/100)*5);
				 
				if ($topup_plan=='TOPUP') { $pay_rate = 8; } else { $pay_rate = 8;}
				$pay_amount = ($topup_amount/100)* $pay_rate;
				if($pay_amount>0){
 			 	$pay_for ="Direct Income - $u_username";
				$sql = "insert into ngo_users_payment set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$u_id' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_group='WORKING' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date='$pay_date' ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
				#db_query($sql);
				
		 
				}
			 }		
		}
	}
	//-------------------------
   
  }  elseif ($pay_plan=='DAILY_RETURN') {
 // last transaction no : 37733
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status='Active' and topup_status='Paid' ";
  	
	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
 	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
	  # print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	//$DAILY_PAYOUT_DAYS = db_scalar("select sett_value from ngo_setting where  sett_code ='DAILY_PAYOUT_DAYS'");
 	if ($pay_date > $topup_date) {
		$payout_count = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_id'  and pay_topupid='$topup_id' and pay_plan='$pay_plan' ");
		
		if ($payout_count >=$topup_days_for ) {
			db_query("update ngo_users_recharge set topup_status='Close' where  topup_id = '$topup_id'  ");
		}
		 
		
		//$topup_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid='$u_id' and topup_status='Paid'  and topup_id < '$topup_id'");
		// && $topup_count==0
	if ($topup_days_for > $payout_count) {
		
		
		$today_count = db_scalar("select count(pay_id) from ngo_users_payment where pay_topupid='$topup_id'  and  pay_date='$pay_date' and pay_userid = '$u_id' and pay_plan='$pay_plan' ");
		 
		 
		// "<br>  $payout_count  =$topup_days_for   : $today_count  ";
		
		if ($today_count==0) {
 			$pay_amount = ($topup_amount/100)*$topup_rate;
 			# print "<br>ID= $u_id  ,today Count= $today_count1  ,days= $days  ,payamt= $pay_amount";
			
			if($pay_amount>0){
			$msg.= $u_id.' ,';
			$pay_amount1 =  ($pay_amount/100)*100;
			$pay_for ="Daily Return";
		 	$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_group='ROI',pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$topup_rate', pay_amount = '$pay_amount1' ,pay_date='$pay_date' ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
			 
		 	db_query($sql);
			
			/*$pay_amount2 =  ($pay_amount/100)*25;
			$pay_for ="Daily Return";
		 	$sql = "insert into ngo_users_ewallet set pay_drcr='Cr', pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan',pay_group='GAME' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$topup_rate', pay_amount = '$pay_amount2' ,pay_date='$pay_date' ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
			 
		 	//db_query($sql);*/
			
			
 
 			}
 		}		
	}
	
	}
	
	}
	//-------------------------
 
  

  } elseif ($pay_plan=='MATCHING') {
 	 
	$MINIMUM_REFERER=2;
	$MINIMUM_TOPUP=2500;
	$MATCHING_MINIMUM=2500;
	$MATCHING_CAPING=35000;
 	 
	 $sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status='Active' and topup_status!='Unpaid' and topup_plan='TOPUP' ";
 	//$sql_gen = "select u_username,u_id,u_ref_userid from ngo_users where   u_status='Active' ";
  	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
 	//if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
  // print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
	 
	if ($datefrom!='' && $dateto!='') 	{  $sql_part  .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
 	// check minimum 2 referer and u_status='Active' 
 	
	$total_referer= db_scalar("select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid    and u_ref_userid ='$u_id' ")+0;
  			
	  // "<br> <br> select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid    and u_status='Active'  and u_ref_userid ='$u_id' ";
 			#print "<br> OK.... $total_referer  = $MINIMUM_REFERER ..............";	
	if ($total_referer >=$MINIMUM_REFERER) {
	
		  $total_topup= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_status!='Unpaid' and  topup_userid ='$u_id'  ")+0;
		  $total_topup_a= db_scalar("select sum(topup_amount) from ngo_users_recharge  where  topup_status!='Unpaid' and topup_userid  in (select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='A') ")+0;
		  $total_topup_b= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_status!='Unpaid' and  topup_userid  in (select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='B') ")+0;
		// 
   		// 	 print "<br> OK.... $total_topup  = $MINIMUM_TOPUP ..............";
		
		if ($total_topup>=$MINIMUM_TOPUP && $total_topup_a>=$MINIMUM_TOPUP && $total_topup_b>=$MINIMUM_TOPUP) {
  			
 		$u_id_a = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$u_id' and u_ref_side='A' limit 0,1");
		$u_id_b = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$u_id' and u_ref_side='B' limit 0,1");
   		$pair_a = binary_total_paid_close($u_id_a )+0;
 		$pair_b = binary_total_paid_close($u_id_b)+0;
 		$total_pair_paid=db_scalar("select sum(pay_ref_amt) from ngo_users_payment where pay_userid ='$u_id' and  pay_plan='$pay_plan' ")+0;
		//     print " <br> ======= $u_username =$u_id= $pair_a = $pair_b = $total_pair_paid "; 
		$total_pair_a = $pair_a-$total_pair_paid;
		$total_pair_b = $pair_b-$total_pair_paid;
 		// calculat valid paire for payment
    // print "<br>= $total_pair_a  = $total_pair_b   = $MATCHING_MINIMUM"; 
		
		if ($total_pair_a!='' && $total_pair_b !='' && $total_pair_a>=$MATCHING_MINIMUM && $total_pair_b>=$MATCHING_MINIMUM) {
  
		if ($total_pair_a>$total_pair_b) 		{ $total_pair_wicker = $total_pair_b;}
		elseif ($total_pair_b>$total_pair_a) 	{ $total_pair_wicker = $total_pair_a;}
		elseif ($total_pair_a=$total_pair_b)	{ $total_pair_wicker = $total_pair_a;}
		
		// check mimimum maching 
 		  # print " <br> ======= $u_username =   = $pair_a = $pair_b = $total_pair_wicker ";  
 			//$MATCHING_CAPING = db_scalar("select sett_value from ngo_setting where  sett_code ='MATCHING_CAPING' limit 0,1");
  			
 			if ($total_pair_wicker>0) {
			//$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='$pay_plan' limit 0,1");
   			$pay_rate = 8; 
			$pay_amount = ($total_pair_wicker/100) * $pay_rate ;
  			
			if($pay_amount>0){
			$msg.= $u_id.' ,';
 				$today_paid_amount= db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid ='$u_id' and pay_plan='MATCHING' and pay_date='$pay_date'");
					
					 if ($total_topup>=100000) { $MATCHING_CAPING =  50000 - $today_paid_amount; } 
					 else { $MATCHING_CAPING =  25000 - $today_paid_amount;}
					//if ($MATCHING_CAPING>100000) { $MATCHING_CAPING =100000;} 
		
					//$MATCHING_CAPING =($topup_amount+$total_updated_caping)-$today_paid_amount; 
 					//if ($today_paid_amount > $MATCHING_CAPING) { $pay_amount =$MATCHING_CAPING -$today_paid_amount ; } 
					
					if ($pay_amount > $MATCHING_CAPING) { $pay_amount =$MATCHING_CAPING; } 
					//$msg.= $u_id.' ,';
 					//$msg.= $u_username.'['.$pay_amount.'] ,';
					$pay_amount1 =  ($pay_amount/100)*100;
					$pay_for ="Binary Income for matching  ".$total_pair_wicker;
					$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_group='WORKING' ,pay_for = '$pay_for' ,pay_ref_amt='$total_pair_wicker' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount1' ,pay_date='$pay_date' ,pay_datetime =ADDDATE(now(),INTERVAL 270 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
					db_query($sql);
					
 					/*$pay_amount2 =  ($pay_amount/100)*25;
					$pay_for ="Binary Income for matching ".$total_pair_wicker;
					$sql = "insert into ngo_users_ewallet set pay_drcr='Cr', pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_group='GAME' ,pay_for = '$pay_for' ,pay_ref_amt='$total_pair_wicker' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount2' ,pay_date='$pay_date' ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
					 
					//db_query($sql);*/
			
 		}
 		}		
	  }
	  
	  }
	  }
	} 
 //----------------------------
 
  
 
 
 } elseif ($pay_plan=='MATCHING2') {
 	 
	 // re-commitment binary - 5%
	$MINIMUM_REFERER=2;
	$MINIMUM_TOPUP=2500;
	$MATCHING_MINIMUM=2500;
	$MATCHING_CAPING=35000;
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status='Active' and topup_status='Paid' and topup_plan='RE_TOPUP' ";
 	//$sql_gen = "select u_username,u_id,u_ref_userid from ngo_users where   u_status='Active' ";
  	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
	
	//
 	//if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
 //  print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
	 
	if ($datefrom!='' && $dateto!='') 	{  $sql_part  .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
 	// check minimum 2 referer and u_status='Active' 
 	
	$total_referer= db_scalar("select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid  and topup_plan='RE_TOPUP'  and u_ref_userid ='$u_id' ")+0;
  			
	  // "<br> <br> select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid    and u_status='Active'  and u_ref_userid ='$u_id' ";
 			#print "<br> OK.... $total_referer  = $MINIMUM_REFERER ..............";	
	if ($total_referer >=$MINIMUM_REFERER) {
	
		  $total_topup= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_status!='Unpaid' and topup_plan='RE_TOPUP' and  topup_userid ='$u_id'  ")+0;
		  $total_topup_a= db_scalar("select sum(topup_amount) from ngo_users_recharge  where  topup_status!='Unpaid' and topup_plan='RE_TOPUP' and topup_userid  in (select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='A') ")+0;
		  $total_topup_b= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_status!='Unpaid' and topup_plan='RE_TOPUP' and  topup_userid  in (select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='B') ")+0;
		// 
   		 	#print "<br> OK.... $total_topup  = $MINIMUM_TOPUP ..............";
		
		if ($total_topup>=$MINIMUM_TOPUP && $total_topup_a>=$MINIMUM_TOPUP && $total_topup_b>=$MINIMUM_TOPUP) {
  			
 		$u_id_a = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$u_id' and u_ref_side='A' limit 0,1");
		$u_id_b = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$u_id' and u_ref_side='B' limit 0,1");
   		$pair_a = binary_total_paid_retopup($u_id_a )+0;
 		$pair_b = binary_total_paid_retopup($u_id_b)+0;
 		$total_pair_paid=db_scalar("select sum(pay_ref_amt) from ngo_users_payment where pay_userid ='$u_id' and  pay_plan='$pay_plan'  ")+0;
		// print " <br> ======= $u_username =$u_id= $pair_a = $pair_b = $total_pair_paid "; 
		$total_pair_a = $pair_a-$total_pair_paid;
		$total_pair_b = $pair_b-$total_pair_paid;
 		// calculat valid paire for payment
     // print "<br>= $total_pair_a  = $total_pair_b   = $MATCHING_MINIMUM"; 
		
		if ($total_pair_a!='' && $total_pair_b !='' && $total_pair_a>=$MATCHING_MINIMUM && $total_pair_b>=$MATCHING_MINIMUM) {
  
		if ($total_pair_a>$total_pair_b) 		{ $total_pair_wicker = $total_pair_b;}
		elseif ($total_pair_b>$total_pair_a) 	{ $total_pair_wicker = $total_pair_a;}
		elseif ($total_pair_a=$total_pair_b)	{ $total_pair_wicker = $total_pair_a;}
		
		// check mimimum maching 
 		 //   print " <br> ======= $u_username =   = $pair_a = $pair_b = $total_pair_wicker ";  
 			//$MATCHING_CAPING = db_scalar("select sett_value from ngo_setting where  sett_code ='MATCHING_CAPING' limit 0,1");
  			
			
 			if ($total_pair_wicker>0) {
			// $pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='$pay_plan' limit 0,1");
			 
			$total_updated_caping= db_scalar("select sum(pay_amount) from ngo_users_ewallet   where pay_userid ='$u_id' and pay_plan='BINARY_CAPING'  and pay_topupid='$topup_id'")+0;
			
 			$pay_rate = 5; 
			
			 
			$today_paid_amount1= db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid ='$u_id' and pay_date='$pay_date'  and pay_plan='MATCHING' ");
			$today_paid_amount2= db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid ='$u_id' and pay_date='$pay_date'  and  pay_plan='MATCHING2' ");
			$today_paid_amount = $today_paid_amount1 + $today_paid_amount2;
			
			$MATCHING_CAPING =($total_topup+$total_updated_caping)-$today_paid_amount; 
			//if ($today_paid_amount > $MATCHING_CAPING) { $pay_amount =$MATCHING_CAPING -$today_paid_amount ; } 
 			 
 			$pay_amount = ($total_pair_wicker/100) * $pay_rate ;
			if ($pay_amount > $MATCHING_CAPING) { $pay_amount =$MATCHING_CAPING; } 
 			$msg.= $u_id.' ,';
			if($pay_amount>0){
 			$msg.= $u_username.'['.$pay_amount.'] ,';
			$pay_for ="Re-Commitment Binary Income on $total_pair_wicker ";
			$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_group='WORKING' ,pay_for = '$pay_for' ,pay_ref_amt='$total_pair_wicker' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
			 db_query($sql);
			
 		}
 		}		
	  }
	  
	  }
	  }
	} 
 //----------------------------
 
  
 }
 
 
 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead">User Payment Create </div></td>
        </tr>
      </table>
      <div align="right"><a href="users_payment_list.php">Back to Payment List</a>&nbsp;</div>
      <div align="center" class="errorMsg"><?=$msg?></div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <table width="547"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
          <tr>
            <td align="right" class="tdLabel"> <span class="tdData">Payout Type :</span></td>
            <td  ><span class="txtTotal">
              <?
			echo array_dropdown( $ARR_PAYMENT_TYPE, $pay_plan,'pay_plan', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select payment type"','--select--');
			?>
            </span></td>
            <td align="right"> <!--Topup Plan :--></td>
            <td><span class="txtTotal">
              <input type="hidden" name="pay_plan_type" value="TOPUP" />
              <?
			//echo array_dropdown( $ARR_PLAN_TYPE, $pay_plan_type,'pay_plan_type', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select plan"','--select--');
			?>
</span></td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">Auto ID From : </td>
            <td  ><input name="u_id1" style="width:120px;" type="text" value="<?=$u_id1?>" alt="number" emsg="Please enter user auto id from"  />            </td>
            <td align="right"> <span class="tdLabel">Auto ID</span> To : </td>
            <td><input name="u_id2" style="width:120px;"type="text" value="<?=$u_id2?>" alt="number" emsg="Please enter user auto id to" />            </td>
          </tr>
          <tr class="tableSearch">
            <td align="right">Topup Date  From: </td>
            <td valign="top"><?=get_date_picker("datefrom", $datefrom)?></td>
            <td align="right">Topup Date To : </td>
            <td><?=get_date_picker("dateto", $dateto)?></td>
            <input type="hidden" name="u_id" value="<?=$u_id?>"/>
          </tr>
          <tr>
            <td width="117" align="right" class="tdData">Payment For the date: </td>
            <td width="132" class="txtTotal"><?=get_date_picker("pay_date", $pay_date)?></td>
            <td width="104" align="right" class="tdData">&nbsp; 
          </td>
            <td width="179" class="txtTotal">&nbsp; 
            </td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit" /></td>
            <td align="right"><!--&nbsp;Only Downline--></td>
            <td><span class="txtTotal">
            <!--  <input name="u_userid" style="width:120px;"type="text" value="<?=$u_userid?>"  />-->
              <?
					 
						//echo make_dropdown("select utype_id,utype_name from ngo_users_type where  utype_status='Active' and utype_id>1 ", 'utype_id', $utype_id,  'class="txtbox"   style="width:120px;" ','--select--');
							?>
            </span></td>
          </tr>
        </table>
      </form>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
