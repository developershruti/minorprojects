<?
include ("includes/surya.dream.php"); 

/*
$arr_error_msgs[] =  "Hello Everyone some good news comming soon! Right now we are upgrading our system... please allow some time for it. Thank you Team Rozipay" ;
$_SESSION['arr_error_msgs'] = $arr_error_msgs;
header("Location: login.php");
exit;

*/
 #header("location: registration_stop.php");
 #exit;
 
 //print_r($_POST);
//@extract($_POST);
//and  u_status!='Banned' and  u_status='Active' 
if ($username=='guest' && $password=='123456') {
	$_SESSION['sess_guest'] = $username;
 	if ($_SESSION['sess_back']!='') {
		header("location: ".$_SESSION['sess_back']);
		$_SESSION['sess_back']='';	
		exit;	
	} else {
		 header("location: index.php");
		 exit;	
	}
}

 	/* if ($_POST['conf_num3']!=$_SESSION['conf_num3']){ 
		$arr_error_msgs[] ="Captcha string does not match"; 
		$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		header("Location: login?a=sign-in");
		exit;
	} */
 

	$username = ms_form_value($username);
	$password = ms_form_value($password);
	/* if ($captcha!=$_SESSION['CAPTCHA_CODE']){ 
		$arr_error_msgs[] ="Captcha string does not match"; 
 	} */
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
	
	if (count($arr_error_msgs) ==0) {  
  	$sql = "select * from ngo_users where u_username = '$username'  "; ///(u_username = '$username' OR u_email = '$username')
  
 
	$result = db_query($sql);
	if ($line= mysqli_fetch_array($result)) {
		@extract($line);
		 
	
     		if ($u_password==$password ) {
			if($u_status=='Banned') {
			$_SESSION['sess_blocked_msg'] = $u_blocked_msg;
			header("location: blocked_account.php");
			exit;
		}
			$_SESSION['sess_uid'] 		= $u_id;
			$_SESSION['sess_username'] 	= $u_username;
			$_SESSION['sess_mobile'] 	= $u_mobile;
			$_SESSION['sess_email']		= $u_email;
			$_SESSION['sess_fname']		= $u_fname;
			$_SESSION['sess_date']		= $u_date;
			$_SESSION['sess_status']	= $u_status;
			///$_SESSION['sess_security_code'] = $u_password2;
			///$_SESSION['sess_group']	= $u_group;
			$_SESSION['sess_verify_email_status'] = $u_verify_email_status;
			$_SESSION['sess_group']		= 1;
			$_SESSION['sess_rank']		= $u_rank_id;
			$_SESSION['sess_BEP20']		= rand(1,5);
			$_SESSION['CAPTCHA_CODE'] = NULL; /// RESET CAPTCHA CODE FROM SESSION AFTER SUCCESSFUL LOGIN
			
 /// set cookie for remember 
  if(!empty($_POST["remember"])) {
	setcookie ("username",encryptor('encrypt', $_POST["username"]),time()+ 3600);
	setcookie ("password",encryptor('encrypt', $_POST["password"]),time()+ 3600);
	setcookie ("remember",encryptor('encrypt', $_POST["remember"]),time()+ 3600);
	/*echo "Cookies Set Successfuly";
	exit;*/
} /*else {
	setcookie("username","");
	setcookie("password","");
	echo "Cookies Not Set";
}*/
			
			
  			
			//sk $ip =  gethostbyaddr($_SERVER['REMOTE_ADDR']);
 			$ip =  $_SERVER['REMOTE_ADDR'];
 			
			 /*$sql = "update ngo_users set u_last_login=now() ,u_last_login_ip='$ip' where u_id = '$u_id'  ";
 			 $result = db_query($sql);
			
			$sql_log = "insert into ngo_login_log set log_userid='$u_id', log_ip='$ip', log_date=now()    ";
			 $result = db_query($sql_log);*/
 			
 			if ($_SESSION['sess_back']!='') {
			 	header("location: ".$_SESSION['sess_back']);
				$_SESSION['sess_back']='';	
				exit;	
			} else {
 				header("location:userpanel/myaccount.php");
				exit;	
 			}
			
		} else {
 		$arr_error_msgs[] =  "Invalid User ID / Email / Password try again!" ;
		$_SESSION['arr_error_msgs'] = $arr_error_msgs;
			header("Location: login.php");
	        exit;
		}
 	} else { 
		$arr_error_msgs[] =  "Invalid User ID / Email / Password  or Inactive account!" ;
		$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		header("Location: login.php");
		exit;
}
 } else {
		header("Location: login.php");
		exit;
 }
?>
