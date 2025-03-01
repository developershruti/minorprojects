<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
#print_r($_POST);
if(is_post_back()) {


 			 
			///////////////////////////////////   from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id 
		    $sql_gen = "select *  from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id  and topup_status='Unpaid' ";
			
			if ($g_amount!='') 						{$sql_gen .= " and topup_amount='$g_amount' ";}
			if (($g_id1!='') && ($g_id2!='')) 		{$sql_gen .= " and (topup_userid  between $g_id1  and  $g_id2 )";} 
 			if (($gdatefrom!='') && ($gdateto!=''))	{$sql_gen .= " and topup_date between '$gdatefrom' AND '$gdateto' "; }
 			// print " <br> Giver = ".$sql_gen ;
 			$result_gen = db_query($sql_gen);
			$ctr=0;
			while($line_gen = mysqli_fetch_array($result_gen)) {
 			//pay_plan='BANK_WITHDRAW' and 
			//////////////// taker details
			
			$sql_taker = "select *  from ngo_users_payment ,ngo_users  where ngo_users_payment.pay_userid=ngo_users.u_id and  pay_drcr='Dr' and pay_plan='BANK_WITHDRAW' and pay_status='Unpaid'  ";
			if ($t_amount!='') 						{$sql_taker .= " and pay_amount='$t_amount' ";}
			if (($t_id1!='') && ($t_id2!='')) 		{$sql_taker .= " and (pay_userid  between $t_id1  and  $t_id2 )";} 
 			if (($tdatefrom!='') && ($tdateto!=''))	{$sql_taker .= " and pay_date between '$tdatefrom' AND '$tdateto' "; }
			$sql_taker .= "  limit $ctr ,1 ";  
			// print " <br> taker = ".$sql_taker;
			$ctr++;
  			$result_taker = db_query($sql_taker);
			$line_taker = mysqli_fetch_array($result_taker);
 			//and 
			///////////////////
			
			
 			$gift_refno  = $line_taker[pay_id];
			$gift_userid = $line_taker[pay_userid];
 			$gift_amount = $g_amount;
 			// withdrawal amount and total get help amount
			$total_get_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_userid='$gift_userid' and gift_refno='$gift_refno'  and gift_status!='Reject' ")+0;
			$withdrawal_pay_amount =db_scalar("select pay_amount from ngo_users_payment  where pay_plan='BANK_WITHDRAW' and pay_id='$gift_refno'");
 			if ($withdrawal_pay_amount >$total_get_amount) { 
			
			// check help provide amount and request amount
			$total_provided_amount=db_scalar("select sum(gift_amount) from ngo_users_gift where gift_by_userid='$line_gen[topup_userid]' and gift_topupid='$line_gen[topup_id]'  and gift_status!='Reject'")+0; 			
			$balance_amount = $line_gen[topup_amount] - $total_provided_amount;
  			//print " $gift_username: $gift_userid =   $total_provided_amount =  $balance_amount =      ";
			if ($balance_amount >= $gift_amount) {
  				if ($gift_userid!='') {
					$u_parent_id = db_scalar("select gift_id from ngo_users_gift  order by gift_id desc limit 0,1")+1;
					$gift_id_refno =  '5HT'.rand(100,999).$u_parent_id.rand(100,999);
						
					$sql_insert="insert into ngo_users_gift set gift_userid = '$gift_userid',gift_id_refno = '$gift_id_refno' ,gift_by_userid='$line_gen[topup_userid]' ,gift_topupid='$line_gen[topup_id]',gift_group='COMMITED',gift_refno='$gift_refno' ,gift_amount='$gift_amount' ,gift_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 4350 MINUTE),gift_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_status='New'";
					 db_query($sql_insert);
					
					$msg.= "( $line_gen[u_username] => $line_taker[u_username]), ";
					// send help confirmation msg sms to user 
 					$to_fname  = $line_taker[u_fname].'/'. $line_taker[u_username];
					$to_mobile =  $line_taker[u_mobile];
					//  send sms to provider help mobile
					$from_mobile = $line_gen[u_mobile] ;
					//"Dear Sender name & user name, please GIVE HELP of Rs 5000 to Mr, Receiver Name/ User name /mobile no with in 120 hrs. Thanks My Helping World"
					$from_message = "Dear $line_gen[u_fname] & $line_gen[u_username], please GIVE HELP of Rs $gift_amount to $to_fname / $to_mobile with in 60 hrs. Thanks " .SITE_URL ;
 					send_sms($from_mobile,$from_message);
					//  send sms to get help mobile
					
					// "Dear Reciever name & user name, please GET HELP of Rs 5000 from Sender Name/ User name /mobile no with in 120 hrs. Thanks My Helping World"
					$to_message = "Dear $to_fname, please GET HELP of Rs $gift_amount from Sender $line_gen[u_fname] / $line_gen[u_username]/ $line_gen[u_mobile] with in 60 hrs. Thanks " .SITE_URL ;
 					send_sms($to_mobile,$to_message);
					
					
					
					
 // send Provide Help email 
$to_email =  $line_gen[u_email] ; 		 
$to_message="
Dear ". $line_gen[u_fname]  .", 

Help  Details

You have a request to send a help amount $gift_amount to  ($to_fname) within 60 hrs 
 
http://www.". SITE_URL ." 
Help Amount = ". $gift_amount ."
Receiver Name = ".$to_fname. "
Contact No  = ".$to_mobile. "
 
Thank you !

". SITE_NAME ."
http://www.". SITE_URL ."
";
$HEADERS  = "MIME-Version: 1.0 \n";
$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
$SUBJECT  = SITE_NAME." Support Help Details ";
if ($to_email!='') {  @mail($to_email, $SUBJECT, $to_message,$HEADERS); }
$_SESSION[POST]='';
//

// send Get Help email 
$from_email =  $line_taker[u_email] ; 		 
$from_message="
Dear ". $to_fname.", 

Get Help 

You have received an offer to receive Support amount $gift_amount from  ($line_gen[u_fname]) within 48 hrs 
 
http://www.". SITE_URL ." 
Help Amount = ". $gift_amount ."
Sender Name = ".$line_gen[u_fname]. "
Sender Contact No  = ".$line_gen[u_mobile]. "
 
Thank you !

". SITE_NAME ."
http://www.". SITE_URL ."
";
$HEADERS  = "MIME-Version: 1.0 \n";
$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
$SUBJECT  = SITE_NAME." Support Help Details ";
if ($from_email!='') {  @mail($from_email, $SUBJECT, $from_message,$HEADERS); }
$_SESSION[POST]='';
//
				//$arr_error_msgs[] = "Success :Support Amount successfully sent.";
				$_SESSION['arr_error_msgs'] = $arr_error_msgs;	

 				}	 
				}
			
			}
 			}	 
			//////////////////////////////////////////////
			
}

 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead">User Help Order in Bulk </div></td>
        </tr>
      </table>
      <div align="right"><a href="users_payment_list.php">Back to Payment List</a>&nbsp;</div>
      <div align="center" class="errorMsg"><?=$msg?></div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <table width="683"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
          <tr>
            <th colspan="4" align="left"  > Help Giver </th>
          </tr>
		  
          <tr>
            <td width="129" align="right" class="tdLabel">Giver Auto ID From : </td>
            <td width="120"  ><input name="g_id1" style="width:120px;" type="text" value="<?=$g_id1?>" alt="number" emsg="Please enter giver user auto id from"  />            </td>
            <td width="104" align="right"> <span class="tdLabel">Giver ID</span> To : </td>
            <td width="179"><input name="g_id2" style="width:120px;"type="text" value="<?=$g_id2?>" alt="number" emsg="Please enter giver user auto id to" />            </td>
          </tr>
          <tr class="tableSearch">
            <td align="right"><span class="tdLabel">Giver </span>Commit  Date  From: </td>
            <td valign="top"><?=get_date_picker("gdatefrom", $gdatefrom)?></td>
            <td align="right"><span class="tdLabel">Giver</span> Commit Date To : </td>
            <td><?=get_date_picker("gdateto", $gdateto)?></td>
            <input type="hidden" name="u_id" value="<?=$u_id?>"/>
          </tr>
          <tr>
            <td align="right" id="right">Giver  Amount : </td>
            <td id="left"><input name="g_amount" style="width:120px;"type="text" value="<?=$g_amount?>" alt="number" emsg="Please enter giver amount" /></td>
            <td align="right" class="tdData">&nbsp;</td>
            <td class="txtTotal">&nbsp;</td>
          </tr>
         </table>
        <br />

		  <table width="683"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
		  <tr>
            <th colspan="4" align="left"  > Help Taker </th>
          </tr>
          <tr>
            <td align="right" class="tdLabel">Taker Auto ID From : </td>
            <td  ><input name="t_id1" style="width:120px;" type="text" value="<?=$t_id1?>" alt="number" emsg="Please enter taker user auto id from">            </td>
            <td align="right"><span class="tdLabel">Taker ID</span> To : </td>
            <td><input name="t_id2" style="width:120px;"type="text" value="<?=$t_id2?>" alt="number" emsg="Please enter taker user auto id to" />            </td>
          </tr>
          <tr>
            <td align="right"><span class="tdLabel">Taker </span>Withdrawal Date  From: </td>
            <td valign="top"><?=get_date_picker("tdatefrom", $tdatefrom)?></td>
            <td align="right"><span class="tdLabel">Taker</span> Withdrawal Date To : </td>
            <td><?=get_date_picker("tdateto", $tdateto)?></td>
          </tr>
          
          <tr>
            <td align="right" id="right">Taker Amount : </td>
            <td id="left"><input name="t_amount" style="width:120px;"type="text" value="<?=$t_amount?>" alt="number" emsg="Please enter taker amount" /></td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		  <br />

		  <table width="683"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
        <tr>
		<td width="170" align="right" id="right">   </td>
		<td width="323" id="left"> </td>
          <td width="178" id="content"><input type="submit" name="Submit" value="Submit" /> </td>
        </tr>
        <tr>
          <td colspan="3" align="left"  > 
		  Note : <br />
		  <br />1. All Help request order generate with same Giver Amount.
		  <br />2. You must enter all information in search box to process help order
		  <br />3. Widthrawal (Taker Amount) will be use only for to filter taker list
		  <br />4. Call for any tech support

</td>
          </tr>
      </table>
		
      </form>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
