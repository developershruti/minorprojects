<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
#print_r($_POST);
	$arr_upvid_ids = $_REQUEST['arr_upvid_ids'];
	if(is_array($arr_upvid_ids)) {
		$str_upvid_ids = implode(',', $arr_upvid_ids);
		
		if(isset($_REQUEST['Payment_Paid']) || isset($_REQUEST['Payment_Paid_x']) ){
			/*$sql_update="update ngo_users_promo_video set upvid_remark='$upvid_remark', upvid_status='Approved' where upvid_status='New' and upvid_id in ($str_upvid_ids)";
			db_query($sql_update);*/
			
			$sql = "select * from ngo_users_promo_video where upvid_status='New' and upvid_id in ($str_upvid_ids) ";
			$result = db_query($sql);
 			while ($line= mysqli_fetch_array($result)){;
 			//@extract($line);
			///$ctr++;
			/// Update Status in table 
			$sql_update="update ngo_users_promo_video set upvid_remark='$upvid_remark', upvid_status='Approved' where upvid_status='New' and upvid_id='$line[upvid_id]' ";
 			db_query($sql_update);
			
			/*//$ARR_SOCIAL_REQUEST_TYPE = array( );*/
 			
			if($line['upvid_type']==1 ){ $pay_rate = 2.50; //'1'=>'Facebook: $25' 
			} else if($line['upvid_type']==2 ){ $pay_rate = 2.50;  //'2'=>'Instagram: $25'
			} else if($line['upvid_type']==3 ){ $pay_rate = 2.50; //'3'=>'Twitter: $25'
			} else if($line['upvid_type']==4 ){ $pay_rate = 5.00; //'4'=>'Reels: $50'
			} else if($line['upvid_type']==5 ){ $pay_rate = 5.00;  //'5'=>'YouTube Shorts: $50'
			} else if($line['upvid_type']==6 ){ $pay_rate = 2.50; //'6'=>'TikTok: $50'
			} else if($line['upvid_type']==7 ){ $pay_rate = 5.00; //'7'=>'YouTube Video: $50'
			} else if($line['upvid_type']==8 ){ $pay_rate = 10.00; //'8'=>'Blog Post: $75'
			} else if($line['upvid_type']==9 ){ $pay_rate = 10.00; //'9'=>'Web Article: $75'
			} else if($line['upvid_type']==10 ){ $pay_rate = 10.00; } //'10'=>'YouTube PDF Description: $100');
			  
 			
			// Self Bounty Bonus
			$pay_for3 = "Self Bounty Bonus By #".$line['upvid_id']." ".$ARR_SOCIAL_REQUEST_TYPE[$line['upvid_type']];
			$pay_amount= $pay_rate; // 
 			$sql3 = "insert into ngo_users_ewallet set pay_drcr='Cr' ,pay_userid ='".$line['upvid_userid']."' ,pay_refid ='".$line['upvid_id']."', pay_group='RW',pay_plan='BOUNTY_BONUS' ,pay_for = '$pay_for3' ,pay_ref_amt='$pay_amount' ,pay_unit = '$' ,pay_rate = '$pay_amount', pay_amount = '$pay_amount'  , pay_status = 'Paid', pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='INSTANT' ";
 			db_query($sql3); 
			
			
			
			///////// Level Sign up referral bonus 
 			$u_ref_userid = $line['upvid_userid'];//$u_ref_userid = $_SESSION['sess_uid'];
 			$ctr=0;
			while ($ctr<3) { 
			$ctr++;
			$u_ref_userid = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' ");
			// $referral_verify_email_status = db_scalar("select u_verify_email_status from ngo_users where u_id='$u_ref_userid' "); //// temp disabled sksksk
			$referral_verify_email_status = 'Verified';
 			//$topup_amount_active_count = db_scalar("select count(*) from ngo_users_recharge_stack where topup_userid='$u_ref_userid' ")+0;
			//&& $topup_amount_active_count>=1
 			if ($u_ref_userid!='' && $u_ref_userid!=0 && $referral_verify_email_status=='Verified'){
  				if($ctr==1)		{ $pay_rate2 =20; } //  
				else if($ctr==2){ $pay_rate2 =10;} //  
				else if($ctr==3){ $pay_rate2 =5;} ////  
			//	else if($ctr==4){ $pay_rate =1;}
 			//if($ctr==1){ $pay_plan ='DIRECT_INCOME';} else {$pay_plan ='LEVEL_INCOME';}
				$pay_plan2 ='TEAM_BOUNTY_BONUS';
 				//$pay_ref_amt = $topup_amount /$token_price;
				//$pay_ref_amt = $pay_amount;
 				 $pay_amount2 = ($pay_amount/100)*$pay_rate2;
				// $pay_amount_ref = $pay_ref_amt;
				//$pay_amount_ref = $pay_ref_amt;
				$pay_for2 ="Referral Bounty Bonus From Level $ctr By #".$line['upvid_id']." ".$ARR_SOCIAL_REQUEST_TYPE[$line['upvid_type']];  
 				//$sql2 = "insert into ngo_users_coin set pay_drcr='Cr',pay_userid ='$u_ref_userid' ,pay_refid ='$topup_userid' ,pay_topupid='$topup_id',pay_plan='$pay_plan' ,pay_group='WI' ,pay_plan_level='$ctr'  ,pay_for = '$pay_for' ,pay_ref_amt='$pay_ref_amt' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount_ref' ,pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='SPOT' ";
				$sql2 = "insert into ngo_users_ewallet set pay_drcr='Cr' ,pay_userid ='".$u_ref_userid."' ,pay_refid ='".$line['upvid_id']."' ,pay_group='RW',pay_plan='$pay_plan2' ,pay_for = '$pay_for2' ,pay_ref_amt='$pay_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate2', pay_amount = '$pay_amount2'  , pay_status = 'Paid', pay_date=ADDDATE(now(),INTERVAL 330 MINUTE) ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE),pay_admin='ADMIN' ";
				db_query($sql2);
				  
 			} 
 		}
			 
 			
			} 
			
			
			 
			
			
			
			
			
  		}else if(isset($_REQUEST['Payment_Unpaid']) || isset($_REQUEST['Payment_Unpaid_x']) ){
			$sql_update="update ngo_users_promo_video set upvid_remark='$upvid_remark', upvid_status='Rejected' where upvid_id in ($str_upvid_ids)";
			db_query($sql_update);
  		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 
	}
}
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select * ";
$sql = " from ngo_users_promo_video ,ngo_users  where ngo_users_promo_video.upvid_userid=ngo_users.u_id ";

// and u_status!='Banned'
/// downline payout list of a user
if ($u_sponsor_id!=''){
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
if ($id_in!='') {$sql .= " and upvid_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}
if ($upvid_status!='') 		{$sql .= " and upvid_status='$upvid_status' "; } else { $sql .= " and upvid_status='New' "; }
if ($upvid_type!='') 		{$sql .= " and upvid_type='$upvid_type' "; }
//if ($upvid_amount!='') 		{$sql .= " and upvid_amount='$upvid_amount' ";} 
 
if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (upvid_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  upvid_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and  upvid_datetime between '$datefrom' AND '$dateto' "; }

if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 


$sql_export = $sql ."  order by ngo_users.u_id asc "; 
$sql_export_total = $sql ." group by ngo_users.u_id  order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'upvid_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'Username','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile','u_city'=>'City', 'upvid_bank'=>'Bank Name' ,'upvid_bank_branch'=>' Branch','upvid_amount'=>'Amount'  ,'upvid_status'=>'Status','upvid_datetime'=>'Deposit Date' );
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
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
          <td id="pageHead"><div id="txtPageHead"> Bounty Request details </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="676"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="6">Search</th>
                </tr>
                <tr>
                  <td width="118" align="right" class="tdLabel">Auto ID . From: </td>
                  <td width="131"><input name="user_id_from" type="text"style="width:50px;" value="<?=$user_id_from?>" />
                    <input name="user_id_to" style="width:50px;"type="text" value="<?=$user_id_to?>" /></td>
                  <td align="right">Paid/Unpaid: </td>
                  <td><? //=payment_status_dropdown('upvid_status',$upvid_status);?>
				  <select name="upvid_status" id="upvid_status">
				  <option value="">Please Select</option>
				  <option value="New" <? if($upvid_status=='New'){ ?> selected="" <? } ?> >Pending</option>
				  <option value="Approved" <? if($upvid_status=='Approved'){ ?> selected="" <? } ?> >Approved</option>
				  <option value="Rejected" <? if($upvid_status=='Rejected'){ ?> selected="" <? } ?> >Rejected</option>
				  </select>
				  
				  
				  </td>
                  <td width="20" align="right"><!--<input name="export" type="checkbox" id="export" value="1" />--></td>
                  <td width="163">  <!-- Deposit list--> </td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Username </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right"><span class="tdLabel">Post Type :</span></td>
                  <td> <? echo array_dropdown($ARR_SOCIAL_REQUEST_TYPE, $upvid_type, 'upvid_type',' style="width:100%;" class="form-control" ');
 //=join_mode_dropdown('u_join_mode',$u_join_mode,'alt="select" emsg="Please select Account Type"')?> </td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="right">  Date from: </td>
                  <td><?=get_date_picker("datefrom", $datefrom)?></td>
                  <td  align="right" valign="top"> Date To: </td>
                  <td><?=get_date_picker("dateto", $dateto)?></td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Downline - Username </td>
                  <td><input name="u_sponsor_id"style="width:120px;" type="text" value="<?=$u_sponsor_id?>" /></td>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right" valign="middle">&nbsp;</td>
                  <td valign="middle"><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                </tr>
              </table>
			  
            </form>
			<div align="right"><!--<a href="recharge_topup_add.php">Add New Investment</a>-->
            <? if(mysqli_num_rows($result)==0){?>
            <div class="msg">Sorry, no records found.</div>
            <? } else{ 
 	  ?> 	<!-- | <a href="recharge_topup_auto.php">Auto Recharge/Topup</a>--> </div>
            <div align="right"> Showing Records:
              <?= $start+1?>
              to
              <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?>
              of
              <?= $reccnt?>
            </div>
            <div>Records Per Page:
              <?=pagesize_dropdown('pagesize', $pagesize);?>
            </div>
            <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
              <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
			<tr>
					<th width="5%" height="25" >&nbsp;Req-No </th>
					<th width="11%" height="25" >&nbsp;UserID </th>
					<th width="11%" height="25" >&nbsp;Name </th>
					<th width="11%" height="25" >&nbsp;City </th>
					<th width="19%" height="25" >Date </th>
					<th width="13%" >Post Type</th>
					<th width="14%" >Post Url</th>
					<th width="14%" >Remark</th>
					<th width="16%" >Status</th>
					<!--<th width="10%" > </th>-->
					<th width="2%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th> 
			</tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
    ?>
                <tr class="<?=$css?>">
                  <td><?=$line['upvid_id'];?></td>
				  <td><?=$line['u_username'];?></td>
				  <td><?=$line['u_fname'];?></td>
				  <td><?=$line['u_city'];?></td>
				 <td><?=date_format2($line['upvid_datetime']);?>  </td>
 				 <td><?=$ARR_SOCIAL_REQUEST_TYPE[$line['upvid_type']]?><? //=$line['upvid_type'];?></td>
 				<td><a href="<?=$line['upvid_post_url'];?>" target="_blank"><?=$line['upvid_post_url'];?> </a> </td>
 				<?php /*?><td><? if($line['upvid_type']=='Crypto'){ ?>$ <?=($line['upvid_amount_usdt']);?><? } ?> </td><?php */?>
				<td><?=($line['upvid_remark']);?> </td>
  				<td>
				<? if($upvid_status=='New'){ ?>
 						<span class="badge bg-primary">Pending</span>
						<? } else if($upvid_status=='Approved'){ ?>
						<span class="badge bg-success">Approved</span>
						<? } else if($upvid_status=='Rejected'){ ?>
						<span class="badge bg-danger">Rejected</span>
						<? } else if($upvid_status=='Inactive'){ ?>
						<span class="badge bg-info">Inactive</span>
						<? } ?>
				
				</td>
 				<!--<td><a href="<? //=UP_FILES_WS_PATH.'/receipt/'.$line['upvid_receipt']?>" target="_blank">View Slip</a></td>-->
                  <td align="center"><input name="arr_upvid_ids[]" type="checkbox" id="arr_upvid_ids[]" value="<?=$line['upvid_id'];?>"/></td> 
                </tr>
                <? }
?>
              </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
				 <td width="19%" align="right" style="padding:2px">  </td>
                  <td width="9%" align="right" style="padding:2px">                    </td>
			      <td width="22%" align="right" style="padding:2px"><!-- Paid date:
			        <? //=get_date_picker("pay_transfer_date", date("Y-m-d"))?>-->
					
					<input name="upvid_remark" style="width:100%;" type="text" id="upvid_remark"  />  
					</td>
			      <td width="34%" align="right" style="padding:2px">  
			      </td>
				  <td width="8%" align="right" style="padding:2px">
				  <input name="Payment_Paid" type="image" id="Payment_Paid" src="images/buttons/paid.gif" onclick="return paidConfirmFromUser('arr_upvid_ids[]')"/>                  </td>
				   <td width="8%" align="right" style="padding:2px"><input name="Payment_Unpaid" type="image" id="Payment_Unpaid" src="images/buttons/unpaid.gif" onclick="return paidConfirmFromUser('arr_upvid_ids[]')"/>                  </td>
				   
				   
                </tr>
              </table> 
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
