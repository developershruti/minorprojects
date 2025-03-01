<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();

if ($_SESSION['sess_admin_type']=='main') { 
if(is_post_back()) {
@extract($_POST);

 if ($code_cunter<=500) {
	if ($code_username!='' && $code_cate!='') {
		$ctr=1;
	 	$code_userid = db_scalar("select u_id from ngo_users where u_username='$code_username'");
		if ($code_userid!='') {
	 	while ($code_cunter >= $ctr){
		$ctr++;
		//$code_string = date(Ymdhms).
		#$code_string = md5(uniqid(rand(), 1));
		$u_parent_id = db_scalar("select code_id from ngo_code  order by code_id desc limit 0,1")+1;
 		$code_string = 'IM'.$u_parent_id. strtoupper(substr(md5(uniqid(rand(), 1)),0,10));
 
		//code_usefrom =now() ,
 		    $sql = "insert into ngo_code set  code_userid='$code_userid',code_username='$code_username',code_purchase_userid='$code_userid',  code_cate = '$code_cate', code_string = '$code_string', code_plan='REG'  , code_date = ADDDATE(now(),INTERVAL 120 MINUTE) ,code_useto=ADDDATE(now(),INTERVAL 30 DAY) ,code_user='$_SESSION[sess_admin_login_id]', code_group='ADMIN' ";
		db_query($sql);
		$arr_code_ids[] = mysqli_insert_id();
		} 
			$str_code_ids = implode(',', $arr_code_ids);
			$log_count = $code_cunter;
			$sql2 = "insert into ngo_code_log set  log_userid= '0' ,log_sent_userid= '$code_userid' ,log_sent_username='$code_username',log_count='$log_count' ,log_string='$str_code_ids', log_status='Active' ,log_date=ADDDATE(now(),INTERVAL 120 MINUTE), log_user='admin', log_group='PIN' ";
			db_query($sql2);
  			
				$mobile = db_scalar("select u_mobile from ngo_users where u_id='$code_userid'");
				$post = db_scalar("select utype_name from ngo_users_type where utype_id='$code_cate'");
  				$u_mobile = "91".$mobile.' ';
				// send welcome sms to user 
				$message = "" .SITE_NAME." Pin Transfered to Your ID:".$code_username."  Total Pin:".$code_cunter.", For Package:".$post." on date:".date("d-M-Y");
			 #	send_sms($u_mobile,$message);
			 
 				header("Location: code_list.php");
				exit;
		} else {
			$msg="Username does not exist !";
		}
		
		
		
		} else {
		$msg="Plan OR Assign To UserID! OR Assign to Post  is missing!";
		}
 


} else {
	$msg="Maximum limit for  Generate a codeis 100 at a time!";

}
}	
} else {
$msg="You don't have permission to generate new pins!";

}

 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Add/ update Code </div></td>
  </tr>
</table>
<div align="right"><a href="code_list.php">Back to code List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">
	  <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="errorMsg"><?=$msg?></td>
	    </tr>
	 <!-- <tr>
	    <td class="tdLabel">Request ID </td>
	    <td class="tdData"><input type="text" name="code_creqid" value="<?=$code_creqid?>" /></td>
	    </tr>
	  <tr>
	    <td class="tdLabel">Assign To Username </td>
	    <td class="tdData"><input type="text" name="code_userid" value="<?=$code_userid?>" /> 
	    Ex. 100005 </td>
	    </tr>-->
		
		<!-- <tr class="tableSearch">
           <td align="right"><span class="tdLabel">Plan:</span></td>
		   <td><?
			//echo array_dropdown( $ARR_PLAN_TYPE, $code_plan,'code_plan', 'class="txtbox" alt="select" emsg="Please select plan " style="width:120px;"','');
			?></td>
	      </tr>-->
		 <!-- <tr class="tableSearch">
           <td align="right"><span class="tdLabel">Pin For State:</span></td>
		   <td>
		   <input type="text" name="code_state" value="<?=$code_state?>" alt="blank" emsg=" state can not be blank" />
		   <?
			 // echo array_dropdown( $ARR_CODE_STATE, $code_state,'code_state', 'class="txtbox" alt="select" emsg="Please select pin state " style="width:120px;"','');
			?></td>
	      </tr>-->
		 <tr>
	    <td align="right" class="tdLabel">Send Pin  To User ID : </td>
	    <td class="tdData"><input type="text" name="code_username" value="<?=$code_username?>" alt="blank" emsg="Username can not be blank" /> 
	       </td>
	    </tr>
		
	  <tr> 
	    <td width="20%" align="right" class="tdLabel">Total Pin Issue : </td>
	    <td width="80%" class="tdData">
		<input type="text" name="code_cunter" value="<?=$code_cunter?>" alt="number" emsg="Total pin Issue can not be blank" />
 		<!--<select name="code_cunter" s>
		  <option value="10">10</option>
		  <option value="25">25</option>
		  <option value="50">50</option>
		  <option value="100">100</option>
		  <option value="200">200</option>
	      </select>	-->    </td>
	    </tr>
	  <tr>
	    <td align="right" class="tdLabel">Pin welth : </td>
	    <td class="tdData">
		<?
		$sql ="select utype_id , utype_name from ngo_users_type  where utype_status='Active'  order by utype_id asc";  
		echo make_dropdown($sql, 'code_cate', $code_cate,  'class="txtbox" alt="select" emsg="Please select pin welth " style="width:140px;"','--select--');
		?>	
		
		
		
		<?
		// old dropdown sk
		//$sql ="select utype_id , utype_name from ngo_users_type where  utype_status='Active'  and utype_value>=10 order by utype_id asc";  
		//echo make_dropdown($sql, 'code_cate', $code_cate,  'class="txtbox" alt="select" emsg="Please select pin welth " style="width:140px;"','--select--');
		?>			</td>
	    </tr>
	 <!-- <tr>
	    <td class="tdLabel">Assigned  Date </td>
	    <td class="tdData"><? //=get_date_picker("code_usefrom", $code_usefrom)?></td>
	    </tr>
	  

     	    <tr>
     	      <td align="right" class="tdLabel">Pin Group : </td>
     	      <td class="tdData"><input type="text" name="code_group" value="<?=$code_group?>" alt="blank" emsg="Pin Group can not be blank"/></td>
   	      </tr>-->
     	    <tr>
	    <td class="tdLabel">&nbsp;</td>
	    <td class="tdData"><input type="hidden" name="code_id" value="<?=$code_id?>">
		                <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>
    </tr>
  </table>
</form>
<? include("bottom.inc.php");?>