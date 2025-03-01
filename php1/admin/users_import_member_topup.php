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
	$u_userid	 	= $cs_array[4];
	#$topup_plan 	= $cs_array[1];
 	#$topup_group 	= $cs_array[2];
	#$topup_days_for	= $cs_array[2];
	#$topup_rate		= $cs_array[2];
	$topup_amount	= $cs_array[3];
	#$topup_bonus	= $cs_array[0];
	$topup_amount2	= $cs_array[3];
	$topup_date 	= $cs_array[9]; 
	$topup_exp_date = $cs_array[10]; 
	$topup_status	= 'Unpaid';
	$topup_datetime	= $cs_array[9];
  	
  		$topup_userid = db_scalar("select u_id from ngo_users  where u_old_userid = '$u_userid'   ");
		$topup_count = db_scalar("select count(*) from ngo_users_recharge  where topup_userid = '$topup_userid' and topup_amount='$topup_amount'  and topup_date='$topup_date'");	
 
 		if ($topup_count==0 && $topup_userid!='') {
 
			// $pay_for = 'Direct Income ' ;
			$sql = "insert into ngo_users_recharge set topup_userid='$topup_userid',topup_days_for ='$topup_days_for' ,topup_rate ='$topup_rate' ,topup_amount='$topup_amount' ,topup_bonus='$topup_bonus' ,topup_amount2='$topup_amount2' ,topup_date='$topup_date' ,topup_exp_date = '$topup_exp_date' ,topup_status='$topup_status' ,topup_datetime = '$topup_datetime'  ";
			 db_query($sql);
 		
			} 
			
			
			$msg = "User payment imported successfully. <br>".$user_ids;
			# $imports++; if ($imports > 100) { break;}
		}
 	fclose ($fp);
	}
 		 
 }
 

//if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "Rs. " .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Import Payout </div></td>
  </tr>
</table>
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