<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
//print_r($_POST);
if(is_post_back()) {
	
	
	if($_POST['prod_image_del']!='') {
		$sql_edit_part .= ", prod_image = '' ";
	}
 	if($_FILES['prod_image']['name']!='') {
  $name = str_replace('.'.file_ext($_FILES['prod_image']['name']),'',$_FILES['prod_image']['name']).'_'.md5(uniqid(rand(), true));
	 $img_name=$name.'.'.file_ext($_FILES['prod_image']['name']);
     $ori_name=UP_FILES_FS_PATH.'/products/'.$img_name;
	 @copy($_FILES['prod_image']['tmp_name'],$ori_name);
		$sql_edit_part .= ", prod_image = '$img_name' ";
	}
		if($prod_id!='') {
		$sql = "update ngo_products set  prod_catid='$prod_catid',prod_name= '$prod_name', prod_desc = '$prod_desc',  prod_mrp = '$prod_mrp', prod_price = '$prod_price',prod_point = '$prod_point', prod_lastupdate = now() $sql_edit_part where prod_id = $prod_id";
		db_query($sql); 
	} else{
		$sql = "insert into ngo_products set prod_catid='$prod_catid',prod_name='$prod_name',prod_desc='$prod_desc', prod_mrp = '$prod_mrp',prod_price= '$prod_price', prod_point = '$prod_point',prod_date=now(),prod_image='$img_name' ";
		db_query($sql);
	}
	header("Location: products_list.php");
	exit;
}

$prod_id = $_REQUEST['prod_id'];
if(prod_id!='') {
	$sql = "select * from ngo_products where prod_id = '$prod_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		$line = ms_form_value($line_raw);
		@extract($line);
	}
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Products</div></td>
  </tr>
</table>
<div align="right"><a href="products_list.php">Back to  Products List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
 
    
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
         <tr>
      <td align="right"  class="tdLabel">Product Category:</td>
    <td width="575" class="tdData"><?
	 $sql ="select cat_id,cat_name from ngo_products_cat ";  
	 echo make_dropdown($sql, 'prod_catid', $prod_catid,  'class="txtfleid" style="width:200px;" alt="select" emsg="Please Select The Category"', 'Please select');
	?> </td>
    </tr>  <tr>
      <td width="183" align="right" valign="top" class="tdLabel">Product Title:</td>
      <td width="575" class="tdData"><textarea name="prod_name" cols="50" rows="4" class="textfield" id="prod_name"><?=$prod_name ?>
      </textarea></td>
    </tr>

     
         <tr>
      <td width="183" align="right" valign="top" class="tdLabel">Product Description:</td>
      <td width="575" class="tdData"><textarea name="prod_desc" id="prod_desc" rows="5" cols="50"  class="textfield"><?=$prod_desc?></textarea></td>
       </tr>
	 <tr>
		<td width="183" align="right" valign="top" class="tdLabel">Shipping  Info:</td>
        <td width="575" class="tdData"><input name="prod_shipping" type="text" id="prod_shipping" value="<?=$prod_shipping?>"  class="textfield"></td>
    </tr>
	<tr>
	<td width="183" align="right" valign="top" class="tdLabel">Product Back Info:</td>
    <td width="575" class="tdData"><input name="prod_back" type="text" id="prod_back" value="<?=$prod_back?>"  class="textfield"></td>
	</tr>	   
       
        <tr>
		<td width="183" align="right" valign="top" class="tdLabel">MRP:</td>
        <td width="575" class="tdData"><input name="prod_mrp" type="text" id="prod_mrp" value="<?=$prod_mrp?>"  class="textfield"></td>
    </tr>
	
		<tr>
		<td width="183" align="right" valign="top" class="tdLabel">Offer Price:</td>
        <td width="575" class="tdData"><input name="prod_price" type="text" id="prod_price" value="<?=$prod_price?>"  class="textfield"></td>
    </tr> 
	<tr>
		<td width="183" align="right" valign="top" class="tdLabel">Product Point:</td>
        <td width="575" class="tdData"><input name="prod_point" type="text" id="prod_point" value="<?=$prod_point?>"  class="textfield"></td>
    </tr> 	
    <? if($prod_image!='') { ?>
    <tr>
      <td width="183" align="right" valign="top" class="tdLabel">Current Product Image:</td>
      <td width="575" class="tdData"><img src="<?=UP_FILES_WS_PATH.'/'.$prod_image?>" width="150" /><br>Delete<input type="checkbox" name="prod_image_del" value="1"></td>
    </tr>		 
    <? }?>
	       <tr>
      <td width="183" class="tdLabel">Photo:</td>
      <td width="575" class="tdData"><input name="prod_image" type="file" id="prod_image" ></td>
    </tr>
	<tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="prod_id" value="<?=$prod_id?>" size="50">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
    <tr>
      <td class="tdLabel">&nbsp;</td>
      <td  class="tdData">&nbsp;</td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>