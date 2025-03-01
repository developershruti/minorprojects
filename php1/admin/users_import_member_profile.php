<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
    
	if($_FILES['photo_image']['name']!='') {
	$imported_file = $_FILES['photo_image']['name'];
	$pay_date = $_POST[pay_date];
 	@copy($_FILES['photo_image']['tmp_name'], UP_FILES_FS_PATH.'/importcsv/'.$imported_file);
	//	import code start
	$fp = fopen (UP_FILES_FS_PATH.'/importcsv/'.$imported_file, "r");
	$cs_array = fgetcsv ($fp, 100000, "\n");
	$debug=0;
	while ($cs_array = fgetcsv ($fp, 100000, "\t")) {
	 
	
  	#print "<pre>". print_r($cs_array)."</pre>";
	$u_old_userid = $cs_array[0];
	$u_username = $cs_array[3];
	$u_password = $cs_array[13];
	$u_password2 = $cs_array[13];
	//$sponsor_id= $cs_array[6];
	$ref_userid = $cs_array[5];
	#$ref_side = $cs_array[46]; // L R
	#if ($ref_side=='L') { $u_ref_side='A';} else {  $u_ref_side='B';} 
	$u_email = $cs_array[6];
	#$u_dob = $cs_array[9];
	$u_gender = $cs_array[17];
	$u_title = $cs_array[14];
	$u_fname = $cs_array[15] ;
	$u_lname = $cs_array[16];
	#$u_guardian =  $cs_array[5];
	$u_guardian_name = $cs_array[18];
	$u_address = $cs_array[8];
	$u_city = $cs_array[11];
	$u_state = $cs_array[12];
	#$u_country = $cs_array[13];
	$u_postalcode = $cs_array[20];
	#$u_phone = $cs_array[10];
	$u_mobile = $cs_array[22];
	$u_panno = $cs_array[25];
	$u_security_qst = $cs_array[10];
	$u_security_ans= $cs_array[9];
	
	$u_nomi_name = $cs_array[23];
	$u_nomi_relation = $cs_array[24];
	#$u_nomi_dob = $cs_array[29];
	#$u_nomi_address = $cs_array[28];
	$u_status= $cs_array[29];
	$u_bank_name = $cs_array[31];
	$u_bank_acno = $cs_array[34];
	#$u_bank_acc_type = $cs_array[];
	$u_bank_branch = $cs_array[33];
	$u_bank_ifsc_code = $cs_array[32];
//	$u_bank_micr_code = $cs_array[];
	$u_date = $cs_array[1];
	#$topup_amount = $cs_array[25];
 
		#$username_count = db_scalar("select count(*) from ngo_users  where u_old_userid = '$u_old_userid'   ");	
 		if ($u_date!='') { db_query("update ngo_users set u_date='$u_date' where u_old_userid = '$u_old_userid' "); }
 		if ($username_count==0) {
 			 	$u_ref_userid = db_scalar("select u_id from ngo_users  where u_old_userid = '$ref_userid'   ");
				if ($u_status==0) { $u_status='Banned';} else { $u_status='Active';}
				#$u_sponsor_id = db_scalar("select u_id from ngo_users  where u_username = '$ref_userid'   ");	
				$u_sponsor_id  = $u_ref_userid;
				$u_code = 'Imported User';
			# $sql = "insert into ngo_users set  u_old_userid = '$u_old_userid',u_username='$u_username', u_password = '$u_password',u_password2 = '$u_password2',   u_sponsor_id = '$u_sponsor_id', u_fname = '$u_fname', u_lname = '$u_lname', u_dob = '$u_dob', u_guardian='$u_guardian' ,u_guardian_name='$u_guardian_name' ,u_address = '$u_address' , u_city = '$u_city' , u_state = '$u_state', u_postalcode = '$u_postalcode', u_country = '$u_country', u_phone = '$u_phone',u_mobile = '$u_mobile', u_nomi_name = '$u_nomi_name' , u_nomi_relation = '$u_nomi_relation', u_nomi_dob = '$u_nomi_dob' , u_nomi_address = '$u_nomi_address' ,u_ref_userid = '$u_ref_userid' ,u_ref_side='$u_ref_side' ,u_closeid='$u_closeid'  ,u_product='$u_product', u_panno = '$u_panno', u_slno = '$u_slno' , u_code = '$u_code', u_admin = '$u_admin' ,u_status='Active' , u_bank_name='$u_bank_name', u_bank_acno='$u_bank_acno', u_bank_branch='$u_bank_branch' ,u_bank_ifsc_code='$u_bank_ifsc_code', u_date= ADDDATE(now(),INTERVAL 750 MINUTE),u_last_login=ADDDATE(now(),INTERVAL 750 MINUTE) ";
  			
  			#$result = db_query($sql);
			#$topup_userid = mysqli_insert_id();
 			
			/*if ($topup_amount==4000) {
  			$result_topup 	=db_query("select * from ngo_users_type  where utype_id = '$code_cate'");
			$line_topup  	=mysqli_fetch_array($result_topup);
			$topup_rate 	=$line_topup['utype_formula']; 
			$topup_days_for =$line_topup['utype_value'] ;
			$topup_amount 	='10000' ;
			 
			$sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid' ,topup_by_userid='$_SESSION[sess_uid]',topup_serialno='$code_id', topup_code='Imported Data', topup_plan='TOPUP',topup_sub_plan='' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate' ,topup_amount='$topup_amount' ,topup_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_status='Paid' ";
			 db_query($sql);
 		
			}*/
			
			
			$msg = "Following user id imported successfully. <br>".$user_ids;
			#$imports++; if ($imports > 100) { break;}
		}
	}
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
    <td id="pageHead"><div id="txtPageHead"> Import Cheque </div></td>
  </tr>
</table>
<div align="right"><a href="cheque_list.php">Back to Bill List</a>&nbsp;</div>
<form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
   <table width="90%"  border="0" align="center" cellpadding="5" cellspacing="1" class="tableSearch">
    <tr>
       
      <td  colspan="2" class="errorMsg"><?=$msg?></td>
    </tr>
    <tr>
      <td width="23%"  align="right"><strong>Payment Date  : </strong></td>
      <td width="77%"  class="tableDetails"><input name="pay_date" type="text" id="pay_date"  value="<?=$pay_date?>" /> 
        <span class="errorMsg">(Eg. yyyy-mm-dd)</span> </td>
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