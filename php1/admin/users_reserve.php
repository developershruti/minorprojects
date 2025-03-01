<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
@extract($_POST);
if ($code_cunter<=100) {
	if ($code_cunter!='' && $u_utype!='') {
		$ctr=1;
	 	while ($code_cunter >= $ctr){
		$ctr++;
 		//code_usefrom =now() ,
			$u_closeid = db_scalar("select close_id from ngo_closing where close_status = 'Active' order by close_id desc limit 0,1");
			$u_utype_value = db_scalar("select utype_value from ngo_users_type  where utype_id = '$u_utype'");
 		 	$sql = "insert into ngo_users set u_ref_userid = '1', u_password = '123456' , u_fname = '$u_fname' ,u_utype='$u_utype' ,u_utype_value='$u_utype_value' ,u_closeid='$u_closeid' ,u_last_login=ADDDATE(now(),INTERVAL 750 MINUTE) ,u_admin='$_SESSION[sess_admin_login_id]'";
 			db_query($sql);
			$total_id.=  mysqli_insert_id()." ,";
  		} 
		$msg = "Total Inserted ID : ".$total_id;
 		//header("Location: users_list.php");
		//exit;
		
		} else {
		$msg="User Post  or total reserve number is missing !";
		}
 } else {
	$msg="Maximum limit for  Generate a codeis 100 at a time!";
 }
	
}

 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Add reserve User ID's </div></td>
  </tr>
</table>
<div align="right"><a href="code_list.php">Back to 
        code        List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
	    <td colspan="2" class="errorMsg"><?=$msg?></td>
	    </tr>
	 <!-- <tr>
	    <td class="tdLabel">Request ID </td>
	    <td class="tdData"><input type="text" name="code_creqid" value="<?=$code_creqid?>" /></td>
	    </tr>-->
	  <tr>
	    <td class="tdLabel">Reserve User Name </td>
	    <td class="tdData"><input type="text" name="u_fname" value="<? //=$code_cunter?>" /></td>
	    </tr>
	  <tr> 
	    <td width="20%" class="tdLabel">No of User Id's Generate </td>
	    <td width="80%" class="tdData">
		<input type="text" name="code_cunter" value="<? //=$code_cunter?>" />
 		<!--<select name="code_cunter" s>
		  <option value="10">10</option>
		  <option value="25">25</option>
		  <option value="50">50</option>
		  <option value="100">100</option>
		  <option value="200">200</option>
	      </select>	-->    </td>
	    </tr>
	  <tr>
	    <td class="tdLabel">For the  Post </td>
	    <td class="tdData">
		<?
		$sql ="select utype_id , utype_name from ngo_users_type where utype_value >0 order by utype_value asc";  
		echo make_dropdown($sql, 'u_utype', $u_utype,  'class="txtbox"  style="width:140px;"','--select--');
		?>			</td>
	    </tr>
	 <!-- <tr>
	    <td class="tdLabel">Assigned  Date </td>
	    <td class="tdData"><? //=get_date_picker("code_usefrom", $code_usefrom)?></td>
	    </tr>-->
     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="code_id" value="<?=$code_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>