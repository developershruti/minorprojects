<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
#print_r($_POST);
	$arr_pay_ids = $_REQUEST['arr_pay_ids'];
	if(is_array($arr_pay_ids)) {
		$str_pay_ids = implode(',', $arr_pay_ids);
		if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			$sql_update="update ngo_users_payment set pay_status='Paid',pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE('$pay_transfer_date',INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
 		
		}else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_users_payment set pay_status='Unpaid',pay_transaction_no='',pay_transfer_date='',pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
		
		}else if(isset($_REQUEST['Payout_SMS']) || isset($_REQUEST['Payout_SMS_x']) ) {
			// sms code start
			 	#$sql_test = "select * from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
				$sql_test = "select u_username,u_fname,u_mobile, sum(pay_amount)as payment  from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
 				 
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
				
				$message =  "CONGRATULATION ".$u_fname." TODAY PAYOUT (Rs:".$payment.") GENRATED ON YOUR ID:".$u_username." FOR DETAILS PLZ LOGIN IN YOUR ACCOUNT, ".SITE_URL; 
			    send_sms($u_mobile,$message);
			 
 				}
 			 /// end  
			 
			 
		}else if(isset($_REQUEST['Payment_SMS']) || isset($_REQUEST['Payment_SMS_x']) ) {
  			 // sms code start
			 	#$sql_test = "select * from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
				$sql_test = "select u_username,u_fname,u_mobile, ROUND((sum(pay_amount)-((sum(pay_amount)/100)* 20)),2)  as payment  from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";

			 
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
			 
				$message = "CONGRATULATION ".$u_fname." PAYMENT (Rs:".$payment.") FOR YOUR ID:".$u_username." IS TRANSFERED IN YOUR BANK ACCOUNT   FOR DETAILS PLZ LOGIN IN YOUR ACCOUNT, ".SITE_URL;
				send_sms($u_mobile,$message);
				 
 				}
 			 /// end  
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
  }
}
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_username,u_fname,u_id,u_ref_userid,u_bank_register,ngo_users_payment.*  ";
$sql = " from ngo_users,ngo_users_payment where  u_id=pay_userid and u_status!='Banned'";
 
if ($pay_plan!='') 		{$sql .= " and pay_plan='$pay_plan' ";} 
if ($pay_for!='') 		{$sql .= " and pay_for='$pay_for' ";} 
if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";}

if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (pay_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  pay_status ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
if (($datefrom2!='') && ($dateto2!='')){ $sql .= " and pay_transfer_date between '$datefrom2' AND '$dateto2' "; }
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($pay_admin!='') 	{$sql .= " and pay_admin='$pay_admin' ";}

/// downline payout list of a user
if ($u_sponsor_id!=''){
$u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_sponsor_id'");
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



# $sql_export = $sql ." group by ngo_users.u_id, upay_for order by ngo_users.u_id asc"; 
# $sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

  $sql_export = $sql ." group by pay_userid, pay_plan,pay_for order by pay_userid asc "; 
  $sql_export_total = $sql ." group by pay_userid  order by pay_userid asc"; 

$order_by == '' ? $order_by = 'pay_date' : true;
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
          <td id="pageHead"><div id="txtPageHead"> Users Payout details list </div></td>
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
                  <td  align="right" valign="top">User ID </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right">Paid Status </td>
                  <td><span class="txtTotal">
                    <?
			echo payment_status_dropdown('pay_status',$pay_status);
			?>
                  </span></td>
                  <td width="96" align="right">Plan : </td>
                  <td width="161"><?
			echo array_dropdown( $ARR_PLAN_TYPE, $pay_plan,'pay_plan', 'class="txtbox"  style="width:120px;"','--select--');
			?></td>
				</tr>
                <tr>
                  <td width="118" align="right" class="tdLabel">Auto ID . From: </td>
                  <td width="131"><input name="user_id_from"style="width:120px;" type="text" value="<?=$user_id_from?>" />                  </td>
                  <td width="90" align="right">Auto ID . To:</td>
                  <td width="128"><input name="user_id_to" style="width:120px;"type="text" value="<?=$user_id_to?>" />                  </td>
                  <td align="right">Edit By : </td>
                  <td><input name="pay_admin"style="width:120px;" type="text" value="<?=$pay_admin?>" /></td>
                </tr>
                
                <tr>
                  <td align="right">  Generate Date from: </td>
                  <td><?=get_date_picker("datefrom", $datefrom)?></td>
                  <td  align="right" valign="top"> Generate Date To: </td>
                  <td><?=get_date_picker("dateto", $dateto)?></td>
                  <td align="right" valign="middle"><input name="export" type="checkbox" id="export" value="1" /></td>
                  <td valign="middle">Export Individual Payout </td>
                </tr>
                <tr>
                  <td align="right"> Transfer Date from: </td>
                  <td><?=get_date_picker("datefrom2", $datefrom2)?></td>
                  <td  align="right" valign="top"> Transfer Date To: </td>
                  <td><?=get_date_picker("dateto2", $dateto2)?></td>
                  <td align="right" valign="middle"><input name="export_total" type="checkbox" id="export_total" value="1" /></td>
                  <td valign="middle">Export Total Payout </td>
                </tr>
                <tr>
                  <td align="right">Downline - User ID </td>
                  <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
                  <td  align="right" valign="top">Pay For :</td>
                  <td><span class="txtTotal">
                    <?
			echo array_dropdown( $ARR_PAYMENT_TYPE, $pay_for,'pay_for', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select payment type"','--select--');
			?>
                  </span></td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle"><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                </tr>
              </table>
            </form>
			<div align="right"><a href="users_payment_create.php">Create User Payment</a>  </div> 
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
                  <th width="4%" >Plan</th>
				   <th width="4%" >Auto ID</th>
                  <th width="3%" >User ID</th>
                  <th width="10%" >Name<?= sort_arrows('u_username')?></th>
				 <th width="4%" >Topup ID.</th>
                  <th width="4%" >Ref ID </th>
                  <th width="7%" >Pay Type </th>
                  <th width="4%" >Topup Amt </th>
                  <th width="3%" >Rate</th>
                  <th width="7%" >Amount </th>
                  <th width="6%" >Payment Date </th>
				  <th width="3%" >Status</th>
                   <th width="6%" >Paid Date </th>
                   <th width="4%" >Transaction No. </th>
                   <th width="4%">Edit By </th>
                  <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 //$cheque_other_count = db_scalar("select count(*) from ngo_users where u_cheque_other =$u_id");
	//if ($u_cheque=='self') { $u_cheque_to='self+'.$cheque_other_count;} else {$u_cheque_to=$u_cheque_other;}
	
 ?>
                <tr class="<?=$css?>">
                  <td nowrap="nowrap"><?=$pay_plan?></td>
				   <td nowrap="nowrap"><?=$u_id?></td>
                  <td nowrap="nowrap"><?=$u_username?></td>
                  <td nowrap="nowrap"><?=$u_fname?></td>
				  <td nowrap="nowrap"><?=$pay_topupid?></td>
                  <td nowrap="nowrap"><?=$pay_refid?></td>
                  <td nowrap="nowrap"><?=$pay_for?></td>
                  <td nowrap="nowrap"><?=$pay_ref_amt?></td>
                  <td nowrap="nowrap"><? if ($pay_for=='RECHARGE') { echo $pay_rate+0 .' Days';} else {echo $pay_rate+0 .'%'; }?>                  </td>
                  <td nowrap="nowrap"><?=$pay_amount?></td>
                   <td nowrap="nowrap"><?=date_format2($pay_date)?></td>
				  <td nowrap="nowrap"><?=$pay_status?></td>
                  <td nowrap="nowrap"><?=date_format2($pay_transfer_date)?></td>
                  <td nowrap="nowrap"><?=$pay_transaction_no?></td>
                  <td align="center"><?=$pay_admin?></td>
                  <td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$pay_id?>"/></td>
                </tr>
                <? }
?>
              </table>
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
				 <td width="34%" align="right" style="padding:2px"><input name="Payment_SMS" type="image" id="Payment_SMS" src="images/buttons/payment_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/></td>
                  <td width="8%" align="right" style="padding:2px"><input name="Payout_SMS" type="image" id="Payout_SMS" src="images/buttons/payout_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/>                  </td>
			      <td width="21%" align="right" style="padding:2px"> Transfer date:
			        <?=get_date_picker("pay_transfer_date", date("Y-m-d"))?></td>
			      <td width="21%" align="right" style="padding:2px"> Transaction No: 
			        <input name="pay_transaction_no" type="text"  />
			      </td>
				  <td width="8%" align="right" style="padding:2px"> 
				  <input name="Payment_Paid" type="image" id="Payment_Paid" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>                  </td>
				   <td width="8%" align="right" style="padding:2px"><input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>                  </td>
                </tr>
              </table>
			  
			  
            </form>
            
            <? }?>
            <? include("paging.inc.php");?>          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
