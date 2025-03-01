<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
//print_r($_POST);
if(is_post_back()) {
	$arr_prod_ids = $_REQUEST['arr_prod_ids'];
	if(is_array($arr_prod_ids)) {
		$str_prod_ids = implode(',', $arr_prod_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_products where prod_id in ($str_prod_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_products set prod_status = 'Active' where prod_id in ($str_prod_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_products set prod_status = 'Inactive' where prod_id in ($str_prod_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Update']) || isset($_REQUEST['Update_x']) ) {
			$sql = "update ngo_products set prod_catid = '$prod_catid' where prod_id in ($str_prod_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Featured']) || isset($_REQUEST['Featured_x']) ) {
			$sql = "update ngo_products set prod_featured = 'featured' where prod_id in ($str_prod_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['unFeatured']) || isset($_REQUEST['unFeatured_x']) ) {
			$sql = "update ngo_products set prod_featured = 'unfeatured' where prod_id in ($str_prod_ids)";
			db_query($sql);
				
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_products ";
$sql .= " where 1 ";
//$sql.=" and ngo_products.prod_catid=mind_product_category.cat_id ";

$sql = apply_filter($sql, $prod_name, $u_name_filter,'prod_name');
if ($prod_catid!='' ) {$sql .= " and  prod_catid='$prod_catid'"; } 



$order_by == '' ? $order_by = ' ngo_products.prod_id' : true;
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
    <td id="pageHead"><div id="txtPageHead">Product List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="2">Search</th>
          </tr>
                   <tr>
                     <td class="tdLabel">Product Categry </td>
                     <td><span class="tdData">
                       <?
	 $sql ="select cat_id,cat_name from ngo_products_cat ";  
	 echo make_dropdown($sql, 'prod_catid', $prod_catid,  'class="txtfleid" style="width:200px;" alt="select" emsg="Please Select The Category"', 'Please select');
	?>
                     </span></td>
                   </tr>
                   <tr>
            <td width="63" class="tdLabel">Product Title</td>
            <td width="269"><input name="prod_name" type="text" value="<?=$prod_name?>" />
            <?=filter_dropdown('u_name_filter', $u_name_filter)?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
        <div align="right"> <a href="products_f.php">Add New Product</a></div>
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
            <th width="10%" align="left" nowrap="nowrap">Product ID
              <?= sort_arrows('prod_id')?></th>
			   <th width="10%" align="left" nowrap="nowrap">Product Image</th>
            <th width="36%" align="left" nowrap="nowrap">Product name
              <?= sort_arrows('prod_name')?></th>
			   <th width="36%" align="left" nowrap="nowrap">Cat name
             </th>
            <th width="12%" align="left" nowrap="nowrap">Product Price
                <?= sort_arrows('prod_price')?></th>
        
            <th width="13%" align="left" nowrap="nowrap">Last Update
                <?= sort_arrows('prod_lastupdate')?></th>
            <th width="7%" align="left" nowrap="nowrap">Featured
                <?= sort_arrows('prod_featured')?></th>
				 <th width="7%" align="left" nowrap="nowrap">Status
                <?= sort_arrows('prod_status')?></th>
            <th width="3%" align="left" nowrap="nowrap">&nbsp;</th>
            <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
    $css = ($css=='trOdd')?'trEven':'trOdd';
	$cat_name = db_scalar("select cat_name from ngo_products_cat  where cat_id='$prod_catid'");
?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$prod_id?></td>
			<td nowrap="nowrap"><img src="<?=show_thumb(UP_FILES_WS_PATH.'/products/'.$prod_image,75,75,'height')?>"  align="center"   border="0" class="txtbox"/> </td>
            <td nowrap="nowrap"><?=$prod_name?></td>
			<td nowrap="nowrap"><?=$cat_name?></td>
            <td nowrap="nowrap" align="center"><?=$prod_price?></td>
        
            <td nowrap="nowrap" align="center"><?=$prod_lastupdate?></td>
            <td nowrap="nowrap" align="center"><?=$prod_featured?></td>
			<td nowrap="nowrap" align="center"><?=$prod_status?></td>
            <td align="center"><a href="products_f.php?prod_id=<?=$prod_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
            <td align="center"><input name="arr_prod_ids[]" type="checkbox" id="arr_prod_ids[]" value="<?=$prod_id?>" /></td>
          </tr>
          <? }
?>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr><td >
             <table border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td class="tdLabel">Product Categry </td>
            <td  > 
              <?
	 $sql123 ="select cat_id,cat_name from ngo_products_cat ";  
	 echo make_dropdown($sql123, 'prod_catid', $prod_catid,  'class="txtfleid" style="width:200px;" alt="select" emsg="Please Select The Category"', 'Please select');
	?>
            </td>
			<td > 	<input name="Update" type="image" id="Update" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_prod_ids[]')"/> </td>
			</tr></table>
			</td>
            <td align="right" style="padding:2px">
			<input name="unFeatured" type="image" id="unFeatured" src="images/buttons/unfeatured.gif" onclick="return unfeaturedConfirmFromUser('arr_prod_ids[]')"/>
			<input name="Featured" type="image" id="Featured" src="images/buttons/featured.gif" onclick="return featuredConfirmFromUser('arr_prod_ids[]')"/>
			<input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_prod_ids[]')"/>
              <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_prod_ids[]')"/>
                          <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_prod_ids[]')"/></td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
