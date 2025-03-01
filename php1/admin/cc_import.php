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
 	// print "<pre>". print_r($cs_array)."</pre>";
	$cc_userid 		= $cs_array[0];
	$cc_pay_mode		= $cs_array[2];
	$cc_admin 		= $cs_array[3]; 
 	$cc_amount 		= $cs_array[4]; 
	$cc_cheque_no 	= $cs_array[5];
	$cc_cheque_date 	= $cs_array[6];
	$cc_bank 			= $cs_array[7]; 
  	$cc_given_userid 	= $cs_array[8]; 
	$cc_given_name 	= $cs_array[9]; 
	$cc_cheque_userid = $cs_array[10]; 
	$cc_rec_date 		= $cs_array[11]; 
	$cc_contact 		= $cs_array[12]; 
 	$cc_remark 		= $cs_array[13]; 
	$cc_misc 			= $cs_array[13]; 
  
		 	$id = db_scalar("select count(*) from ngo_cc where  cc_userid='$cc_userid' ");
			if ($id==0) {
			 	$sql = "insert into ngo_cc set  cc_userid='$cc_userid' ,cc_pay_mode='$cc_pay_mode' ,cc_admin='$_SESSION[sess_admin_login_id]' ,cc_cheque_no='$cc_cheque_no' ,cc_cheque_date='$cc_cheque_date' ,cc_bank='$cc_bank' , cc_amount='$cc_amount' , cc_given_userid='$cc_given_userid', cc_given_name='$cc_given_name', cc_cheque_userid='$cc_cheque_userid',cc_rec_date='$cc_rec_date' ,cc_remark='$cc_remark',cc_misc='$cc_misc' ,cc_contact='$cc_contact'";
			db_query($sql);
				 $user_ids .= $cc_userid ." ,";
			}else {
			 	$user_skip_ids .= $cc_userid ." ,";
			}
 			$imports++; if ($imports > 100) { break;}
 	}
	fclose ($fp);
	$msg .= "Following user id imported successfully. <br>".$user_ids;
	$msg .= " <br> <br>Following user id Skipped. <br>".$user_skip_ids;
	
	
	}
 		 
 }
 

if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "Rs. " .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Import Receiving </div></td>
  </tr>
</table>
<div align="right"><a href="receive_list.php">Back to Receiving List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
   <table width="58%"  border="0" align="center" cellpadding="5" cellspacing="1" class="tableSearch">
    <tr>
       
      <td  colspan="2" class="errorMsg"><?=$msg?></td>
    </tr>
 
	
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