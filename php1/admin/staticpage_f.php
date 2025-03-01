<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {

	if($_POST['static_image_del']!='') {
		@unlink(UP_FILES_FS_PATH.'/staticpage/'.$old_u_photo);
		$sql_edit_part .= ", static_image = '' ";
	}
 	if($_FILES['static_image']['name']!='') {
  	$name = str_replace('.'.file_ext($_FILES['static_image']['name']),'',$_FILES['static_image']['name']).'_'.md5(uniqid(rand(), true));
	 $img_name=$name.'.'.file_ext($_FILES['static_image']['name']);
     $ori_name=UP_FILES_FS_PATH.'/staticpage/'.$img_name;
	 @copy($_FILES['static_image']['tmp_name'],$ori_name);
		$sql_edit_part .= ", static_image = '$img_name' ";
	}

	$static_page_name = str_replace(' ','_',$static_title);
	if($static_id!='') {
		// static_page_name ='$static_page_name' ,
		$sql = "update ngo_staticpage set   static_title = '$static_title', static_desc = '$static_desc'  $sql_edit_part where static_id = $static_id";
		db_query($sql);
		header("Location: staticpage_list.php");
		exit;
	
	} else{
		$sql = "insert into ngo_staticpage set   static_page_name ='$static_page_name'   , static_title = '$static_title', static_desc = '$static_desc'   ,static_date=now()  $sql_edit_part";
		db_query($sql);
		header("Location: staticpage_list.php");
		exit;

	}
	
}

$static_id = $_REQUEST['static_id'];
if($static_id!='') {
	$sql = "select * from ngo_staticpage where static_id = '$static_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
	}
}
?>

<? include("top.inc.php");?>
<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Static Page</div></td>
  </tr>

  
</table>
<div align="right"><a href="staticpage_list.php">Back to 
        Staticpage List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	 
 
   <tr>
      <td width="85" align="right" class="tdLabel">Page Name:</td>
      <td  class="tdData"><input name="static_page_name" type="text" id="static_page_name" value="<?=$static_page_name?>"  alt="blank" class="textfield"style="width:200px;" ></td>
      </tr> 
 
	  
	  <tr>
      <td width="183" align="right" class="tdLabel">Page Title:</td>
      <td  class="tdData"><input name="static_title" type="text" id="static_title" value="<?=$static_title?>"  alt="blank" class="textfield" style="width:200px;"></td>
      </tr>
 	 
	 
	 
	 <? if($static_image!='') { ?>
    
    
     <tr>
      <td width="183" align="right" class="tdLabel">Page Top   Banner  :</td>
      <td width="575" class="tdData">
	  
	   <img src="<?=show_thumb(UP_FILES_WS_PATH.'/staticpage/'.$static_image,680,150,'resize')?>"/>
	  <br>Delete<input type="checkbox" name="static_image_del" value="1"></td>
    </tr>		 
    <? }?>
	       <tr>
      <td width="183" align="right" class="tdLabel">Banner (680x200):</td>
      <td width="575" class="tdData"><input name="static_image" type="file" id="static_image" ></td>
    </tr>
	<tr>
        <tr>
      <td width="183" align="right" class="tdLabel">Desc:</td>
      <td  class="tdData"><? //=get_fck_editor("static_desc", $static_desc)?>
	  
	    <textarea name="static_desc" cols="80" rows="10" id="static_desc"><?=$static_desc?></textarea>
	  </td>
    </tr>
  

     	    <tr>
	    <td align="right" class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="static_id" value="<?=$static_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>