<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {
	if($comp_id!='') {
		$sql = "update ngo_complain set  comp_userid = '$comp_userid',comp_title = '$comp_title' ,comp_date = '$comp_date',  comp_desc = '$comp_desc'  where comp_id = $comp_id";
		db_query($sql);
	} else{
		$comp_userid = db_scalar("select u_username from ngo_users where u_id='$comp_username' ");
		$sql = "insert into ngo_complain set comp_userid = '$comp_userid', comp_title = '$comp_title' ,comp_date = '$comp_date' , comp_desc = '$comp_desc',comp_datetime=now() ";
		db_query($sql);
	}
	header("Location: complain_list.php");
	exit;
}

$comp_id = $_REQUEST['comp_id'];
if($comp_id!='') {
	$sql = "select * from ngo_complain where comp_id = '$comp_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
		
		$comp_username = db_scalar("select u_username from ngo_users where u_id='$comp_userid' ");
	}
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Add/ Update Complain </div></td>
  </tr>
</table>
<div align="right"><a href="complain_list.php">Back to 
        Complain List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	 <!-- <tr>
	    <td class="tdLabel">Complain by: </td>
	    <td class="tdData"> <?php //$sql ="select u_id , u_username from ngo_users where u_status='Active' and u_id='$comp_userid'";  
						// echo make_dropdown($sql, 'comp_userid', $comp_userid,  'class="txtbox_red" style="width:150px;" alt="select" emsg="Please Select complain user name"', 'Please select');
							?></td>
	    </tr>-->
		 <tr>
	    <td class="tdLabel">Complain bys:</td>
	    <td class="tdData"><input name="comp_username" type="text" id="comp_username" value="<?=$comp_username?>"  alt="blank" class="textfield" /></td>
	    </tr>
	  <tr>
	    <td class="tdLabel">Title:</td>
	    <td class="tdData"><input name="comp_title" type="text" id="comp_title" value="<?=$comp_title?>"  alt="blank" class="textfield" /></td>
	    </tr>
	  <tr>
      <td width="81" class="tdLabel">Complain Date </td>
      <td width="702" class="tdData"><input name="comp_date" type="text" id="comp_date" value="<?=$comp_date?>"   /> 
        yyyy-mm-dd </td>
      </tr>
        <tr>
      <td width="81" class="tdLabel">Desc:</td>
      <td  class="tdData">
	   <textarea name="comp_desc" cols="60" rows="8" class="textfield" id="comp_desc" alt="blank"><?=$comp_desc?></textarea>	   </td>
    </tr>

     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="comp_id" value="<?=$comp_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>