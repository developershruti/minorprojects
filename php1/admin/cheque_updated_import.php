<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
    //print_r($_POST);
	if($_FILES['photo_image']['name']!='') {
	$imported_file = $_FILES['photo_image']['name'];
 	@copy($_FILES['photo_image']['tmp_name'], UP_FILES_FS_PATH.'/importcsv/'.$imported_file);
	//	import code start
	$fp = fopen (UP_FILES_FS_PATH.'/importcsv/'.$imported_file, "r");
	$cs_array = fgetcsv ($fp, 100000, "\n");
	$debug=0;
	while ($cs_array = fgetcsv ($fp, 100000, "\t")) {
 	//print "<pre>". print_r($cs_array)."</pre>";
	$sql_part='';
	$check_id = $cs_array[0];
	if ($cs_array[7]!='' )  { $sql_part .=" , check_cheque_no ='$cs_array[7]' " ;}
	if ($cs_array[8]!='' )  { $sql_part .=" , check_rec_id ='$cs_array[8]' " ;}
	if ($cs_array[9]!='' ) { $sql_part .=" , check_rec_name ='$cs_array[9]' " ;}
	if ($cs_array[10]!='' ) { $sql_part .=" , check_rec_date ='$cs_array[10]' " ;}
	if ($cs_array[11]!='' ) { $sql_part .=" , check_contact ='$cs_array[11]' " ;}
	if ($cs_array[12]!='' ) { $sql_part .=" , check_status ='$cs_array[12]' " ;}
	
/*	$check_rec_id = $cs_array[8];
	$check_rec_name = $cs_array[9]; 
 	$check_rec_date = $cs_array[10];
	$check_contact = $cs_array[11];
	$check_status = $cs_array[12];*/
 		if ($check_id!='') {
			 print "<br>".  $sql = "update ngo_cheque set  check_id='$check_id' $sql_part where check_id='$check_id'  ";
			 db_query($sql);
			 $user_ids .= $check_id ." ,";
			}
			
			$msg = "Following Cheque ID updated successfully. <br>".$user_ids;
			//$imports++; if ($imports > 500) { break;}
		 
	}
	fclose ($fp);
	}
 		 
 }
 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Import Updated Cheque </div></td>
  </tr>
</table>
<div align="right"><a href="cheque_list.php">Back to Bill List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
   <table width="90%"  border="0" align="center" cellpadding="5" cellspacing="1" class="tableSearch">
    <tr>
       
      <td  colspan="2" class="errorMsg"><?=$msg?></td>
    </tr>
   <!-- <tr>
      <td width="23%"  align="right"><strong>Cheque Date  : </strong></td>
      <td width="77%"  class="tableDetails"><input name="check_date" type="text" id="check_date"  value="<? //=$check_date?>" /> 
        <span class="errorMsg">(Eg. yyyy-mm-dd)</span> </td>
    </tr>-->
	
    <tr>
      <td align="right" class="tdLabel"><strong> Select File Name: </strong></td>
      <td class="tableDetails"><input name="photo_image" type="file" id="photo_image" /></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel"><strong>Update field : </strong></td>
      <td class="tableDetails">Cheque No, Rec ID, Rec Name, Rec Contact , Rec Status , Rec Date (yyyy-mm-dd) </td>
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