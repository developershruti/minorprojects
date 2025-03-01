<?php
include ("../includes/surya.dream.php");
 protect_user_page(); 
$arr_error_msgs = array();
/// get payment deposit api key and secret and address
/*$sql_bin = "select  u_binance_api_key , u_binance_secret ,u_binance_trusted_ip from ngo_users  where u_binance_api_key!='' and u_binance_secret!='' and u_id='1' ";  
$result_bin = db_query($sql_bin);
$line_bin = mysqli_fetch_array($result_bin) ;
@extract($line_bin);*/
/*

TY73vMbeLKjn8vdmFS4QYjQHtR3n5va4GS

Send only TRX to this deposit address.
Ensure the network is Tron (TRC20).

*/
  
 


//print " $api_key  |  $api_secret  |  $new_address ";
/*if($u_binance_api_key=='' || $u_binance_secret='' ){ 
	$arr_error_msgs[] =  "Something went wrong, please try after some time";
	$action = '';
 }*/

if($action == 'Finish') {
 $value = array();
 $depositHistory = array();
  ///connect with binance
if($pay_ipntype=='BSB'){ 
	///test account
$u_binance_api_key = "HAwBUoYBqVqtuYDkj05B4ywk81GYce4GYO9yoCIefbge8SLKwz2ncJVgusNPuQxE";
$u_binance_secret = "W21jDDC1I5jujTRF7yTIBIxsoJgD50mSNzZxfNQYSibdcMJf59DjnGtPT6eO3jLh";
} else {
	// Company Account
$u_binance_api_key = "HAwBUoYBqVqtuYDkj05B4ywk81GYce4GYO9yoCIefbge8SLKwz2ncJVgusNPuQxE";
$u_binance_secret = "W21jDDC1I5jujTRF7yTIBIxsoJgD50mSNzZxfNQYSibdcMJf59DjnGtPT6eO3jLh";

}
binance::auth($u_binance_api_key, $u_binance_secret);
$depositHistory = binance::call('/sapi/v1/capital/deposit/hisrec');
/* 
print"<pre>";
print_r($depositHistory);
print"</pre>";

Array
(
    [0] => Array
        (
            [id] => 3104353021774536449
            [amount] => 5
            [coin] => USDT
            [network] => TRX
            [status] => 1
            [address] => TY73vMbeLKjn8vdmFS4QYjQHtR3n5va4GS
            [addressTag] => 
            [txId] => 5a16c5dfafbb224c0627eebb205a3b9207a752ff83009c423d5e78b62857ef4c
            [insertTime] => 1662992259000
            [transferType] => 0
            [confirmTimes] => 1/1
            [unlockConfirm] => 0
            [walletType] => 0
        )

)
 */
 	if (count($depositHistory)>0) {
  	foreach($depositHistory as $key => $value) {
  // echo "$key = $value[txId]<br>";
  //pay_coin='USDT' and
  if (isset($value['txId'])) {
    	$deposit_count = db_scalar("select count(*) from ngo_binance_deposit where  pay_txId='$value[txId]'");
		 if ($deposit_count==0) {
  			    $sql = "insert into ngo_binance_deposit set pay_coin='$value[coin]' ,pay_network='$value[network]', pay_amount='$value[amount]' , pay_status='$value[status]' ,pay_address='$value[address]' ,pay_addressTag='$value[addressTag]' ,pay_txId='$value[txId]' ,pay_insertTime='$value[insertTime]' ,pay_transferType='$value[transferType]' ,pay_confirmTimes='$value[confirmTimes]' ,pay_unlockConfirm='$value[unlockConfirm]' ,pay_walletType='$value[walletType]',pay_ipntype='$pay_ipntype' , pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) , pay_datetime=ADDDATE(now(),INTERVAL 330 MINUTE) ";
			db_query($sql);
	}		
			/*
			[amount] => 29949
            [coin] => TRX
            [network] => TRX
            [status] => 1
            [address] => TJDRnLTkoqrpEVzJRjTdLryQefTdJXGnKd
            [addressTag] => 
            [txId] => Internal transfer 112548303208
            [insertTime] => 1658584836000
            [transferType] => 1
            [confirmTimes] => 1/1
            [unlockConfirm] => 0
            [walletType] => 0
			*/
		 
		 }
	}
}
////update deposit amount /////
   $deposit_count = db_scalar("select count(*) from ngo_binance_deposit where  pay_status!='Paid' and pay_coin='USDT' and pay_txId='$pay_trnid'");
	if ($deposit_count>=1) {
 		$sql_details = "select * from ngo_binance_deposit where pay_coin='USDT' and pay_txId='$pay_trnid'";
		$result_details = db_query($sql_details);
		$line_details= mysqli_fetch_array($result_details);
		@extract($line_details);  
 		$sql = "update ngo_coinpayment set pay_ref_amt1='$pay_amount',pay_ref_amt2='$pay_amount',pay_amount='$pay_amount', pay_txn_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_status='Paid',pay_status_text='Completed' where  pay_trnid='$pay_trnid' ";
        db_query($sql);
         $pay_userid = db_scalar("select pay_userid from ngo_coinpayment where pay_trnid='$pay_trnid'");
       	 $total_count1 = db_scalar("select count(*) from ngo_users_ewallet where pay_userid = '$pay_userid' and pay_transaction_no='$pay_trnid'  and pay_plan='BINANCE'");
         if($total_count1==0 ) {
  			$pay_for = "Deposit txn ID:".$pay_trnid;
			// $pay_amount_usdt = round(($pay_amount/14.2),2);
			$pay_amount_usdt = $pay_amount ; 
            $sql = "insert into ngo_users_ewallet set  pay_userid = '$pay_userid', pay_drcr='Cr', pay_group='CW', pay_unit = '$pay_ipntype' , pay_refid = '$pay_id' ,pay_plan='BINANCE' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount'  ,pay_rate = '100', pay_amount = '$pay_amount_usdt',pay_status='Paid',pay_transaction_no='$pay_trnid',	pay_transfer_date=ADDDATE(now(),INTERVAL 330 MINUTE)  ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
         db_query($sql);
		 $pay_refid = mysqli_insert_id($GLOBALS['dbcon']);
		 
 		 $sql111 = "update ngo_binance_deposit set pay_refid='$pay_refid', pay_userid = '$pay_userid'  ,pay_status='Paid' where  pay_txId='$pay_trnid' ";
         db_query($sql111);
 		
		 header("location:deposit_process_history?action=done");
 		 exit;
		
		
		 
		 
	} 
  	}else {
		$sql = "update ngo_coinpayment set pay_ref_amt2='0', pay_status='Reject',pay_status_text='0' where  pay_trnid='$pay_trnid' ";
        db_query($sql);
	}
	
/* print"<pre>";
 	  print_r($depositHistory);
 print"</pre>"; 
	exit;
	*/
}else {  
	///$depositAddress = $api->depositAddress("TRX","TRX");
	//print_r($depositAddress);
	//$new_address= $depositAddress['address'];
	// mew address set topup of the page get value from database
	
	//SELECT pay_userid  FROM `ngo_users_ewallet` WHERE pay_plan='ADM_FUND' and pay_amount>1000
	// find whom QR code not display
	$u_id = db_scalar("select u_id from ngo_users where u_username = '$_SESSION[sess_username]' and u_id<1000 and u_id in (SELECT pay_userid FROM  ngo_users_ewallet WHERE pay_plan='ADM_FUND' and pay_amount>1000) ");
	if ($u_id=='') {  
		 $deposit_count = db_scalar("select MOD( count(*), 5)  from ngo_coinpayment where pay_group='BINANCE' and pay_ipntype!='BSB'");
	} else {
		// set BCM Code display
		$deposit_count =1;
	}
 	if($deposit_count==0) {
		/// test address
		#$pay_ipntype='BSB';
		#$new_address='TY73vMbeLKjn8vdmFS4QYjQHtR3n5va4GS';
		
		$pay_ipntype='BCM';
		$new_address='TLSA9Xw8DXuNHNg781Z4rtsdGGFu9Dnx2j';
 	} else {
	/// PM BNB company deposit address
		$pay_ipntype='BCM';
		$new_address='TLSA9Xw8DXuNHNg781Z4rtsdGGFu9Dnx2j';
	}
	//$new_address=$u_binance_trusted_ip;
}
///$pgs='buy_token';
 
 if(is_post_back()) {
 	@extract($_POST);
  if ($action == 'Submit')  {
  		if ($pay_trnid=='') { $arr_error_msgs[] =  "Submit Txn ID for complete transaction";}
		//$pay_amount = $pay_amount +($pay_amount/100)*1;
		 $deposit_count = db_scalar("select count(*) from ngo_coinpayment where pay_group='BINANCE' and pay_trnid='$pay_trnid'");
		 if ($deposit_count >0) { $arr_error_msgs[] =  "Txn ID already submitted, please check and submit ";}
		$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		 if (count($arr_error_msgs) ==0) {
		 $pay_amount=0;
 		$sql = "insert into ngo_coinpayment set pay_userid='$_SESSION[sess_uid]' ,pay_group='BINANCE', pay_ipntype='$pay_ipntype', pay_ref_amt1='$pay_amount',pay_amount='$pay_amount' ,pay_trnid='$pay_trnid' , pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) , pay_datetime=ADDDATE(now(),INTERVAL 330 MINUTE),pay_status='Process',pay_currency1='USDT',pay_currency2='USDT'";
		db_query($sql);
		$pay_id = mysqli_insert_id($GLOBALS['dbcon']);
		$action= 'Finish';
		header("location:deposit_process.php?action=Finish&pay_trnid=$pay_trnid");
 		exit;
		} else {
		$action ='Continue';
		 
		}
  }
}

$_SESSION['arr_error_msgs'] = $arr_error_msgs;
/* $sql = "select * from ngo_deposit_req where  creq_id ='$creq_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
*/
  
  
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
<? include("includes/extra_head.php")?>
<? include ("../includes/fvalidate.inc.php"); ?>
</head>
<body class="dt-layout--default dt-sidebar--fixed dt-header--fixed">
<!-- Loader -->
<?  include("includes/loader.php")?>
<!-- /loader -->
<!-- Root -->
<div class="dt-root">
  <div class="dt-root__inner">
    <!-- Header -->
    <? include("includes/header.inc.php")?>
    <!-- /header -->
    <!-- Site Main -->
    <main class="dt-main">
      <!-- Sidebar -->
      <? include("includes/sidebar.php")?>
      <!-- /sidebar -->
      <!-- Site Content Wrapper -->
      <div class="dt-content-wrapper">
        <!-- Site Content -->
        <div class="dt-content">
          <!-- Page Header -->
          <div class="dt-page__header " style="    border-bottom: 1px solid #ddd;">
            <h1 class="dt-page__title">Deposit Request </h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
            <div class="col-xl-12">
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0">
                  <!-- Tables -->
                  <div class="table-responsive">
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p>  
                    <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0"  >
					<tr>
                        <td   align="left" valign="top" >
	<br><strong>1.  Copy address :</strong>  Copy the deposit address. 
    <br><strong>2.  Initiate a withdrawal :</strong> Initiate a withdrawal on the withdrawal platform. 
	<br><strong>3.  Network confirmation  :</strong> Wait for the blockchain network to confirm your transfer.  
	<br><strong>4. Deposit successful:</strong>  After the network confirmation, we will credit the crypto for you.  
 
						</td>
						</tr>
                      <tr>
                        <td   align="center" valign="top" >
				
						
						<? 
		 ///  $FUND_DEPOSIT_STATUS  = round(db_scalar("select sett_value from ngo_setting where sett_code = 'FUND_DEPOSIT_STATUS'"),0); 
		  $FUND_DEPOSIT_STATUS =1;
		if ($FUND_DEPOSIT_STATUS=='1') { ?>
                          <br />
                          <?   if ($action == '')  { ?>
                          <form method="post" name="form1" id="form1"  <?= validate_form()?>>
                            <table width="100%"  border="0" cellpadding="1" cellspacing="1" class="td_box">
                              <tr>
                                <td align="left" colspan="2">
								<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?=$new_address?>&choe=UTF-8" width="220" height="220" />
                                  <p align="left" class="on-mobile-text-center"><br>
							    </td>
                              </tr>
                              <tr>
                               
							    <td width="21%" align="left">TRC20 USDT Deposit Address : </td>
								 <td align="left">
								  
                                    
                                    <span style="color:#000">
                                    <input class="on-mobile-input" style="width:auto; width:320px; background:none; color:#000; border:none;" type="text" value="<?=$new_address?>" readonly="" id="myInput1">
                                </span> <i class="fa fa-copy" onClick="myFunction()" style="color:#000; cursor:pointer;"></i></p></td>
                              </tr>
                              <tr>
                                <td width="21%" align="left">Amount(TRC20 USDT) : </td>
                                <td width="79%" align="left"> 
                                  <input type="text" name="pay_amount" id="pay_amount" class="form-control input-type-1" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />                                </td>
                              </tr>
                              <tr>
                                <td align="left">&nbsp;</td>
                                <td height="100" align="left">
                                   
 								  <input type="hidden" name="new_address" id="new_address" value="<?=$new_address?>" />
								<input type="hidden" name="pay_ipntype" id="pay_ipntype" value="<?=$pay_ipntype?>" />
                                  <input type="hidden" name="action" value="Continue" />
                                  <input name="Submit" type="submit"  class="btn btn-primary mt-3" value="Continue" />
                                  &nbsp;&nbsp;
                                  <!--<input name="Reset" type="reset" class="button" value=" Reset " />-->                                </td>
                              </tr>
                              <tr>
                                <td height="100" colspan="2" align="left"> 
  
<ul>

<!--<li> Expected arrival :  1 network confirmations</li>
<li> Expected unlock :  1 network confirmations</li>
--><li> Minimum deposit :  1 USDT</li>
   <li>Send only&nbsp;<span data-bn-type="text">USDT</span>&nbsp;to this deposit address.</li>
  <li>Ensure the network is&nbsp;<span data-bn-type="text">Tron (TRC20)</span>.</li>
  <li>Do not send NFTs to this address.&nbsp; </li>
</ul></td>
                              </tr>
                            </table>
                          </form>
                          <? } else if ($action == 'Continue') { ?>
                          <form method="post" name="form1" id="form1"  <?= validate_form()?>>
                            <table width="100%"  border="0" cellpadding="1" cellspacing="1" class="td_box" >
                              <tr>
                                <td  align="center"class="td_box"><input type="text" name="pay_trnid" class="form-control input-type-1 " placeholder="USDT Txansaction / HASH Code" value="<?=$pay_trnid?>"  />
                                </td>
                              </tr>
                              <tr>
                                <td align="center">
								<input type="hidden" name="new_address" id="new_address" value="<?=$new_address?>" />
								<input type="hidden" name="pay_ipntype" id="pay_ipntype" value="<?=$pay_ipntype?>" />
								
								<input type="hidden" name="action" value="Submit" />
                                  <input name="Submit" type="submit"  class="btn btn-primary mt-3" value="Submit"  />
                                </td>
                              </tr>
                              <tr>
                                <td align="left"><br>
                                  <br>
                                  <span style="color:#FFffff"> Note: Go to you wallet and copy  correct Txid/HASH  ID from wallet and input in above box to complete your transaction.</span> </td>
                              </tr>
                            </table>
                          </form>
                          <? } else if ($action == 'Finish') { ?>
                          <table width="100%"  border="0" cellpadding="1" cellspacing="1" >
                            <tr class="tdhead">
                              <td align="center" valign="middle"   class="tdhead"> Deposit Confirmation </td>
                            </tr>
                            <tr>
                              <td  align="center"class="td_box"><br>
                                <br>
                                Your deposit request submitted successfully, status will update soon. <br>
                                <br>
                              </td>
                            </tr>
                          </table>
                          <? }  ?>
                          <?  } else { ?>
                          <br />
                          <span class="error" >Deposit request temporarily not available at this time.</span> <br />
                          <br />
                          <br />
                          <br />
                          <br />
                          <?  }  ?>
                        </td>
                      </tr>
                    </table>
					
			 </div>
                  <!-- /tables -->
                </div>
                <!-- /card body -->
              </div>
              <!-- /card -->
            </div>
           
          </div>
          <!-- /grid -->
        </div>
        <!-- Footer -->
        <? include("includes/footer.php")?>
        <!-- /footer -->
      </div>
      
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
<? include("includes/extra_footer.php")?>
</body>
</html>
