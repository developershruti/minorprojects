<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
//print_r($_POST);
	$arr_topup_ids = $_REQUEST['arr_topup_ids'];
	if(is_array($arr_topup_ids)) {
		$str_topup_ids = implode(',', $arr_topup_ids);
		if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ){
 			   $sql_update="update ngo_users_recharge set topup_pay_status='Paid',topup_paydate=ADDDATE(now(),INTERVAL 750 MINUTE) where topup_id in ($str_topup_ids)";
 			 db_query($sql_update);
 		}
 	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
  }
}
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_id, u_fname, u_lname ,u_address ,u_cheque ,topup_id ,topup_serialno ,topup_code ,topup_plan ,topup_amount ,topup_date,topup_datetime ";
$sql = " from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id and u_status!='Banned'";


/// downline payout list of a user
if ($u_downline!=''){
	
$id = array();
$id[]=$u_downline;
while ($sb!='stop'){
if ($referid=='') {$referid=$u_downline;}
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
if ($id_in!='') {$sql .= " and u_id in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
 }
	/// downline payout list of a user
///if ($close_id!='') 			{$sql .= " and u_closeid='$close_id' ";}	

 
if ($topup_pay_status!='') 	{$sql .= " and topup_pay_status='$topup_pay_status' ";}
if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (topup_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  topup_userid ='$user_id_from' ";}

if (($datefrom!='') && ($dateto!='')){ $sql .= " and topup_datetime between '$datefrom' AND '$dateto' "; }


$sql_export = $sql ." group by ngo_users.u_id, topup_for order by ngo_users.u_id asc"; 
$sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'u_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
   	$arr_columns =array('u_username'=>'User ID','u_id'=>'User ID','u_fname'=>'First Name','u_lname'=>'Last Name','u_address'=>'Address','u_ref_userid'=>'Referer ID','u_mobile'=>'Mobile','u_date'=>'DOJ','topup_for'=>'Payout For','sum(topup_amount)as totalamount'=>'Total Amount','((sum(topup_amount)/100)*10.3) as tds'=>'TDS','((sum(topup_amount)/100)* 7.7) as Handlingcharge'=>'Handling Charge' ,'(sum(topup_amount)-((sum(topup_amount)/100)* 18)) as netamount'=>'Net Amount' );
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 
if ($export_total=='1') {
//,'((sum(topup_amount)/100)*5) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	$arr_columns =array('u_username'=>'User ID','u_id'=>'User ID','u_fname'=>'First Name','u_lname'=>'Last Name','u_address'=>'Address','u_mobile'=>'Mobile' ,'sum(topup_amount)as totalamount'=>'Total Amount','((sum(topup_amount)/100)*10.3) as tds'=>'TDS','((sum(topup_amount)/100)*9.7) as Othercharge'=>'Other Charge' ,'(sum(topup_amount)-((sum(topup_amount)/100)*20)) as netamount'=>'Net Amount' );
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
          <td id="pageHead"><div id="txtPageHead"> Incentive Recharge Details </div></td>
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
                  <td width="131"><input name="user_id_from"style="width:120px;" type="text" value="<?=$user_id_from?>" />                  </td>
                  <td width="91" align="right"><span class="tdLabel">Auto</span> ID . To:</td>
                  <td width="127"><input name="user_id_to" style="width:120px;"type="text" value="<?=$user_id_to?>" />                  </td>
                  <td width="20" align="right"><input name="export" type="checkbox" id="export" value="1" /></td>
                  <td width="163"> Export Individual incentive</td>
                </tr>
                <tr>
                  <td align="right" class="tdLabel"> Username:: </td>
                  <td>&nbsp;</td>
                  <td align="right">Recharge Welth : </td>
                  <td><?
		$sql ="select utype_id , utype_name from ngo_users_type where utype_value>0 order by utype_id";  
		echo make_dropdown($sql, 'u_utype', $u_utype,  'class="txtbox"  style="width:120px;"','--select--');
		?></td>
                  <td align="right"><input name="export_total" type="checkbox" id="export_total" value="1" /></td>
                  <td>Export Total Incentive </td>
                </tr>
                <tr>
                  <td align="right">Downline to  User ID:</td>
                  <td><input name="u_downline" style="width:120px;"type="text" value="<?=$u_downline?>" />                  </td>
                  <td align="right">Pay Status: </td>
                  <td valign="middle"><select name="topup_pay_status">
                      <option value="" <? if ($topup_pay_status=='') {echo 'selected="selected"';}?> >All</option>
                      <option value="Unpaid" <? if ($topup_pay_status=='Unpaid') {echo 'selected="selected"';}?>>Unpaid</option>
                      <option value="Paid" <? if ($topup_pay_status=='Paid') {echo 'selected="selected"';}?>>Paid</option>
                    </select></td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle">&nbsp;</td>
                </tr>
                <tr>
                  <td align="right">Incentive Type: </td>
                  <td><?
			echo array_dropdown( $ARR_SUPP_PAYMENT_TYPE, $topup_for,'topup_for', 'class="txtbox"  style="width:120px;"','--select--');
			?></td>
                  <td align="right"> </td>
                  <td> </td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="right">Incentive Date from: </td>
                  <td><?=get_date_picker("datefrom", $datefrom)?></td>
                  <td width="91"  align="right" valign="top"> Incentive Date To: </td>
                  <td><?=get_date_picker("dateto", $dateto)?></td>
                  <td align="right">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <input type="hidden" name="u_id" value="<?=$u_id?>"/>
                </tr>
                <tr>
                  <td colspan="6" height="10"></td>
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
                  <th width="6%" >Auto ID </th>
                  <th width="6%" >User ID</th>
                  <th width="9%" >Name
                    <?= sort_arrows('u_username')?></th>
                  <th width="14%" >Address</th>
                  <th width="7%" >PO No.</th>
                  <th width="5%" >Referer</th>
                  <th width="9%" >Payment for</th>
                  <th width="5%">Pay QTY</th>
                  <th width="8%" >Amount </th>
                  <th width="8%" >Pay Status</th>
                  <th width="13%" >Dated</th>
                  <th width="8%" >Payment Dated</th>
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
                  <td nowrap="nowrap">&nbsp;</td>
                  <td nowrap="nowrap"><?=$u_id?></td>
                  <td nowrap="nowrap"><?=$u_fname." ".$u_lname?>                  </td>
                  <td ><?=$u_address?></td>
                  <td nowrap="nowrap"><?=$topup_pono?></td>
                  <td nowrap="nowrap"><?=$topup_refid?></td>
                  <td nowrap="nowrap"><? if ($topup_for=='Sponsoring') { echo $topup_for." ".$topup_sponsor_level;} else { echo $topup_for;}?></td>
                  <td nowrap="nowrap"><?=$topup_qty?></td>
                  <td nowrap="nowrap"><?=$topup_amount?></td>
                  <td nowrap="nowrap"><?=$topup_pay_status?></td>
                  <td nowrap="nowrap"><?=date_format2($topup_datetime)?></td>
                  <td nowrap="nowrap"><?=date_format2($topup_paydate)?></td>
                  <td align="center"><input name="arr_topup_ids[]" type="checkbox" id="arr_topup_ids[]" value="<?=$topup_id?>"/></td>
                </tr>
                <? }
?>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right" style="padding:2px"><input name="Submit" type="image" id="Submit" src="images/buttons/submit.gif" onclick="return paidConfirmFromUser('arr_topup_ids[]')"/>
                  </td>
                </tr>
              </table>
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
