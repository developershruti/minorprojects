<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
	
	
	if(is_array($permission_check)){
	  $adm_permission=implode(',',$permission_check);
	}
	
	/*
	
	if($_POST['adm_picture_del']!='') {
		$sql_edit_part .= ", adm_picture = '' ";
	}
	if($_FILES['adm_picture']['name']!='') {
		$adm_picture_name = rawurlencode($_FILES['adm_picture']['name']).'-'.md5(uniqid(rand(), true)).'.'.file_ext($_FILES['adm_picture']['name']);
		copy($_FILES['adm_picture']['tmp_name'], UP_FILES_FS_PATH.'/'.$adm_picture_name);
		$sql_edit_part .= ", adm_picture = '$adm_picture_name' ";
	}*/
	//adm_login = '$adm_login',
		if($adm_userid!='') {
		 $sql = "update ngo_admin set adm_login = '$adm_login', adm_password = '$adm_password', adm_login2 = '$adm_login2', adm_password2 = '$adm_password2',adm_name = '$adm_name', adm_address = '$adm_address', adm_city = '$adm_city', adm_country = '$adm_country', adm_phone = '$adm_phone', adm_email = '$adm_email', adm_type = '$adm_type',adm_permission='$adm_permission'  $sql_edit_part where adm_userid = $adm_userid";
		db_query($sql);
	} else{  
		$sql = "insert into ngo_admin set adm_login = '$adm_login', adm_login2 = '$adm_login2', adm_password2 = '$adm_password2', adm_password = '$adm_password', adm_name = '$adm_name', adm_address = '$adm_address', adm_city = '$adm_city', adm_country = '$adm_country', adm_phone = '$adm_phone', adm_email = '$adm_email', adm_picture = '$adm_picture_name', adm_type = '$adm_type',adm_date=ADDDATE(now(),INTERVAL 750 MINUTE),adm_permission='$adm_permission' ";
		db_query($sql);
	}
	header("Location: admin_list.php");
	exit;
}

$adm_userid = $_REQUEST['adm_userid'];
if($adm_userid!='') {
	$sql = "select * from ngo_admin where adm_userid = '$adm_userid'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		$line = ms_form_value($line_raw);
		@extract($line);
	    $permission_check=explode(",",$adm_permission);
	 }
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Admin</div></td>
  </tr>
</table>
<div align="right"><a href="admin_list.php">Back to 
         Admin        List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
 
    
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
        <tr>
      <td width="141" class="tdLabel">Login:</td>
      <td width="270" class="tdData"> <input name="adm_login" type="text" id="adm_login" value="<?=$adm_login?>"  class="textfield" alt="blank" emsg="Login id can not be blank"> </td>
    </tr>

        <tr>
      <td width="141" class="tdLabel">Password:</td>
      <td width="270" class="tdData"><input name="adm_password" type="text" id="adm_password" value="<?=$adm_password?>"  class="textfield" alt="blank" emsg="Login password can not be blank"></td>
    </tr>

        <tr>
          <td class="tdLabel">Access Code:</td>
          <td class="tdData"><input name="adm_login2" type="text" id="adm_login2" value="<?=$adm_login2?>"  class="textfield" alt="blank" emsg="Access Pass can not be blank" /></td>
        </tr>
        <tr>
          <td class="tdLabel">Access Pass:</td>
          <td class="tdData"><input name="adm_password2" type="text" id="adm_password2" value="<?=$adm_password2?>"  class="textfield" alt="blank" emsg="Access Code can not be blank" /></td>
        </tr>
        
        <tr>
      <td width="141" class="tdLabel">Name:</td>
      <td width="270" class="tdData"><input name="adm_name" type="text" id="adm_name" value="<?=$adm_name?>"  class="textfield" alt="blank" emsg="Admin Name can not be blank"></td>
    </tr>

        <tr>
      <td width="141" class="tdLabel">Address:</td>
      <td width="270" class="tdData"><textarea name="adm_address" id="adm_address" rows="5" cols="50"  class="textfield"><?=$adm_address?></textarea></td>
    </tr>

        <tr>
      <td width="141" class="tdLabel">City:</td>
      <td width="270" class="tdData"><input name="adm_city" type="text" id="adm_city" value="<?=$adm_city?>"  class="textfield"></td>
    </tr>

        <tr>
      <td width="141" class="tdLabel">Country:</td>
      <td width="270" class="tdData"><input name="adm_country" type="text" id="adm_country" value="<?=$adm_country?>"  class="textfield"></td>
    </tr>

        <tr>
      <td width="141" class="tdLabel">Phone:</td>
      <td width="270" class="tdData"><input name="adm_phone" type="text" id="adm_phone" value="<?=$adm_phone?>"  class="textfield"></td>
    </tr>

        <tr>
      <td width="141" class="tdLabel">Email:</td>
      <td width="270" class="tdData"><input name="adm_email" type="text" id="adm_email" value="<?=$adm_email?>"  class="textfield"  ></td>
    </tr>

     
    <!--<? //if($adm_picture!='') { ?>
    <tr>
      <td width="141" class="tdLabel">Current Adm Picture:</td>
      <td width="270" class="tdData"><img src="<?//=UP_FILES_WS_PATH.'/'.$adm_picture?>" width="150" /><br>Delete<input type="checkbox" name="adm_picture_del" value="1"></td>
    </tr>		 
    <? //}?>-->
	       <!--<tr>
      <td width="141" class="tdLabel">Picture:</td>
      <td width="270" class="tdData"><input name="adm_picture" type="file" id="adm_picture" ></td>
    </tr>-->

        <tr>
      <td width="141" class="tdLabel">Type:</td>
      <td width="270" class="tdData">
	  
	  <select name="adm_type"><option value="main" <?php if($adm_type=="main"){echo "selected";} ?>>Main</option>
	  <option value="general" <?php if($adm_type=="general"){echo "selected";} ?>>General</option>
	  </select>	  </td>
    </tr>
	<tr>
      <td width="141" class="tdLabel">&nbsp;</td>
      <td width="270" class="tdLabel">If the admin type is "General" then please select the managemant links for which he/she is authorised.<br /> 
        If the admin level is "Main" then he/she would have full permission for the management links.</td>
    </tr>
	
	<tr>
      <td width="141" class="tdLabel">Permission For:</td>
      <td width="270" class="tdData"><?
	 // print_r($ARR_ADMIN_LINK_PERMISSION);
	   echo make_checkboxes($ARR_ADMIN_LINK_PERMISSION, 'permission_check' , $permission_check,3,	$missit, $style	= 'nor_content', $tableattr = 'align="left" width="100%", border="0"','other')?>	  </td>
    </tr>
	
	

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="adm_userid" value="<?=$adm_userid?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>



