<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 
if(is_post_back()) {
$data=array();
/*if($level==1){ 	
	$sql_test = "select u_id,  ,u_ref_userid, member_on_level_1, member_on_level_2, member_on_level_3, member_on_level_4, member_on_level_5, member_on_level_6, member_on_level_7, member_on_level_8 ,topup_id,  topup_plan,topup_group, topup_rate,topup_amount , topup_datetime ,topup_date ,topup_status ";
$sql = " from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id  and topup_amount='15.00' and u_status='Active'  ";
} else if($level==2){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_1) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='15' group by u_ref_userid having sum(member_on_level_1)>=16";
} else if($level==3){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_2) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='15' group by u_ref_userid having sum(member_on_level_2)>=64";
} else if($level==4){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_3) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='15' group by u_ref_userid having sum(member_on_level_3)>=256";
} else if($level==5){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_4) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='15' group by u_ref_userid having sum(member_on_level_4)>=1024";
} else if($level==6){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_5) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='15' group by u_ref_userid having sum(member_on_level_5)>=4096";
} else if($level==7){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_6) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='15' group by u_ref_userid having sum(member_on_level_6)>=16384";
}
	*/	
	 
	//$sql_test = "select u_id,u_username,topup_id,topup_userid,topup_amount,topup_status,topup_date from  ngo_users,ngo_users_recharge  where topup_userid=u_id  and topup_id in ($str_topup_ids)   ";
$sql_test = "select u_id  ,u_ref_userid, member_on_level_1, member_on_level_2, member_on_level_3, member_on_level_4, member_on_level_5, member_on_level_6, member_on_level_7, member_on_level_8 ,topup_id,  topup_userid, topup_plan,topup_group, topup_rate,topup_amount , topup_datetime ,topup_date ,topup_status  from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id  and topup_amount='15.00' and u_status='Active' ";
	
if ($level==1)	{$sql_test .= " and member_on_level_1>=4";  }
if ($level==2) 	{$sql_test .= " and member_on_level_2 >=16"; }
if ($level==3) 	{$sql_test .= " and member_on_level_3 >=64"; }
if ($level==4) 	{$sql_test .= " and member_on_level_4>=256"; }
if ($level==5) 	{$sql_test .= " and member_on_level_5>=1024 "; }
if ($level==6) 	{$sql_test .= " and member_on_level_6>=4096 "; }
if ($level==7) 	{$sql_test .= " and member_on_level_7>=16384 "; }
if ($level==8) 	{$sql_test .= " and member_on_level_8>=32768 "; }


	$result_test = db_query($sql_test);
 	while ($line_test= mysqli_fetch_array($result_test)){
	@extract($line_test);
	if ($u_id!='' && $topup_amount>0 ) { 
	//and pay_plan_level='$pay_plan_level'
    $payout_count_all = db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$topup_userid'  and pay_plan='$pay_group' and pay_group='$pay_group'")+0;
 	if($payout_count_all<4) {
 	$topup_amount_active_count = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' and topup_amount='15' ")+0;	
  		if ($pay_amount>0 && $topup_amount_active_count>0) {
		$payout_count = db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$topup_userid' and pay_plan_level='$pay_plan_level' and pay_plan='$pay_group' and pay_group='$pay_group' and pay_date='$payment_date'  ")+0;
		 if ($payout_count==0) {
   					$pay_for =   $ARR_CLUB_GROUP[$pay_group];
					$sql22 = "insert into ngo_users_payment set   pay_drcr='Cr',  pay_userid = '$topup_userid'  ,pay_group='$pay_group',pay_plan='$pay_group',pay_plan_level='$pay_plan_level' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = 'F' ,pay_rate = '100', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date='$payment_date' ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE) ";
					$result = db_query($sql22);
					echo  "<br> $pay_group Club Income of level $pay_plan_level, Sent To, Auto Id : $topup_userid , Username : $u_username";
					$_SESSION['arr_error_msgs'] = $arr_error_msgs;
				  }
				 }
				}	
 			}	
  		}
	}
 

//if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "Rs. " .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Send Club Income </div></td>
  </tr>
</table>
 <form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
  <table width="35%" border="0" align="left" cellpadding="0" cellspacing="0" class="tableList" style="float:left; background:#FFE7BC; border:solid 1px #FFA500; margin-top:5px;">
                <tr>
                  <th width="8%" colspan="3" style="background:#FFA500" >Send Club Achieved Fund To User</th>
                </tr>
              
                <tr>
                  <td width="205" align="right" style="padding:5px;"> 
                    Club Income Type : </td>
                  <td><?=array_dropdown($ARR_CLUB_GROUP, '$pay_group', 'pay_group');?> </td>
                </tr>
                <tr>
                  <td width="205" align="right" style="padding:5px;">Payment For Level : </td>
                  <td><?=array_dropdown($ARR_CLUB_LEVEL, $level, 'level');?>  </td>
                </tr>
				  <tr>
                  <td width="205" align="right" style="padding:5px;">Send Club Achieved Amount : </td>
                  <td><input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />
                  </td>
                </tr>
				<td align="right"> Payment Date : </td>
                  <td><?=get_date_picker("payment_date", $payment_date)?></td>
                <tr>
                  <td width="205" align="right" style="padding:5px;"></td>
                  <td width="86" align="left" style="padding:5px;"> <input name="Submit_Recharge" type="image" id="Submit_Recharge" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_topup_ids[]')"/>  </td> 
                </tr>
              </table>
  <br />
  <br />
  </form>
<? include("bottom.inc.php");?>