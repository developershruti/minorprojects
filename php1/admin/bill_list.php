<?
require_once("../includes/surya.dream.php");
//print_r($_POST);
if(is_post_back()) {
	$arr_bill_ids = $_REQUEST['arr_bill_ids'];
	if(is_array($arr_bill_ids)) {
		$str_bill_ids = implode(',', $arr_bill_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			//$sql = "delete from ngo_product_bill_details where billd_billid in ($str_bill_ids)";
			//db_query($sql);
 			//$sql = "delete from ngo_product_bill where bill_id in ($str_bill_ids)";
			//db_query($sql);
 		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			//$sql = "update ngo_product_bill set bill_status = 'Active' where bill_id in ($str_bill_ids)";
			//db_query($sql);
		} else if(isset($_REQUEST['Print']) || isset($_REQUEST['Print_x']) ) {
 			$_SESSION['str_bill_ids'] = $str_bill_ids;
			header ("location: bill_print.php");
			exit();
 		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_bill  ";
$sql .= " where 1 ";

if ($bill_prod!='') {$sql .= " and  (bill_prod1 like '%$bill_prod%' OR bill_prod2 like '%$bill_prod%' )";}
 if (($bill_id_from!='') && ($bill_id_to!='')) {$sql .= " and (bill_userid  between $bill_id_from  and  $bill_id_to )";}
 
//$sql = apply_filter($sql, $bill_title, $bill_title_filter,'bill_title');

$order_by == '' ? $order_by = 'bill_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";
 


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
       Bill    List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table width="390"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="4">Search</th>
          </tr>
 		  <tr>
 		    <td width="78" class="tdLabel">User ID From </td>
 		    <td width="120"><input name="bill_id_from"style="width:120px;" type="text" value="<?=$bill_id_from?>" /></td>
 		    <td width="54">User ID To </td>
 		    <td width="120"><input name="bill_id_to" style="width:120px;"type="text" value="<?=$bill_id_to?>" /></td>
 		    </tr>
 		  <tr>
            <td class="tdLabel">Product name </td>
            <td><input name="bill_prod" type="text" id="bill_prod"style="width:120px;" value="<?=$bill_prod?>" /></td>
            <td>Topup ID </td>
            <td><input name="bill_topupid"type="text" id="bill_topupid" style="width:120px;" value="<?=$bill_topupid?>" /></td>
 		  </tr>
          
		  <tr>
            <td>&nbsp;</td>
                 <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                 <td align="right">&nbsp;</td>
                 <td>&nbsp;</td>
                 <input type="hidden" name="u_id" value="<?=$u_id?>"/>
		   </tr>
        </table>
     </form>
   <div align="right"> <a href="bill_f.php">Creat New Bill </a></div>
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
      <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="7%" align="left" nowrap="nowrap">User ID </th>
             <th width="8%" align="left" nowrap="nowrap">Topup/Recharge ID </th>
             <th width="8%" align="left" nowrap="nowrap">Bill No </th>
             <th width="8%" align="left" nowrap="nowrap">Bill Date </th>
			  <th width="23%" align="left" nowrap="nowrap"> Product </th>
			  <th width="9%" align="left" nowrap="nowrap">Taxable</th>
			  <th width="6%" align="left" nowrap="nowrap">Tax Rate </th>
              <th width="10%" align="left" nowrap="nowrap">Product Amt. </th>
              <th width="9%" align="left" nowrap="nowrap">Tax Amt</th>
              <th width="11%">Net Amount </th>
              <th width="3%">&nbsp;</th>
              <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	
 ?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$bill_userid?></td>
			<td nowrap="nowrap"><?=$bill_topupid?></td>
			<td nowrap="nowrap"><?=$bill_id?></td>
			<td nowrap="nowrap"><?=date_format2($bill_date)?></td>
			<td nowrap="nowrap"><?
				if ($bill_prodqty1>0) {
						echo $bill_prod1.'('.$bill_prodqty1.')';
 					}
					if ($bill_prodqty2>0) {
						echo $bill_prod2.'('.$bill_prodqty2.')';
					}
				 
				 ?></td>
			<td nowrap="nowrap"><?=$bill_taxable?></td>
			<td nowrap="nowrap"><?=$bill_tax_rate?></td>
			<td nowrap="nowrap"><?=$bill_prodamt1+$bill_prodamt2?></td>
			<td nowrap="nowrap"><?=$bill_prodtax?></td>
			<td align="center"><?=$bill_prodamt1+$bill_prodamt2+$bill_prodtax?></td>
			<td align="center"><a href="bill_f.php?bill_id=<?=$bill_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
            <td align="center"><input name="arr_bill_ids[]" type="checkbox" id="arr_bill_ids[]" value="<?=$bill_id?>" /></td>
           </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"><input name="Print" type="image" id="Print" src="images/buttons/submit.gif"  />
            <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_bill_ids[]')"/></td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
