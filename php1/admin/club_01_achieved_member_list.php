<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
//print_r($_POST);
	$arr_topup_ids = $_REQUEST['arr_topup_ids'];
	if(is_array($arr_topup_ids)) {
		$str_topup_ids = implode(',', $arr_topup_ids);
		if(isset($_REQUEST['Submit_Recharge']) || isset($_REQUEST['Submit_Recharge_x']) ){
 			 /*$sql_update="update ngo_users_recharge set topup_rate='$topup_rate_recharge'  where  topup_plan='RECHARGE' and topup_id in ($str_topup_ids)";
 			 db_query($sql_update);*/
 
  /////////////////////////////
 /// @extract ($_SESSION[post]);
  @extract ($_POST);
  $arr_error_msgs = array();
  if($pay_amount=='') {   $arr_error_msgs[] = "Please Enter Club Achieved Amount"; 
	} else if ($pay_group=='') {  $arr_error_msgs[] = "Please Select Club Income Type";
	} else if ($pay_plan_level=='') {  $arr_error_msgs[] = "Please Select Pay Level";
	} else if ($payment_date=='') {  $arr_error_msgs[] = "Please Choose Payment For Date "; }
 	 
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//check if there is no error
  if (count($arr_error_msgs) ==0) {


$sql_test = "select u_id,u_username,topup_id,topup_userid,topup_amount,topup_status,topup_date from  ngo_users,ngo_users_recharge  where topup_userid=u_id  and topup_id in ($str_topup_ids)   ";
 $result_test = db_query($sql_test);
 $mobile = array();
 while ($line_test= mysqli_fetch_array($result_test)){
 @extract($line_test);
if ($u_id!='' && $topup_amount>0 ) { 
  
     $payout_count = db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$topup_userid' and pay_plan_level='$pay_plan_level' and pay_plan='$pay_group' and pay_group='$pay_group' and pay_date='$payment_date'  ")+0;
 	if ($pay_plan_level==1) { $topup_required = 35;}
	else if ($pay_plan_level==2) { $topup_required = 35;}
	else if ($pay_plan_level==3) { $topup_required = 35;}
	else if ($pay_plan_level==4) { $topup_required = 35;}
	else if ($pay_plan_level==5) { $topup_required = 35;}
	else if ($pay_plan_level==6) { $topup_required = 35;}
	else if ($pay_plan_level==7) { $topup_required = 35;}
	else if ($pay_plan_level==8) { $topup_required = 35;}
    // print "select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and topup_amount='$topup_required' ";
	///echo "<br/>";
	  $topup_amount_active_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and topup_amount='$topup_required' ")+0;	
   /* if ($topup_amount_active_count==0) {
	  $arr_error_msgs[] = "This user account must be upgrade with $topup_required amount ";
    } */
	 
$pay_amount = $pay_amount;  ///form amount 
$pay_rate=100;
///$pay_group = "CW";
$pay_drcr = 'Cr';
if ($pay_amount>0 && $topup_amount_active_count>0) {
 if ($payout_count==0) {
			$msg.= $u_id.' ,';
 			$u_parent_id = db_scalar("select pay_id from ngo_users_payment  order by pay_id desc limit 0,1")+1;
			$pay_id_refno =  'R'.rand(100,999).$u_parent_id.rand(100,999);
			$pay_for =   $ARR_CLUB_GROUP[$pay_group];
			$sql22 = "insert into ngo_users_payment set  pay_id_refno='$pay_id_refno',  pay_drcr='$pay_drcr',  pay_userid = '$topup_userid'  ,pay_group='$pay_group',pay_plan='$pay_group',pay_plan_level='$pay_plan_level' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = 'F' ,pay_rate = '100', pay_amount = '$pay_amount',pay_status='Unpaid' ,pay_date='$payment_date' ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE) ";
			$result = db_query($sql22);
			$arr_error_msgs[] = "$pay_group Club Income of level $pay_plan_level, Sent Successfully To, Auto Id : $topup_userid , Username : $u_username";
			$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		  }
		 }
		}	

	
}	
 } 


 ///////////////////////// 
 			 
		} elseif (isset($_REQUEST['Submit_direct_club']) || isset($_REQUEST['Submit_direct_club_x']) ){
	 
$sql_test = "select u_id,u_username,topup_id,topup_userid,topup_amount,topup_status,topup_date from  ngo_users,ngo_users_recharge  where topup_userid=u_id  and topup_id in ($str_topup_ids)   ";
 $result_test = db_query($sql_test);
 $mobile = array();
 while ($line_test= mysqli_fetch_array($result_test)){
 @extract($line_test);
if ($u_id!='' && $topup_amount>0 ) { 
  
     $payout_count = db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$topup_userid' and pay_plan_level='$pay_plan_level' and pay_plan='$pay_group' and pay_group='$pay_group' and pay_date='$payment_date'  ")+0;
  	$topup_required = 35;
 	  $topup_amount_active_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and topup_amount='$topup_required' ")+0;	
   $pay_drcr = 'Cr';
if ($pay_amount>0 && $topup_amount_active_count>0) {
 if ($payout_count==0) {
			$msg.= $u_id.' ,';
 			$u_parent_id = db_scalar("select pay_id from ngo_users_payment  order by pay_id desc limit 0,1")+1;
			$pay_id_refno =  'R'.rand(100,999).$u_parent_id.rand(100,999);
			$pay_for =   $ARR_CLUB_GROUP[$pay_group];
			$sql22 = "insert into ngo_users_payment set  pay_id_refno='$pay_id_refno',  pay_drcr='$pay_drcr',  pay_userid = '$topup_userid'  ,pay_group='$pay_group',pay_plan='$pay_group',pay_plan_level='$pay_plan_level' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = 'F' ,pay_rate = '100', pay_amount = '$pay_amount',pay_status='Unpaid' ,pay_date='$payment_date' ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE) ";
			$result = db_query($sql22);
			$arr_error_msgs[] = "$pay_group Club Income of level $pay_plan_level, Sent Successfully To, Auto Id : $topup_userid , Username : $u_username";
			$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		  }
		 }
		}	
  } 

			 
 		} elseif (isset($_REQUEST['Submit_Topup']) || isset($_REQUEST['Submit_Topup_x']) ){
			$topup_date =db_scalar("select ADDDATE('$topup_date_new',INTERVAL 30870 MINUTE)"); 
		 	#$sql_update="update ngo_users_recharge set topup_datetime='$topup_date_new',topup_date='$topup_date' where topup_id in ($str_topup_ids)";
 			#db_query($sql_update);
		}
 	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
  }
}
 
/*$start = intval($start);
///$pagesize = 200;
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
*/

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;


$columns = "select u_id,  u_username, u_fname ,u_address  ,u_email,u_mobile ,u_ref_userid, u_sponsor_id, u_mobile,u_status, u_city,u_state , member_on_level_1, member_on_level_2, member_on_level_3, member_on_level_4, member_on_level_5, member_on_level_6, member_on_level_7, member_on_level_8 ,topup_id,topup_by_userid ,topup_serialno, topup_code,topup_plan,topup_group,topup_days_for ,topup_rate,topup_amount , topup_datetime ,topup_date ,topup_status ";
$sql = " from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id  and topup_amount='35.00' and u_status='Active'  ";

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
 			$id[]=$line_test['u_id'];
			$refid[]=$line_test['u_id'];
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
if ($u_city!='') 			{$sql .= " and u_city='$u_city' "; }
if ($u_state!='') 			{$sql .= " and u_status='$u_status' "; }
if ($topup_status!='') 			{$sql .= " and topup_status='$topup_status' "; }

////filter Level Wise List

if ($level==1 || $level=='') 			{$sql .= " and member_on_level_1>=6  "; $level=1; }
if ($level==2) 			{$sql .= " and member_on_level_2 >=16  "; }
if ($level==3) 			{$sql .= " and member_on_level_3 >=64 "; }
if ($level==4) 			{$sql .= " and member_on_level_4>=256 "; }
if ($level==5) 			{$sql .= " and member_on_level_5>=1024 "; }
if ($level==6) 			{$sql .= " and member_on_level_6>=4096 "; }
if ($level==7) 			{$sql .= " and member_on_level_7>=16384 "; }
if ($level==8) 			{$sql .= " and member_on_level_8>=32768 "; }
///if ($level==9) 			{$sql .= " and member_on_level_9>=4 "; }
 



if ($topup_id!='') 		{$sql .= " and topup_id='$topup_id' ";} 
if ($topup_plan!='') 		{$sql .= " and topup_plan='$topup_plan' ";} 
if ($topup_amount!='') 		{$sql .= " and topup_amount='$topup_amount' ";} 
//if ($topup_type!='') 		{$sql .= " and topup_type='$topup_type' ";} 
if ($topup_pay_status!='') 	{$sql .= " and topup_pay_status='$topup_pay_status' ";}
if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (topup_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  topup_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and  topup_datetime between '$datefrom' AND '$dateto' "; }

if ($u_username!='') 		{$sql .= " and u_username='$u_username'  ";} 
///$sql .= " group by topup_userid ";

$sql_export = $sql ."  order by ngo_users.u_id asc "; 
$sql_export_total = $sql ." group by ngo_users.u_id, topup_plan order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'topup_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2      ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   //	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'Username','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile' ,'u_email'=>'Email'  ,'u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC' ,'topup_rate'=>'Rate','topup_amount'=>'Total Amount','topup_date'=>'ROI Date','topup_datetime'=>'Topup Date');
   
    	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'Username','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile' ,'u_email'=>'Email' ,'topup_rate'=>'Cashback Amount','topup_rate2'=>'Booster Amount','topup_amount'=>'Topup Amount','topup_date'=>'Cashback Date','topup_datetime'=>'Topup Activation Date');
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 

 
if ($export_total=='1') {
 //
//,'((sum(topup_amount)/100)*5) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	$arr_columns =array( 'u_username'=>'Username','u_fname'=>'Name','u_address'=>'Address' ,'u_mobile'=>'Mobile','u_status'=>'Status','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR'   ,'u_city'=>'City' ,'sum(topup_amount)as totalamount'=>'Total Amount'  );
	export_delimited_file($sql_export_total, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;

}
 
$sql 	.= "  limit $start, $pagesize ";
$sql 	= $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Club Achieved Member List</div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content"><p align="center" style="color:#FF0000;">
        <? include("error_msg.inc.php");?>
        <br />
        <?=$msg;?>
      </p>
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
            <td><?=payment_status_dropdown('topup_status',$topup_status);?></td>
            <td width="20" align="right">Type</td>
            <td width="163"><select name="topup_plan" id="topup_plan">
                <option value="" >Please Select</option>
                <option <? if($topup_type=='TOPUP'){?> selected="selected" <? } ?> value="TOPUP">TOPUP</option>
                <option<? if($topup_type=='POWER'){?> selected="selected" <? } ?> value="POWER">POWER</option>
              </select></td>
          </tr>
          <tr>
            <td  align="right" valign="top">Username </td>
            <td><input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
            <td align="right"><span class="tdLabel">Topup Amount:</span></td>
            <td><input name="topup_amount" style="width:120px;"type="text" value="<?=$topup_amount?>" /></td>
            <td align="right"><input name="export_total" type="checkbox" id="export_total" value="1" />
            </td>
            <td><!--Export Total Payout-->
              Total  Topup List </td>
          </tr>
          <tr>
            <td align="right"> Date from: </td>
            <td><?=get_date_picker("datefrom", $datefrom)?></td>
            <td  align="right" valign="top"> Date To: </td>
            <td><?=get_date_picker("dateto", $dateto)?></td>
            <td align="right"><input name="export" type="checkbox" id="export" value="1" /></td>
            <td>Details Topup list </td>
          </tr>
          <tr>
            <td  align="right" valign="top">Downline - Username </td>
            <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
            <td  align="right" valign="top" nowrap="nowrap" style="color:#FF0000">Qualified Ids On Level </td>
            <td><?=array_dropdown($ARR_CLUB_LEVEL, $level, 'level');?>
              <?php /*?>Qualified Users List<?php */?></td>
            <td align="right" valign="middle">&nbsp;</td>
            <td valign="middle"><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <div align="right">
        <!--<a href="https://razoo.live/cronjob_club_member_on_each_level_update.php" target="_blank">Click Here To Refresh/Recount Team Member Count</a> -->
        <? if(mysqli_num_rows($result)==0){?>
        <div class="msg">Sorry, no records found.</div>
        <? } else{ 
 	  ?>
        <!-- | <a href="recharge_topup_auto.php">Auto Recharge/Topup</a>-->
      </div>
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
        <br>
        <style>   
 table tr.td_green td {
          border: #fff solid 1px!important;    color:#000000; background:#EFFFED;
        }
 
 table tr.td_green:hover td {
          border: #ffd000 solid 1px!important; background:#00FF00!important;  cursor:pointer;  color:#333;
        }
</style>
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="8%" >Topup ID
              <?= sort_arrows('topup_id')?></th>
            <th width="8%" >User ID
              <?= sort_arrows('u_id')?></th>
            <th width="9%" >Name
              <?= sort_arrows('u_username')?></th>
            <th width="9%" >City </th>
            <th width="8%" style="background:#875B0B" > <strong style="background:#FFA500; padding:1px; margin-top:3px;">&nbsp;&nbsp;Level
              <?=$level;?>
              &nbsp;&nbsp;</strong></th>
            <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 2&nbsp;&nbsp;</strong></th>
            <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 3&nbsp;&nbsp;</strong></th>
            <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 4&nbsp;&nbsp;</strong></th>
            <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 5&nbsp;&nbsp;</strong></th>
            <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 6&nbsp;&nbsp;</strong></th>
            <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 7&nbsp;&nbsp;</strong></th>
            <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 8&nbsp;&nbsp;</strong></th>
            <?php /*?> 
                     <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level 9&nbsp;&nbsp;</strong></th>
				  <th width="8%" style="background:#875B0B"  ><strong style="background:#FFA500; padding:1px;">&nbsp;&nbsp;Level&nbsp;10&nbsp;&nbsp;</strong></th>
                    <?php */?>
            <?php /*?><th width="9%" >Sponsor </th>
                  <th width="5%" >Topup By</th>
                  <th width="8%" >Type</th>
                  <th width="8%" >Plan</th>
                  <th width="8%" >Weeks/Months</th>
                  <th width="8%" >Day</th>
                  <th width="8%" >Rate </th>
                  <th width="8%" >Booster </th><?php */?>
            <th width="7%" >Topup Amount </th>
            <th width="7%" >Status</th>
            <th width="7%" >Topup Date </th>
            <!--<th width="7%" >Topup Date </th>-->
            <th width="2%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	 $css = ($css=='trOdd')?'trEven':'trOdd';
	 //$cheque_other_count = db_scalar("select count(*) from ngo_users where u_cheque_other =$u_id");
	//if ($u_cheque=='self') { $u_cheque_to='self+'.$cheque_other_count;} else {$u_cheque_to=$u_cheque_other;}
	/*if ($topup_amount==1999) { $css = 'td_red'; } 
	else if ($topup_amount==4999)  { $css = 'td_pink';}
	else if ($topup_amount>35)  { $css = 'td_green';}
	else if ($topup_amount>24999)  { $css = 'td_green';}*//**/
	///$total_direct_paid = db_scalar("select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_ref_userid ='$u_id'   ")+0;
	///if ($total_direct_paid>=4)  { $value = 'table';} else { $value = 'none'; }
	if ($topup_amount>=35)  { $css = 'td_green';}
	///if ($total_direct_paid>=4)  { 
  ?>
          <tr class="<?=$css?>"  >
            <td nowrap="nowrap"><?=$topup_id?></td>
            <td nowrap="nowrap"><?=$u_username?></td>
            <td nowrap="nowrap"><?=$u_fname?>
            </td>
            <td nowrap="nowrap"><?=$u_city?>
            </td>
            <td nowrap="nowrap"><?=$member_on_level_1?>
            </td>
            <td nowrap="nowrap"><?=$member_on_level_2?>
            </td>
            <td nowrap="nowrap"><?=$member_on_level_3?>
            </td>
            <td nowrap="nowrap"><?=$member_on_level_4?>
            </td>
            <td nowrap="nowrap"><?=$member_on_level_5?>
            </td>
            <td nowrap="nowrap"><?=$member_on_level_6?>
            </td>
            <td nowrap="nowrap"><?=$member_on_level_7?>
            </td>
            <td nowrap="nowrap" align="center" style="border:solid 1px #999; font-weight:bold; background:#FFE7BC;"><? 
/*
if ($level==1 || $level=='') 			{ echo  $member_on_level_1; }
if ($level==2) 			{ echo  $member_on_level_2; }
if ($level==3) 			{ echo  $member_on_level_3; }
if ($level==4) 			{ echo  $member_on_level_4; }
if ($level==5) 			{ echo  $member_on_level_5; }
if ($level==6) 			{ echo  $member_on_level_6; }
if ($level==7) 			{ echo  $member_on_level_7; }
if ($level==8) 			{ echo  $member_on_level_8; }
				   
	*/			   
				   
				   
				   
				    ///=total_direct_level_downline_ids_paid($u_id,1, $sql_part)+0?>
            </td>
            <?php /*?><td nowrap="nowrap"><?=$u_sponsor_id?> </td>
                  <td nowrap="nowrap"><?=db_scalar("select CONCAT(u_username,'-', u_fname) from ngo_users where u_id ='$topup_by_userid'");?></td>
                  <td nowrap="nowrap"><?=$topup_type?></td>
                  <td nowrap="nowrap"><?=$topup_plan?></td>
                  <td nowrap="nowrap"><?=$topup_group?></td>
                  <td nowrap="nowrap"><?=$topup_days_for?></td>
                  <td nowrap="nowrap"><?  echo $topup_rate+0;  ?> </td>
                  <td nowrap="nowrap"><?  echo $topup_rate2+0;  ?>
                  </td><?php */?>
            <td nowrap="nowrap"><?=db_scalar("select topup_amount from ngo_users_recharge where topup_userid ='$u_id' order by topup_id desc limit 0,1 ");?>
              <!--///=$topup_amount--></td>
            <td nowrap="nowrap"><?=$topup_status?></td>
            <td nowrap="nowrap"><?=date_format2($topup_date)?></td>
            <!--<td nowrap="nowrap"><?=date_format2($topup_datetime)?></td>-->
            <td align="center"><input name="arr_topup_ids[]" type="checkbox" id="arr_topup_ids[]" value="<?=$topup_id?>"/></td>
          </tr>
          <? }
?>
        </table>
        <table width="35%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableList" style="float:right; background:#FFE7BC; border:solid 1px #FFA500; margin-top:5px;">
          <tr>
            <th width="8%" colspan="3" style="background:#FFA500" >Send Club Achieved Fund To User</th>
          </tr>
          <tr>
            <td width="205" align="right" style="padding:5px;"><!--Transaction Type-->
              Club Income Type : </td>
            <td><?=array_dropdown($ARR_CLUB_GROUP, '$pay_group', 'pay_group');?>
              <!--&nbsp;&nbsp; <input type="hidden" name="pay_group" value="<?=$pay_group?>"   /> --></td>
          </tr>
          <tr>
            <td width="205" align="right" style="padding:5px;">Payment For Level : </td>
            <td><?=array_dropdown($ARR_CLUB_LEVEL, $pay_plan_level, 'pay_plan_level');?>
              <!-- Level <? ///=$pay_plan_level;?>-->
              &nbsp;&nbsp; </td>
          </tr>
          <tr>
            <td width="205" align="right" style="padding:5px;">Send Club Achieved Amount : </td>
            <td><input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />
            </td>
          </tr>
          <td align="right"> Payment Date : </td>
            <td><?=get_date_picker("payment_date", $payment_date)?></td>
          <tr>
            <td width="205" align="right" style="padding:5px;"></td>
            <td width="86" align="left" style="padding:5px;"><input name="Submit_Recharge" type="image" id="Submit_Recharge" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_topup_ids[]')"/>
              <!--2020-02-26 temp comment--></td>
          </tr>
        </table>
      </form>
      <? }?>
      <? include("paging.inc.php");?>
    </td>
  </tr>
</table>
<? include("bottom.inc.php");?>
