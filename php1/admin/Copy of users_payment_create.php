<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 #print_r($_POST);
 
  
 
 if($pay_for=='DIRECT') {
   	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and topup_plan= '$pay_plan' and u_ref_userid!=0  and u_status!='Banned' and topup_status!='Close'  ";
  	if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and u_date between '$datefrom' AND '$dateto' ";  } 
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
			@extract($line_gen);
			if ($u_ref_userid!='' && $u_ref_userid!=0){
				$payout_count1 = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_ref_userid'  and pay_refid = '$u_id' and pay_for='$pay_for' and pay_topupid='$topup_id' and pay_plan='$pay_plan' ");
			if ($payout_count1==0) {
				$msg.= $u_id.' ,';
				$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_title ='$pay_for' limit 0,1");
				$pay_amount = ($topup_amount/100)*$pay_rate;
				if($pay_amount>0){
				$sql = "insert into ngo_users_payment set pay_userid = '$u_ref_userid',pay_refid = '$u_id' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
				db_query($sql);
				}
			 }		
		}
	}
	//-------------------------
 }  elseif ($pay_for=='DAILY_PAYOUT') {
 
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and topup_plan= 'TOPUP' and u_status!='Banned' and topup_status!='Close'   ";
  	if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
	#print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
   	$payout_count = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_id'  and pay_for='$pay_for' and pay_topupid='$topup_id' and pay_plan='$pay_plan' ");
	//$DAILY_PAYOUT_DAYS = db_scalar("select sett_value from ngo_setting where  sett_code ='DAILY_PAYOUT_DAYS'");
 	if ($pay_date >= $topup_date) {
	
	if ($payout_count >=$topup_days_for ) {
		db_query("update ngo_users_recharge set topup_status='Close' where  topup_id = '$topup_id'  ");
	}
	if ($topup_days_for > $payout_count) {
		$today_count = db_scalar("select count(pay_id) from ngo_users_payment where pay_topupid='$topup_id'  and  pay_date=date(ADDDATE('$pay_date',INTERVAL 750 MINUTE)) and pay_userid = '$u_id' ");
		if ($today_count==0) {
	
		//$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_title ='$pay_for' limit 0,1");
		
			$pay_amount = ($topup_amount/100)*$topup_rate;
			if($pay_amount>0){
			$msg.= $u_id.' ,';
			$sql = "insert into ngo_users_payment set pay_userid = '$u_id',pay_refid = '' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit='%' ,pay_rate = '$topup_rate', pay_amount = '$pay_amount' ,pay_date=date(ADDDATE('$pay_date',INTERVAL 750 MINUTE)) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql);
			
			/* $roi_rate = db_scalar("select sett_value from ngo_setting where  sett_title ='ROI' limit 0,1");
			$roi_pay_amount = ($pay_amount/100)*$roi_rate;
			$sql = "insert into ngo_users_payment set pay_userid = '$u_ref_userid',pay_refid = '$u_id' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = 'ROI' ,pay_ref_amt='$pay_amount' ,pay_unit='%' ,pay_rate = '$roi_rate', pay_amount = '$roi_pay_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql); */
			
			
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
  }  elseif ($pay_for=='MATCHING') {
 	
	$sql_gen = "select u_username,u_id,u_ref_userid from ngo_users where  u_ref_userid!=0  and u_status='Active' ";
  	if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	# print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
	if ($datefrom!='' && $dateto!='') 	{  $sql_part .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
	# get left right sponser id
	
		// check minimum 2 referer
		$total_referer= db_scalar("select count(*) from ngo_users  where u_ref_userid ='$u_id' and u_status='Active' ")+0;
		if ($total_referer >=2) {
 		 
		// select sum(topup_amount) from ngo_users_recharge  where topup_userid  in (select u_id from ngo_users where  u_ref_userid ='100009' and u_ref_side='A')
		$u_id_a = db_scalar("select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='A' ");
		$u_id_b = db_scalar("select u_id from ngo_users where  u_ref_userid ='$u_id' and u_ref_side='B' ");
 
		 
		$total_topup= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_userid ='$u_id' ")+0;
 		$total_topup_a= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_userid ='$u_id_a' ")+0;
		$total_topup_b= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_userid ='$u_id_b' ")+0;
		
		if ($total_referer>=2  && $total_topup>=10000 && $total_topup_a>=10000 && $total_topup_a>=10000) {
 		
		# calculate left and right paire - total
 		$total_pair_a = binary_total_business_date_range($u_id_a ,$sql_part)+0;
 		$total_pair_b = binary_total_business_date_range($u_id_b ,$sql_part)+0;
 		// calculat valid paire for payment
   		if ($total_pair_a!='' && $total_pair_b !='' && $total_pair_a>=10000 && $total_pair_b>=10000) {
 		// check total pair in a and b side
		if ($total_pair_a>$total_pair_b) 		{ $total_pair_achive = $total_pair_b;}
		elseif ($total_pair_b>$total_pair_a) 	{ $total_pair_achive = $total_pair_a;}
		elseif ($total_pair_a=$total_pair_b)	{ $total_pair_achive = $total_pair_a;}
  
		$total_pair_paid = db_scalar("select sum(pay_ref_amt) from ngo_users_payment where pay_userid ='$u_id' and  pay_for='$pay_for'")+0;
		$total_pair_pending = $total_pair_achive - $total_pair_paid;
		if ( $total_pair_pending>0) {
			$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_title ='$pay_for' limit 0,1");
			$pay_amount = ($total_pair_pending/100)*$pay_rate;
			if($pay_amount>0){
			$msg.= $u_id.' ,';
		
			$sql = "insert into ngo_users_payment set pay_userid = '$u_id',pay_refid = '$pay_refid' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$total_pair_pending' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql);
		}
 		}		
	  }
	  
	  }
	  }
	} 
 //----------------------------
 
 }  elseif ($pay_for=='MATURITY--sb--') {
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and topup_plan= 'RECHARGE' and u_ref_userid!=0  and u_status!='Banned'   ";
  	if ($u_id1!='' && $u_id2!='') 		{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
	if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	if ($u_ref_userid!='' && $u_ref_userid!=0){
     	$payout_count1 = db_scalar("select count(pay_id) from ngo_users_payment where  pay_userid = '$u_ref_userid'  and pay_refid = '$u_id' and pay_for='$pay_for' and pay_topupid='$topup_id' and pay_plan='$pay_plan' ");
	if ($payout_count1==0) {
		$msg.= $u_id.' ,';
		$pay_rate = db_scalar("select sett_value from ngo_setting where  sett_title ='$pay_for' limit 0,1");
		$pay_amount = ($topup_amount/100)*$pay_rate;
		if($pay_amount>0){
	#$sql = "insert into ngo_users_payment set pay_userid = '$u_ref_userid',pay_refid = '$u_id' ,pay_topupid='$topup_id' ,pay_plan='$pay_plan' ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit='%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
		#db_query($sql);
		}
 		}		
	}
	}
	//-------------------------
 }  elseif ($pay_for=='ROI') {
 
 }  elseif ($pay_for=='REWARDS') {
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
      <div align="left">
        <?=$msg?>
      </div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <table width="547"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
          <tr>
            <td align="right" class="tdLabel">Plan : </td>
            <td  ><span class="txtTotal">
              <?
			echo array_dropdown( $ARR_PLAN_TYPE, $pay_plan,'pay_plan', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select plan"','--select--');
			?>
              </span></td>
            <td align="right"><span class="tdData">Payout Type :</span></td>
            <td><span class="txtTotal">
              <?
			echo array_dropdown( $ARR_PAYMENT_TYPE, $pay_for,'pay_for', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select payment type"','--select--');
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
            <td width="104" align="right" class="tdData"> 
         <!--   ROI Plan :--> </td>
            <td width="179" class="txtTotal"><?
			//echo array_dropdown( $ARR_PLAN_TOPUP_RATE, $pay_rate,'pay_rate', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select plan"','--select--');
			?></td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit" /></td>
            <td align="right">&nbsp;<!--Pin Welth : --></td>
            <td><span class="txtTotal">
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
