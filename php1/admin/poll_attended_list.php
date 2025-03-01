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
 			# db_query($sql_update);
 		} elseif (isset($_REQUEST['Submit_Topup']) || isset($_REQUEST['Submit_Topup_x']) ){
		 	$sql_update="update ngo_users_recharge set topup_rate='$topup_rate_topup'  where topup_plan='TOPUP' and topup_id in ($str_topup_ids)";
 			#db_query($sql_update);
		}
 	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
  }
}
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_id, u_username, u_password,u_fname ,u_address ,u_ref_userid, u_sponsor_id, u_mobile , ngo_users_survey.* ";
$sql = " from ngo_users  ,ngo_users_survey  where ngo_users_survey.survey_userid=ngo_users.u_id and u_status!='Banned'";

 
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
if ($id_in!='') {$sql .= " and survey_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}

if ($survey_id!='') 		{$sql .= " and survey_id='$survey_id' ";} 
  
 
if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (survey_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  survey_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and survey_date between '$datefrom' AND '$dateto' "; }
if (($datefrom2!='') && ($dateto2!=''))				{$sql .= " and survey_datetime between '$datefrom2' AND '$dateto2' "; }

if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 


$sql_export = $sql ."  order by ngo_users.u_id asc "; 
$sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'survey_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'User ID','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile','u_remark'=>'Remark' ,'topup_datetime'=>'Topup Date','topup_date'=>'Maturity Date','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City','u_bank_register'=>'Acc Register in Bank','topup_plan'=>'Plan' ,'topup_rate'=>'Rate','topup_amount'=>'Total Amount');
 
//export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
//exit;
} 

 
if ($export_total=='1') {

//
//,'((sum(topup_amount)/100)*5) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	#$arr_columns =array( 'u_username'=>'User ID','u_fname'=>'Name','u_address'=>'Address' ,'u_mobile'=>'Mobile','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City' ,'u_bank_register'=>'Acc Register in Bank' ,'sum(topup_amount)as totalamount'=>'Total Amount'  );
	#export_delimited_file($sql_export_total, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	#exit;

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
          <td id="pageHead"><div id="txtPageHead"> Attanded Survey List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="676"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="5">Search</th>
                </tr>
                <tr>
                  <td   align="right" nowrap="nowrap" class="tdLabel">UserAutoID . From: </td>
                  <td  ><input name="user_id_from"style="width:120px;" type="text" value="<?=$user_id_from?>" />                  </td>
                  <td   align="right" nowrap="nowrap">UserAuto ID . To:</td>
                  <td  ><input name="user_id_to" style="width:120px;"type="text" value="<?=$user_id_to?>" />                  </td>
                  <td   align="right"><!--<input name="export" type="checkbox" id="export" value="1" />--></td>
                </tr>
                <tr>
                  <td  align="right" valign="top" nowrap="nowrap">Username : </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right" nowrap="nowrap"><span class="tdLabel">Topup ID :  </span></td>
                  <td><input name="topup_id" style="width:120px;"type="text" value="<?=$topup_id?>" /></td>
                  <td align="right">                    </td>
                </tr>
                 <tr>
                  <td align="right" nowrap="nowrap"> Topup Date from: </td>
                  <td><?=get_date_picker("datefrom2", $datefrom2)?></td>
                  <td  align="right" valign="top" nowrap="nowrap"> Topup Date To: </td>
                  <td><?=get_date_picker("dateto2", $dateto2)?></td>
                  <td align="right" valign="middle">&nbsp;</td>
                </tr>
               
                <tr>
                  <td  align="right" valign="top" nowrap="nowrap">Downline - User ID : </td>
                  <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
                  <td  align="right" valign="top" nowrap="nowrap">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td align="right" valign="middle">&nbsp;</td>
                </tr>
              </table>
            </form>
            <? if(mysqli_num_rows($result)==0){?>
            <div class="msg">Sorry, no records found.</div>
            <? } else{ 
 	  ?> 	<div align="right"><a href="recharge_topup_add.php"> </a><a href="recharge_topup_auto.php"></a> </div>
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
                  <th width="5%" >Survey  ID </th>
                  <th width="5%" >Username</th>
                  <th width="8%" >Name <?= sort_arrows('u_username')?></th>
                  
                  <th width="6%" >Poll ID </th>
                  <th width="8%" >Rate</th>
                   <th width="7%" >Amount </th>
                   <th width="7%" > Attend Date </th>
                    
                  
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
                  <td nowrap="nowrap"><?=$survey_id?></td>
                  <td nowrap="nowrap"><?=$u_username?></td>
                  <td nowrap="nowrap"><?=$u_fname?> </td>
                   <td nowrap="nowrap"><?=$survey_poll_id?></td>
                  <td nowrap="nowrap"><?  echo $survey_rate;?> </td>
                   <td nowrap="nowrap"><?=$survey_amount?></td>
                   <td nowrap="nowrap"><?=date_format2($survey_pay_date)?></td>
                  
               
                 <td align="center"><input name="arr_topup_ids[]" type="checkbox" id="arr_topup_ids[]" value="<?=$topup_id?>"/></td> 
                </tr>
                <? }
?>
              </table>
         <!--   <table width="614" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="205" align="right" style="padding:2px">Recharge : <?
			//echo array_dropdown($ARR_PLAN_RECHARGE_RATE, $topup_rate_recharge,'topup_rate_recharge', 'class="txtbox"  style="width:120px;"','--select--');
			?></td>
				<td width="86" align="right" style="padding:2px"><input name="Submit_Recharge" type="image" id="Submit_Recharge" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_topup_ids[]')"/></td>
                  <td width="237" align="right" style="padding:2px">Topup : <?
			//echo array_dropdown($ARR_PLAN_TOPUP_RATE, $topup_rate_topup,'topup_rate_topup', 'class="txtbox"  style="width:120px;"','--select--');
			?></td>
                  <td width="86" align="right" style="padding:2px"><input name="Submit_Topup" type="image" id="Submit_Topup" src="images/buttons/submit.gif" onclick="return  updateConfirmFromUser('arr_topup_ids[]')"/>                  </td>
                </tr>
              </table> -->
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
