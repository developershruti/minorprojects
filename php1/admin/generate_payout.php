<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
$close_id = $_REQUEST['close_id'];
if($close_id!='') {
 	$sql_close = "select * from ngo_closing where close_id = '$close_id'";
	$result_close = db_query($sql_close);
	if ($line_close = mysqli_fetch_array($result_close)) {
		//$line_close = ms_form_value($line_close);
 		$close_achieve = db_scalar("select count(*) from ngo_users where u_closeid ='$close_id'");
		if ($line_close[close_target]!=0) { $achieve_per = round(($close_achieve*100/$line_close[close_target]),2); }
  		//if ($line_close[close_target]!=0) { $achieve_per = round(($line_close[close_achieve]*100/$line_close[close_target]),2); }
	}
}
 //?act=WorkingBonus&payout_no=1&close_id=2&pay_close_id=1
	// ------------------non working payout code start------------------ 
	if(($act=='WorkingBonus') && ($payout_no!='') && ($close_id!='')) {
 	 // select user list to generate payout for 
 	$sql_gen = "select u_id,u_username,u_utype_value from ngo_users where u_parent_id=0 and  u_closeid = '$pay_close_id'";
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
  		$payout_count = db_scalar("select count(upay_id) from ngo_users_payout where upay_closeid = '$close_id' and upay_pono = '$payout_no' and upay_userid = '$line_gen[u_id]' and upay_for='WorkingBonus' ");
		if ($payout_count==0) {
 		$nonworkingpayrate = db_scalar("select sett_value from ngo_setting where sett_parentid ='2' and sett_payoutno='$payout_no' ");
 		$upay_amount = round(((($nonworkingpayrate/100)*$achieve_per)*$line_gen[u_utype_value]),2);
 			$sql = "insert into ngo_users_payout set  upay_closeid = '$close_id', upay_pono = '$payout_no', upay_userid = '$line_gen[u_id]' ,upay_for = 'WorkingBonus',upay_qty = '$upay_qty', upay_rate = '$achieve_per', upay_amount = '$upay_amount' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' ";
			 db_query($sql);
  			}
		}
		
	}
	// non working payout code end
 
  	//------------------working payout code start ------------------ 
 	if(($payout_for=='Working') && ($payout_id_from!='') && ($payout_id_to!='')) {
 	 // select user list to generate payout for 
 	 $sql_gen = "select u_id ,u_ref_userid ,u_closeid ,u_utype_value from ngo_users where u_ref_userid!=0  and u_parent_id=0  and  u_re_entry='no' and ( u_id >=$payout_id_from and u_id<=$payout_id_to) ";
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	if ($u_ref_userid!='' && $u_ref_userid!=0){
  		// Direct Income level 1
  		 $payout_count1 = db_scalar("select count(upay_id) from ngo_users_payout where  upay_userid = '$u_ref_userid'  and upay_refid = '$u_id' and upay_for='Working' ");
		if ($payout_count1==0) {
			$msg.= $u_id."=".$u_ref_userid.' ,';
		
			if($u_utype_value>=6) { $u_utype_value = $u_utype_value-1;}
			$workingpayrate1 = db_scalar("select sett_value from ngo_setting where sett_id=19 ");
			$upay_amount = $workingpayrate1*$u_utype_value;
		
			$sql = "insert into ngo_users_payout set  upay_closeid = '$u_closeid', upay_sponsor_level ='1', upay_pono='1', upay_userid = '$u_ref_userid',upay_refid = '$u_id' ,upay_for = 'Working' ,upay_qty = '$u_utype_value', upay_rate = '$workingpayrate1', upay_amount = '$upay_amount' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql);
		
 		// Direct Income level 2
		$u_ref_userid2 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
		if ($u_ref_userid2!='' && $u_ref_userid2!=0){
			$workingpayrate2 = db_scalar("select sett_value from ngo_setting where sett_id=20 ");
			$upay_amount2 = $workingpayrate2*$u_utype_value;
			$sql2 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='2', upay_pono='2'  ,upay_userid='$u_ref_userid2' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate2', upay_amount='$upay_amount2' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' "; 
 			db_query($sql2);
			// Direct Income level 3
			$u_ref_userid3 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid2' ");
			if ($u_ref_userid3!='' && $u_ref_userid3!=0){
				$workingpayrate3 = db_scalar("select sett_value from ngo_setting where sett_id=21 ");
				$upay_amount3 = $workingpayrate3*$u_utype_value;
				$sql3 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='3',  upay_pono='3', upay_userid='$u_ref_userid3' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate3', upay_amount='$upay_amount3' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' "; 
				db_query($sql3);
				// Direct Income level 4
				$u_ref_userid4 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid3' ");
				if ($u_ref_userid4!='' && $u_ref_userid4!=0){
					$workingpayrate4 = db_scalar("select sett_value from ngo_setting where sett_id=22 ");
					$upay_amount4 = $workingpayrate4*$u_utype_value;
					$sql4 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='4',  upay_pono='4' , upay_userid='$u_ref_userid4' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate4', upay_amount='$upay_amount4' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' "; 
					db_query($sql4);
			  		// Direct Income level 5
					$u_ref_userid5 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid4' ");
					if ($u_ref_userid5!='' && $u_ref_userid5!=0){
						$workingpayrate5 = db_scalar("select sett_value from ngo_setting where sett_id=23 ");
						$upay_amount5= $workingpayrate5*$u_utype_value;
						$sql5 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='5', upay_pono='5' , upay_userid='$u_ref_userid5' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate5', upay_amount='$upay_amount5' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' "; 
						db_query($sql5);
						
						/*// Direct Income level 6
						$u_ref_userid6 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid5' ");
						if ($u_ref_userid6!='' && $u_ref_userid6!=0){
							$workingpayrate6 = db_scalar("select sett_value from ngo_setting where sett_id=24 ");
							$upay_amount6= $workingpayrate6*$u_utype_value;
							$sql6 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='6' , upay_pono='6' , upay_userid='$u_ref_userid6' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate6', upay_amount='$upay_amount6' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' "; 
							db_query($sql6);
							// Direct Income level 7
							$u_ref_userid7 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid6' ");
							if ($u_ref_userid7!='' && $u_ref_userid7!=0){
								$workingpayrate7 = db_scalar("select sett_value from ngo_setting where sett_id=25 ");
								$upay_amount7= $workingpayrate7*$u_utype_value;
								$sql7 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='7' , upay_pono='7' , upay_userid='$u_ref_userid7' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate7', upay_amount='$upay_amount7' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' "; 
								db_query($sql7);
								// Direct Income level 8
								$u_ref_userid8 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid7' ");
								if ($u_ref_userid8!='' && $u_ref_userid8!=0){
									$workingpayrate8 = db_scalar("select sett_value from ngo_setting where sett_id=26 ");
									$upay_amount8= $workingpayrate8*$u_utype_value;
									$sql8 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='8' , upay_pono='8', upay_userid='$u_ref_userid8' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate8', upay_amount='$upay_amount8' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' "; 
									db_query($sql8);
								}
  							}
 						}*/
						
						
					}
				}
		  	}
 		} 
 	}
}
		#---------------------------
		
		
		}
 	}
  	// working payout code end 
 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//---------------sponsoring income code start  ------------------
	  
 	
	
	// sponsoring income code end 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	
	
	
	
	
	
	 /*else if (($act='Club') && ($close_id!='')) {
		// generate payout for club member to a select closing
		$total_user = db_scalar("select count(u_id) from ngo_users where  u_closeid ='$close_id' "); 
   		$sql_gen = "select sett_id,sett_title,sett_payoutno,sett_value from ngo_setting where sett_id in (17,18,19,20,21) order by sett_id asc ";
		$result_gen = db_query($sql_gen);
  		while($line_gen = mysqli_fetch_array($result_gen)) {
			$id=$line_gen[sett_id]+1;
			// select range of total work
			$select_to = db_scalar("select sett_payoutno from ngo_setting where sett_id =$id ")-1;
			$select_from = $line_gen[sett_payoutno];
			if ($close_id-12>0) { $close_id_to = $close_id-12; } else {$close_id_to = 1;}
			$total_paid_amount = $total_user * $line_gen[sett_value];
			// select total qualified member 
			if ($line_gen[sett_id]==21) {
				$total_qualified = db_scalar("select count(u_ref_userid) as totalcount from ngo_users where u_closeid between $close_id_to and $close_id having count(u_ref_userid) > $select_from");
			} else {
				$total_qualified = db_scalar("select count(u_ref_userid) as totalcount from ngo_users where u_closeid between $close_id_to and $close_id having count(u_ref_userid) between $select_from  and $select_to");
			}
			if ($total_qualified>0) {
 				$user_paid_amount = $total_paid_amount/$total_qualified; // calculat amount to paid for each member
 				$sql_qualified = "select  u_id  from ngo_users where u_closeid between $close_id_to and $close_id group by u_ref_userid  having count(u_ref_userid) between $select_from  and $select_to ";
				$result_qualified = db_query($sql_qualified);
				while($line_qualified = mysqli_fetch_array($result_qualified)) {
					$already_paid = db_scalar("select count(upay_closeid) from ngo_users_payout  where upay_userid = '$line_qualified[u_id]' and upay_closeid = '$close_id'");
					if ($already_paid==0) {
						$sql = "insert into ngo_users_payout set  upay_closeid = '$close_id', upay_pono = '0', upay_userid = '$line_qualified[u_id]' ,upay_for = 'Club Zone',upay_qty = '$total_qualified', upay_rate = '$user_paid_amount', upay_amount = '$user_paid_amount' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' ";
						db_query($sql);
					}
					
				}
			}
 		}
		//--------------------------------
	} elseif (($act='Investor') && ($close_id!='')) {
 		// generate inveter payour for selected closig 
		$total_user = db_scalar("select count(u_id) from ngo_users where  u_closeid ='$close_id' "); 
   		$sql_gen = "select sett_id,sett_title,sett_payoutno,sett_value from ngo_setting where sett_id in (22,23,24) order by sett_id asc ";
		$result_gen = db_query($sql_gen);
  		while($line_gen = mysqli_fetch_array($result_gen)) {
   			$total_paid_amount = $total_user * $line_gen[sett_value];
			// select total qualified member 
				if ($close_id-12>0) { $close_id_to = $close_id-12; } else {$close_id_to = 1;}
 				$total_qualified = db_scalar("select count(u_id) as totalcount from ngo_users where u_closeid between $close_id_to and $close_id  and u_utype_value= $line_gen[sett_payoutno]");
 			if ($total_qualified>0) {
 				$user_paid_amount = $total_paid_amount/$total_qualified; // calculat amount to paid for each member
 				$sql_qualified = "select  u_id  from ngo_users where u_closeid between $close_id_to and $close_id  and u_utype_value= $line_gen[sett_payoutno] ";
				$result_qualified = db_query($sql_qualified);
				while($line_qualified = mysqli_fetch_array($result_qualified)) {
					$already_paid = db_scalar("select count(upay_closeid) from ngo_users_payout  where upay_userid = '$line_qualified[u_id]' and upay_closeid = '$close_id'");
					if ($already_paid==0) {
						$sql = "insert into ngo_users_payout set  upay_closeid = '$close_id', upay_pono = '0', upay_userid = '$line_qualified[u_id]' ,upay_for = 'Invester Zone',upay_qty = '$total_qualified', upay_rate = '$user_paid_amount', upay_amount = '$user_paid_amount' ,upay_datetime =now(),upay_admin='$_SESSION[sess_admin_login_id]' ";
						db_query($sql);
					}
					
				}
			}
 		}
		
		//-------------------------------------------- 
	}
 */
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">Add/ update Closing </div></td>
  </tr>
</table>
<div align="right"><a href="closing_list.php">Back to Closing List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="181"  border="0" align="center" cellpadding="0" cellspacing="2">
	  <tr>
	    <td width="73" class="tdData">Closing ID </td>
	    <td width="102" class="txtTotal">: <?=$close_id?></td>
	    </tr>
  </table>
</form>
 
 <?
$columns = "select * ";
$sql = " from ngo_closing where close_id < $close_id  order by close_id desc limit 0,12  ";
$sql_count = "select count(*) ".$sql; 
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
 ?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
        <? if(mysqli_num_rows($result)==0){?>
      <div class="msg">Sorry, no records found.</div>
      <? } else{ 
 	  ?>
	  
      <div align="right"> Showing Records:
        <?= $start+1?>
        to
        <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?>
        of
        <?= $reccnt?>
      </div>
      <div>Records Per Page:
        <?=pagesize_dropdown('pagesize', $pagesize);?>
      </div>
      <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="7%" class="tdLabel" >Payout No. </th>
            <th width="7%" >Closing ID </th>
 			<th width="9%" >Total Users </th>
			<th width="18%" >Complement Incentive</th>
			<!--<th width="21%" >Sponsoring Income </th>-->
 			<th width="15%" >&nbsp;</th>
 			<th width="15%" >&nbsp;</th>
			<th width="8%" >&nbsp;</th>
            </tr>
          <?
 		  
$ctr=0;		  
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	$ctr++;
 	$css = ($css=='trOdd')?'trEven':'trOdd';
	//if ($line[close_target]!=0) { $achieve_per = round(($line[close_achieve]*100/$line[close_target]),2)."%"; }
 	//$user_achieve = db_scalar("select count(u_id) from ngo_users where u_closeid='$close_id' ");
	 
	 $sql_paytotal = "select count(upay_userid) as user_count, sum(upay_amount) as upay_amount  from ngo_users_payout where upay_closeid = '$close_id' and upay_pono='$ctr'  and upay_for='ComplementIncentive' group by upay_closeid";
	$result_paytotal = db_query($sql_paytotal);
	$line_paytotal= mysqli_fetch_array($result_paytotal);
	
 	//$sponsor_amount = db_scalar("select sum(upay_amount) from ngo_users_payout where upay_closeid = '$close_id' and upay_pono='$ctr' and upay_for='sponsoring' group by upay_closeid");
 	
?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$ctr?></td>
            <td nowrap="nowrap"><?=$line[close_id]?></td>
 			 <td nowrap="nowrap"><?=$line_paytotal[user_count]?></td>
			 <td nowrap="nowrap"><?=$line_paytotal[upay_amount]?></td>
			 <td nowrap="nowrap"><?=$sponsor_amount?></td>
 			
 			 <td nowrap="nowrap"><a href="generate_payout.php?act=WorkingBonus&amp;payout_no=<?=$ctr?>&amp;close_id=<?=$close_id?>&amp;pay_close_id=<?=$line[close_id]?>">Generate Complement Incentive</a></td> 
			 
			 <td nowrap="nowrap"><a href="payout_details.php?pono=<?=$ctr?>&amp;close_id=<?=$close_id?>&amp;pay_close_id=<?=$line[close_id]?>">View Payout</a></td>
            </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" style="padding:2px">
			 </td>
                  </tr>
        </table>
      </form>
    <? }?>      <? //include("paging.inc.php");?>    </td>
  </tr>
</table>
<? include("bottom.inc.php");?>