<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
//print_r($_POST);
if(is_post_back()) {
	$arr_image_ids = $_REQUEST['arr_image_ids'];
	if(is_array($arr_image_ids)) {
		$str_image_ids = implode(',', $arr_image_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_image where image_id in ($str_image_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_image set image_status = 'Active' where image_id in ($str_image_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_image set image_status = 'Inactive' where image_id in ($str_image_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Update']) || isset($_REQUEST['Update_x']) ) {
			#$sql = "update ngo_image set image_catid = '$image_catid' where image_id in ($str_image_ids)";
			#db_query($sql);
		} else if(isset($_REQUEST['Featured']) || isset($_REQUEST['Featured_x']) ) {
			$sql = "update ngo_image set image_featured = 'featured' where image_id in ($str_image_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['unFeatured']) || isset($_REQUEST['unFeatured_x']) ) {
			$sql = "update ngo_image set image_featured = 'unfeatured' where image_id in ($str_image_ids)";
			db_query($sql);
				
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_image ";
$sql .= " where 1 ";
//$sql.=" and ngo_image.image_catid=mind_imageuct_category.cat_id ";

$sql = apply_filter($sql, $image_name, $u_name_filter,'image_name');
if ($image_catid!='' ) {$sql .= " and  image_catid='$image_catid'"; } 

 $order_by == '' ? $order_by = ' ngo_image.image_id' : true;
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
          <td id="pageHead"><div id="txtPageHead">Display Creatives </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"><form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
            </form>
            <br />
            <div align="right"> <a href="popup_add.php">Add New Popup</a></div>
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
                  <th width="8%" align="left" nowrap="nowrap"> ID  <?= sort_arrows('image_id')?></th>
                  <th   width="10%" align="left" nowrap="nowrap"> Page</th>
				   <th  align="left" nowrap="nowrap"> Popup  Images</th>
                  <th width="50%" align="left" nowrap="nowrap"> Popup desc <?= sort_arrows('image_desc')?></th>
                   <th width="6%" align="left" nowrap="nowrap">Status <?= sort_arrows('image_status')?></th>
                  <th width="3%"> </th>
                  <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
    $css = ($css=='trOdd')?'trEven':'trOdd';
	///$cat_name = db_scalar("select cat_name from ngo_image_cat  where cat_id='$image_catid'");
?>
                <tr class="<?=$css?>">
                  <td nowrap="nowrap"><?=$image_id?></td>
				  <td nowrap="nowrap"><?=$image_title?></td>
				  
                  <td width="6%" nowrap="nowrap"><img src="<?=(UP_FILES_WS_PATH.'/news/'.$image_image );?>"  height="100px" align="center"   border="0" class="txtbox"/> </td>
                  <td ><?=$image_desc?></td>
                  <td nowrap="nowrap" align="center"><?=$image_status?></td>
                  <td align="center"><a href="popup_add.php?image_id=<?=$image_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                  <td align="center"><input name="arr_image_ids[]" type="checkbox" id="arr_image_ids[]" value="<?=$image_id?>" /></td>
                </tr>
                <? }
?>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td ><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="tdLabel"><!--Product Categry-->
                        </td>
                        <td  ><?
	 #$sql123 ="select cat_id,cat_name from ngo_image_cat ";  
	# echo make_dropdown($sql123, 'image_catid', $image_catid,  'class="txtfleid" style="width:200px;" alt="select" emsg="Please Select The Category"', 'Please select');
	?>
                        </td>
                        <td ><!--<input name="Update" type="image" id="Update" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_image_ids[]')"/>-->
                        </td>
                      </tr>
                    </table></td>
                  <td align="right" style="padding:2px"><!--<input name="unFeatured" type="image" id="unFeatured" src="images/buttons/unfeatured.gif" onclick="return unfeaturedConfirmFromUser('arr_image_ids[]')"/>
              <input name="Featured" type="image" id="Featured" src="images/buttons/featured.gif" onclick="return featuredConfirmFromUser('arr_image_ids[]')"/>-->
                    <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_image_ids[]')"/>
                    <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_image_ids[]')"/>
                    <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_image_ids[]')"/></td>
                </tr>
              </table>
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
