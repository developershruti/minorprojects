<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {

if ($gallery_image_del !='') {
			@unlink(UP_FILES_FS_PATH.'/gallery/'.$old_gallery_image);
			$update_photo = ", gallery_image=''";
		}
		
		if($_FILES['gallery_image']['name']!='') {
  			$gallery_image_name = str_replace('.'.file_ext($_FILES['gallery_image']['name']),'',$_FILES['gallery_image']['name']).'_'.md5(uniqid(rand(), true)).'.'.file_ext($_FILES['gallery_image']['name']);
			 copy($_FILES['gallery_image']['tmp_name'], UP_FILES_FS_PATH.'/gallery/'.$gallery_image_name);
			 $update_photo = ", gallery_image='$gallery_image_name'";
 		}
		
		
	if($gallery_id!='') {
		$sql = "update ngo_gallery set    gallery_name = '$gallery_name' , gallery_desc = '$gallery_desc' ". $update_photo ."$sql_edit_part where gallery_id = $gallery_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_gallery set   gallery_name = '$gallery_name'  , gallery_desc = '$gallery_desc' ,gallery_date=now() ". $update_photo ."";
		db_query($sql);
	}
	header("Location: gallery_list.php");
	exit;
}

$gallery_id = $_REQUEST['gallery_id'];
if($gallery_id!='') {
	$sql = "select * from ngo_gallery where gallery_id = '$gallery_id'";
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
       Add/ Update Panel </div></td>
  </tr>
</table>
<div align="right"><a href="gallery_list.php">Back to 
        Panel List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  
	  <tr>
      <td width="346" align="left" class="tdLabel">Panel Title:</td>
      <td width="920" class="tdData"><input name="gallery_name" type="text" id="gallery_name" value="<?=$gallery_name?>"  alt="blank" class="textfield"></td>
      </tr> 
        <tr>
		 <? if($gallery_image!='') { ?>
          <tr>
            <td align="left" valign="top" class="tdLabel">Current  Image:</td>
                        <td align="left" valign="top"><img src="<?=UP_FILES_WS_PATH.'/gallery/'.$gallery_image?>" width="98" /><br>
                          Delete
                          <input type="checkbox" name="gallery_image_del" value="1"  class="maintxt">
                        </td>
          </tr>
                      <? }?>
                      <tr>
                        <td align="left" valign="top" class="tdLabel"> Gallery  Images  : </td>
                        <td align="left" valign="top"><span class="tahoma11_red">
                          <input name="gallery_image" type="file" class="txtbox" id="gallery_image" style="width:270px;"/>
                          </span></td>
                      </tr>
      <td width="346" align="left" class="tdLabel">Desc:</td>
      <td  class="tdData">
	   <textarea name="gallery_desc" cols="100" rows="15" class="textfield" id="gallery_desc" alt="blank"><?=$gallery_desc?></textarea> 
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