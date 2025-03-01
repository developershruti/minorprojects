<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
#print_r($_POST);
	$arr_creq_ids = $_REQUEST['arr_creq_ids'];
	if(is_array($arr_creq_ids)) {
		$str_creq_ids = implode(',', $arr_creq_ids);
		
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
 		 		#$gift_tr_receipt =  db_scalar("select gift_tr_receipt from ngo_users_gift where gift_id in ($str_gift_ids) ")  ;
				#@unlink(UP_FILES_FS_PATH.'/profile/'.$gift_tr_receipt);
 				#$sql_update="update ngo_users_gift set gift_tr_receipt='',gift_status='New'  where gift_id in ($str_gift_ids) ";
				#db_query($sql_update);
	  //gift_status='New' and
 			 $sql = "delete from ngo_deposit_req where creq_id in ($str_creq_ids)";
			 db_query($sql);
 		}
		
		else if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			$sql_update="update ngo_deposit_req set creq_status='Paid'  where creq_id in ($str_creq_ids)";
			db_query($sql_update);
  		}else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_deposit_req set creq_status='Unpaid' where creq_id in ($str_creq_ids)";
			db_query($sql_update);
		 
   		 
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 
	}
}
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select * ";
$sql = " from ngo_deposit_req ,ngo_users  where ngo_deposit_req.creq_userid=ngo_users.u_id ";

// and u_status!='Banned'
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
if ($id_in!='') {$sql .= " and creq_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}
if ($creq_status!='') 		{$sql .= " and creq_status='$creq_status' "; }
if ($creq_amount!='') 		{$sql .= " and creq_amount='$creq_amount' ";} 
 
if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (creq_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  creq_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and  creq_date between '$datefrom' AND '$dateto' "; }

if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 


$sql_export = $sql ."  order by ngo_users.u_id asc "; 
$sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'creq_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'Username','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile','u_city'=>'City', 'creq_bank'=>'Bank Name' ,'creq_bank_branch'=>' Branch','creq_amount'=>'Amount'  ,'creq_status'=>'Status','creq_date'=>'Deposit Date' );
 
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
                  <td><?=payment_status_dropdown('creq_status',$creq_status);?></td>
                  <td width="20" align="right"><input name="export" type="checkbox" id="export" value="1" /></td>
                  <td width="163">   Deposit list </td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Username </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right"><span class="tdLabel">Deposit Amount:</span></td>
                  <td><input name="creq_amount" style="width:120px;"type="text" value="<?=$creq_amount?>" /></td>
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
                  <td  align="right" valign="top">Downline - Username </td>
                  <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
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
				<th width="5%" height="25" >&nbsp;Req-No </th>
				<th width="11%" height="25" >&nbsp;UserID </th>
				<th width="11%" height="25" >&nbsp;Name </th>
				<th width="11%" height="25" >&nbsp;City </th>
				<th width="19%" height="25" >Date </th>
                  <th width="13%" >Request Type</th>
                <th width="14%" >Amount</th>
			    <!--<th width="14%" >USDT Amount</th>-->
				<th width="14%" >Txn No.</th>
 				 <th width="16%" >Status</th>
				<th width="10%" > </th>
				<th width="2%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th> 
			</tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
    ?>
                <tr class="<?=$css?>">
                  <td><?=$line['creq_id'];?></td>
				  <td><?=$line['u_username'];?></td>
				  <td><?=$line['u_fname'];?></td>
				  <td><?=$line['u_city'];?></td>
				 <td><?=date_format2($line['creq_date']);?>  </td>
 				 <td><?=$line['creq_type'];?></td>
 				<td><?=price_format($line['creq_amount']);?> </td>
				
				<?php /*?><td><? if($line['creq_type']=='Crypto'){ ?>$ <?=($line['creq_amount_usdt']);?><? } ?> </td><?php */?>
				<td><?=($line['creq_remark']);?> </td>
  				<td><? if($line['creq_status']=='New Request'){ ?> Pending <? } else if($line['creq_status']=='Unpaid'){  ?>Rejected<? } else if($line['creq_status']=='Paid'){  ?>Approved<? }   ?></td>
 				<td><a href="<?=UP_FILES_WS_PATH.'/receipt/'.$line['creq_receipt']?>" target="_blank">View Slip</a></td>
                  <td align="center"><input name="arr_creq_ids[]" type="checkbox" id="arr_creq_ids[]" value="<?=$line['creq_id'];?>"/></td> 
                </tr>
                <? }
?>
              </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
				 <td width="19%" align="right" style="padding:2px">  </td>
                  <td width="9%" align="right" style="padding:2px">                    </td>
			      <td width="22%" align="right" style="padding:2px"><!-- Paid date:
			        <? //=get_date_picker("pay_transfer_date", date("Y-m-d"))?>--></td>
			      <td width="34%" align="right" style="padding:2px">  
			      </td>
				  <td width="8%" align="right" style="padding:2px"> 
				  <input name="Payment_Paid" type="image" id="Payment_Paid" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_creq_ids[]')"/>                  </td>
				   <td width="8%" align="right" style="padding:2px"><input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_creq_ids[]')"/>                  </td>
				   
				   
                </tr>
              </table> 
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
