<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
//print_r($_POST);
	$arr_topup_ids = $_REQUEST['arr_topup_ids'];
	if(is_array($arr_topup_ids)) {
		$str_topup_ids = implode(',', $arr_topup_ids);
		if(isset($_REQUEST['Submit_Recharge']) || isset($_REQUEST['Submit_Recharge_x']) ){
 			 $sql_update="update ngo_users_recharge set topup_rate='$topup_rate_recharge'  where  topup_plan='RECHARGE' and topup_id in ($str_topup_ids)";
 			 db_query($sql_update);
 		} elseif (isset($_REQUEST['Submit_Topup']) || isset($_REQUEST['Submit_Topup_x']) ){
		 	$sql_update="update ngo_users_recharge set topup_rate='$topup_rate_topup'  where topup_plan='TOPUP' and topup_id in ($str_topup_ids)";
 			db_query($sql_update);
 		} elseif (isset($_REQUEST['Send_Gift']) || isset($_REQUEST['Send_Gift_x']) ){
		 	 
			 
			/////////////////////////////////// 
		  	$sql_gen = "select * from ngo_users_recharge  where topup_id in ($str_topup_ids)";
 			$result_gen = db_query($sql_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
 			
			$gift_userid =db_scalar("select u_id from ngo_users  where u_username='$gift_username'")  ;
			$total_provided_amount = db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid ='$line_gen[topup_userid]' and gift_topupid='$line_gen[topup_id]'")+0;	  
			$balance_amount = $line_gen[topup_amount] - $total_provided_amount ;
			
			//print " $gift_username: $gift_userid =   $total_provided_amount =  $balance_amount =      ";
			if ($balance_amount >= $gift_amount) {
			
				if ($gift_userid!='') {
					$sql_insert="insert into ngo_users_gift set gift_userid = '$gift_userid' ,gift_by_userid='$line_gen[topup_userid]' ,gift_topupid='$line_gen[topup_id]' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 4 DAY),gift_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_status='New'";
					 db_query($sql_insert);
				}
			} else {
				$arr_error_msgs[] = "Error :Gift Amount is greater then user provide help balance amount, you can send maximum $balance_amount for this users";
				$_SESSION['arr_error_msgs'] = $arr_error_msgs;
			}
			}	 
			//////////////////////////////////////////////
			
			
			

		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
  }
}
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_id, u_username, u_fname ,u_address ,u_ref_userid, u_sponsor_id, u_mobile,u_status ,topup_id ,topup_serialno, topup_code,topup_plan ,topup_rate,topup_amount , topup_datetime ,topup_date ,topup_exp_date,topup_status ";
$sql = " from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id   ";

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
if ($id_in!='') {$sql .= " and topup_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}
if ($u_status!='') 			{$sql .= " and u_status='$u_status' "; }
if ($topup_id!='') 		{$sql .= " and topup_id='$topup_id' ";} 
//if ($topup_plan!='') 		{$sql .= " and topup_plan='$topup_plan' ";} 
if ($topup_amount!='') 		{$sql .= " and topup_amount='$topup_amount' ";} 
 
if ($topup_pay_status!='') 	{$sql .= " and topup_pay_status='$topup_pay_status' ";}
if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (topup_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  topup_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and topup_datetime between '$datefrom' AND '$dateto' "; }

if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 


$sql_export = $sql ."  order by ngo_users.u_id asc "; 
$sql_export_total = $sql ." group by ngo_users.u_id, topup_plan order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'topup_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'User ID','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile','u_status'=>'Status' ,'u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City','topup_date'=>'Topup Date' ,'topup_rate'=>'Rate','topup_amount'=>'Total Amount');
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 

 
if ($export_total=='1') {
 //
//,'((sum(topup_amount)/100)*5) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	$arr_columns =array( 'u_username'=>'User ID','u_fname'=>'Name','u_address'=>'Address' ,'u_mobile'=>'Mobile','u_status'=>'Status','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR'   ,'u_city'=>'City' ,'sum(topup_amount)as totalamount'=>'Total Amount'  );
	export_delimited_file($sql_export_total, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
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
          <td id="pageHead"><div id="txtPageHead"> Provide Help details List </div></td>
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
                  <td align="right">Status: </td>
                  <td><?=status_dropdown('u_status', $u_status)?></td>
                  <td width="20" align="right"><input name="export" type="checkbox" id="export" value="1" /></td>
                  <td width="163">   Details Topup list </td>
                </tr>
                <tr>
                  <td  align="right" valign="top">User ID </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right"><span class="tdLabel">Topup Amount:</span></td>
                  <td><input name="topup_amount" style="width:120px;"type="text" value="<?=$topup_amount?>" /></td>
                  <td align="right"> <input name="export_total" type="checkbox" id="export_total" value="1" />                  </td>
                  <td><!--Export Total Payout--> 
 Total  Topup List </td>
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
                  <td  align="right" valign="top">Downline - User ID </td>
                  <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
                  <td  align="right" valign="top">Topup ID </td>
                  <td><input name="topup_id" style="width:120px;"type="text" value="<?=$topup_id?>" /></td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle"><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                </tr>
              </table>
            </form>
			
			 <div class="msg"><? include("error_msgs.inc.php");?></div>
			
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
                  <th width="6%" > HelpID </th>
                  <th width="6%" >Auto UID</th>
				   <th width="6%" >User ID <?= sort_arrows('u_id')?></th>
                  
                   <th width="13%" >Name <?= sort_arrows('u_username')?></th>
                  <th width="6%" >City</th>
                  
				  <th width="9%" >Status</th>
				  <th width="9%" >Plan</th>
				  <!--<th width="9%" >Pin Sl </th>
                   <th width="9%" >Pin Code </th>-->
                   <th width="9%" >Rate </th>
                   <th width="8%" >Amount </th>
                   <th width="8%" > Amount +Bonus </th>
                   <th width="8%" >Status</th>
                   <th width="8%" >Request Date  <?= sort_arrows('topup_datetime')?></th>
                   <th width="8%" >Expire Date</th>
                  
                   <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th> 
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 $total_provided_amount = db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid ='$u_id' and gift_topupid='$topup_id'")+0;
	//if ($u_cheque=='self') { $u_cheque_to='self+'.$cheque_other_count;} else {$u_cheque_to=$u_cheque_other;}
	
 ?>
                <tr class="<?=$css?>">
                  <td nowrap="nowrap"><?=$topup_id?></td>
                  <td nowrap="nowrap"><?=$u_id?></td>
				  <td nowrap="nowrap"><?=$u_username?></td>
                   <td nowrap="nowrap"><?=$u_fname?> </td>
					<td nowrap="nowrap"><?=$u_city?></td>
					<td nowrap="nowrap"><?=$u_status?></td>
					<td nowrap="nowrap"><?=$topup_plan?></td>
					<!--<td nowrap="nowrap"><?=$topup_serialno?></td>
                  <td nowrap="nowrap"><?=$topup_code?></td>-->
                   <td nowrap="nowrap"><? echo $topup_rate+0;   echo " %";  ?> </td>
                   <td nowrap="nowrap"><?=$topup_amount?></td>
                   <td nowrap="nowrap"><?=$topup_amount2?></td>
                   <td nowrap="nowrap"><?=$topup_status?></td>
                   <td nowrap="nowrap"><?=$topup_date?></td>
                   <td nowrap="nowrap"><?=date_format2($topup_exp_date)?></td>
               
                 <td align="center"><input name="arr_topup_ids[]" type="checkbox" id="arr_topup_ids[]" value="<?=$topup_id?>"/></td> 
                </tr>
                <? }
?>
              </table>
            <table width="614" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                   
                  <td width="237" align="right" style="padding:2px">Username :  <input name="gift_username" type="text" value="<?=$gift_username?>" /></td>
				   <td width="237" align="right" style="padding:2px">Amount :  <input name="gift_amount" type="text" value="<?=$gift_amount?>" /></td>
                  <td width="86" align="right" style="padding:2px"><input name="Send_Gift" type="image" id="Send_Gift" src="images/buttons/submit.gif" onclick="return  updateConfirmFromUser('arr_topup_ids[]')"/>                  </td>
                </tr>
              </table> 
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
