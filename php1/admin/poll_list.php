<?
require_once("../includes/surya.dream.php");
protect_admin_page();
if(is_post_back()) {
	$arr_qids = $_REQUEST['arr_qids'];
	if(is_array($arr_qids)) {
		$str_qids = implode(',', $arr_qids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_pollv2_question where qid in ($str_qids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_pollv2_question set faq_status = 'Active' where qid in ($str_qids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_pollv2_question set faq_status = 'Inactive' where qid in ($str_qids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_pollv2_question ";
$sql .= " inner join ngo_pollv2 on ngo_pollv2_question.pollid = ngo_pollv2.id ";
$sql .= " where 1=1  ";
$sql = apply_filter($sql, $id, '=','id');
$sql = apply_filter($sql, $question, $question_filter,'question');

$order_by == '' ? $order_by = 'qid' : true;
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
          <td id="pageHead"><div id="txtPageHead"> Survey Question   List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"><form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <br />
              <table width="318"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="2">Search</th>
                </tr>
                <tr>
                  <td class="tdLabel">Survey Name</td>
                  <td><?=make_dropdown(" select id, pollname from ngo_pollv2 order by pollname", 'id', $id)?></td>
                </tr>
                <tr>
                  <td class="tdLabel"> Question</td>
                  <td><input name="question" type="text" value="<?=$question?>" />
                    <?=filter_dropdown('question_filter', $question_filter)?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                </tr>
              </table>
            </form>
            <br />
            <div align="right"><a href="poll_category_list.php">Back to Survey List</a> | <a href="poll_f.php?id=<?=$id?>">Add New Question </a></div>
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
                  <th width="26%" align="left" nowrap="nowrap">Survey   Title <?= sort_arrows('pollname')?> </th>
                  <th width="55%" align="left" nowrap="nowrap">Question  <?= sort_arrows('question')?></th>
                  <th width="10%" nowrap="nowrap">Color</th>
                  <th width="10%" nowrap="nowrap">Size</th>
                  <th width="10%" nowrap="nowrap">Updated</th>
                  <th width="10%" nowrap="nowrap">Created </th>
                  <th width="5%">&nbsp;</th>
                  <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
                <tr class="<?=$css?>">
                  <td  nowrap="nowrap"><?=$pollname?>                  </td>
                  <td nowrap="nowrap"><?=$question?></td>
                  <td nowrap="nowrap"><?=$pollcolor?></td>
                  <td nowrap="nowrap"><?=$pollsize?></td>
                  <td nowrap="nowrap"><?=date_format2($updated)?></td>
                  <td nowrap="nowrap"><?=date_format2($created)?></td>
                  <td align="center"><a href="poll_f.php?qid=<?=$qid?>&id=<?=$id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                  <td align="center"><input name="arr_qids[]" type="checkbox" id="arr_qids[]" value="<?=$qid?>" /></td>
                </tr>
                <? }
?>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right" style="padding:2px"><input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_qids[]')"/>
                    <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_qids[]')"/>
                    <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_qids[]')"/></td>
                </tr>
              </table>
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
