<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
 
if(is_post_back()) {
#print_r($_POST);
	$arr_u_ids = $_REQUEST['arr_u_ids'];
	if(is_array($arr_u_ids)) {
		$str_u_ids = implode(',', $arr_u_ids);
		if(isset($_REQUEST['Payment_PaidAAAAAAAAAA']) || isset($_REQUEST['Payment_Paid_x']) ){
  			
 		
		}else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_users_payment set pay_status='Unpaid',pay_transaction_no='',pay_transfer_date='',pay_admin='$_SESSION[sess_admin_login_id]' where u_id in ($str_u_ids)";
			db_query($sql_update);
		
		}else if(isset($_REQUEST['Payout_SMS']) || isset($_REQUEST['Payout_SMS_x']) ) {
			// sms code start
			 	#$sql_test = "select * from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and u_id in ($str_u_ids)  group by pay_userid ";
				/*$sql_test = "select u_username,u_fname,u_mobile, sum(pay_amount)as payment  from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and u_id in ($str_u_ids)  group by pay_userid ";
 				 
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
				
				}*/
 		} else if (isset($_REQUEST['Payment_SMS']) || isset($_REQUEST['Payment_SMS_x']) ) {
  			 // sms code start
			 	#$sql_test = "select * from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and u_id in ($str_u_ids)  group by pay_userid ";
				/*
				$sql_test = "select u_username,u_fname,u_mobile, ROUND((sum(pay_amount)-((sum(pay_amount)/100)* 20)),2)  as payment  from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and u_id in ($str_u_ids)  group by pay_userid ";

			 
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
			 
				
				
 				}
 			 /// end 
			  */
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 
	}
}
 

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

 
// $sql_hc="SELECT SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit,SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit, (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]'";

$columns = "select  * ";
$sql = " from ngo_users ,ngo_users_recharge  where  u_id=topup_userid and  u_status='Active'";
 
#if ($pay_plan!='') 	{$sql .= " and pay_plan='$pay_plan' ";} 
#if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";}

#if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (pay_userid  between $user_id_from  and  $user_id_to )";}
#else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  pay_status ='$user_id_from' ";}
#if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
#if (($datefrom2!='') && ($dateto2!='')){ $sql .= " and pay_transfer_date between '$datefrom2' AND '$dateto2' "; }
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
#if ($pay_admin!='') 		{$sql .= " and pay_admin='$pay_admin' ";}
#if ($pay_for!='') 			{$sql .= " and pay_for like '%$pay_for%' ";}
#if ($pay_drcr!='') 			{$sql .= " and pay_drcr='$pay_drcr' ";}

/// downline payout list of a user
/*if ($u_sponsor_id!=''){
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
 */

# $sql_export = $sql ." group by ngo_users.u_id, upay_for order by ngo_users.u_id asc"; 
# $sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 


$sql_export = $sql ." group by pay_userid, pay_plan,pay_for order by pay_userid asc "; 
// $sql_export_total = $sql ." group by pay_userid  order by pay_userid asc"; 

$order_by == '' ? $order_by = 'u_id' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
$sql_count = "select count(*) ".$sql; 

  $sql .= " group by u_id order by $order_by $order_by2 ";

 
if ($export=='1') {
   $arr_columns =array('u_id'=>'Auto ID','u_username'=>'UserName','u_fname'=>'First Name','u_liberty_reserve'=>'LR Acc No'  ,"SUM(IF(pay_drcr='Cr',pay_amount,'')) as Credit"=>"Credit","SUM(IF(pay_drcr='Dr',pay_amount,'')) as Debit"=>"Debit"
	,"(SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance"=>"Balance"
	  
	 );
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
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
    <td id="pageHead"><div id="txtPageHead"> Users payment Summary </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content"><form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <table width="750"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="6">Advance Search</th>
          </tr>
          <tr>
            <td  align="right" valign="top">Username </td>
            <td><input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
            <td align="right">Naration :</td>
            <td><input name="pay_for"style="width:120px;" type="text" value="<?=$pay_for?>" /></td>
            <td width="96" align="right">Edit By :</td>
            <td width="161"><input name="pay_admin"style="width:120px;" type="text" value="<?=$pay_admin?>" /></td>
          </tr>
          <tr>
            <td width="118" align="right" class="tdLabel">Auto ID . From: </td>
            <td width="131"><input name="user_id_from"style="width:120px;" type="text" value="<?=$user_id_from?>" />
            </td>
            <td width="90" align="right">Auto ID . To:</td>
            <td width="128"><input name="user_id_to" style="width:120px;"type="text" value="<?=$user_id_to?>" />
            </td>
            <td align="right">Downline - Username </td>
            <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
          </tr>
          <tr>
            <td align="right"> Payment Date from: </td>
            <td><?=get_date_picker("datefrom", $datefrom)?></td>
            <td  align="right" valign="top"> Payment Date To: </td>
            <td><?=get_date_picker("dateto", $dateto)?></td>
            <td align="right" valign="middle"><!--<input name="export" type="checkbox" id="export" value="1" />--></td>
            <td valign="middle"><!--Export total Balance Payout -->
              <input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <!--<div align="right"><a href="users_payment_create.php">Create Payment</a> | <a href="users_acc_drcr_f.php">Transfer Fund</a></div> -->
      <div class="msg">
        <?=$msg;?>
      </div>
      <? if(mysqli_num_rows($result)==0){?>
      <div class="msg">Sorry, no records found.</div>
      <? } else{ 
 	  ?>
      <!-- <div align="right"> Showing Records:
              <?= $start+1?>
              to
              <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?>
              of
              <?= $reccnt?>
            </div>-->
      <div>Records Per Page:
        <?=pagesize_dropdown('pagesize', $pagesize);?>
      </div>
      <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="11%" >Username</th>
            <th width="15%" >Name
              <?= sort_arrows('u_username')?></th>
            <th width="12%" ><strong>Total Deposit</strong></th>
            <th width="10%" ><strong>Total Withdraw </strong></th>
            <th width="6%" nowrap="nowrap">Purchase Wallet</th>
            <th width="6%" nowrap="nowrap">Capital Wallet</th>
            <th width="6%" nowrap="nowrap">Reward Wallet</th>
			
			<th width="10%" ><strong>Holding Token Balance  </strong></th>
				    <th width="10%" ><strong>Security Token Balance  </strong></th>
					 <td nowrap="nowrap"><?=round($holding_token,2)?></td>
                  <td nowrap="nowrap"><?=round($security_token,2)?></td>
            <!--  <th width="10%" ><strong>Total Balance  </strong></th>-->
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
  
	$total_deposit += $deposit_inc =  db_scalar("SELECT sum(topup_amount) as balance  FROM ngo_users_recharge where  topup_userid='$u_id' ") ;
 	$total_withdraw += $withdraw_inc =  db_scalar("SELECT  SUM(pay_amount)   as balance  FROM ngo_users_payment where  pay_userid='$u_id' and pay_plan='BANK_WITHDRAW' and pay_status='Paid' ") ;
	
	$deposit_wallet = db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_userid='$u_id' and pay_group='DW'");
	$capital_wallet = db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_userid='$u_id' and pay_group='CW'");
	$reward_wallet = db_scalar("SELECT(SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$u_id'");

 	$holding_token = db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$u_id' and pay_group='DCH'");
	$security_token = db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$u_id' and pay_group='DCI'");


  	$balance_inc = $deposit_inc - $withdraw_inc;
	$css = ($css=='trOdd')?'trEven':'trOdd';
 ?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$u_username?></td>
            <td nowrap="nowrap"><?=$u_fname?></td>
            <td nowrap="nowrap"><?=round($deposit_inc,2)?></td>
            <td nowrap="nowrap"><?=round($withdraw_inc,2)?></td>
            <td><?=price_format($deposit_wallet)?></td>
            <td><?=price_format($capital_wallet)?></td>
            <td><?=price_format($reward_wallet)?></td>
            <!-- <td nowrap="nowrap"><?=round($balance_inc,2)?></td>-->
          </tr>
          <? } ?>
          <tr >
            <th colspan="2" align="right" nowrap="nowrap"><strong>Total Amount : </strong></th>
            <th align="left" nowrap="nowrap"><?=$total_deposit?></th>
            <th align="left" nowrap="nowrap"><?=$total_withdraw?></th>
            <th align="left" nowrap="nowrap" onclick="3"> </th>
          </tr>
        </table>
      </form>
      <? }?>
      <? include("paging.inc.php");?>
    </td>
  </tr>
</table>
<? include("bottom.inc.php");?>
