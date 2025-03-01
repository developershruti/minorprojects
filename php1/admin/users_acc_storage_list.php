<?
require_once("../includes/surya.dream.php");
protect_admin_page2();

if(is_post_back()) {
 #print_r($_POST);
 

	$arr_pay_ids = $_REQUEST['arr_pay_ids'];
	if(is_array($arr_pay_ids)) {
		$str_pay_ids = implode(',', $arr_pay_ids);
		if  (isset($_REQUEST['Send_Gift']) || isset($_REQUEST['Send_Gift_x']) ){
 			 
			///////////////////////////////////   from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id 
		    	$sql_gen = "select *  from ngo_users_payment ,ngo_users  where ngo_users_payment.pay_userid=ngo_users.u_id and pay_id in ($str_pay_ids)";
 			$result_gen = db_query($sql_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
 			//pay_plan='BANK_WITHDRAW' and 
			$gift_refno_count =db_scalar("select count(*) from ngo_users_payment  where pay_drcr='Dr' and  pay_id='$gift_refno'");
			if ($gift_refno_count>0) { 
 			
			$gift_userid =db_scalar("select pay_userid from ngo_users_payment  where pay_id='$gift_refno' ")  ;
			// withdrawal amount and total get help amount
			$total_get_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_userid='$gift_userid' and gift_refno='$gift_refno'")+0;
			$withdrawal_pay_amount =db_scalar("select  pay_amount from ngo_users_payment  where pay_plan='BANK_WITHDRAW' and pay_id='$gift_refno'");
 			
			//print " $gift_userid: $gift_refno =   $total_get_amount =  $withdrawal_pay_amount =      ";
			if ($withdrawal_pay_amount >$total_get_amount) { 
			
			// check help provide amount and request amount
			$total_provided_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid='$line_gen[pay_userid]' and gift_group='STORAGE' and gift_topupid='$line_gen[pay_id]' and gift_status!='Reject'")+0; 			
			$balance_amount = $line_gen[pay_amount] - $total_provided_amount ;
  			// print " $gift_username: $gift_userid =   $total_provided_amount =  $balance_amount =      ";
			if ($balance_amount >= $gift_amount) {
			
				if ($gift_userid!='') {
					$sql_insert="insert into ngo_users_gift set gift_userid = '$gift_userid' ,gift_by_userid='$line_gen[pay_userid]' ,gift_topupid='$line_gen[pay_id]',gift_group='STORAGE',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 2 DAY),gift_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_status='New'";
					 db_query($sql_insert);
					
					// send help confirmation msg sms to user 
					$to_fname = db_scalar("select u_fname from ngo_users  where  u_id='$gift_userid' ") ;
					$to_mobile = '91'. db_scalar("select u_fname from ngo_users  where  u_id='$gift_userid' ") ;
					//  send sms to provider help mobile
					$from_mobile = '91'.$line_gen[u_mobile] ;
					$from_message = SITE_NAME. ", Dear $line_gen[u_fname] ,pls deposit $gift_amount support in $to_fname ,Mobile- $to_mobile within 48 hrs. " .SITE_URL ." team";
 					send_sms($from_mobile,$from_message);
					//  send sms to get help mobile
					
					$to_message = SITE_NAME. ", Dear $to_fname  ,pls get an support amount $gift_amount by $line_gen[u_fname] ,Mobile- $line_gen[u_mobile] within 48 hrs. " .SITE_URL ." team";
 					send_sms($to_mobile,$to_message);
					
					
					
					
 // send Provide Help email 
$to_email =  $line_gen[u_email] ; 		 
$to_message="
Dear ". $line_gen[u_fname]  .", 

Provide Help 

You have a request to send a help amount $gift_amount to  ($to_fname) within 48 hrs 
 
http://www.". SITE_URL ." 
Help Amount = ". $gift_amount ."
Receiver Name = ".$to_fname. "
Contact No  = ".$to_mobile. "
 
Thank you !

". SITE_NAME ."
http://www.". SITE_URL ."
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

Get Support 

You have received an offer to receive Support amount $gift_amount from  ($line_gen[u_fname]) within 48 hrs 
 
http://www.". SITE_URL ." 
Help Amount = ". $gift_amount ."
Sender Name = ".$line_gen[u_fname]. "
Sender Contact No  = ".$line_gen[u_mobile]. "
 
Thank you !

". SITE_NAME ."
http://www.". SITE_URL ."
";
$HEADERS  = "MIME-Version: 1.0 \n";
$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
$SUBJECT  = SITE_NAME." Support Help Details ";
if ($from_email!='') {  @mail($from_email, $SUBJECT, $from_message,$HEADERS); }
$_SESSION[POST]='';
//
				$arr_error_msgs[] = "Success :Support Amount successfully sent.";
				$_SESSION['arr_error_msgs'] = $arr_error_msgs;	

 				}	 
				} else { 
				$arr_error_msgs[] = "Error :Given Amount is greater then user storage balance amount, you can send maximum $balance_amount for this users";
				$_SESSION['arr_error_msgs'] = $arr_error_msgs;
				}
				
				
			
			}
			} else {
				$arr_error_msgs[] = "Error :Support Amount is greater then user given help balance amount, you can send maximum $balance_amount for this users";
				$_SESSION['arr_error_msgs'] = $arr_error_msgs;
			}
			}	 
			//////////////////////////////////////////////
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
  }
}
 



$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_username,u_fname,u_city,u_id,u_ref_userid,u_bank_register,ngo_users_payment.*  ";
$sql = " from ngo_users,ngo_users_payment where  u_id=pay_userid and u_status!='Banned' and pay_drcr='Dr' and pay_plan='STORAGE_FUND' ";
 
//if ($pay_plan!='') 		{$sql .= " and pay_plan='$pay_plan' ";} 
if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";}

if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (pay_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  pay_status ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
if (($datefrom2!='') && ($dateto2!='')){ $sql .= " and pay_transfer_date between '$datefrom2' AND '$dateto2' "; }
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($pay_admin!='') 		{$sql .= " and pay_admin='$pay_admin' ";}
if ($pay_for!='') 			{$sql .= " and pay_for like '%$pay_for%' ";}
if ($pay_amount!='') 		{$sql .= " and pay_amount='$pay_amount' ";}
/// downline payout list of a user
if ($u_sponsor_id!=''){
$u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_sponsor_id'");
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
		 $referid = implode(",",$refid);
	} else {
		$sb='stop';
	}
 } 
 
$id_in = implode(",",$id);
if ($id_in!='') {$sql .= " and pay_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}
}
 

# $sql_export = $sql ." group by ngo_users.u_id, upay_for order by ngo_users.u_id asc"; 
# $sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$sql_export = $sql ." group by pay_userid, pay_plan,pay_for order by pay_userid asc "; 
$sql_export_total = $sql ." group by pay_userid  order by pay_userid asc"; 

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
  $sql .= " order by $order_by $order_by2 ";

 
if ($export=='1') {
   	$arr_columns =array('u_username'=>'User ID','u_id'=>'Auto ID','u_fname'=>'First Name','u_address'=>'Address','u_city'=>'City','u_mobile'=>'Mobile','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City' ,'u_bank_register'=>'Acc Register in Bank','pay_date'=>'Payment Date','pay_for'=>'Payout For','pay_transfer_date'=>'Transfer Date' ,'pay_transaction_no'=>'Transaction No','sum(pay_amount)as totalamount'=>'Total Amount','((sum(pay_amount)/100)*10.3) as tds'=>'TDS','((sum(pay_amount)/100)* 9.7) as Handlingcharge'=>'Handling Charge' ,'(sum(pay_amount)-((sum(pay_amount)/100)* 20)) as netamount'=>'Net Amount' );
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 
if ($export_total=='1') {
//,'((sum(topup_amount)/100)*5) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	//$arr_columns =array( 'u_username'=>'User ID','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile' ,'sum(pay_amount)as totalamount'=>'Total Amount'  );
	
		$arr_columns =array('u_id'=>'Auto ID','u_username'=>'User ID','u_fname'=>'First Name','u_address'=>'Address','u_city'=>'City' ,'u_mobile'=>'Mobile','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City' ,'u_bank_register'=>'Acc Register in Bank','pay_transfer_date'=>'Transfer Date' ,'pay_transaction_no'=>'Transaction No', 'sum(pay_amount)as totalamount'=>'Total Amount','((sum(pay_amount)/100)*10.3) as tds'=>'TDS','((sum(pay_amount)/100)*9.7) as Handlingcharge'=>'Handling Charge' ,'(sum(pay_amount)-((sum(pay_amount)/100)*20)) as netamount'=>'Net Amount' );
	export_delimited_file($sql_export_total, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
	 

} 
 
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Storage Giver List</div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
		  
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="750"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="6">Advance Search</th>
                </tr>
				<tr>
                  <td  align="right" valign="top">Username </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right">&nbsp; </td>
                  <td>&nbsp;</td>
                  <td width="22" align="right">&nbsp;</td>
                  <td width="161">&nbsp;</td>
				</tr>
                <tr>
                  <td width="118" align="right" class="tdLabel">Auto ID . From: </td>
                  <td width="131"><input name="user_id_from" type="text"style="width:120px;" value="<?=$user_id_from?>" />                  </td>
                  <td width="98" align="right">Auto ID . To:</td>
                  <td width="194"><input name="user_id_to" style="width:120px;"type="text" value="<?=$user_id_to?>" />                  </td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                
                <tr>
                  <td align="right">   Date from: </td>
                  <td><?=get_date_picker("datefrom", $datefrom)?></td>
                  <td  align="right" valign="top">  Date To: </td>
                  <td><?=get_date_picker("dateto", $dateto)?></td>
                  <td align="right" valign="middle"><input name="export" type="checkbox" id="export" value="1" /></td>
                  <td valign="middle">Export Individual Payout </td>
                </tr>
                <tr>
                  <td align="right">Downline - Username </td>
                  <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
                  <td  align="right" valign="top">  Amount :</td>
                  <td><input name="pay_amount"style="width:120px;" type="text" value="<?=$pay_amount?>" /></td>
                  <td align="right" valign="middle"><input name="export_total" type="checkbox" id="export_total" value="1" /></td>
                  <td valign="middle">Export Total Payout </td>
                </tr>
                <tr>
                  <td align="right"> </td>
                  <td></td>
                  <td  align="right" valign="top">Balance : </td>
                  <td><input name="acc_balance1" type="text"style="width:50px;" value="<?=$acc_balance1?>" />
                      <input name="acc_balance2" style="width:50px;"type="text" value="<?=$acc_balance2?>" /></td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle"><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                </tr>
              </table>
            </form>
			 <div class="msg"><? include("error_msgs.inc.php");?></div>
			<div align="right"><a href="users_payment_create.php"> </a><a href="users_acc_drcr_f.php"></a></div> 
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
                   <th width="5%" >Username</th>
                  <th width="10%" >Name<?= sort_arrows('u_username')?></th>
 				  <th width="4%" >City</th>
 				  <th width="4%" >Pay ID<?= sort_arrows('pay_id')?> </th>
                  <th width="15%" >Naration</th>
				   <th width="4%" >Payment Head </th>
				   <th width="4%" >Payment Type </th>
				   <th width="4%" >Total Get Amount </th>
                  <th width="4%" >Ref Amt </th>
                  <th width="3%" >Rate</th>
                  <th width="7%" >Amount
                    <?= sort_arrows('pay_amount')?></th>
				  <th width="6%" >Given <?= sort_arrows('pay_id')?></th>
                  <th width="6%" >Balance </th>
                  <th width="6%" >Payment Date </th>
				  <th width="3%" >Dr/CR</th>
                   <th width="4%">Status</th>
				     
                   <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 //$cheque_other_count = db_scalar("select count(*) from ngo_users where u_cheque_other =$u_id");
	//if ($u_cheque=='self') { $u_cheque_to='self+'.$cheque_other_count;} else {$u_cheque_to=$u_cheque_other;}
	$total_get_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_userid='$u_id'  ")+0;
	
	//print " <br> select sum(gift_amount) from ngo_users_gift where gift_userid ='$u_id' and gift_group='STORAGE' and gift_topupid='$pay_id'";
	
	$pay_paid_amount = db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid ='$u_id' and gift_group='STORAGE' and gift_topupid='$pay_id'")+0;
	
	$pay_balance_amount = $pay_amount-$pay_paid_amount;
	
if ($acc_balance1>0 && $acc_balance2>0) { 
if ($pay_balance_amount>=$acc_balance1 && $pay_balance_amount<=$acc_balance2) { 

 ?>
                <tr class="<?=$css?>">
                   <td nowrap="nowrap"><?=$u_username?></td>
                  <td nowrap="nowrap"><?=$u_fname?></td>
				  <td nowrap="nowrap"><?=$u_city?></td>
				  <td nowrap="nowrap"><?=$pay_id?></td>
                  <td><?=$pay_for?></td>
				  <td nowrap="nowrap"><?=$pay_group?></td>
				  <td nowrap="nowrap"><?=$pay_plan?></td>
				  <td nowrap="nowrap"><?=$total_get_amount?></td>
                   <td nowrap="nowrap"><?=$pay_ref_amt?></td>
                  <td nowrap="nowrap"><?=$pay_rate?>                  </td>
                  <td nowrap="nowrap"><?=$pay_amount?></td>
                   <td nowrap="nowrap"><?=$pay_paid_amount?></td>
				   <td nowrap="nowrap"><?=$pay_balance_amount?></td>
                   <td nowrap="nowrap"><?=date_format2($pay_date)?></td>
				  <td nowrap="nowrap"><?=$pay_drcr?></td>
                  <td align="center"><a title="<?=$pay_transaction_no?>" href="#"><?=$pay_status?></a></td>
                  <td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$pay_id?>"/></td>
                </tr>
                <? }  
				
				} else {  ?>

			<tr class="<?=$css?>">
				<td nowrap="nowrap"><?=$u_username?></td>
				<td nowrap="nowrap"><?=$u_fname?></td>
				<td nowrap="nowrap"><?=$u_city?></td>
				<td nowrap="nowrap"><?=$pay_id?></td>
				<td><?=$pay_for?></td>
				<td nowrap="nowrap"><?=$pay_group?></td>
				<td nowrap="nowrap"><?=$pay_plan?></td>
				 <td nowrap="nowrap"><?=$total_get_amount?></td>
				<td nowrap="nowrap"><?=$pay_ref_amt?></td>
				<td nowrap="nowrap"><?=$pay_rate?>                  </td>
				<td nowrap="nowrap"><?=$pay_amount?></td>
				<td nowrap="nowrap"><?=$pay_paid_amount?></td>
				<td nowrap="nowrap"><?=$pay_balance_amount?></td>
				<td nowrap="nowrap"><?=date_format2($pay_date)?></td>
				<td nowrap="nowrap"><?=$pay_drcr?></td>
				<td align="center"><a title="<?=$pay_transaction_no?>" href="#"><?=$pay_status?></a></td>
				<td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$pay_id?>"/></td>
			</tr>


   <? }
   
   }
?>



              </table>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr> 
				 <td width="610"></td>
 				<!--<td width="237" align="right" style="padding:2px">Username :  <input name="gift_username" type="text" value="<?=$gift_username?>" /></td>-->
                  <td width="255" align="right" style="padding:2px">Withdrawal Ref No :  
                  <input name="gift_refno" type="text" value="<?=$gift_refno?>" /></td>
 				  <td width="187" align="right" style="padding:2px">Amount :  
			      <input name="gift_amount" type="text" value="<?=$gift_amount?>" /></td>
                  <td width="86" align="right" style="padding:2px"><input name="Send_Gift" type="image" id="Send_Gift" src="images/buttons/submit.gif" onclick="return  updateConfirmFromUser('arr_pay_ids[]')"/>                  </td>
                </tr>
              </table> 
			  
			  
            </form>
            
            <? }?>
            <? include("paging.inc.php");?>          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
