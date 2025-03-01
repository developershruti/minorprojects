<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {
  
		
	if($ad_id!='') {
		$sql = "update ngo_browsing set  ad_title = '$ad_title',ad_url = '$ad_url' , ad_desc = '$ad_desc'   where ad_id = $ad_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_browsing set  ad_title = '$ad_title',ad_url = '$ad_url' , ad_desc = '$ad_desc' ,ad_date=now() ". $update_photo ."";
		db_query($sql);
	}
	header("Location: ads_list.php");
	exit;
}

$ad_id = $_REQUEST['ad_id'];
if($ad_id!='') {
	$sql = "select * from ngo_browsing where ad_id = '$ad_id'";
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
<div align="right"><a href="ads_list.php">Back to Ads List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
      <td width="81" align="left" class="tdLabel">NewsTitle:</td>
      <td width="702" class="tdData"><input name="ad_title" type="text" id="ad_title" value="<?=$ad_title?>"  alt="blank" class="textfield"></td>
      </tr>
	   <tr>
      <td width="81" align="left" class="tdLabel">URL:</td>
      <td width="702" class="tdData"><textarea name="ad_url" cols="100" rows="5" class="textfield" id="ad_url" alt="blank"><?=$ad_url?></textarea> </td>
      </tr>
                  
        <td width="81" align="left" class="tdLabel">Desc:</td>
      <td  class="tdData">
	   <textarea name="ad_desc" cols="100" rows="15" class="textfield" id="ad_desc" ><?=$ad_desc?></textarea>  
	  <? //=get_fck_editor("ad_desc", $ad_desc)?></td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="ad_id" value="<?=$ad_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>