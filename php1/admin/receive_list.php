<?
require_once("../includes/surya.dream.php");
 //print_r($_POST);
 protect_admin_page2();
if(is_post_back()) {
	$arr_rece_ids = $_REQUEST['arr_rece_ids'];
	if(is_array($arr_rece_ids)) {
		$str_rece_ids = implode(',', $arr_rece_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  			#$sql = "delete from ngo_receive where rece_id in ($str_rece_ids)";
			#db_query($sql);
 		 } else if(isset($_REQUEST['Pay_Mode']) || isset($_REQUEST['Pay_Mode_x']) ) {
  			$sql = "update ngo_receive set rece_pay_mode = '$pay_mode' where rece_id in ($str_rece_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Status']) || isset($_REQUEST['Status_x']) ) {
  			$sql = "update ngo_receive set rece_status = '$rece_status' where rece_id in ($str_rece_ids)";
			db_query($sql);
		
		} else if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ) {
  			if($rec_id!='') {
			$sql = "update ngo_receive set rece_rec_id = '$rec_id', rece_rec_date=now() where rece_id in ($str_rece_ids)";
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
$sql = " from ngo_receive, ngo_users   ";
$sql .= " where ngo_receive.rece_userid=ngo_users.u_id   ";


if (($rece_id_from!='') && ($rece_id_to!='')) {$sql .= " and (rece_userid  between $rece_id_from  and  $rece_id_to )";}
else if (($rece_id_from!='') && ($rece_id_to=='')) {$sql .= " and  rece_userid ='$rece_id_from' ";}

if ($rece_cheque_no!='') {$sql .= " and  rece_cheque_no ='$rece_cheque_no' ";}
 
if (($datefrom!='') && ($dateto!='')){ $sql .= " and rece_rec_date between '$datefrom' AND '$dateto' "; }
if ($rece_bank!='') {$sql .= " and  rece_bank ='$rece_bank' ";}
if ($rece_status!='') {$sql .= " and  rece_status  ='$rece_status' ";}
if ($rece_amount!='') {$sql .= " and  rece_amount  ='$rece_amount' ";}
//$sql = apply_filter($sql, $rece_title, $rece_title_filter,'rece_title');
$order_by == '' ? $order_by = 'rece_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";
//'rece_id'=>'SlNo',
if ($export=='1') {
	$arr_columns =array('rece_userid'=>'UserID','u_fname'=>'User Name','rece_pay_mode'=>'Payment Mode','rece_admin'=>'Received By','rece_amount'=>'Amount','rece_cheque_no'=>'Cheque No','rece_cheque_date'=>'Cheque Date','rece_bank'=>'Bank Name','rece_given_userid'=>'Given By ID','rece_given_name'=>'Given By Name','rece_cheque_userid'=>'Cheque of ID','rece_rec_date'=>'Receive Date','rece_contact'=>'Contact Number','rece_remark'=>'Remark');
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
       Payment Receive   List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" id="content">
             <form method="get" name="form2" id="form2" action="receive_list.php" onsubmit="return confirm_submit(this)">
         
        <table width="618"  border="0" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="5">Search</th>
          </tr>
 		  <tr>
 		    <td width="98" class="tdLabel">User ID From </td>
 		    <td width="127"><input name="rece_id_from"style="width:120px;" type="text" value="<?=$rece_id_from?>" /></td>
 		    <td width="89" align="right">User ID To </td>
 		    <td width="138"><input name="rece_id_to" style="width:120px;"type="text" value="<?=$rece_id_to?>" /></td>
 		    <td width="144"><input name="export" type="checkbox" id="export" value="1" />
Export to CSV </td>
 		  </tr>
 		  <tr>
 		    <td class="tdLabel">Rec. Amount </td>
 		    <td><input name="rece_amount" style="width:120px;"type="text" value="<?=$rece_amount?>" /></td>
 		    <td align="right">Bank Name </td>
 		    <td><? //=bank_dropdown('rece_bank',$rece_bank)?>
			<input name="rece_bank" style="width:120px;"type="text" value="<?=$rece_bank?>" />
			</td>
 		    <td>&nbsp;</td>
 		  </tr>
 		  <tr>
            <td class="tdLabel">Receive Date from </td>
            <td><?=get_date_picker("datefrom", $datefrom)?><!--<input name="rece_bank" type="text" id="rece_bank"style="width:120px;" value="<? // =$rece_bank?>" />--></td>
            <td align="right">Receive Date To </td>
            <td><?=get_date_picker("dateto", $dateto)?></td>
 		    <td>&nbsp;</td>
 		  </tr>
		  <tr>
            <td>&nbsp;</td>
                 <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                 <td align="right">&nbsp;</td>
                 <td align="left" valign="middle"><br /></td>
		         <td align="left" valign="middle">&nbsp;</td>
		  </tr>
        </table>
             </form>
   <div align="right"><!--<a href="cheque_auto_f.php">Auto Generated PDC Cheque </a>&nbsp;|&nbsp;-->  <a href="receive_f.php">Add Receiving</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="receive_import.php">Import Reveiving List</a></div>
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
            <th width="3%" align="left" nowrap="nowrap">SlNo.</th>
           <!-- <th width="5%" align="left" nowrap="nowrap">Sl No </th>-->
            <th width="5%" align="left" nowrap="nowrap">User ID </th>
			 <th width="7%" align="left" nowrap="nowrap">User Name </th>
			 <th width="3%" align="left" nowrap="nowrap">Post</th>
			 <th width="7%" align="left" nowrap="nowrap">Referer ID </th>
			 <th width="5%" align="left" nowrap="nowrap">Amount </th>
			 <th width="4%" align="left" nowrap="nowrap">Mode</th>
			 <th width="7%" align="left" nowrap="nowrap">Cheque No </th>
             <th width="8%" align="left" nowrap="nowrap">Cheque Date </th>
			  <th width="4%" align="left" nowrap="nowrap">Bank </th>
              <th width="6%" align="left" nowrap="nowrap"> Given  ID </th>
              <th width="7%" align="left" nowrap="nowrap">Given Name </th>
              <th width="6%">   ChequeID</th>
               <th width="3%"   >Rec Date</th>
               <th width="5%"   >Remark</th>
               <th width="9%"   >MISC</th>
               <th width="5%"   ></th>
               <th width="3%"   ></th>
               <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
               <!-- <th width="3%"><input name="rece_all" type="checkbox" id="rece_all" value="1" onclick="checkall(this.form)" /></th>-->
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$duplicate  = db_scalar("select count(*) from ngo_receive where rece_userid='$rece_userid' and  rece_amount='$rece_amount'");
	if ($duplicate>=2) { $error='bgcolor="#FF2020"';$css='tdLabel'; }
	
 ?>
          <tr class="<?=$css?>"  <?=$error?>>
            <td nowrap="nowrap"><?=$rece_id?></td>
           <!-- <td nowrap="nowrap"><? //=$rece_id?></td>-->
            <td nowrap="nowrap"><?=$rece_userid?></td>
                        <td nowrap="nowrap"><?=$u_fname ?></td>
                        <td nowrap="nowrap"><?=$u_utype ?></td>
                        <td nowrap="nowrap"><?=$u_ref_userid ?></td>
                        <td nowrap="nowrap"><?=$rece_amount?></td>
                        <td nowrap="nowrap"><?=$rece_pay_mode?></td>
                        <td nowrap="nowrap"><?=$rece_cheque_no ?></td>
						<td nowrap="nowrap"><?=date_format2($rece_cheque_date)?></td>
					    <td nowrap="nowrap"><?=$rece_bank?></td>
                        <td nowrap="nowrap"><?=$rece_given_userid?></td>
                        <td align="center"><?=$rece_given_name?>   </td>
                        <td nowrap="nowrap"><?=$rece_cheque_userid?></td> 
						<td align="center"><?=date_format2($rece_rec_date)?></td>
						<td align="center"><?=$rece_remark ?></td>
						<td align="center"><?=$rece_misc ?></td>
                         <td align="center"><a href="receive_deposit.php?rece_id=<?=$rece_id?>">Deposit</a></td>
                         <td align="center"><a href="receive_f.php?rece_id=<?=$rece_id?>"><img src="images/icons/edit.png" alt="Edit" width="14" height="18" border="0" /></a></td>
                         <td align="center" nowrap="nowrap"><input name="arr_rece_ids[]" type="checkbox" id="arr_rece_ids[]" value="<?=$rece_id?>" /></td>
                    <!--<td align="center"><input name="arr_rece_ids[]" type="checkbox" id="arr_rece_ids[]" value="<?=$rece_id?>" /></td>-->
                </tr>
          <? }
?>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" >&nbsp;</td>
           </tr>
          <tr>
            <td align="right" ><table width="256" border="0" align="center" cellpadding="1" cellspacing="0" class="tableSearch">
              <tr>
                <td align="right">Payment Mode :</td>
                <td><input name="pay_mode" type="text" value="<?=$pay_mode?>" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="Pay_Mode" type="image" id="Pay_Mode" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_rece_ids[]')"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
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
