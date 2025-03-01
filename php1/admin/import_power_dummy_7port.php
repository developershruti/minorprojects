<?

require_once('../includes/surya.dream.php');
$arr_error_msgs = array();

 
if(is_post_back()) {
@extract($_POST);

/*print_r($_POST);
exit;*/

$u_id = db_scalar("select u_id from ngo_users where u_username='$u_powerid' ");
if ($u_id =='') { $arr_error_msgs[] =  "User ID  does not exist!";}
//if ($u_ref_side =='') { $arr_error_msgs[] =  "Please Select Position";}
/*if ($u_fname =='') { $arr_error_msgs[] =  "Please Enter Dummy Id Name";}*/
if($total_investment!='') {
$MINIMUM_INVESTMENT  = 25;
if ($total_investment<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Minimum investment amount is ". price_format($MINIMUM_INVESTMENT); }
}
$u_total_id=20;
if ($u_total_id =='' && $u_total_id==0) { $arr_error_msgs[] =  "Please enter No. Of Dummy Power Id";}
$_SESSION['arr_error_msgs'] = $arr_error_msgs;

if (count($arr_error_msgs) ==0) {
$array_counter = array();
 	///$u_ref_userid = 1;
	
	$u_ref_userid = $u_id;
	///$u_ref_side = 'A';
	$u_ref_side ='A'; // $u_ref_side;
	while ($ctr <$u_total_id) {
	$ctr++;
 //if ($id!='') { $u_ref_userid = $id; } 
 		if($ctr>4){
			$u_ref_userid = $array_counter[$ctr]['u_ref_userid'];
 		}
 		
 		$u_parent_id = db_scalar("select u_parent_id from ngo_users  order by u_id desc limit 0,1")+1;
 		$u_username = 'MB'.rand(1,9).$u_parent_id.rand(10,99);
 		  
  		$sql = "insert into ngo_users set  u_parent_id = '$u_parent_id',u_username='$u_username',u_sponsor_id = '$u_ref_userid' ,u_ref_userid = '$u_ref_userid' ,u_ref_side='$u_ref_side' , u_password = 'mtb123#', u_password2 = '123456', u_email = '$u_email' , u_fname = '$u_fname', u_lname = '$u_lname' ,u_address = 'Address', u_city = '$u_city', u_state = '$u_state', u_postalcode = '$u_postalcode' , u_phone = '$u_phone', u_mobile = '$u_mobile',u_panno='$u_panno' , u_bank_name='$u_bank_name', u_bank_acno='$u_bank_acno', u_bank_branch='$u_bank_branch' ,u_bank_ifsc_code='$u_bank_ifsc_code',u_remark='$u_remark'  ,u_admin='$_SESSION[sess_admin_login_id]' ,u_status='Active' , u_date= ADDDATE(now(),INTERVAL 750 MINUTE),u_last_login=ADDDATE(now(),INTERVAL 750 MINUTE)";
	 	db_query($sql);
	 	///$id = mysql_insert_id();
		$id = mysqli_insert_id($GLOBALS['dbcon']);
		
		if($ctr==1) {
			$array_counter['5']['u_ref_userid'] = $id;
 			$array_counter['6']['u_ref_userid'] = $id;
			$array_counter['7']['u_ref_userid'] = $id;
			$array_counter['8']['u_ref_userid'] = $id;
 		} else if($ctr==2) {
			$array_counter['9']['u_ref_userid'] = $id;
 			$array_counter['10']['u_ref_userid'] = $id;
			$array_counter['11']['u_ref_userid'] = $id;
			$array_counter['12']['u_ref_userid'] = $id;
 		} else if($ctr==3) {
			$array_counter['13']['u_ref_userid'] = $id;
 			$array_counter['14']['u_ref_userid'] = $id;
			$array_counter['15']['u_ref_userid'] = $id;
			$array_counter['16']['u_ref_userid'] = $id;
  		} else if($ctr==4) {
			$array_counter['17']['u_ref_userid'] = $id;
 			$array_counter['18']['u_ref_userid'] = $id;
			$array_counter['19']['u_ref_userid'] = $id;
			$array_counter['20']['u_ref_userid'] = $id;

		}
		
		
/*print "<pre>";
		print_r($array_counter);
		print "</pre>"; */
		
		
		print "<br>====Auto Id :&nbsp;".$id."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Username&nbsp;&nbsp;:&nbsp;".$u_username."&nbsp;&nbsp;&nbsp;With Topup Amount&nbsp;&nbsp;".price_format($total_investment)."&nbsp;&nbsp;&nbsp;&nbsp;Dummy Id Generated Successfully" ; 
 		
		if($total_investment>0) { 
 		$topup_amount 	=25; //// actual investment is including GST. 30$
 		$topup_amount2 	=$total_investment;
 		$topup_circle = 1;
 		$topup_rate =0.00; //1% cashback daily
  		$topup_days_for =365; ///200 Days
     	 $sql = "insert into  ngo_users_recharge set topup_userid = '$id',topup_by_userid='$id',topup_serialno='0' ,topup_group='POWER', topup_code='$topup_code', topup_plan='POWER' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate'   ,topup_amount='$topup_amount' ,topup_amount2='$topup_amount2' ,topup_date=ADDDATE(now(),INTERVAL  570 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 570 MINUTE),topup_exp_date=ADDDATE(now(),INTERVAL 365 DAY)  ,topup_status='Paid' ";
 		db_query($sql);
		}
 	}
 }
 	//header("Location: news_list.php");
 	//exit;
}


/*
$news_id = $_REQUEST['news_id'];
 if($news_id!='') {
 	$sql = "select * from ngo_news where news_id = '$news_id'";
 	$result = db_query($sql);
 	if ($line_raw = mysqli_fetch_array($result)) {
 		//$line = ms_form_value($line_raw);
 		@extract($line_raw);
 	}
 }*/
 ?>

<link href="styles.css" rel="stylesheet" type="text/css">
 
<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td id="pageHead"><div id="txtPageHead"> Add Dummy Power Id  </div></td>

  </tr>

</table>

<div align="right"><a href="import_power_dummy_id.php">Import/Add Dummy Power Id </a>&nbsp;</div>

<form name="registration" method="post" enctype="multipart/form-data" <?= validate_form()?>>

<p><? include("../error_msg.inc.php");?></p><br>
  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">

  
 

    <tr>

      <td width="90" align="left" class="tdLabel">Main/Parent Power Username :</td>

      <td width="500" class="tdData"><input name="u_powerid" type="text" id="u_powerid" value="<?=$u_powerid?>"  alt="blank" emsg="Please enter parent Id" onChange="do_get_referal_details();"  class="textfield">
	  
	 <div align="left" id="referal_details" class="error"> </div>
	  </td>

    </tr>
	<!--<tr>

      <td width="90" align="left" class="tdLabel">Placement Side : </td>

      <td width="500" class="tdData"><select name="u_ref_side" id="u_ref_side"  alt="select" class="textfield"  emsg="Please Select Position">
									<option value="">Select Placement Side</option>
									<option <? if($u_ref_side=='A') {?> selected="selected" <? } ?> value="A">Left Side</option>
									 <option <? if($u_ref_side=='B') {?> selected="selected" <? } ?> value="B">Right Side</option>
			  </select>
									 <? ///=make_radios($ARR_POSSITION, 'u_ref_side', $u_ref_side = '', 2,	'', $style	= 'height:10px; ', $tableattr = ' ')?></td>

    </tr>
	<tr>

      <td width="90" align="left" class="tdLabel">No. Of Dummy Power Id :</td>

      <td width="500" class="tdData"><input name="u_total_id" type="text" id="u_total_id" value="<?=$u_total_id?>"  alt="blank" emsg="Please enter No.Of Dummy Power Id" class="textfield"></td>

    </tr>-->
	<tr>

      <td width="90" align="left" class="tdLabel">Dummy Power Id's Name:</td>

      <td width="500" class="tdData"><input name="u_fname" type="text" id="u_fname" value="<?=$u_fname?>"  emsg="Please enter Dummy Power Id's Name" class="textfield"></td>

    </tr>
	<tr>

      <td width="90" align="left" class="tdLabel">Dummy Power Id's Mobile:</td>

      <td width="500" class="tdData"><input name="u_mobile" type="text" id="u_mobile" value="<?=$u_mobile?>"    emsg="Please enter Dummy Power Id's Mobile" class="textfield"></td>

    </tr>
	<tr>

      <td width="90" align="left" class="tdLabel">Dummy Power Id's Email Id:</td>

      <td width="500" class="tdData"><input name="u_email" type="text" id="u_email" value="<?=$u_email?>"   emsg="Please enter Dummy Power Id's Email Id" class="textfield"></td>

    </tr>
 
<tr>

      <td width="90" align="left" class="tdLabel">Dummy Topup/Package Amount :</td>

      <td width="500" class="tdData">
	  <input name="total_investment"  type="text" class="form-control"   value="25<?//=$total_investment?>" placeholder="$25 & Above"   emsg="Please enter minimum amount $25"     /> 
	  
	  
	  
	 <?php /*?> <select name="total_investment" class="textfield"  id="total_investment"     >
                                    <option value="" >Select Package</option>
                                   <!-- <option value="1000" <? if($total_investment==1000) {?>  selected="selected" <? } ?>  >Working Activation Rs. 1000.00</option>-->
									 <option value="7000" <? if($total_investment==7000) {?>  selected="selected" <? } ?>  >Package Rs. 7000.00</option>
									 <option value="35000" <? if($total_investment==35000) {?>  selected="selected" <? } ?> >Package Rs. 35000.00</option>
									  <option value="70000" <? if($total_investment==70000) {?>  selected="selected" <? } ?> >Package Rs. 70000.00</option>
									  <option value="175000" <? if($total_investment==175000) {?>  selected="selected" <? } ?> >Package Rs. 175000.00</option>
									    <option value="350000" <? if($total_investment==350000) {?>  selected="selected" <? } ?> >Package Rs. 350000.00</option>
                                     <? 
 					// Array ( [topup_amount] => 1000 [package] => 16 [user_password] => 33333 [Submit] =>   Submit   )
 					$ctr = 1 ;
					while ($ctr<=100 ) { 
					$amount = 100*$ctr;
					
					
					?>
					<option value="<?=$amount?>" <? if ($amount==$total_investment) { echo 'selected="selected"';} ?>><?=price_format($amount)?> </option>
					<? $ctr++; }  ?> 
                                     
                                  </select><?php */?></td>

    </tr>
     

     
 <?php /*?><tr>

    <td width="81" align="left" class="tdLabel">Desc:</td>

      <td  class="tdData"><!--<textarea name="news_desc" cols="100" rows="15" class="textfield" id="news_desc" alt="blank"><?=$news_desc?></textarea>-->

        <?=get_fck_editor("news_desc", $news_desc)?></td>

    </tr><?php */?>

    <tr>

      <td class="tdLabel">&nbsp;</td>

      <td class="tdData"><input type="hidden" name="news_id" value="<?=$news_id?>">

        <input type="image" name="imageField" src="images/buttons/submit.gif" /></td>

    </tr>

  </table>

</form>

<? include("bottom.inc.php");?>

