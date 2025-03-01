<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
 //print_r($_POST);
	$arr_bid_ids = $_REQUEST['arr_bid_ids'];
	if(is_array($arr_bid_ids)) {
		$str_bid_ids = implode(',', $arr_bid_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
 		 		#$bid_tr_receipt =  db_scalar("select bid_tr_receipt from ngo_users_bid where bid_id in ($str_bid_ids) ")  ;
				#@unlink(UP_FILES_FS_PATH.'/profile/'.$bid_tr_receipt);
 				#$sql_update="update ngo_users_bid set bid_tr_receipt='',bid_status='New'  where bid_id in ($str_bid_ids) ";
				#db_query($sql_update);
	  			//bid_status='New' and
 			 $sql = "delete from ngo_users_bid  where bid_id in ($str_bid_ids)";
			 db_query($sql);
 		} elseif (isset($_REQUEST['Update']) || isset($_REQUEST['Update_x']) ){
		 	if ($submit_status!='') {
			$sql_update="update ngo_users_bid set bid_status='$submit_status'  where   bid_id in ($str_bid_ids)";
 			db_query($sql_update);
			}
		} else if (isset($_REQUEST['Submit_cycle_auto']) || isset($_REQUEST['Submit_cycle_auto_x']) ) {
			/*
 		$bid_userid =db_scalar("select u_id from ngo_users  where  u_username='$bid_username' limit 0,5")  ;
 		if ($bid_userid!='') { 
		
		  	$sql_gen = "select * from ngo_users  where u_id in (select bid_by_userid from ngo_users_bid  where bid_id in ($str_bid_ids)) ";
 			$result_gen = db_query($sql_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
 				 
 				$total_count = db_scalar("select count(*) from ngo_users_bid  where bid_status!='Reject'  and bid_userid='$bid_userid' and bid_cycle='$bid_cycle1' ")+0 ;
 				$sql2 = " select * from  ngo_users_type where   utype_code='$bid_cycle1'";
				$result2 = db_query($sql2);
				$line2= mysqli_fetch_array($result2);
 
  				if ($total_count<5 ) {
				  	$sql_insert="insert into ngo_users_bid set bid_userid = '$bid_userid' ,bid_by_userid='$line_gen[u_id]' ,bid_cycle='$bid_cycle1' ,bid_amount='$line2[utype_charges]' ,bid_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,bid_exp_date= ADDDATE(now(),INTERVAL 6510 MINUTE),bid_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,bid_status='New'";
					db_query($sql_insert);
					
					// send welcome sms to user 
					$to_username = db_scalar("select u_username from ngo_users  where  u_id='$bid_userid' ")+0 ;
					$mobile = '91'.$line_gen[u_mobile] ;
					$message = "Dear user ($line_gen[u_username]), you have to send a bid for cycle # $bid_cycle1 to ID No. ($to_username) within 72 hrs. " .SITE_NAME ." team";
 					send_sms($mobile,$message);
					 
				}
			 }
			 $bid_cycle2 =$bid_cycle1+1;
			 db_query("update ngo_users  set u_bid_cycle='$bid_cycle2' where u_id='$bid_userid'");
			 $bid_cycle =$bid_cycle1;
 			}*/
			
				
 		
		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
  }
}
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select u_id,u_username, u_fname,  ngo_users_bid.* ";
$sql = " from ngo_users ,ngo_users_bid ";
$sql .= " where u_id=bid_userid ";
//$sql = " from ngo_users_bid ,ngo_users  where ngo_users_bid.bid_userid=ngo_users.u_id ";

// and u_status!='Banned'
/// downline payout list of a user
/*if ($u_sponsor_id!=''){
$u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_sponsor_id'");
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
		$referid = implode(",",$refid);
	} else {
		$sb='stop';
	}
 } 
$id_in = implode(",",$id);
if ($id_in!='') {$sql .= " and bid_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}
*/
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($bid_userid!='') 		{$sql .= " and bid_userid='$bid_userid' ";} 
if ($bid_number!='') 		{$sql .= " and bid_number='$bid_number' ";} 
if ($bid_plan!='') 			{$sql .= " and bid_plan='$bid_plan' ";} 
if ($bid_amount!='') 		{$sql .= " and bid_amount='$bid_amount' ";} 
if ($bid_status!='') 		{$sql .= " and bid_status='$bid_status' ";} else { $sql .= " and bid_status='Win' "; } 
if ($bid_date!='') 			{$sql .= " and bid_date='$bid_date' ";}

if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (bid_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  bid_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and bid_date between '$datefrom' AND '$dateto' "; }

 
#$sql_export = $sql ."  order by ngo_users.u_id asc "; 
#$sql_export_total = $sql ." group by ngo_users.u_id, bid_plan order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'bid_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'Username','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile','u_status'=>'Status' ,'u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City','bid_date'=>'Topup Date' ,'bid_rate'=>'Rate','bid_amount'=>'Total Amount');
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 

 
if ($export_total=='1') {
 //
//,'((sum(bid_amount)/100)*5) as BDF'=>'BDF','((sum(bid_amount)/100)*2) as CWF'=>'CWF'
	$arr_columns =array( 'u_username'=>'Username','u_fname'=>'Name','u_address'=>'Address' ,'u_mobile'=>'Mobile','u_status'=>'Status','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR'   ,'u_city'=>'City' ,'sum(bid_amount)as totalamount'=>'Total Amount'  );
	export_delimited_file($sql_export_total, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;

}

$sql 	.= "limit $start, $pagesize ";
$sql 	= $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Support List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="676"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="4">Search</th>
                </tr>
                <tr>
                  <td width="121" align="right" class="tdLabel">Auto ID . From: </td>
                  <td width="156"><input name="user_id_from" type="text"style="width:50px;" value="<?=$user_id_from?>" />
                    <input name="user_id_to" style="width:50px;"type="text" value="<?=$user_id_to?>" /></td>
                  <td width="137" align="right">Bid Number: </td>
                  <td width="244">  <input name="bid_number"style="width:120px;" type="text" value="<?=$bid_number?>" /> 
				  <?
							  // if ($u_country=='') {$u_country=99;} 
						# $sql ="select utype_code , utype_name from ngo_users_type order by utype_code";  
						#  echo make_dropdown($sql, 'bid_cycle', $bid_cycle ,  'class="txtbox"  style="width:140px;"','--select--');
						 	?>				  </td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Bidder Username </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right"><span class="tdLabel">Bid Amount:</span></td>
                  <td><input name="bid_amount" style="width:120px;"type="text" value="<?=$bid_amount?>" /></td>
                </tr>
                <tr>
                  <td align="right" class="tdLabel"><span class="td_box">Bidding  Module<span class="error">*</span></span></td>
                  <td><span class="td_box"><?=array_dropdown($ARR_BID_PLAN, $bid_plan, 'bid_plan');?>
                  </span></td>
                  <td  align="right" valign="top">Bid Status : </td>
                  <td><?=array_dropdown($ARR_BID_STATUS, $bid_status, 'bid_status');?></td>
                </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td  align="right" valign="top">Bid Date :                  </td>
                  <td><?=get_date_picker("bid_date", $bid_date)?></td>
                </tr>
              </table>
            </form>
			
			<div align="right"> <!--<a href="users_bidding_draw.php">Bidding Draw</a> | --><a href="users_bidding_winner_bonus.php">Bidding Winner Bonus</a> </div>
			<div align="right"><? if(mysqli_num_rows($result)==0){?> <div class="msg">Sorry, no records found.</div>
            <? } else{ 
 	  ?> 	 </div>
            <div align="right"> Showing Records:
              <?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of  <?= $reccnt?>
            </div>
            <div>Records Per Page:  <?=pagesize_dropdown('pagesize', $pagesize);?>
            </div>
            <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
              <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
                <tr>
					<th width="10%" >Bid ID</th>
					<th width="10%" >Bidder User ID <?= sort_arrows('u_username')?></th>
					<th width="10%" >Bidder Name <?= sort_arrows('u_fname')?></th>
					<th width="10%" >&nbsp;Plan Name</th>
					<th width="10%" >&nbsp;Plan No</th>
					<th width="10%" >&nbsp;Bid Number</th>
					<th width="10%" >&nbsp;Bid Amount</th>
					<th width="10%" >&nbsp;Bid Date</th>
					<th width="10%" >&nbsp;Bid Confirm Date </th>
					<th width="10%" >&nbsp;Bid Status</th>
                  
                  <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th> 
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	
	$sql_by = "select * from ngo_users  where u_id ='$bid_by_userid' ";
	$result_by = db_query($sql_by);
	$line_by = mysqli_fetch_array($result_by);
				
			
	 $css = ($css=='trOdd')?'trEven':'trOdd';
  ?>
		<tr class="<?=$css?>">
		<td nowrap="nowrap"><?=$bid_id?></td>
		
		<td nowrap="nowrap"><?=$u_username?></td>
		<td nowrap="nowrap"><?=$u_fname?> </td>
		<td nowrap="nowrap"><?=$utype_name?></td>
		<td nowrap="nowrap"><?=$bid_plan?></td>
		<td nowrap="nowrap"><?=$bid_number?></td>
 		<td nowrap="nowrap"><?=$bid_amount?></td>
 		<td nowrap="nowrap"><?=date_format2($bid_date)?></td>
		<td nowrap="nowrap"><?=date_format2($bid_draw_date)?></td>
		<td nowrap="nowrap"><?=$bid_status?></td>
		
		<td align="center"><input name="arr_bid_ids[]" type="checkbox" id="arr_bid_ids[]" value="<?=$bid_id?>"/></td> 
		</tr>
                <? }
?>
              </table>
           <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
 				   <td   align="right" valign="top" style="padding:2px"><?
 						# $sql ="select  utype_code, utype_name from ngo_users_type where utype_status='Active' and  utype_id>1  ";  
						#echo make_dropdown($sql, 'bid_cycle1', $bid_cycle1,  'class="txtfleid" style="width:150px;" alt="select" emsg="Please Select Pin "', 'Please select');
							?>
                          <!--<input name="bid_username" type="text" value="<?=$bid_username?>" size="20" />
                          <input name="Submit_cycle_auto" type="image" id="Submit_cycle_auto" src="images/buttons/cycle.gif"  onclick="return  updateConfirmFromUser('arr_bid_ids[]')"/>-->
                        </td>
						 <!-- <td width="11%" align="center" valign="middle" nowrap="nowrap"  >
						  <?=array_dropdown($ARR_BID_STATUS, $submit_status, 'submit_status');?>
						  
				   <input name="Update" type="image" id="Update" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_bid_ids[]')"/>  </td> 
				    <td width="11%" align="center" valign="middle"  >
				   <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_bid_ids[]')"/>  </td> -->
						
                </tr>
              </table>  
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
