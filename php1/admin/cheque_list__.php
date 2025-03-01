<?
require_once("../includes/surya.dream.php");
 //print_r($_POST);
 protect_admin_page2();
if(is_post_back()) {
	$arr_check_ids = $_REQUEST['arr_check_ids'];
	if(is_array($arr_check_ids)) {
		$str_check_ids = implode(',', $arr_check_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  			#$sql = "delete from ngo_cheque where check_id in ($str_check_ids)";
			#db_query($sql);
 		} else if(isset($_REQUEST['Print']) || isset($_REQUEST['Print_x']) ) {
			$_SESSION['arr_check_ids'] =$_REQUEST['arr_check_ids'] ;
		header ("location: cheque_print_single.php");
		exit();
			#$sql = "update ngo_cheque set check_status = 'Active' where check_id in ($str_check_ids)";
			#db_query($sql);
		 } else if(isset($_REQUEST['Print2']) || isset($_REQUEST['Print2_x']) ) {
			$_SESSION['arr_check_ids'] =$_REQUEST['arr_check_ids'] ;
			header ("location: cheque_print.php");
			exit();
			#$sql = "update ngo_cheque set check_status = 'Active' where check_id in ($str_check_ids)";
			#db_query($sql);
		} else if(isset($_REQUEST['Status']) || isset($_REQUEST['Status_x']) ) {
  			$sql = "update ngo_cheque set check_status = '$check_status' where check_id in ($str_check_ids)";
			db_query($sql);
		
		} else if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ) {
  			if($rec_id!='') {
			$sql = "update ngo_cheque set check_rec_id = '$rec_id', check_rec_date=now() where check_id in ($str_check_ids)";
			db_query($sql);
			}
 		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_cheque, ngo_users   ";
$sql .= " where ngo_cheque.check_userid=ngo_users.u_id   ";


if (($check_id_from!='') && ($check_id_to!='')) {$sql .= " and (check_userid  between $check_id_from  and  $check_id_to )";}
if ($check_cheque_no!='') {$sql .= " and  check_cheque_no ='$check_cheque_no' ";}
if ($check_date!='') {$sql .= " and  check_date ='$check_date' ";}
if ($check_bank!='') {$sql .= " and  check_bank ='$check_bank' ";}
if ($check_status!='') {$sql .= " and  check_status  ='$check_status' ";}
if ($check_amount!='') {$sql .= " and  check_amount  ='$check_amount' ";}
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
	    $export_sql2 = "   from  ngo_cheque , ngo_users where ngo_cheque.check_userid=ngo_users.u_id and  check_userid in ($export_ids ) order by check_userid asc ";
	$arr_columns =array('check_userid'=>'User ID','u_fname'=>'User Name','check_cheque_no'=>'Cheque No','check_bank'=>'Bank','check_amount'=>'Amount','check_date'=>'Cheque Date','check_rec_id'=>'Rec id','check_rec_name'=>'Rec Name','check_rec_date'=>'Rec Date','check_contact'=>'Contact Number','check_for'=>'Payment For','check_closeid'=>'Closing ID','check_payment_mode'=>'Payment Mode');
 
 	    export_delimited_file($export_sql2, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	   exit;
}


$order_by == '' ? $order_by = 'check_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";

if ($export=='1') {
 	 $arr_columns =array('check_userid'=>'UserID','u_fname'=>'User Name','check_type'=>'Cheque Type','check_cheque_no'=>'Cheque No','check_bank'=>'Bank Name','check_amount'=>'Amount','check_date'=>'Cheque Date','check_status'=>'Status','check_rec_id'=>'Rec id','check_rec_name'=>'Rec Name','check_rec_date'=>'Rec Date','check_contact'=>'Contact Number','check_for'=>'Payment For','check_closeid'=>'Closing ID','check_payment_mode'=>'Payment Mode');
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
       PDC/General Cheque    List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2" action="cheque_list.php" onsubmit="return confirm_submit(this)">
        <br />
        <table width="618"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="5">Search</th>
          </tr>
 		  <tr>
 		    <td width="95" class="tdLabel">User ID From </td>
 		    <td width="137"><input name="check_id_from"style="width:120px;" type="text" value="<?=$check_id_from?>" /></td>
 		    <td width="81" align="right">User ID To </td>
 		    <td width="158"><input name="check_id_to" style="width:120px;"type="text" value="<?=$check_id_to?>" /></td>
 		    <td width="158"><input name="export" type="checkbox" id="export" value="1" />
Export to CSV </td>
 		  </tr>
 		  <tr>
 		    <td class="tdLabel">Cheque Number </td>
 		    <td><input name="check_cheque_no"style="width:120px;" type="text" value="<?=$check_cheque_no?>" /></td>
 		    <td align="right">Bank Name </td>
 		    <td><?=bank_dropdown('check_bank',$check_bank)?></td>
 		    <td><input name="export2" type="checkbox" id="export2" value="1" />
Only Duplicate Record</td>
 		  </tr>
 		  <tr>
            <td class="tdLabel">Cheque Date </td>
            <td><?=get_date_picker("check_date", $check_date)?><!--<input name="check_bank" type="text" id="check_bank"style="width:120px;" value="<? // =$check_bank?>" />--></td>
            <td align="right">Status</td>
            <td>
			<?=checkstatus_dropdown('check_status',$check_status)?>
			<!--<input name="check_status" type="text" id="check_status"style="width:120px;" value="<? //=$check_status?>" />--></td>
 		    <td>&nbsp;</td>
 		  </tr>
          
		  <tr>
            <td>&nbsp;</td>
                 <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                 <td align="right">Amount </td>
                 <td align="left" valign="middle"><input name="check_amount" style="width:120px;"type="text" value="<?=$check_amount?>" />
                  <br /></td>
		         <td align="left" valign="middle">&nbsp;</td>
		  </tr>
        </table>
     </form>
   <div align="right"><a href="cheque_auto_f.php">Auto Generated PDC Cheque </a>&nbsp;|&nbsp;  <a href="cheque_f.php">Create New Cheque </a>&nbsp;|&nbsp; <a href="cheque_import.php">Import Cheque List</a>&nbsp;|&nbsp; <a href="cheque_updated_import.php">Import Updated Cheque List</a></div>
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
      </div><!--action="cheque_print_single.php"-->
      <form method="post" name="form1" id="form1" >
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
           <!-- <th width="5%" align="left" nowrap="nowrap">Sl No </th>-->
           <th width="5%" align="left" nowrap="nowrap">User ID </th>
			 <th width="7%" align="left" nowrap="nowrap">User Name </th>
			 <th width="8%" align="left" nowrap="nowrap">Post</th>
			 <th width="8%" align="left" nowrap="nowrap">Cheque Type </th>
			 <th width="7%" align="left" nowrap="nowrap">Cheque No </th>
             <th width="8%" align="left" nowrap="nowrap">Cheque Date </th>
			  <th width="6%" align="left" nowrap="nowrap">Amount </th>
			  <th width="4%" align="left" nowrap="nowrap">Bank </th>
              <th width="5%" align="left" nowrap="nowrap">Status</th>
              <th width="5%" align="left" nowrap="nowrap">Rec ID </th>
              <th width="16%" align="left" nowrap="nowrap">Rec name </th>
              <th width="6%">Rec mobile. </th>
               <th width="6%"   >Rec Date </th>
               <th width="5%"   >Closing</th>
			   <th width="5%"   >Mode</th>
			   <th width="3%"   >Pay-For</th>
               <th width="4%"   >Print</th>
               <th width="2%"   > </th>
              <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$duplicate  = db_scalar("select count(*) from ngo_cheque where check_userid='$check_userid' and  check_amount='$check_amount'");
	if ($duplicate>=2) { $error='bgcolor="#FF2020"';$css='tdLabel'; }
	
 ?>
          <tr class="<?=$css?>"  <?=$error?>>
                  <!-- <td nowrap="nowrap"><? //=$check_id?></td>-->
                  <td nowrap="NOWRAP"><?=$check_userid?></td>
                  <td nowrap="NOWRAP"><?=$u_fname ?></td>
                  <td nowrap="NOWRAP"><?=db_scalar("select utype_code from ngo_users_type where utype_id='$line[u_utype]'") ?></td>
                  <td nowrap="NOWRAP"><?=$check_type ?></td>
                  <td nowrap="NOWRAP"><?=$check_cheque_no ?></td>
                  <td nowrap="NOWRAP"><?=date_format2($check_date)?></td>
                  <td nowrap="NOWRAP"><?=$check_amount?></td>
                  <td nowrap="NOWRAP"><?=$check_bank?></td>
                  <td nowrap="NOWRAP"><?=$check_status?></td>
                  <td nowrap="NOWRAP"><?=$check_rec_id?></td>
                  <td nowrap="NOWRAP"><? if ($check_rec_name!='') { echo $check_rec_name;} else { echo db_scalar("select u_fname  from ngo_users where u_id='$check_rec_id'");}?></td>
                  <td align="center" nowrap="nowrap"><? if ($check_contact!='') { echo $check_contact;} else { echo db_scalar("select u_mobile  from ngo_users where u_id='$check_rec_id'");}?>
                    <? //=$check_contact?></td>
                  <td align="center" nowrap="nowrap"><?=date_format2($check_rec_date)?></td>
                  <td align="center" nowrap="nowrap"><?=$check_closeid ?></td>
				   <td align="center" nowrap="nowrap"><?=$check_payment_mode ?></td>
                  <td align="center" nowrap="nowrap"><?=$check_for ?></td>
                  <td align="center" nowrap="nowrap"><?=$check_print ?></td>
                  <!-- <td align="center"><a href="cheque_print.php?check_id=<? //=$check_id?>" target="_blank">Print</a></td>-->
                  <td align="center" nowrap="nowrap"><a href="cheque_f.php?check_id=<?=$check_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                  <td align="center" nowrap="nowrap"><input name="arr_check_ids[]" type="checkbox" id="arr_check_ids[]" value="<?=$check_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" >Receiver ID: <input name="rec_id" type="text" value="<?=$rec_id?>" /> </td><td align="left" ><input name="Submit" type="image" id="Submit" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_check_ids[]')"/></td>
			
			<td align="right" > Status: <?=checkstatus_dropdown('check_status',$check_status)?></td><td align="left" > <input name="Status" type="image" id="Status" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_check_ids[]')"/> </td>
               <td align="right" ><input name="Print2" type="image" id="Print2" src="images/buttons/cheque_print2.gif" onclick="return printConfirmFromUser('arr_check_ids[]')"/> <input name="Print" type="image" id="Print" src="images/buttons/cheque_print.gif" onclick="return printConfirmFromUser('arr_check_ids[]')"/>  </td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
