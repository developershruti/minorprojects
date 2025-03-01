<?php
include ("../includes/surya.dream.php");
protect_user_page();
 
if(is_post_back()) {
$arr_error_msgs = array();

/*
[account_balance] => 6600
[bid_amount] => 100
[total_bid_amount] => 200
*/
/*
print "<pre>";
print_r($_POST);
print "</pre>"; 
*/
	
$post_bet = $_POST;	
	 
$acc_balance =  db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='CW'")+0;
 
if ($acc_balance <1) { 
  	$arr_error_msgs[] =  "Insufficient account balance for transfer" ;  
 	$stop='stop';
} 

if ($acc_balance<$total_bid_amount) { $arr_error_msgs[] = "Insufficient account balance for bid"; } 
if ($total_bid_amount<=0) { $arr_error_msgs[] = "Invalid total bid amount"; } 

$_SESSION['arr_error_msgs'] = $arr_error_msgs;

#print " $acc_balance  : $total_bid_amount ";
if (count($arr_error_msgs) ==0) {
 
 	//$trade_count =  db_scalar("SELECT  count(*) FROM ngo_users_ewallet where pay_userid = '$_SESSION[sess_uid]' and pay_group='CW' and pay_plan='BIDING' and pay_transaction_no='$ref_bid_gameno'" )+0;
	$trade_count =  db_scalar("SELECT  pay_id FROM ngo_users_ewallet where pay_userid = '$_SESSION[sess_uid]' and pay_group='CW' and pay_plan='BIDING' and pay_transaction_no='$ref_bid_gameno' limit 0,1" )+0;
	if($trade_count!='') {
		$trade_sum =  db_scalar("SELECT  sum(pay_amount) FROM ngo_users_ewallet where pay_userid = '$_SESSION[sess_uid]' and pay_group='CW' and pay_plan='BIDING' and pay_transaction_no='$ref_bid_gameno'" )+0;
		
			$total_bid_amount = $total_bid_amount-$trade_sum;
	}
	
	if($total_bid_amount>0){
 	$pay_for1 = "Play Predict Point Deducted # $ref_bid_gameno";
	$sql1 = "insert into ngo_users_ewallet set  pay_drcr='Dr',  pay_userid = '$_SESSION[sess_uid]'  ,pay_plan='BIDING' ,pay_group='CW' ,pay_for = '$pay_for1' ,pay_ref_amt='$total_bid_amount' ,pay_unit = 'F',pay_rate = '100', pay_amount = '$total_bid_amount' ,pay_transaction_no='$ref_bid_gameno' ,pay_status='Unpaid' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
	db_query($sql1);
 	$pay_refid = mysqli_insert_id($GLOBALS['dbcon']);	
		/// income
	
	 
  						$u_ref_userid = $_SESSION['sess_uid'];
 						$ctr=0;
						$pay_amount= ($total_bid_amount/100)*5;
						while ($ctr<9) { 
						$ctr++;
 						$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
						if ($u_ref_userid!='' && $u_ref_userid!=0 ){
						$ref_acc_balance =  db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_ewallet where pay_userid='$u_ref_userid' and pay_group='CW'")+0;
						if($ref_acc_balance>=1000) {
 							if($ctr==1)		{ $pay_rate =25;}
							else if($ctr==2){ $pay_rate =20;}
							else if($ctr==3){ $pay_rate =15;}
							else if($ctr==4){ $pay_rate =5;}
							else if($ctr==5){ $pay_rate =3;}
							else if($ctr==6){ $pay_rate =2;}
							else if($ctr==7){ $pay_rate =2;}
							else if($ctr==8){ $pay_rate =2;}
							else if($ctr==9){ $pay_rate =1;}
						 					
					$direct_required = $ctr;
					$total_direct_refcount=db_scalar("select count(*) from ngo_users_recharge,ngo_users  where  topup_userid=u_id  and u_status='Active' and topup_status='Paid' and u_ref_userid='$u_ref_userid'")+0;
					
					$pay_amount_ref = ($pay_amount/100)*$pay_rate;
					if ($total_direct_refcount>=$ctr && $pay_amount_ref>=0.1) {
							
 							$pay_for ="Play Predict Reward Level $ctr - $_SESSION[sess_username]";
							$sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$pay_refid' ,pay_plan='TRADE_LEVEL' ,pay_group='WI' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount_ref' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='BET' ";
							db_query($sql2);
						 }
						} 
					}
			 }
			 
			 
	}	
		
		////end ////
//	total_bid_amount
	$bid_datetime = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE) ");
	$bid_today_count = db_scalar("select  (count(*)+1) as total from ngo_users_bid_history where bid_date =DATE_FORMAT( ADDDATE(now(),INTERVAL 330 MINUTE) , '%Y-%m-%d') ");
	if($bid_today_count<=9) {$bid_no='00'.$bid_today_count;} 
	else if($bid_today_count>=10 && $bid_today_count<=99) {$bid_no='0'.$bid_today_count;}
	else if($bid_today_count>=100 ) {$bid_no= $bid_today_count;}
	$bid_gameno =  date("Ymd",strtotime($bid_datetime)).$bid_no;
		
  	foreach ($post_bet as $bid_plan=> $bid_amount_full) {
	// deduction 5% amount from biding amount
	$bid_amount = ($bid_amount_full/100)*95;
	
	$plan_name = substr($bid_plan,0,4);
	$plan_no   = substr($bid_plan,4,2) ;
	//$plan_no2  = substr($bid_plan,4,6) ;
	$plan_no3  = trim(substr($bid_plan,4,10)) ;
	$bid_rate =10;
	if ($bid_amount>0 && $plan_name =='plan') {
	 // set bid amount  blank
		$bid_0=$bid_1=$bid_2=$bid_3=$bid_4=$bid_5=$bid_6=$bid_7=$bid_8=$bid_9=0;
 		//  print " <br> $bid_plan ==> $plan_no :  $plan_no2 :  $plan_no3  : $bid_amount ";
   		if ($plan_no>=0 && $plan_no<=9 && is_numeric($plan_no)) {
 			$bid_coulmn  = 'bid_'.$plan_no;  
			$$bid_coulmn = $bid_amount+0;
			$bid_rate =10;
 		 /// print " <br>". 
		  $sql = "insert into ngo_users_bid set  bid_userid = '$_SESSION[sess_uid]'  ,bid_plan='$bid_plan',bid_gameno='$bid_gameno' ,bid_amount = '$bid_amount' ,bid_rate='$bid_rate' ,bid_0='$bid_0' ,bid_1='$bid_1' ,bid_2='$bid_2'  ,bid_3='$bid_3' ,bid_4='$bid_4' ,bid_5='$bid_5' ,bid_6='$bid_6' ,bid_7='$bid_7' ,bid_8='$bid_8' ,bid_9='$bid_9' ,bid_status='New' ,bid_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,bid_draw_date=ADDDATE(now(),INTERVAL 333 MINUTE) ,bid_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		 $result = db_query($sql);
		  
 		 $$bid_coulmn ='';
		// plan1st12 plan2nd12 plan3rd12
		//$plan_no3=='1to18' || $plan_no3=='19to36' ||  
 		} else if ($plan_no3=='black_num' || $plan_no3=='red_num' || $plan_no3=='silver_num') {
			 // print " <br> Plan > $plan_no2 :    $bid_plan :  = $bid_amount ";
 			if($plan_no3=='black_num') {  $bid_2=$bid_4=$bid_6=$bid_8 = $bid_amount/5;   $bid_0=$bid_amount/6.66667;}
			else if($plan_no3=='red_num') { $bid_1=$bid_3=$bid_7=$bid_9 = $bid_amount/5; $bid_5=$bid_amount/6.66667;}
			else if($plan_no3=='silver_num') { $bid_0=$bid_5 = $bid_amount/2; }
				$bid_rate =10; 
				//if($winning_number==5) { $prediction_amount= $line_pred['bid_amount']*0.5; } else {$prediction_amount= $line_pred['bid_amount']*1;}
				
				$bid_desc = $ARR_BID_PLAN[$plan_no3];
				$sql = "insert into ngo_users_bid set  bid_userid = '$_SESSION[sess_uid]'  ,bid_plan='$bid_plan' ,bid_gameno='$bid_gameno',bid_amount = '$bid_amount' ,bid_rate='$bid_rate' ,bid_0='$bid_0' ,bid_1='$bid_1' ,bid_2='$bid_2'  ,bid_3='$bid_3' ,bid_4='$bid_4' ,bid_5='$bid_5' ,bid_6='$bid_6' ,bid_7='$bid_7' ,bid_8='$bid_8' ,bid_9='$bid_9' ,bid_status='New' ,bid_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,bid_draw_date=ADDDATE(now(),INTERVAL 333 MINUTE) ,bid_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
				$result = db_query($sql);
 		}
		  $plan_no='';
			/////////////////////
 		$sql2 = "insert into ngo_users_bid_list set  bid_userid = '$_SESSION[sess_uid]'  ,bid_plan='$bid_plan',bid_gameno='$bid_gameno' ,bid_amount = '$bid_amount' ,bid_rate='$bid_rate',bid_status='New' ,bid_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,bid_draw_date=ADDDATE(now(),INTERVAL 333 MINUTE) ,bid_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
		$result = db_query($sql2);
  	   }
	}
	
	 header("location: bid_options.php");
	 exit;
	
 }
}

$acc_balance =  db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='CW' ");
#$acc_balance2 =  db_scalar("SELECT  (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as Balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]'   ");


$bid_datetime = db_scalar("select   ADDDATE(bid_datetime ,INTERVAL 3 MINUTE)   from ngo_users_bid_history  order by bid_hid desc limit 0,1 ");
$bid_datetime2 = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE)  ");
$dateFrom = date("d-m-Y H:i:s",strtotime($bid_datetime));
$dateTo = date("d-m-Y H:i:s", strtotime($bid_datetime2));
 //print "<br><br><br> == Date :  $dateFrom | $dateTo ";
 
 if($dateFrom>$dateTo){  
 //print "<br><br><br> == Date :  OK ";
 
$start_date = new DateTime($dateFrom);
$since_start = $start_date->diff(new DateTime($dateTo));
/* echo $since_start->days.' days total<br>';
echo $since_start->y.' years<br>';
echo $since_start->m.' months<br>';
echo $since_start->d.' days<br>';
echo $since_start->h.' hours<br>';
echo $since_start->i.' minutes<br>';
echo $since_start->s.' seconds<br>';
echo $since_start->s + ($since_start->i*60).' Total seconds<br>';*/
 
$sess_total_time = $since_start->s +($since_start->i*60)+5;
} else{
$sess_total_time =0;

}


$bid_datetime = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE) ");
$bid_today_count = db_scalar("select  (count(*)+1) as total from ngo_users_bid_history where bid_date =DATE_FORMAT( ADDDATE(now(),INTERVAL 330 MINUTE) , '%Y-%m-%d') ");
if($bid_today_count<=9) {$bid_no='00'.$bid_today_count;} 
else if($bid_today_count>=10 && $bid_today_count<=99) {$bid_no='0'.$bid_today_count;}
else if($bid_today_count>=100 ) {$bid_no= $bid_today_count;}
$bid_gameno =  date("Ymd",strtotime($bid_datetime)).$bid_no;
	
	
	
//if ($sess_total_time==0) {$sess_total_time =120;} 
 
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
<head>
<? include("includes/extra_head.php")?>
<style> 
table .td_box {   /*border:solid 1px #4841ed;*/   } 
table {  /* border:solid 1px #4841ed; */  } 
table .td_box tr { /* border-top: solid 1px #4841ed; border:solid 1px #4841ed; */  }  
table .td_box tr td {  /* border:solid 1px #4841ed; */  }
td { vertical-align:middle; }


  .bubble { 

	clear:both;
	display:inline-table;
 	position:relative;
 	font-size:20px;
	padding:1px 6px 1px 3px;
	line-height:12px;
	font-weight:bold;
	letter-spacing:-1px;
	top:0px;
	right:0px;
	z-index:90; 
	cursor:pointer!important;
 	color:#FF0808;
 	/*
	border:1px solid #b20606;
 	border-radius: 7px;
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;	
	background:#ff2e2e;
	background: -moz-linear-gradient(top,#ff2e2e,#c80606);
	background: -webkit-gradient(linear, left top, left bottom, from(#ff2e2e), to(#c80606));*/
}

.bubble:hover { background:#000!important; } 

</style>
<script language="javascript">

function update_bidvalueAAA(element) {
	//alert(element);
	alert(document.getElementByName('black_number').Value);
 	//current_value = document.bid_form.element.value;
	//bid_amount = document.bid_form.bid_amount.value;
 	//document.bid_form.element.value=current_value+bid_amount;
	 
 }
</script>
<script type="text/javascript">
	function update_bidvalue(plan,elem)
	{
		//alert("OK...");
 		var element 		= document.getElementById(elem);
 		var plan_amount 	= document.getElementById(plan).value;
		var bid_amount 		= document.bid_form.bid_amount.value ;
  		var account_balance = document.bid_form.account_balance.value;
 		
 		if (account_balance <  parseInt(bid_amount)) {
			alert("Insuficient account balance for bid.");
			return true;
		}
		
		element.innerHTML =  parseInt(bid_amount)+ parseInt(plan_amount); 
		
 		//document.bid_form.PLAN3.value =parseInt(bid_amount)+ parseInt(total_amount);
		document.getElementById(plan).value =parseInt(bid_amount)+ parseInt(plan_amount);
 		
		document.bid_form.account_balance.value -= parseInt(bid_amount);
		document.getElementById('acc_balance').innerHTML = document.bid_form.account_balance.value;
		
		var total_bid_amount = document.bid_form.total_bid_amount.value ;
 		document.bid_form.total_bid_amount.value  = parseInt(bid_amount)+ parseInt(total_bid_amount);
		document.getElementById('total_bid_amt').innerHTML = document.bid_form.total_bid_amount.value;
		
 		//var account_balance = parseInt( document.bid_form.account_balance.value) - (parseInt(bid_amount)+ parseInt(total_amount));
 		
		/*
		alert(document.bid_form.total_bid_amount.value);
 		alert(elem)
		element.innerHTML = " Rs."+ bid_amount+total_amount ;
 		document.bid_form.black_number.value = bid_amount+total_amount;
		*/
		
 	}

function update_bid_amount(elem,bid_amount)
	{
	 document.getElementById('bid_amt1').src= "images/number/bid_amt1a.png";
	document.getElementById('bid_amt5').src= "images/number/bid_amt5a.png";
 	 
	document.getElementById('bid_amt10').src= "images/number/bid_amt10a.png";
	document.getElementById('bid_amt50').src= "images/number/bid_amt50a.png";
 	document.getElementById('bid_amt100').src= "images/number/bid_amt100a.png";
	document.getElementById('bid_amt500').src= "images/number/bid_amt500a.png";
 	document.getElementById('bid_amt1000').src= "images/number/bid_amt1000a.png";
	/*document.getElementById('bid_amt5000').src= "images/number/bid_amt5000a.png";
 	document.getElementById('bid_amt10000').src= "images/number/bid_amt10000a.png";
	document.getElementById('bid_amt50k').src= "images/number/bid_amt50ka.png";
	document.getElementById('bid_amt100k').src= "images/number/bid_amt100ka.png";*/
  	document.bid_form.bid_amount.value = parseInt(bid_amount); 
	document.getElementById(elem).src= "images/number/"+elem+"b.png";
	//alert(document.bid_form.bid_amount.value);
	}


	function validate() {
		return true;
	}
 </script>
<script type="text/javascript">
	function countDown(secs, elem)
	{
		var element = document.getElementById(elem);
	   // element.innerHTML = "<h2>You have <b>"+secs+"</b> seconds to answer the questions</h2>";
		element.innerHTML =  secs +" Sec" ;
 		document.bid_form.result_elapsed_time.value = secs;
 		
 		if(secs < 1) {
			 window.location="bid_options.php";
		}
		else
		{
			secs--;
			setTimeout('countDown('+secs+',"'+elem+'")',1000);
		}
		
		if(secs <= 30) {
  			 document.getElementById('bet_ok').style.display = 'none';
			 document.getElementById('bet_reset').style.display = 'none';
 		}
		
	}

	function validate() {
		return true;
	}
 </script>
<script type="text/javascript">
 
 function bgchange_over(elem) {
 
 	if (elem=='row_rednum') {
   		/*document.getElementById('td1').style.backgroundColor = '#4A9748'; 
		document.getElementById('td3').style.backgroundColor = '#4A9748'; 
		document.getElementById('td5').style.backgroundColor = '#4A9748'; 
		document.getElementById('td7').style.backgroundColor = '#4A9748';
		document.getElementById('td9').style.backgroundColor = '#4A9748'; */
 		document.getElementById('plan_tips').innerHTML ='THIS IS RED BET,WIN BONUS: 1 X 2 = 2';
 	} else if (elem=='row_blacknum') {
   		/*document.getElementById('td0').style.backgroundColor = '#4A9748'; 
		document.getElementById('td2').style.backgroundColor = '#4A9748'; 
		document.getElementById('td4').style.backgroundColor = '#4A9748'; 
		document.getElementById('td6').style.backgroundColor = '#4A9748'; 
		document.getElementById('td8').style.backgroundColor = '#4A9748'; */
		document.getElementById('plan_tips').innerHTML ='THIS IS BLACK BET, WIN BONUS: 1 X 2 = 2';
	 } else if (elem=='row_silvernum') {
   		/*document.getElementById('td0').style.backgroundColor = '#4A9748'; 
		document.getElementById('td5').style.backgroundColor = '#4A9748'; */
 		document.getElementById('plan_tips').innerHTML ='THIS IS EVEN BET, WIN BONUS: 1 X 5 = 2';
 	} else if (elem=='row_oddnum') {
   		/*document.getElementById('td1').style.backgroundColor = '#4A9748'; 
		document.getElementById('td3').style.backgroundColor = '#4A9748'; 
		document.getElementById('td5').style.backgroundColor = '#4A9748'; 
		document.getElementById('td7').style.backgroundColor = '#4A9748';
		document.getElementById('td9').style.backgroundColor = '#4A9748'; */
		document.getElementById('plan_tips').innerHTML ='THIS IS ODD BET,WIN BONUS: 1 X 2 = 2';
  	}  else {
		document.getElementById(elem).style.backgroundColor = '#4A9748-';
		document.getElementById('plan_tips').innerHTML ='THIS IS BIG DICE STAR BET,WIN BONUS: 1 X 10 = 10';
 	}
  }
 
  function bgchange_out(elem) {
 	 
 	document.getElementById('td0').style.backgroundColor = '#5D57FA-'; 
	document.getElementById('td1').style.backgroundColor = '#5D57FA-';
	document.getElementById('td2').style.backgroundColor = '#5D57FA-';
	document.getElementById('td3').style.backgroundColor = '#5D57FA-';
	document.getElementById('td4').style.backgroundColor = '#5D57FA-';
	document.getElementById('td5').style.backgroundColor = '#5D57FA-';
	document.getElementById('td6').style.backgroundColor = '#5D57FA-';
	document.getElementById('td7').style.backgroundColor = '#5D57FA-';
	document.getElementById('td8').style.backgroundColor = '#5D57FA-';
	document.getElementById('td9').style.backgroundColor = '#5D57FA-';
 	document.getElementById('plan_tips').innerHTML ='';
  }
 </script>
</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
  <? include("includes/header.inc.php")?>
  <!-- ========== App Menu ========== -->
  <? include("includes/sidebar.php")?>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0">Play Game</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">BigDice Games </a></li>
                  <li class="breadcrumb-item active">Play Game</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <!--end row-->
        <div class="row">
		 <? include("error_msg.inc.php");?>
		
		<div class="col-xxl-6 centered">
		  
            <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Play Game</h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 
                <div class="live-preview">
                    
		  <?
		 // $total_bid_amount = db_scalar("select sum(bid_amount) as toal_bid_amount  from ngo_users_bid   where bid_status='New' and bid_userid = '$_SESSION[sess_uid]' ");
		 $total_bid_amount =  db_scalar("SELECT  sum(pay_amount) FROM ngo_users_ewallet where pay_userid = '$_SESSION[sess_uid]' and pay_group='CW' and pay_plan='BIDING' and pay_transaction_no='$bid_gameno'" )+0;
		
		//$total_bid_amount = $total_bid_amount-$trade_sum;
		
		  ?>
		  
          <form name="bid_form" id="bid_form" method="post"  onSubmit="return validate()"  enctype="multipart/form-data"   >
            <input type="hidden" name="account_balance" id="account_balance" value="<?=(float)$acc_balance?>">
            <input type="hidden" name="bid_amount" id="bid_amount" value="10">
            <input type="hidden" name="total_bid_amount" id="total_bid_amount" value="<?=(float)$total_bid_amount?>">
 			<input type="hidden" id="plan0" name="plan0" value="<?=(float)$plan0 ?>">
			<input type="hidden" id="plan1" name="plan1" value="<?=(float)$plan1 ?>">
			<input type="hidden" id="plan2" name="plan2" value="<?=(float)$plan2 ?>">
			<input type="hidden" id="plan3" name="plan3" value="<?=(float)$plan3 ?>">
			<input type="hidden" id="plan4" name="plan4" value="<?=(float)$plan4 ?>">
			<input type="hidden" id="plan5" name="plan5" value="<?=(float)$plan5 ?>">
			<input type="hidden" id="plan6" name="plan6" value="<?=(float)$plan6 ?>">
			<input type="hidden" id="plan7" name="plan7" value="<?=(float)$plan7 ?>">
 			<input type="hidden" id="plan8" name="plan8" value="<?=(float)$plan8 ?>">
			<input type="hidden" id="plan9" name="plan9" value="<?=(float)$plan9 ?>">
			
             <input type="hidden" id="planblack_num" name="planblack_num" value="<?=(float)$planblack_num ?>">
             <input type="hidden" id="planred_num" name="planred_num" value="<?=(float)$planred_num ?>">
			 <input type="hidden" id="plansilver_num" name="plansilver_num" value="<?=(float)$plansilver_num ?>">
			  <input type="hidden" id="ref_bid_gameno" name="ref_bid_gameno" value="<?=$bid_gameno ?>">
             <div  id="details"></div>
			 
 			<!-- table section 01 start -->
			<div class="col-xxl-6 centered">
			 <table border="0" width="100%"> <tr>
                            
                            <td width="50%" align="right"  class="ti tle  " style="text-align:right; border:0px;"> Time Left : </td>
							 
                            <td  width="50%"  align="left"  class="t itle  " nowrap="nowrap"  style="text-align:left!important; " ><div id="status" style="color:#FF0000; font-size:20px; width:  text-align:left; line-height:0px; vertical-align:top;"  ></div> 
							<input type="hidden" name="total_time" value="<?=$sess_total_time;?>" />
                              <input type="hidden" name="result_elapsed_time" id="result_elapsed_time" value=""  /> 
                              
                              <script type="text/javascript">countDown(<?=$sess_total_time;?>,"status");</script>
                            </td>
                          </tr></table>  
			</div>
			<div class="col-xxl-6 centered"  >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0px;"  >
                    <tr>
                      <td  width="50%" align="right"  nowrap="nowrap" > Capital Wallet Balance :</td>
                      <td  width="50%" align="left"  > <div id="acc_balance">  <?=round($acc_balance,0);?> </div></td>
					    
                    </tr>
                     <!-- <tr>
                      <td  width="15%" align="right"  nowrap="nowrap" > Reward Wallet Balance :</td>
                      <td  width="90%" align="left"  > <div id="acc_balance">  <?=round($acc_balance2,0);?> </div></td>
					   </tr>-->
					<tr>
                      <td width="15%"  align="right" class="title"> Predict Amount : </td>
                      <td    align="left" class="title"><div id="total_bid_amt"  style="color:#FFFF00; font-size:24px;  " >
                          <?=round($total_bid_amount,0);?>
                        </div></td> 
                    </tr>
					<tr>
                      <td width="15%"  align="right" class="title"> Predict No : </td>
                      <td    align="left" class="title"><div id="bid_gameno">
                          <?=$bid_gameno;?>
                        </div></td> 
                    </tr>
					<!--<tr>
					<td width="15%" align="right"  > Predict History : </td>
                            <td   align="left" ><? 
						/*$sql_bh = "select  bid_draw_no from ngo_users_bid_history  order by bid_hid desc limit 0,10";
						$result_bh = db_query($sql_bh);
						$ctr=0;
						while($line_bh = mysqli_fetch_array($result_bh)) {
 						 if($ctr==0) { 
						  ?>
                              <span style="color:#FF0000; font-size:24px;">
                              <?=$line_bh['bid_draw_no']?>
                              </span> -
                              <?
						  } else { 
						  echo $line_bh['bid_draw_no'] . ' - '; 
						  }
						  $ctr++;
						 }*/
						 
						  ?>
                            </td>
					</tr>-->
                  </table>
			</div>
			
                  
			<!-- table section 01 start -->	  
			 

			
			<!-- table section 02 start -->  
                  <table width="100%" border="0" style="border:0px; margin-top:15px;">
                    <tr>
                      <td  colspan="2" style="text-align:center;" > 
                      <!-- -->
					  <img width="45" id="bid_amt1" src="images/number/bid_amt1b.png" onClick="update_bid_amount('bid_amt1','1')"> 
					  <img width="45"  id="bid_amt5" src="images/number/bid_amt5a.png" onClick="update_bid_amount('bid_amt5','5')">
					   
						 
						 
					 
                              <img width="50" id="bid_amt10" src="images/number/bid_amt10a.png" onClick="update_bid_amount('bid_amt10','10')"> 
							   <img width="50" id="bid_amt50" src="images/number/bid_amt50a.png" onClick="update_bid_amount('bid_amt50','50')"> 
 							  <img width="50" id="bid_amt100" src="images/number/bid_amt100a.png" onClick="update_bid_amount('bid_amt100','100')"> 
							   <img width="50" id="bid_amt500" src="images/number/bid_amt500a.png" onClick="update_bid_amount('bid_amt500','500')"> 
 							  <img width="50" id="bid_amt1000" src="images/number/bid_amt1000a.png" onClick="update_bid_amount('bid_amt1000','1000')"> 
							   <?php /*?><img width="50" id="bid_amt5000" src="images/number/bid_amt5000a.png" onClick="update_bid_amount('bid_amt5000','5000')">
 							   <img width="50" id="bid_amt10000" src="images/number/bid_amt10000a.png" onClick="update_bid_amount('bid_amt10000','10000')">
							   <img width="50" id="bid_amt50k" src="images/number/bid_amt50ka.png" onClick="update_bid_amount('bid_amt50k','50000')">
							   <img width="50" id="bid_amt100k" src="images/number/bid_amt100ka.png" onClick="update_bid_amount('bid_amt100k','100000')"><?php */?>
				      </td>
				    </tr>
					<tr>
                           
                            <td align="left" valign="middle"  style="padding-top:20px; text-align:center;" colspan="2"  ><a href="bid_options.php"><!-- <img id="bet_reset" src="images/number/bet_reset.png" height="45" >--> <input type="button" id="bet_reset" name="bet_reset" value="Predict Reset" class="btn btn-secondary active" onClick="this.form.submit(); this.disabled=true; this.value='Processing...'; " ></a>  
							 <input type="button" id="bet_ok" name="bet_ok" value="Predict Submit" style="width:150px;" class="btn btn-primary btn-block"  onClick="this.form.submit(); this.disabled=true; this.value='Sending...'; " > <!-- <input type="image"  id="bet_ok" src="images/number/bet_ok.png" height="45" > --></td>
                    </tr>
                  </table> 
						
			<!-- table section 02 end -->  
                     				
				</td>
                    </tr>
                  </table> 
 </div>
                 
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="card">
			<div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Choose Your Predict Amount</h4>
               </div>
              <div class="card-body">
				
          <!--  <h1>&nbsp;&nbsp; Bid Options</h1>-->
		  
				  
				  <table width="100%" border="0"  align="center"  cellpadding="0" cellspacing="0"  >
              <tr>
                <td align="center" class="td_box" >
 			 
			
			 
                    <?
	
	$sql_gen = "select bid_userid, bid_plan, sum(bid_amount) as bid_amount  from ngo_users_bid   where bid_status='New' and bid_userid = '$_SESSION[sess_uid]' group by bid_plan ";
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
 	  // $$line_gen['bid_plan']= round($line_gen['bid_amount'],0);
		if($line_gen['bid_plan']=='planblack_num')		{ $planblack_num =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='planred_num')	{ $planred_num =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plansilver_num'){ $plansilver_num =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan0')			{ $plan0 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan1')			{ $plan1 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan2')			{ $plan2 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan3')			{ $plan3 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan4')			{ $plan4 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan5')			{ $plan5 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan6')			{ $plan6 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan7')			{ $plan7 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan8')			{ $plan8 =round($line_gen['bid_amount'],0);}
		else if($line_gen['bid_plan']=='plan9')			{ $plan9 =round($line_gen['bid_amount'],0);}
  	  //$line_gen['bid_plan'].'=='. $line_gen['bid_amount'];
  }
 
		
		$sett_value = db_scalar("select sett_value from ngo_setting where sett_code ='TRADE_05_STATUS' ");
 					   
					  
 ?>
 <!-- table section 03 start -->  
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped dt-responsive nowrap align-middle mdl-data-table"  style="margin-top:4px;">
                          <tr   ><!--style="background-color:#5D57FA;"-->
                            <td align="center" id="td0"><span class="bubble" id="bubble0">
                              <?=$plan0?>
                              </span> <br>
                              <img width="85" src="images/number/0.png"  <? if($sett_value==1){  ?> onClick="update_bidvalue('plan0','bubble0')"  <? } ?> onMouseOver="bgchange_over('td0')" onMouseOut="bgchange_out('td0')"></td>
                            <td align="center" id="td1"><span class="bubble" id="bubble1">
                              <?=$plan1?>
                              </span> <br>
                              <img width="85" src="images/number/1.png" onClick="update_bidvalue('plan1','bubble1')"  onMouseOver="bgchange_over('td1')" onMouseOut="bgchange_out('td1')"></td>
                            <td align="center" id="td2"><span class="bubble" id="bubble2">
                              <?=$plan2?>
                              </span> <br>
                              <img width="85" src="images/number/2.png" onClick="update_bidvalue('plan2','bubble2')"  onMouseOver="bgchange_over('td2')" onMouseOut="bgchange_out('td2')"></td>
                            <td align="center" id="td3"><span class="bubble" id="bubble3">
                              <?=$plan3?>
                              </span> <br>
                              <img width="85" src="images/number/3.png" onClick="update_bidvalue('plan3','bubble3')" onMouseOver="bgchange_over('td3')" onMouseOut="bgchange_out('td3')"></td>
                            <td align="center" id="td4"><span class="bubble" id="bubble4">
                              <?=$plan4?>
                              </span> <br>
                              <img width="85" src="images/number/4.png" onClick="update_bidvalue('plan4','bubble4')"  onMouseOver="bgchange_over('td4')" onMouseOut="bgchange_out('td4')"></td>
                          </tr>
                          <tr id="row_2ndrow">   <!--style="background-color:#5D57FA;"-->
                            <td align="center" id="td5"><span class="bubble" id="bubble5">
                              <?=$plan5?>
                              </span> <br>
                              <img width="85" src="images/number/5.png" <? if($sett_value==1){  ?> onClick="update_bidvalue('plan5','bubble5')"  <? } ?> onMouseOver="bgchange_over('td5')" onMouseOut="bgchange_out('td5')"></td>
                            <td align="center" id="td6"><span class="bubble" id="bubble6">
                              <?=$plan6?>
                              </span> <br>
                              <img width="85" src="images/number/6.png" onClick="update_bidvalue('plan6','bubble6')"  onMouseOver="bgchange_over('td6')" onMouseOut="bgchange_out('td6')"></td>
                            <td align="center" id="td7"><span class="bubble" id="bubble7">
                              <?=$plan7?>
                              </span> <br>
                              <img width="85" src="images/number/7.png" onClick="update_bidvalue('plan7','bubble7')"  onMouseOver="bgchange_over('td7')" onMouseOut="bgchange_out('td7')"></td>
						    <td align="center" id="td8"><span class="bubble" id="bubble8">
                              <?=$plan8?>
                              </span> <br>
                              <img width="85" src="images/number/8.png" onClick="update_bidvalue('plan8','bubble8')"  onMouseOver="bgchange_over('td8')" onMouseOut="bgchange_out('td8')"></td>
                           
                            <td align="center" id="td9"><span class="bubble" id="bubble9">
                              <?=$plan9?>
                              </span> <br>
                              <img width="85" src="images/number/9.png" onClick="update_bidvalue('plan9','bubble9')"  onMouseOver="bgchange_over('td9')" onMouseOut="bgchange_out('td9')"></td>
                          </tr>
                          <tr > <!--style="background-color:#5D57FA;"-->
						   <td align="center" colspan="5"> 
 						   <table>
						     <tr > <!--style="background-color:#5D57FA;"-->
 						    <td align="center" id="td1_blacknum"><span class="bubble" id="bubbleblack_num">
                              <?=$planblack_num?>
                              </span> <br>
                              <img src="images/number/black_num.png"  height="100"  class="button_sk"   onClick="update_bidvalue('planblack_num','bubbleblack_num')" onMouseOver="bgchange_over('row_blacknum')" onMouseOut="bgchange_out('row_blacknum')"></td>
							   <td align="center" id="td1_silver_num"><span class="bubble" id="bubblesilver_num">
                              <?=$plansilver_num?>
                              </span> <br>
                              <img src="images/number/silver_num.png"  height="100"  class="button_sk" <? if($sett_value==1){  ?>  onClick="update_bidvalue('plansilver_num','bubblesilver_num')" <? } ?>onMouseOver="bgchange_over('row_silvernum')" onMouseOut="bgchange_out('row_silvernum')"></td>
                            <td align="center" id="td1_red_num"><span class="bubble" id="bubblered_num">
                              <?=$planred_num?>
                              </span> <br>
                              <img src="images/number/red_num.png" height="100"  class="button_sk"   onClick="update_bidvalue('planred_num','bubblered_num')"  onMouseOver="bgchange_over('row_rednum')" onMouseOut="bgchange_out('row_rednum')" > </td>
							  
							 
                          </tr>
						  
						   
						   </table>
						    

						   
						    </td>
						  </tr>
						 
						
                          <tr  ><!--style="background-color:#e51284; "-->
                            <td colspan="14" height="30" align="center"  style="min-height:100px;" ><div style="font-size:18px; min-height:40px; padding-top:10px;">
                                <div id="plan_tips" style="font-size:18px; color:#000000; background-color:#FF0052;"></div>
                              </div></td>
                          </tr>
                        </table>
						<!--<div  id="prediction" align="right"><a href="bid_prediction.php" class="btn btn-primary">Prediction Chart</a></div>-->
		<!-- table section 03 end -->  				
						</td>
                    </tr>
                  </table>
				  
				</div>
            </div>
          </div>
		  
		  
		  
		   <div class="col-lg-12">
            <div class="card">
			<div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Current Predict Details</h4>
               </div>
              <div class="card-body">
            
				  
				  <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead class="table-light">
                  <tr  >
					<!--<td width="33%" align="center" ><strong>Bid Date</strong></td>-->
					<th width="33%" align="center" >Predict No </th>
 					<th width="33%" align="center" > <strong>Predict On</strong></th>
 					<th width="33%" align="center" > <strong>Predict Amount</strong> </th>
			 
                    </tr>
					</thead> 
                <?
				
 		/*
		$bid_today_count = db_scalar("select  (count(*)+1) as total from ngo_users_bid_history where bid_date =DATE_FORMAT( ADDDATE(now(),INTERVAL 330 MINUTE) , '%Y-%m-%d') ");
		if($bid_today_count<=9) {$bid_no='00'.$bid_today_count;} 
		else if($bid_today_count>=10 && $bid_today_count<=99) {$bid_no='0'.$bid_today_count;}
		else if($bid_today_count>=100 ) {$bid_no= $bid_today_count;}
		$bid_gameno =  date("Ymd",strtotime($bid_datetime)).$bid_no;*/
			
			
	$sql_gen = "select bid_id, bid_plan, sum(bid_amount) as bid_amount , bid_gameno ,bid_datetime  from ngo_users_bid   where bid_status='New' and bid_userid = '$_SESSION[sess_uid]' group by bid_userid, bid_plan ";
	//$sql_gen = "select bid_id, bid_plan,  bid_amount from ngo_users_bid where bid_status='New' and bid_userid = '$_SESSION[sess_uid]' ";
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	$line = ms_display_value($line_gen);
	@extract($line); 
	
	
  ?>
		<tr class="<?=$css?>">
		 <td align="center" ><?=$bid_gameno;?></td> 
  		<td align="center" ><? //=$ARR_BID_GROUP[$line['bid_plan']]; ?> <img width="50" src="images/number/<?=$ARR_BID_IMG[$line['bid_plan']]?>"></td>
  		<td align="center" ><?=$bid_amount?></td>
  		 </tr>
                <? }
?>
              </table>
			  </div>
            </div>
          </div>
		  
		  <div class="col-lg-6">
            <div class="card">
			<div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">My Predict History</h4>
               </div>
              <div class="card-body">
			    
			<table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead class="table-light">
                            <tr  >
                              <!-- <td width="10%" height="23">Pay No. </td>-->
                              <th width="20%" align="center" >Predict&nbsp;No </th>
                              <th width="40%" align="center" >Predict&nbsp;On</th>
                              <th width="20%" align="center" >Point </th>
							  <th width="20%" align="center" >Prize </th>
                              <th width="20%" align="center" >Status </th>
                            </tr>
                       </thead>   
                          <?
			$sql_my = "select * from ngo_users_bid inner join ngo_users on bid_userid=u_id and bid_userid='$_SESSION[sess_uid]' and bid_status!='New' order by bid_id desc  limit 0,5  ";
			$result_my = db_query($sql_my);
 			$total_count = mysqli_num_rows($result_my);
 			if ($total_count>0){
 			while ($line_my= mysqli_fetch_array($result_my, MYSQLI_ASSOC)){
			$line_my = ms_display_value($line_my);
 			$wining_amount = db_scalar("select pay_amount from ngo_users_ewallet where pay_group='CW' and pay_plan='TRADE_REWARD' and pay_userid='$_SESSION[sess_uid]' and pay_refid='$line_my[bid_id]'");
			
			 	//	@extract($line_my); 
 			 ?>
                          <tr class="<?=$css?>">
                             <td align="center" ><?=$line_my['bid_gameno']; ?></td>
                            <td align="center" ><? //=$ARR_BID_GROUP[$line_my['bid_plan']]; ?><img width="50" src="images/number/<?=$ARR_BID_IMG[$line_my['bid_plan']]?>"></td>
                            <td align="center" ><?=round($line_my['bid_amount'],2); ?></td>
							 <td align="center" ><?=round($wining_amount,2); ?></td>
                            <td align="center" ><?=$line_my['bid_status']; ?></td>
                          </tr>
                          <? 
					  
					  } ?>
                          <? }  else { ?>
                          <tr class="maintxt">
                            <td colspan="6"  align="center" >My Transaction   details not found </td>
                          </tr>
                          <? } ?>
                          
                        </table>
						
						 </div>
            </div>
          </div>
				 <div class="col-lg-6">
            <div class="card">
			<div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Last 10 Winning Predict History</h4>
               </div>
              <div class="card-body">
			    		
			    <h2> </h2>
				  <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead class="table-light">
                 <tr  >
					 
					 <th width="10%" align="center" >Predict No </th>
					 <th width="10%" align="center" >Win&nbsp;Digit </th> 
 					<!--<th width="10%" >&nbsp;Drow Details</th> -->
					<th width="10%" >&nbsp;Predict Date</th>
                    </tr>   </thead>
                <?
	$sql_gen = "select *  from ngo_users_bid_history  order by bid_hid desc limit 0,10 ";
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	$line = ms_display_value($line_gen);
	@extract($line); 
  ?>
		<tr class="<?=$css?>">
		 <td nowrap="nowrap" align="center"><?=$bid_gameno?></td>
		 <td nowrap="nowrap" align="center"><?//=$bid_draw_no?> <img width="50" src="images/number/<?=$bid_draw_no?>.png">
		 </td>
 		<!--<td nowrap="nowrap"><?=$bid_desc?></td> -->
 		<td nowrap="nowrap"><?=datetime_format($bid_datetime)?></td> 
 		 </tr>
                <? }
?>
              </table>
			  
			   </div>
            </div>
          </div>
			  
				 
          </form>
         </div>
            </div>
          </div>
          <!--end col-->
        </div>
        <!--end row-->
      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <? include("includes/footer.php")?>
  </div>
  <!-- end main content-->
</div>
<!-- END layout-wrapper -->
<? include("includes/extra_footer.php")?>
</body>
</html>
