<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {
	if($id!='') {
		$sql = "update ngo_pollv2 set pollname = '$pollname' ,caption = '$caption'  ,created = '$created'  ,expires = '$expires' ,description = '$description' ,updated=now() where id = $id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_pollv2 set pollname = '$pollname',caption = '$caption'  ,created = '$created' ,expires = '$expires' ,description = '$description' ,status='Active'  ,updated=now()";
		db_query($sql);
	}
	header("Location: poll_category_list.php");
	exit;
}

$id = $_REQUEST['id'];
if($id!='') {
	$sql = "select * from ngo_pollv2 where id = '$id'";
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
      Survey </div></td>
  </tr>
</table>
<div align="right"><a href="poll_category_list.php">Back to 
        Survey List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
 
    
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
        <tr>
      <td width="131" align="right" class="tdLabel">Survey  Name :</td>
      <td width="833" class="tdData"><input name="pollname" type="text" id="pollname" value="<?=$pollname?>"  class="textfield" style="width:250px" alt="blank" emsg="Please enter Survey name"></td>
    </tr>

     	    <tr>
     	      <td align="right" class="tdLabel">Caption : </td>
     	      <td class="tdData"><input name="caption" type="text" id="caption" value="<?=$caption?>"  class="textfield" style="width:250px" alt="blank" emsg="Please enter Survey caption" /></td>
   	      </tr>
     	    <tr>
              <td align="right" class="tdLabel">Start  Date : </td>
     	      <td class="tdData"><?=get_date_picker("created", $created)?></td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">Expires Date :  </td>
     	      <td class="tdData"><?=get_date_picker("expires", $expires)?></td>
   	      </tr>
     	    <tr>
     	      <td align="right" valign="top" class="tdLabel">Description : </td>
     	      <td class="tdData"><textarea name="description" cols="60" rows="8" class="textfield" id="description"   alt="blank" emsg="Please enter Survey description"><?=$description?></textarea></td>
   	      </tr>
     	    <tr>
     	      <td align="right" class="tdLabel">&nbsp;</td>
     	      <td class="tdData">&nbsp;</td>
   	      </tr>
     	   
     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="id" value="<?=$id?>">
                         <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>