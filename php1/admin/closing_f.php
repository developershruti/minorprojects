<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
	if($close_id!='') {
		$sql = "update ngo_closing set  close_target = '$close_target', close_achieve = '$close_achieve',close_startdate = '$close_startdate',close_enddate = '$close_enddate', close_desc = '$close_desc' ,close_user='$_SESSION[sess_admin_login_id]' where close_id = $close_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_closing set  close_target = '$close_target', close_achieve = '$close_achieve',close_startdate = '$close_startdate',close_enddate = '$close_enddate', close_desc = '$close_desc' ,close_user='$_SESSION[sess_admin_login_id]' ";
		db_query($sql);
	}
	header("Location: closing_list.php");
	exit;
}

$close_id = $_REQUEST['close_id'];
if($close_id!='') {
	$sql = "select * from ngo_closing where close_id = '$close_id'";
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
       Add/ update Closing </div></td>
  </tr>
</table>
<div align="right"><a href="closing_list.php">Back to 
        Closing        List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
	    <td class="tdLabel">Closing ID </td>
	    <td class="tdData"><?=$close_id?></td>
	    </tr>
	  <!--<tr>
	    <td class="tdLabel">Target </td>
	    <td class="tdData"><input name="close_target" type="text" id="close_target" value="<? //=$close_target?>"  alt="blank" emsg="Please enter target  for this closing" class="textfield" /></td>
	    </tr>
	  <tr>
	    <td class="tdLabel">Archieve</td>
	    <td class="tdData"><input name="close_achieve" type="text" id="close_achieve" value="<? //=$close_achieve?>"   class="textfield" /></td>
	    </tr>-->
	  <tr>
	    <td class="tdLabel">Start Date </td>
	    <td class="tdData"><?=get_date_picker("close_startdate", $close_startdate)?></td>
	    </tr>
	  <tr>
      <td width="141" class="tdLabel">Closing Date :</td>
      <td width="270" class="tdData"><?=get_date_picker("close_enddate", $close_enddate)?></td>
      </tr>
        <tr>
      <td width="141" class="tdLabel">Desc:</td>
      <td  class="tdData">
	    <textarea name="close_desc" cols="60" rows="8" class="textfield" id="close_desc" ><?=$close_desc?></textarea>	   </td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="close_id" value="<?=$close_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>