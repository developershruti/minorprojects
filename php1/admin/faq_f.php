<?
require_once('../includes/surya.dream.php');
$faq_cat_id=$_REQUEST['faq_category_id'];
if(is_post_back()) {
	if($faq_id!='') {
		$sql = "update ngo_faq set faq_question = '$faq_question', faq_answer = '$faq_answer' $sql_edit_part where faq_id = $faq_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_faq set faq_cat_id='$cat_id', faq_question = '$faq_question', faq_answer = '$faq_answer' ";
		db_query($sql);
	}
	header("Location: faq_list.php?cat_id=$cat_id");
	exit;
}

$faq_id = $_REQUEST['faq_id'];
if($faq_id!='') {
	$sql = "select * from ngo_faq where faq_id = '$faq_id'";
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
       Faq</div></td>
  </tr>
</table>
<div align="right"><a href="faq_list.php?faq_category_id=<?=$faq_category_id?>">Back toFaq        List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded"  onSubmit="return check1_from();">
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
        <tr>
      <td width="141" class="tdLabel">Question:</td>
      <td width="270" class="tdData"><textarea name="faq_question" id="faq_question" rows="2" cols="90" ><?=$faq_question?></textarea>	
	 
	  </td>
    </tr>

        <tr>
      <td width="141" class="tdLabel">Answer:</td>
      <td  class="tdData"><?=get_fck_editor("faq_answer", $faq_answer)?></td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="faq_id" value="<?=$faq_id?>">
		<input type="hidden" name="faq_category_id" value="<?=$faq_category_id?>">
                        <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>