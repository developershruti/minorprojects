<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {

if ($news_image_del !='') {
			@unlink(UP_FILES_FS_PATH.'/profile/'.$old_news_image);
			$update_photo = ", news_image=''";
		}
		
		if($_FILES['news_image']['name']!='') {
  			$news_image_name = str_replace('.'.file_ext($_FILES['news_image']['name']),'',$_FILES['news_image']['name']).'_'.md5(uniqid(rand(), true)).'.'.file_ext($_FILES['news_image']['name']);
			 copy($_FILES['news_image']['tmp_name'], UP_FILES_FS_PATH.'/news/'.$news_image_name);
			 $update_photo = ", news_image='$news_image_name'";
 		}
		
		
	if($news_id!='') {
		$sql = "update ngo_news set  news_title = '$news_title',news_place = '$news_place' , news_desc = '$news_desc' ". $update_photo ."$sql_edit_part where news_id = $news_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_news set  news_title = '$news_title',news_place = '$news_place' , news_desc = '$news_desc' ,news_datetime=now() ". $update_photo ."";
		db_query($sql);
	}
	header("Location: news_list.php");
	exit;
}

$news_id = $_REQUEST['news_id'];
if($news_id!='') {
	$sql = "select * from ngo_news where news_id = '$news_id'";
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
       Add/ update News </div></td>
  </tr>
</table>
<div align="right"><a href="news_list.php">Back to 
        News        List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
      <td width="81" align="left" class="tdLabel">NewsTitle:</td>
      <td width="702" class="tdData"><input name="news_title" type="text" id="news_title" value="<?=$news_title?>"  alt="blank" class="textfield"></td>
      </tr>
	   <tr>
      <td width="81" align="left" class="tdLabel">News Place:</td>
      <td width="702" class="tdData"><input name="news_place" type="text" id="news_place" value="<?=$news_place?>"  alt="blank" class="textfield"></td>
      </tr>
        <tr>
		 <? if($news_image!='') { ?>
          <tr>
            <td align="left" valign="top" class="tdLabel">Current  Image:</td>
                        <td align="left" valign="top"><img src="<?=UP_FILES_WS_PATH.'/news/'.$news_image?>" width="98" /><br>
                          Delete
                          <input type="checkbox" name="news_image_del" value="1"  class="maintxt">
                        </td>
          </tr>
                      <? }?>
                      <tr>
                        <td align="left" valign="top" class="tdLabel"> News Images  : </td>
                        <td align="left" valign="top"><span class="tahoma11_red">
                          <input name="news_image" type="file" class="txtbox" id="news_image" style="width:270px;"/>
                          </span></td>
                      </tr>
      <td width="81" align="left" class="tdLabel">Desc:</td>
      <td  class="tdData">
	   <!--<textarea name="news_desc" cols="100" rows="15" class="textfield" id="news_desc" alt="blank"><?=$news_desc?></textarea>--> 
	  <?=get_fck_editor("news_desc", $news_desc)?></td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="news_id" value="<?=$news_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>