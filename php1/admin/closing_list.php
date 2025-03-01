<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
	$arr_close_ids = $_REQUEST['arr_close_ids'];
	if(is_array($arr_close_ids)) {
		$str_close_ids = implode(',', $arr_close_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			//$sql = "delete from ngo_closing where close_id in ($str_close_ids)";
			//db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_closing set close_status = 'Active' where close_id in ($str_close_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_closing set close_status = 'Inactive' where close_id in ($str_close_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_closing ";
$sql .= " where 1 ";

$sql = apply_filter($sql, $close_title, $close_title_filter,'close_title');

$order_by == '' ? $order_by = 'close_id' : true;
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
          <td id="pageHead"><div id="txtPageHead"> Closing    List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"><div align="right"> <a href="generate_payout_range.php">Generate Payout</a>&nbsp;|&nbsp;<a href="closing_f.php">&nbsp;Add New
              Closing </a></div>
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
                  <th width="5%" align="left" nowrap="nowrap">ID
                    <?= sort_arrows('close_id')?></th>
                 <!-- <th width="8%" align="left" nowrap="nowrap">Target
                    <? //= sort_arrows('close_target')?></th>-->
                  <th width="10%" align="left" nowrap="nowrap">Total Users
                    <?= sort_arrows('close_achieve')?></th>
                 <!-- <th width="9%" align="left" nowrap="nowrap">Achieve % </th>-->
                  <th width="12%" align="left" nowrap="nowrap">Start Date
                    <?= sort_arrows('close_startdate')?></th>
                  <th width="15%" align="left" nowrap="nowrap">Closing Date
                    <?= sort_arrows('close_enddate')?></th>
                  <th width="8%" align="left" nowrap="nowrap">Status </th>
                  <th width="7%">Edit By</th>
                 <!-- <th width="12%">Generate Payout</th>-->
                  <th width="3%">&nbsp;</th>
                  <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 
	$close_achieve = db_scalar("select count(*) from ngo_users where u_closeid ='$close_id'");
	if ($close_target!=0) { $achieve_per = round(($close_achieve*100/$close_target),2)."%"; }
?>
                <tr class="<?=$css?>">
                  <td nowrap="nowrap"><?=$close_id?></td>
                 <!-- <td nowrap="nowrap"><? //=$close_target?></td>-->
                  <td nowrap="nowrap"><?=$close_achieve?></td>
                 <!-- <td nowrap="nowrap"><? //=$achieve_per?></td>-->
                  <td nowrap="nowrap"><?=date_format2($close_startdate)?></td>
                  <td nowrap="nowrap"><?=date_format2($close_enddate)?></td>
                  <td nowrap="nowrap"><?=$close_status?></td>
                  <td align="center"><?=$close_user?></td>
                  <!--<td align="center"><a href="generate_payout.php?close_id=<? //=$close_id?>">Generate Payout</a> &nbsp;&nbsp; <a href="generate_payout_range.php?close_id=<? //=$close_id?>"></a></td>-->
                  <td align="center"><a href="closing_f.php?close_id=<?=$close_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                  <td align="center"><input name="arr_close_ids[]" type="checkbox" id="arr_close_ids[]" value="<?=$close_id?>" /></td>
                </tr>
                <? }
?>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right" style="padding:2px"><input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_close_ids[]')"/>
                    <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_close_ids[]')"/>
                    <!-- <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_close_ids[]')"/>--></td>
                </tr>
              </table>
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
