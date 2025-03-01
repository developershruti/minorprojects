<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
///print_r($_POST);
		$arr_error_msgs = array();
		
		#$auto_id = db_scalar("select u_id from ngo_users where u_username = '$u_ref_userid'");
		$total_ref = db_scalar("select count(u_id) from ngo_users where u_id = '$u_ref_userid'");
		if ($total_ref ==0) { $arr_error_msgs[] =  "Referer ID  does not exist!";}
  
 		if($u_id=='') {
			#$total_code = db_scalar("select count(*) from ngo_code where code_id='$u_slno' and code_string='$u_code' and code_is='Available' and  code_cate='$u_utype' and code_status='Active' and code_useto>=ADDDATE(now(),INTERVAL 750 MINUTE)");
			#if ($total_code ==0) { $arr_error_msgs[] =  " Reference SlNo or Code Number does not exist or already used!";}
		}
		
		$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//check if there is no error
 		if (count($arr_error_msgs)==0) {
 			#$u_utype_value = db_scalar("select utype_value from ngo_users_type  where utype_id = '$u_utype'");
			if($u_id!='') {
			//,u_product='$u_product'
			#if ($u_sponsor_id=='' || $u_sponsor_id=='0') {
			#	$u_sponsor_id = get_sponsor_id($u_ref_userid,$u_ref_side);
			#, u_sponsor_id = '$u_sponsor_id'
			#}
				#$u_ref_userid = db_scalar("select  u_id from ngo_users where u_username = '$u_ref_userid'");
 		    	$sql = "update ngo_users set u_ref_userid = '$u_ref_userid',u_ref_side='$u_ref_side' , u_sponsor_id = '$u_sponsor_id', u_password = '$u_password',  u_fname = '$u_fname', u_lname = '$u_lname', u_address = '$u_address', u_city = '$u_city', u_state = '$u_state', u_postalcode = '$u_postalcode' , u_phone = '$u_phone', u_mobile = '$u_mobile'   ,u_last_login=ADDDATE(now(),INTERVAL 750 MINUTE) ,u_admin='$_SESSION[sess_admin_login_id]' $sql_edit_part where u_id = '$u_id'";
 			db_query($sql);
			 
 		} else{
  		    //,u_photo = '$u_photo_name' ,u_product='$u_product'
			$u_parent_id = db_scalar("select u_parent_id from ngo_users  order by u_id desc limit 0,1")+rand(7,15);
			$u_username = ''.$u_parent_id;
			$u_ref_userid = db_scalar("select  u_id from ngo_users where u_username = '$u_ref_userid'");
 			
 			#if ($u_join_mode=='Spill') {
 			#	$u_sponsor_id = get_sponsor_id($u_ref_userid,$u_ref_side);
			#} else { $u_sponsor_id=$u_ref_userid; }
			
			
			//$u_closeid = db_scalar("select close_id from ngo_closing where close_status = 'Active' order by close_id desc limit 0,1");
			//$sql = "insert into ngo_users set u_ref_userid = '$u_ref_userid' ,u_parent_id='$u_parent_id',u_join_mode='$u_join_mode'   ,u_ref_side='$u_ref_side', u_sponsor_id = '$u_sponsor_id', u_username = '$u_username', u_password = '$u_password', u_email = '$u_email', u_dob = '$u_dob', u_gender = '$u_gender', u_fname = '$u_fname', u_lname = '$u_lname',  u_guardian= '$u_guardian',  u_guardian_name = '$u_guardian_name' ,u_address = '$u_address', u_city = '$u_city', u_state = '$u_state', u_postalcode = '$u_postalcode', u_country = 'India', u_phone = '$u_phone',u_mobile='$u_mobile', u_nomi_name = '$u_nomi_name' , u_nomi_relation = '$u_nomi_relation', u_nomi_dob = '$u_nomi_dob' , u_nomi_address = '$u_nomi_address' ,u_admin='$_SESSION[sess_admin_login_id]' ,u_closeid='$u_closeid'  ,u_utype='$u_utype' ,u_utype_value='$u_utype_value' , u_panno = '$u_panno', u_slno = '$u_slno' , u_code = '$u_code' , u_status='Active', u_date=ADDDATE(now(),INTERVAL 750 MINUTE),u_last_login=ADDDATE(now(),INTERVAL 750 MINUTE) ";
 			//$result = db_query($sql);
			//$id = mysqli_insert_id();
			//$_SESSION[sess_recid] =$id ;
			
 			#$sql_code="update ngo_code set code_is='Used', code_use_userid='$id' ,code_use_name='$u_fname' ,code_usefrom=ADDDATE(now(),INTERVAL 750 MINUTE) where code_id = '$u_slno' and code_string='$u_code'";
 			#db_query($sql_code);
			
			#$u_total_referer = db_scalar("select count(*) from ngo_users where  u_ref_userid ='$u_ref_userid'  ");	
			#db_query("update ngo_users set u_total_referer='$u_total_referer' where u_id='$u_ref_userid'");
			#$message = "WELCOME TO SMS Earning. ".$u_fname." " .$u_lname." Your Id Number:".$u_username." & PASSWORD ".$u_password.", FOR MORE DETAILS VISIT ".SITE_URL;
			 #send_sms($u_mobile,$message);
 		 
			 
			
 		}
	 header("Location: users_list.php");
	 exit;
	}
}
$u_id = $_REQUEST['u_id'];
if($u_id!='') {
	$sql = "select * from ngo_users where u_id = '$u_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
 		#$u_ref_userid = db_scalar("select u_username from ngo_users where u_id = '$u_ref_userid'");
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
                              <td align="left" class="tdLabel">Referer ID<span class="error">:</span> </td>
                              <td align="left" valign="top" class="maintxt"><input name="u_ref_userid" type="text" class="txtbox" id="u_ref_userid" value="<?=$u_ref_userid?>" alt="blank" emsg="Please enter member reference ID" /></td>
          </tr>
                          <tr>
                             <td align="left" class="tdLabel">Spill  ID: </td>
                             <td align="left" valign="top" class="maintxt"><input name="u_sponsor_id" type="text" class="txtbox" id="u_sponsor_id" value="<?=$u_sponsor_id?>" alt="blank" emsg="Please enter member sponsor ID" /></td>
                           </tr> 
                           <tr>
                              <td align="left" class="tdLabel">Referer Side:</td>
                              <td align="left" valign="top" class="maintxt"><?=left_right_dropdown('u_ref_side',$u_ref_side,'alt="select" emsg="Please select referer side"')?></td>
                            </tr> 
                              
          <tr>
            <td width="169" class="tdLabel">Password:</td>
            <td width="806" class="tdData"><input name="u_password" type="text" id="u_password" value="<?=$u_password?>"  class="textfield" alt="blank" emsg="Please give the password"></td>
          </tr>
         
        
          <tr>
            <td width="169" class="tdLabel">First Name:</td>
            <td width="806" class="tdData"><input name="u_fname" type="text" id="u_fname" value="<?=$u_fname?>"  class="textfield" alt="blank" emsg="Please give the first name"></td>
          </tr>
          <tr>
            <td width="169" class="tdLabel">Last Name:</td>
            <td width="806" class="tdData"><input name="u_lname" type="text" id="u_lname" value="<?=$u_lname?>"  class="textfield" ></td>
          </tr><!--alt="blank" emsg="Please give the last name"-->
           
          <tr>
            <td width="169" class="tdLabel">Address:</td>
            <td width="806" class="tdData"><input name="u_address" type="text" id="u_address" value="<?=$u_address?>"  class="textfield" ></td>
          </tr>
          <tr>
            <td width="169" class="tdLabel">City:</td>
            <td width="806" class="tdData"><input name="u_city" type="text" id="u_city" value="<?=$u_city?>"  class="textfield" ></td>
          </tr>
          <tr>
            <td width="169" class="tdLabel">State:</td>
            <td width="806" class="tdData"><input name="u_state" type="text" id="u_state" value="<?=$u_state?>"  class="textfield" >            </td>
          </tr>
          <tr>
            <td width="169" class="tdLabel">Postal Code:</td>
            <td width="806" class="tdData"><input name="u_postalcode" type="text" id="u_postalcode" value="<?=$u_postalcode?>"  class="textfield"></td>
          </tr>
          
          <tr>
            <td width="169" class="tdLabel">Phone:</td>
            <td width="806" class="tdData"><input name="u_phone" type="text" id="u_phone" value="<?=$u_phone?>"  class="textfield"></td>
          </tr>
          
		  <tr>
            <td width="169" class="tdLabel">Mobile:</td>
            <td width="806" class="tdData"><input name="u_mobile" type="text" id="u_mobile" value="<?=$u_mobile?>"  class="textfield"></td>
          </tr>
		  <tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="tdData">&nbsp;</td>
          </tr>
          <tr>
            <td width="169" class="tdLabel">Nominee Name:</td>
            <td width="806" class="tdData"><input name="u_nomi_name" type="text" id="u_nomi_name" value="<?=$u_nomi_name?>"  class="textfield"></td>
          </tr>
          <tr>
            <td width="169" class="tdLabel">Nominee relation:</td>
            <td width="806" class="tdData"><input name="u_nomi_relation" type="text" id="u_nomi_relation" value="<?=$u_nomi_relation?>"  class="textfield"></td>
          </tr>
          
          <tr>
            <td width="169" class="tdLabel">Nominee Address:</td>
            <td width="806" class="tdData"><input name="u_nomi_address" type="text" id="u_nomi_address" value="<?=$u_nomi_address?>"  class="textfield"></td>
          </tr>
         <!-- <tr>
            <td class="tdLabel">Select Product:</td>
            <td class="tdData"><?
						// $sql ="select prod_id , prod_name from ngo_products where prod_status='Active'  ";  
						//echo make_dropdown($sql, 'u_product', $u_product,  'class="txtfleid" style="width:150px;" ', 'Please select');
						//alt="select" emsg="Please Select product Name"
							?></td>
          </tr>-->
          <tr>
            <td class="tdLabel">Pan card No: </td>
            <td class="tdData"><input name="u_panno" type="text" id="u_panno" value="<?=$u_panno?>"  class="textfield" /></td>
          </tr>
          
          <tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="tdData">&nbsp;</td>
          </tr>
       
          
          <tr>
            <td class="tdLabel">&nbsp;</td>
            <td class="tdData"><input type="hidden" name="u_id" value="<?=$u_id?>">
			<input type="hidden" name="u_ref_userid_old" value="<?=$u_ref_userid?>">
			
              <input type="hidden" name="old_user_image" value="<?=$u_photo?>" />
              <input type="image" name="imageField" src="images/buttons/submit.gif" /><!----></td>
          </tr>
        </table>
      </form>
      <? include("bottom.inc.php");?>
