<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
#print_r($_POST);
	$arr_pay_ids = $_REQUEST['arr_pay_ids'];
	if(is_array($arr_pay_ids)) {
		$str_pay_ids = implode(',', $arr_pay_ids);
		if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			$sql_update="update ngo_users_coin set pay_status='Paid',pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE('$pay_transfer_date',INTERVAL 1 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
 		
		}else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_users_coin set pay_status='Unpaid',pay_transaction_no='',pay_transfer_date='',pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
		
		}else if(isset($_REQUEST['Payout_SMS']) || isset($_REQUEST['Payout_SMS_x']) ) {
			// sms code start
			 	#$sql_test = "select * from  ngo_users_coin, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
				/*$sql_test = "select u_username,u_fname,u_mobile, sum(pay_amount)as payment  from  ngo_users_coin, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
 				 
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
				
				}*/
 		} else if (isset($_REQUEST['Payment_SMS']) || isset($_REQUEST['Payment_SMS_x']) ) {
  			 // sms code start
			 	#$sql_test = "select * from  ngo_users_coin, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
				 
				$sql_test = "select u_username,u_fname,u_mobile,  pay_amount  as payment  from  ngo_users_coin, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids) ";

 				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
			 	$mobile = '91'.$u_mobile;
				$message = "DEAR ".$u_fname." PAYMENT (".price_format($payment).") FOR YOUR ID:".$u_username." IS TRANSFERED IN YOUR BANK ACCOUNT FOR DETAILS PLZ LOGIN IN YOUR ACCOUNT ". SITE_URL;
				send_sms($mobile,$message);
				 
 			 /// end 
			   
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 
	}
}

}
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_username,u_fname,u_city,u_id,u_ref_userid,u_bank_register,ngo_users_coin.*  ";
$sql = " from ngo_users,ngo_users_coin where  u_id=pay_userid ";
//and u_status='Active'
 
if ($pay_plan!='') 		{$sql .= " and pay_plan='$pay_plan' ";} 
if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";}
if ($pay_group!='') 		{$sql .= " and pay_group='$pay_group' ";}


if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (pay_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  pay_status ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
if (($datefrom2!='') && ($dateto2!='')){ $sql .= " and pay_transfer_date between '$datefrom2' AND '$dateto2' "; }
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($pay_admin!='') 		{$sql .= " and pay_admin='$pay_admin' ";}
if ($pay_for!='') 			{$sql .= " and pay_for like '%$pay_for%' ";}
if ($u_fname!='') 			{$sql .= " and u_fname like '%$u_fname%' ";}
if ($pay_status!='') 		{$sql .= " and pay_status='$pay_status' ";}

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

$sql_export = $sql ."  order by pay_userid asc "; 
$sql_export_total = $sql ." group by pay_userid  order by pay_userid asc"; 

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
  $sql .= " order by $order_by $order_by2 ";

 
if ($export=='1') {
   	$arr_columns =array('u_username'=>'User ID','u_id'=>'Auto ID','u_fname'=>'First Name','u_address'=>'Address','u_city'=>'City','u_mobile'=>'Mobile','u_atm_card_no'=>'Bank Acc Holder Name','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City' ,'u_bank_register'=>'Acc Register in Bank','pay_date'=>'Payment Date','pay_for'=>'Payout For','pay_transfer_date'=>'Transfer Date' ,'pay_transaction_no'=>'Transaction No','pay_amount'=>'Total Amount');
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 
if ($export_total=='1') {
//,'((sum(topup_amount)/100)*5) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	//$arr_columns =array( 'u_username'=>'User ID','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile' ,'sum(pay_amount)as totalamount'=>'Total Amount'  );
	
		$arr_columns =array('u_id'=>'Auto ID','u_username'=>'User ID','u_fname'=>'First Name','u_address'=>'Address','u_city'=>'City' ,'u_mobile'=>'Mobile','u_atm_card_no'=>'Bank Acc Holder Name' ,'u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City' ,'u_bank_register'=>'Acc Register in Bank','pay_transfer_date'=>'Transfer Date' ,'pay_transaction_no'=>'Transaction No', 'sum(pay_amount)as totalamount'=>'Total Amount' );
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
          <td id="pageHead"><div id="txtPageHead"> Users Coin details </div></td>
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
                  <td  align="right" valign="top">Name </td>
                  <td><input name="u_fname"style="width:120px;" type="text" value="<?=$u_fname?>" /></td>
                  <td width="96" align="right">Plan : </td>
                  <td width="161"><input name="pay_plan"style="width:120px;" type="text" value="<?=$pay_plan?>" /></td>
				</tr>
                <tr>
                  <td width="118" align="right" class="tdLabel">Auto ID . From/To: </td>
                  <td width="131"><input name="user_id_from"style="width:50px;" type="text" value="<?=$user_id_from?>" />
                    <input name="user_id_to" style="width:50px;"type="text" value="<?=$user_id_to?>" /></td>
                  <td width="90" align="right">Payment Type : </td>
                  <td width="128"><select name="pay_drcr"   >
                    <option>Please Select</option>
                    <option value="Cr">Credit </option>
                    <option value="Dr">Debit </option>
                  </select></td>
                  <td align="right">Edit By : </td>
                  <td><input name="pay_admin"style="width:120px;" type="text" value="<?=$pay_admin?>" /></td>
                </tr>
                
                <tr>
                  <td align="right">  Payment Date from: </td>
                  <td><?=get_date_picker("datefrom", $datefrom)?></td>
                  <td  align="right" valign="top"> Payment Date To: </td>
                  <td><?=get_date_picker("dateto", $dateto)?></td>
                  <td align="right" valign="middle">Paid/Unpaid : </td>
                  <td valign="middle"><input name="pay_status"style="width:120px;" type="text" value="<?=$pay_status?>" /></td>
                </tr>
                <tr>
                  <td align="right">Downline - Username </td>
                  <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
                  <td  align="right" valign="top">Naration :</td>
                  <td><input name="pay_for"style="width:120px;" type="text" value="<?=$pay_for?>" /></td>
                  <td align="right" valign="middle"><input name="export" type="checkbox" id="export" value="1" /></td>
                  <td valign="middle">Export Individual Payout </td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Payment Group: </td>
                  <td><? echo  array_dropdown($ARR_COIN_GROUP,$pay_group,'pay_group',$extra);  ?></td>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td align="right" valign="middle"><input name="export_total" type="checkbox" id="export_total" value="1" /></td>
                  <td valign="middle">Export Total Payout </td>
                </tr>
              </table>
            </form>
			<div align="right"> <a href="users_coin_f.php">Transfer Coin</a></div> 
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
                 
				   <th width="2%" >ID</th>
                  <th width="5%" >Username</th>
                  <th width="10%" >Name<?= sort_arrows('u_fname')?></th>
 				  
 				  <th width="4%" >Pay ID </th>
                  <th width="15%" >Naration</th>
				   <th width="4%" >Processor</th>
				   <th width="4%" >Payment Type </th>
                  <th width="4%" >Ref Amt </th>
                  <th width="3%" >Rate</th>
                  <th width="7%" >Amount </th>
                  <th width="6%" >Payment Date </th>
				  <th width="3%" >Dr/CR</th>
                   <th width="4%">Status</th>
                   <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 //$cheque_other_count = db_scalar("select count(*) from ngo_users where u_cheque_other =$u_id");
	//if ($u_cheque=='self') { $u_cheque_to='self+'.$cheque_other_count;} else {$u_cheque_to=$u_cheque_other;}
	
 ?>
                <tr class="<?=$css?>">
                  
				   <td nowrap="nowrap"><?=$u_id?></td>
                  <td nowrap="nowrap"><?=$u_username?></td>
                  <td nowrap="nowrap"><?=$u_fname?></td>
			 
				  <td nowrap="nowrap"><?=$pay_id?></td>
                  <td><?=$pay_for?></td>
				  <td nowrap="nowrap"><?=$pay_group?></td>
				  <td nowrap="nowrap"><?=$pay_plan?></td>
                  <td nowrap="nowrap"><?=$pay_ref_amt?></td>
                  <td nowrap="nowrap"><?=$pay_rate?>                  </td>
                  <td nowrap="nowrap"><?=$pay_amount?></td>
                   <td nowrap="nowrap"><?=date_format2($pay_date)?></td>
				  <td nowrap="nowrap"><?=$pay_drcr?></td>
                  <td align="center"><a title="<?=$pay_transaction_no?>" href="#"><?=$pay_status?></a></td>
                  <td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$pay_id?>"/></td>
                </tr>
                <? }
?>
              </table>
              <!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
				 <td width="19%" align="right" style="padding:2px"><input name="Payment_SMS" type="image" id="Payment_SMS" src="images/buttons/payment_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/></td>
                  <td width="9%" align="right" style="padding:2px"> <input name="Payout_SMS" type="image" id="Payout_SMS" src="images/buttons/payout_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/>                   </td>
			      <td width="22%" align="right" style="padding:2px"> Transfer date:
			        <?=get_date_picker("pay_transfer_date", date("Y-m-d"))?></td>
			      <td width="34%" align="right" style="padding:2px"> Transaction No/: 
			        <input name="pay_transaction_no" type="text" size="50"  />
			      </td>
				 <td width="8%" align="right" style="padding:2px"> 
				  <input name="Payment_Paid" type="image" id="Payment_Paid" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>                  </td>
				   <td width="8%" align="right" style="padding:2px"><input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>                  </td>
                </tr>
              </table>-->
			  
			  
            </form>
            
            <? }?>
            <? include("paging.inc.php");?>          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
