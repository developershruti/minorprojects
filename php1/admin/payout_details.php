<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
//print_r($_POST);
	$arr_upay_ids = $_REQUEST['arr_upay_ids'];
	if(is_array($arr_upay_ids)) {
		$str_upay_ids = implode(',', $arr_upay_ids);
		if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ){
 			   $sql_update="update ngo_users_payout set upay_pay_status='Paid',upay_paydate=now() where upay_id in ($str_upay_ids)";
 			 db_query($sql_update);
  			 
		}
		 
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
  }
}

 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users_payout ,ngo_users  where ngo_users_payout.upay_userid=ngo_users.u_id  and  upay_closeid='$close_id' and upay_pono='$pono'  ";

$sql = apply_filter($sql, $u_username, $u_username_filter,'u_username');
$order_by == '' ? $order_by = 'u_username' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
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
       Payout details </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
		<div align="right"><a href="generate_payout.php?pono=<?=$pono?>&amp;close_id=<?=$close_id?>&amp;pay_close_id=<?=$pay_close_id?>">Back to Closing List</a>&nbsp;</div>
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table width="368"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
                   <tr>
            <td class="tdLabel">Username</td>
            <td><input name="u_username" type="text" value="<?=$u_username?>" />
             <?=filter_dropdown('u_username_filter', $u_username_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
			<input type="hidden" name="close_id" value="<?=$close_id?>"/>
			<input type="hidden" name="pono" value="<?=$pono?>"/>
                 <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
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
            <th width="6%" nowrap="nowrap">User ID</th>
            <th width="16%" nowrap="nowrap">Name <?= sort_arrows('u_username')?></th>
			<th width="22%" nowrap="nowrap">Address</th>
            <th width="9%" nowrap="nowrap">member type</th>
             <th width="10%" nowrap="nowrap">Payout type </th>
             <th width="6%" nowrap="nowrap">Amount</th>
 			<th width="7%" nowrap="nowrap">Pay Status</th>
			<th width="11%" nowrap="nowrap">Payment Dated</th>
  			<th width="6%" nowrap="nowrap">By</th>
			<th width="7%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
            </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
 ?>
          <tr class="<?=$css?>">
				<td nowrap="nowrap"><?=$u_id?></td>
				<td nowrap="nowrap"><?=$u_fname?> </td>
				<td ><?=$u_address?></td>
				<td nowrap="nowrap"><?=$u_utype_value?></td>
				<td nowrap="nowrap"><?=$upay_for?></td>
				<td nowrap="nowrap"><?=$upay_amount?></td>
 				<td nowrap="nowrap"><?=$upay_pay_status?></td>
				<td nowrap="nowrap"><?=date_format2($upay_paydate)?></td>
				<td nowrap="nowrap"><?=$upay_admin?></td>
				 <td align="center"><input name="arr_upay_ids[]" type="checkbox" id="arr_upay_ids[]" value="<?=$upay_id?>"/></td>
             </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" style="padding:2px"><input name="Submit" type="image" id="Submit" src="images/buttons/submit.gif" onclick="return paidConfirmFromUser('arr_upay_ids[]')"/>
			 </td>
                  </tr>
        </table>
      </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
