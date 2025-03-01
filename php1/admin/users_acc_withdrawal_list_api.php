<?
require_once("../includes/surya.dream.php");
protect_admin_page2();



print "<br>start .............................";

/////////////token start/////////
///-------------------------------------------------------------
//////api_key generate ///////////
/*

$username = "M000062";
$password="uTWTAdmVUG";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.bizz91.com/api/account/login");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=M000062&password=uTWTAdmVUG");
// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
// http_build_query(array('postvar1' => 'value1')));
// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);

//print_r($server_output);
$character = json_decode($server_output);
print_r($character);
print $api_key= $character->response->api_key;
////api_key end ////

print "<br> End .....OK........................";

$api_key='79eda903d79eb6b87b22dd49e107a72c';
*/
///-------------------------------------------------------------
/*
//////// token generate ///////////

$username = "M000062";
$api_key="79eda903d79eb6b87b22dd49e107a72c";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.bizz91.com/api/token/generateAccessToken");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=M000062&api_key=79eda903d79eb6b87b22dd49e107a72c");
// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
// http_build_query(array('postvar1' => 'value1')));
// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);

//print_r($server_output);
$character = json_decode($server_output);
print_r($character);
print $token= $character->token;
////token end ////

Respons
[status] => 1
    [response_code] => s001
    [token] => e510d7f42064bfcf2730742abd3363e0
    [expiry] => 2020-05-17 16:56:54
)

///-------------------------------------------------------------
 */

 //// balance check ////
//////// token generate ///////////

/*
////////////ok report .////////////// 

$access_token = 'e510d7f42064bfcf2730742abd3363e0';
$header = ["Accept:application/json", "Authorization:Bearer ".$access_token];
$method = 'GET';
$url = 'https://www.bizz91.com/api/account/checkFunds';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);
echo $response;  //[JSON RESPONSE]

$pay_response = json_decode($response);
print_r($pay_response);

print $status= $pay_response->funds;
////balance end ////

*/


$sql_details = "select * from ngo_users where  u_id ='2'";
$result_details = db_query($sql_details);
$line_details= mysqli_fetch_array($result_details);
@extract($line_details);  
$imps_amount  = 100;
$api_request_id='11223344';
$parameters = array(
  'account_number' => $u_bank_acno
  ,'confirm_account_number' => $u_bank_acno
  ,'ifsc' => $u_bank_ifsc_code
  ,'amount' => round($imps_amount,0)
  ,'transfer_type' => 'imps'
  ,'bene_name' => $u_bank_acc_holder
  ,'api_request_id' => $api_request_id
);
// imps  neft   rtgs   upi

$access_token = 'e510d7f42064bfcf2730742abd3363e0';
$header = ["Accept:application/json", "Authorization:Bearer ".$access_token];
$method = 'POST';
$url = 'https://www.bizz91.com/api/payout/processPayout';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);
//echo $response;  //[JSON RESPONSE]

$pay_response = json_decode($response);
print_r($pay_response);

 $status= $pay_response->status;
 $response_code= $pay_response->response_code;
 $urn_id= $pay_response->urn_id;
 $utr= $pay_response->utr;
 $txnRefID= $pay_response->txnRefID;
 $utr= $pay_response->utr;

////token end ////
/*
{"status":true,"response_code":"s001","urn_id":"344368570","utr":"013718962250","txnRefID":"140","response":"Successfully transfered ₹100 to
Surya Bhan Yadav (09211000010159)"}stdClass Object ( [status] => 1 [response_code] => s001 [urn_id] => 344368570 [utr] => 013718962250 [txnRefID] => 140 [response] => Successfully transfered ₹100 to
Surya Bhan Yadav (09211000010159) )

*/


 ///// balance check end 

///{"status":true,"response_code":"s001","response":{"username":"M000062","last_login":"2020-05-16 16:30:16","api_key":"7182e7cf84eed93b72b5fdedd9c15c65","funds":459371.56599999999}}stdClass Object ( [status] => 1 [response_code] => s001 [response] => stdClass Object ( [username] => M000062 [last_login] => 2020-05-16 16:30:16 [api_key] => 7182e7cf84eed93b72b5fdedd9c15c65 [funds] => 459371.566 ) )
exit;

























if($pay_action=='IMPS' && $pay_id!='' && $u_userid!='' && $pay_status=='Unpaid' && $imps_amount>=1){
  

$sql_details = "select * from ngo_users where  u_id ='$u_userid'";
$result_details = db_query($sql_details);
$line_details= mysqli_fetch_array($result_details);
@extract($line_details);  


/////////////token start/////////
$username = "M000062";
$password="uTWTAdmVUG";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.bizz91.com/account/login");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=M000062&password=uTWTAdmVUG");
// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
// http_build_query(array('postvar1' => 'value1')));
// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);
$character = json_decode($server_output);
print_r($character);
print $access_token= $character->access_token;
////token end /////


///AUTHORISATION= BEARER
////payment start ////

//https://api.pay2all.in/v1/payout/transfer

//print "https://api.pay2all.in/v1/payout/transfer/?mobile_number=$u_mobile&amount=$withdraw_pay_amount&beneficiary_name=$u_bank_acc_holder&account_number=$u_bank_acno&ifsc=$u_bank_ifsc_code&channel_id=2&client_id=$pay_id&provider_id=143";

////$mobile_number = 8860181421;
//"mobile_number=$u_mobile&amount=$withdraw_pay_amount&beneficiary_name=$u_bank_acc_holder&account_number=$u_bank_acno&ifsc=$u_bank_ifsc_code&channel_id=2&client_id=$pay_id&provider_id=143");

$parameters = array(
    'mobile_number' => $u_mobile
    ,'amount' => round($imps_amount,0)
    ,'beneficiary_name' => $u_bank_acc_holder
    ,'account_number' => $u_bank_acno
    ,'ifsc' => $u_bank_ifsc_code
    ,'channel_id' => '2'
    ,'client_id' => $pay_id
    ,'provider_id' => '143'
);

 

$header = ["Accept:application/json", "Authorization:Bearer ".$access_token];
$method = 'POST';
$url = 'https://api.pay2all.in/v1/payout/transfer';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);
//echo $response;  //[JSON RESPONSE]

$pay_response = json_decode($response);
$status= $pay_response->status;
$status_id= $pay_response->status_id;
$utr= $pay_response->utr;
$orderid= $pay_response->orderid;
$report_id= $pay_response->report_id;


if ($status==0 || $status==1) {
  $pay_transaction_no = " Report ID : $report_id | UTR No : $utr ";
  $sql3 = "update ngo_users_payment set pay_transaction_no='$pay_transaction_no',pay_status='Paid' , pay_transfer_date=ADDDATE(now(),INTERVAL 570 MINUTE) where  pay_userid = '$u_userid' and  pay_id = '$pay_id'  "; 
  db_query($sql3);
  $arr_error_msgs[] ="Your Withdrawal has been processed successfully. ";
} else {
  $arr_error_msgs[] ="Your Withdrawal has been  accepted and process soon. ";
  $sql3 = "update ngo_users_payment set pay_transaction_no='Transaction Failed',pay_status='Unpaid' , pay_transfer_date=ADDDATE(now(),INTERVAL 570 MINUTE) where  pay_userid = '$u_userid' and  pay_id = '$pay_id'  "; 
  db_query($sql3);
}
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
header("Location: users_acc_withdrawal_list.php");
exit;

}



if(is_post_back()) {
#print_r($_POST);
	$arr_pay_ids = $_REQUEST['arr_pay_ids'];
	if(is_array($arr_pay_ids)) {
		$str_pay_ids = implode(',', $arr_pay_ids);
		if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			$sql_update="update ngo_users_payment set pay_status='Paid',pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE('$pay_transfer_date',INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);

 			$withdraw_pay_amount = db_scalar("select pay_amount from ngo_users_payment where pay_id  in ($str_pay_ids) limit 0,1");		
			$current_date = db_scalar(" select DATE_FORMAT(ADDDATE(CURDATE(),INTERVAL 750 MINUTE), '%Y-%c-%d') as dated");		
 			 //send sms to user 
 			$mobile =  db_scalar("select u_mobile  from ngo_users where u_id  in (select pay_userid from ngo_users_payment where pay_id  in ($str_pay_ids)) limit 0,1");
			$sms_username =  db_scalar("select CONCAT(u_fname,'(ID: ',u_username,')')  from ngo_users where u_id  in (select pay_userid from ngo_users_payment where pay_id  in ($str_pay_ids)) limit 0,1");
			
			//$message =  "Congratulation Dear  ".$sms_username.", Your bank withdrawal request for amount ".price_format($withdraw_pay_amount).".  paid successfully  ". SITE_NAME ;  
			//$msg = send_sms_text($mobile,$message);
	
			// send email 
$u_email = db_scalar("select u_email from ngo_users where u_id  in (select pay_userid from ngo_users_payment where pay_id  in ($str_pay_ids)) limit 0,1");
 
$message="
Hi ". $sms_username .", 
  
Your  Withdrawal request paid successfully.

Transaction No = ".$pay_transaction_no ."

Paid Amount = ". $withdraw_pay_amount ."

Paid Date = ". $current_date. "


Thank you !

". SITE_NAME ."
http://". SITE_URL ."
";
 
  			$HEADERS  = "MIME-Version: 1.0 \n";
			$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
			$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
			$SUBJECT  = SITE_NAME." Withdrawal processed confirmation ";
 			if ($u_email!='') { @mail($u_email, $SUBJECT, $message,$HEADERS); }
  			$_SESSION[POST]='';

//
			
			
 		
		} else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_users_payment set pay_status='Unpaid',pay_transaction_no='',pay_transfer_date='',pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
		} else if(isset($_REQUEST['Payout_Delete']) || isset($_REQUEST['Payout_Delete_x']) ){
		 			 
				$sql_test = "select *  from  ngo_users_payment where pay_plan='FUND_WITHDRAW' and pay_status='Unpaid' and pay_id in ($str_pay_ids)  ";
  				$result_test = db_query($sql_test);
 				while ($line_test= mysqli_fetch_array($result_test)){
   					//@extract($line_test);
					  	db_query("delete  FROM ngo_users_payment where pay_userid='$line_test[pay_userid]' and pay_plan='DEDUCTION'  and pay_refid='$line_test[pay_id]' ");
 	db_query("delete  FROM ngo_users_payment where pay_userid='$line_test[pay_userid]' and pay_plan='FUND_WITHDRAW'  and pay_id='$line_test[pay_id]' ");

 
 				} 
			   



		} else if(isset($_REQUEST['Payout_wallet']) || isset($_REQUEST['Payout_wallet_x']) ){
		 			 
				$sql_test = "select *  from  ngo_users_payment where pay_plan='FUND_WITHDRAW' and pay_status='Unpaid' and pay_id in ($str_pay_ids)  ";
  				$result_test = db_query($sql_test);
 				while ($line_test= mysqli_fetch_array($result_test)){
   					//@extract($line_test);
					$pay_for2 = $pay_group ." FUND WITHDRAW ".$line_test[pay_for];
				 $sql2 = "insert into ngo_users_ewallet set  pay_drcr='Cr',pay_group='PW',  pay_userid = '$line_test[pay_userid]',pay_refid = '$line_test[pay_id]' ,pay_topupid='0' ,pay_plan='FUND_WITHDRAW' ,pay_for = '$pay_for2' ,pay_ref_amt='$line_test[pay_amount]' ,pay_unit = 'F' ,pay_rate = '100', pay_amount = '$line_test[pay_amount]' ,pay_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE) ,pay_admin='$_SESSION[sess_admin_login_id]' ";
					$result = db_query($sql2);
 				} 
			$sql_update="update ngo_users_payment set pay_status='Paid',pay_transaction_no='BTC Wallet',pay_transfer_date=ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);  

 		} else if(isset($_REQUEST['Payout_Delete']) || isset($_REQUEST['Payout_Delete_x']) ){
		 			 
				/*$sql_test = "select *  from  ngo_users_payment where pay_plan='FUND_WITHDRAW' and pay_id in ($str_pay_ids)  ";
  				$result_test = db_query($sql_test);
 				while ($line_test= mysqli_fetch_array($result_test)){
 					// print " <br> == delete from ngo_users_payment where  pay_userid = '$line_test[pay_userid]' and pay_refid = '$line_test[pay_id]' and pay_plan='DEDUCTION'";
 					//db_query("delete from ngo_users_payment where  pay_userid = '$line_test[pay_userid]' and pay_refid = '$line_test[pay_id]' and pay_plan='DEDUCTION'");
					//db_query("delete from ngo_users_payment where  pay_userid = '$line_test[pay_userid]' and pay_refid = '$line_test[pay_id]' and pay_plan='FUND_TRANSFER'");
					//db_query("delete from ngo_users_ewallet where  pay_userid = '$line_test[pay_userid]' and pay_refid = '$line_test[pay_id]' and pay_plan='FUND_RECEIVE'");
  				}*/
				 db_query("delete from ngo_users_payment where  pay_id in ($str_pay_ids)");
	
		}else if(isset($_REQUEST['Payout_SMS']) || isset($_REQUEST['Payout_SMS_x']) ) {
			// sms code start
			 	#$sql_test = "select * from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
				/*$sql_test = "select u_username,u_fname,u_mobile, sum(pay_amount)as payment  from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
 				 
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
				
				}*/
 		} else if (isset($_REQUEST['Payment_SMS']) || isset($_REQUEST['Payment_SMS_x']) ) {
  			 // sms code start
			 	#$sql_test = "select * from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";
				/*
				$sql_test = "select u_username,u_fname,u_mobile, ROUND((sum(pay_amount)-((sum(pay_amount)/100)* 20)),2)  as payment  from  ngo_users_payment, ngo_users  where pay_userid=u_id and u_mobile!='' and pay_id in ($str_pay_ids)  group by pay_userid ";

			 
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
			 
				
				
 				}
 			 /// end 
			  */
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 
	}
}
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_username,u_fname,u_city,u_bitcoin,u_id,u_ref_userid,u_bank_micr_code,ngo_users_payment.*  ";
$sql = " from ngo_users,ngo_users_payment where  u_id=pay_userid and u_status!='Banned' and pay_plan='FUND_WITHDRAW'  ";
  
///if ($pay_plan!='') 		{$sql .= " and pay_plan='$pay_plan' ";} 
if ($pay_group!='') 		{$sql .= " and pay_group='$pay_group' ";} 
if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";} else { $sql .= " and pay_status!='Paid'";}

if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (pay_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  pay_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
if (($datefrom2!='') && ($dateto2!='')){ $sql .= " and pay_transfer_date between '$datefrom2' AND '$dateto2' "; }
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($pay_admin!='') 		{$sql .= " and pay_admin='$pay_admin' ";}
if ($pay_for!='') 			{$sql .= " and pay_for like '%$pay_for%' ";}
if ($pay_amount!='') 		{$sql .= " and pay_amount='$pay_amount' ";}

/// downline payout list of a user
if ($u_sponsor_id!=''){
$u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_sponsor_id'");
if ($u_userid!='') {
$id = array();
$id[]=$u_userid;
while ($sb!='stop'){
if ($referid=='') {$referid=$u_userid;}
$sql_test = "select u_id  from ngo_users  where  u_sponsor_id in ($referid)  ";
$result_test = db_query($sql_test);
$count = mysqli_num_rows($result_test);
	if ($count>0) {
		//print "<br> $count = ".$ctr++;
		$refid = array();
 		while ($line_test= mysqli_fetch_array($result_test)){
 			$id[]=$line_test[u_id];
			$refid[]=$line_test[u_id];
 		}
		 $referid = implode(",",$refid);
	} else {
		$sb='stop';
	}
 } 
 
$id_in = implode(",",$id);
if ($id_in!='') {$sql .= " and pay_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}
}
 

# $sql_export = $sql ." group by ngo_users.u_id, upay_for order by ngo_users.u_id asc"; 
# $sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$sql_export = $sql ." group by pay_userid, pay_plan,pay_for order by pay_userid asc "; 
$sql_export_total = $sql ." group by pay_userid  order by pay_userid asc"; 

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
  $sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
   $arr_columns =array('u_username'=>'Username','UCASE(u_city)'=>'City','u_mobile'=>'Mobile','UCASE(u_bank_name)'=>'Bank Name','UCASE(u_fname)'=>'Beneficiary Name' ,'CONCAT(": ",u_bank_acno)'=>'Account No' ,'UCASE(u_bank_branch)'=>' Branch' ,'UCASE(u_bank_ifsc_code)'=>'IFSC', 'pay_date'=>'Payment Date','UCASE(pay_for)'=>'Payout For' ,'sum(pay_amount)as totalamount'=>'Total Amount' );
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 
if ($export_total=='1') {
//,'((sum(topup_amount)/100)*5) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	//$arr_columns =array( 'u_username'=>'User ID','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile' ,'sum(pay_amount)as totalamount'=>'Total Amount'  );
	
		$arr_columns =array( 'u_username'=>'User ID','UCASE(u_fname)'=>'Beneficiary Name', 'sum(pay_amount)as totalamount'=>'Payment Amount'  ,'u_mobile'=>'Mobile','UCASE(u_bank_name)'=>'Bank' ,'UCASE(u_bank_ifsc_code)'=>'Bene IFSC Code' ,'CONCAT(": ",u_bank_acno)'=>'Bene Account Number' ,'UCASE(u_bank_branch)'=>' Branch Address'  ,'UCASE(u_city)'=>'City'  ,'pay_transfer_date'=>'Transfer Date' ,'pay_transaction_no'=>'Transaction No');
	export_delimited_file($sql_export_total, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
	 

}  
 
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
 <div align="right"><a href="users_acc_withdrawal_list.php?show=Yes">.</a></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td id="pageHead"><div id="txtPageHead"> Users payment details </div></td>
 </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td id="content">
  <p>
                <? include("../error_msg.inc.php");?>
              </p>
  <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
  <input type="hidden" value="<?=$show?>" name="show" id="show" / >
    <table width="750"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
     <tr align="center">
      <th colspan="6">Advance Search</th>
     </tr>
     <tr>
      <td  align="right" valign="top">Username </td>
      <td><input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
      <td align="right">Amount  : </td>
      <td><input name="pay_amount"style="width:120px;" type="text" value="<?=$pay_amount?>" />
      </td>
      <td width="67" align="right"><span class="tdData"> Group</span>:</td>
      <td width="190"><span class="txtTotal">
       <?=payment_group_dropdown($pay_group,$extra)?>
       </span></td>
     </tr>
     <tr>
      <td width="118" align="right" class="tdLabel">Auto ID  From: </td>
      <td width="131"><input name="user_id_from" type="text"style="width:120px;" value="<?=$user_id_from?>" />
      </td>
      <td width="90" align="right">Auto ID  To:</td>
      <td width="128"><input name="user_id_to" style="width:120px;"type="text" value="<?=$user_id_to?>" />
      </td>
      <td align="right">Status :</td>
      <td><?=payment_status_dropdown('pay_status',$pay_status)?></td>
     </tr>
     <tr>
      <td align="right"> Payment Date from: </td>
      <td><?=get_date_picker("datefrom", $datefrom)?></td>
      <td  align="right" valign="top"> Payment Date To: </td>
      <td><?=get_date_picker("dateto", $dateto)?></td>
      <td  align="right" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
     </tr>
     <tr>
      <td align="right">Downline - Username </td>
      <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
      <td  align="right" valign="top">Naration :</td>
      <td><input name="pay_for"style="width:120px;" type="text" value="<?=$pay_for?>" /></td>
      <td align="right" valign="middle"><input name="export" type="checkbox" id="export" value="1" /></td>
      <td valign="middle">Export Individual Payout </td>
     </tr>
     <tr>
      <td  align="right" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td  align="right" valign="top">&nbsp;</td>
      <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
       <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
      <td align="right" valign="middle"><input name="export_total" type="checkbox" id="export_total" value="1" /></td>
      <td valign="middle">Export Total Payout </td>
     </tr>
    </table>
   </form>
   <div align="right"><!--<a href="users_payment_create.php">Create Payment</a>-->
    <?php /* ?>| <a href="users_payment_withdrawal.php">Auto Withdrawal </a> | <a href="users_acc_drcr_f.php">Transfer Fund</a><?php */?>
   </div>
   <? if(mysqli_num_rows($result)==0){?>
   <div class="msg">Sorry, no records found.</div>
   <? } else{ 
 	  ?>
   <div align="right"> Showing Records:
    <?= $start+1?>
    to
    <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?>
    of
    <?= $reccnt?>
   </div>
   <div>Records Per Page:
    <?=pagesize_dropdown('pagesize', $pagesize);?>
   </div>
   <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
    <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
     <tr>
      <th width="2%" >ID</th>
      <th width="5%" >Username</th>
      <th width="10%" >Name  </th>
 	  <th width="10%" >BTC Wallet  </th>
       <th width="4%" >Pay ID </th>
      <th width="15%" >Naration</th>
	  <? if ($show=='Yes') { ?><th width="5%" >Naration</th> <? } ?>
       <th width="4%" >Group</th>
      <th width="7%" >Amount </th>
	   <th width="6%" >Payment Date </th>
      <th width="15%" >Paid  Txn No</th>
       <th width="3%" >Paid Date</th>
      <th width="4%">Status</th>
      <th width="4%">Re-Pay</th>
      <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
     </tr>
     <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	//$cheque_other_count = db_scalar("select count(*) from ngo_users where u_cheque_other =$u_id");
	//if ($u_cheque=='self') { $u_cheque_to='self+'.$cheque_other_count;} else {$u_cheque_to=$u_cheque_other;}
	/*if ($pay_plan=='FUND_WITHDRAW') {
		$withdrawal_paid = db_scalar("select count(*) from ngo_users_payment where pay_userid =$u_id and pay_plan='FUND_WITHDRAW' and pay_status='Paid'")+0;
		$withdrawal_unpaid = db_scalar("select count(*) from ngo_users_payment where pay_userid =$u_id and pay_plan='FUND_WITHDRAW' and pay_status='Unpaid'")+0;
		
		$withdrawal_count= '<span class="errorMsg">(P:'.$withdrawal_paid.' U:'.$withdrawal_unpaid.')<span>';
		
	 } else {
	 $withdrawal_count= '';
	 }*/
	 
	 if ($u_bank_micr_code!=$pay_id_refno) { $css ='td_red';} 
 ?>
     <tr class="<?=$css?>">
      <td nowrap="nowrap"><?=$u_id?></td>
      <td nowrap="nowrap"><a href="users_list.php?act=login&username=<?=$u_username?>" target="_blank"></a><?=$u_username?></td>
      <td nowrap="nowrap"><?=$u_fname?></td>
	  <td nowrap="nowrap"><?=$u_bitcoin?></td>
      <td nowrap="nowrap"><?=$pay_id?></td>
      <td><?=$pay_for?></td>
	<? if ($show=='Yes') { ?> <td><?=$pay_id_refno?></td> <? } ?>
      <td nowrap="nowrap" ><?=$pay_group?></td>
      <td nowrap="nowrap"><?=$pay_amount?></td>
      <td nowrap="nowrap"><?=date_format2($pay_date)?></td>
      <td align="center"><?=$pay_transaction_no?> </td>
      <td nowrap="nowrap"><?=date_format2($pay_transfer_date)?></td>
      <td align="center"> <?=$pay_status?> </td>
      <td nowrap="nowrap"><a href="users_acc_withdrawal_list.php?pay_action=IMPS&pay_id=<?=$pay_id?>&imps_amount=<?=round($pay_amount,0)?>&u_userid=<?=$u_id?>&pay_status=Unpaid">Paynow </td>
      <td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$pay_id?>"/></td>
     </tr>
      
     <? }
?>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <!-- <td width="19%" align="right" style="padding:2px"><input name="Payment_SMS" type="image" id="Payment_SMS" src="images/buttons/payment_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/></td>
                  <td width="9%" align="right" style="padding:2px"><input name="Payout_SMS" type="image" id="Payout_SMS" src="images/buttons/payout_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/>                  </td>-->
				  
				  <td width="9%" align="right" style="padding:2px">  <!--<input name="Payout_Delete" type="image" id="Payout_Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_pay_ids[]')"/> -->   <input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>        </td>
      <td width="22%" align="right" style="padding:2px"> Transfer date:
       <?=get_date_picker("pay_transfer_date", date("Y-m-d"))?></td>
      <td width="34%" align="right" style="padding:2px"> Transaction No/:
       <input name="pay_transaction_no" type="text" size="50"  />
      </td>
      <td width="8%" align="right" style="padding:2px"><input name="Payment_Paid" type="image" id="Payment_Paid" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>
      </td><!--
      <td width="8%" align="right" style="padding:2px">Paid to BTC Wallet
       <input name="Payout_wallet" type="image" id="Payout_wallet" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>
      </td>
      <td width="8%" align="right" style="padding:2px"><input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>
      </td>-->
     </tr>
    </table>
   </form>
   <? }?>
   <? include("paging.inc.php");?>
  </td>
 </tr>
</table>
<? include("bottom.inc.php");?>
