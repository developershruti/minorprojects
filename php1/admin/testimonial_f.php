<?
require_once('../includes/surya.dream.php');
$test_cat_id=$_REQUEST['test_category_id'];
if(is_post_back()) {
	if($test_id!='') {
		$sql = "update ngo_testimonial set test_description = '$test_description'  $sql_edit_part where test_id = $test_id";
		db_query($sql);
 
	}
	header("Location: testimonial_list.php");
	exit;
}

$test_id = $_REQUEST['test_id'];
if($test_id!='') {
	$sql = "select * from ngo_testimonial where test_id = '$test_id'";
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
          <td id="pageHead"><div id="txtPageHead"> Add /Edit</div></td>
        </tr>
      </table>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded"  onSubmit="return check1_from();">
        <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
          <tr>
            <td width="141" class="tdLabel">Testimonials:</td>
            <td width="270" class="tdData"><textarea name="test_description" id="test_description" rows="10" cols="90" ><?=$test_description?>
</textarea>
            </td>
          </tr>
		  
          <tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="tdData"><input type="hidden" name="test_id" value="<?=$test_id?>">
              <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
          </tr>
        </table>
      </form>
      <? include("bottom.inc.php");?>
