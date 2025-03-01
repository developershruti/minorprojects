<?
require_once('../includes/surya.dream.php');
$id=$_REQUEST['id'];
if(is_post_back()) {
	if($qid!='') {
		$sql = "update ngo_pollv2_question set question = '$question',num_options=4 ,c1='$c1',c2='$c2',c3='$c3',c4='$c4' ,pollcolor='$pollcolor' ,pollsize='$pollsize',updated=now(),created=now()  where qid = $qid";
		db_query($sql);
	} else{
		$sql = "insert into ngo_pollv2_question set pollid='$id', question = '$question',num_options=4 ,c1='$c1',c2='$c2',c3='$c3',c4='$c4' ,pollcolor='$pollcolor' ,pollsize='$pollsize',updated=now(),created=now()  ";
		db_query($sql);
	}
	header("Location: poll_list.php?id=$id");
	exit;
}

$qid = $_REQUEST['qid'];
if($qid!='') {
	$sql = "select * from ngo_pollv2_question where qid = '$qid'";
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
      Survey Question </div></td>
  </tr>
</table>
<div align="right"><a href="poll_list.php?id=<?=$id?>">Back to Survey Question  List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded"  onSubmit="return check1_from();">
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
        <tr>
      <td width="133" align="right" class="tdLabel">Question :</td>
      <td width="846" class="tdData"><input name="question" type="text" id="question" value="<?=$question?>" size="40" />	  </td>
    </tr>

     	    <tr>
     	      <td align="right" class="tdLabel">Option 1 : </td>
     	      <td class="tdData"><input name="c1" type="text" id="c1" value="<?=$c1?>" size="40" /></td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">Option 2 : </td>
     	      <td class="tdData"><input name="c2" type="text" id="c2" value="<?=$c2?>" size="40" /></td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">Option 3 : </td>
     	      <td class="tdData"><input name="c3" type="text" id="c3" value="<?=$c3?>" size="40" /></td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">Option 4 : </td>
     	      <td class="tdData"><input name="c4" type="text" id="c4" value="<?=$c4?>" size="40" /></td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">Survey Color : </td>
     	      <td class="tdData"><input name="pollcolor" type="text" id="pollcolor" value="<?=$pollcolor?>" size="40" /> 
     	        - ff0000 </td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">Survey Size : </td>
     	      <td class="tdData"><input name="pollsize" type="text" id="pollsize" value="<?=$pollsize?>" size="40" /> 
     	        - 300x200 </td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">&nbsp;</td>
     	      <td class="tdData">&nbsp;</td>
   	      </tr>
     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="qid" value="<?=$qid?>">
		<input type="hidden" name="id" value="<?=$id?>">
                        <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>