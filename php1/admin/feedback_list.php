<?php
require_once('../includes/surya.dream.php');

if (is_post_back()) {
  $arr_feedback_ids = $_REQUEST['arr_feedback_ids'];
  if (is_array($arr_feedback_ids)) {
    $str_feedback_ids = implode(',', $arr_feedback_ids);
    if (isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x'])) {
      $sql = "delete from ngo_feedback where feedback_id in ($str_feedback_ids)";
      db_query($sql);
    } else if (isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x'])) {
      $sql = "update ngo_feedback set status = 'Active' where feedback_id in ($str_feedback_ids)";
      db_query($sql);
    } else if (isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x'])) {
      $sql = "update ngo_feedback set status = 'Inactive' where feedback_id in ($str_feedback_ids)";
      db_query($sql);
    }
    header("Location: feedback_list.php?msg=" . urlencode($msg));
    exit;
  }
}


protect_user_page();

$start = intval($start);
$pagesize = intval($pagesize) == 0 ? $pagesize = DEF_PAGE_SIZE : $pagesize;
$sql = "SELECT COUNT(*) as total FROM ngo_feedback";
$result = db_query($sql);
$row = mysqli_fetch_array($result);
$reccnt = $row['total'];

$sql = "SELECT * FROM ngo_feedback ORDER BY feedback_id DESC LIMIT $start, $pagesize";
$result = db_query($sql);
?>

<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php"); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead">
      <div id="txtPageHead">
        Feedback List </div>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
      <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
          <tr>
            <td class="tdLabel">Title</td>
            <td><input name="static_title" type="text" value="<?= $feedback_title ?>" />
              <?= filter_dropdown('static_title_filter', $static_title_filter) ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?= $pagesize ?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" />
            </td>
          </tr>
        </table>
      </form>
      <br />
      <div align="right"> <a href="feedback_f.php">Add New Feedback</a></div>
      <? if (mysqli_num_rows($result) == 0) { ?>
        <div class="msg">Sorry, no records found.</div>
      <? } else { ?>
        <div align="right"> Showing Records:
          <?= $start + 1 ?>
          to
          <?= ($reccnt < $start + $pagesize) ? ($reccnt - $start) : ($start + $pagesize) ?>
          of
          <?= $reccnt ?>
        </div>
        <div>Records Per Page:
          <?= pagesize_dropdown('pagesize', $pagesize); ?>
        </div>
        <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
          <table width="100%" border="0" cellpadding="0" cellspacing="1" class="tableList">
            <tr>



              <th nowrap="nowrap">Id <?= sort_arrows('feedback_id') ?></th>
              <th nowrap="nowrap">Title <?= sort_arrows('feedback_title') ?></th>
              <th nowrap="nowrap">Rating <?= sort_arrows('feedback_rating') ?></th>
              <th nowrap="nowrap">Description <?= sort_arrows('feedback_desc') ?></th>

              <th nowrap="nowrap">Status <?= sort_arrows('feedback_status') ?></th>
              <th>&nbsp;</th>
              <th><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
            </tr>
            <?
            while ($line_raw = mysqli_fetch_array($result)) {
              $line = ms_display_value($line_raw);
              @extract($line);
              $css = ($css == 'trOdd') ? 'trEven' : 'trOdd';
            ?>
              <tr class="<?= $css ?>">
                <td nowrap="nowrap"><?= $feedback_id ?></td>
                <td nowrap="nowrap"><?= $feedback_title ?></td>
                <td nowrap="nowrap"><?= $feedback_rating ?></td>

                <td nowrap="nowrap">
                  <?= (strlen($feedback_desc) > 90) ? substr($feedback_desc, 0, 80) . '...' : $feedback_desc ?>

                </td>
                <td nowrap="nowrap"><?= $STATUS ?></td>
                <td align="center">
                  <a href="feedback_f.php?feedback_id=<?= $feedback_id ?>">
                    <img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a>
                </td>
                <td align="center"><input name="arr_feedback_ids[]" type="checkbox" id="arr_feedback_ids[]" value="<?= $feedback_id ?>" /></td>
              </tr>
            <? }
            ?>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <!-- <td align="right" style="padding:2px"> <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_feedback_ids[]')" /> -->
              <td align="right" style="padding:2px">

                <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_feedback_ids[]')" />
                <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_feedback_ids[]')" />
                <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_feedback_ids[]')" />
              </td>
    </td>
  </tr>
</table>
</form>
<? } ?> <? include("paging.inc.php"); ?>
</td>
</tr>
</table>

<? include("bottom.inc.php"); ?>