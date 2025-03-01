<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_id, u_username,u_fname ,ngo_users_coin.*  ";
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

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "  group by pay_userid having count(pay_userid)>0 ";
$sql .= " order by $order_by $order_by2 ";

  
 
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
                  <td width="118"  align="right" valign="top">Username </td>
                  <td width="131">
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td width="90"  align="right" valign="top">Name </td>
                  <td width="128"><input name="u_fname"style="width:120px;" type="text" value="<?=$u_fname?>" /></td>
                  <td width="96" align="right">&nbsp;</td>
                  <td width="161">&nbsp;</td>
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
                  <td  align="right" valign="top">Payment Group: </td>
                  <td><? echo  array_dropdown($ARR_COIN_GROUP,$pay_group,'pay_group',$extra);  ?></td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle">&nbsp;</td>
                </tr>
                <tr>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle">&nbsp;</td>
                </tr>
              </table>
            </form>
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
                 
				   <th width="8%" >ID</th>
                  <th width="15%" >Username</th>
                  <th width="15%" >Name<?= sort_arrows('u_fname')?></th>
 				   <th width="33%" >Cash CG </th>
 				  <th width="29%" >Holding CG </th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
 	$coin_cc = db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$u_id' and pay_group='CC'");
	$coin_hc = db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$u_id' and pay_group='HC'");
 
  ?>
                <tr class="<?=$css?>">
                  
				   <td nowrap="nowrap"><?=$u_id?></td>
                  <td nowrap="nowrap"><?=$u_username?></td>
                  <td nowrap="nowrap"><?=$u_fname?></td>
 				  <td nowrap="nowrap"><div align="center">
 				   <?=$coin_cc?>
			      </div></td>
                  <td nowrap="nowrap"><div align="center">
                   <?=$coin_hc?>
                  </div></td>
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
