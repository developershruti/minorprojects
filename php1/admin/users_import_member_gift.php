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
	$u_userid1 = $cs_array[2];
	$u_userid2 = $cs_array[4];
	//$gift_refno = $cs_array[1];
 	$gift_amount = $cs_array[5];
	$gift_date = $cs_array[11];
	if ($gift_date=='NULL') {$gift_date ='2013-03-28';}
	#$gift_exp_date = $cs_array[2];
	
	if ($cs_array[6]==1 && $cs_array[7]==1 && $cs_array[8]==1)  { $gift_status ='Accept';}
	else if ($cs_array[6]==2 && $cs_array[7]==2 && $cs_array[8]==0)  { $gift_status ='Waiting';}
	 else if ($cs_array[6]==0 && $cs_array[7]==0 && $cs_array[8]==0)  { $gift_status ='Reject';}
  	
  		$gift_userid = db_scalar("select u_id from ngo_users  where u_old_userid = '$u_userid1' ");
		$gift_by_userid = db_scalar("select u_id from ngo_users  where u_old_userid = '$u_userid2' ");
		$gift_count = db_scalar("select count(*) from ngo_users_gift  where gift_userid = '$gift_userid' and gift_by_userid='$gift_by_userid'  and gift_amount='$gift_amount'");	
 
 		if ($gift_count==0 && $gift_userid!='') {
 
			// $pay_for = 'Direct Income ' ;
			$sql = "insert into ngo_users_gift set  gift_userid ='$gift_userid' ,gift_by_userid ='$gift_by_userid' ,gift_amount='$gift_amount' ,gift_date='$gift_date' ,gift_exp_date=ADDDATE('$gift_date',INTERVAL 5070 MINUTE),gift_status='$gift_status'  ";
			 db_query($sql);
 		
			} 
			
			
			$msg = "User payment imported successfully. <br>".$user_ids;
			#$imports++; if ($imports > 50) { break;}
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