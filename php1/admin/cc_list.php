<?
require_once("../includes/surya.dream.php");
 //print_r($_POST);
 protect_admin_page2();
if(is_post_back()) {
	$arr_cc_ids = $_REQUEST['arr_cc_ids'];
	if(is_array($arr_cc_ids)) {
		$str_cc_ids = implode(',', $arr_cc_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  			#$sql = "delete from ngo_cc where cc_id in ($str_cc_ids)";
			#db_query($sql);
 		 
		} else if(isset($_REQUEST['Status']) || isset($_REQUEST['Status_x']) ) {
  			$sql = "update ngo_cc set cc_status = '$cc_status' where cc_id in ($str_cc_ids)";
			db_query($sql);
		
		} else if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ) {
  			if($rec_id!='') {
			$sql = "update ngo_cc set cc_rec_id = '$rec_id', cc_rec_date=now() where cc_id in ($str_cc_ids)";
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
$sql = " from ngo_cc  ";
$sql .= " where 1 ";


if (($cc_id_from!='') && ($cc_id_to!='')) {$sql .= " and (cc_userid  between $cc_id_from  and  $cc_id_to )";}
if ($cc_cheque_no!='') {$sql .= " and  cc_cheque_no ='$cc_cheque_no' ";}
 
if (($datefrom!='') && ($dateto!='')){ $sql .= " and cc_rec_date between '$datefrom' AND '$dateto' "; }
if ($cc_bank!='') {$sql .= " and  cc_bank ='$cc_bank' ";}
if ($cc_status!='') {$sql .= " and  cc_status  ='$cc_status' ";}
if ($cc_amount!='') {$sql .= " and  cc_amount  ='$cc_amount' ";}
//$sql = apply_filter($sql, $cc_title, $cc_title_filter,'cc_title');
$order_by == '' ? $order_by = 'cc_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";
//'cc_id'=>'SlNo',
if ($export=='1') {
	$arr_columns =array('cc_userid'=>'UserID','u_fname'=>'User Name','cc_pay_mode'=>'Payment Mode','cc_admin'=>'Received By','cc_amount'=>'Amount','cc_cheque_no'=>'Cheque No','cc_cheque_date'=>'Cheque Date','cc_bank'=>'Bank Name','cc_given_userid'=>'Given By ID','cc_given_name'=>'Given By Name','cc_cheque_userid'=>'Cheque of ID','cc_rec_date'=>'Receive Date','cc_contact'=>'Contact Number','cc_remark'=>'Remark');
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
       CC   List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2" action="receive_list.php" onsubmit="return confirm_submit(this)">
        <br />
        <table width="618"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="5">Search</th>
          </tr>
 		  <tr>
 		    <td width="98" class="tdLabel">Name </td>
 		    <td width="127"><input name="cc_id_from"style="width:120px;" type="text" value="<?=$cc_id_from?>" /></td>
 		    <td width="89" align="right">City </td>
 		    <td width="138"><input name="cc_id_to" style="width:120px;"type="text" value="<?=$cc_id_to?>" /></td>
 		    <td width="144"><input name="export" type="checkbox" id="export" value="1" />
Export to CSV </td>
 		  </tr>
 		  <tr>
            <td class="tdLabel"> calling Date from </td>
            <td><?=get_date_picker("datefrom", $datefrom)?><!--<input name="cc_bank" type="text" id="cc_bank"style="width:120px;" value="<? // =$cc_bank?>" />--></td>
            <td align="right"> calling Date To </td>
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
   <div align="right"><!--<a href="cheque_auto_f.php">Auto Generated PDC Cheque </a>&nbsp;|&nbsp;-->  <a href="cc_f.php">Add a call </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="cc_import.php">Import Calling List</a></div>
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
            <th width="4%" align="left" nowrap="nowrap">SlNo.</th>
           <!-- <th width="5%" align="left" nowrap="nowrap">Sl No </th>-->
            <th width="8%" align="left" nowrap="nowrap">User Name </th>
			 <th width="8%" align="left" nowrap="nowrap">address</th>
			 <th width="8%" align="left" nowrap="nowrap">City</th>
			 <th width="8%" align="left" nowrap="nowrap">Mobile</th>
             <th width="10%" align="left" nowrap="nowrap">Telephone</th>
			  <th width="7%" align="left" nowrap="nowrap">Call Start on </th>
              <th width="6%" align="left" nowrap="nowrap"> Last Call </th>
              <th width="13%" align="left" nowrap="nowrap">Next Calling  Date</th>
              <th width="10%">Remark</th>
               <th width="8%"   >Status</th>
               <th width="3%"   > </th>
             <!-- <th width="3%"><input name="cc_all" type="checkbox" id="cc_all" value="1" onclick="checkall(this.form)" /></th>-->
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$duplicate  = db_scalar("select count(*) from ngo_cc where cc_userid='$cc_userid' and  cc_amount='$cc_amount'");
	if ($duplicate>=2) { $error='bgcolor="#FF2020"';$css='tdLabel'; }
	
 ?>
          <tr class="<?=$css?>"  <?=$error?>>
            <td nowrap="nowrap"><?=$cc_id?></td>
           <!-- <td nowrap="nowrap"><? //=$cc_id?></td>-->
            <td nowrap="nowrap"><?=$u_fname ?></td>
                        <td nowrap="nowrap"><?=$cc_amount?></td>
                        <td nowrap="nowrap"><?=$cc_pay_mode?></td>
                        <td nowrap="nowrap"><?=$cc_cheque_no ?></td>
						<td nowrap="nowrap"><?=date_format2($cc_cheque_date)?></td>
					    <td nowrap="nowrap"><?=$cc_bank?></td>
                        <td nowrap="nowrap"><?=$cc_given_userid?></td>
                        <td align="center"><?=$cc_given_name?>   </td>
                        <td nowrap="nowrap"><?=date_format2($cc_rec_date)?></td> 
						<td align="center">&nbsp;</td>
                         <td align="center"><a href="receive_f.php?cc_id=<?=$cc_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                    <!--<td align="center"><input name="arr_cc_ids[]" type="checkbox" id="arr_cc_ids[]" value="<?=$cc_id?>" /></td>-->
                </tr>
          <? }
?>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" >&nbsp;</td>
           </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
