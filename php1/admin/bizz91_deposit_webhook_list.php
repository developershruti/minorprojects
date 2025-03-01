<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
#print_r($_POST);
	$arr_pay_ids = $_REQUEST['arr_pay_ids'];
	if(is_array($arr_pay_ids)) {
		$str_pay_ids = implode(',', $arr_pay_ids);
		
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
 		 		#$gift_tr_receipt =  db_scalar("select gift_tr_receipt from ngo_users_gift where gift_id in ($str_gift_ids) ")  ;
				#@unlink(UP_FILES_FS_PATH.'/profile/'.$gift_tr_receipt);
 				#$sql_update="update ngo_users_gift set gift_tr_receipt='',gift_status='New'  where gift_id in ($str_gift_ids) ";
				#db_query($sql_update);
	  //gift_status='New' and
 			 $sql = "delete from ngo_deposit_req where pay_id in ($str_pay_ids)";
			 db_query($sql);
 		}
		
		else if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			$sql_update="update ngo_users_getway set pay_status='Paid'  where pay_id in ($str_pay_ids)";
			db_query($sql_update);
  		}else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_users_getway set pay_status='Unpaid' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
		 
   		 
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 
	}
}
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select * ";
$sql = " from ngo_users_getway  where  1 ";

// and u_status!='Banned'
/// downline payout list of a user
if ($u_sponsor_id!=''){
$u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_sponsor_id'");
$id = array();
$id[]=$u_userid;
while ($sb!='stop'){
if ($referid=='') {$referid=$u_userid;}
$sql_test = "select u_id  from ngo_users  where  u_ref_userid in ($referid)  ";
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
if ($pay_status!='') 		{$sql .= " and pay_status='$pay_status' "; }
if ($pay_amount!='') 		{$sql .= " and pay_amount='$pay_amount' ";} 
if ($pay_txnno!='') 		{$sql .= " and pay_txnno='$pay_txnno' ";} 


if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (creq_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  creq_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and  pay_date between '$datefrom' AND '$dateto' "; }

///if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 


#$sql_export = $sql ."  order by ngo_users.u_id asc "; 
#$sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'pay_id'=>'Auto ID' , 'pay_txnno'=>'Txn No' ,'pay_amount'=>' Amount','	pay_mod'=>'Mode'  ,'pay_status'=>'Status','pay_date'=>'Deposit Date' );

export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

  
 
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
				<th width="11%" height="25" >&nbsp;UTR/Tax No </th>
				<th width="11%" height="25" >&nbsp;Amount </th>
				<th width="11%" height="25" >Mode</th>
				<th width="10%">Satus</th>
				<th width="10%" >Date</th>
	 
				<th width="2%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th> 
			</tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
  @extract($line);
  $page_total += $line['pay_amount'];
  $css = ($line['pay_status']=='New')?'td_red':'td_green';
    ?>
          <tr class="<?=$css?>">
          <td><?=$line['pay_id'];?></td>
				  <td> <?=db_scalar("select   CONCAT(u_username ,' = ', u_fname)  from ngo_users where u_id = '$pay_userid'");?>  </td>
				  <td><?=$line['pay_txnno'];?></td>
				  <td><?=$line['pay_amount'];?></td>
				 <td><?=$line['pay_mod'];?></td>
				<td><?=$line['pay_status'];?> </td>
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
