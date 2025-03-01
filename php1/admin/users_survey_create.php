<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 #print_r($_POST);
 
  if(is_post_back()) {
  $u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_username2'"); 
if ($u_userid!='') {
	$id = array();
	$id[]=$u_userid;
	while ($sb!='stop'){
	if ($referid=='') {$referid=$u_userid;}
	$sql_test = "select u_id  from ngo_users  where  u_sponsor_id in ($referid)  ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	print $id_in = implode(",",$id);
	if ($id_in!='') {
 		$u_id = db_scalar("select u_id from ngo_users where u_id in ($id_in) ");
		if ($u_id=='') { $msg = "Invalid User ID ";}
 	}
 
}
  
 	if ($poll_id=='') { $msg="Please enter SMS ID whom you want to generate payout"; } 
 	$survey_count = db_scalar("select count(id) from ngo_pollv2 where  id = '$poll_id' ");
	if ($survey_count=='' || $survey_count=='0') { $msg="Invalid SMS ID please check "; } 
 	if($survey_count>=1) { 	
		
 	$sql_gen = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid   and u_status!='Banned' and topup_status!='Close' ";
  	
	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
 	else {
		$auto_id = db_scalar("select u_id from ngo_users where u_username = '$u_username1'");
		$sql_gen .= " and u_id ='$auto_id' ";
	}
 	 
	#print $sql_gen;
   	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	$survey_count = db_scalar("select count(survey_id) from ngo_users_survey where  survey_userid = '$u_id' and survey_topupid='$topup_id'  and survey_poll_id = '$poll_id' ");
	
	if($survey_count==0) { 
	
	$pay_date = db_scalar("select  created from ngo_pollv2 where  id = '$poll_id' ");
   		if ($pay_date >= $topup_date){
		$msg .= $u_username." ,";
			$survey_amount = db_scalar("select topup_rate from ngo_users_recharge  where topup_id = '$topup_id' limit 0,1");
 			$sql = "insert into ngo_users_survey set  survey_userid = '$u_id' ,survey_topupid='$topup_id' ,survey_poll_id='$poll_id' ,survey_rate='$survey_amount',  survey_amount = '$survey_amount' ,survey_date = ADDDATE('$pay_date',INTERVAL 750 MINUTE), survey_pay_date = ADDDATE('$pay_date',INTERVAL 15 DAY), survey_datetime = ADDDATE('$pay_date',INTERVAL 750 MINUTE), survey_status = 'Unpaid' ";
			db_query($sql);
  		
	   }
 	 }
 	}
   } 
 
 }
 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead">User Payment Create </div></td>
        </tr>
      </table>
      <div align="right"><a href="users_payment_list.php">Back to Payment List</a>&nbsp;</div>
      <div align="center" class="errorMsg"><?=$msg?></div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <table width="547"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
          <tr>
            <td align="right" class="tdLabel">User ID : </td>
            <td  ><input name="u_username1" type="text" style="width:120px;" value="<?=$u_username1?>"  /></td>
            <td align="right"> <span class="tdLabel">Downline User ID </span> : </td>
            <td><input name="u_username2" style="width:120px;"type="text" value="<?=$u_username2?>"  /></td>
          </tr>
          <tr>
            <td align="right" class="tdData"> Survey ID : </td>
            <td class="txtTotal"><?
			//echo array_dropdown( $ARR_PLAN_TOPUP_RATE, $pay_rate,'pay_rate', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select plan"','--select--');
			?>
                <input name="poll_id" style="width:120px;"type="text" value="<?=$poll_id?>"></td>
            <td width="104" align="right" class="tdData">&nbsp;</td>
            <td width="179" class="txtTotal">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit" /></td>
            <td align="right"><!--&nbsp;Only Downline--></td>
            <td><span class="txtTotal">
            <!--  <input name="u_userid" style="width:120px;"type="text" value="<?=$u_userid?>"  />-->
              <?
					 
						//echo make_dropdown("select utype_id,utype_name from ngo_users_type where  utype_status='Active' and utype_id>1 ", 'utype_id', $utype_id,  'class="txtbox"   style="width:120px;" ','--select--');
							?>
            </span></td>
          </tr>
        </table>
      </form>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
