<?
require_once("../includes/surya.dream.php");
protect_admin_page2();

if ($_GET['action']=='del' && $_GET['ask']=='welcome' && $_GET['top']=='prediction' && $_GET['go']=='run') {
	$sql = "delete from  ngo_users_bid_prediction  where 1 ";
	db_query($sql);
	
	$sql = "update  ngo_staticpage set static_status='Inactive'   where static_page_name='Trade_finish_msg' ";
	db_query($sql);
	header("Location: users_bidding_draw.php");
	exit;
	
 }


if ($_GET['action']=='show' && $_GET['ask']=='message' && $_GET['top']=='prediction' && $_GET['go']=='active') {
	$sql = "update  ngo_staticpage set static_status='Active'   where static_page_name='Trade_finish_msg' ";
	db_query($sql);
	header("Location: users_bidding_draw.php");
	exit;

}

if ($_GET['number']=='05' && $_GET['action']=='enabledisable' && $_GET['top']=='trade' && $_GET['sett_value']!='') {
	 $sql = "update ngo_setting set sett_value = '$sett_value',sett_admin='$_SESSION[sess_admin_login_id]' ,sett_lastupdate=ADDDATE(now(),INTERVAL 330 MINUTE)   where sett_code ='TRADE_05_STATUS'";
	db_query($sql);
	
	header("Location: users_bidding_draw.php");
	exit;


}

if ($_GET['prediction']=='status' && $_GET['action']=='enabledisable' && $_GET['top']=='trade' && $_GET['sett_value']!='') {
	 $sql = "update ngo_setting set sett_value = '$sett_value',sett_admin='$_SESSION[sess_admin_login_id]' ,sett_lastupdate=ADDDATE(now(),INTERVAL 330 MINUTE)   where sett_code ='PREDICTION_STATUS'";
	db_query($sql);
	
	header("Location: users_bidding_draw.php");
	exit;


}




if(is_post_back()) {
 
 if (isset($_REQUEST['Update']) || isset($_REQUEST['Update_x']) ) {
 		/// set winning number for draw
	   $sql = "update ngo_setting set sett_value = '1', sett_unit = '$sett_unit'  ,sett_admin='$_SESSION[sess_admin_login_id]' ,sett_lastupdate=ADDDATE(now(),INTERVAL 330 MINUTE)   where sett_code ='WINNING_NUMBER'";
	db_query($sql);
	header("Location: users_bidding_draw.php");
	exit;

 
	
  }

if (isset($_REQUEST['Prediction']) || isset($_REQUEST['Prediction_x']) ) {
 
 	$bid_datetime = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE) ");
	$bid_today_count = db_scalar("select  (count(*)+1) as total from ngo_users_bid_history where bid_date =DATE_FORMAT( ADDDATE(now(),INTERVAL 330 MINUTE) , '%Y-%m-%d') ");
	if($bid_today_count<=9) {$bid_no='00'.$bid_today_count;} 
	else if($bid_today_count>=10 && $bid_today_count<=99) {$bid_no='0'.$bid_today_count;}
	else if($bid_today_count>=100 ) {$bid_no= $bid_today_count;}
	$bid_gameno =  date("Ymd",strtotime($bid_datetime)).$bid_no;
	
	$bid_today_count = db_scalar("select count(*)  from ngo_users_bid_prediction where bid_gameno = '$bid_gameno' ");
	if ($bid_today_count==0){ 
	  $sql = "insert into ngo_users_bid_prediction set  bid_gameno = '$bid_gameno'  ,bid_color='$prediction_color',bid_amount='$prediction_amount' ,bid_status='Waiting' ,bid_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,bid_draw_date=ADDDATE(now(),INTERVAL 333 MINUTE) ,bid_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
	 $result = db_query($sql);
	}	 
	
	header("Location: users_bidding_draw.php");
	exit;
	
}
  if (isset($_REQUEST['Update_draw.............']) || isset($_REQUEST['Update_x.............']) ) {
 
			#select * 
			//print_r($_POST);
			$winning_number = $ARR_BID_COLUMN[$bid_column];
			$sql_gen = "select * from ngo_users_bid  where  bid_status='New' and $bid_column>0 ";
			$result_gen = db_query($sql_gen);
			$total_bid_count = mysqli_num_rows($result_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
			@extract($line_gen);
			$bid_number = $ARR_BID_COLUMN[$bid_column];
			 //  print "<br> =  $draw_status : $bid_number : $bid_draw_no"; 
			 
			 
 			
			  
			 $today_count = db_scalar("select count(pay_id) from ngo_users_ewallet where pay_plan='WINING_PRIZE' and pay_userid = '$bid_userid' and pay_refid='$winning_number' and pay_transaction_no='$bid_plan' and pay_ref_amt='$bid_amount' and  pay_date='$bid_date' ");
		 
  			if ($draw_status=='Win' && $today_count==0) {
 				//db_query("update ngo_users_bid set bid_status='Win', bid_draw_date='$bid_draw_date',bid_draw_win_no='$bid_draw_no' where  bid_id = '$bid_id'");
 				$pay_rate = $bid_rate;
 				$bid_amount = $$bid_column;
 				$pay_amount = $bid_amount * $pay_rate;
 				if($pay_amount>0){
				 $msg.= $u_id.' ,';
 				 $pay_for =$bid_desc." Winning No $winning_number ";
 				 $sql = "insert into ngo_users_ewallet set pay_drcr='Cr', pay_userid = '$bid_userid',pay_refid = '$winning_number' ,pay_transaction_no='$bid_plan' ,pay_plan='WINING_PRIZE',pay_group='BID' ,pay_for = '$pay_for' ,pay_ref_amt='$bid_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
				
 				db_query($sql);
				$pay_topupid = mysqli_insert_id($GLOBALS['dbcon']);
				/// Level distribution 
 				 ////////////////////////////////////////////
 				 // Direct Income level
 				//$topup_amount = 100;  
				/*
				if ($bid_rate==10000) {
					 
				$u_ref_userid = $bid_userid;
 				$pay_rate =.5;
				$pay_amount =  $bid_amount * 0.5;
					if($pay_amount>0){
					$ctr=0;
						while ($ctr<=5) { 
						$ctr++;
						$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
						if ($u_ref_userid!='' && $u_ref_userid!=0 ){
 							$pay_for ="Bid Level $ctr Bonus ";
							$sql2 = "insert into ngo_users_payment set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$bid_userid' ,pay_topupid='$pay_topupid',pay_plan='LEVEL_INCOME' ,pay_group='$pay_group' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$topup_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='SPOT' ";
							#db_query($sql2);
						 }
						} 
					}
			}	
			*/
 				}  
				/////////////////////////////////////////////
    		}  
 		 
   			}
			// Insert draw history 
			//if ($total_bid_count==0) { $bid_number = rand(0,36);} 
			//if ($total_bid_count==0) { $bid_number = rand(0,36);} 
			$bid_datetime = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE) ");
			$bid_desc = "Winning Numner :$winning_number - Time: $bid_datetime ";
			$sql_history = "insert into ngo_users_bid_history set   bid_draw_no = '$winning_number',bid_desc = '$bid_desc' ,bid_date =ADDDATE(now(),INTERVAL 330 MINUTE),bid_datetime =ADDDATE(now(),INTERVAL 330 MINUTE)";
			
			db_query($sql_history);
			/// delete bid hostory 24 hrs old 
			$sql_update = "delete from ngo_users_bid_history where bid_datetime < ADDDATE(now(),INTERVAL -2880 MINUTE) ";
			//db_query($sql_update);
			
			// delete biding transaction after draw
			//$sql_update = "delete from ngo_users_bid where bid_status='New' ";
			$sql_update = "update ngo_users_bid set bid_status='Win' ,bid_draw_win_no='$winning_number' where  bid_status='New' and $bid_column>0 ";
			db_query($sql_update);
			$sql_update = "update ngo_users_bid set bid_status='Loss' ,bid_draw_win_no='$winning_number' where  bid_status='New' ";
			db_query($sql_update);
				 
 		}
 	
	
	
	
	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">


<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Biding Summary  </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
              
            <form method="post"  name="bid_form" id="bid_form"  onsubmit="confirm_submit(this)">
             
                <?
				// count(*) total_bidder , 
$sql = "select sum(bid_0) as bid_0 ,sum(bid_1) as bid_1,sum(bid_2) as bid_2 ,sum(bid_3) as bid_3 ,sum(bid_4) as bid_4 ,sum(bid_5) as bid_5 ,sum(bid_6) as bid_6 ,sum(bid_7) as bid_7 ,sum(bid_8) as bid_8 ,sum(bid_9) as bid_9   from ngo_users_bid where bid_status='New'  ";
//, sum(bid_amount) as total_amount
$result = db_query($sql);
//	$line_raw = mysqli_fetch_array($result);
$line_raw = mysqli_fetch_assoc($result);
/*	print "<pre>";
	print_r($line_raw);
	print "</pre>";
*/	  $min_value =  (min($line_raw));
	  $arr_bid_column=array();
	foreach($line_raw as $key=>$value) { 
 		if ($value <=$min_value) { 
			//$bid_column = $key; 
			$arr_bid_column[] = $key; 
			 // print "<br> = $key : $value "; 
		} 
 	}
  #	print_r($arr_bid_column);
	if(count($arr_bid_column)>0) {$number_count  = count($arr_bid_column)-1;} else { $number_count  = count($arr_bid_column);} 
	$number = rand(0,$number_count);
	$bid_column = $arr_bid_column[$number]; 

/// print_r(array_rand($arr_bid_column ,1));
#$css = ($css=='trOdd')?'trEven':'trOdd';	
 
$total_bid_amount = db_scalar("select sum(bid_amount) from ngo_users_bid where bid_status='New' ");
$total_win_bid_amount = db_scalar("select sum($bid_column) from ngo_users_bid where bid_status='New' ");
$total_win_amount = $total_win_bid_amount * 10;

//check admi have set the winning number manula or not
 $sett_unit = db_scalar("select sett_unit from ngo_setting where sett_code ='WINNING_NUMBER' ");
 if($sett_unit!=''){
	//$total_bid_amount_man = db_scalar("select sum(bid_amount) from ngo_users_bid where bid_status='New' ");
	$total_win_bid_amount_man = db_scalar("select sum($sett_unit) from ngo_users_bid where bid_status='New' ");
	$total_win_amount_man = $total_win_bid_amount_man  * 10;
 }
  
	
/*	
$bid_datetime = db_scalar("select  ADDDATE(bid_datetime ,INTERVAL 0 MINUTE) from ngo_users_bid_history  order by bid_hid desc limit 0,1 ");
$dateFrom = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE) ");
$dateTo = db_scalar("select ADDDATE('$bid_datetime',INTERVAL 333 MINUTE) ");
$dateFrom = date("d-m-Y H:i:s",strtotime($dateFrom));
$dateTo = date("d-m-Y H:i:s", strtotime($dateTo));
$sess_total_time= getDateDifference($dateFrom, $dateTo, $unit = 'S');
//if ($sess_total_time==0) {$sess_total_time =180;} 
*/
$bid_datetime = db_scalar("select   ADDDATE(bid_datetime ,INTERVAL 3 MINUTE)   from ngo_users_bid_history  order by bid_hid desc limit 0,1 ");
$bid_datetime2 = db_scalar("select ADDDATE(now(),INTERVAL 330 MINUTE)  ");
$dateFrom = date("d-m-Y H:i:s",strtotime($bid_datetime));
$dateTo = date("d-m-Y H:i:s", strtotime($bid_datetime2));
 //print "<br><br><br> == Date :  $dateFrom | $dateTo ";
 
 if($dateFrom>$dateTo){  
	//print "<br><br><br> == Date :  OK ";
	$start_date = new DateTime($dateFrom);
	$since_start = $start_date->diff(new DateTime($dateTo));
	$sess_total_time = $since_start->s +($since_start->i*60)+5;
} else{
	$sess_total_time =180;

}

/*
$bid_datetime = db_scalar("select   ADDDATE(bid_datetime ,INTERVAL 3 MINUTE)   from ngo_users_bid_history  order by bid_hid desc limit 0,1 ");
$bid_datetime2 = db_scalar("select ADDDATE(now(),INTERVAL 0 MINUTE)  ");
$dateFrom = date("d-m-Y H:i:s",strtotime($bid_datetime));
$dateTo = date("d-m-Y H:i:s", strtotime($bid_datetime2));
 print "<br><br><br> == Date :  $dateFrom | $dateTo ";
if($dateFrom>$dateTo){  
	$start_date = new DateTime($dateFrom);
	$since_start = $start_date->diff(new DateTime($dateTo));
	$sess_total_time = $since_start->s +($since_start->i*60);
} else{
	$sess_total_time =0;
}
*/


  ?>
	
	<div align="left">  
  <script type="text/javascript">
	function countDown(secs, elem)
	{
		var element = document.getElementById(elem);
	   // element.innerHTML = "<h2>You have <b>"+secs+"</b> seconds to answer the questions</h2>";
		element.innerHTML =  secs +" Sec" ;
 		document.bid_form.result_elapsed_time.value = secs;
 		
		if(secs < 1) {
			  window.location="users_bidding_draw.php";
		}
		else
		{
			secs--;
			setTimeout('countDown('+secs+',"'+elem+'")',1000);
		}
	}

	function validate() {
		return true;
	}
 </script>
	</div>
	<!-- <h1> 
	    Time Left : <input type="hidden" name="total_time" value="<?=$sess_total_time;?>" />
                <input type="hidden" name="result_elapsed_time" id="result_elapsed_time" value=""  />
                <div id="status" style="width:10px;   color:#000000;"> </div>
                <script type="text/javascript">countDown(<?=$sess_total_time;?>,"status");</script>
				
				  <br />
		Total Bid Amount : <?=$total_bid_amount?>  <br />
		Minimum Bid Amount : <?=$min_value?> <br />
		Wining Number : <?=$ARR_BID_COLUMN[$bid_column]?> <br /> 
 		Winning Amount : <?=$total_win_amount?> <br />
		Balance Amount : <?=$total_bid_amount-$total_win_amount?> <br />
  
   </h1>
	</div>-->
	  <form name="bid_form" id="bid_form" method="post"  onSubmit="return validate()"  enctype="multipart/form-data" > 
	<table width="88%"  border="0" align="center" cellpadding="5" cellspacing="5" class="td_box" style="font-size:24px;">
	<tr  style="background-color:#000000; color:#FFFF33;">
				 <th align="left" valign="middle" colspan="6"> Trade Summary </th>
				 </tr>
	<tr  style="background-color:#ffffff;">
		<td width="20%" align="right" >Time Left : </td> 
		<td width="21%" align="left" nowrap="nowrap"><input type="hidden" name="total_time" value="<?=$sess_total_time;?>" />
                <input type="hidden" name="result_elapsed_time" id="result_elapsed_time" value=""  />
                <div id="status" style="width:10px;   color:#000000;"> </div>
                <script type="text/javascript">countDown(<?=$sess_total_time;?>,"status");</script> </td>
		<td width="13%" align="right">Total Bid Amount : </td> 
		<td width="19%" align="left"> <?=$total_bid_amount?></td>
		<td width="14%" align="right"> Minimum Bid Amount : </td> 
		<td width="21%" align="left"><?=$min_value?>  </td>
		 </tr>
	<tr style="background-color:#66FF99;">
		<td align="right"> Wining Number(Auto) : </td> 
		<td align="left"><?=$ARR_BID_COLUMN[$bid_column]?> <? //= $WINNING_NUMBER = db_scalar("select sett_unit from ngo_setting where sett_code ='WINNING_NUMBER' ");?></td>
		<td align="right"> Winning Amount : </td> 
		<td align="left"> <?=$total_win_amount?> </td>
		<td align="right"> Profit/Loss Amount : </td> 
		<td align="left"> <?=$total_bid_amount-$total_win_amount?></td>
		 
		
	</tr>
	<? if($sett_unit!=''){ ?>
	<tr style="background-color:#FF6666;">
		<td align="right"> Wining Number (Manual) : </td> 
		<td align="left"><?  echo $ARR_BID_COLUMN[$sett_unit]; ?></td>
		<td align="right"> Winning Amount : </td> 
		<td align="left"> <?=$total_win_amount_man?> </td>
		<td align="right"> Profit/Loss Amount : </td> 
		<td align="left"> <?=$total_bid_amount-$total_win_amount_man?></td>
		 
		
	</tr>
	<? } ?>
	</table>
	
	 
	  <br />
	  <table width="500"  border="0" align="center" cellpadding="5" cellspacing="5" class="td_box">
			<tr  style="background-color:#000000; color:#FFFF33;">
				 <th align="left" valign="middle" colspan="10"> Trade Report </th>
				 </tr>
	<tr style="background-color:#ffffff;">
	  
	   <td align="center"><span class="bubble" id="bubble0"><?=(int)$line_raw['bid_0'] ?></span> <br><img width="85" src="../images/number/0.png" ></td>
	     <td align="center"><span class="bubble" id="bubble1"><?=(int)$line_raw['bid_1'] ?></span> <br><img width="85" src="../images/number/1.png" ></td>
	  <td align="center"><span class="bubble" id="bubble2"><?=(int)$line_raw['bid_2'] ?></span> <br><img width="85" src="../images/number/2.png" ></td>
	  <td align="center"><span class="bubble" id="bubble3"><?=(int)$line_raw['bid_3'] ?></span> <br><img width="85" src="../images/number/3.png"></td>
	   <td align="center"><span class="bubble" id="bubble4"><?=(int)$line_raw['bid_4'] ?></span> <br><img width="85" src="../images/number/4.png" ></td>
	   <td align="center"><span class="bubble" id="bubble5"><?=(int)$line_raw['bid_5'] ?></span> <br><img width="85" src="../images/number/5.png" ></td>
	  <td align="center"><span class="bubble" id="bubble6"><?=(int)$line_raw['bid_6'] ?></span> <br><img width="85" src="../images/number/6.png" ></td>
	   <td align="center"><span class="bubble" id="bubble7"><?=(int)$line_raw['bid_7'] ?></span> <br><img width="85" src="../images/number/7.png" ></td>
	   <td align="center"><span class="bubble" id="bubble8"><?=(int)$line_raw['bid_8'] ?></span> <br><img width="85" src="../images/number/8.png" ></td>
	  <td align="center"><span class="bubble" id="bubble9"><?=(int)$line_raw['bid_9'] ?></span> <br><img width="85" src="../images/number/9.png" ></td>
	  
	   
	  </tr>
	 
	

   
                
              </table><br />

          <table width="450"  border="0" align="center" cellpadding="5" cellspacing="5" class="td_box">
		   <tr  style="background-color:#000000; color:#FFFF33;">
				 <th align="left" valign="middle" colspan="2">  Set Winning Number  </th>
				 </tr>
                <tr style="background-color:#ffffff;">
				 <td align="right" valign="middle">   Winning Number : </td>
 				    <td align="left" valign="middle" > 
					<?=array_dropdown($ARR_BID_COLUMN, $sett_unit, 'sett_unit');?>
					 </td> 
                </tr>
               
               <tr style="background-color:#ffffff;">
                  <td  align="center" >&nbsp;</td>
                  <td align="left"  >
 				  <input name="Update" type="image" id="Update" src="images/buttons/submit.gif"  /></td>
                </tr>
              </table> 
			  
			   <table width="450"  border="0" align="center" cellpadding="5" cellspacing="5" class="td_box">
                 <tr  style="background-color:#000000; color:#FFFF33;">
				 <th align="left" valign="middle" colspan="4"> Create Prediction Chart  </th>
				 </tr>
				 <tr style="background-color:#ffffff;">
				 <td align="right" valign="middle" nowrap="nowrap">  Prediction Color : </td>
 				    <td align="left" valign="middle" > 
					<?=array_dropdown($ARR_PREDICTION_COLOR, $prediction_color, 'prediction_color');?>
					 </td> 
					<td align="right" valign="middle">    Amount : </td>
 				    <td align="left" valign="middle" > 
					  <input name="prediction_amount" style="width:120px;" type="text" value="<?=$prediction_amount?>" alt="number" emsg="Please enter prediction amount"  /> </td> 
                </tr>
                <tr style="background-color:#ffffff;">
                  <td  align="center" >&nbsp;</td>
                  <td align="left"   >
 				  <input name="Prediction" type="image" id="Prediction" src="images/buttons/submit.gif"  /></td>
				    <td  align="center" >&nbsp;</td>
					  <td  align="center" > </td>
				  
                </tr>
				
              </table>  
            </form>
			
 
<br />


			<table width="450"  border="0" align="center" cellpadding="5" cellspacing="5" class="td_box">
                 <tr  style="background-color:#000000; color:#FFFF33;">
				 <th align="left" valign="middle" colspan="5">Prediction Chart  </th>
				 </tr>
				 <tr style="background-color:#ffffff; font-size:18px;">
				 <td align="left" valign="middle" nowrap="nowrap">Trade No </td>
 				    <td align="left" valign="middle" >Trade Color  </td> 
					<td align="left" valign="middle"> Trade Amount   </td>
  				    <td align="left" valign="middle" > Result  </td> 
					<td align="left" valign="middle" > Profit  </td> 
                </tr>
				<?
				
				//bid_date =DATE_FORMAT( ADDDATE(now(),INTERVAL 330 MINUTE) , '%Y-%m-%d')
		  	$sql_gen = "select *,   (IF(bid_status='Loss',bid_amount2,'')) AS Loss,  (IF(bid_status='Win',bid_amount2,'')) AS Win from ngo_users_bid_prediction   where bid_gameno!='' group by bid_gameno order by bid_id asc ";
			$result_gen = db_query($sql_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
			
			# $running_balance =db_scalar("SELECT (SUM(IF(bid_status='Win',bid_amount,''))-SUM(IF(bid_status='Loss',bid_amount,''))) as balance FROM ngo_users_bid_prediction where bid_id <'$line_gen[bid_id]'  ") ;
			 $acc_balance  += $line_gen['bid_amount2'] ;
			 
			 
				?>
				
                <tr style="background-color:#ffffff;">
				 <td align="left" valign="middle" nowrap="nowrap"><?=$line_gen['bid_gameno'];?> </td>
 				    <td align="left" valign="middle" ><?=$line_gen['bid_color'];?></td>  
					<td align="left" valign="middle">    <?=$line_gen['bid_amount'];?>   </td>
  				    <td align="left" valign="middle" > <?=$line_gen['bid_status'];?>  </td> 
					<td align="left" valign="middle" > <? if($line_gen['bid_status']!='Waiting') { echo $acc_balance;}?>  </td> 
                </tr>
				
				<? } ?>
              </table>  
			  <? 
					   $PREDICTION_STATUS = db_scalar("select sett_value from ngo_setting where sett_code ='PREDICTION_STATUS' ");
 					 if($PREDICTION_STATUS==1){
					  ?>
					    <div align="center"> <h1 style="color:#FF0000;"> <?=db_scalar("select static_desc from ngo_staticpage where static_page_name='NO_PREDICTION_MESSAGE' and static_status='Active' ");?></h1></div>
			 <? } ?>
			  <div align="center"> <h1 style="color:#006600;"> <?=db_scalar("select static_desc from ngo_staticpage where static_page_name='Trade_finish_msg' and static_status='Active' ");?>!</h1></div>
			  <br />
<br />
 <table width="450"  border="0" align="center" cellpadding="5" cellspacing="5" class="td_box">
                 <tr  style="background-color:#000000; color:#FFFF33;">
				 <th align="left" valign="middle" colspan="4">Prediction Setting  </th>
				 </tr>
				 <tr style="background-color:#ffffff;">
                   
				     <td  align="center" colspan="2" >&nbsp;<a href="users_bidding_draw.php?action=del&ask=welcome&top=prediction&go=run"><strong>Delete Prediction</strong></a></td>
					  <td  align="center" colspan="2" >&nbsp;<a href="users_bidding_draw.php?action=show&ask=message&top=prediction&go=active"><strong>Show Congratulation MSG</strong></a></td>
				 
				  
                </tr>
				<tr style="background-color:#ffffff;">
                    <? 
					   $sett_value = db_scalar("select sett_value from ngo_setting where sett_code ='TRADE_05_STATUS' ");
 					  ?>
					  
				     <td  align="center" colspan="2" >&nbsp;  <? if($sett_value==0){  echo '<div style="color:#FF0000;font-size:15px;">0,5 is Disabled </div>'; } else { echo '<div style="color:#009933;font-size:15px;"> 0,5 is Enable </div>'; }?> </td>
					  <td  align="center" colspan="2" >&nbsp; 
					   <? if($sett_value==0){  ?>
					 	<a href="users_bidding_draw.php?number=05&action=enabledisable&top=trade&sett_value=1"><strong>Enable 0,5 Number for Trade </strong></a>
					  <? } else { ?>
					   	<a href="users_bidding_draw.php?number=05&action=enabledisable&top=trade&sett_value=0"><strong>Desable 0,5 Number for Trade</strong></a>
					  <? }  ?>
					  </td> 
                </tr>
				<tr style="background-color:#ffffff;">
                    <? 
					   $sett_value = db_scalar("select sett_value from ngo_setting where sett_code ='PREDICTION_STATUS' ");
 					  ?>
					  
				     <td  align="center" colspan="2" >&nbsp;  <? if($sett_value==0){  echo '<div style="color:#FF0000;font-size:15px;">Message is Hide</div>'; } else { echo '<div style="color:#009933;font-size:15px;">Message is showing </div>'; }?> </td>
					  <td  align="center" colspan="2" >&nbsp; 
					   <? if($sett_value==0){  ?>
					 	<a href="users_bidding_draw.php?prediction=status&action=enabledisable&top=trade&sett_value=1"><strong> Show No Prediction Msg</strong></a>
					  <? } else { ?>
					   	<a href="users_bidding_draw.php?prediction=status&action=enabledisable&top=trade&sett_value=0"><strong>Hide No Prediction Msg</strong></a>
					  <? }  ?>
					  </td>
				 
				 
				 
				 
				  
                </tr>
				
				<tr style="background-color:#ffffff;">
                  
					   
					  <td  align="center" colspan="4" >&nbsp; 
					  
					 	<a target="_blank" href="../cronjob_rider_trading_reward.php?prediction=status&action=enabledisable&top=trade&sett_value=1"><strong> Generate Today Rider Trading Reward</strong></a>
				 
					  </td>
				 
				 
				 
				 
				  
                </tr>
			  </table>  
            
            <? //include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
