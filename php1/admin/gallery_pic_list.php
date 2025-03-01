<?
require_once("../includes/surya.dream.php");

if(is_post_back()) {
	$arr_pic_ids = $_REQUEST['arr_pic_ids'];
	if(is_array($arr_pic_ids)) {
		$str_pic_ids = implode(',', $arr_pic_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$result = db_query("select * from  ngo_gallery_pic where pic_id in ($str_pic_ids)");
			while ($line_raw = mysqli_fetch_array($result)) {
				@unlink(UP_FILES_FS_PATH.'/gallery/'.$line_raw[pic_image]);
			}
			$sql = "delete from ngo_gallery_pic where pic_id in ($str_pic_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_gallery_pic set pic_status = 'Active' where pic_id in ($str_pic_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_gallery_pic set pic_status = 'Inactive' where pic_id in ($str_pic_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_gallery_pic ";
$sql .= " where 1 ";
 
 if ($gallery_id!='') { $sql .= " and pic_gallery_id='$gallery_id' "; } 
$order_by == '' ? $order_by = ' pic_id' : true;
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
       Pic List </div></td>
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
            <td class="tdLabel">Title</td>
            <td><input name="pic_name " type="text" value="<?=$pic_name ?>" />
            <?=filter_dropdown('pic_title_filter', $pic_title_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
            <div align="right"> <a href="product_pic_f.php?gallery_id=<?=$gallery_id?>">Add New Photo  </a></div>
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
               <th width="17%" align="center" nowrap="nowrap">Pic Id <?= sort_arrows('pic_id')?></th>
			  
               <th width="16%" align="center" nowrap="nowrap">Pic</th>
               <th width="57%" align="center" nowrap="nowrap">Pic Name                 <?= sort_arrows('pic_name ')?></th>
                      <!-- <th width="50%" align="center" nowrap="nowrap">Pic Description <?#= sort_arrows('pic_desc')?></th>-->
                       <th width="6%" align="center" nowrap="nowrap">  Status <?= sort_arrows('pic_status')?></th>
                                    <th width="2%">&nbsp;</th>                         
            <th width="2%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
                        <td nowrap="nowrap"><?=$pic_id?></td>
						<td nowrap="nowrap"> <img src="<?=show_thumb(UP_FILES_WS_PATH.'/gallery/'.$pic_image,190,142,'resize')?>"  align="center"  class="boximg-pad fade"  border="0"  /></td> 
						 
						<td nowrap="nowrap"><?=$pic_name ?></td>
                       <!-- <td nowrap="nowrap"><?#=$pic_desc?></td>-->
						 <td nowrap="nowrap"><?=$pic_status?></td>
                                    <td align="center"><a href="gallery_pic_f.php?pic_id=<?=$pic_id?>&gallery_id=<?=$gallery_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>   
									                      
                                    <td align="center"><input name="arr_pic_ids[]" type="checkbox" id="arr_pic_ids[]" value="<?=$pic_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">              <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_pic_ids[]')"/>
              <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_pic_ids[]')"/>
                          <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_pic_ids[]')"/></td>
          </tr>
        </table>
      </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
