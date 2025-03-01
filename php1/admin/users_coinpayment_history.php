<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
	$arr_pay_ids = $_REQUEST['arr_pay_ids'];
	if(is_array($arr_pay_ids)) {
		$str_pay_ids = implode(',', $arr_pay_ids);
		if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			$sql_update="update ngo_coinpayment set pay_status='Paid',pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE(now(),INTERVAL 630 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
		}else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_coinpayment set pay_status='Unpaid',pay_transaction_no='',pay_transfer_date='',pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
	
	}
}

}



$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select u_username,u_fname, u_city,u_id,u_ref_userid,u_bank_register,ngo_coinpayment.*  ";
$sql = " from ngo_users,ngo_coinpayment where  u_id=pay_userid and u_status='Active'";
///if ($pay_plan!='') 		{$sql .= " and pay_plan='$pay_plan' ";} 
if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";}
if ($pay_group!='') 		{$sql .= " and pay_group='$pay_group' ";}
if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (pay_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  pay_status ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
if (($datefrom2!='') && ($dateto2!='')){ $sql .= " and pay_transfer_date between '$datefrom2' AND '$dateto2' "; }
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($pay_ipntype!='') 		{$sql .= " and pay_ipntype='$pay_ipntype' ";}
if ($pay_for!='') 			{$sql .= " and pay_for like '%$pay_for%' ";}
if ($u_fname!='') 			{$sql .= " and u_fname like '%$u_fname%' ";}
if ($pay_status!='') 		{$sql .= " and pay_status='$pay_status' ";}
if ($pay_trnid!='') 		{$sql .= " and pay_trnid like '%$pay_trnid%' ";}

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
    <td id="pageHead"><div id="txtPageHead"> 8G Pay Gateway History</div></td>
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
            <td  align="right" valign="top">Name </td>
            <td><input name="u_fname"style="width:120px;" type="text" value="<?=$u_fname?>" /></td>
            <td width="96" align="right">Group : </td>
            <td width="161"><?



			echo array_dropdown( $ARR_CURRENCY_GROUP, $pay_group,'pay_group', 'class="txtbox"  style="width:120px;"','--select--');



			?></td>
          </tr>
          <tr>
            <td width="118" align="right" class="tdLabel">Auto ID . From/To: </td>
            <td width="131"><input name="user_id_from"style="width:50px;" type="text" value="<?=$user_id_from?>" />
              <input name="user_id_to" style="width:50px;"type="text" value="<?=$user_id_to?>" /></td>
            <td width="90" align="right">Txn ID : </td>
            <td width="128"><input name="pay_trnid"style="width:120px;" type="text" value="<?=$pay_trnid?>" />            </td>
            <td align="right">Portal : </td>
            <td><input name="pay_ipntype"style="width:120px;" type="text" value="<?=$pay_ipntype?>" /></td>
          </tr>
          <tr>
            <td align="right"> Payment Date from: </td>
            <td><?=get_date_picker("datefrom", $datefrom)?></td>
            <td  align="right" valign="top"> Payment Date To: </td>
            <td><?=get_date_picker("dateto", $dateto)?></td>
            <td align="right" valign="middle">Paid/Unpaid : </td>
            <td valign="middle"><input name="pay_status"style="width:120px;" type="text" value="<?=$pay_status?>" /></td>
          </tr>
          <tr>
            <td align="right">Downline - Username </td>
            <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
            <td  align="right" valign="top">&nbsp; </td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
            <td align="right" valign="middle"><!--<input name="export" type="checkbox" id="export" value="1" />--></td>
            <td valign="middle"><!--Export Details List--> </td>
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
            <th width="2%" >ID</th>
            <th width="5%" >Username</th>
            <th width="10%" >Name </th>
            <th width="4%" >Pay ID </th>
            <th width="4%" >Group</th>
            <th width="4%" >Portal</th>
            <th width="4%" >Ref Amt 1</th>
            <th width="4%" >Ref Amt 2 </th>
            <th width="3%" >Rate</th>
            <th width="7%" >Amount </th>
            <th width="6%" >Payment Date </th>
            <th width="3%" >Txn ID</th>
            <th width="3%" >Txn Date</th>
            <th width="4%">Status 1</th>
            <th width="4%">Status 2</th>
            <th width="1%"></th>
            <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';

 ?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$u_id?></td>
            <td nowrap="nowrap"><?=$u_username?></td>
            <td nowrap="nowrap"><?=$u_fname?></td>
            <td nowrap="nowrap"><?=$pay_id?></td>
            <td nowrap="nowrap"><?=$pay_group?></td>
            <td nowrap="nowrap"><?=$pay_ipntype?></td>
            <td nowrap="nowrap"><?=$pay_currency1?>
              <?=($pay_ref_amt1)?></td>
            <td nowrap="nowrap"><?=$pay_currency2?>
              <?=($pay_ref_amt2)?></td>
            <td nowrap="nowrap"><?=$pay_rate?>
            </td>
            <td nowrap="nowrap"><?=price_format($pay_amount)?></td>
            <td nowrap="nowrap"><?=date_format2($pay_date)?></td>
            <td nowrap="nowrap"><?=$pay_trnid?></td>
            <td nowrap="nowrap"><?=date_format2($pay_txn_date)?></td>
            <td align="center"><a title="<?=$pay_transaction_no?>" href="#">
              <?=$pay_status?>
              </a></td>
            <td align="center"><a title="<?=$pay_transaction_no?>" href="#">
              <?=$pay_status_text?>
              </a></td>
            <td nowrap="nowrap"><?=$pay_admin?></td>
            <td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$pay_id?>"/></td>
          </tr>
          <? }



?>
        </table>
      </form>
      <? }?>
      <? include("paging.inc.php");?>
    </td>
  </tr>
</table>
<? include("bottom.inc.php");?>
