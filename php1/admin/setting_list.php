<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_setting ";
$sql .= " where sett_status='Active' ";

$sql = apply_filter($sql, $sett_title, $sett_title_filter,'sett_title');

$order_by == '' ? $order_by = 'sett_id' : true;
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
       Setting    List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
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
             <th nowrap="nowrap">Setting Title             <?= sort_arrows('sett_title')?></th>
             <th nowrap="nowrap">Code</th>
             <th nowrap="nowrap">Payout No </th>
             <th nowrap="nowrap">Value            <?= sort_arrows('sett_value')?></th>
             <th nowrap="nowrap">Unit
              <?= sort_arrows('sett_unit')?></th>
            <th nowrap="nowrap">Last Update </th>
            <th nowrap="nowrap">Edit By </th>
			<th nowrap="nowrap"> </th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
                        <td nowrap="nowrap"><?=$sett_title?></td>
					    <td nowrap="nowrap"><?=$sett_code?></td>
					    <td nowrap="nowrap"><?=$sett_payoutno?></td>
					    <td nowrap="nowrap"><?=$sett_value?></td>
                        <td nowrap="nowrap"><?=$sett_unit?></td>
                        <td nowrap="nowrap"><?=$sett_lastupdate?></td>
						<td nowrap="nowrap"><?=$sett_admin?></td>
                        <td align="center"><a href="setting_f.php?sett_id=<?=$sett_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>  
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">&nbsp;</td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
