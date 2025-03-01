<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {
	if($cat_id!='') {
		$sql = "update ngo_faq_category set cat_name = '$cat_name' $sql_edit_part where cat_id = $cat_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_faq_category set cat_name = '$cat_name' ";
		db_query($sql);
	}
	header("Location: faq_category_list.php");
	exit;
}

$cat_id = $_REQUEST['cat_id'];
if($cat_id!='') {
	$sql = "select * from ngo_faq_category where cat_id = '$cat_id'";
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
    <td id="pageHead"><div id="txtPageHead">
      Faq Category</div></td>
  </tr>
</table>
<div align="right"><a href="ngo_faq_category_list.php">Back to 
         Faq Category        List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
 
    
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
        <tr>
      <td width="141" class="tdLabel">Cat Name:</td>
      <td width="270" class="tdData"><input name="cat_name" type="text" id="cat_name" value="<?=$cat_name?>"  class="textfield" style="width:250px" alt="blank" emsg="Please fill the category name"></td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="cat_id" value="<?=$cat_id?>">
                         <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>