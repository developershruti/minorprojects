<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
//print_r($_POST);
if(is_post_back()) {
 
	 
			if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ){
 		if ($sms_text!='') {
 				if ($msg_group=='ALL') {
          $sql_test = "select u_mobile from ngo_users  where u_mobile!='' and u_status='Active'";
         } else if ($msg_group=='PAID') {
          $sql_test = "select u_mobile from ngo_users  where u_mobile!='' and u_status='Active' and u_id in (select topup_userid from ngo_users_recharge where topup_status='Paid')";
        } else if ($msg_group=='UNPAID') {
          $sql_test = "select u_mobile from ngo_users  where u_mobile!='' and u_status='Active' and u_id not in (select topup_userid from ngo_users_recharge where topup_status='Paid') ";
        }
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
					$mobile[]=$line_test['u_mobile'];
				}
 			 	$mobilenumber = implode(",",$mobile);
				
				//send sms to user 
				$message = $sms_text;
			$msg = send_sms($mobilenumber,$message);
			 
 		}
	}	 
	//header("Location: ".$_SERVER['HTTP_REFERER']);
	//exit;
 }
 

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Send SMS to User </div></td>
  </tr>
</table>
<form method="post" name="form2" id="form2" onsubmit="return confirm_submit(this)">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" >
                  <tr>
                    <td align="left" style="padding:2px">
                    <?=$msg ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" >
                      <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="20%" align="right"><br />
SMS Text: </td>
                        <td width="50%" align="left"><textarea name="sms_text" cols="60" rows="3"><?=$sms_text?></textarea></td>
                        <td width="11%" align="right">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="right"> Message Group : </td>
                        <td align="left"><label>
                          <select name="msg_group">
                            
                            <option value="PAID">SMS Only on Paid Users</option>
                            <option value="UNPAID">SMS Only on Unpaid Users</option>
                            <option value="ALL">SMS to All Users</option>
                          </select>
                        </label></td>
                        <td align="right">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="left"><input name="Submit" type="image" id="Featured" src="images/buttons/submit.gif"  /></td>
                        <td align="right">&nbsp;</td>
                      </tr>
                      
                    </table></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding:2px"><!--	<input name="Featured" type="image" id="Featured" src="images/buttons/featured.gif" onclick="return featuredConfirmFromUser('arr_u_ids[]')"/>
                    <input name="Unfeatured" type="image" id="Unfeatured" src="images/buttons/unfeatured.gif" onclick="return UnfeaturedConfirmFromUser('arr_u_ids[]')"/><input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_u_ids[]')"/>--></td>
                  </tr>
        </table>
       
      </form>
          <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
