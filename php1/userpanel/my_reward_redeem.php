<?php
include ("includes/surya.dream.php");
protect_user_page();

$result_win = db_query("select * from ngo_rewards_winner  where  win_userid='$_SESSION[sess_uid]'");

if (mysqli_num_rows($result_win)) {
	$line_win = mysqli_fetch_array($result_win);	
	@extract($line_win);
	$result_rewa = db_query("select * from ngo_rewards   where  rewa_id ='$win_rewaid' ");
	$line_rewa = mysqli_fetch_array($result_rewa);	
	@extract($line_rewa);
 	$arr_error_msgs[] ="Reward redeem request already submitted.";
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
	
	
} else { 

$sql_part = " and topup_date between '2013-01-01' AND '2013-01-31' "; 
$u_id_a = db_scalar("select u_id from ngo_users  where u_status='Active' and  u_sponsor_id ='$_SESSION[sess_uid]' and u_ref_side='A' limit 0,1");
$win_used_left = binary_total_paid_ids($u_id_a,$sql_part)+0;
$u_id_b = db_scalar("select u_id from ngo_users  where u_status='Active' and u_sponsor_id ='$_SESSION[sess_uid]' and u_ref_side='B' limit 0,1");
$win_used_right = binary_total_paid_ids($u_id_b,$sql_part)+0;

if ($win_used_left >=$win_used_right) { $total_id=$win_used_right; }  else {  $total_id=$win_used_left;} 
#print " $_SESSION[sess_username] -- $win_used_left = $win_used_right  = $total_id ";
//	// select * from ngo_rewards where rewa_total_id<=200 order by rewa_total_id desc limit 0,1

 
$result_rewa = db_query("select * from ngo_rewards  where  rewa_total_id  <=$total_id   order by rewa_total_id desc limit 0,1");
$line_rewa = mysqli_fetch_array($result_rewa);		
@extract($line_rewa);

//print_r($_SESSION);
 if(is_post_back()) {
  
  
  $total_winner = db_scalar("select count(win_id) from ngo_rewards_winner where win_userid= '$_SESSION[sess_uid]'");
		 
		if ($total_winner==0) {
 		$win_rewaid = $line_rewa[rewa_id];
		$win_reward_desc= $line_rewa[rewa_name] . $line_rewa[rewa_description];
		$win_price = $line_rewa[rewa_price];
  		//win_redeem_in='$win_redeem_in',
	  	$sql = "insert into ngo_rewards_winner set  win_userid= '$_SESSION[sess_uid]', win_rewaid='$win_rewaid',  win_reward_desc='$win_reward_desc', win_used_left='$win_used_left', win_used_right='$win_used_right', win_used_direct='$win_used_direct', win_price='$win_price', win_mailling_name='$win_mailling_name', win_mailling_address='$win_mailling_address', win_mailling_city='$win_mailling_city', win_mailling_state='$win_mailling_state', win_mailling_country='$win_mailling_country', win_mailling_zip='$win_mailling_zip', win_mailling_tele='$win_mailling_tele', win_mailling_email='$win_mailling_email', win_rec_amount='$win_rec_amount', win_rec_userid='$win_rec_userid', win_rec_name='$win_rec_name', win_rec_date='$win_rec_date', win_rec_contact='$win_rec_contact'  ,win_date=now() ";
		 db_query($sql);
 		 $win_id = mysql_insert_id();
 		
		$pay_for1 = "Reward Fund Received  for $win_reward_desc  ";
		$sql1 = "insert into ngo_users_payment set  pay_drcr='Cr',  pay_userid = '$_SESSION[sess_uid]',pay_refid = '$win_id' ,pay_plan='REWARD' , pay_group='GIFT' ,pay_transaction_no='$pay_plan' ,pay_for = '$pay_for1' ,pay_ref_amt='$win_price' ,pay_unit = 'Fix' ,pay_rate = '0', pay_amount = '$win_price',pay_status='Paid' ,pay_date=ADDDATE(now(),INTERVAL 120 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 720 MINUTE) ";
		 db_query($sql1);
 
 
$message="
 

Dear ". $u_username .",

Your request submitted successfully for redeem reward. 

Please send your feed back once you will receive rewards.


Regards

". SITE_NAME ."  team 

  ";
		$EMAILL_REC= $_SESSION['sess_uemail'];
		if ($EMAILL_REC!='') {
			$HEADERS  = "MIME-Version: 1.0 \n";
			$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
			$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
			$SUBJECT  = "Reward redeem request confirmation";
			@mail($EMAILL_REC, $SUBJECT, $message,$HEADERS);
		}
	 
	$arr_error_msgs[] ="Reward redeem request  submitted successfully.";
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
	#header("Location: my_reward_redeem.php");
	#exit;
	}
}
 
} 
  
?> 

 
 <!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

 <head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?=$META_TITLE?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php include("includes/extra_file.inc.php");?>
 <script type="text/javascript" src="js/modernizr.custom.11889.js" ></script>
 <?php include("includes/fvalidate.inc.php");?>
     </head>
<body>

	<!-- Primary Page Layout
	================================================== -->

<div id="wrap">
 <?php include("includes/header.inc.php");?>

 <!-- end-header -->
<section id="headline2">
<div class="container">
<h3>Redeem your  Achived Reward </h3>
</div>
</section>

<section class="container page-content" >

<section id="main-content">
 
<div class="columns" >
 
</div>
  
        
        <table width="99%" border="0" align="center" cellpadding="2" cellspacing="2"  class="td_box">
      <tr>
                
                  <td  valign="top" class="errortxt"><? include("error_msg.inc.php");?> 

                  </td>
				 
                </tr>
         <tr>
         <td  align="center" valign="top"  class="maintxt"  ><br>
		  <? if ($rewa_id=='') { ?>
		  <span class="error">No reward achived yet! </span>
		  
		  
		 <? } else {
		 
		 
		  if ($win_rewaid!='') { ?>
		 
		  <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
               <tr>
                 <td class="title"  colspan="2">Reward Point Redeem  in Pin Purchase Account</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td width="29%" align="right"> My Achived Reward: </td>
				   <td width="71%"> <strong><?=$line_rewa['rewa_name'];?></strong></td>
               </tr>
			   <tr>
                 <td width="29%" align="right"> Total Reward Fund : </td>
				   <td width="71%"> <strong><?=price_format($line_rewa['rewa_price']);?></strong></td>
               </tr>
			   
			    <? if  ($win_redeem_in=='PRICE') { ?>
			   
			    <tr>
                 <td  colspan="2" class="maintxt">Note: Reward price transfered in you Pin Purchase Account.  </td>
				 
               </tr>
			   
			   <? }  else { ?>
			   
			   
			   <!-- <tr>
                        <td class="subtitle" colspan="2" > <h3>Product Dispatch Address</h3></td>
                       
                      </tr>
			   
			    <tr>
                        <td align="right" valign="top" class="maintxt">Contact Name<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"> <?=$win_mailling_name?> </span></td>
                      </tr>
					  
					  
			     <tr>
                        <td align="right" valign="top" class="maintxt">Address<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"><?=$win_mailling_address?></span></td>
                      </tr>
                       
	<tr>
                        <td align="right" valign="top" class="maintxt">City<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"><?=$win_mailling_city?> </span></td>
                      </tr>
                      
                      <tr>
                        <td align="right" valign="top" class="maintxt">State<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"><?=$win_mailling_state?> </span></td>
                      </tr>
                   
                     <tr>
                        <td align="right" valign="top" class="maintxt">Country<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"> <?=$win_mailling_country?> </span></td>
                      </tr>
					  
					  <tr>
                        <td align="right" valign="top" class="maintxt">Phone<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"> <?=$win_mailling_tele?> </span></td>
                      </tr>
					  
					
						 
					  <tr>
                        <td align="right" valign="top" class="maintxt">Postal Code<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"> <?=$win_mailling_zip?> </span></td>
                      </tr>
			    <tr>
                        <td align="right" valign="top" class="maintxt">Email   </td>
                        <td align="left" valign="top"><span class="maintxt"> <?=$win_mailling_email?> </span></td>
                      </tr> -->
			    
			   <? }   ?>
			   
             </table>
		  </td>
         </tr>
		 <? }  else { ?>
		 
		  <tr>
         <td height="200" align="center" valign="top"  class="maintxt"><br>
		    <form name="reward_redeem" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data"  <?= validate_form()?>>
		     <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
               <tr>
                 <td class="title"  colspan="2">Reward Point Redeem  in Pin Purchase Account </td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td width="29%" align="right"> Reward Achived : </td>
				   <td width="71%"> <strong><?=$line_rewa['rewa_name'];?></strong></td>
               </tr>
			   <tr>
                 <td width="29%" align="right"> Total Reward Price : </td>
				   <td width="71%"> <strong><?=price_format($line_rewa['rewa_price']);?></strong></td>
               </tr>
			  
			   
			   <tr>
                 <td width="29%" align="right"> </td>
				   <td width="71%">  
				   <input type="hidden" name="win_redeem_in" value="PRICE">
 				   <input type="submit" name="Submit" value="Redeem Reward Price"  style="width:180px;"></td>
               </tr>
			   
             </table>
           </form>
		   </td>
         </tr>
          
		   <!-- <tr>
         <td height="200" align="center" valign="top" class="maintxt"><br>
 		   <form name="reward_redeem" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data"  <?= validate_form()?>>
		     <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td class="title" colspan="2" >Redeem Reward Fund   </td>
                </tr>
               <tr>
                 <td  colspan="2"> please fill your mailling address where you get your achived rewards.</td>
                </tr>
 			     <tr>
                 <td width="29%" align="right" class="maintxt"> Rewarch Achived : </td>
				   <td width="71%" class="maintxt"> <strong><?=$line_rewa['rewa_name'];?></strong></td>
               </tr>
			    
			   <tr>
                        <td align="right" valign="top" class="maintxt">Contact Name<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="win_mailling_name" type="text" class="txtbox" id="win_mailling_name" style="width:200px;" value="<?=$win_mailling_name?>"  alt="blank" emsg="Please enter  contact name"/>
                        </span></td>
                      </tr>
					  
					  
			     <tr>
                        <td align="right" valign="top" class="maintxt">Address<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt">
                          <textarea name="win_mailling_address" cols="30" rows="3"   id="win_mailling_address"  alt="blank" emsg="Please enter address"><?=$win_mailling_address?></textarea>
                        </span></td>
                      </tr>
                       
	<tr>
                        <td align="right" valign="top" class="maintxt">City<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="win_mailling_city" type="text" class="txtbox" id="win_mailling_city" style="width:200px;" value="<?=$win_mailling_city?>"  alt="blank" emsg="Please enter city"/>
                        </span></td>
                      </tr>
                      
                      <tr>
                        <td align="right" valign="top" class="maintxt">State<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="win_mailling_state" type="text" class="txtbox" id="win_mailling_state" style="width:200px;" value="<?=$win_mailling_state?>" alt="blank" emsg="Please enter state"/>
                         </span></td>
                      </tr>
                   
                     <tr>
                        <td align="right" valign="top" class="maintxt">Country<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt"><?
						 if ($u_country=='') {$u_country=99;} 
						 $sql ="select countries_name , countries_name from ngo_countries order by countries_id";  
						echo make_dropdown($sql, 'win_mailling_country', $win_mailling_country,  'class="txtbox" alt="select"  style="width:200px;" emsg="Please Enter country"', 'Please select'); 
							?>
                        </span></td>
                      </tr>
					  
					  <tr>
                        <td align="right" valign="top" class="maintxt">Phone<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="win_mailling_tele" type="text" class="txtbox" id="win_mailling_tele" style="width:200px;" value="<?=$win_mailling_tele?>" />
                        </span></td>
                      </tr>
					  
					
						 
					  <tr>
                        <td align="right" valign="top" class="maintxt">Postal Code<span class="error"> *</span></td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="win_mailling_zip" type="text" class="txtbox" id="win_mailling_zip" style="width:200px;" value="<?=$win_mailling_zip?>" alt="blank" emsg="Please enter zip code"/>
                        </span></td>
                      </tr>
			    <tr>
                        <td align="right" valign="top" class="maintxt">Email   </td>
                        <td align="left" valign="top"><span class="maintxt">
                          <input name="win_mailling_email" type="text" class="txtbox"  id="win_mailling_email"    style="width:200px;" value="<?=$win_mailling_email?>" />
                        </span></td>
                      </tr> 
						   
			    <tr>
                 <td width="29%" align="right"> </td>
				   <td width="71%"> 
				    <input type="hidden" name="win_redeem_in" value="PRODUCT">
				   
				    <input type="submit" name="Submit" value="Redeem Reward"  style="width:180px;"></td>
               </tr>-->
			    
             
          
		   
		 
		   
		 
		  <? } 
		  
		  }
		   ?> </td>
         </tr>
      </table>
	  
</section>

<!-- end-main-conten -->
   <? include("includes/right.inc.php")?>
<!-- end-sidebar-->
<div class="white-space"></div>
</section><!-- container -->
        
            
           
        <!-- #main -->
    
        <!-- #sidebar -->
      </div>
      <!-- .inner -->
    </section>
    <!-- .pagemid -->
    <? include("includes/footer.inc.php")?>
    <!-- .footer -->
  </div>
  <!-- .wrapper -->
</div>
</body>
</html>
    
  
        
       
	    
 