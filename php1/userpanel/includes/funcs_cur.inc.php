<?
function validate_form()
{
	return ' onsubmit="return validateForm(this,0,0,0,1,8);" ';
}

 

function send_sms ($mobilenumbers,$message,$msg_id='') {
 
if ($mobilenumbers!='' && $message!='') {
 
	
 #$url= http://bulk.onestopsms.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=c0a0aa89cda22ee561a4bcc32987152d&message=$message&senderId=ROZIPY&routeId=1&mobileNos=$mobilenumbers&smsContentType=english;
 
 $url="http://bulk.onestopsms.in/rest/services/sendSMS/sendGroupSms";
 $message = urlencode($message);
 $ch = curl_init(); 
 if (!$ch){die("Couldn't initialize a cURL handle");}
 $ret = curl_setopt($ch, CURLOPT_URL,$url);
 curl_setopt ($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 curl_setopt ($ch, CURLOPT_POSTFIELDS,"AUTH_KEY=c0a0aa89cda22ee561a4bcc32987152d&message=$message&senderId=ROZIPY&routeId=8&mobileNos=$mobilenumbers&smsContentType=english");
 $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

 print $curlresponse = curl_exec($ch); // execute

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
 
 



function send_sms_punjab($mobilenumbers,$message,$msg_id='') {
 
if ($mobilenumbers!='' && $message!='') {
//////////////////////////////////


 /*
username=smsincome1
password=mgis-11178
text=message to be sent, must be urlencoded
to=12 digit mobile number starting with 91
from=
dlr-mask=19
dlr-url=the url to which delivery report is to be posted, must be urlencoded

Sample Send SMS call : http://203.212.70.200/smpp/sendsms?username=smsincome1&password=abcd1234&to=919653369000&from=919653369000&text=test+sms&dlr-mask=19&dlr-url=

Receiving Delivery Reports
Create a page on your website, which will receive the delivery reports, and pass it in the "dlr-url" parameter of send sms call.
Sample dlr-url : http://domain/status.php?msg_id=1234567890&to=%p&time=%t&status=%d&reason=%2
Please Note : In the dlr-url, you will need to pass your own unique value for msg_id parameter, to identify the message.
*/
 		 
		$request =""; //initialise the request variable
		$param['username']	= "webzone1";
 		$param['password'] 	= "ultimate123";
 		$param['to'] 		= $mobilenumbers; //"919xxxxxxxxx"; 
		$param['from'] 		= "ULTIMATE";
 		$param['text'] 		= $message; //"Hello";
		$param['dlr-mask'] 	= "19"; //Can be "19�
		$param['dlr-url'] 	= "http://ultimatepower5.com/sms_test_report.php?msg_id=$msg_id&to=%p&time=%t&status=%d&reason=%2";
		//Have to URL encode the values
 		foreach($param as $key=>$val) {
			$request.= $key."=".urlencode($val);
		//$request.= $key."=". $val ;
		//we have to urlencode the values
		$request.= "&";
		//append the ampersand (&) sign after each parameter/value pair
		}
		$request = substr($request, 0, strlen($request)-1);
		//remove final (&) sign from the request
		$url = "http://203.212.70.200/smpp/sendsms?".$request;
	 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch);
		return $curl_scraped_page;
	 
	 ///////////////////////////////////
 	 }
 }

function send_sms_webzone($mobilenumbers,$message) {
 
 if ($mobilenumbers!='' && $message!='') {
//Please Enter Your Details
 $user=""; //Your Id Number
 $password=""; //your password
 #$mobilenumbers="919XXXXXXXXX"; //enter Mobile numbers comma seperated
 #$message = "test messgae"; //enter Your Message 
 $senderid=""; //Your senderid
 $messagetype="N"; //Type Of Your Message
 $DReports="Y"; //Delivery Reports
 #$url="http://www.smscountry.com/SMSCwebservice.asp";
 #$url="api.smscountry.com/SMSCwebservice_bulk.aspx";
  $url="http://sms.webzonetechnology.com/WebServiceSMS.aspx";
 $message = urlencode($message);
 $ch = curl_init(); 
 if (!$ch){die("Couldn't initialize a cURL handle");}
 $ret = curl_setopt($ch, CURLOPT_URL,$url);
 curl_setopt ($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
 curl_setopt ($ch, CURLOPT_POSTFIELDS, 
"User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
 $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

 

 $curlresponse = curl_exec($ch); // execute
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
 		$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
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
	  if ($line_you[u_id]!='') {
		return '<span  style="color:#09A701">'.$line_you[u_fname].'</span>';
	} else {
		return '<span class="error">Username Does not exist!</span>';
	}
}

function get_referal_details($name='referal_details',$ref_userid) {
	//check uesrname availability
 	if ($ref_userid!='') { $sql_part = " and u_username= '$ref_userid' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select u_id, u_fname from ngo_users where 1 $sql_part ";
	$result_you  = db_query($sql_you);
	$line_you   = mysqli_fetch_array($result_you );
	 //return "OK" .$line_you[u_id];
	if ($line_you[u_id]!='') {
		return '<span  style="color:#09A701">'.$line_you[u_fname].'</span>';
	} else {
		return '<span class="error">Username Does not exist!</span>';
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
	$arr = array('' => 'Please Select', 'Paid' => 'Paid', 'Unpaid' => 'Unpaid');
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
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysqli_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
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
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysqli_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
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

function direct_total_business_date_range($userid ,$sql_part){
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



function get_username_details($name='username_details',$username) {
	//check uesrname availability
	 
	if ($username!='') { $sql_part = " and u_username= '$username' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
	$sql_you  = "select u_id,u_fname from ngo_users where 1 $sql_part ";
	$result_you  = db_query($sql_you);
	$line_you   = mysqli_fetch_array($result_you );
	 //return "OK" .$line_you[u_id];
	if ($line_you[u_id]!='') {
		return 'Username <span class="error">(Not Available)</span>';
	} else {
		return 'Username <span class="error">(Available)</span>';
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
		return "<span class='error'>Referral  : $line_you[u_fname] </span>" ;
	} else {
		return '<span class="error">Wrong Referral Information</span>';
	}
  	
}





?>