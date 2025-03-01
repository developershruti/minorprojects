<?
require_once("../includes/surya.dream.php");

if(is_post_back()) {
	$arr_comp_ids = $_REQUEST['arr_comp_ids'];
	if(is_array($arr_comp_ids)) {
		$str_comp_ids = implode(',', $arr_comp_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_complain where comp_id in ($str_comp_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_complain set comp_status = 'Active' where comp_id in ($str_comp_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_complain set comp_status = 'Inactive' where comp_id in ($str_comp_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_complain, ngo_users  ";
$sql .= " where comp_userid=u_id  ";

if ($comp_is!='') {$sql .= " and comp_is='$comp_is' "; } else { $sql .= " and (comp_is='Open' OR comp_is IS NULL ) "; }
$sql = apply_filter($sql, $comp_title, $comp_title_filter,'comp_title');

$order_by == '' ? $order_by = 'comp_id' : true;
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
    <td id="pageHead"><div id="txtPageHead"> Complain List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content"><form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
          <tr>
            <td class="tdLabel">Title</td>
            <td><input name="comp_title" type="text" value="<?=$comp_title?>" />
              <?=filter_dropdown('comp_title_filter', $comp_title_filter)?></td>
          </tr>
		  <tr>
            <td class="tdLabel">Open/Close </td>
            <td><input name="comp_is" type="text" value="<?=$comp_is?>" />
              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
      <div align="right"> <a href="complain_f.php">Add New Complain </a></div>
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
            <th width="12%" align="center" nowrap="NOWRAP">Complain Ref No
              <?= sort_arrows('comp_id')?></th>
            <th width="16%" align="center" nowrap="NOWRAP">Complain by User ID
              <?= sort_arrows('u_username')?></th>
            <th width="13%" align="center" nowrap="NOWRAP">Complain by Name
              <?= sort_arrows('u_fname')?></th>
            <th width="16%" align="center" nowrap="NOWRAP">Mobile</th>
            <th width="39%" align="left" nowrap="NOWRAP">Title
              <?= sort_arrows('comp_title')?></th>
            <th width="13%" align="center" nowrap="NOWRAP">Complain </th>
            <th width="13%" align="center" nowrap="NOWRAP">Status
              <?= sort_arrows('comp_status')?></th>
            <th width="3%" nowrap="nowrap">Date</th>
            <th width="3%" nowrap="nowrap">&nbsp;</th>
            <th width="3%" nowrap="nowrap">&nbsp;</th>
            <th width="4%" nowrap="nowrap"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$new_complain = db_scalar("select count(*) from ngo_complain_reply where reply_compid='$comp_id' and reply_read='Unread'");
?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$comp_id?></td>
            <td nowrap="nowrap"><?=$u_username?></td>
            <td nowrap="nowrap"><?=$u_fname?></td>
            <td nowrap="nowrap"><?=$u_mobile?></td>
            <td nowrap="nowrap"><?=$comp_title?> </td>
            <td nowrap="nowrap"><?=$comp_is?></td>
            <td nowrap="nowrap"><?=$comp_status?></td>
            <td align="center" nowrap="nowrap"><?=$comp_date?></td>
            <td align="center" nowrap="nowrap"><a href="complain_details.php?comp_id=<?=$comp_id?>">Complain Details(
              <?=$new_complain?>
              )</a> </td>
            <td align="center"><a href="complain_f.php?comp_id=<?=$comp_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
            <td align="center"><input name="arr_comp_ids[]" type="checkbox" id="arr_comp_ids[]" value="<?=$comp_id?>" /></td>
          </tr>
          <? }
?>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"><input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_comp_ids[]')"/>
              <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_comp_ids[]')"/>
              <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_comp_ids[]')"/></td>
          </tr>
        </table>
      </form>
      <? }?>
      <? include("paging.inc.php");?>
    </td>
  </tr>
</table>
<? include("bottom.inc.php");?>
