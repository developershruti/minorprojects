<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
	$arr_creq_ids = $_REQUEST['arr_creq_ids'];
	if(is_array($arr_creq_ids)) {
		$str_creq_ids = implode(',', $arr_creq_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from crypto_payments where creq_status = 'New Request' and creq_id in ($str_creq_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Paid']) || isset($_REQUEST['Paid_x']) ) {
			$sql = "update crypto_payments set creq_status = 'Paid' where creq_status = 'New Request' and creq_id in ($str_creq_ids)";
			db_query($sql);
			$pay_userid  = db_scalar("select u_id from ngo_users where u_id  in (select creq_userid from crypto_payments where creq_id in ($str_creq_ids))");
		
 		} else if(isset($_REQUEST['Unpaid']) || isset($_REQUEST['Unpaid_x']) ) {
			$sql = "update crypto_payments set creq_status = 'Unpaid' where creq_status = 'New Request' and  creq_id in ($str_creq_ids)";
			db_query($sql);
		}
		
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from crypto_payments, ngo_users ";
$sql .= " where u_id=userID ";

if ($u_username!='') 			{$sql .= " and u_username='$u_username' "; }
if ($datefrom!='' && $dateto!='') {  $sql .= " and txDate between '$datefrom' AND '$dateto' ";} 
///if ($u_mobile!='') 		{$sql .= " and u_mobile='$u_mobile' "; }
#if ($creq_status!='') 		{$sql .= " and creq_status='$creq_status' "; }
#if ($creq_mobile!='') 		{$sql .= " and creq_mobile='$creq_mobile' "; }

// $sql = apply_filter($sql, $creq_message, $creq_message_filter,'creq_message');




if ($export=='1') { 
 	$arr_columns =array('creq_userid'=>'User Auto ID','creq_tempid'=>'Template ID','creq_mobile'=>'Mobile','creq_message'=>'Message','creq_response'=>'Response' ,'creq_externalId'=>'ExternalId','creq_couse'=>'Couse','creq_datetime'=>'Date','creq_type'=>'SMS Type' );
 	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}


$order_by == '' ? $order_by = 'paymentID' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";

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
    <td id="pageHead"><div id="txtPageHead">
       BTC Go url Payment History </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table width="698"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="4">Search</th>
          </tr>
                 
                   <tr>
                     <td align="right" class="tdLabel">Username  : </td>
                     <td><input name="u_username" type="text" value="<?=$u_username?>" /></td>
                     <td align="right">Mobile  :</td>
                     <td><input name="u_mobile" type="text" value="<?=$u_mobile?>" /></td>
                   </tr>
                   <tr>
                     <td align="right">Sent Date  From : </td>
                     <td><?=get_date_picker("datefrom", $datefrom)?></td>
                     <td align="right">Date to  To: </td>
                     <td><?=get_date_picker("dateto", $dateto)?></td>
                   </tr>
                  
                <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
            <td>&nbsp;</td>
            <td><input name="export" type="checkbox" id="export" value="1" />
SMS Sent List</td>
                </tr>
        </table>
      </form>
      <br />
     <? if(mysqli_num_rows($result)==0){?>
	 
      <div class="msg">Sorry, no records found.</div>
      <? } else{ ?>
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
			<th width="11%" height="25" >&nbsp;Payment ID</th>
			<th width="10%" >User Auto ID</th>
			<th width="10%" >Username</th>
			<th width="10%" >Order ID</th>
			<th width="10%" >Amount</th>
			<th width="19%" >Amount USD </th>
			<!--<th width="13%">Address</th>-->
			<th width="14%" >Tx ID</th>
 			<th width="10%" >Tx Date</th>
			<th width="10%" >Tx Confirmed </th>
			<th width="10%" >Tx Check Date</th>
			<th width="10%" >Processed </th>
			<th width="10%" >Processed Date </th>
		    <th width="10%" >Record Created</th>
          </tr>
          <?
		  while ($line_raw= mysqli_fetch_array($result)){ 
 	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	//if ($creq_userid!='') { $creq_advertiser = db_scalar("select CONCAT(u_username,':',u_mobile) from ngo_users where u_id = '$creq_userid'");}
?>
	<tr class="<?=$css?>">
		<td>&nbsp;<?=$line['paymentID'];?></td>
		
		<td><?=$line['userID'];?></td>
		<td nowrap="nowrap"><?=$line['u_username'];?> - <?=$line['u_fname'];?></td>
		<td><?=$line['orderID'];?></td>
		<td><?=$line['amount'];?></td>
 		<td><?=$line['amountUSD'];?></td>
	<!--	<td><?=$line['addr'];?></td>-->
		<td><?=$line['txID'];?></td>
		<td nowrap="nowrap"><?=date_format2($line['txDate']);?>  </td>
		<td><?=$line['txConfirmed'];?></td>
 		<td nowrap="nowrap"><?=date_format2($line['txCheckDate']);?>  </td>
		<td><?=$line['processed'];?></td>
		<td  nowrap="nowrap"><?=date_format2($line['processedDate']);?>  </td>
	 <td  nowrap="nowrap"><?=date_format2($line['recordCreated']);?>  </td>
	  
	</tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">              <input name="Paid" type="image" id="Activate" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_creq_ids[]')"/>
              <input name="Unpaid" type="image" id="Unpaid" src="images/buttons/unpaid.gif" onclick="return deactivateConfirmFromUser('arr_creq_ids[]')"/>
			   <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_creq_ids[]')"/> </td>
          </tr>
        </table> 
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
