<?
require_once("../includes/surya.dream.php");
if(is_post_back()) {

///adm_type='main' and 
 	$sql="select * from ngo_admin where  adm_login='$_POST[login_id]' and adm_password='$_POST[password]'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
  			if ($_POST['login_id2']!='') {
			//adm_type='main' and 
				$sql="select * from ngo_admin where adm_login='$_POST[login_id]' and adm_password='$_POST[password]' and adm_login2='$_POST[login_id2]' and adm_password2='$_POST[password2]'";
				$result = db_query($sql);
				if ($line_raw = mysqli_fetch_assoc($result)) {
				@extract($line_raw);
					$_SESSION['sess_admin_login_id'] = $adm_login;
					$_SESSION['sess_admin_type'] = $adm_type;
					$_SESSION['sess_admin_plan'] = 'A';
					//
				$ip =  gethostbyaddr($_SERVER['REMOTE_ADDR']);
				$today = db_scalar(" select ADDDATE(now(),INTERVAL 750 MINUTE) ");
   				$mobile = '';
				$message =" Adminitrator login On IP :".$ip." on date:". $today ;
				send_sms($u_mobile,$message);
				 
				header("location: admin_desktop.php");
				exit;
				} else {
					$arr_error_msgs[] = "Invalid Access Code or Access Pass";
 				}
  		}
 	} else {
 		$arr_error_msgs[] = "Invalid Login ID or Password";
		$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 		header("location: login.php");
		exit;
	}
	
}			


?>

<link href="styles.css" rel="stylesheet" type="text/css">
<?php include("header.inc.php");?>
<form action="" method="post">
  <table width="407"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="368" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top"><? include("error_msgs.inc.php");?></td>
    </tr>
    <tr>
      <td><table width="100%"  border="0" cellpadding="15" cellspacing="1" bgcolor="#CFCFCF">
          <tr>
            <td bgcolor="#F5F5F5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" align="left"><img src="images/icons/keys.gif" width="32" height="32" /></td>
                  <td width="87%" align="left" valign="top"><span style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#1E518F; font-weight:bold">Welcome to
                      <?=SITE_NAME?>
                    Administration Suite!</span></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left" valign="top" class="blue_txt">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="34%" valign="top" class="txtLight">Please enter a valid Access Code and Access pass to gain access to the administration console.</td>
                        <td width="66%" align="right" valign="top"><table width="80%"  border="0" cellpadding="7" cellspacing="1" bgcolor="#CFCFCF">
                            <tr>
                              <td bgcolor="#EFEFEF"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td align="left"><strong>Access Code </strong></td>
                                  </tr>
                                  <tr>
                                    <td align="left"><input name="login_id2" type="text" class="textfield" id="login_id2" value="<?=$login_id2?>" size="30" /></td>
                                  </tr>
                                  <tr>
                                    <td align="left"><strong>Access Pass </strong></td>
                                  </tr>
                                  <tr>
                                    <td align="left"><input name="password2" type="password" class="textfield" value="<?=$password2?>" size="30" /></td>
                                  </tr>
                                  
                                  <tr>
                                    <td align="right" style="padding-top:5px">
									<input type="hidden" name="login_id" value="<?=$login_id?>" />
									<input type="hidden" name="password" value="<?=$password?>" />
									
									<input type="image" src="images/buttons/submit.gif" alt="Submit" border="0" /></td>
                                  </tr>
                              </table></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>