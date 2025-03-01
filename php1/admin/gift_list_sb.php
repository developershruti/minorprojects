<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
 //print_r($_POST);
	$arr_gift_ids = $_REQUEST['arr_gift_ids'];
	if(is_array($arr_gift_ids)) {
		$str_gift_ids = implode(',', $arr_gift_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  			$sql = "delete from ngo_users_gift  where gift_status='New' and gift_id in ($str_gift_ids)";
			db_query($sql);
 		} elseif (isset($_REQUEST['Submit_Topup']) || isset($_REQUEST['Submit_gift_x']) ){
		 	#$sql_update="update ngo_users_gift set gift_rate='$gift_rate_topup'  where gift_plan='TOPUP' and gift_id in ($str_gift_ids)";
 			#db_query($sql_update);
		} else if (isset($_REQUEST['Submit_cycle_auto']) || isset($_REQUEST['Submit_cycle_auto_x']) ) {
			
 		$gift_userid =db_scalar("select u_id from ngo_users  where  u_username='$gift_username' limit 0,5")  ;
 		if ($gift_userid!='') { 
		
		  	$sql_gen = "select * from ngo_users  where u_id in (select gift_by_userid from ngo_users_gift  where gift_id in ($str_gift_ids)) ";
 			$result_gen = db_query($sql_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
 				 
 				$total_count = db_scalar("select count(*) from ngo_users_gift  where gift_status!='Reject'  and gift_userid='$gift_userid' and gift_cycle='$gift_cycle1' ")+0 ;
 				$sql2 = " select * from  ngo_users_type where   utype_code='$gift_cycle1'";
				$result2 = db_query($sql2);
				$line2= mysqli_fetch_array($result2);
 
  				if ($total_count<5 ) {
				  	$sql_insert="insert into ngo_users_gift set gift_userid = '$gift_userid' ,gift_by_userid='$line_gen[u_id]' ,gift_cycle='$gift_cycle1' ,gift_amount='$line2[utype_charges]' ,gift_date=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_exp_date= ADDDATE(now(),INTERVAL 6510 MINUTE),gift_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,gift_status='New'";
					db_query($sql_insert);
					
					// send welcome sms to user 
					$mobile = '91'.db_scalar("select u_mobile from ngo_users where u_id='$line_gen[u_id]'");
					$message = "Dear user, you have to send a gift for cycle # $gift_cycle1 within 72 hrs. " .SITE_NAME ." team";
 					send_sms($mobile,$message);
					 
				}
			 }
			 $gift_cycle2 =$gift_cycle1+1;
			 db_query("update ngo_users  set u_gift_cycle='$gift_cycle2' where u_id='$gift_userid'");
			 $gift_cycle =$gift_cycle1;
 			}
			
				
 		
		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
  }
}
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$columns = "select  * ";
$sql = " from ngo_users_gift ,ngo_users  where ngo_users_gift.gift_userid=ngo_users.u_id ";

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
if ($id_in!='') {$sql .= " and gift_userid in ($id_in)  "; }
 //$sql .= " and (u_cheque_other='$u_cheque_other' or u_id='$u_cheque_other') ";
}
*/
if ($gift_cycle!='') 			{$sql .= " and gift_cycle='$gift_cycle' "; }


if ($gift_id!='') 		{$sql .= " and gift_id='$gift_id' ";} 
//if ($gift_plan!='') 		{$sql .= " and gift_plan='$gift_plan' ";} 
if ($gift_amount!='') 		{$sql .= " and gift_amount='$gift_amount' ";} 
 
if ($gift_status!='') 	{$sql .= " and gift_status='$gift_status' ";}
if (($user_id_from!='') && ($user_id_to!='')) 		{$sql .= " and (gift_userid  between $user_id_from  and  $user_id_to )";}
else if (($user_id_from!='') && ($user_id_to==''))	{$sql .= " and  gift_userid ='$user_id_from' ";}
if (($datefrom!='') && ($dateto!=''))				{$sql .= " and gift_datetime between '$datefrom' AND '$dateto' "; }

if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
if ($u_username2!='') 		{
	$gift_by_userid = db_scalar("select u_id from ngo_users where u_username = '$u_username2'");
	$sql .= " and gift_by_userid='$gift_by_userid' ";
} 
#$sql_export = $sql ."  order by ngo_users.u_id asc "; 
#$sql_export_total = $sql ." group by ngo_users.u_id, gift_plan order by ngo_users.u_id asc"; 

$order_by == '' ? $order_by = 'gift_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array( 'u_id'=>'Auto ID','u_username'=>'Username','u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile','u_status'=>'Status' ,'u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR','u_city'=>'City','gift_date'=>'Topup Date' ,'gift_rate'=>'Rate','gift_amount'=>'Total Amount');
 
export_delimited_file($sql_export, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

 

 
if ($export_total=='1') {
 //
//,'((sum(gift_amount)/100)*5) as BDF'=>'BDF','((sum(gift_amount)/100)*2) as CWF'=>'CWF'
	$arr_columns =array( 'u_username'=>'Username','u_fname'=>'Name','u_address'=>'Address' ,'u_mobile'=>'Mobile','u_status'=>'Status','u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR'   ,'u_city'=>'City' ,'sum(gift_amount)as totalamount'=>'Total Amount'  );
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
          <td id="pageHead"><div id="txtPageHead"> Gift List </div></td>
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
                  <td width="137" align="right">Gift Cycle : </td>
                  <td width="244">  
				  <?
							  // if ($u_country=='') {$u_country=99;} 
						 $sql ="select utype_code , utype_name from ngo_users_type order by utype_code";  
						  echo make_dropdown($sql, 'gift_cycle', $gift_cycle ,  'class="txtbox"  style="width:140px;"','--select--');
						 	?>				  </td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Receiver Username </td>
                  <td>
                  <input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
                  <td align="right"><span class="tdLabel">Topup Amount:</span></td>
                  <td><input name="gift_amount" style="width:120px;"type="text" value="<?=$gift_amount?>" /></td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Sender Username </td>
                  <td><input name="u_username2"style="width:120px;" type="text" value="<?=$u_username2?>" /></td>
                  <td  align="right" valign="top">Gift Status : </td>
                  <td><?=array_dropdown($ARR_GIFT_STATUS, $gift_status, 'gift_status');?></td>
                </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </form>
			<div align="right"><? if(mysqli_num_rows($result)==0){?> <div class="msg">Sorry, no records found.</div>
            <? } else{ 
 	  ?> 	 </div>
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
                <tr><th width="4%" >Sl No </th>
                  <th width="5%" >Cycle No </th>
                  <th width="9%" >Rec User ID <?= sort_arrows('u_username')?></th>
                  
                   <th width="8%" > Rec Name <?= sort_arrows('u_fname')?></th>
                   <th width="5%" >Rec City</th>
                  
				   <th width="9%" >Sender User ID </th>
				  <th width="9%" >Sender User  name</th>
				  <th width="7%" >Tr No  </th>
                   <th width="7%" >Tr Date  </th>
                   <th width="11%" >Desc</th>
                   <th width="6%" >Amount </th>
                   <th width="8%" >Status</th>
                   <th width="8%" >Gift Date  <?= sort_arrows('gift_date')?></th>
                 
                  
                  <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th> 
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	
	$sql_by = "select * from ngo_users  where u_id ='$gift_by_userid' ";
	$result_by = db_query($sql_by);
	$line_by = mysqli_fetch_array($result_by);
				
			
	 $css = ($css=='trOdd')?'trEven':'trOdd';
  ?>
		<tr class="<?=$css?>">
		<td nowrap="nowrap"><?=$gift_id?></td>
		<td nowrap="nowrap"><?=$gift_cycle?></td>
		<td nowrap="nowrap"><?=$u_username?></td>
		<td nowrap="nowrap"><?=$u_fname?> </td>
		<td nowrap="nowrap"><?=$u_city?></td>
		<td nowrap="nowrap"><?=$line_by[u_username]?></td>
		<td nowrap="nowrap"><?=$line_by[u_fname]?></td>
		<td nowrap="nowrap"><?=$gift_tr_no?></td>
		<td nowrap="nowrap"><?=$gift_tr_date?></td>
		<td><?  echo $gift_desc; ?> </td>
		<td nowrap="nowrap"><?=$gift_amount?></td>
		<td nowrap="nowrap"><?=$gift_status?></td>
		
		<td nowrap="nowrap"><?=date_format2($gift_date)?></td>
		
		<td align="center"><input name="arr_gift_ids[]" type="checkbox" id="arr_gift_ids[]" value="<?=$gift_id?>"/></td> 
		</tr>
                <? }
?>
              </table>
           <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
                   
				  
				   <td   align="right" valign="top" style="padding:2px"><?
 						 $sql ="select  utype_code, utype_name from ngo_users_type where utype_status='Active' and  utype_id>1  ";  
						echo make_dropdown($sql, 'gift_cycle1', $gift_cycle1,  'class="txtfleid" style="width:150px;" alt="select" emsg="Please Select Pin "', 'Please select');
							?>
                          <input name="gift_username" type="text" value="<?=$gift_username?>" size="20" />
                          <input name="Submit_cycle_auto" type="image" id="Submit_cycle_auto" src="images/buttons/cycle.gif"  onclick="return  updateConfirmFromUser('arr_gift_ids[]')"/>
                        </td>
						 <td width="11%" align="center" valign="middle" class="tableSearch" >
				  <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_gift_ids[]')"/></td>
						
                </tr>
              </table>  
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
