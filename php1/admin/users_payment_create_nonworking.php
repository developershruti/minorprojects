<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 #print_r($_POST);

 if(is_post_back()) {
 $pay_group ='NON_WORKING';
 
//$ARR_CLUB_GROUP = array(''=>'Please Select' ,'ROZI_4_STAR_CLUB'=>'The WEZOOM 4 Star Club', 'ROZI_16_STAR_CLUB'=>'The WEZOOM 16 Star Club','ROZI_64_STAR_CLUB'=>'The WEZOOM 64 Star Club','ROZI_256_STAR_CLUB'=>'The WEZOOM 256 Star Club','ROZI_1024_STAR_CLUB'=>'The WEZOOM 1024 Star Club','ROZI_4096_STAR_CLUB'=>'The WEZOOM 4096 Star Club','ROZI_16384_STAR_CLUB'=>'The WEZOOM 16384 Star Club','ROZI_32768_STAR_CLUB'=>'The WEZOOM 32768 Star Club');
if($pay_group !='' && $pay_amount!='') {
$sql_test = "select u_id,u_username,topup_id,topup_userid,topup_amount,topup_status,topup_date from  ngo_users,ngo_users_recharge  where topup_userid=u_id ";
 
$result_test = db_query($sql_test);
$mobile = array();
while ($line_test= mysqli_fetch_array($result_test)){
@extract($line_test);
if ($u_id!='' && $topup_amount>0 ) { 
 
  
///echo "select count(*) from ngo_users_payment where  pay_userid = '$topup_userid' and pay_plan_level='$pay_plan_level' and pay_plan='$pay_group' and pay_group='$pay_group' and pay_date='$payment_date'";
	$payout_count = db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$topup_userid'   and pay_plan='$pay_group' and pay_group='$pay_group' and pay_date='$payment_date'  ") ;
   
   
//$pay_amount = $pay_amount;  ///form amount 
$pay_rate=2;
///$pay_group = "CW"
$pay_drcr = 'Cr';
 
if ($payout_count==0) {
		   $msg.= $u_id.' ,';
			//$u_parent_id = db_scalar("select pay_id from ngo_users_payment  order by pay_id desc limit 0,1")+1;
		   $pay_id_refno =  'R'.rand(100,999).$u_parent_id.rand(100,999);
		   $pay_for =  'Non Working Income ';
		  print "<br>==>  $topup_userid | $pay_group | $pay_amount "; 
		  
		  $sql22 = "insert into ngo_users_payment set  pay_id_refno='$pay_id_refno',  pay_drcr='$pay_drcr',  pay_userid = '$topup_userid'  ,pay_group='$pay_group',pay_plan='$pay_group',pay_plan_level='0' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = 'F' ,pay_rate = '100', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date='$payment_date' ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE) ";
		   $result = db_query($sql22);
		   //$arr_error_msgs[] = "$pay_group Club Income of level $pay_plan_level, Sent Successfully To, Auto Id : $topup_userid , Username : $u_username";
		  // $_SESSION['arr_error_msgs'] = $arr_error_msgs;
		 }
		}
	   }	
	}
   
}	 
///
 
 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead">Non Working Income   Create </div></td>
        </tr>
      </table>
      <div align="right"><a href="users_payment_list.php">Back to Payment List</a>&nbsp;</div>
      <div align="left" class="errorMsg"><?=$msg?></div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
	  <table width="35%" border="0" align="left" cellpadding="0" cellspacing="0" class="tableList" style="float:center; background:#FFE7BC; border:solid 1px #FFA500; margin-top:5px;">
                <tr>
                  <th width="8%" colspan="3" style="background:#FFA500" >Send Non Working Income To User</th>
                </tr>
              
				  <tr>
                  <td width="205" align="right" style="padding:5px;">Non Working Income Amount : </td>
                  <td><input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />
                  </td>
                </tr>
				<td align="right"> Payment Date : </td>
                  <td><?=get_date_picker("payment_date", $payment_date)?></td>
                <tr>
                  <td width="205" align="right" style="padding:5px;"></td>
                  <td width="86" align="left" style="padding:5px;"> <input name="Submit_Recharge" type="image" id="Submit_Recharge" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_topup_ids[]')"/> <!--2020-02-26 temp comment--></td> 
                </tr>
              </table>
      </form>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
