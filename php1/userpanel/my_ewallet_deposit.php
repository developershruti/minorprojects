<?php

include ("../includes/surya.dream.php");

$a="buy_btc_fund"; 

 protect_user_page();

 $arr_error_msgs = array();

 if(is_post_back()) {

 

if ($_POST['Submit']=='Continue') {}



	//$total_topup= db_scalar("select sum(topup_amount) from ngo_users_recharge  where topup_userid ='$_SESSION[sess_uid]'  ")+0;



	if ($amountUSD<1 && $total_topup==0) { $arr_error_msgs[] =  "Minimum Load Amount $1" ;}  

 	$_SESSION['arr_error_msgs'] = $arr_error_msgs;

		//check if there is no error

		

		if (count($arr_error_msgs) ==0) {

		

/*$result_topup 	= db_query("select * from ngo_users_type  where utype_id = '$utype_id'");

$line_topup  	= mysql_fetch_array($result_topup);

$amountUSD 	= $line_topup['utype_charges'] ;

$orderID	= $line_topup['utype_code'] ;*/

//$orderID	= '125478' ;

 /*

	 $sqlInsert = "insert into ngo_bitcoin_log  set btc_userid='$_SESSION[sess_uid]', btc_group='BTC' , btc_usd='$amountUSD', btc_amount='$amountUSD', btc_string='$btc_string', btc_ip='$btc_ip', btc_status='Unpaid',btc_date=now()";

	db_query($sqlInsert);

	$orderID = mysql_insert_id();*/

 	

	

 ////////////////////////////////////////API///////////////////////////////////////

 	require_once( "../cryptoapi_php/cryptobox.class.php" );

	//$amountUSD = ($amountUSD*80)/65;

	$amountUSD = round(($amountUSD+($amountUSD/100)*0.35),0);

	/**** CONFIGURATION VARIABLES ****/ 

	$orderID		= $_SESSION['sess_uid'].'-'.$amountUSD;

	$userID 		= $_SESSION['sess_uid'];			// place your registered userID or md5(userID) here (user1, user7, ko43DC, etc).

													// your user should have already registered on your website before   

	$userFormat		= "COOKIE";						// this variable ignored when you use $userID 

	$orderID 		= $orderID;						// premium membership order
 	//$amountUSD		= 0.41;	 						// price per membership - 79 USD
 	$period			= "12 MONTH";					// one month membership; after need to pay again

	$def_language	= "en";				// default Payment Box Language

	$public_key		= "46974AA6N7gWBitcoin77BTCPUBGFgpzrTtuiGFJW7Brv1yVXv"; // from gourl.io

	$private_key	= "46974AA6N7gWBitcoin77BTCPRVNpOkNJ7lC7IvVgUnixjcLXV";// from gourl.io



	// IMPORTANT: Please read description of options here - https://gourl.io/api-php.html#options  

	

	/********************************/





	

	

	

	/** PAYMENT BOX **/

	$options = array(

			"public_key"  => $public_key, 	// your public key from gourl.io

			"private_key" => $private_key, 	// your private key from gourl.io

			"webdev_key"  => "DEV1304G201D8B8A2AE9F9BG105914227",// optional, gourl affiliate key skskks

			"orderID"     => $orderID, 		// order id

			"userID"      => $userID, 		// unique identifier for every user

			"userFormat"  => $userFormat, 	// save userID in COOKIE, IPADDRESS or SESSION

			"amount"   	  => 0,				// price in coins OR in USD below

			"amountUSD"   => $amountUSD,	// we use price in USD

			"period"      => $period, 		// payment valid period

			"language"	  => $def_language  // text on EN - english, FR - french, etc

	);



//print_r($options);

	// Initialise Payment Class

	$box = new Cryptobox ($options);

	

	// coin name

	$coinName = $box->coin_name(); 

	

	

	// Successful Cryptocoin Payment received

	if ($box->is_paid())

	{

		// one time action

		if (!$box->is_processed())

		{

			// One time action after payment has been made

					

			$message = "Thank you (order #".$orderID.", payment #".$box->payment_id()."). We upgraded your account with paid Amount";

	

			// Set Payment Status to Processed

			$box->set_status_processed();

			/////////////// 

			

			

			//////////////////////////////////////insert the package in database

   		/*$sql = "insert into  ngo_users_recharge set topup_userid = '$_SESSION[sess_uid]' ,topup_by_userid='$_SESSION[sess_uid]',topup_serialno='$code_id', topup_code='$code_string', topup_plan='TOPUP' ,topup_days_for='$topup_days_for' ,topup_rate='$topup_rate' ,topup_amount='$amountUSD' ,topup_date=ADDDATE(now(),INTERVAL 480 MINUTE) ,topup_datetime=ADDDATE(now(),INTERVAL 480 MINUTE) ,topup_status='Paid' ";

		db_query($sql);

		$topup_id = mysql_insert_id();*/

 			////////////////////////////////////////////////

			

		}

		else $message = "Thank you";

	}



	

	

	// Optional - Language selection list for payment box (html code)

	$languages_list = display_language_box($def_language);











	// ...

	// Also you can use IPN function cryptobox_new_payment($paymentID = 0, $payment_details = array(), $box_status = "") 

	// for send confirmation email, update database, update user membership, etc.

	// You need to modify file - cryptobox.newpayment.php, read more - https://gourl.io/api-php.html#ipn

	// ...

  //////////////////////////API end//////////////////////////////////

 }	

 }	



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
            <h1 class="dt-page__title"> Deposit Throught Bitcoin Payment  !</h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row" >
            <!-- Grid Item --><div class="col-xl-3"  style="padding:20px;">
			</div>
            <div class="col-xl-6"  style="padding:20px;">
              <div class="dt-card overflow-hidden"   style="padding:20px;">
                <!-- Card Body -->
                <div class="dt-card__body p-0"  style="padding:20px;">
                  <!-- Tables -->
                  <div class="table-responsive"   >  
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                      <?=$msgs?>
                    </p>
                    <form name="changepassword" method="post" action=""  class="forms-sample" enctype="multipart/form-data"  <?= validate_form()?>>
                    <form action="" method="post" <?= validate_form()?>  class="forms-sample" >
                      <? if ($Submit=='Continue') { ?>
                      <table width="50%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td   align="left" valign="top"  colspan="2"><?php if ($box->is_paid()): ?>
                            <?php echo $message; ?>
                            <?php else: ?>
                            <!-- Awaiting Payment -->
                            <!-- 

	<br><br><br>	

	<h3>Purchase Package ( $<?php echo $amountUSD; ?> per <?php echo $period; ?> ) - </h3>-->
                            <?php endif; ?>
                            <div style='font-size:12px;margin:50px 0 5px 370px'>Language: &#160; <?php echo $languages_list; ?></div>
                            <?php echo $box->display_cryptobox(true, 740, 300, "padding:3px 6px;margin:10px;border:10px solid #f7f5f2;"); ?> </td>
                        </tr>
                      </table>
                    </form>
                    <? } else { ?>
                    <form action="<?=$_SERVER['PHP_SELF']?>"  method="post" <?= validate_form()?>  class="forms-sample" >
                      <table width="100%" border="0" cellpadding="2" cellspacing="2" >
                        
						<tr>
						<td width="20%" align="center" valign="top" rowspan="2"><img width="150px;" src="images/bit-left-img.png"/></td>
                          <td width="40%" align="left" valign="top" class="maintxt" style="color:#000"><strong> Amount($) : </strong>  <br><br>


                            <!--<div class="form-group"> <span>Enter Amount</span>-->
                              <input name="amountUSD"  type="text" class="form-control"  value="<?=$amountUSD?>"  alt="blank" emsg="Please enter minimum $100 "   placeholder="Amount ($)"   width="100%"  required/>
                            </div></td>
                        </tr>
                        <tr>
                          
                          <td align="left" valign="baseline"><button name="Submit" type="submit" value="Continue" class="btn btn-primary mr-2">Continue</button></td>
                        </tr>
                      </table>
                    </form>
                    <? } ?>
                    </form>
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
