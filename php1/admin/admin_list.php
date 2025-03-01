<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
	$arr_adm_userids = $_REQUEST['arr_adm_userids'];
	if(is_array($arr_adm_userids)) {
		$str_adm_userids = implode(',', $arr_adm_userids);
			$sql = "delete from ngo_admin where adm_userid in ($str_adm_userids)";
			db_query($sql);
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_admin ";
$sql .= " where 1 ";

$sql = apply_filter($sql, $adm_login, $adm_login_filter,'adm_login');

$order_by == '' ? $order_by = 'adm_userid' : true;
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
       Admin    List </div></td>
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
            <td class="tdLabel">Login Id</td>
            <td><input name="adm_login" type="text" value="<?=$adm_login?>" />
            <?=filter_dropdown('adm_login_filter', $adm_login_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
            <div align="right"> <a href="admin_f.php">Add New
         Admin      </a></div>
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
                                    
            <th nowrap="nowrap">Login            Id<?= sort_arrows('adm_login')?></th>
                      
            <th nowrap="nowrap">Password            <?= sort_arrows('adm_password')?></th>
                      
            <th nowrap="nowrap">Name            <?= sort_arrows('adm_name')?></th>
                      
            <th nowrap="nowrap">Type            <?= sort_arrows('adm_type')?></th>
                      
            <th nowrap="nowrap">Date            <?= sort_arrows('adm_date')?></th>
                                    <th>&nbsp;</th>                         <th><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                      </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
                                    <td nowrap="nowrap"><?=$adm_login?></td>
                        <td nowrap="nowrap"><?=$adm_password?></td>
                        <td nowrap="nowrap"><?=$adm_name?></td>
                        <td nowrap="nowrap"><?=$adm_type?></td>
                        <td nowrap="nowrap"><?=$adm_date?></td>
                                    <td align="center"><a href="admin_f.php?adm_userid=<?=$adm_userid?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>                         <td align="center"><input name="arr_adm_userids[]" type="checkbox" id="arr_adm_userids[]" value="<?=$adm_userid?>" /></td>
                      </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">            <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_adm_userids[]')"/></td>
          </tr>
        </table>
              </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
