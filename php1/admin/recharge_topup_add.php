<?

require_once('../includes/surya.dream.php');

//print date(Ymdhms);

protect_admin_page2();

if(is_post_back()) {

$arr_error_msgs =array();
$topup_userid = db_scalar("select u_id from ngo_users where u_username = '$username' ");	
if ($topup_userid =='') { $arr_error_msgs[] =  "Username does not exist!";}
$MINIMUM_INVESTMENT  = 35;
 if ($topup_amount<$MINIMUM_INVESTMENT) { $arr_error_msgs[] = "<br>Minimum investment amount is ". price_format($MINIMUM_INVESTMENT); }


 $topup_amount_active = db_scalar("select count(*) from ngo_users_recharge where topup_userid = '$topup_userid' ");	

 	if ($topup_amount_active>0) {
		$arr_error_msgs[] = "$topup_username account Already activated ";
  }  
  

$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//print_r($arr_error_msgs);

if (count($arr_error_msgs) ==0) { 
/*	if ($topup_amount<=700 ) {
        $topup_rate 	= 1;//5% Daily
        $topup_days_for = 200;	
     }else if ($topup_amount>700 && $topup_amount<=2400) {
        $topup_rate 	= 1;//5% Daily
        $topup_days_for = 300;
     }else if ($topup_amount>2400 && $topup_amount<=5000) {
        $topup_rate 	= 1;//5% Daily
        $topup_days_for = 400;
      }else if ($topup_amount>5000) {
        $topup_rate 	= 1;//5% Daily
        $topup_days_for = 500;
	 }*/
     
   
 if ($topup_userid!='' && $topup_amount>0) { 
		$topup_serialno = rand(10,99).db_scalar("select topup_id from ngo_users_recharge order by topup_id desc limit 0,1").rand(10,99);
    		$topup_code='ADM'.rand(100000,999999);
      
		$topup_amount 	=35; //// actual investment is including GST. 34$
		$topup_amount2 	=$topup_amount;
		$topup_circle = 1;
		$topup_rate =0.00; //1% cashback daily
     $topup_days_for =365; ///200 Days
     

 		//$topup_plan = 'POWER';
   	//	$sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid' ,topup_by_userid='$topup_userid',topup_serialno='$topup_serialno', topup_code='$topup_code', topup_plan='$topup_plan', topup_group='$topup_group' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate' ,topup_amount='$topup_amount' ,topup_date=ADDDATE(now(),INTERVAL 630 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 630 MINUTE) ,topup_status='Paid' ";
   
  
     $sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid',topup_by_userid='0',topup_serialno='$topup_serialno' ,topup_group='C1', topup_code='$topup_code', topup_plan='FREE' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate'   ,topup_amount='$topup_amount' ,topup_amount2='$topup_amount2' ,topup_date=ADDDATE(now(),INTERVAL  330 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 330 MINUTE),topup_exp_date=ADDDATE(now(),INTERVAL 365 DAY)  ,topup_status='Paid' ";

     db_query($sql);
 		$topup_id = mysqli_insert_id($GLOBALS['dbcon']);
		
		$sql11 = "insert into ngo_users_coin_ewallet set  pay_drcr='Cr',  pay_userid = '$topup_userid',pay_refid = '$topup_id' ,pay_plan='BUNCH_POINT' ,pay_group='BPW' ,pay_for = 'Bunch Point on Activation' ,pay_ref_amt='5000' ,pay_unit = 'Fix' ,pay_rate = '100', pay_amount = '5000',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		 
		 db_query($sql11);
			
			
			
  /*////////////////////////////////////////////*/
 	 }		
     ////////////////////////////////
      
	$arr_error_msgs[] =  "Your investment completed successfully!";

}		
 
 	}

	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
 
#header("Location: ".$_SERVER['HTTP_REFERER']);

#exit;

//}



 

 

 

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td id="pageHead"><div id="txtPageHead">Add Investment in a user account </div></td>
 </tr>
</table>
<div align="right"><a href="recharge_topup_list.php">Back to Investment List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
 <input type="hidden" name="check_id" value="<?=$check_id?>"  />
 <table width="90%" border="0" cellpadding="2" cellspacing="2">
  <tr>
   <td width="23%" valign="top" class="maintxt">&nbsp;</td>
   <td width="77%" valign="top" class="errorMsg"><? include("../error_msg.inc.php");?></td>
  </tr>
  <!-- <tr>

             <td align="right" valign="top" class="maintxt">Payment Processor : </td>

             <td valign="top"> <? // echo payment_processor_dropdown($pay_group,$extra); ?></td>

           </tr> -->
  <tr>
   <td align="right" valign="top" class="maintxt"> Username: </td>
   <td valign="top"><input name="username"  type="text"  alt="blank" emsg="Please enter username " /></td>
  </tr> <!-- 
   <tr>
   <td align="right" valign="top" class="maintxt"> Topup Type: </td>
   <td valign="top"> 
   <? //=array_dropdown($ARR_PLAN_TYPE,$topup_plan,'topup_plan',$extra);?>
				  
           
        <select name="topup_plan" id="topup_plan">
          <option value="" >Please Select</option>
				 <option <? if($topup_plan=='TOPUP'){?> selected="selected" <? } ?> value="TOPUP">TOPUP</option>
				 
				  <option <? if($topup_plan=='FREE'){?> selected="selected" <? } ?> value="FREE">FREE</option>
          <option<? if($topup_plan=='ADMIN'){?> selected="selected" <? } ?> value="ADMIN">ADMIN</option>
				  <option <? if($topup_plan=='POWER'){?> selected="selected" <? } ?> value="POWER">POWER</option>
 				   </select> 
            
            </td>
  </tr>
  -->
  <tr>
   <td align="right" valign="top" class="maintxt">Topup Amount: </td>
   <td valign="top"><!--<input name="topup_amount"  type="text"  alt="number" emsg="Please enter topup amount " />-->
    
   <select name="topup_amount" class="form-control  "  id="topup_amount"  alt="select" emsg="Please Select Package"  >

<option value="" >Select Activation Package</option>
<option value="35" <? if($total_investment==35) {?> selected="selected" <? } ?>>Account Activation $35.00</option>
<!--  <option value="20" <? if($total_investment==20) {?>  selected="selected" <? } ?>  >Activation $20.00</option>
<option value="50" <? if($total_investment==50) {?> selected="selected" <? } ?>>Activation $50.00</option>
<option value="100" <? if($total_investment==100) {?>  selected="selected" <? } ?>>Activation $100.00</option>
<option value="200" <? if($total_investment==200) {?>  selected="selected" <? } ?>  >Activation  $200.00</option>
<option value="500" <? if($total_investment==500) {?>  selected="selected" <? } ?>  >Activation $500.00</option>
<option value="1000" <? if($total_investment==1000) {?>  selected="selected" <? } ?>  >Activation $1000.00</option>
<option value="2000" <? if($total_investment==2000) {?>  selected="selected" <? } ?>  >Activation $2000.00</option>
-->
<? 

// Array ( [topup_amount] => 1000 [package] => 16 [user_password] => 111 [Submit] =>   Submit   )

/*$ctr = 1 ;

while ($ctr<=1000 ) { 

$amount = 100*$ctr;*/

?>

<!--<option value="<?=$amount?>" <? if ($amount==$total_investment) { echo 'selected="selected"';} ?>><?=price_format($amount)?> </option>-->

<? /*$ctr++; }*/  ?>

</select>
   </td>
  </tr>
  <tr>
   <td valign="top" class="maintxt"></td>
   <td valign="top"><input name="Submit" type="submit" value="Submit" />
    <br />
    <br />
    <br />
    <span>Note : This topup is applicable for leaders only. ROI WILL NOT BE GENERATE ON POWER AND FEE TYPE TOPUP </span> <br /></td>
  </tr>
 </table>
 <br />
 <br />
</form>
<? include("bottom.inc.php");?>
