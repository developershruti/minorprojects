<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
 
 
 if(is_post_back()) {
  /// and code_useto>=ADDDATE(now(),INTERVAL 750 MINUTE)
	
	$topup_userid= db_scalar("select u_id from ngo_users where u_username='$u_username'");
	if ($topup_userid=='') {$arr_error_msgs[] =  "Invalid user id, please check!";}
 
 	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//print_r($arr_error_msgs);
if (count($arr_error_msgs) ==0) { 
		
		
		 	$result_topup 	= db_query("select * from ngo_users_type  where utype_id = '$utype_id'");
			$line_topup  	= mysqli_fetch_array($result_topup);
			$topup_plan 	= $line_topup['utype_code']; 
 			$topup_amount2 	= $line_topup['utype_value']  ;
			$topup_amount 	= $line_topup['utype_charges'] ;
  			 
  		$sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid' ,topup_by_userid='$topup_userid' , topup_plan='$topup_plan' ,topup_rate='$topup_rate' ,topup_amount='$topup_amount',topup_amount2='$topup_amount2',topup_date=ADDDATE(now(),INTERVAL 750 MINUTE)  ,topup_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_status='Unpaid' ";
		db_query($sql);
		
 		$arr_error_msgs[] =  "$u_username account help giver record generated successfully!";
		
	}
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
}
 
 
 
 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <?php //include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Auto Recharge/Topup </div></td>
        </tr>
      </table>
      <div align="right"><a href="recharge_topup_list.php">Back to Recharge Topup List</a>&nbsp;</div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <input type="hidden" name="check_id" value="<?=$check_id?>"  />
        <table width="90%" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td valign="top" class="maintxt">&nbsp;</td>
            <td valign="top" class="errorMsg"><? include("../error_msg.inc.php");?></td>
          </tr>
        
          <tr>
            <td align="right" valign="top" class="maintxt">User ID: </td>
            <td valign="top"><input name="u_username"  type="text"  alt="blank" emsg="Please enter Userid " /></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="maintxt">Help Amount: </td>
            <td valign="top"><span class="tdData">
              <?
		$sql ="select utype_id , utype_name from ngo_users_type where utype_id>1 order by utype_id asc";  
		echo make_dropdown($sql, 'utype_id', $utype_id,  'class="txtbox"  style="width:140px;"','--select--');
		?>
              </span></td>
          </tr>
          
          <tr>
            <td valign="top" class="maintxt"></td>
            <td valign="top"><input name="Submit" type="submit" value="Submit" /></td>
          </tr>
        </table>
        <br />
        <br />
      </form>
      <? include("bottom.inc.php");?>
