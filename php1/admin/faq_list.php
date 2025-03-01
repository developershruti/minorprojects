<?
require_once("../includes/surya.dream.php");

if(is_post_back()) {
	$arr_faq_ids = $_REQUEST['arr_faq_ids'];
	if(is_array($arr_faq_ids)) {
		$str_faq_ids = implode(',', $arr_faq_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_faq where faq_id in ($str_faq_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_faq set faq_status = 'Active' where faq_id in ($str_faq_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_faq set faq_status = 'Inactive' where faq_id in ($str_faq_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_faq ";
$sql .= " inner join ngo_faq_category on ngo_faq.faq_cat_id = ngo_faq_category.cat_id ";
$sql .= " where 1=1  ";
$sql = apply_filter($sql, $faq_cat_id, '=','faq_cat_id');

$sql = apply_filter($sql, $cat_name, $cat_name_filter,'cat_name');

$order_by == '' ? $order_by = 'faq_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= " order by $order_by $order_by2 ";

$sql .= " limit $start, $pagesize ";
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
      Faq    List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table width="401"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
          <tr>
            <td class="tdLabel">Cat Name</td>
            <td>
              <?=make_dropdown(" select cat_id, cat_name from ngo_faq_category order by cat_name", 'cat_id', $cat_id)?></td>
          </tr>
		            <tr>
            <td class="tdLabel"></td>
            <td><input name="cat_name" type="text" value="<?=$cat_name?>" />
            <?=filter_dropdown('cat_name_filter', $cat_name_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
            <div align="right"><a href="faq_category_list.php">Back to Faq Category        List</a> |  <a href="faq_f.php?cat_id=<?=$cat_id?>">Add New
        Faq      </a></div>
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
                        <th nowrap="nowrap">Cat Name              <?= sort_arrows('cat_name')?>
            </th>
                                      
            <th nowrap="nowrap">Question            <?= sort_arrows('faq_question')?></th>
                      
            <th nowrap="nowrap">Status            <?= sort_arrows('faq_status')?></th>
                                    <th>&nbsp;</th>                         <th><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
                        <td  nowrap="nowrap"><?=$cat_name?>            </td>
                                    <td nowrap="nowrap"><?=$faq_question?></td>
                        <td nowrap="nowrap"><?=$faq_status?></td>
                                    <td align="center"><a href="faq_f.php?faq_id=<?=$faq_id?>&amp;cat_id=<?=$cat_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>                         
                                    <td align="center"><input name="arr_faq_ids[]" type="checkbox" id="arr_faq_ids[]" value="<?=$faq_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">              <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_faq_ids[]')"/>
              <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_faq_ids[]')"/>
                          <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_faq_ids[]')"/></td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
