<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 
/*$sql = "select * from ngo_cheque where  check_id ='$check_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
*/
?>

<link href="styles.css" rel="stylesheet" type="text/css">
      <style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
 
.style2 {
	font-size: 14px;
	color: #000000;
	font-weight: bold;
}
-->
      </style>
<? 
//print_r($_POST);
//if(is_post_back()) {
if($_SESSION['arr_check_ids']) {
	//$arr_check_ids = $_POST['arr_check_ids'];
	$arr_check_ids = $_SESSION['arr_check_ids'];
	if(is_array($arr_check_ids)) {
		$str_check_ids = implode(',', $arr_check_ids);
 		//db_query("update ngo_cheque set check_print='Printed' where check_id in ($str_check_ids) ");
 		$sql = "select * from ngo_cheque where check_id in ($str_check_ids) order by check_id desc ";
		$result = db_query($sql);
		while($line= mysqli_fetch_array($result)){
			@extract($line);
?>
	<table width="775" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0"  >
          <tr>
            <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="84%"><strong class="style2">A/C PAYEE </strong></td>
                <td width="16%" height="20" align="left" class="tdData"><span class="style2">
                  <?=strtoupper(date_format2($check_date))?>
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="19%">&nbsp;</td>
                <td width="81%" height="50" valign="top"   class="tdData"><span class="style2"> 
                  <?
				$sql_user = "select * from ngo_users  where u_id='$line[check_userid]'";
 				$result_user = db_query($sql_user);
				$line_user= mysqli_fetch_array($result_user);
				$name =  $line_user['u_fname']." ".$line_user['u_lname'];
				$user_id =$line_user['u_username'];
				$post = db_scalar("select utype_code from ngo_users_type where utype_id='$line_user[u_utype]'");
				echo nl2br(strtoupper($name));
				?>
                  </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top" > 
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15%">&nbsp;</td>
                <td width="64%" height="50" valign="top"><span class="style2">
                  <?=nl2br(strtoupper($check_inword)) ?> 
                </span></td>
                <td width="21%" valign="bottom" class="tdData"><span class="style2">
                  <?=$check_amount ?>
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="76%">&nbsp;</td>
                <td width="24%" height="20" valign="middle" class="tdData">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top" >&nbsp;</td>
          </tr>
          <tr>
            <td height="35" valign="top" >&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top" class="style2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ID :
            <?=$user_id ;?></td>
          </tr>
          <tr>
            <td height="97" valign="top" >&nbsp;</td>
          </tr>
         
       
       </table></td>
    </tr>
  </table>
  <?  
  		}
	}
	
	}
 ?>