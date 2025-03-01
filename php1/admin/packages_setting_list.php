<?
require_once("../includes/surya.dream.php");

if(is_post_back()) {
	$arr_bet_pack_ids = $_REQUEST['arr_bet_pack_ids'];
	if(is_array($arr_bet_pack_ids)) {
		$str_bet_pack_ids = implode(',', $arr_bet_pack_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_packages where bet_pack_id in ($str_bet_pack_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_packages set bet_pack_status = 'Active' where bet_pack_id in ($str_bet_pack_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_packages set bet_pack_status = 'Inactive' where bet_pack_id in ($str_bet_pack_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_packages ";
$sql .= " where 1 ";

$sql = apply_filter($sql, $bet_pack_title, $bet_pack_title_filter,'bet_pack_title');

$order_by == '' ? $order_by = 'bet_pack_id' : true;
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
       AI Packages Setting </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
                   <tr>
            <td class="tdLabel">Packages Name</td>
            <td><input name="bet_pack_title" type="text" value="<?=$bet_pack_title?>" />
            <?=filter_dropdown('bet_pack_title_filter', $bet_pack_title_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
          <!--  <div align="right"> <a href="packages_setting_f.php">Add New
         News      </a></div>-->
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
             
            <th width="20%" align="center" nowrap="nowrap">Packages Name <?= sort_arrows('bet_pack_title')?></th>
			<th width="50%" align="center" nowrap="nowrap">Short Msgs <?= sort_arrows('bet_pack_desc')?></th>
                      
            <th width="20%" align="center" nowrap="nowrap">Status <?= sort_arrows('bet_pack_status')?></th>
                                    <th width="8%">&nbsp;</th>                         
                  <th width="10%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
                        <td nowrap="nowrap"><?=$bet_pack_title?></td>
						<td nowrap="nowrap"><?=$bet_pack_desc?></td>
                        <td nowrap="nowrap"><?=$bet_pack_status?></td>
                                    <td align="center"><a href="packages_setting_f.php?bet_pack_id=<?=$bet_pack_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>                         
                                    <td align="center"><input name="arr_bet_pack_ids[]" type="checkbox" id="arr_bet_pack_ids[]" value="<?=$bet_pack_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">              <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_bet_pack_ids[]')"/>
              <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_bet_pack_ids[]')"/>
                         <?php /*?> <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_bet_pack_ids[]')"/><?php */?></td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
