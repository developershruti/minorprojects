<?
require_once("../includes/surya.dream.php");

if(is_post_back()) {
 	$arr_win_ids = $_REQUEST['arr_win_ids'];
	 
	if(is_array($arr_win_ids)) {
		$str_win_ids = implode(',', $arr_win_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_rewards_winner where win_id in ($str_win_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_rewards_winner set ticket_status = 'Active' where win_id in ($str_win_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_rewards_winner set ticket_status = 'Inactive' where win_id in ($str_win_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_rewards_winner ";
$sql .= " where 1 ";

//$sql = apply_filter($sql, $ticket_username, $ticket_username_filter,'ticket_username');

$order_by == '' ? $order_by = 'win_id' : true;
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
    <td id="pageHead"><div id="txtPageHead"> Reward Redeem List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content"><!--<form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
                   <tr>
            <td class="tdLabel">Username</td>
             <td><input name="ticket_username" type="text" value="<?=$ticket_username?>" />
            <? //=filter_dropdown('ticket_username_filter', $ticket_username_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>-->
      <br />
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
            <th width="9%" align="center" nowrap="nowrap">Win Id
              <?= sort_arrows('win_id')?></th>
            <th width="9%" align="center" nowrap="nowrap">Win User Id 
              <?= sort_arrows('win_userid')?></th>
            <th width="11%" align="center" nowrap="nowrap">Win Reward Id
              <?= sort_arrows('ticket_userid')?></th>
            <th width="11%" align="center" nowrap="nowrap">Username</th>
              
            <th width="9%" align="center" nowrap="nowrap">Win Mailing Name</th>
            <th width="6%" align="center" nowrap="nowrap">Address </th>
            <th width="19%" align="center" nowrap="nowrap">City </th>
            <th width="8%" align="center" nowrap="nowrap">State</th>
			 <th width="8%" align="center" nowrap="nowrap">Email</th>
             <th width="7%" align="center" nowrap="nowrap">Mobile </th>
            <th width="6%" align="center" nowrap="nowrap">Win Rec Amount</th>
			<th width="6%" align="center" nowrap="nowrap">Win Rec Id</th>
			<th width="6%" align="center" nowrap="nowrap">Win Rec Name</th>
            <th width="5%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$win_id?></td>
            <td nowrap="nowrap"><?=$win_userid?></td>
            <td nowrap="nowrap"><?=$win_rewaid?></td>
            <td nowrap="nowrap"><?=$u_ref_fname = db_scalar("select  u_username from ngo_users where u_id = '$win_userid'");?>
			
			<? //=$ticket_username?></td>
            <td nowrap="nowrap"><?=$win_mailling_name?></td>
            <td nowrap="nowrap"><?=$win_mailling_address?></td>
            <td nowrap="nowrap"><?=$win_mailling_city?></td>
			<td nowrap="nowrap"><?=$win_mailling_state?></td>
            <td nowrap="nowrap"><?=$win_mailling_email?></td>
            <td nowrap="nowrap"><?=$win_mailling_tele?></td>
            <td nowrap="nowrap"><?=$win_rec_amount?></td>
			<td nowrap="nowrap"><?=$win_rec_userid?></td>
			<td nowrap="nowrap"><?=$win_rec_name?></td>
            <td align="center"><input name="arr_win_ids[]" type="checkbox" id="arr_win_ids[]" value="<?=$win_id?>" /></td>
          </tr>
          <? }
?>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"><!--<input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_win_ids[]')"/>
										<input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_win_ids[]')"/>-->
              <!--	<input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_win_ids[]')"/>-->
            </td>
          </tr>
        </table>
      </form>
      <? }?>
      <? include("paging.inc.php");?>
    </td>
  </tr>
</table>
<? include("bottom.inc.php");?>
