<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 #print_r($_POST);
   
//////////////////////////////////////////////////////////
if ($_POST[action]=='Withdrawal') {
$sql_gen = "select u_username,u_id,u_ref_userid, ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and u_status='Active'  ";
if ($u_id1!='' && $u_id2!='') 	{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";}
//if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
# print $sql_gen;
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
 	@extract($line_gen);
	
	$total_take_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_userid='$line_gen[u_id]' and gift_status='Accept' ")+0;
	$total_give_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid='$line_gen[u_id]'  and gift_status='Accept'")+0; 
	$withdrawa_amount=db_scalar("select sum(pay_amount) from ngo_users_payment where  pay_userid = '$u_id' and pay_plan='BANK_WITHDRAW' ")+0;
	
	 
	if ($total_give_amount>0   && $total_take_amount<=0 && $withdrawa_amount==0) {
	//print "<br> $u_username =  $total_give_amount  = $total_take_amount  ";
		$pay_rate =200;
		$pay_amount = $topup_amount*2;
		$pay_ref_amt  = $topup_amount;
    	$pay_for1 = "Get Help Request " ;
		$sql2 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$u_id',pay_refid = '' ,pay_plan='BANK_WITHDRAW' ,pay_group='ROI' ,pay_transaction_no='' ,pay_for = '$pay_for1' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 120 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 120 MINUTE) ";
		db_query($sql2);
	}
  
 }
} else if ($_POST[action]=='Takesupport') {
 			 
			///////////////////////////////////   from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id 
		  	$sql_gen = "select u_username,u_id,u_ref_userid, ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and u_status='Active'  limit 500,1500 ";
 			$result_gen = db_query($sql_gen);
			//print mysqli_num_rows($result_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
			@extract($line_gen);
			//pay_plan='BANK_WITHDRAW' and 
			
			$sql_take = "select u_username,u_id,u_ref_userid, ngo_users_payment.* from ngo_users,ngo_users_payment where  u_id=pay_userid and u_status='Active' 
and pay_plan='BANK_WITHDRAW'  and pay_amount='$topup_amount'  ";
 			$result_take = db_query($sql_take);
			if ($line_take = mysqli_fetch_array($result_take)){
			
			
				$gift_userid = $line_take[u_id];
				$gift_refno = $line_take[pay_id];
				$gift_amount = $line_take[pay_amount];
 				
			$total_take_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_userid='$gift_userid'")+0;
			$total_give_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid='$line_gen[u_id]'  ")+0; 
			//$withdrawa_amount=db_scalar("select sum(pay_amount) from ngo_users_payment where  pay_userid = '$u_id' and pay_plan='BANK_WITHDRAW' ")+0;
		
		/// print " <br> $u_username =  $total_take_amount  = $total_give_amount == $gift_userid - $gift_amount ";
 			//$ctr++ ;
 			if ($total_give_amount==0 && $total_take_amount==0) {
	
 			  print " $gift_userid: $gift_userid =   $total_provided_amount =  $balance_amount =      ";
			
  			 		 
				$sql_insert="insert into ngo_users_gift set gift_userid = '$gift_userid' ,gift_by_userid='$line_gen[u_id]' ,gift_topupid='$line_gen[topup_id]',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 2 DAY),gift_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_status='New'";
					db_query($sql_insert);
					
 		 	 
				}
			
			}
			 
			}	 
			//////////////////////////////////////////////
 		}


 

 /*
 if ($_POST[Submit]=='Submit') {
 
	  $sql_gen = "select u_username,u_id,u_ref_userid, ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid and u_status='Active'   ";
if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
else {
if ($u_id1!='' && $u_id2!='') 	{  $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)";}
}
if ($datefrom!='' && $dateto!='') 	{  $sql_gen .= " and topup_date between '$datefrom' AND '$dateto' ";  } 

# print $sql_gen;
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
 	@extract($line_gen);
	// generate storage fund
	$storage_count = db_scalar("select count(*) from ngo_users_payment where pay_plan='STORAGE_FUND' and pay_topupid='$topup_id' and  pay_userid ='$u_id'")+0;
	$total_give_amount= db_scalar("select  sum(gift_amount) from ngo_users_gift where  gift_by_userid='$u_id' and gift_topupid='$topup_id'  and gift_status='Accept'")+0;
	
	//print  " <br> $storage_count =   $total_give_amount  =$topup_amount ";
	$pay_amount = $topup_amount;
	if ($storage_count==0 && $topup_amount >$total_give_amount)  {
		
		$total_take_amount= db_scalar("select  sum(gift_amount) from ngo_users_gift where  gift_userid='$u_id' and gift_topupid='$topup_id'   and gift_status='Accept'")+0;
		$storage_fund = $total_give_amount *2;
		if ($total_take_amount < $storage_fund) { 
			$storage_fund_amount = $storage_fund-$total_take_amount;
			$pay_rate =200;
			$pay_amount = $storage_fund_amount;
 			$pay_for ="Storage Fund";
			$sql = "insert into ngo_users_payment set pay_drcr='Dr',pay_userid ='$u_id' ,pay_refid ='' ,pay_topupid='$topup_id' ,pay_plan='STORAGE_FUND' ,pay_group='ROI' ,pay_for = '$pay_for' ,pay_ref_amt='$total_give_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]',pay_status='Paid' ";
			db_query($sql);
			$storage_id = mysqli_insert_id();			
		}		
 	 } 
	 // Generate Withdrawal Request
  		$pay_for1 = "Get Help Request " ;
		$sql2 = "insert into ngo_users_payment set  pay_drcr='Dr',  pay_userid = '$u_id',pay_refid = '' ,pay_plan='BANK_WITHDRAW' ,pay_group='ROI' ,pay_transaction_no='' ,pay_for = '$pay_for1' ,pay_ref_amt='$pay_amount' ,pay_unit = 'Fix' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 120 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 120 MINUTE) ";
		db_query($sql2);
		$gift_refno = mysqli_insert_id();	
		
	 ///////////////////////////////////   from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id 
		  print 	$sql_gen = "select *  from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id and topup_amount ='$pay_amount'";
 			$result_gen = db_query($sql_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
 			 @extract($line_gen);
			$gift_userid =$u_id ;
			// withdrawal amount and total get help amount
			$total_get_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_userid='$gift_userid' and gift_refno='$gift_refno'")+0;
			$withdrawal_pay_amount =$pay_amount;
 			if ($withdrawal_pay_amount >$total_get_amount) { 
			
			// check help provide amount and request amount
			$total_provided_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid='$gift_userid' and gift_topupid='$line_gen[topup_id]'")+0; 			
			$balance_amount = $line_gen[topup_amount] - $total_provided_amount ;
  			//print " $gift_username: $gift_userid =   $total_provided_amount =  $balance_amount =      ";
			if ($balance_amount >= $gift_amount) {
			
				if ($gift_userid!='') {
					$sql_insert="insert into ngo_users_gift set gift_userid = '$gift_userid' ,gift_by_userid='$line_gen[topup_userid]' ,gift_topupid='$line_gen[topup_id]',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 2 DAY),gift_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_status='New'";
					 db_query($sql_insert);
					// break;
					 
 			}	 
 			  }
			} else {
				$arr_error_msgs[] = "Error :Support Amount is greater then user given help balance amount, you can send maximum $balance_amount for this users";
				$_SESSION['arr_error_msgs'] = $arr_error_msgs;
			}
			  
			//////////////////////////////////////////////
			
	 }
	 /////////////////////////////////////////////////////	
	} 			
  }
*/    
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
            <td width="117" align="right" class="tdLabel">&nbsp;</td>
            <td width="132"  ><select name="action">
              <option value="">Select</option>
			   <option value="Withdrawal">Withdrawal</option>
              <option value="Takesupport">Take Support</option>
                        </select></td>
            <td width="104" align="right"> <!--Topup Plan :--></td>
            <td width="179"><span class="txtTotal">
             
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
