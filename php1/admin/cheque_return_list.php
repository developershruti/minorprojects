<?
require_once('../includes/surya.dream.php');
//print_r($_POST);
 protect_admin_page2();
if(is_post_back()) {
	$arr_check_ids = $_REQUEST['arr_check_ids'];
	if(is_array($arr_check_ids)) {
		$str_check_ids = implode(',', $arr_check_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  			#$sql = "delete from ngo_cheque_return where check_id in ($str_check_ids)";
			#db_query($sql);
 		} else if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ) {
			if ($check_rec_name2=='') { $check_rec_name2 =  db_scalar(" select u_fname from ngo_users where u_id='$check_rec_id2' ");}
			if ($check_contact2=='') { $check_contact2 =  db_scalar(" select u_mobile from ngo_users where u_id='$check_rec_id2' ");}
			$sql = "update ngo_cheque_return set check_rec_id = '$check_rec_id2',check_rec_name='$check_rec_name2' ,check_rec_date='$check_rec_date2' ,check_contact='$check_contact2',check_remark='$check_remark2' ,check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now()  where check_id in ($str_check_ids)";
			db_query($sql);
		 
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_cheque_return  ";
$sql .= " where 1 ";


if (($check_id_from!='') && ($check_id_to=='')) {$sql .= " and  check_userid ='$check_id_from' ";}
else if (($check_id_from!='') && ($check_id_to!='')) {$sql .= " and (check_userid  between $check_id_from  and  $check_id_to )";}
if ($check_cheque_no!='') {$sql .= " and  check_cheque_no ='$check_cheque_no' ";}
if ($check_date!='') {$sql .= " and  check_date ='$check_date' ";}
if ($check_bank!='') {$sql .= " and  check_bank ='$check_bank' ";}
if ($check_status!='') {$sql .= " and  check_status  ='$check_status' ";}

//$sql = apply_filter($sql, $check_title, $check_title_filter,'check_title');



if ($export2=='1') {
 	$export_id = array();
	$export_id[]=0;
	$export_sql= "select check_userid,  count(*) as counter ".$sql . "  group by  check_userid ,check_amount ";
 	$export_result = db_query($export_sql);
	while ($line_export = mysqli_fetch_array($export_result)) {
 		if ($line_export[counter]>=2) {
			///print "<br>.  userID=". $line_export[check_userid]."  --- counter=".$line_export[counter];
		 	$export_id[] = $line_export[check_userid];}
 	}
	$export_ids = implode(",",$export_id);
 	//print_r($export_id);            
 // ,'check_status'=>'check_status'
	    $export_sql2 = "   from  ngo_cheque_return , ngo_users where ngo_cheque_return.check_userid=ngo_users.u_id and  check_userid in ($export_ids ) order by check_userid asc ";
	$arr_columns =array('check_userid'=>'User ID','u_fname'=>'User Name','check_cheque_no'=>'Cheque No','check_bank'=>'Bank','check_amount'=>'Amount','check_date'=>'Cheque Date','check_rec_id'=>'Rec id','check_rec_name'=>'Rec Name','check_rec_date'=>'Rec Date','check_contact'=>'Contact Number');
 
 	    export_delimited_file($export_sql2, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	   exit;
}


$order_by == '' ? $order_by = 'check_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";

if ($export=='1') {
 	 $arr_columns =array('check_userid'=>'Userid','check_cheque_no'=>'Cheque No','check_bank'=>'Bank','check_amount'=>'Amount','check_date'=>'Chque Date', 'check_rec_id'=>'Return ID','check_rec_name'=>'Return Name','check_rec_date'=>'Return Date','check_contact'=>'Contact Number','check_remark'=>'Purpose','check_editby'=>'EditBy');
	 export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
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
    <td id="pageHead"><div id="txtPageHead">
       Cheque    Return List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2"  onsubmit="return confirm_submit(this)">
        <br />
        <table width="541"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="4">Search</th>
          </tr>
 		  <tr>
 		    <td width="95" class="tdLabel">User ID From </td>
 		    <td width="137"><input name="check_id_from"style="width:120px;" type="text" value="<?=$check_id_from?>" /></td>
 		    <td width="81">User ID To </td>
 		    <td width="158"><input name="check_id_to" style="width:120px;"type="text" value="<?=$check_id_to?>" /></td>
 		    </tr>
 		  <tr>
 		    <td class="tdLabel">Cheque Number </td>
 		    <td><input name="check_cheque_no"style="width:120px;" type="text" value="<?=$check_cheque_no?>" /></td>
 		    <td>Bank Name </td>
 		    <td><?=bank_dropdown('check_bank',$check_bank)?></td>
 		    </tr>
 		  <tr>
            <td class="tdLabel">Cheque Date </td>
            <td><?=get_date_picker("check_date", $check_date)?><!--<input name="check_bank" type="text" id="check_bank"style="width:120px;" value="<? // =$check_bank?>" />--></td>
            <td>&nbsp;</td>
            <td><input name="export" type="checkbox" id="export" value="1" />
Export to CSV </td>
 		</tr>
          
		  <tr>
            <td>&nbsp;</td>
                 <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                 <td align="right">&nbsp;</td>
                 <td align="left" valign="middle"><br />
                   <!--<input name="export2" type="checkbox" id="export2" value="1" /> 
                   Only Duplicate Record--></td>
		   </tr>
        </table>
     </form>
   <div align="right"> <a href="cheque_return_f.php">Add New Cheque Return </a></div>
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
      <form method="post" name="form1" id="form1"  action="cheque_return_list.php" >
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="5%" align="left" nowrap="nowrap">User ID </th>
			 <th width="7%" align="left" nowrap="nowrap">Cheque No </th>
             <th width="8%" align="left" nowrap="nowrap">Cheque Date </th>
			  <th width="5%" align="left" nowrap="nowrap">Amount </th>
			  <th width="3%" align="left" nowrap="nowrap">Type</th>
			  <th width="4%" align="left" nowrap="nowrap">Bank </th>
              <th width="5%" align="left" nowrap="nowrap">Status</th>
              <th width="9%" align="left" nowrap="nowrap">Return User ID</th>
              <th width="8%">ReturnName </th>
              <th width="7%">Return Date </th>
              <th width="8%">Contact No. </th>
              <th width="26%">Purpose</th>
               <th width="2%"   >Editby</th>
               <th width="2%"   > </th>
              <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$duplicate  = db_scalar("select count(*) from ngo_cheque_return where check_userid='$check_userid' and  check_amount='$check_amount'");
	if ($duplicate>=2) { $error='bgcolor="#FF2020"';$css='tdLabel'; }
	
 ?>
          <tr class="<?=$css?>"  <?=$error?>>
            <td nowrap="nowrap"><?=$check_userid?></td>
                        <td nowrap="nowrap"><?=$check_cheque_no ?></td>
						<td nowrap="nowrap"><?=date_format2($check_date)?></td>
						 <td nowrap="nowrap"><?=$check_amount?></td>
						 <td nowrap="nowrap"><?=$check_type?></td>
					    <td nowrap="nowrap"><?=$check_bank?></td>
                        <td nowrap="nowrap"><?=$check_status?></td>
                        <td nowrap="nowrap"><?=$check_rec_id?></td>
                        <td align="center"><?=$check_rec_name?></td>
                        <td align="center"><?=date_format2($check_rec_date)?></td>
                        <td align="center"><?=$check_contact?></td>
                        <td align="center"><?=$check_remark?></td>
                        <td align="center"><?=$check_editby?></td>
                       <!-- <td align="center"><a href="cheque_print.php?check_id=<? //=$check_id?>" target="_blank">Print</a></td>-->
                        <td align="center"><a href="cheque_return_f.php?check_id=<?=$check_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                    <td align="center"><input name="arr_check_ids[]" type="checkbox" id="arr_check_ids[]" value="<?=$check_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"><br />
              <table width="545" border="0" align="center" cellpadding="2" cellspacing="2" class="tableSearch">
              <tr>
                <td width="107" align="right">Return User  ID : </td>
                <td width="124" align="left"><input name="check_rec_id2" type="text" value="<?=$check_rec_id2?>" /></td>
                <td width="90" align="right">Return date :</td>
                <td width="196"><span class="tableDetails">
                  <?=get_date_picker("check_rec_date2", $check_rec_date2)?>
                </span></td>
              </tr>
              <tr>
                <td align="right">Return Name :</td>
                <td align="left"><input name="check_rec_name2" type="text" value="<?=$check_rec_name2?>" /></td>
                <td align="right">Contact Number : </td>
                <td><input name="check_contact2" type="text" value="<?=$check_contact2?>" /></td>
              </tr>
              
              <tr>
                <td align="right">Purpose : </td>
                <td colspan="3" align="left"><input name="check_remark2" type="text" value="<?=$check_remark2?>" size="65" /></td>
                </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td colspan="2" align="left"><input name="Submit" type="image" id="Submit" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_check_ids[]')"/></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
