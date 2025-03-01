<?
require_once("../includes/surya.dream.php");

if(is_post_back()) {
	$arr_gallery_ids = $_REQUEST['arr_gallery_ids'];
	if(is_array($arr_gallery_ids)) {
		$str_gallery_ids = implode(',', $arr_gallery_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_gallery where gallery_id in ($str_gallery_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_gallery set gallery_status = 'Active' where gallery_id in ($str_gallery_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_gallery set gallery_status = 'Inactive' where gallery_id in ($str_gallery_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_gallery ";
$sql .= " where 1 ";

$sql = apply_filter($sql, $gallery_name, $gallery_name_filter,'gallery_name');

$order_by == '' ? $order_by = 'gallery_id' : true;
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
       Gallery List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
            <form method="get" name="form2" id="form2" onSubmit="return confirm_submit(this)">
        <br />
        <table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
                   <tr>
            <td class="tdLabel">Title</td>
            <td><input name="gallery_name" type="text" value="<?=$gallery_name?>" />
            <?=filter_dropdown('gallery_name_filter', $gallery_name_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
            <div align="right"> <a href="gallery_f.php">Add New
         Photo Gallery </a></div>
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
      <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
             
            <th width="31%" align="center" nowrap="nowrap">Title            <?= sort_arrows('gallery_name')?></th>
            <th width="31%" align="center" nowrap="nowrap">Image</th>
            <th width="50%" align="center" nowrap="nowrap">Status            <?= sort_arrows('gallery_status')?></th>
                                    <th width="8%">&nbsp;</th>                         
                  <th width="11%"><input name="check_all" type="checkbox" id="check_all" value="1" onClick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
                        <td nowrap="nowrap"><?=$gallery_name?></td>
                        <td nowrap="nowrap"><img src="<?=UP_FILES_WS_PATH.'/gallery/'.$gallery_image?>" width="98" /></td>

                        <td nowrap="nowrap"><?=$gallery_status?></td>
                                    <td align="center"><a href="gallery_f.php?gallery_id=<?=$gallery_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>                         
                                    <td align="center"><input name="arr_gallery_ids[]" type="checkbox" id="arr_gallery_ids[]" value="<?=$gallery_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">              <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onClick="return activateConfirmFromUser('arr_gallery_ids[]')"/>
              <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onClick="return deactivateConfirmFromUser('arr_gallery_ids[]')"/>
                          <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onClick="return deleteConfirmFromUser('arr_gallery_ids[]')"/></td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
