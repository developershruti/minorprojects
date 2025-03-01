<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {

if($_POST['gallery_image_del']!='') {
		@unlink(UP_FILES_FS_PATH.'/gallery/'.$old_gallery_image);
		$sql_edit_part = ", gallery_image = '' ";
	}
	
	 if($_FILES['gallery_image']['name']!='') {
  $name = str_replace('.'.file_ext($_FILES['gallery_image']['name']),'',$_FILES['gallery_image']['name']).'_'.md5(uniqid(rand(), true));
	 $gallery_image=$name.'.'.file_ext($_FILES['gallery_image']['name']);
     $ori_name=UP_FILES_FS_PATH.'/gallery/'.$gallery_image;
	 @copy($_FILES['gallery_image']['tmp_name'],$ori_name);
		$sql_edit_part = " ,gallery_image = '$gallery_image' ";
	}
 
  
	if($gallery_id!='') {
		$sql = "update ngo_gallery set   gallery_name = '$gallery_name' , gallery_desc = '$gallery_desc' $sql_edit_part  where gallery_id = $gallery_id" ;
		db_query($sql);
	} else{
		$sql = "insert into  ngo_gallery set gallery_name = '$gallery_name' , gallery_desc = '$gallery_desc' , gallery_date =now()  $sql_edit_part ";
		db_query($sql);
	}
	header("Location: product_list.php");
	exit;
}

$gallery_id = $_REQUEST['gallery_id'];
if($gallery_id!='') {
	$sql = "select * from  ngo_gallery where gallery_id = '$gallery_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
	}
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Add/ Update Gallery Category </div></td>
  </tr>
</table>
<div align="right"><a href="product_list.php">Back to Gallery List</a>&nbsp;</div>
<form name="form1" method="post"  enctype="multipart/form-data" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	    
	  <tr>
      <td width="81" class="tdLabel">Product  Name:</td>
      <td width="702" class="tdData"><input name="gallery_name" type="text" id="gallery_name" value="<?=$gallery_name?>" alt="blank" emsg="Please enter image title "></td>
      </tr>
	  
	 
	   <? if($gallery_image!='') { ?>
    <tr>
      <td width="183" class="tdLabel">Product Image :</td>
      <td width="575" class="tdData">
	   <img src="<?=UP_FILES_WS_PATH.'/gallery/'.$gallery_image;?>"/>
	  <br>Delete<input type="checkbox" name="gallery_image_del" value="1"></td>
    </tr>		 
    <? }?>
	       <tr>
      <td width="183" class="tdLabel">Product  Image (Only .JPG Image) :</td>
      <td width="575" class="tdData"><input name="gallery_image" type="file" id="gallery_image" ></td>
    </tr>
        <tr>
      <td width="81" class="tdLabel">Product Description:</td>
      <td  class="tdData">
	  <textarea name="gallery_desc" cols="60" rows="8" class="textfield" id="gallery_desc" alt="blank"><?=$gallery_desc?></textarea>  
	  <? //=get_fck_editor("gallery_desc", $gallery_desc)?></td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="gallery_id" value="<?=$gallery_id?>">
 		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>