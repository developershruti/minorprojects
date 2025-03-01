<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
    //print_r($_POST);
	if($_FILES['photo_image']['name']!='') {
	$imported_file = $_FILES['photo_image']['name'];
	
	$check_bank = $_POST[check_bank];
	@copy($_FILES['photo_image']['tmp_name'], UP_FILES_FS_PATH.'/importcsv/'.$imported_file);
	//	import code start
	$fp = fopen (UP_FILES_FS_PATH.'/importcsv/'.$imported_file, "r");
	$cs_array = fgetcsv ($fp, 100000, "\n");
	$debug=0;
	while ($cs_array = fgetcsv ($fp, 100000, "\t")) {
		//print "<pre>". print_r($cs_array)."</pre>";
		$u_username = $cs_array[0];
		$u_bank_register = $cs_array[2];
		$total_count = db_scalar("select count(*) from ngo_users where u_username='$u_username' ");
		if ($total_count!=0) { 	 
			$sql = "update  ngo_users set u_bank_register='$u_bank_register' where u_username='$u_username'  ";
			db_query($sql);
			$user_ids .= $u_username ." ,";
		}
	 }
			
		$msg = "Following user id imported successfully. <br>".$user_ids;
		//$imports++; if ($imports > 500) { break;}
	  
	 
	fclose ($fp);
	}
 		 
 }
 

if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "Rs. " .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Update user register bank name  </div></td>
  </tr>
</table>
<div align="right"><a href="users_list.php">Back to Users List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
   <table width="90%"  border="0" align="center" cellpadding="5" cellspacing="1" class="tableSearch">
    <tr>
       
      <td  colspan="2" class="errorMsg"><?=$msg?></td>
    </tr>
   <!-- <tr>
      <td width="23%"  align="right"><strong>Cheque Date  : </strong></td>
      <td width="77%"  class="tableDetails"><input name="check_date" type="text" id="check_date"  value="<? //=$check_date?>" /> 
        <span class="errorMsg">(Eg. yyyy-mm-dd)</span> </td>
    </tr>
	<tr>
      <td align="right"><strong>Bank Name  : </strong></td>
      <td class="tableDetails"><?=bank_dropdown('check_bank',$check_bank)?></td>
    </tr>-->
	
    <tr>
      <td align="right" class="tdLabel"><strong> Select File Name: </strong></td>
      <td class="tableDetails"><input name="photo_image" type="file" id="photo_image" /></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
      <td class="tableDetails"><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
      <td class="tableDetails">&nbsp;</td>
    </tr>
  </table>
  <br />
  <br />
  </form>
<? include("bottom.inc.php");?>