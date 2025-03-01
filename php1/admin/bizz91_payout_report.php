<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;


 


$columns = "select * ";
$sql = " from ngo_bizz91_log  where  1 ";
 
if ($biz_status!='') 		{$sql .= " and biz_status='$biz_status' "; }
if ($biz_amount!='') 		{$sql .= " and biz_amount='$biz_amount' ";} 
if ($biz_utr!='') 		  {$sql .= " and biz_utr='$biz_utr' ";} 

if (($user_id_from!='') && ($user_id_to!='')) 		  {$sql .= " and (biz_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  biz_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				        {$sql .= " and  biz_datetime between '$datefrom' AND '$dateto' "; }

///if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 


#$sql_export = $sql ."  order by ngo_users.u_id asc "; 
#$sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'biz_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'biz_id'=>'Auto ID' , 'biz_utr'=>'Txn No' ,'biz_amount'=>' Amount','	pay_mod'=>'Mode'  ,'pay_stbiz_statusatus'=>'Status','biz_datetime'=>'Deposit Date' );

export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

///$sql = "insert into ngo_bizz91_log set  biz_userid='$u_id' ,biz_status='$biz_status',	biz_respons_code='$biz_respons_code',biz_url_id='$biz_url_id',biz_utr='$biz_utr',biz_txnrefid='$biz_txnrefid',biz_response='$biz_response',	biz_pay_id='$pay_id' , biz_datetime =ADDDATE(now(),INTERVAL 630 MINUTE)";
		
$sql 	.= "limit $start, $pagesize ";
$sql 	= $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Payment Deposit details </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="676"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="6">Search</th>
                </tr>
                <tr>
                  <td width="118" align="right" class="tdLabel">Auto ID . From: </td>
                  <td width="131"><input name="user_id_from" type="text"style="width:50px;" value="<?=$user_id_from?>" />
                    <input name="user_id_to" style="width:50px;"type="text" value="<?=$user_id_to?>" /></td>
                  <td align="right">Paid/Unpaid: </td>
                  <td><?=payment_status_dropdown('pay_status',$creq_status);?></td>
                  <td width="20" align="right"><input name="export" type="checkbox" id="export" value="1" /></td>
                  <td width="163">   Deposit list </td>
                </tr>
                <tr>
                  <td  align="right" valign="top">UTR/Txn No </td>
                  <td>
                   <input name="pay_txnno"style="width:120px;" type="text" value="<?=$pay_txnno?>" />  </td>
                  <td align="right"><span class="tdLabel">Deposit Amount:</span></td>
                  <td><input name="pay_amount" style="width:120px;"type="text" value="<?=$pay_amount?>" /></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                
                <tr>
                  <td align="right">  Date from: </td>
                  <td><?=get_date_picker("datefrom", $datefrom)?></td>
                  <td  align="right" valign="top"> Date To: </td>
                  <td><?=get_date_picker("dateto", $dateto)?></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              
                <tr>
                  <td  align="right" valign="top"><!--Downline - Username --></td>
                  <td><!-- <input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /> --> </td>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle"><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                </tr>
              </table>
			  
            </form>
			<div align="right"><!--<a href="recharge_topup_add.php">Add New Investment</a>-->
            <? if(mysqli_num_rows($result)==0){?>
            <div class="msg">Sorry, no records found.</div>
            <? } else{ 
 	  ?> 	<!-- | <a href="recharge_topup_auto.php">Auto Recharge/Topup</a>--> </div>
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
				<th width="5%" height="25" >&nbsp;Auto No </th>
        <th width="11%" height="25" >&nbsp;UserID </th>
        <th width="11%" height="25" >&nbsp;Status </th>
        <th width="11%" height="25" >&nbsp;Response Code </th>
        <th width="11%" height="25" >&nbsp;URL ID </th>
        <th width="11%" height="25" >&nbsp;UTR No </th>
        <th width="11%" height="25" >&nbsp;TxnRefID </th>
        <th width="11%" height="25" >&nbsp;Response</th>
        <th width="11%" height="25" >&nbsp;Amount </th>
				<th width="11%" height="25" >&nbsp;Pay ID</th>
				<th width="10%" >Date</th>
				<th width="2%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th> 
			</tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
  @extract($line);
  $page_total += $line['pay_amount'];
  $css = ($line['pay_status']=='New')?'td_red':'td_green';
 
		 
//$sql = "insert into ngo_bizz91_log set  biz_userid='$u_id' ,biz_status='$biz_status',	biz_respons_code='$biz_respons_code',biz_url_id='$biz_url_id',biz_utr='$biz_utr',biz_txnrefid='$biz_txnrefid',biz_response='$biz_response',biz_amount='$imps_amount',	biz_pay_id='$pay_id' , biz_datetime =ADDDATE(now(),INTERVAL 630 MINUTE)";
 

    ?>
          <tr class="<?=$css?>">
          <td><?=$line['biz_id'];?></td>
				  <td> <?=db_scalar("select   CONCAT(u_username ,' = ', u_fname)  from ngo_users where u_id = '$biz_userid'");?>  </td>
        <td><?=$line['biz_status'];?> </td>
        <td><?=$line['biz_respons_code'];?> </td>
        <td><?=$line['biz_url_id'];?> </td>
        <td><?=$line['biz_utr'];?> </td>
        <td><?=$line['biz_txnrefid'];?> </td>
        <td><?=$line['biz_response'];?> </td>
        <td><?=$line['biz_amount'];?> </td>
        <td><?=$line['pay_id'];?> </td>
        <td><?=datetime_format($line['biz_datetime']);?> </td>




				<td><?=datetime_format($line['pay_date']);?>  </td>
 			    <td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$line['pay_id'];?>"/></td> 
                </tr>
                <? }
?>
              </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
				 <td width="19%" align="right" style="padding:2px"> Page Total Amount :  </td>
                  <td width="20%" align="right" style="padding:2px">         <h2><?=$page_total;?> </h2>          </td>
			      <td width="22%" align="right" style="padding:2px"> </td>
			      <td width="34%" align="right" style="padding:2px"> </td>
            
				  <td width="8%" align="right" style="padding:2px"> 
				  <input name="Payment_Paid" type="image" id="Payment_Paid" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>                  </td>
				   <td width="8%" align="right" style="padding:2px"><input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>                  </td>
				 
				   
                </tr>
              </table> 
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
