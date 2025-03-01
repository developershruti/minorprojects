<?
require_once('../includes/surya.dream.php');

 if ($_SESSION['sess_admin_type']=='general' &&  $_SESSION['sess_admin_type_acc']=='Read') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: admin_desktop.php?acc=".$_SESSION['sess_admin_type_acc']);
	 exit;
}

if(is_post_back()) {

if ($image_image_del !='') {
			@unlink(UP_FILES_FS_PATH.'/news/'.$old_image_image);
			$update_photo = ", image_image=''";
		}
		
		if($_FILES['image_image']['name']!='') {
  			$image_image_name = str_replace('.'.file_ext($_FILES['image_image']['name']),'',$_FILES['image_image']['name']).'_'.md5(uniqid(rand(), true)).'.'.file_ext($_FILES['image_image']['name']);
			 copy($_FILES['image_image']['tmp_name'], UP_FILES_FS_PATH.'/news/'.$image_image_name);
			 $update_photo = ", image_image='$image_image_name'";
 		}
		
		
	if($image_id!='') {
		$sql = "update ngo_image set  image_title = '$image_title' ,image_place = '$image_place' ,image_video = '$image_video' , image_desc = '$image_desc' ". $update_photo ."$sql_edit_part where image_id = $image_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_image set  image_title = '$image_title',image_place = '$image_place'  ,image_video = '$image_video', image_desc = '$image_desc' ,image_datetime=now() ". $update_photo ."";
		db_query($sql);
		$msg="popup inserted successfully";
	}
	header("Location: popup_list.php");
	
	
	exit;
}

$image_id = $_REQUEST['image_id'];
if($image_id!='') {
	$sql = "select * from ngo_image where image_id = '$image_id'";
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
       Add/ Popup </div></td>
  </tr>
</table>
 
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>

<?=$msg?>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	   <tr>
      <td width="81" align="left" class="tdLabel">Poppup Type :</td>
      <td width="702" class="tdData">
	  
	  <select name="image_title" id="image_title	">
					<option value="">Please Select</option>
					<option <? if($image_title=='INDEX'){ ?> selected="selected" <?  }  ?> value="INDEX">Index</option>
					<option <? if($image_title=='DASHBOARD'){ ?> selected="selected" <?  }  ?> value="DASHBOARD">Dashboard</option>         
				  
 				   </select></td>
      </tr> 
	     
		
		
		  
		 
  
		 <? if($image_image!='') { ?>
          <tr>
            <td align="left" valign="top" class="tdLabel">Current  Image:</td>
                        <td align="left" valign="top"><img src="<?=UP_FILES_WS_PATH.'/news/'.$image_image?>" width="98" /><br>
                          Delete
                          <input type="checkbox" name="image_image_del" value="1"  class="maintxt">
                        </td>
          </tr>
                      <? }?>
                      <tr>
                        <td align="left" valign="top" class="tdLabel"> Popup Images  : </td>
                        <td align="left" valign="top"><span class="tahoma11_red">
                          <input name="image_image" type="file" class="txtbox" id="image_image" style="width:270px;"/>
                          </span></td> 
                      </tr>
					  <tr>
            <td  align="right" valign="top" class="tdLabel">  Youtube Vedio URL: </td>
            <td  class="tdData"><input name="image_video" type="text" class="textfield" id="image_video" value="<? if($image_video=='') { echo 'https://www.youtube.com/embed/';} else { echo $image_video;} ?>" size="50" /> <br /> https://www.youtube.com/embed/<strong>rHx-7TJmpis</strong></td>
          </tr>
		  
					 
					  <tr>
      <td width="81" align="left" class="tdLabel">Popup description:</td>
      <td width="702" class="tdData">
	 
	  
	  <textarea name="image_desc" cols="70"    rows="10" class="textfield"  type="text" alt="blank"> <?=$image_desc?> </textarea>
	  
	  </td>
      </tr>
     
      
     

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="image_id" value="<?=$image_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>