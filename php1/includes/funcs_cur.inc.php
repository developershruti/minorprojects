<?
function validate_form()
{
	return ' onsubmit="return validateForm(this,0,0,0,1,8);" ';
}

 
///////////////biz91 Payout API function start ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function bizz91_get_api_key() {

	$sql = "select * from ngo_bizz91 where bizz_group='BIZZ91'";
	$result = db_query($sql);
	$line_raw = mysqli_fetch_array($result);
	$bizz_username=$line_raw['bizz_username'];
	$bizz_password=$line_raw['bizz_password'];
	$bizz_status = $line_raw['bizz_status'];
	#$username = "M000062";
	#$password="uTWTAdmVUG";
	if($bizz_username!='' && $bizz_password!='' && $bizz_status=='Active') { 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.bizz91.com/api/account/login");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$bizz_username&password=$bizz_password");
	// In real life you should use something like:
	// curl_setopt($ch, CURLOPT_POSTFIELDS, 
	// http_build_query(array('postvar1' => 'value1')));
	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);

	$character = json_decode($server_output);
	//print_r($character);
	$bizz_api_key= $character->response->api_key;

	$sql = "update ngo_bizz91 set  bizz_api_key='$bizz_api_key', bizz_date =ADDDATE(now(),INTERVAL 630 MINUTE) where bizz_group='BIZZ91'";
	db_query($sql);
	
	return $bizz_api_key;

	////api_key end ////
	}

}

function bizz91_get_token() {

	$sql = "select * from ngo_bizz91 where bizz_group='BIZZ91'";
	$result = db_query($sql);
	$line_raw = mysqli_fetch_array($result);
	$bizz_username=$line_raw['bizz_username'];
	$bizz_api_key=$line_raw['bizz_api_key'];
	$bizz_status = $line_raw['bizz_status'];
	#$username = "M000062";
	#$password="uTWTAdmVUG";
	if($bizz_username!='' && $bizz_api_key!='' && $bizz_status=='Active') {
	#$username = "M000062";
	#$api_key="79eda903d79eb6b87b22dd49e107a72c";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.bizz91.com/api/token/generateAccessToken");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$bizz_username&api_key=$bizz_api_key");
	// In real life you should use something like:
	// curl_setopt($ch, CURLOPT_POSTFIELDS, 
	// http_build_query(array('postvar1' => 'value1')));
	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	
	//print_r($server_output);
	$character = json_decode($server_output);
	//print_r($character);
	 $bizz_token= $character->token;
	 $bizz_token_expiry= $character->expiry;

	$sql = "update ngo_bizz91 set  bizz_token='$bizz_token',bizz_token_expiry='$bizz_token_expiry', bizz_date =ADDDATE(now(),INTERVAL 630 MINUTE) where bizz_group='BIZZ91'";
	db_query($sql);

	return $bizz_token;
		
	////token end ////
	}

}


function bizz91_get_balance() {

	$sql = "select * from ngo_bizz91 where bizz_group='BIZZ91'";
	$result = db_query($sql);
	$line_raw = mysqli_fetch_array($result);

	$access_token=$line_raw['bizz_token'];
	$bizz_status = $line_raw['bizz_status'];
	if($access_token!='' && $bizz_status=='Active') {


		//$access_token = 'e510d7f42064bfcf2730742abd3363e0';
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
		//echo $response;  //[JSON RESPONSE]
		$pay_response = json_decode($response);
		//print_r($pay_response);
		 $bizz_balance= $pay_response->funds;

		$sql = "update ngo_bizz91 set  bizz_balance='$bizz_balance', bizz_date =ADDDATE(now(),INTERVAL 630 MINUTE) where bizz_group='BIZZ91'";
		db_query($sql);
		return $bizz_balance;


	}


}



function bizz91_send_payout($u_username,$imps_amount,$pay_id) {

	$sql = "select * from ngo_bizz91 where bizz_group='BIZZ91'";
	$result = db_query($sql);
	$line_raw = mysqli_fetch_array($result);

	$access_token=$line_raw['bizz_token'];
	$bizz_status = $line_raw['bizz_status'];
	if($access_token!='' && $bizz_status=='Active') {


		$sql_details = "select * from ngo_users where  u_username ='$u_username'";
		$result_details = db_query($sql_details);
		$line_details= mysqli_fetch_array($result_details);
		@extract($line_details);  
		//$imps_amount  = 100;
		//$api_request_id='11223344';
		$parameters = array(
		  'account_number' => $u_bank_acno
		  ,'confirm_account_number' => $u_bank_acno
		  ,'ifsc' => $u_bank_ifsc_code
		  ,'amount' => round($imps_amount,0)
		  ,'transfer_type' => 'imps'
		  ,'bene_name' => $u_bank_acc_holder
		  ,'api_request_id' => $pay_id
		);
		// imps  neft   rtgs   upi
		
		//$access_token = 'e510d7f42064bfcf2730742abd3363e0';
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
		//print_r($pay_response);
		
		 $biz_status= $pay_response->status;
		 $biz_respons_code= $pay_response->response_code;
		 $biz_url_id= $pay_response->urn_id;
		 $biz_utr= $pay_response->utr;
		 $biz_txnrefid= $pay_response->txnRefID;
		 $biz_response= $pay_response->response;


		 
		 $sql = "insert into ngo_bizz91_log set  biz_userid='$u_id' ,biz_status='$biz_status',	biz_respons_code='$biz_respons_code',biz_url_id='$biz_url_id',biz_utr='$biz_utr',biz_txnrefid='$biz_txnrefid',biz_response='$biz_response',biz_amount='$imps_amount',	biz_pay_id='$pay_id' , biz_datetime =ADDDATE(now(),INTERVAL 630 MINUTE)";
		 db_query($sql);

		 if($biz_status=='1') { 
		$pay_transaction_no = " Report ID : $biz_url_id | UTR No : $biz_utr ";
		$sql3 = "update ngo_users_payment set pay_transaction_no='$pay_transaction_no',pay_status='Paid' , pay_transfer_date=ADDDATE(now(),INTERVAL 570 MINUTE) where  pay_userid = '$u_id' and  pay_id = '$pay_id'  "; 
		db_query($sql3);
		 }

		return $biz_status;
		 //{"status":true,"response_code":"s001","urn_id":"344368570","utr":"013718962250","txnRefID":"140","response":"Successfully transfered ₹100 to Surya Bhan Yadav (09211000010159)"}



	}

}
///////////////biz91 Payout API function End  ////////////////////////////

function send_sms($mobilenumbers,$message,$msg_id='') {
		if ($mobilenumbers!='' && $message!='') {
		
			//$url="https://api.bizzsms.in/api/v2/SendSMS?SenderId=PLAYRM&Is_Unicode=false&Is_Flash=false&Message=$message&MobileNumbers=$mobilenumbers&ApiKey=70sLcArgjj5gnPKZ6G8te/ycrk+nrfElnnC5iWro6Nc=&ClientId=2122085a-abe2-43de-9569-99ceced7747d";
	   
			$message = urlencode($message);
			//$url="http://bulk.onestopsms.in/GatewayAPI/rest";
			//"loginid=onlinemarketing&password=313770&msg=$message&send_to=$mobilenumbers&senderId=WEZOOM&routeId=8&smsContentType=english"
			$url="https://api.bizzsms.in/api/v2/SendSMS?";
			$ch = curl_init(); 
			if (!$ch){die("Couldn't initialize a cURL handle");}
			$ret = curl_setopt($ch, CURLOPT_URL,$url);
			//curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt ($ch, CURLOPT_POSTFIELDS,"SenderId=PLAYRM&Is_Unicode=false&Is_Flash=false&Message=$message&MobileNumbers=$mobilenumbers&ApiKey=70sLcArgjj5gnPKZ6G8te/ycrk+nrfElnnC5iWro6Nc=&ClientId=2122085a-abe2-43de-9569-99ceced7747d");
			$ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   
			$curlresponse = curl_exec($ch); // execute
	   
			///print $url="http://bulk.onestopsms.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=6181ddeefc5fa7d09c669a633b0f117&message=$message&senderId=wezoom&routeId=8&mobileNos=$mobilenumbers&smsContentType=english";
			//print_r($curlresponse);
		   if(curl_errno($ch))
			   echo 'curl error : '. curl_error($ch);
		   
			if (empty($ret)) {
			   // some kind of an error happened
			   die(curl_error($ch));
			   curl_close($ch); // close cURL handler
			} else {
			   $info = curl_getinfo($ch);
			   curl_close($ch); // close cURL handler
			   //echo "<br>";
			   return $curlresponse;    //echo "Message Sent Succesfully" ;
			 }
		
	   
		}	 
	   }
	   

 
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // send email code start  Mailtrap

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 // Include PHPMailer classes
 
 require SITE_FS_PATH.'/mailtrap/vendor/autoload.php';
 
  /// send mail via smtp mailtrap
 function send_email_mailtrap($to_email, $usr_fname, $subject, $message) { 

 
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'live.smtp.mailtrap.io';   // smtp.mailtrap.io                  // Specify Mailtrap SMTP servers
    $mail->SMTPAuth   = true;   // true                                 // Enable SMTP authentication
    $mail->Username   = 'api';  //your_mailtrap_username              // SMTP username
    $mail->Password   = '5af383041d6622bb7ee18c4e7922d9b4xxxxxxxxxxxxxxxxx'; // your_mailtrap_password             // SMTP password
	//$mail->SMTPSecure = 'tls';
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	//$mail->Port       = 587;  // 587 (recommended), 2525 or 25 // rival outgoin port smtp 465                                // TCP port to connect to
	$mail->Port       = 587;  // 587 (recommended), 2525 or 25 // rival outgoin port smtp 465               
    

	/*$mail->SMTPOptions = array (
        'ssl' => array(
            'verify_peer'  => true,
            'verify_peer_name'  => false,
            'allow_self_signed' => true));*/


    // Recipients
   // $mail->setFrom('from@example.com', 'Your Name');
    $mail->setFrom('info@kenzotrade.com', 'KenzoTrade.com');
    //$mail->addAddress('recipient@example.com', 'Recipient Name');     // Add a recipient
	$mail->addAddress($to_email, $usr_fname);     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
   // $mail->Subject = 'Test Email via Mailtrap';
    $mail->Subject = $subject;
    //$mail->Body    = 'This is a test email sent via Mailtrap.';
	$mail->Body    = $message;
 
    // $mail->send(); Hold for temp 
	
     //echo 'Email has been sent successfully!';
} catch (Exception $e) {
     // echo "Email could not be sent. Error: {$mail->ErrorInfo}";
}

 
 
 }
 
function send_sms_promo($mobilenumbers,$message,$msg_id='') {
	if ($mobilenumbers!='' && $message!='') {
		 // $url = "http://textart.in/sendhttp.php?user=".urlencode('smsapi')."&password=".urlencode('vipin@2015')."&mobiles=".urlencode($mobilenumbers)."&message=".urlencode($message)."&sender=".urlencode('ILAXMI')."&route=4";
		$message = urlencode($message);
	   $url="http://bulk.onestopsms.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=c0a0aa89cda22ee561a4bcc32987152d&message=$message&senderId=PLAYRM&routeId=11&mobileNos=$mobilenumbers&smsContentType=english";
		 $ch = curl_init($url);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   $curl_scraped_page = curl_exec($ch);
	   curl_close($ch);
	   //echo $curl_scraped_page;
		return $curl_scraped_page; 
		  }
	}

 
function protect_admin_page() {
	//return true;
	 $cur_dir = dirname($_SERVER['PHP_SELF']);
	if($cur_dir == SITE_SUB_PATH.'/admin') {
		$cur_page = basename($_SERVER['PHP_SELF']);
		 //echo "<br>cur_page: $cur_page";
		if($cur_page != 'login.php') {
			if ($_SESSION['sess_admin_login_id']=='') {
			#	header('Location: login.php');
			#	exit;
			}
		}
	}
}

function protect_admin_page2() {

	if ($_SESSION['sess_admin_login_id']=='') {
 		header('Location: login.php');
		exit;
	}
}

function protect_user_page() {

	if ($_SESSION['sess_uid']=='') {
 		//$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
		//$_SESSION['sess_back']='./dashboard/'.basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
		$_SESSION['sess_back']='./userpanel/'.basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
		header('Location: login.php');
		exit;
	}
}


function get_sponsor_id($u_ref_userid,$u_ref_side){
  	while ($sb!='stop'){
		$u_id = db_scalar("select u_id from ngo_users  where  u_sponsor_id ='$u_ref_userid' and u_ref_side='$u_ref_side' limit 0,1");
		if ($u_id!='') { $u_ref_userid = $u_id; } else { $sb='stop';}
  } 
 return $u_ref_userid;
}


  
/// Sajax Funtion Start 

 
 
 

function get_user_details($name='user_details',$topup_username) {
	//check uesrname availability
	
 
	if ($topup_username!='') { $sql_part = " and u_username= '$topup_username' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select * from ngo_users where  u_username= '$topup_username' ";
	$result_you  = db_query($sql_you );
	$line_you   = mysqli_fetch_array($result_you );
  	//aassmapvt.com
	  if ($line_you['u_id']!='') {
		return '<span  style="color:#09A701">'.$line_you['u_fname'].'</span>';
	} else {
		return '<span class="error">Username does not exist!</span>';
	}
}

function get_referal_details($name='referal_details',$ref_userid) {
	//check uesrname availability
 	if ($ref_userid!='') { $sql_part = " and u_username= '$ref_userid' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select u_id, u_fname from ngo_users where 1 $sql_part ";
	$result_you  = db_query($sql_you);
	$line_you   = mysqli_fetch_array($result_you);
	 //return "OK" .$line_you[u_id];
	if ($line_you['u_id']!='') {
		return '<span  style="color:#ee6b4f">'.$line_you['u_fname'].'</span>';
	} else {
		return '<span  style="color:#ee6b4f">Invalid Sponsor Id!</span>';
	}
  	
}

 

/*function sk start*/
 /// Sajax Funtion Start 
 
function get_direct_downline_details($name='direct_downline_details',$userid) {
	//check uesrname availability
 	if ($userid!='') { $sql_part = " and u_id= '$userid' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select * from ngo_users where 1 $sql_part";
	$result_you  = db_query($sql_you );
	$line_you   = mysqli_fetch_array($result_you );
	
	$referer_id = db_scalar("select u_username from ngo_users where u_id='$line_you[u_ref_userid]' ");
	$total_topup = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$line_you[u_id]' ");
 	
	$total_downline_business  = direct_total_business_date_range($userid , "  ")+0;
 	// Left-Right Recharge Business :	 
	#$total_recharge_left  = binary_total_business_date_range($left_side_id, " and topup_plan='RECHARGE'")+0;
	#$total_recharge_right = binary_total_business_date_range($right_side_id, " and topup_plan='RECHARGE'")+0 ;
	//aassmapvt.com
	if (($line_you[u_photo]!='')&& (file_exists(UP_FILES_FS_PATH.'/profile/'.$line_you[u_photo]))) {  
$photo = '<img src="'.show_thumb(UP_FILES_WS_PATH.'/profile/'.$line_you[u_photo],100,100,'height').'" align="left" border="0"   style="margin-right:1px; vertical-align:top;" />';
 }   
	$return_msg = '
	 
 	<table width="100%" border="0" cellspacing="3" cellpadding="3" class="white_box"  >
	  <tr class="tdOdd" >
	  <td width="20%" align="right"  > <strong>Name :</strong></td>
		<td width="30%"  nowrap="nowrap" >'.$line_you[u_fname].'</td>
 	    <td width="20%" align="right"  ><strong>User ID :</strong></td>
	    <td width="30%" align="left"  nowrap="nowrap">'.$line_you[u_username].'</td>	
	   </tr>
	  <tr  class="tdEven" >
	  <td align="right"  nowrap="nowrap" > <strong>Date of join :</strong></td>
		<td align="left" >'. date_format2($line_you[u_date]).'</td>
		<td align="right"  > <strong>Sponsor ID : </strong></td>
		<td align="left" >'.$referer_id.'</td>
	 </tr>
 	 <!-- <tr  class="tdOdd" >
	  <td align="right"  ><strong> Self Topup:</strong></td>
		<td align="left" >'.  $total_topup .'  </td>
  		<td align="right"  nowrap="nowrap" ><strong>Downline Business:</strong></td>
	    <td align="left" nowrap="nowrap" >'.price_format($total_downline_business).' </td>
	  </tr>-->
 	  </table>
	   ';
	 
	 
	 
	return $return_msg;
}









/*function sk end*/


function get_downline_details($name='downline_details',$userid) {
	//check uesrname availability
	if ($userid!='') { $sql_part = " and u_id= '$userid' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select * from ngo_users where 1 $sql_part";
	$result_you  = db_query($sql_you );
	$line_you   = mysqli_fetch_array($result_you);
	
	$referer_id = db_scalar("select u_username from ngo_users where u_id='$line_you[u_ref_userid]' ");
	$total_topup = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$line_you[u_id]' ");
	//$topup_date = db_scalar("select topup_date  from ngo_users_recharge where topup_userid='$line_you[u_id]' and topup_status='Paid' ");
	$left_side_id = db_scalar("select u_id from ngo_users where u_sponsor_id='$line_you[u_id]' and u_ref_side='A'");
	$right_side_id = db_scalar("select u_id from ngo_users where u_sponsor_id='$line_you[u_id]' and u_ref_side='B'");
	 $green_date =  db_scalar("select  gift_tr_date from ngo_users_gift where gift_by_userid = '$line_you[u_id]' and gift_status='Accept' order by gift_id desc");
	 
	 $total_referer = db_scalar("select  count(*) from ngo_users,ngo_users_recharge where u_id=topup_userid and u_status='Active' and u_ref_userid ='$line_you[u_id]' ")+0;
		// Sponsor ID
	//$sponsor_id = db_scalar("select u_username from ngo_users where u_id ='$line_you[u_ref_userid]' ");

	//Left-Right Count :
	$left_side_count  = binary_total_ids($left_side_id)+0 ;
	$right_side_count = binary_total_ids($right_side_id)+0 ;
	
	// Left-Right Topup Business :
	//binary_total_date($userid,$datefrom,$dateto)
	$total_topup_left  = binary_total_business_date_range($left_side_id ,"  ")+0;
	$total_topup_right = binary_total_business_date_range($right_side_id ,"  ")+0 ;
	
	#$total_topup_left2  = binary_total_business_date_range($left_side_id ,"  and topup_plan='RE_TOPUP' ")+0;
	#$total_topup_right2 = binary_total_business_date_range($right_side_id ,"  and topup_plan='RE_TOPUP' ")+0 ;

 	$total_paid_left  = binary_total_paid($left_side_id)+0;
	$total_paid_right = binary_total_paid($right_side_id)+0 ;
	
	$total_unpaid_left  = ($total_topup_left +$total_topup_left2) - $total_paid_left;
	$total_unpaid_right = ($total_topup_right+$total_topup_right2) - $total_paid_right;

 
	// Left-Right Recharge Business :	 
	#$total_recharge_left  = binary_total_business_date_range($left_side_id, " and topup_plan='RECHARGE'")+0;
	#$total_recharge_right = binary_total_business_date_range($right_side_id, " and topup_plan='RECHARGE'")+0 ;
	//aassmapvt.com
	if (($line_you[u_photo]!='')&& (file_exists(UP_FILES_FS_PATH.'/profile/'.$line_you[u_photo]))) {  
$photo = '<img src="'.show_thumb(UP_FILES_WS_PATH.'/profile/'.$line_you[u_photo],100,100,'height').'" align="left" border="0"   style="margin-right:1px; vertical-align:top;" />';
 }   
	$return_msg = '
<table width="494" border="1" align="left" cellpadding="2" cellspacing="1"  class="td_box" >
  <tr class="tdEven">
    <td width="214" > User ID</td>
    <td colspan="2" > '.$line_you[u_username] .' </td>
    
  </tr>
  <tr class="tdOdd" >
    <td  >Name</td>
    <td colspan="2" >'.$line_you[u_fname].'</td>
     
  </tr>
  <tr class="tdEven">
    <td >Date of Joining</td>
    <td colspan="2" >'. date_format2($line_you[u_date]).'</td>
   
  </tr>
   <tr class="tdOdd">
    <td  >Total Active Direct </td>
    <td colspan="2">'. $total_referer.' </td>
    
  </tr>
  
  
  <!--
  <tr  >
    <td   >Paid Date</td>
    <td colspan="2">'. date_format2($green_date).'</td>
   
  </tr>-->
 <!-- <tr class="tdOdd">
    <td  >Commitment Amount</td>
    <td colspan="2">'. price_format($total_topup).' </td>
    
  </tr>-->
  
 <!-- <tr class="tdEven">
    <td ></td>
    <td width="148" >Left</td>
    <td width="130"  >Right</td>
  </tr>
  <tr class="tdOdd">
    <td  >Total Users</td>
    <td  >'.$left_side_count.' </td>
    <td  >'.$right_side_count.'</td>
  </tr>
  <tr class="tdEven">
    <td  >Total Commitment </td>
    <td  >'.$total_topup_left.'</td>
    <td  >'.$total_topup_right.'</td>
  </tr>-->
  <!-- <tr>
    <td  >Total Re-Commitment  </td>
    <td  >'.$total_topup_left2.'</td>
    <td  >'.$total_topup_right2.'</td>
  </tr>-->
  <!--<tr class="tdOdd">
    <td  >Total Paid  </td>
    <td  >'.$total_paid_left.'</td>
    <td  >'.$total_paid_right.'</td>
  </tr>
  <tr class="tdEven">
    <td  >Total Unpaid </td>
    <td  >'.$total_unpaid_left.'</td>
    <td  >'.$total_unpaid_right.'</td>
  </tr>-->
</table>
  
	   ';
	 
	 
	 
	return $return_msg;
}




/// Sajax Funtion Start 


function binary_total_paid_close($userid){
 	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_sponsor_id in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
			 
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$id_in = implode(",",$id); 
 	$total_business = db_scalar("select sum(topup_amount)  from ngo_users_recharge  where   topup_status!='Unpaid'  and topup_userid in ($id_in)  ")+0; 
	return $total_business;
}
}

function binary_total_ids($userid){
	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	$ctr++;
	//if ($ctr>=10) {$sb='stop';}
 	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_sponsor_id in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
 		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			  $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
  	$id_in = implode(",",$id); 
 	$total_ids = db_scalar("select count(u_id)  from ngo_users  where  u_sponsor_id in ($id_in) ")+1; 
	return $total_ids;
 }
}


function direct_to_direct_ids($userid){
	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	$ctr++;
	//if ($ctr>=10) {$sb='stop';}
 	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_ref_userid in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
 		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test['u_id'];
				$refid[]=$line_test['u_id'];
			}
			  $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
  	$id_in = implode(",",$id); 
	
 	$total_ids['0'] = db_scalar("select count(*)  from ngo_users  where  u_ref_userid in ($id_in) ")+0; 
	$total_ids['1'] = db_scalar("select count(*)  from ngo_users  where  u_ref_userid in ($id_in) and u_id in (select topup_userid from ngo_users_recharge) ")+0;
	return $total_ids;
 }
}



function binary_total_paid_ids($userid,$sql_part){
	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	$ctr++;
	//if ($ctr>=10) {$sb='stop';}
  	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_sponsor_id in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
 		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			  $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	 $id = array_unique($id); 
  	$id_in = implode(",",$id); 
	//return "select count(*)   from ngo_users_recharge  where  topup_userid in ($id_in) $sql_part ";
	//$total_ids = db_scalar("select count(*) from ngo_users_recharge  where  topup_userid in ($id_in) $sql_part ");
  	$total_ids = db_scalar("select  count(*) from ngo_users_recharge  where  topup_userid in ($id_in)   $sql_part "); 
	return $total_ids;
}
}


function binary_total_business_date_range($userid ,$sql_part){
 	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_sponsor_id in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	 $id = array_unique($id); 
	$id_in = implode(",",$id); 
 	 #print  "<br> select sum(topup_amount)  from ngo_users_recharge  where  topup_userid in ($id_in) $sql_part ";
	$total_business = db_scalar("select sum(topup_amount)  from ngo_users_recharge  where  topup_userid in ($id_in) $sql_part ")+0; 
	return $total_business;
}
}

function binary_total_paid($userid){
 	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_sponsor_id in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
			 
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$id_in = implode(",",$id); 
 	$total_business = db_scalar("select sum(topup_amount)  from ngo_users_recharge  where topup_userid!='$userid' and  topup_userid in ($id_in) ")+0; 
	return $total_business;
}
}


function binary_total_date($userid,$datefrom,$dateto){
	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where    u_sponsor_id in ($referid) ";
	if ($datefrom!='' && $dateto!='') {  $sql_test .= " and u_date between '$datefrom' AND '$dateto' ";  }
 	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$id_in = implode(",",$id); 
	//	 print "select count(u_id)  from ngo_users  where  u_sponsor_id in ($id_in) ";

 	$total_ids = db_scalar("select count(u_id)  from ngo_users  where u_status='Active' and  u_sponsor_id in ($id_in) ")+1; 
	return $total_ids;
}
}

function direct_to_direct_total_team($userid ,$sql_part){
 	if ($userid!=''){
 	
	$id = array();
	$id[]=$userid;
	$level=3;
 	$ctr=0;
 	while ($ctr<$level){
	$ctr++;
	if ($referid=='') {$referid=$userid;}
	//print "<br> $ctr ==> ". 
	$sql_test = "select u_id  from ngo_users  where  u_ref_userid in ($referid)  ";
 	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
 			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
			// check ID limit for l1 incime 
				$self_unit_limit = db_scalar(" select count(*) from ngo_users_reward_point where pay_userid='$line_test[u_id]' and pay_status='Unpaid' ");
 				if($self_unit_limit>0) {
					$id[]   =$line_test['u_id'];
					$refid[]=$line_test['u_id'];
					}
				}
			 $refid   = array_unique($refid); 
			 $referid = implode(",",$refid);
 			// print "<br> ==================================================== Downline Team ($count)  $ctr ==> ".$referid;
		} 
	 } 
	 
	$ctr=0;
	$level=1;
 	while ($ctr<$level){
	$ctr++;
	if ($u_ref_userid_new=='') {$u_ref_userid_new=$userid;}
 	$u_ref_userid_new = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid_new' ");
 //	print "<br> $u_ref_userid_new ==> ". 
	$sql_test = "select u_id  from ngo_users  where  u_ref_userid='$u_ref_userid_new'  ";
 	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
		$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
			$self_unit_limit = db_scalar(" select count(*) from ngo_users_reward_point where pay_userid='$line_test[u_id]' and pay_status='Unpaid' ");
 				if($self_unit_limit>0) {
				$id[]   =$line_test['u_id'];
				$refid[]=$line_test['u_id'];
				}
			}
			 $referid = implode(",",$refid);
			 // print "<br>====================================================  Upline Direct ($count)   $ctr ==> ".$referid;
			 
		} 
	 } 
	 
 	$id = array_unique($id); 
	$id_in = implode(",",$id); 
	 
	return $id_in;
}
}
function downline_ids($userid){
	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
	
	while ($sb!='stop'){
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where  u_ref_userid in ($referid)  ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test['u_id'];
				$refid[]=$line_test['u_id'];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$id_in = implode(",",$id); 
	return $id_in;
}
}
function downline_ids_count_sk($userid){
	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
	
	while ($sb!='stop'){
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where  u_ref_userid in ($referid)";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$result = count($id);
	//$id_in = implode(",",$id); 
	
	return $result;
}
}
function coordinator_upling_ids($u_ref_userid){
  if ($u_ref_userid!='') {
 				while ($sb!='stop'){
					if ($u_ref_userid==0 || $u_ref_userid=='') {$sb='stop'; }
						$u_coordinator = db_scalar("select u_coordinator  from ngo_users  where  u_id ='$u_ref_userid'  ");
						//print " <br> $u_userid =$u_total_referer ,";
						if ($u_coordinator=='Yes') {
							$coordinator_id = $u_ref_userid;
							$sb='stop';
						} else {
							$u_ref_userid = db_scalar("select u_ref_userid  from ngo_users  where  u_id ='$u_ref_userid'  ");
						}
				} 
				
				
			 }
	return  $coordinator_id;
 
 }

function coordinator_ids($u_userid){
	 
	if ($u_userid!='') {
	$id = array();
 	while ($sb!='stop'){
	if ($referid=='') {$referid=$u_userid;}
	$sql_test = "select u_id ,u_coordinator from ngo_users  where  u_ref_userid in ($referid)  ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			// print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
 				if ($line_test[u_coordinator]=='Yes') { 
					$id[]=$line_test[u_id];
 				 }  else {
					$refid[]=$line_test[u_id];
				 }
 			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$coordinator_id_in = implode(",",$id);
 }  
	return  $coordinator_id_in;
	 
}


////////////////////////////////////////////
function str_stop($string, $max_length){
	if (strlen($string) > $max_length){
		$string = substr($string, 0, $max_length);
		$pos = strrpos($string, " ");
		if($pos === false) {
			  return substr($string, 0, $max_length)."...";
		  }
		return substr($string, 0, $pos)."...";
	}else{
		return $string;
	}
}


function date_month($date, $format) {
	if (strlen($date) >= 10) {
		if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		}
		$mktime	= mktime(0,	0, 0, substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		//return date("F", $mktime);
		return date($format, $mktime);
	} else {
		return $s;
	}
}
function cal_age($DOB) { 
 	    $birth = explode("-", $DOB); 
         $age = date("Y") - $birth[0]; 
         if(($birth[1] > date("m")) || ($birth[1] == date("m") && date("d") < $birth[2])) { 
                $age -= 1; 
        } 
        return $age; 
}
function payment_group_dropdown($selected,$extra) {
 	global $ARR_PAYMENT_GROUP;
	return array_dropdown($ARR_PAYMENT_GROUP,$selected,'pay_group',$extra);
}

function payment_processor_dropdown($selected,$extra) {
 	global $ARR_PAYMENT_PROCESSOR;
	return array_dropdown($ARR_PAYMENT_PROCESSOR,$selected,'pay_group',$extra);
}


function payment_status_dropdown($name,$sel_value){
	$arr = array('' => 'Please Select', 'New' => 'New', 'Paid' => 'Paid', 'Unpaid' => 'Unpaid', 'Close' => 'Close', 'Pending' => 'Pending', 'Failed' => 'Failed');
	return array_dropdown($arr, $sel_value, $name);
}
function payment_mode_dropdown($name,$sel_value){
	$arr = array('' => 'Please Select', 'Cash' => 'Cash', 'Cheque' => 'Cheque', 'Other' => 'Other');
	return array_dropdown($arr, $sel_value, $name);
}
function total_ref_dropdown($name,$sel_value){
	$arr = array('' => 'Please Select', '3' => 'Referer 3', '5' => 'Referer 5', '11' => 'Referer 11', '25' => 'Referer 25', '0' => 'Referer 0');
	return array_dropdown($arr, $sel_value, $name);
}

function bank_dropdown($name,$sel_value){
	$arr = array('' => 'Please Select', "ICICI" => 'ICICI', 'BOI' => 'BOI','BOB'=>'BOB','HDFC'=>'HDFC','AXIS'=>'AXIS');
	return array_dropdown($arr, $sel_value, $name);
}

function bank_dropdown2($name,$sel_value){
	$arr = array('' => 'Please Select', "ICICI" => 'ICICI', 'BOI' => 'BOI','BOB'=>'BOB','HDFC'=>'HDFC','AXIS'=>'AXIS','SBI'=>'SBI');
	return array_dropdown($arr, $sel_value, $name);
}

function checkstatus_dropdown($name,$sel_value){
	$arr = array( '' => 'Please Select','Not Deliver' => 'Not Deliver', 'Deliver' => 'Deliver','Cancel'=>'Cancel','New Request'=>'New Request');
	return array_dropdown($arr, $sel_value, $name);
}
function checktype_dropdown($name,$sel_value){
	$arr = array( '' => 'Please Select','PDC' => 'PDC','DIRECT' => 'DIRECT','MATCHING' => 'MATCHING' ,'TRADE_PROFIT'=>'TRADE_PROFIT' ,'GENERAL' => 'GENERAL');
	return array_dropdown($arr, $sel_value, $name);
}

function deduction_dropdown($name,$sel_value,$extra){
	$ARR_DEUCTION = array( '' => 'Please Select','TDS'=>'TDS' );
	 
	return array_dropdown($ARR_DEUCTION,$sel_value,$name,$extra);
}

 

function gender_dropdown($selected,$extra) {
 	
	global $ARR_GENDER;
	return array_dropdown($ARR_GENDER,$selected,'u_gender',$extra);
}

function us_state_dropdown($selected,$extra) {
 	global $arr_us_state;
	return array_dropdown($arr_us_state, $selected, 'u_state' , $extra);
}
	
function  payment_type_dropdown($sel_value,$name,$extra){
// 	( $arr, $sel_value='', $name='', $extra='', $choose_one='', $arr_skip= array())
	global $ARR_PAYMENT_TYPE;
	return array_dropdown($ARR_PAYMENT_TYPE, $sel_value, $name,$extra);
}
function traxrate_dropdown($name,$sel_value){
	$arr = array( "Exempted" => 'Exempted', '4' => '4%', '12.5' => '12.5%','1' => '1%');
	return array_dropdown($arr, $sel_value, $name);
}

function taxable_dropdown($name,$sel_value){
	$arr = array( "taxable" => 'Taxable', 'nontaxable' => 'Non Taxable');
	return array_dropdown($arr, $sel_value, $name);
}

function guardian_dropdown($name,$sel_value){
	$arr = array( "father" => 'Father', 'husband' => 'Husband', 'other' => 'Other');
	return array_dropdown($arr, $sel_value, $name);
}

function status_dropdown($name ,$sel_value ){
	$arr = array( "" => 'Please Select ','Banned' => 'Block ID\'s','Active' => 'Active', 'Inactive' => 'Inactive', 'Reject' => 'Rejected');
	return array_dropdown($arr, $sel_value, $name);
}

function yes_no_dropdown($name,$sel_value){
	$arr = array( ''=>'Please select','Yes' => 'Yes', 'No' => 'No');
	return array_dropdown($arr, $sel_value, $name);
}
function join_mode_dropdown($name,$sel_value,$extra){
	$arr = array(''=>'Please select', 'Direct' => 'Direct', 'Spill' => 'Spill');
	return array_dropdown($arr, $sel_value, $name,$extra);
}

function left_right_dropdown($name,$sel_value,$extra){
	$arr = array( ''=>'Please select','A' => 'Left', 'B' => 'Right');
	return array_dropdown($arr, $sel_value, $name,$extra);
}
function u_gender_dropdown($selected,$extra) {
  	
	$arr_gender = array( "male" => 'Male', 'female' => 'Female');
	return array_dropdown($arr_gender,$selected,'u_gender',$extra);
}
 						
function package_dropdown($sel_value,$extra){
	$sql ="select utype_id , utype_name from ngo_users_type where utype_status='Active'    order by utype_id";  
	return make_dropdown($sql, 'package', $sel_value,  'class="txtbox" alt="select"  style="width:200px;"','Please select');
 }

function week_dropdown($sel_value,$extra){
 	global $ARR_WEEK;
	return array_dropdown($ARR_WEEK, $sel_value, 'dia_day',$extra);
}

function weekday_dropdown($sel_value,$extra){
 	global $ARR_WEEK_DAYS;
	return array_dropdown($ARR_WEEK_DAYS, $sel_value, 'dia_week',$extra);
}


function cal_days($dateFrom,$dateto){
 	$dateFrom = date("d-m-Y H:i:s",strtotime($dateFrom));
	$dateTo = date("d-m-Y H:i:s", strtotime($dateto));
	$diffd = getDateDifference($dateFrom, $dateTo, 'd');
	$diffh = getDateDifference($dateFrom, $dateTo, 'h');
	$diffm = getDateDifference($dateFrom, $dateTo, 'm');
	$diffs = getDateDifference($dateFrom, $dateTo, 's');
	$diffa = getDateDifference($dateFrom, $dateTo, 'a');
 	return $diffd+0;
 } 
   
function cal_lastlogin($dateFrom){
#sb-- calculate login time in hrs and days   	
	#$dateFrom = "07-11-2006 06:00:00";
	$dateFrom = date("d-m-Y H:i:s",strtotime($dateFrom));
	$dateTo = date("d-m-Y H:i:s", strtotime('now'));
	$diffd = getDateDifference($dateFrom, $dateTo, 'd');
	$diffh = getDateDifference($dateFrom, $dateTo, 'h');
	$diffm = getDateDifference($dateFrom, $dateTo, 'm');
	$diffs = getDateDifference($dateFrom, $dateTo, 's');
	$diffa = getDateDifference($dateFrom, $dateTo, 'a');
	
	if ($diffd <=1) {
		if ($diffh<=1) { $logintext = 'Online Now';} 
		else { 	$logintext = 'Offline';}
	} else {
		$logintext = 'Offline';	 
	}
	return $logintext;
	/*
	echo 'Calculating difference between ' . $dateFrom . ' and ' . $dateTo . ' <br /><br />';
	echo $diffd . ' days.<br />';
	echo $diffh . ' hours.<br />';
	echo $diffm . ' minutes.<br />';
	echo $diffs . ' seconds.<br />';
	echo '<br />In other words, the difference is ' . $diffa['days'] . ' days, ' . $diffa['hours'] . ' hours, ' . $diffa['minutes'] . ' minutes and ' . $diffa['seconds'] . ' seconds.
	';
*/
}

function getDateDifference($dateFrom, $dateTo, $unit = 'd') {
	$difference = null;
	$dateFromElements = explode(' ', $dateFrom);
	$dateToElements = explode(' ', $dateTo);
	$dateFromDateElements = explode('-', $dateFromElements[0]);
	$dateFromTimeElements = explode(':', $dateFromElements[1]);
	$dateToDateElements = explode('-', $dateToElements[0]);
	$dateToTimeElements = explode(':', $dateToElements[1]);
	// Get unix timestamp for both dates
	$date1 = mktime($dateFromTimeElements[0], $dateFromTimeElements[1], $dateFromTimeElements[2], $dateFromDateElements[1], $dateFromDateElements[0], $dateFromDateElements[2]);
	$date2 = mktime($dateToTimeElements[0], $dateToTimeElements[1], $dateToTimeElements[2], $dateToDateElements[1], $dateToDateElements[0], $dateToDateElements[2]);
	if( $date1 > $date2 )
	{
		return null;
	}
	$diff = $date2 - $date1;
	$days = 0;
	$hours = 0;
	$minutes = 0;
	$seconds = 0;
	if ($diff % 86400 <= 0)  // there are 86,400 seconds in a day
	{
		$days = $diff / 86400;
	}
	if($diff % 86400 > 0)
	{
		$rest = ($diff % 86400);
		$days = ($diff - $rest) / 86400;
		if( $rest % 3600 > 0 )
		{
			$rest1 = ($rest % 3600);
			$hours = ($rest - $rest1) / 3600;
			if( $rest1 % 60 > 0 )
			{
				$rest2 = ($rest1 % 60);
				$minutes = ($rest1 - $rest2) / 60;
				$seconds = $rest2;
			}
			else
			{
				$minutes = $rest1 / 60;
			}
		}
		else
		{
		$hours = $rest / 3600;
		}
	}
	switch($unit)
	{
	case 'd':
	case 'D':
		$partialDays = 0;
		$partialDays += ($seconds / 86400);
		$partialDays += ($minutes / 1440);
		$partialDays += ($hours / 24);
		$difference = $days + $partialDays;
		break;
	case 'h':
	case 'H':
		$partialHours = 0;
		$partialHours += ($seconds / 3600);
		$partialHours += ($minutes / 60);
		$difference = $hours + ($days * 24) + $partialHours;
		break;
	case 'm':
	case 'M':
		$partialMinutes = 0;
		$partialMinutes += ($seconds / 60);
		$difference = $minutes + ($days * 1440) + ($hours * 60) + $partialMinutes;
		break;
	case 's':
	case 'S':
		$difference = $seconds + ($days * 86400) + ($hours * 3600) + ($minutes * 60);
		break;
	case 'a':
	case 'A':
	$difference = array (
	"days" => $days,
	"hours" => $hours,
	"minutes" => $minutes,
	"seconds" => $seconds
	);
	break;
	}
	return $difference;
}

function pacific_date2(){
	//Monday, November 06, 2006 
	$pst_date = gmdate("Y-m-d", mktime(date("H")-0, date("i"), date("s"), date("m"), date("d"), date("Y")));
	return $pst_date;
}
function pacific_time2(){
//10:44:39 PM 
	$pst_time = gmdate("H:i:s A", mktime(date("H")-12, date("i"), date("s"), date("m"), date("d"), date("Y")));
	return $pst_time;
}


function pacific_time(){
//10:44:39 PM 
	$pst_time = gmdate("H:i:s A", mktime(date("H")-8, date("i"), date("s"), date("m"), date("d"), date("Y")));
	return $pst_time;
}
 
function pacific_date(){
	//Monday, November 06, 2006 
	$pst_date = gmdate("l F m Y", mktime(date("H")-8, date("i"), date("s"), date("m"), date("d"), date("Y")));
	return $pst_date;
} 
 


function smile($content){
	//global $arr_smile;
	$sql_smile	= "select * from ngo_smilies";
	$res_sql_smile=db_query($sql_smile); 
	if(mysqli_num_rows($res_sql_smile)>0){
	 $arr_smile	=	array();
	 while($row_smile=mysqli_fetch_array($res_sql_smile)){
		@extract($row_smile);
	 	$arr_smile[$smile_url]	=	$code;		
	 }
	}
	if(is_array($arr_smile)){
		foreach($arr_smile as $key=>$value){
			if(strpos($content,$value)!=-1){
				$content	=	str_replace($value,'<img src="'.SITE_WS_PATH.'/images/smiles/'.$key.'" border=0>',$content);
			 }
		}
	}
	
	return $content;
}

function rating($table_name,$column_name,$id,$column_rating) {
  $sql_rating = "select avg($column_rating) from $table_name where $column_name='$id'";
  $result_rating=db_scalar($sql_rating);
 return ceil($result_rating);
}

function banner($page,$width,$count,$rand='rand')
 {
  if($rand){
  $query="select * from ngo_banner where banner_page = '$page' and  banner_start_date <= curdate() and banner_end_date >= curdate() and banner_status='Active' order by rand() limit $count";
 
  } else {
  $query="select * from ngo_banner where banner_page = '$page' and banner_start_date <= curdate() and banner_end_date >= curdate() and banner_status='Active' order by banner_id limit $count";
 
  }
//echo $query;

  $result=db_query($query);
  if($result){
	  while($res=mysqli_fetch_array($result))
	   { 
	  if($res['banner_name']){
			if($res['banner_link']){
			$str="<a href=".$res['banner_link']." target='_blank'><img src=".UP_FILES_WS_PATH.'/banner/'.$res['banner_name']." align='center' style='margin-right:5px;' class='border_image'/></a>";
	       } else {
	  		$str="<img src=".UP_FILES_WS_PATH.'/banner/'.$res['banner_name']." align='center' style='margin-right:5px;' class='border_image'/>";
	   		  }
   } else {
	    if($res['banner_link']){
	  	$str="<a href=".$res['banner_link']." target='_blank'>".$res['banner_text']."</a>";
        } else {
		$str=$res['banner_text'];
        }   
      }
	  $str2[]=$str;
	} 
   return $str2;
 }
}






function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 000000);  /* Millions (giga) */ 
    $number -= $Gn * 000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Million"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 




/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	
	$link = mysqli_connect($host,$user,$pass);
	mysqli_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysqli_query('SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysqli_query('SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysqli_fetch_row(mysqli_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}

/*function direct_total_business_date_range($userid ,$sql_part){
 	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_ref_userid in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	 $id = array_unique($id); 
	$id_in = implode(",",$id); 
 	 #print  "<br> select sum(topup_amount)  from ngo_users_recharge  where  topup_userid in ($id_in) $sql_part ";
	$total_business = db_scalar("select sum(topup_amount)  from ngo_users_recharge  where topup_status='Paid' and  topup_userid in ($id_in) $sql_part ")+0; 
	return $total_business;
}
}
*/
function direct_total_business_date_range($userid ,$sql_part, $upto_level){
 	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
	$ctr_level=0;
 	while ($sb!='stop'){
	$ctr_level++;
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_ref_userid in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0 && $ctr_level<=$upto_level) { ///$count>0
			//print "<br> $count = ".$ctr++;
		/// print "$count>0 && $ctr_level<=$upto_level ";
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
  				$id[]=$line_test['u_id'];
 				$refid[]=$line_test['u_id'];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	 $id = array_unique($id); 
	 $id_in = implode(",",$id); 
	 
 	//return "<br> select sum(topup_amount)  from ngo_users_recharge where topup_userid!='$userid' and topup_userid in ($id_in) $sql_part  ";
	$total_business = db_scalar("select sum(topup_amount)  from ngo_users_recharge where topup_userid!='$userid' and topup_userid in ($id_in) $sql_part ")+0;  //topup_status='Paid' and
	return $total_business;
}
}


function direct_total_team_date_range($userid ,$sql_part, $upto_level){
 	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
	$ctr_level=0;
 	while ($sb!='stop'){
	$ctr_level++;
	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_ref_userid in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0 && $ctr_level<=$upto_level) { ///$count>0
			//print "<br> $count = ".$ctr++;
		/// print "$count>0 && $ctr_level<=$upto_level ";
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
  				$id[]=$line_test['u_id'];
 				$refid[]=$line_test['u_id'];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	 $id = array_unique($id); 
	 $id_in = implode(",",$id); 
	 
 	//return "<br> select sum(topup_amount)  from ngo_users_recharge where topup_userid!='$userid' and topup_userid in ($id_in) $sql_part  ";
	//$total_business = db_scalar("select sum(topup_amount)  from ngo_users_recharge where topup_userid!='$userid' and topup_userid in ($id_in) $sql_part ")+0;  //topup_status='Paid' and
 	$total_team = db_scalar("select count(DISTINCT(topup_userid)) from ngo_users_recharge where topup_userid!='$userid' and topup_userid in ($id_in) $sql_part ")+0;  //topup_status='Paid' and
	return $total_team;
}
}



function get_username_details($name='username_details',$username) {
	//check uesrname availability
	 
	if ($username!='') { $sql_part = " and u_username= '$username' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select u_id,u_fname from ngo_users where 1 $sql_part ";
	$result_you  = db_query($sql_you);
	$line_you   = mysqli_fetch_array($result_you );
	 //return "OK" .$line_you[u_id];
	if ($line_you[u_id]!='') {
		return "Username <span class='error' style='color:#ee6b4f;'>(Not Available)</span>";
	} else {
		return "Username <span class='error' style='color:#ee6b4f;'>(Available)</span>";
	}
  	
}
function get_sponsor_details($name='sponsor_details',$ref_userid) {
	//check uesrname availability
	
	if ($ref_userid!='') { $sql_part = " and u_username= '$ref_userid' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select u_id ,u_fname from ngo_users where 1 $sql_part ";
	$result_you  = db_query($sql_you);
	$line_you   = mysqli_fetch_array($result_you );
	 //return "OK" .$line_you[u_id];
	if ($line_you[u_id]!='') {
		return "<span class='error' style='color:#ee6b4f;'>Referral  : $line_you[u_fname] </span>" ;
	} else {
		return "<span class='error' style='color:#ee6b4f;'>Wrong Referral Information</span>";
	}
  	
}
 

// url increation/decreaption 
function encryptor($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    
    $secret_key = 'BigSonLive';
    $secret_iv = 'bigshash@12345678';
   
    $key = hash('sha256', $secret_key);    
   
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
    if( $action == 'encrypt' ) 
    {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' )
    {
    	
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0,      $iv);
    }

    return $output;
}


function getRandomFloat($min, $max) {
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}


function downline_total_ids($userid){
	if ($userid!=''){
 	$id = array();
	$id[]=$userid;
 	while ($sb!='stop'){
	$ctr++;
	//if ($ctr>=10) {$sb='stop';}
 	if ($referid=='') {$referid=$userid;}
	$sql_test = "select u_id  from ngo_users  where u_ref_userid in ($referid) ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
 		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test['u_id'];
				$refid[]=$line_test['u_id'];
			}
			  $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
  	$id_in = implode(",",$id); 
 	//$total_ids = db_scalar("select count(u_id) from ngo_users  where  u_ref_userid in ($id_in) ")+0; 
	//$total_ids = db_scalar("select count(*) from ngo_users_recharge where topup_userid in ($id_in) $sql_part ");
	$total_ids = db_scalar("select COUNT(DISTINCT topup_userid) from ngo_users_recharge where topup_userid in ($id_in) $sql_part "); 
	return $total_ids;
 }
}









?>