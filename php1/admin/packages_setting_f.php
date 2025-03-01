<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {

/*if ($bet_pack_image_del !='') {
			@unlink(UP_FILES_FS_PATH.'/profile/'.$old_bet_pack_image);
			$update_photo = ", bet_pack_image=''";
		}
		
		if($_FILES['bet_pack_image']['name']!='') {
  			$bet_pack_image_name = str_replace('.'.file_ext($_FILES['bet_pack_image']['name']),'',$_FILES['bet_pack_image']['name']).'_'.md5(uniqid(rand(), true)).'.'.file_ext($_FILES['bet_pack_image']['name']);
			 copy($_FILES['bet_pack_image']['tmp_name'], UP_FILES_FS_PATH.'/news/'.$bet_pack_image_name);
			 $update_photo = ", bet_pack_image='$bet_pack_image_name'";
 		}*/
		
		
	if($bet_pack_id!='') {
		$sql = "update ngo_packages set bet_pack_title = '$bet_pack_title', bet_pack_desc = '$bet_pack_desc' where bet_pack_id = $bet_pack_id";
		db_query($sql);
	} else{
		/*$sql = "insert into ngo_packages set  bet_pack_title = '$bet_pack_title', bet_pack_desc = '$bet_pack_desc' , bet_pack_datetime=now() ";
		db_query($sql);*/
	}
	header("Location: packages_setting_list.php");
	exit;
}

$bet_pack_id = $_REQUEST['bet_pack_id'];
if($bet_pack_id!='') {
	$sql = "select * from ngo_packages where bet_pack_id = '$bet_pack_id'";
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
       Add/ update Packages  </div></td>
  </tr>
</table>
<div align="right"><a href="bet_pack_list.php">Back to 
        Packages         List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
      <td width="81" align="left" class="tdLabel">Packages Title:</td>
      <td width="702" class="tdData"><input name="bet_pack_title" type="text" id="bet_pack_title" value="<?=$bet_pack_title?>" readonly=""  alt="blank" class="textfield"></td>
      </tr>
	  <?php /*?> <tr>
      <td width="81" align="left" class="tdLabel">Packages  Place:</td>
      <td width="702" class="tdData"><input name="bet_pack_place" type="text" id="bet_pack_place" value="<?=$bet_pack_place?>"  alt="blank" class="textfield"></td>
      </tr><?php */?>
       <?php /*?> <tr>
		 <? if($bet_pack_image!='') { ?>
          <tr>
            <td align="left" valign="top" class="tdLabel">Current  Image:</td>
                        <td align="left" valign="top"><img src="<?=UP_FILES_WS_PATH.'/news/'.$bet_pack_image?>" width="98" /><br>
                          Delete
                          <input type="checkbox" name="bet_pack_image_del" value="1"  class="maintxt">
                        </td>
          </tr>
                      <? }?>
                      <tr>
                        <td align="left" valign="top" class="tdLabel"> Packages  Images  : </td>
                        <td align="left" valign="top"><span class="tahoma11_red">
                          <input name="bet_pack_image" type="file" class="txtbox" id="bet_pack_image" style="width:270px;"/>
                          </span></td>
                      </tr><?php */?>
      <td width="81" align="left" class="tdLabel">Desc:</td>
      <td  class="tdData">
	    <textarea name="bet_pack_desc" cols="100" rows="5" class="textfield" id="bet_pack_desc" alt="blank"><?=$bet_pack_desc?></textarea> 
	  <? //=get_fck_editor("bet_pack_desc", $bet_pack_desc)?></td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="bet_pack_id" value="<?=$bet_pack_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>