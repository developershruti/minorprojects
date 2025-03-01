<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {

if($_POST['pic_image_del']!='') {
		@unlink(UP_FILES_FS_PATH.'/gallery/'.$old_pic_image);
		$sql_edit_part = ", pic_image = '' ";
	}
	
	 if($_FILES['pic_image']['name']!='') {
  $name = str_replace('.'.file_ext($_FILES['pic_image']['name']),'',$_FILES['pic_image']['name']).'_'.md5(uniqid(rand(), true));
	 $pic_image=$name.'.'.file_ext($_FILES['pic_image']['name']);
     $ori_name=UP_FILES_FS_PATH.'/gallery/'.$pic_image;
	 @copy($_FILES['pic_image']['tmp_name'],$ori_name);
		$sql_edit_part = " ,pic_image = '$pic_image' ";
	}
 
  
	if($pic_id!='') {
		$sql = "update ngo_gallery_pic set   pic_name = '$pic_name' ,pic_price = '$pic_price',pic_article_no = '$pic_article_no',pic_discount = '$pic_discount' ,pic_desc = '$pic_desc' , pic_category = '$pic_category', availablity_status = '$availablity_status' $sql_edit_part  where pic_id = $pic_id" ;
		db_query($sql);
	} else{
		$sql = "insert into  ngo_gallery_pic set pic_name = '$pic_name'  ,pic_price = '$pic_price',pic_article_no = '$pic_article_no',pic_discount = '$pic_discount' , pic_desc = '$pic_desc' , pic_category = '$pic_category',  availablity_status = '$availablity_status', pic_gallery_id='$gallery_id' ,pic_date = now()  $sql_edit_part";
		db_query($sql);
	}
	header("Location: product_pic_list.php");
	exit;
}

$pic_id = $_REQUEST['pic_id'];
if($pic_id!='') {
	$sql = "select * from  ngo_gallery_pic where pic_id = '$pic_id'";
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
       Add/Update Products </div></td>
  </tr>
</table>
<div align="right"><a href="product_list.php?gallery_id=<?=$gallery_id?>">Back to Products List</a>&nbsp;</div>
<form name="form1" method="post"  enctype="multipart/form-data" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	    
	  <tr>
      <td width="81" class="tdLabel">Product Name:</td>
      <td width="702" class="tdData"><input name="pic_name" type="text" id="pic_name" value="<?=$pic_name?>" alt="blank" emsg="Please enter Photo Name "></td>
      </tr>
	   <tr>
      <td width="81" class="tdLabel">Article Number:</td>
      <td width="702" class="tdData"><input name="pic_article_no" type="text" id="pic_article_no" value="<?=$pic_article_no?>" alt="blank" emsg="Please enter Photo Name "></td>
      </tr>
	    <tr>
      <td width="150" class="tdLabel">Product Price :(In Rupees) </td>
      <td width="702" class="tdData"><input name="pic_price" type="text" id="pic_price" value="<?=$pic_price?>" alt="blank" emsg="Please enter Photo Name "></td>
      </tr>
	  <tr>
      <td width="150" class="tdLabel">Discount : (In Percent %)</td>
      <td width="702" class="tdData"><input name="pic_discount" type="text" id="pic_discount" value="<?=$pic_discount?>" alt="blank" emsg="Please enter Photo Name "></td>
      </tr>
	    <tr>
      <td width="150" class="tdLabel">Product Description:</td>
      <td width="702" class="tdData"> <textarea name="pic_desc" cols="60" rows="8" class="textfield" id="pic_desc" alt="blank"><?=$pic_desc?></textarea> </td>
      </tr>
	  
	 
	   <? if($pic_image!='') { ?>
    <tr>
      <td width="183" class="tdLabel"> Product Image:</td>
      <td width="575" class="tdData">
	   <img src="<?=UP_FILES_WS_PATH.'/gallery/'.$pic_image;?>" width="150"/>
	  <br>Delete<input type="checkbox" name="pic_image_del" value="1"></td>
    </tr>		 
    <? }?>
	       <tr>
      <td width="183" class="tdLabel"> Product  (Only .JPG Image):</td>
      <td width="575" class="tdData"><input name="pic_image" type="file" id="pic_image" ></td>
    </tr>
        <!--<tr>
      <td width="81" class="tdLabel">Photo Description:</td>
      <td  class="tdData">
	  <textarea name="pic_desc" cols="60" rows="8" class="textfield" id="pic_desc" alt="blank" emsg="Please enter Photo description " ><?#=$pic_desc?></textarea>  
	  <? //=get_fck_editor("pic_desc", $pic_desc)?></td>
    </tr>-->
                    <tr>
                      <td width="39%" align="left" valign="top" class="tdLabel">Product Category</td>
                      <td width="61%"class="tdLabel" >
					 <?=pic_category($pic_category,'class="txtbox" style="width:140px;" name="pic_category" id="pic_category" alt="blank" emsg="Please select gender"')?>
					  </td>
                    </tr>
   	    <tr>
                      <td width="39%" align="left" valign="top" class="tdLabel">Product Category</td>
                      <td width="61%"class="tdLabel" >
					 <?=availablity_status($availablity_status,'class="txtbox" style="width:140px;" name="availablity_status" id="availablity_status" alt="blank" emsg="Please select availablity status"')?>
					  </td>
                    </tr>
   	    


     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"> 
		<input type="hidden" name="gallery_id" value="<?=$gallery_id?>">
		<input type="hidden" name="pic_id" value="<?=$pic_id?>">
 		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
     	    <tr>
     	      <td class="tdLabel">&nbsp;</td>
     	      <td class="tdData">&nbsp;</td>
   	      </tr>
     	    <tr>
     	      <td class="tdLabel">&nbsp;</td>
     	      <td class="tdData">&nbsp;</td>
   	      </tr>
  </table>
</form>
<? include("bottom.inc.php");?>