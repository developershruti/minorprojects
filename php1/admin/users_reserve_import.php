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
	//Reference ID, First Name, Address, City , State, Postal Code, Mobile, Pan Card 
	$u_id = $cs_array[0];
	if ($cs_array[2]!='' )  { $sql_part .=" , u_ref_userid ='$cs_array[2]' " ;}
	if ($cs_array[3]!='' )  { $sql_part .=" , u_fname ='$cs_array[3]' " ;}
	if ($cs_array[4]!='' ) { $sql_part .=" , u_address ='$cs_array[4]' " ;}
	if ($cs_array[5]!='' ) { $sql_part .=" , u_city ='$cs_array[5]' " ;}
	if ($cs_array[6]!='' ) { $sql_part .=" , u_state ='$cs_array[6]' " ;}
	if ($cs_array[7]!='' ) { $sql_part .=" , u_mobile ='$cs_array[7]' " ;}
	if ($cs_array[7]!='' ) { $sql_part .=" , u_date=ADDDATE(now(),INTERVAL 750 MINUTE),u_last_login=ADDDATE(now(),INTERVAL 750 MINUTE) " ;}
	if ($cs_array[7]!='' ) { $sql_part .=" , u_panno ='$cs_array[9]' " ;}
	
	
/*	$check_rec_id = $cs_array[8];
	$check_rec_name = $cs_array[9]; 
 	$check_rec_date = $cs_array[10];
	$check_contact = $cs_array[11];
	$check_status = $cs_array[12];*/
 		if ($u_id!='') {
			$sql = "update ngo_users set  u_id='$u_id' $sql_part where u_id='$u_id'  ";
			db_query($sql);
			 
			 //--------------------------------------
			 	
	//------------------working payout code start ------------------ 
  
 	 // select user list to generate payout for 
	$sql_gen = "select u_id ,u_ref_userid ,u_closeid ,u_utype_value from ngo_users where u_ref_userid!=0  and u_parent_id=0  and  u_id='$u_id' ";
	$result_gen = db_query($sql_gen);
	$line_gen = mysqli_fetch_array($result_gen);
	@extract($line_gen);
 	if ($u_ref_userid!='' && $u_ref_userid!=0){
  		// Direct Income level 1
  		 $payout_count1 = db_scalar("select count(upay_id) from ngo_users_payout where  upay_userid = '$u_ref_userid'  and upay_refid = '$u_id' and upay_for='Working' ");
		if ($payout_count1==0) {
 			$workingpayrate1 = db_scalar("select sett_value from ngo_setting where sett_id=19 ");
			$upay_amount = $workingpayrate1*$u_utype_value;
 		 	$sql = "insert into ngo_users_payout set  upay_closeid = '$u_closeid', upay_sponsor_level ='1', upay_pono='1', upay_userid = '$u_ref_userid',upay_refid = '$u_id' ,upay_for = 'Working' ,upay_qty = '$u_utype_value', upay_rate = '$workingpayrate1', upay_amount = '$upay_amount' ,upay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql);
		
 		// Direct Income level 2
		//print "ID 2 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid' ";
		$u_ref_userid2 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
		if ($u_ref_userid2!='' && $u_ref_userid2!=0){
			$workingpayrate2 = db_scalar("select sett_value from ngo_setting where sett_id=20 ");
			$upay_amount2 = $workingpayrate2*$u_utype_value;
			$sql2 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='2', upay_pono='2'  ,upay_userid='$u_ref_userid2' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate2', upay_amount='$upay_amount2' ,upay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
 			db_query($sql2);
			// Direct Income level 3
			//print "ID 3 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid2' ";
			 $u_ref_userid3 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid2' ");
			if ($u_ref_userid3!='' && $u_ref_userid3!=0){
				$workingpayrate3 = db_scalar("select sett_value from ngo_setting where sett_id=21 ");
				$upay_amount3 = $workingpayrate3*$u_utype_value;
				$sql3 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='3',  upay_pono='3', upay_userid='$u_ref_userid3' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate3', upay_amount='$upay_amount3' ,upay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
				db_query($sql3);
				// Direct Income level 4
				//print "ID 4 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid3' ";
				
				$u_ref_userid4 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid3' ");
				if ($u_ref_userid4!='' && $u_ref_userid4!=0){
					$workingpayrate4 = db_scalar("select sett_value from ngo_setting where sett_id=22 ");
					$upay_amount4 = $workingpayrate4*$u_utype_value;
					$sql4 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='4',  upay_pono='4' , upay_userid='$u_ref_userid4' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate4', upay_amount='$upay_amount4' ,upay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
					db_query($sql4);
			  		// Direct Income level 5
					//print "ID 5 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid4' ";
					 $u_ref_userid5 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid4' ");
					if ($u_ref_userid5!='' && $u_ref_userid5!=0){
						$workingpayrate5 = db_scalar("select sett_value from ngo_setting where sett_id=23 ");
						$upay_amount5= $workingpayrate5*$u_utype_value;
						$sql5 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='5', upay_pono='5' , upay_userid='$u_ref_userid5' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate5', upay_amount='$upay_amount5' ,upay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
						db_query($sql5);
 					}
				  }
		  	    }
 		      } 
 	        }
         }
 			 
			 //--------------------------------------
			 
			 
			 $user_ids .= $cs_array[2] ." ,";
			}
			
			$msg = "Following User ID updated successfully. <br>".$user_ids;
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
    <td id="pageHead"><div id="txtPageHead"> Import Reserve User ID </div></td>
  </tr>
</table>
<div align="right"><a href="users_list.php">Back to users List</a>&nbsp;</div>
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
      <td align="right" class="tdLabel"><strong>Update field: </strong></td>
      <td class="tableDetails">Reference ID, First Name, Address, City , State, Postal Code, Mobile, Pan Card </td>
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