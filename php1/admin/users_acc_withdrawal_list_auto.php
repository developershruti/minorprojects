<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) { 
#print_r($_POST);
	$arr_pay_ids = $_REQUEST['arr_pay_ids'];
	if(is_array($arr_pay_ids)) {
	
	/*
 if ($_SESSION['sess_admin_type']=='general' &&  $_SESSION['sess_admin_type_acc']=='Read') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: admin_desktop.php?acc=".$_SESSION['sess_admin_type_acc']);
	 exit;
}*/


		$str_pay_ids = implode(',', $arr_pay_ids);
		if(isset($_REQUEST['Payment_Paid_Coinpayment']) || isset($_REQUEST['Payment_Paid_Coinpayment_x']) ){
		
 		/*	$pay_transaction_no='Txn Hash : '.$transaction_remark;
			$sql_update="update ngo_users_payment set pay_status='Paid', pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE('$pay_transfer_date',INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);*/

////coinpayment start /////
//and pay_status='Unpaid'





		$sql_test = "select *  from  ngo_users_payment where  pay_id in ($str_pay_ids)  ";
		$result_test = db_query($sql_test);
		while ($line_test= mysqli_fetch_array($result_test)){
			@extract($line_test);		
		
		$user_bnb_address = db_scalar("select  u_bsc_wallet_address from ngo_users where u_id = '$pay_userid'  and u_status='Active'");
		
 		$Public_Key='6febcd0567b14358c023e3fec4a91c5467939e49916ea0baca91f25527ffafd4';
		$Private_Key='8aC5fb8D8b142164fabDca88f37a9820C820Cf349dc1b311f3Fa5D2ffc5da7F3';
		
		$Coin_code = 'USDT.TRC20';
		$withdraw_amount = $pay_amount;
		if($user_bnb_address!='' && $withdraw_amount>0){
		require('../coinpayments/coinpayments.inc.php');
		$cps = new CoinPaymentsAPI();
		$cps->Setup($Private_Key, $Public_Key);
		#####$result = $cps->CreateWithdrawal($withdraw_amount, $Coin_code, $user_bnb_address);
		#$result = $cps->CreateWithdrawal(0.1, 'BTC', 'bitcoin_address');
		/*print "<pre>";
		print_r($result);
		print "</pre>";*/
		
		
		if ($result['error'] == 'ok') {
			#print 'Withdrawal created with ID: '.$result['result']['id'];
			$pay_transaction_no = $result['result']['id'];
			$sql_update="update ngo_users_payment set pay_status='Paid',  pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id='$pay_id'";
			db_query($sql_update);
		} else {
			//print 'Error: '.$result['error']."\n";
			$pay_transaction_no = $result['error'];
			$sql_update="update ngo_users_payment set pay_status='Unpaid',  pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id='$pay_id'";
			db_query($sql_update);
		}
		}
		
		
}  
//////end ///


 			$withdraw_pay_amount = db_scalar("select pay_amount from ngo_users_payment where pay_id  in ($str_pay_ids) limit 0,1");		
			$current_date = db_scalar(" select DATE_FORMAT(ADDDATE(CURDATE(),INTERVAL 750 MINUTE), '%Y-%c-%d') as dated");		
 			 //send sms to user 
 			#$mobile =  db_scalar("select u_mobile  from ngo_users where u_id  in (select pay_userid from ngo_users_payment where pay_id  in ($str_pay_ids)) limit 0,1");
			#$sms_username =  db_scalar("select CONCAT(u_fname,'(ID: ',u_username,')')  from ngo_users where u_id  in (select pay_userid from ngo_users_payment where pay_id  in ($str_pay_ids)) limit 0,1");
			
			//$message =  "Congratulation Dear  ".$sms_username.", Your bank withdrawal request for amount ".price_format($withdraw_pay_amount).".  paid successfully  ". SITE_NAME ;  
			//$msg = send_sms_text($mobile,$message);
	
			// send email 
$u_email = db_scalar("select u_email from ngo_users where u_id  in (select pay_userid from ngo_users_payment where pay_id  in ($str_pay_ids)) limit 0,1");
 
$message="
Hi ". $sms_username .", 
  
Your  Withdrawal request paid successfully.

Transaction No = ".$transaction_remark ."

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
  			$_SESSION['POST']='';

//
			
		
		
		} else if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			$sql_update="update ngo_users_payment set pay_status='Paid',pay_transaction_no='$transaction_remark',pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
			
 		
		} else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_users_payment set pay_status='Unpaid',pay_transaction_no='$transaction_remark',pay_transfer_date=NULL,pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
			db_query($sql_update);
		
		} else if(isset($_REQUEST['Token_update']) || isset($_REQUEST['Token_update_x']) ){
		  $sql_test = "select *  from  ngo_users_payment where  pay_id in ($str_pay_ids)  ";
		$result_test = db_query($sql_test);
		while ($line_test= mysqli_fetch_array($result_test)){
			 @extract($line_test);
				//$pay_ref_amt2 = $pay_amount;
			$coin_rate = $coin_rate+0;
			$coin_bonus = $coin_bonus+0;
			$coin_total = ($pay_amount /$coin_rate)+0;
			$total_coin_bonus = $coin_total +(($coin_total /100)*$coin_bonus)+0;
			
 			 $sql_update="update ngo_users_payment set   pay_unit='$coin_rate' , pay_plan_level='$coin_bonus' ,pay_ref_amt1='$total_coin_bonus'   ,pay_admin='$_SESSION[sess_admin_login_id]' where pay_id='$pay_id'";
			db_query($sql_update);
					
		}
		
		} else if(isset($_REQUEST['Payout_Refund']) || isset($_REQUEST['Payout_Refund_x']) ){
		 			 
				$sql_test = "select *  from  ngo_users_payment where pay_plan='FUND_WITHDRAW' and pay_status='Unpaid' and pay_id in ($str_pay_ids)  ";
  				$result_test = db_query($sql_test);
 				while ($line_test= mysqli_fetch_array($result_test)){
   					 @extract($line_test);
						$pay_for1 = "Withdrawal request refunded ".price_format($pay_ref_amt).' ,Refund Due to '. $transaction_remark;
						$sql2 = "insert into ngo_users_payment set  pay_drcr='Cr',pay_group='$pay_group',  pay_userid = '$pay_userid'  ,pay_plan='FUND_REFUND'  ,pay_for = '$pay_for1' ,pay_ref_amt='$pay_ref_amt' ,pay_rate = '100', pay_amount = '$pay_ref_amt',pay_status='Refunded' ,pay_date=ADDDATE(now(),INTERVAL 630 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 630 MINUTE) ";
						
						db_query($sql2);
						$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
						$pay_transaction_no = 'Refund Due to '.$transaction_remark .' ,Refno:'. $pay_refid;
						$sql_update="update ngo_users_payment set pay_status='Refunded',pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE(now(),INTERVAL 630 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id='$pay_id'";
						db_query($sql_update);  


						
  				} 
				
		} else if(isset($_REQUEST['Payout_Binance']) || isset($_REQUEST['Payout_Binance_x']) ){
		 		////////connect with binance 
				
				
require 'vendor/autoload.php';

/*$sql_bin = "select  u_binance_api_key , u_binance_secret from ngo_users  where u_binance_api_key!='' and u_binance_secret!='' and u_id='1001' ";  
$result_bin = db_query($sql_bin);
$line_bin = mysqli_fetch_array($result_bin) ;
@extract($line_bin);

$api_key 	=$line_bin['u_binance_api_key'];
$api_secret =$line_bin['u_binance_secret'];

*/
$api_key    = "uwFpsncyUhxXrA7seuSNreqb4u5ivtXOLerJtYqJhxBBXu0M87ddiJR2hXHweBFe";
$api_secret = "Hh5P5eBKQ8DUPNm1bBv4bZPPV18RQeMZKaOro73sXNCUQM4nFZbsudR8ipvVzUGR";

	
	$api = new Binance\API($api_key, $api_secret);
	$api->useServerTime(); 
	///check base currency balance 
	$balances = $api->balances();
	//print "<br> Binance Balance : ". $binance_coin_balance =  $balances['USDT']['available']+0;
	
	//$withdrawHistory = $api->withdrawHistory();
/*
//Binance Balance : 57865.3645664
print " <br>==> $asset | $u_bsc_wallet_address | $pay_amount "; 
$asset='BUSD';
$address='0x8ed2b802632d4e8d12910cd49a616a7c82b54082';
$amount=486;
//print 	$response = $api->withdraw($asset, $address, $amount);
$response = $api->withdraw($asset, $address, $amount, $addressTag = null, $addressName = "", $transactionFeeFlag = false, $network = "BSC", $orderId = null);
 print "<pre>";
 print_r($response);
print "</pre>";

 */
 
 				//print "<br>".
				$sql_test = "select * from ngo_users,ngo_users_payment where  u_id=pay_userid and u_status!='Banned' and u_bitcoin!='' and pay_plan='BANK_WITHDRAW' and pay_status='Unpaid' and pay_id in ($str_pay_ids)   ";
  				$result_test = db_query($sql_test);
 				while ($line_test= mysqli_fetch_array($result_test)){
   					@extract($line_test);
					$asset = "BUSD";
					$address = $u_bitcoin; //"1C5gqLRs96Xq4V2ZZAR1347yUCpHie7sa";
					$amount = round($pay_amount/92.5,0); //0.2;
					
					//print " <br>==> $asset | $u_bsc_wallet_address | $pay_amount "; 
 					$response = $api->withdraw($asset, $address, $amount, $addressTag = null, $addressName = "", $transactionFeeFlag = false, $network = "BSC", $orderId = null);
					$pay_transaction_no = $response['id'];
					//print_r($response);
					$pay_transaction_no = 'Paid Via BUSD ,Refno:'. $pay_transaction_no;
					//print "<br>". 	
					$sql_update="update ngo_users_payment set pay_status='Paid',pay_transaction_no='$pay_transaction_no',pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id='$pay_id'";
					 	db_query($sql_update);  


						
  				} 
				 header("Location: ".$_SERVER['HTTP_REFERER']);
				 exit;
			   


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
			$sql_update="update ngo_users_payment set pay_status='Paid',pay_transaction_no='$transaction_remark',pay_transfer_date=ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' where pay_id in ($str_pay_ids)";
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

 


$columns = "select u_username ,u_fname ,u_city ,u_bitcoin   ,u_bank_name ,u_bank_acno ,u_bank_branch ,u_bank_ifsc_code ,u_id ,u_ref_userid ,u_bank_micr_code  ,ngo_users_payment.*  ";
$sql = " from ngo_users,ngo_users_payment where  u_id=pay_userid and u_status!='Banned' and pay_plan='BANK_WITHDRAW' ";
  
///if ($pay_plan!='') 		{$sql .= " and pay_plan='$pay_plan' ";} 
if ($pay_group!='') 		{$sql .= " and pay_group='$pay_group' ";} 
if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";} else {$sql .= " and pay_status='Unpaid' ";} 

if (($user_id_from!='') && ($user_id_to!='')) {$sql .= " and (pay_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to=='')) {$sql .= " and  pay_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
if (($datefrom2!='') && ($dateto2!='')){ $sql .= " and pay_transfer_date between '$datefrom2' AND '$dateto2' "; }
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($pay_admin!='') 		{$sql .= " and pay_admin='$pay_admin' ";}
if ($pay_for!='') 			{$sql .= " and pay_for like '%$pay_for%' ";}
if ($pay_amount!='') 		{$sql .= " and pay_amount='$pay_amount' ";}
if ($pay_withdraw_proccessor!='') 		{$sql .= " and pay_withdraw_proccessor='$pay_withdraw_proccessor' ";}
if ($u_bsc_wallet_address!='') 		{$sql .= " and u_bsc_wallet_address='$u_bsc_wallet_address' ";}


 if($topup_code!='') {
 		$sql .= " and pay_userid in (select topup_userid from ngo_users_recharge where topup_code='$topup_code') ";
	 
}


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
 			$id[]=$line_test['u_id'];
			$refid[]=$line_test['u_id'];
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
$sql_export_total = $sql ." group by u_bank_acno  order by pay_userid asc"; 

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
  $sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
 //  $arr_columns =array('u_username'=>'Username','UCASE(u_city)'=>'City','u_mobile'=>'Mobile','UCASE(u_bank_name)'=>'Bank Name','UCASE(u_fname)'=>'Beneficiary Name' ,'CONCAT(": ",u_bank_acno)'=>'Account No' ,'UCASE(u_bank_branch)'=>' Branch','UCASE(u_bank_ifsc_code)'=>'IFSC','u_bitcoin'=>'BTC Wallet','u_gpay'=>'Google Pay','u_ppay'=>'PhonePay','u_product'=>'Paytm'  , 'pay_date'=>'Payment Date','UCASE(pay_for)'=>'Payout For' ,'sum(pay_amount)as totalamount'=>'Total Amount' );
 
		
   $arr_columns =array('u_username'=>'Username','u_bsc_wallet_address'=>'Address','pay_withdraw_proccessor'=>'Coin','pay_amount'=>'Total Amount','pay_ref_amt1'=>'Total Token'  );
   
   
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 
if ($export_total=='1') {
//,'((sum(topup_amount)/100)*54) as BDF'=>'BDF','((sum(topup_amount)/100)*2) as CWF'=>'CWF'
	//$arr_columns =array( 'u_username'=>'User ID','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile' ,'sum(pay_amount)as totalamount'=>'Total Amount'  );
	
		$arr_columns =array( 'u_username'=>'User ID','u_bsc_wallet_address'=>'Address','pay_withdraw_proccessor'=>'Coin', 'sum(pay_amount)as totalamount'=>'Payment Amount' ,'sum(pay_ref_amt1)'=>'Total Token'  );
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
  <td id="pageHead"><div id="txtPageHead">   Withdrawals</div></td>
 </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td id="content">
 
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
      <td><input name="pay_amount"style="width:120px;" type="text" value="<?=$pay_amount?>" />      </td>
      <td width="67" align="right"><span class="tdData"> Group</span>:</td>
      <td width="190"><span class="txtTotal">
	  <select name="pay_withdraw_proccessor" id="pay_withdraw_proccessor" class="form-control select" style="width:100%;  " alt="select" emsg="Select Withdraw Request Type">

                      <option value=""><!--Select Withdraw -->Request Type</option>
                      
                  <option <? if($pay_withdraw_proccessor=='BUSD'){ ?> selected="selected" <? }  ?> value="BUSD">BUSD</option>
                    
                  <!-- 
				  <option <? if($pay_withdraw_proccessor=='BNB'){ ?> selected="selected" <? }  ?> value="BNB">BNB(BSC)</option>
 				  <option <? if($pay_withdraw_proccessor=='Trust Wallet'){ ?> selected="selected" <? }  ?> value="Trust Wallet">Trust Wallet</option>
                  <option <? if($pay_withdraw_proccessor=='Meta Mask'){ ?> selected="selected" <? }  ?> value="Meta Mask">Meta Mask</option>
                  <option <? if($pay_withdraw_proccessor=='Binance Chain Wallet'){ ?> selected="selected" <? }  ?> value="Binance Chain Wallet">Binance Chain Wallet</option>
                  <option <? if($pay_withdraw_proccessor=='Token Pocket'){ ?> selected="selected" <? }  ?> value="Token Pocket">Token Pocket</option>
                  <option value="BANK" <?   if ($pay_withdraw_proccessor == 'BANK')  { ?> selected="selected" <? } ?> >Bank Wire (Deduction : 10%)</option>
                  <option value="BTC" <?   if ($pay_withdraw_proccessor == 'BTC')  { ?> selected="selected" <? } ?>>Bitcoin (Deduction : 20%)</option>
-->
                    </select>
       <? //=payment_group_dropdown($pay_group,$extra)?>
       </span></td>
     </tr>
     <tr>
      <td width="118" align="right" class="tdLabel">Auto ID  From: </td>
      <td width="131"><input name="user_id_from" type="text"style="width:120px;" value="<?=$user_id_from?>" />      </td>
      <td width="90" align="right">Auto ID  To:</td>
      <td width="128"><input name="user_id_to" style="width:120px;"type="text" value="<?=$user_id_to?>" />      </td>
      <td align="right">Status :</td>
      <td><?=payment_status_dropdown('pay_status',$pay_status)?></td>
     </tr>
     <tr>
      <td align="right"> Payment Date from: </td>
      <td><?=get_date_picker("datefrom", $datefrom)?></td>
      <td  align="right" valign="top"> Payment Date To: </td>
      <td><?=get_date_picker("dateto", $dateto)?></td>
        <td width="233" align="right">&nbsp;</td>
                  <td>&nbsp;</td>
     </tr>
     <tr>
      <td align="right">Downline - Username </td>
      <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
      <td  align="right" valign="top">Naration :</td>
      <td><input name="pay_for"style="width:120px;" type="text" value="<?=$pay_for?>" /></td>
      <td align="right" valign="middle"><input name="export" type="checkbox" id="export" value="1" /></td>
      <td valign="middle">Export Withdrawals </td>
     </tr>
     <tr>
      <td  align="right" valign="top">Wallet Address</td>
      <td><input name="u_bitcoin"style="width:120px;" type="text" value="<?=$u_bitcoin?>" /></td>
      <td  align="right" valign="top">&nbsp;</td>
      <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
       <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
      <td align="right" valign="middle"><input name="export_total" type="checkbox" id="export_total" value="1" /></td>
      <td valign="middle">Export Total  Withdrawals </td>
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
      <th width="5%" >Name  </th>
 	<!--  <th width="10%" >Bank Name  </th>
		<th width="10%" >Account Number  </th>
		<th width="10%" >Branch   </th>-->
		<th width="5%" >Wallet Type  </th>
 	  <th width="5%" >  Wallet Address </th>
	  <!--<th width="10%" >Google Pay  </th>
		 <th width="10%" >PhonePe  </th>
		  <th width="10%" >PayTm  </th> 
		  <th width="4%" >Pay Unit </th>-->
       <th width="4%" >Pay ID </th>
      <th width="10%" >Naration</th>
	  <? if ($show=='Yes') { ?><th width="5%" >Naration</th> <? } ?>
       <th width="4%" >  Balance</th>
      <th width="7%" >Amount INR </th>
	  <th width="7%" >Amount BUSD</th>
	   <th width="6%" >Payment Date </th>
      <th width="15%" >Paid  Txn No</th>
       <th width="3%" >Paid Date</th>
      <th width="4%">Status</th>
      <th width="4%">By</th>
      <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
     </tr>
     <?
	 
	 $gears_rate = db_scalar("select sett_value from ngo_setting where sett_code='COIN_RATE' limit 1 ");
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
	 $page_total_amount += $pay_amount;
	 
	 if($page_total_amount>=5000){ $page_total_amount = $page_total_amount+245;}
	 $income_bal = round(db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$u_id'"),2);
	 
	 if ($u_bank_micr_code!=$pay_id_refno) { $css ='td_red';} 	
 ?>
     <tr class="<?=$css?>">
      <td nowrap="nowrap"  <? if ($u_pdc=='yes'){ ?> style="background-color:#000000; color:#FFFFFF;" <? } ?>><?=$u_id?></td>
      <td nowrap="nowrap"><a href="users_list.php?act=login&username=<?=$u_username?>" target="_blank"></a><?=$u_username?></td>
      <td nowrap="nowrap"><?=$u_fname?></td>
	 <!-- <td nowrap="nowrap"><?=$u_bank_name?></td>
	  <td nowrap="nowrap"><?=$u_bank_acno?></td>
	  <td nowrap="nowrap"><?=$u_bank_branch?></td>-->
	  <td nowrap="nowrap"><?=$pay_withdraw_proccessor?></td>
	  <td nowrap="nowrap"><?=$u_bitcoin?></td>
	  
	 <!--  <td width="10%" ><?=$u_gpay?>    </td>
		 <td width="10%" ><?=$u_ppay?> </td>
		  <td width="10%" ><?=$u_product?>  </td> 
		 <td nowrap="nowrap"><?=$pay_unit?></td> -->
      <td nowrap="nowrap"><?=$pay_id?></td>
      <td><?=$pay_for?></td>
       <td nowrap="nowrap" ><?=$income_bal?></td>
      <td nowrap="nowrap"><?=$pay_amount?></td>
	    <td nowrap="nowrap"><?=round($pay_amount/92.5,0)?></td>
	   <!-- <td nowrap="nowrap"><? if($gears_rate>0) { echo $pay_amount/$gears_rate;}?></td>-->
      <td nowrap="nowrap"><?=datetime_format($pay_datetime)?></td>
      <td align="center"><?=$pay_transaction_no?> </td>
      <td nowrap="nowrap"><?=date_format2($pay_transfer_date)?></td>
      <td align="center"> <?=$pay_status?> </td>
      <td nowrap="nowrap"><?=$pay_admin?> </td>
      <td align="center"><input name="arr_pay_ids[]" type="checkbox" id="arr_pay_ids[]" value="<?=$pay_id?>"/></td>
     </tr>
     
     <? }
?>
   
   <tr class="<?=$css?>">
       <td nowrap="nowrap"  >&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
      
       <td nowrap="nowrap" >&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
       <td nowrap="nowrap">&nbsp;<?=$page_total_amount?></td>
       <td nowrap="nowrap"><?=round($page_total_amount/92.5,0)?></td>
	    <td>&nbsp;</td>
       <td align="center">&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
       <td align="center">&nbsp;</td>
       <td nowrap="nowrap">&nbsp;</td>
       <td align="center">&nbsp;</td>
     </tr> </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <!-- <td width="19%" align="right" style="padding:2px"><input name="Payment_SMS" type="image" id="Payment_SMS" src="images/buttons/payment_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/></td>
                  <td width="9%" align="right" style="padding:2px"><input name="Payout_SMS" type="image" id="Payout_SMS" src="images/buttons/payout_sms.gif" onclick="return sendsmsConfirmFromUser('arr_pay_ids[]')"/>                  </td>-->
				  
				  <td width="9%" align="right" style="padding:2px">  <!--<input name="Payout_Delete" type="image" id="Payout_Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_pay_ids[]')"/> -->        </td>
      <td width="22%" align="right" style="padding:2px"> Transfer date:
       <?=get_date_picker("pay_transfer_date", date("Y-m-d"))?></td>
      <td width="34%" align="right" style="padding:2px"> Transaction No/ Remark (if any):
       <input name="transaction_remark" type="text" size="50" value="" />
      </td>
	  
      <td width="20%" align="right" style="padding:2px">
	 
	  <input name="Payment_Paid" type="image" id="Payment_Paid" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/> &nbsp;
	   </td>
      <td width="20%" align="right" style="padding:2px">
	  <input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>&nbsp; 
	   </td>
       <!--  <td width="20%" align="right" style="padding:2px"><input name="Payout_Refund" type="submit" id="Payout_Refund"  value="Payout Refund"  onclick="return submitConfirmFromUser('arr_pay_ids[]')"/> 
	   </td>
   <td width="20%" align="right" style="padding:2px"><input name="Payment_Paid_Coinpayment" type="submit" id="Payment_Paid_Coinpayment"  value="Withdraw Pay Via  Coin Payment"  onclick="return submitConfirmFromUser('arr_pay_ids[]')"/> 
      </td>-->
	 
	  <td width="20%" align="right" style="padding:2px"><input name="Payout_Binance" type="submit" id="Payout_Binance"  value="Withdraw Pay Via  Binace"  onclick="return submitConfirmFromUser('arr_pay_ids[]')"/>
	   
	   
      </td>
	  
	  
	  <!--
      <td width="8%" align="right" style="padding:2px">Paid to BTC Wallet
       <input name="Payout_wallet" type="image" id="Payout_wallet" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>
      </td>
      <td width="8%" align="right" style="padding:2px"><input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>
      </td>-->
     </tr>
	 <!-- <tr> 
	  <td  colspan="4"> </td>
	  <td width="34%" align="right" style="padding:2px"> Coin Rate:
       <input name="coin_rate" type="text"   value="" />
      </td>
	  <td width="34%" align="right" style="padding:2px"> Bonus %:
       <input name="coin_bonus" type="text"   value="" />
      </td>
	   <td width="8%" align="left" style="padding:2px">
	   <input name="Token_update" type="image" id="Token_update" src="images/buttons/submit.gif" onclick="return paidConfirmFromUser('arr_pay_ids[]')"/>
      </td>
	  <td  > </td>
	    </tr>-->
    </table>
   </form>
   <? }?>
   <? include("paging.inc.php");?>
  </td>
 </tr>
</table>
<? include("bottom.inc.php");?>
