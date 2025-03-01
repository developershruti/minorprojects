<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
 
 

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users , ngo_rewards_winner";
$sql .= " where 1 ";

if ($u_id1!='' && $u_id2!='') { 
	$sql .= " and (u_id >= $u_id1 and u_id<=$u_id2)"; 
	$sponsor_sql.= " and (a.u_id >= $u_id1 and a.u_id<=$u_id2)"; 
}else if ($u_id1!='' && $u_id2==''){
	$sql .= " and  u_id ='$u_id1' "; 
	$sponsor_sql.= " and  a.u_id ='$u_id1' ";
}
 if ($u_username!='') 		{$sql .= " and u_username='$u_username' "; }
if ($u_mobile!='') 		{$sql .= " and u_mobile='$u_mobile' "; }
//if ($u_bank_register!='') 	{$sql .= " and u_bank_register='$u_bank_register' "; }
if ($u_status!='') 			{$sql .= " and u_status='$u_status' "; }
$sql = apply_filter($sql, $u_fname, $u_fname_filter,'u_fname');
$sponsor_sql = apply_filter($sponsor_sql, $u_fname, $u_fname_filter,'a.u_fname');

if ($u_utype!='') 			{$sql .= " and u_utype='$u_utype' ";    $sponsor_sql.=" and a.u_utype='$u_utype' ";}
//if ($close_id!='') 			{$sql .= " and u_closeid='$close_id' "; $sponsor_sql.=" and a.u_closeid='$close_id' ";}

if ($datefrom!='' && $dateto!='') {  $sql .= " and u_date between '$datefrom' AND '$dateto' ";} 
 
 
if ($export=='1') { 
 	$arr_columns =array('u_id'=>'Auto ID','u_username'=>'User ID','u_ref_userid'=>'Referer ID','u_ref_side'=>'Side','u_fname'=>'First Name' ,'u_address'=>'Address','u_city'=>'City','u_mobile'=>'Mobile','u_date'=>'DOJ','u_panno'=>'Pan NO' ,'u_dob'=>'DOB' ,'u_bank_name'=>'Bank Name' ,'u_bank_acno'=>'Account No' ,'u_bank_branch'=>' Branch' ,'u_bank_ifsc_code'=>'IFSC','u_bank_micr_code'=>'MICR' ,'u_bank_register'=>'Acc Register in Bank');
 	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}

if ($export2=='1') {
 //select a.u_id,a.u_fname,a.u_mobile,a.u_address, b.u_id,b.u_fname,b.u_mobile,a.u_address  from ngo_users a, ngo_users b where a.u_ref_userid=b.u_id  
 //,'a.u_ref_userid'=>'Referer ID','a.u_dob as user_dob'=>'User DOB','a.u_nomi_name as user_nomi'=>'User Nominee Name'
 // ,'b.u_dob'=>'Sponsor DOB','b.u_nomi_name'=>'Sponsor Nominee Name'
 	$sponsor_sql2 = " from ngo_users a, ngo_users b where a.u_ref_userid=b.u_id " .$sponsor_sql; 
 	$arr_columns2 =array('a.u_id as autoid'=>'Auto ID','a.u_username as userid'=>'User ID','a.u_ref_side as side'=>'Side' ,'a.u_fname as user_fname'=>'User Name','a.u_mobile as user_mobile'=>'User Mobile','a.u_address as user_address'=>'User Address','a.u_city as user_city'=>'User City','a.u_state as user_state'=>'User State','a.u_date as user_date'=>'User DOJ'  ,'b.u_username as Referer_id'=>'Referer ID','b.u_fname as Referer_fname'=>'Referer Name','b.u_mobile as Referer_mobile'=>'Referer Mobile','b.u_address'=>'Referer Address','b.u_city'=>'Referer City','b.u_state'=>'Referer State','b.u_date'=>'Referer DOJ' );
 	export_delimited_file($sponsor_sql2, $arr_columns2, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}

if ($export3=='1') {
		/// downline payout list of a user
	$sponsor_sql2 = " from ngo_users a, ngo_users b where  a.u_bank_acno=b.u_bank_acno and a.u_bank_register='' " .$sponsor_sql; 
	$arr_columns2 =array('a.u_id as autoid'=>'Auto ID','a.u_username as userid'=>'User ID','a.u_fname'=>'User Name' ,'a.u_bank_name'=>'Bank Name','a.u_bank_acno'=>'Bank Account No','a.u_bank_ifsc_code'=>'IFSC CODE','u_bank_micr_code'=>'MICR','b.u_id as autoid'=>'Auto ID','b.u_username as userid'=>'User ID','b.u_fname'=>'User Name' ,'b.u_bank_name'=>'Bank Name','b.u_bank_acno'=>'Bank Account No','b.u_bank_ifsc_code'=>'IFSC CODE');
	export_delimited_file($sponsor_sql2, $arr_columns2, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;

}

/*if ($export3=='1') { 
 	$arr_columns =array('u_id'=>'Auto ID','u_username'=>'User ID','u_ref_side'=>'Side','u_fname'=>'First Name','u_lname'=>'Last Name','u_address'=>'Address','u_mobile'=>'Mobile','u_date'=>'DOJ','u_panno'=>'Pancard No');
 	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}*/
 
/// downline payout list of a user

if ($u_sponsor_id!=''){
$u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_sponsor_id'");
 
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
$id_in = implode(",",$id);
if ($id_in!='') {
		$sql .= " and u_id in ($id_in)  "; 
		$sponsor_sql.=" and a.u_id in ($id_in)  "; 
	}
  
 	
if ($export4=='1') {
		//export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='');
		$sponsor_sql2 = " from ngo_users a, ngo_users b where a.u_ref_userid=b.u_id " .$sponsor_sql; 
		$arr_columns2 =array('a.u_id as autoid'=>'Auto ID','a.u_username as userid'=>'User ID','a.u_ref_side'=>'Side' ,'a.u_fname as user_fname'=>'User Name','a.u_mobile as user_mobile'=>'Mobile','b.u_username as Referer_id'=>'Referer ID','b.u_fname as Referer_fname'=>'Referer Name' ,'b.u_mobile as Referer_mobile'=>'Referer Mobile');
 	export_delimited_file($sponsor_sql2, $arr_columns2, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
	}
 }
}

if ($print_address=='1') {
		$_SESSION['sql_add'] = "select u_id, u_fname ,u_lname ,u_address ,u_phone ,u_city ,u_state , u_mobile ". $sql;
		header ("location: print_address_list.php");
		exit();
	}
if ($total_referer=='1') {
	
	$_SESSION['sql_add'] = "select u_id, u_closeid, u_fname ,u_lname  ,u_phone  ,u_date ". $sql." order by u_id, u_ref_userid asc ";
	header ("location: print_working_list.php");
	exit();
	
 }
 
$order_by == '' ? $order_by = 'u_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);



?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Users    Reward Redeem List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"><form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="75%"  ><table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                      <tr  >
                        <th colspan="5">Search</th>
                      </tr>
                      <tr>
                        <td width="150" align="right" >Auto ID : </td>
                        <td><input name="u_id1" type="text" value="<?=$u_id1?>" size="10"  />
                          <input name="u_id2" type="text" value="<?=$u_id2?>" size="10"  /></td>
                        <td width="153" align="right">Status: </td>
                        <td><?=status_dropdown('u_status', $u_status)?></td>
                        <td><input name="export" type="checkbox" id="export" value="1" />
                          User List</td>
                      </tr>
                      <tr>
                        <td height="26"   align="right" class="tdLabel">Name : </td>
                        <td nowrap="nowrap"  ><input name="u_fname" type="text" value="<?=$u_fname?>"  />
                          <?=filter_dropdown('u_fname_filter', $u_fname_filter)?></td>
                        <td align="right"  >&nbsp;</td>
                        <td  >&nbsp;</td>
                        <td  ><input name="export2" type="checkbox" id="export2" value="1" />
                          Sponsor List </td>
                      </tr>
                      <tr>
                        <td align="right" class="tdLabel">Username  : </td>
                        <td width="159"><input name="u_username" type="text" value="<?=$u_username?>"></td>
                        <td align="right">Mobile  :</td>
                        <td width="231"><input name="u_mobile" type="text" value="<?=$u_mobile?>">                        </td>
                        <td width="146">&nbsp;</td>
                      </tr>
            <!--<tr>
              <td align="right">Refer User ID:</td>
              <td><input name="referid" type="text" value="<? //=$referid?>" size="20"  /></td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>-->
                      <tr>
                        <td align="right">&nbsp;</td>
                        <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                          <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <input type="hidden" name="u_id" value="<?=$u_id?>"/>
                      </tr>
                    </table></td>
                  <td width="25%" valign="top">&nbsp; </td>
                </tr>
              </table>
            </form>
            <div class="msg">
              <?=$msg?>
            </div>
            <br/>
            <div align="right">
              <!-- <a href="users_add.php">Add New Users </a>&nbsp;|&nbsp; <a href="users_reserve.php">Generate Reserve Users ID</a>&nbsp;|&nbsp; <a href="users_reserve_import.php">Import Reserve Users ID</a>-->
            </div>
            <? if(mysqli_num_rows($result)==0){?>
            <div class="msg">Sorry, no records found.</div>
            <? } else{ 
	  ?>
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
                  <th width="5%" nowrap="nowrap">ID <?= sort_arrows('u_id')?></th>
                  <th width="11%" nowrap="nowrap">Username </th>
                  <th width="14%" nowrap="nowrap"> Name <?= sort_arrows('u_fname')?></th>
                  <th width="19%" align="left" nowrap="nowrap">City</th>
                  <th width="10%" nowrap="nowrap">Reward</th>
                  <th width="9%" nowrap="nowrap">Mobile </th>
                  <th width="17%" nowrap="nowrap">Last Login <?= sort_arrows('u_last_login')?></th>
                  <th width="10%" nowrap="nowrap">Status</th>
                  <!-- <th width="6%">&nbsp;</th>-->
                  <th width="2%">&nbsp;</th>
                  <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$user_full_name=$u_fname." ".$u_lname;
	$ewallet = db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$u_id'");
	 
	$total_topup = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$u_id' ");
	if ($total_topup>0) {$css = 'td_green';}  else {$css = 'td_red';} 
	if ($u_status=='Banned') {$css = 'highlight';} 
	else if ($u_status=='Inactive') {$css = 'td_sky';}  
	//db_scalar("select utype_code from ngo_users_type where utype_id='$u_utype'");
?>
                <tr class="<?=$css?>">
                  <td nowrap="nowrap"><?=$u_id?></td>
                  <td nowrap="nowrap"><a href="users_list.php?act=login&username=<?=$u_username?>" target="_blank">
                    <?=$u_username?> </a></td>
                  <td nowrap="nowrap"><?=$user_full_name?> </td> 
				  <td><?=$u_city?></td>
                  <td><?=price_format($ewallet)?></td>
                  <td><?=$u_mobile?></td>
                  <td><?=datetime_format($u_last_login)?></td>
                  <td><?=$u_status?></td>
                  <!-- <td align="center"><a href="../supp_welcome.php?u_id=<?=$u_id?>" target="_blank">Print</a> &nbsp;<a href="../supp_individualincome_adm.php?u_id=<?=$u_id?>" target="_blank">Income</a></td>-->
                  <td align="center"><a href="users_f.php?u_id=<?=$u_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                  <td align="center"><input name="arr_u_ids[]" type="checkbox" id="arr_u_ids[]" value="<?=$u_id?>"/></td>
                </tr>
                <? }
?>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right" valign="top" style="padding:2px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <!--<td width="73%" align="left" valign="top" style="padding:2px">
				   Message that will displyed to user <br />
					<input name="u_blocked_msg" type="text" value="<?=$u_blocked_msg?>" size="30" />
					<br />
					Blocked ID's(like = 45,46,48) :<br />
                    <input name="block_ids" type="text" value="<?=$block_ids?>" size="30" />
                    <br />
                   
                    <input name="Banned" type="image" id="Banned" src="images/buttons/block_id.gif"  /></td>
                     <td width="3%" align="left" valign="top" style="padding:2px">&nbsp;</td>
					<td width="16%" align="left" valign="top" style="padding:2px">Date Of Join<br />
 					   <? //=get_date_picker("DOJ", $DOJ)?>
 					   <br />
 					   <input name="Submit_DOJ" type="image" id="Submit_DOJ" src="images/buttons/submit.gif"></td>-->
                        <td width="16%"   align="center" valign="top" style="padding:2px"><? if ($password=='' ) { $password='Change Password';}?>
                          <input name="password" type="text" value="<?=$password?>" size="20" /></td>
                        <td width="18%"   align="left" valign="top" style="padding:2px"><input name="Submit_password" type="image" id="Submit_password" src="images/buttons/submit.gif" />
                          </span></td>
                        <!-- <td align="left" valign="top" style="padding:2px"><span class="tableDetails">Update Register Bank<br />
 					   <input name="u_bank_register" type="text" value="<?=$u_bank_register?>" size="20" />
                         <br />
                         <input name="Submit_Bank" type="image" id="Submit_Bank" src="images/buttons/submit.gif" />
                     </span></td>
					 
					 <td align="left" valign="top" style="padding:2px"><span class="tableDetails">Change Referer ID<br />
 					   <input name="u_ref_userid" type="text" value="<? //=$u_ref_userid?>" size="20" />
                         <br />
                         <input name="Submit_Ref" type="image" id="Submit_Ref" src="images/buttons/submit.gif" />
                     </span></td>
					
					  <td align="left" valign="top" style="padding:2px"><span class="tableDetails">Change Username  
 					   
                          <input name="Change_Username" type="image" id="Change_Username" src="images/buttons/submit.gif" />
                     </span></td> -->
                        <td width="36%" align="Left" valign="top" style="padding:2px"><?
 						 $sql ="select  utype_code, utype_name from ngo_users_type where utype_status='Active' and  utype_id>1  ";  
						echo make_dropdown($sql, 'gift_cycle', $gift_cycle,  'class="txtfleid" style="width:150px;" alt="select" emsg="Please Select Pin "', 'Please select');
							?>
                          <input name="gift_userid" type="text" value="<?=$gift_userid?>" size="20" />
                          <input name="Submit_cycle_auto" type="image" id="Submit_cycle_auto" src="images/buttons/cycle.gif"  onclick="return  updateConfirmFromUser('arr_u_ids[]')"/>
                        </td>
                        <td width="36%" align="right" valign="top" style="padding:2px"><!--<input name="Submit_cycle" type="image" id="Submit_cycle" src="images/buttons/cycle.gif"  onclick="return  updateConfirmFromUser('arr_u_ids[]')"/>-->
                          <input name="Banned2" type="image" id="Banned2" src="images/buttons/block_id.gif">
                          <input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_u_ids[]')"/>
                          <input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_u_ids[]')"/>
                        </td>
                      </tr>
                    </table>
                    <!--         -->
                  </td>
                </tr>
                <tr>
                  <td align="right" valign="top" style="padding:2px"><!--	<input name="Featured" type="image" id="Featured" src="images/buttons/featured.gif" onclick="return featuredConfirmFromUser('arr_u_ids[]')"/>
                    <input name="Unfeatured" type="image" id="Unfeatured" src="images/buttons/unfeatured.gif" onclick="return UnfeaturedConfirmFromUser('arr_u_ids[]')"/><input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_u_ids[]')"/>-->
                  </td>
                </tr>
              </table>
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
