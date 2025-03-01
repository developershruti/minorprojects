<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
///print_r($_POST);
	$arr_error_msgs = array();
	if ($u_id =='') { $arr_error_msgs[] =  "User ID  does not exist!";}
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
	if (count($arr_error_msgs)==0) {
		$u_ref_userid = db_scalar("select  u_id from ngo_users where u_username = '$u_ref_userid'");
		
		$sql = "update ngo_users set   u_username = '$u_username',  u_password = '$u_password', u_password2 = '$u_password2', u_email = '$u_email' , u_gender = '$u_gender', u_fname = '$u_fname', u_lname = '$u_lname',  u_guardian= '$u_guardian',  u_guardian_name = '$u_guardian_name',u_address = '$u_address', u_city = '$u_city', u_state = '$u_state', u_postalcode = '$u_postalcode' , u_phone = '$u_phone',  u_gpay = '$u_gpay',   u_mobile = '$u_mobile', u_nomi_name = '$u_nomi_name' , u_nomi_relation = '$u_nomi_relation'  , u_bank_lock = '$u_bank_lock',u_panno='$u_panno' ,u_bitcoin='$u_bitcoin'   , u_bank_acc_holder='$u_bank_acc_holder', u_bank_name='$u_bank_name', u_bank_acno='$u_bank_acno', u_bank_branch='$u_bank_branch' ,u_bank_ifsc_code='$u_bank_ifsc_code' ,u_remark='$u_remark'  ,u_acc_type='$u_acc_type',u_last_login=ADDDATE(now(),INTERVAL 750 MINUTE) ,u_admin='$_SESSION[sess_admin_login_id]' $sql_edit_part where u_id = '$u_id'";
	 	db_query($sql);
		
		if ($sms_send=='1') {
		// $message = "Dear $u_fname, Your login Username is $u_username and Password is $u_password, Thanks for joining ".SITE_URL; 
		//           Dear #value, Your login Username is #value and Password is #value, Thanks for joining #value
      //send_sms ($u_mobile,$message,$msg_id=''); 
    

 		}
 		if ($email_send=='1') {
			
// send email 
			
$message="
Hi ". $u_fname .", 

Thank you for becoming a member of the ". SITE_NAME ." community.  We encourage you to get into the habit of commenting on our business. This is a proven way to help us provide timely and relevant information to you.

Visit us regularly to see what's new.

Your login information is provided below.  Please also keep in mind that you must finish your registration by clicking on the link below.
 
 User ID = ". $u_username  ."
Password = ". $u_password. "
Transaction =". $u_password2. "
  
Once again, Thank you for being a part of our community!

". SITE_NAME ."
 ".SITE_WS_PATH ."
";
 
  			$HEADERS  = "MIME-Version: 1.0 \n";
			$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
			$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
			$SUBJECT  = "You are welcome to  ".SITE_NAME ;
 			if ($u_email!='') { @mail($u_email, $SUBJECT, $message,$HEADERS);}

 /// end 
		}
		
		
		
		
		 header("Location: users_list.php");
		 exit;
	}
}
$u_id = $_REQUEST['u_id'];
if($u_id!='') {
	$sql = "select * from ngo_users where u_id = '$u_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result, MYSQLI_BOTH)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
 		$u_ref_userid = db_scalar("select u_username from ngo_users where u_id = '$u_ref_userid'");
	} 
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Users</div></td>
        </tr>
      </table>
      <div align="right"><a href="users_list.php">Back to Users List</a>&nbsp;</div>
      <form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
        <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
          <!--<tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="txtTotal">New Regration Process stoped for some time....... </td>
          </tr>-->
		  <tr>
		    <td class="tdLabel">&nbsp;</td>
		    <td class="txtTotal"><? include("../error_msg.inc.php");?></td>
	      </tr>
	 <tr>
            <td width="18%" align="right" class="tdLabel">Account Type :</td>
            <td width="806" class="tdData"> 
			 <? 
                               echo array_dropdown($ARR_USER_GROUP, $u_acc_type, 'u_acc_type',$extra);
                               ?>			</td>
          </tr>
		    <tr>
            <td width="18%" align="right" class="tdLabel">Username:</td>
            <td width="806" class="tdData"><input name="u_username" type="text" id="u_username" value="<?=$u_username?>"  class="textfield" alt="blank" emsg="Please ender User ID "></td>
          </tr>
		 
          <tr>
            <td width="18%" align="right" class="tdLabel">First Name:</td>
            <td width="806" class="tdData"><input name="u_fname" type="text" id="u_fname" value="<?=$u_fname?>"  class="textfield" alt="blank" emsg="Please give the first name"></td>
          </tr>
         <!-- <tr>
            <td width="169" class="tdLabel">Last Name:</td>
            <td width="806" class="tdData"><input name="u_lname" type="text" id="u_lname" value="<?=$u_lname?>"  class="textfield" ></td>
          </tr> -->
		   <tr>
            <td width="18%" align="right" class="tdLabel">Password:</td>
            <td width="806" class="tdData"><input name="u_password" type="text" id="u_password" value="<?=$u_password?>"  class="textfield" alt="blank" emsg="Please give the password"></td>
          </tr>
         
         
           <tr>
             <td align="right" class="tdLabel">Security Code :</td>
             <td class="tdData"><input name="u_password2" type="text" id="u_password2" value="<?=$u_password2?>"  class="textfield" alt="blank" emsg="Please enter security code" /></td>
           </tr>
          <tr>
            <td width="18%" align="right" class="tdLabel">Gender:</td>
            <td width="806" class="tdData"><?=gender_dropdown($u_gender,$extra)?></td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">Guardian:</td>
            <td class="tdData"><?=guardian_dropdown('u_guardian',$u_guardian)?></td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">Guardian name : </td>
            <td class="tdData"><input name="u_guardian_name" type="text" id="u_guardian_name" value="<?=$u_guardian_name?>"  class="textfield" ></td><!--alt="blank" emsg="Please give the last name"-->
          </tr>
		  
		  
			 <!-- <tr>
                        
                        <td align="right" valign="top" class="tdLabel">DOB<span class="error"> </span></td>
                        <td align="left" valign="top">
						<? //=get_date_picker("u_dob", $u_dob)?>						 </td>
                      </tr>-->
			
					    <tr>
                       
                        <td align="right" valign="top" class="tdLabel" >Email</td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="u_email" type="text" class="txtbox" id="u_email" style="width:200px;" value="<?=$u_email?>"  />
                        </span></td>
                      </tr> 
			 
          <tr>
            <td width="18%" align="right" class="tdLabel">Address:</td>
            <td width="806" class="tdData"><input name="u_address" type="text" id="u_address" value="<?=$u_address?>"  class="textfield" ></td>
          </tr>
          <tr>
            <td width="18%" align="right" class="tdLabel">City:</td>
            <td width="806" class="tdData"><input name="u_city" type="text" id="u_city" value="<?=$u_city?>"  class="textfield" ></td>
          </tr>
          <tr>
            <td width="18%" align="right" class="tdLabel">State:</td>
            <td width="806" class="tdData"><input name="u_state" type="text" id="u_state" value="<?=$u_state?>"  class="textfield" >            </td>
          </tr>
          <tr>
            <td width="18%" align="right" class="tdLabel">Postal Code:</td>
            <td width="806" class="tdData"><input name="u_postalcode" type="text" id="u_postalcode" value="<?=$u_postalcode?>"  class="textfield"></td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">Country:</td>
            <td width="806" class="tdData"> <?
						 $sql ="select countries_name , countries_name from ngo_countries  ";  
						echo make_dropdown($sql, 'u_country', $u_country='India',  'class="txtfleid" style="width:200px;"', 'Please select'); 
						//alt="select" emsg="Please Select The Country Name"
							?></td>
          </tr> 
          <tr>
            <td width="18%" align="right" class="tdLabel">Whatsapp : </td>
            <td width="806" class="tdData"><input name="u_phone" type="text" id="u_phone" value="<?=$u_phone?>"  class="textfield"></td>
          </tr>
          
		  <tr>
            <td width="18%" align="right" class="tdLabel">Mobile:</td>
            <td width="806" class="tdData"><input name="u_mobile" type="text" id="u_mobile" value="<?=$u_mobile?>"  class="textfield"></td>
          </tr>
		  <tr>
		    <td align="right" class="tdLabel">&nbsp;</td>
		    <td class="tdData">&nbsp;</td>
	      </tr>
		 <!--  <tr align="right">
                        <td colspan="3" align="left" valign="top"><strong>Account Type  </strong></td>
          </tr>
		  
		  
		   <tr align="right">
                        <td colspan="3" align="left" valign="top"><strong> Wallet Details </strong></td>
          </tr>
                      <tr>
                         <td align="right" valign="top" class="tdLabel">Account Type: </td>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr>-->
                        <!--<tr>
                         
                        <td width="18%" align="right" valign="top" class="tdLabel">  Coin Wallet <span class="error"> : </span> </td>
                        <td width="806" align="left" valign="top"><span class="maintxt">
                          <input name="u_cardano_gold" type="text" class="txtbox" id="u_cardano_gold" style="width:350px;" value="<?=$u_razoo_coin?>" />
                      </span></td>
                     </tr>
		  
 	   <tr align="right">
                        <td colspan="3" align="left" valign="top"><strong>Digital Wallet Details </strong></td>
          </tr>
                     <tr>
                         <td align="right" valign="top" class="tdLabel">Account Type: </td>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr> 
                      <tr>
                         
                        <td width="18%" align="right" valign="top" class="tdLabel">Google Pay<span class="error"> : </span> </td>
                        <td width="806" align="left" valign="top"><span class="maintxt">
                          <input name="u_gpay" type="text" class="txtbox" id="u_gpay" style="width:350px;" value="<?=$u_gpay?>" />
                      </span></td>
                      </tr>
					  <tr>
                         
                        <td width="18%" align="right" valign="top" class="tdLabel">Phone Pay<span class="error"> : </span> </td>
                        <td width="806" align="left" valign="top"><span class="maintxt">
                          <input name="u_ppay" type="text" class="txtbox" id="u_ppay" style="width:350px;" value="<?=$u_ppay?>" />
                    </span></td>
                      </tr>-->
		<tr align="right">
                        <td colspan="3" align="left" valign="top"><strong>Crypto Currency Details </strong></td>
          </tr>
                     <!-- <tr>
                         <td align="right" valign="top" class="tdLabel">Account Type: </td>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr>-->
                      <tr>
                         <td width="18%" align="right" valign="top" class="tdLabel">USDT Wallet Address<span class="error"> : </span> </td>
                        <td width="806" align="left" valign="top"> 
                          <input name="u_bitcoin" type="text" class="txtbox" id="u_bitcoin" style="width:350px;" value="<?=$u_bitcoin?>" />                    </td>
                      </tr>	
					 <!--
					  <tr>
                         <td width="18%" align="right" valign="top" class="tdLabel">TRX Wallet Address<span class="error"> : </span> </td>
                        <td width="806" align="left" valign="top"> 
                          <input name="u_ripwallet" type="text" class="txtbox" id="u_ripwallet" style="width:350px;" value="<?=$u_ripwallet?>" />
                    </td>
                      </tr>	-->		  
					  
					  
		  <tr align="right">
                        <td colspan="3" align="left" valign="top"><strong>Bank Account Details </strong></td>
          </tr>
                     <!-- <tr>
                         <td align="right" valign="top" class="tdLabel">Account Type: </td>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr>-->
                      <tr>
                         
                        <td width="18%" align="right" valign="top" class="tdLabel">Bank Name<span class="error"> : </span> </td>
                        <td width="806" align="left" valign="top"><span class="maintxt">
                          <input name="u_bank_name" type="text" class="txtbox" id="u_bank_name" style="width:200px;" value="<?=$u_bank_name?>" />  </span></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" class="tdLabel"><span class="maintxt">Acc Holder Name <span class="error">:</span></span></td>
                        <td align="left" valign="top"><input name="u_bank_acc_holder" type="text" class="txtbox" id="u_bank_acc_holder" style="width:200px;" <?=$disable?> value="<?=$u_bank_acc_holder?>"  /></td>
                      </tr>
                      <tr>
                        
                        <td align="right" valign="top" class="tdLabel">Account Number<span class="error"> : </span> </td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="u_bank_acno" type="text" class="txtbox" id="u_bank_acno" style="width:200px;" value="<?=$u_bank_acno?>"/>  </span></td>
                      </tr>
                      
                      <tr>
                       
                        <td align="right" valign="top" class="tdLabel">Branch Name<span class="error"> : </span> </td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="u_bank_branch" type="text" class="txtbox" id="u_bank_branch" style="width:200px;" value="<?=$u_bank_branch?>" />  </span></td>
                      </tr>
					
		    <tr>
                        
                        <td align="right" valign="top" class="tdLabel">IFSC Code<span class="error"> : </span> </td>
                        <td align="left" valign="top"> <input name="u_bank_ifsc_code" type="text" class="txtbox" id="u_bank_ifsc_code" style="width:200px;" value="<?=$u_bank_ifsc_code?>" />   </td>
                      </tr>
		  
		  <tr>
                        
                        <td align="right" valign="top" class="tdLabel">Pan Card No. <span class="error"> : </span> </td>
                        <td align="left" valign="top"> <input name="u_panno" type="text" class="txtbox" id="u_panno" style="width:200px;" value="<?=$u_panno?>" />  </td>
                      </tr>
		  
		  
		  
		    <!--
		  
		  
		  <tr>
            <td align="right" class="tdLabel">&nbsp; </td>
            <td class="tdData">&nbsp;</td>
          </tr>
          <tr>
            <td width="18%" align="right" class="tdLabel">Nominee Name:</td>
            <td width="806" class="tdData"><input name="u_nomi_name" type="text" id="u_nomi_name" value="<?=$u_nomi_name?>"  class="textfield"></td>
          </tr>
          <tr>
            <td width="18%" align="right" class="tdLabel">Nominee relation:</td>
            <td width="806" class="tdData"><input name="u_nomi_relation" type="text" id="u_nomi_relation" value="<?=$u_nomi_relation?>"  class="textfield"></td>
          </tr>
          
          <tr>
            <td width="18%" align="right" class="tdLabel">Nominee Address:</td>
            <td width="806" class="tdData"><input name="u_nomi_address" type="text" id="u_nomi_address" value="<?=$u_nomi_address?>"  class="textfield"></td>
          </tr>
        <tr>
            <td class="tdLabel">Select Product:</td>
            <td class="tdData"><?
						// $sql ="select prod_id , prod_name from ngo_products where prod_status='Active'  ";  
						//echo make_dropdown($sql, 'u_product', $u_product,  'class="txtfleid" style="width:150px;" ', 'Please select');
						//alt="select" emsg="Please Select product Name"
							?></td>
          </tr>-->
          <tr>
            <td align="right" class="tdLabel">Pan card No: </td>
            <td class="tdData"><input name="u_panno" type="text" id="u_panno" value="<?=$u_panno?>"  class="textfield" /></td>
          </tr>
          
          <tr>
            <td align="right" valign="top" class="tdLabel">Withdrawal Closed<span class="error"> : </span> </td>
            <td align="left" valign="top"><?=yes_no_dropdown('u_bank_lock',$u_bank_lock)?></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="tdLabel">Remark:</td>
            <td class="tdData"><textarea name="u_remark" cols="80" rows="6"><?=$u_remark?></textarea> </td>
          </tr>
       <!-- <tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="tdData"><input name="sms_send" type="checkbox" id="sms_send" value="1" /> Send welcome SMS to user </td>
          </tr>  
          
          <tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="tdData"><input name="email_send" type="checkbox" id="email_send" value="1" /> Send welcome Email to user </td>
          </tr>
          -->
          <tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="tdData"><input type="hidden" name="u_id" value="<?=$u_id?>">
			<input type="hidden" name="u_username2" value="<?=$u_username2?>">
			                <input type="hidden" name="old_user_image" value="<?=$u_photo?>" />
              <input type="image" name="imageField" src="images/buttons/submit.gif" /><!----></td>
          </tr>
        </table>
      </form>
      <? include("bottom.inc.php");?>
