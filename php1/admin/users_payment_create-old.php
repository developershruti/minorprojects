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
   	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid   and u_ref_userid!=0  and u_status!='Banned' and topup_status!='Close'  ";
  	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and u_date between '$datefrom' AND '$dateto' ";  } 
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
			@extract($line_gen);
			if ($u_ref_userid!='' && $u_ref_userid!=0){
				$payout_count1 = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_ref_userid'  and pay_refid = '$u_id' and pay_plan='$pay_plan' and pay_topupid='$topup_id' ");
			if ($payout_count1==0) {
				$msg.= $u_id.' ,';
				$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='$pay_plan' limit 0,1");
				$pay_amount = ($topup_amount/100)*$pay_rate;
				if($pay_amount>0){
				
				// direct commission 
				$pay_for = "Credit amount in your account for Direct commission on the new registered user :$u_username ";
				$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_ref_userid',pay_refid = '$u_id' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
				db_query($sql);
			 
				}
			 }		
		}
	}
	//-------------------------
 }  elseif ($pay_plan=='PROFIT_SHARING') {
 
  	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and topup_plan= 'TOPUP' and u_status!='Banned' and topup_status!='Close' ";
  	
	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	}
 	//if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
	 # print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	$payout_count = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_id' and pay_topupid='$topup_id' and pay_plan='$pay_plan' ");
  	//print "<br>   pay_date=".$pay_date. " ,topup_date= ". $topup_date  ; 
	if ($pay_date >= $topup_date) {
  	if ($payout_count >=$topup_days_for ) {
		db_query("update ngo_users_recharge set topup_status='Close' where  topup_id = '$topup_id'  ");
	}
	if ($topup_days_for > $payout_count) {
	  //print "<br>   topup_days_for=".$topup_days_for. " ,payout_count= ". $payout_count  ; 

		$today_count = db_scalar("select count(pay_id) from ngo_users_payment where pay_topupid='$topup_id'  and  pay_date=date(ADDDATE('$pay_date',INTERVAL 750 MINUTE)) and pay_userid = '$u_id' and pay_plan='$pay_plan' ");
		
 		if ($today_count==0) {
			$topup_rate = $topup_rate/22;
   			$pay_amount = ($topup_amount/100)*$topup_rate;
			if($pay_amount>0){
			$msg.= $u_id.' ,';
			$pay_for ="Profit sharing bonus credited for topup Ref No: $topup_id";
			$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_id',pay_refid = '' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit='%' ,pay_rate = '$topup_rate', pay_amount = '$pay_amount' ,pay_date=date(ADDDATE('$pay_date',INTERVAL 750 MINUTE)) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql);
			
			 
		 // 15% DEDUCTION FROM ACCOUNT
		 	$deduction_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='DEDUCTION' limit 0,1");
			$pay_rate = $deduction_rate;
			$deduction_amount = ($pay_amount/100)*$pay_rate;
			if($deduction_amount>0){
			$pay_for = "Debit amount from Profit sharing for service and other charges ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Dr', pay_userid = '$u_id',pay_refid = '$u_id' ,pay_topupid='$topup_id' ,pay_plan='DEDUCTION' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$deduction_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			 db_query($sql);
			 }
			
			
			}
 		}		
	}
	
	}
	
	}
	//-------------------------
	
 // condition 
 /*
 
 1. Must be refere direct 2 user and they must be topup there account with minimum 10k 
 2. both side must be top minimum 10k
 3. user must be recharge there account minimum 10k
 4. user account must be active
  ////// ---- 101253
 
 
 
 */
  } elseif ($pay_plan=='MATCHING') {
 	
	$sql_gen = "select u_username,u_id,u_ref_userid from ngo_users where  u_ref_userid!=0  and u_status='Active' ";
  	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else { 	if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  } 
	}
    $result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
	if ($datefrom!='' && $dateto!='') 	{  $sql_part .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
 	 	#$total_referer= db_scalar("select count(*) from ngo_users  where u_ref_userid ='$u_id' and u_status='Active' ")+0;
		#if ($total_referer >=0) {
  	 	$total_topup= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_userid ='$u_id' ")+0;
 		if ($total_topup>=100 ) {
 		#print "<br>userid=".$u_id;
 		$u_id_a = db_scalar("select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='A' limit 0,1");
		$u_id_b = db_scalar("select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='B' limit 0,1");

  		$pair_a = binary_total_business_date_range($u_id_a ,$sql_part)+0;
 		$pair_b = binary_total_business_date_range($u_id_b ,$sql_part)+0;
		
		$total_pair_paid_a = db_scalar("select sum(pay_ref_amt) from ngo_users_payment where pay_userid ='$u_id' and  pay_plan='$pay_plan'")+0;
		$total_pair_paid_b = db_scalar("select sum(pay_ref_amt2) from ngo_users_payment where pay_userid ='$u_id' and  pay_plan='$pay_plan'")+0;
		
		$total_pair_a = $pair_a-$total_pair_paid_a;
		$total_pair_b = $pair_b- $total_pair_paid_b;
 		
		$MATCHING_MINIMUM = db_scalar("select sett_value from ngo_setting where  sett_code ='MATCHING_MINIMUM' limit 0,1");
		if ($MATCHING_MINIMUM=='') { $MATCHING_MINIMUM='3000';}
 		// calculat valid paire for payment
 		if ($total_pair_a!='' && $total_pair_b !='' && $total_pair_a>='$MATCHING_MINIMUM' && $total_pair_b>='$MATCHING_MINIMUM') {
 		 //print "<br>paire = ".$total_pair_a .':'.$total_pair_b;
  		// check total pair in a and b side
		if ($total_pair_a>$total_pair_b) 		{ $total_pair_wicker = $total_pair_b;}
		elseif ($total_pair_b>$total_pair_a) 	{ $total_pair_wicker = $total_pair_a;}
		elseif ($total_pair_a=$total_pair_b)	{ $total_pair_wicker = $total_pair_a;}
		//binary flush out
		$maching_qualified = floor(($total_pair_wicker/$MATCHING_MINIMUM));
  		$total_pair_achive = $MATCHING_MINIMUM*$maching_qualified;
  		$balance_flush_out = $total_pair_wicker - $total_pair_achive +0; 
		if ($balance_flush_out<1000) {
 			$pay_ref_amt = $total_pair_a;
			$pay_ref_amt2 = $total_pair_b;
 		} else  {
			$pay_ref_amt = $total_pair_achive;
			$pay_ref_amt2 = $total_pair_achive;
		}
  		 //print "<br>id= $u_id  :flush = $balance_flush_out  :  $total_pair_a   : $total_pair_b        ";
   		if ($pay_ref_amt>0) {
			$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='$pay_plan' limit 0,1");
			$pay_amount = ($total_pair_achive/100)*$pay_rate;
 			
			$msg.= $u_id.' ,';
 			$deduction_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='MATCHING_DEDUCTION' limit 0,1");
			// direct binary 
			if($pay_amount>0){ 	$pay_for = "Credit amount in your account for matching bonus "; 
			} else { $pay_for = "Credit Matching bonus flush out ";}
			
  			$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_ref_amt',pay_ref_amt2='$pay_ref_amt2' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
			$pay_refid = mysqli_insert_id();
			
			if($pay_amount>0){
 			// 15% DEDUCTION FROM ACCOUNT
			$pay_rate = $deduction_rate;
			$deduction_amount = ($pay_amount/100)*$pay_rate;
			$pay_for = "Debit amount from matching bonus for service and other charges ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Dr', pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$deduction_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
			
			
			 // leader ship bonus 1 
			$u_ref_userid1 = db_scalar("select u_ref_userid from ngo_users where  u_id ='$u_id' limit 0,1"); 
			$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='LEADERSHIP1' limit 0,1");
			$pay_amount1 = ($pay_amount/100)*$pay_rate;
			$pay_for = "Credit amount in your account for leadership bonus level 1 ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_ref_userid1',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='LEADERSHIP1' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount1' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
			 
			// 15% DEDUCTION FROM ACCOUNT
			$pay_rate = $deduction_rate;
			$deduction_amount = ($pay_amount1/100)*$pay_rate;
			$pay_for = "Debit amount from leadership Level 1 for service and other charges ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Dr', pay_userid = '$u_ref_userid1',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='LEADERSHIP1' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount1' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$deduction_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
			
			// leader ship bonus 2 
			$u_ref_userid2 = db_scalar("select u_ref_userid from ngo_users where  u_id ='$u_ref_userid1' limit 0,1"); 
			$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='LEADERSHIP2' limit 0,1");
			$pay_amount2 = ($pay_amount/100)*$pay_rate;
			$pay_for = "Credit amount in your account for leadership bonus level 2 ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_ref_userid2',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='LEADERSHIP2' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount2' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
			// 15% DEDUCTION FROM ACCOUNT
			$pay_rate = $deduction_rate;
			$deduction_amount = ($pay_amount2/100)*$pay_rate;
			$pay_for = "Debit amount from leadership Level 2 for service and other charges ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Dr', pay_userid = '$u_ref_userid2',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='LEADERSHIP2' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount2' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$deduction_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
 			 
			 // leader ship bonus 3 
			$u_ref_userid3 = db_scalar("select u_ref_userid from ngo_users where  u_id ='$u_ref_userid2' limit 0,1"); 
			$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_code ='LEADERSHIP3' limit 0,1");
			$pay_amount3 = ($pay_amount/100)*$pay_rate;
			$pay_for = "Credit amount in your account for leadership bonus level 3 ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Cr', pay_userid = '$u_ref_userid3',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='LEADERSHIP3' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount3' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
			// 15% DEDUCTION FROM ACCOUNT
			$pay_rate = $deduction_rate;
			$deduction_amount = ($pay_amount3/100)*$pay_rate;
			$pay_for = "Debit amount from leadership Level 3 for service and other charges ";
  			$sql = "insert into ngo_users_payment set pay_drcr='Dr', pay_userid = '$u_ref_userid3',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='LEADERSHIP3' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount3' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$deduction_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]'";
  			$result = db_query($sql);
 		}
 		//}		
	  }
	  
	  }
	  }
	} 
 //----------------------------
 
 }  elseif ($pay_plan=='MATURITY--sb--') {
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and topup_plan= 'RECHARGE' and u_ref_userid!=0  and u_status!='Banned'   ";
  	if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	if ($u_ref_userid!='' && $u_ref_userid!=0){
     	$payout_count1 = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_ref_userid'  and pay_refid = '$u_id'  and pay_topupid='$topup_id' and pay_plan='$pay_plan' ");
	if ($payout_count1==0) {
		$msg.= $u_id.' ,';
		$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_title ='$pay_plan' limit 0,1");
		$pay_amount = ($topup_amount/100)*$pay_rate;
		if($pay_amount>0){
	#$sql = "insert into ngo_users_payment set pay_userid = '$u_ref_userid',pay_refid = '$u_id' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit='%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
		#db_query($sql);
		}
 		}		
	}
	}
	//-------------------------
 }  elseif ($pay_plan=='ROI') {
 
 }  elseif ($pay_plan=='REWARDS') {
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
      <div align="right"><a href="users_acc_drcr_list.php">Back to Payment List</a>&nbsp;</div>
      <div align="left">
        <?=$msg?>
      </div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <table width="547"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
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
            <td width="104" align="right" class="tdData"> 
         <!--   ROI Plan :-->          Payout Type :</td>
            <td width="179" class="txtTotal"><?
			echo array_dropdown( $ARR_PAYMENT_TYPE, $pay_plan,'pay_plan', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select payment type"','--select--');
			?></td>
          </tr>
          <tr>
            <td align="right" class="tdLabel"><span class="txtTotal">
              
            </span></td>
            <td><input type="submit" name="Submit" value="Submit" /></td>
            <td align="right">&nbsp;Only Downline</td>
            <td><span class="txtTotal">
              <input name="u_userid" style="width:120px;"type="text" value="<?=$u_userid?>"  />
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
