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
	$rece_userid 		= $cs_array[0];
	$rece_pay_mode		= $cs_array[2];
	$rece_admin 		= $cs_array[3]; 
 	$rece_amount 		= $cs_array[4]; 
	$rece_cheque_no 	= $cs_array[5];
	$rece_cheque_date 	= $cs_array[6];
	$rece_bank 			= $cs_array[7]; 
  	$rece_given_userid 	= $cs_array[8]; 
	$rece_given_name 	= $cs_array[9]; 
	$rece_cheque_userid = $cs_array[10]; 
	$rece_rec_date 		= $cs_array[11]; 
	$rece_contact 		= $cs_array[12]; 
 	$rece_remark 		= $cs_array[13]; 
	$rece_misc 			= $cs_array[13]; 
  
		 	$id = db_scalar("select count(*) from ngo_receive where  rece_userid='$rece_userid' ");
			if ($id==0) {
			 	$sql = "insert into ngo_receive set  rece_userid='$rece_userid' ,rece_pay_mode='$rece_pay_mode' ,rece_admin='$_SESSION[sess_admin_login_id]' ,rece_cheque_no='$rece_cheque_no' ,rece_cheque_date='$rece_cheque_date' ,rece_bank='$rece_bank' , rece_amount='$rece_amount' , rece_given_userid='$rece_given_userid', rece_given_name='$rece_given_name', rece_cheque_userid='$rece_cheque_userid',rece_rec_date='$rece_rec_date' ,rece_remark='$rece_remark',rece_misc='$rece_misc' ,rece_contact='$rece_contact'";
			db_query($sql);
				 $user_ids .= $rece_userid ." ,";
			}else {
			 	$user_skip_ids .= $rece_userid ." ,";
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