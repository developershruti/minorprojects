<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
$u_ref_userid = 1;
$u_sponsor_id =1;
//$u_ref_side = 'A';
 while ($ctr <=9) {
 $ctr++;
 		//if ($id!='') { $u_ref_userid = $id; } 
		 /* $direct_count = db_scalar("select count(*) from ngo_users where u_ref_userid='$u_ref_userid' ");
			if ($direct_count<=2) {
				$u_power_x = db_scalar("select u_power_x from ngo_users where u_id='$u_ref_userid' ");
			} else {  
				$u_power_x = $u_ref_userid;
			}
			*/
			
 		//$u_sponsor_id = get_sponsor_id($u_ref_userid,$u_ref_side);
		$u_parent_id = db_scalar("select u_parent_id from ngo_users  order by u_id desc limit 0,1")+rand(1,9);
		$u_username = 'BS'.rand(10,99).$u_parent_id;
		$u_ref_side='A';
		$sql = "insert into ngo_users set u_parent_id = '$u_parent_id',u_username='$u_username' ,u_sponsor_id = '$u_sponsor_id' ,u_ref_userid = '$u_ref_userid' ,u_ref_side='$u_ref_side' , u_password = '123z@z654', u_password2 = '123z@z654', u_email = 'info@bigson.live'  , u_fname = 'Big Son', u_lname = '$u_lname' ,u_address = 'Address', u_city = 'city', u_state = 'state', u_postalcode = '$u_postalcode' , u_phone = '$u_phone', u_mobile = '80000000009', u_status = 'Active', u_verify_email_status = 'Verified' ,u_admin='$_SESSION[sess_admin_login_id]', u_date= ADDDATE(now(),INTERVAL 330 MINUTE),u_last_login=ADDDATE(now(),INTERVAL 330 MINUTE)";
	 	db_query($sql);
		
		/*
		 $id = mysqli_insert_id();
		$topup_userid =$id ; 
		$result_topup 	= db_query("select * from ngo_users_type  where utype_id = '1'");
		$line_topup  	= mysqli_fetch_array($result_topup);
		$topup_rate 	= $line_topup['utype_formula']; 
		$topup_days_for = $line_topup['utype_value'];
		$topup_amount 	= $line_topup['utype_charges']*2;
		$topup_amount2 	= $line_topup['utype_charges'];
			
  			 
  		$sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid' , topup_by_userid='$topup_userid',topup_serialno='$u_slno', topup_code='$u_code', topup_plan='TOPUP' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate' ,topup_amount='$topup_amount' ,topup_amount2='$topup_amount2',topup_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_exp_date= ADDDATE(now(),INTERVAL '$topup_days_for' DAY) ,topup_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_status='Unpaid' ";
		db_query($sql);
		//$topup_id = mysqli_insert_id(); 
		*/
		
		print "<br>====".$id ; 
	}
 
?>
 