<?
require_once("../includes/surya.dream.php");
 #print_r($_POST);
 protect_admin_page2();
if(is_post_back()) {
	$arr_check_ids = $_REQUEST['arr_check_ids'];
	if(is_array($arr_check_ids)) {
		$str_check_ids = implode(',', $arr_check_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  			$sql = "delete from ngo_cheque where check_id in ($str_check_ids)";
			db_query($sql);
 		} else if(isset($_REQUEST['Print']) || isset($_REQUEST['Print_x']) ) {
			$sql = "update ngo_cheque set check_print = 'yes',check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now() where check_id in ($str_check_ids)";
			db_query($sql);
			$_SESSION['arr_check_ids'] =$_REQUEST['arr_check_ids'] ;
			header ("location: cheque_print_single.php");
			exit();
			#$sql = "update ngo_cheque set check_status = 'Active' where check_id in ($str_check_ids)";
			#db_query($sql);
		 } else if(isset($_REQUEST['Print2']) || isset($_REQUEST['Print2_x']) ) {
			$sql = "update ngo_cheque set check_print = 'yes',check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now() where check_id in ($str_check_ids)";
			db_query($sql);
			$_SESSION['arr_check_ids'] =$_REQUEST['arr_check_ids'] ;
			header ("location: cheque_print.php");
			exit();
			#$sql = "update ngo_cheque set check_status = 'Active' where check_id in ($str_check_ids)";
			#db_query($sql);
		} else if(isset($_REQUEST['Remark']) || isset($_REQUEST['Remark_x']) ) {
  			 $sql = "update ngo_cheque set check_remark = '$check_remark',check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now() where check_id in ($str_check_ids)";
			 db_query($sql);
		
		} else if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ) {
  			if ($rec_id2!='') { $sql_part .= " ,check_rec_id ='$rec_id2' ";}
			if ($check_status2!='Cancel') { $sql_part .= " ,check_rec_date =now() ";}
			$sql = "update ngo_cheque set  check_status='$check_status2',check_editby = '$_SESSION[sess_admin_login_id]',check_edit_date = now() $sql_part where check_id in ($str_check_ids)";
			db_query($sql);
			if ($return_cheque==1 && $check_status2=='Cancel') {
				$sql_return = "select *  from ngo_cheque  where check_id in ($str_check_ids) ";
				$result_return = db_query($sql_return);
				while ($line_return= mysqli_fetch_array($result_return)){
				@extract($line_return);
				$count = db_scalar(" select count(*) from ngo_cheque_return where check_userid='$check_userid' and check_cheque_no='$check_cheque_no'");
				if ($count==0) {
				//, check_rec_id='', check_rec_name='', check_rec_date='',check_contact='' ,check_remark=''
				 $sql_insert = "insert into ngo_cheque_return set  check_userid='$check_userid',check_bank='$check_bank' ,check_cheque_no='$check_cheque_no' ,check_amount='$check_amount' ,check_inword='$check_inword' , check_date='$check_date' , check_type='$check_type' ,check_status='$check_status' ,check_remark='$check_remark',check_rec_date=now()";
				db_query($sql_insert);
				
				}
				}
			}
			
  		} else if(isset($_REQUEST['Submit_Closing']) || isset($_REQUEST['Submit_Closing_x']) ) {
  			if($closeid!='') {
			$sql = "update ngo_cheque set check_closeid = '$closeid' ,check_for='$check_for'  where check_id in ($str_check_ids)";
			db_query($sql);
			}
		}else if(isset($_REQUEST['Send_SMS']) || isset($_REQUEST['Send_SMS_x']) ) {
  			 // sms code start
			 	$sql_test = "select * from  ngo_cheque, ngo_users  where ngo_cheque.check_userid=ngo_users.u_id and u_mobile!='' and check_id in ($str_check_ids) ";
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
				@extract($line_test);
				//send sms to user 
				 $message ="" .SITE_NAME." CONGRATULATION ".$u_fname." " .$u_lname." YOUR PAYOUT READY & PAYOUT AMT ".$line_test[check_amount]." PLZ COLLECT PAYOUT FROM HEAD OFFICE.4 MORE DETAILS  ";
			 send_sms($u_mobile,$message);
				
				 
				//end sms code
					
					
				}
 			 /// end 
 		}
	}
	# header("Location: ".$_SERVER['HTTP_REFERER']);
	# exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_cheque, ngo_users   ";
$sql .= " where ngo_cheque.check_userid=ngo_users.u_id   ";


if (($check_id_from!='') && ($check_id_to!='')) {$sql .= " and (check_userid  between $check_id_from  and  $check_id_to )";}
else if (($check_id_from!='') && ($check_id_to=='')) {$sql .= " and  check_userid ='$check_id_from' ";}
if ($check_cheque_no!='') {$sql .= " and  check_cheque_no like '$check_cheque_no%' ";}

if ($check_closeid!='') {$sql .= " and  check_closeid ='$check_closeid' ";}
if (($check_date1!='') && ($check_date2!='')){ $sql .= " and check_date between '$check_date1' AND '$check_date2' "; }
if (($rec_date1!='') && ($rec_date2!='')){ $sql .= " and check_rec_date between '$rec_date1' AND '$rec_date2' "; }

if ($check_bank!='') {$sql .= " and  check_bank ='$check_bank' ";}
if ($check_status_filter!='') {$sql .= " and  check_status  ='$check_status_filter' ";}
if ($check_amount!='') {$sql .= " and  check_amount  ='$check_amount' ";}
//$sql = apply_filter($sql, $check_title, $check_title_filter,'check_title');
if ($check_type!='') {$sql .= " and  check_type ='$check_type' ";}
if ($check_rec_id!='') {$sql .= " and  check_rec_id ='$check_rec_id' ";}
if ($check_payment_mode!='') {$sql .= " and  check_payment_mode ='$check_payment_mode' ";}

/////////////////////////
if ($referid!=''){
$id = array();
$id[]=$referid;
 while ($sb!='stop'){
if ($referid=='') {$referid=$u_downline;}
$sql_test = "select u_id  from ngo_users  where  u_ref_userid in ($referid)  ";
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
if ($id_in!='') {$sql .= " and u_id in ($id_in)  "; }
} 

//////////////////////////


if ($export2=='1') {
 	$export_id = array();
	$export_id[]=0;
	$export_sql= "select check_userid,  count(*) as counter ".$sql . "  group by  check_userid ,check_amount ";
 	$export_result = db_query($export_sql);
	while ($line_export = mysqli_fetch_array($export_result)) {
 		if ($line_export[counter]>=2) {
			///print "<br>.  userID=". $line_export[check_userid]."  --- counter=".$line_export[counter];
		 	$export_id[] = $line_export[check_userid];}
 	}
	$export_ids = implode(",",$export_id);
 	//print_r($export_id);            
 // ,'check_status'=>'check_status'
	    $export_sql2 = "   from  ngo_cheque , ngo_users where ngo_cheque.check_userid=ngo_users.u_id and  check_userid in ($export_ids ) order by check_userid asc ";
	$arr_columns =array('check_userid'=>'User ID','u_fname'=>'User Name','u_utype'=>'Post ID','u_mobile'=>'Mobile','check_cheque_no'=>'Cheque No','check_bank'=>'Bank','check_amount'=>'Amount','check_date'=>'Cheque Date','check_rec_id'=>'Rec id','check_rec_name'=>'Rec Name','check_rec_date'=>'Rec Date','check_contact'=>'Contact Number','check_for'=>'Payment For','check_closeid'=>'Closing ID','check_payment_mode'=>'Payment Mode');
 
 	    export_delimited_file($export_sql2, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	   exit;
}


$order_by == '' ? $order_by = 'check_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";

if ($export=='1') {
 	 $arr_columns =array('check_id'=>'AutoID','check_userid'=>'UserID','u_fname'=>'User Name','u_utype'=>'Post ID','u_mobile'=>'Mobile','check_type'=>'Cheque Type','check_bank'=>'Bank Name','check_amount'=>'Amount','check_date'=>'Cheque Date','check_cheque_no'=>'Cheque No','check_rec_id'=>'Rec id','check_rec_name'=>'Rec Name','check_rec_date'=>'Rec Date','check_contact'=>'Contact Number','check_status'=>'Status','check_for'=>'Payment For','check_closeid'=>'Closing ID','check_payment_mode'=>'Payment Mode');
	 export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	 exit;
}


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
          <td id="pageHead"><div id="txtPageHead"> PDC/General Cheque    List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="left"><form method="get" name="form2" id="form2" action="cheque_list.php" onsubmit="return confirm_submit(this)">
           
              <table width="472"  border="0" align="center"  cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="4">Search</th>
                </tr>
                <tr>
                  <td class="tdLabel">User ID From/To </td>
                  <td><input name="check_id_from" type="text"style="width:50px;" value="<?=$check_id_from?>">
                      <input name="check_id_to" style="width:50px;"type="text" value="<?=$check_id_to?>" /></td>
                  <td align="right">Status</td>
                  <td><?=checkstatus_dropdown('check_status_filter',$check_status_filter)?></td>
                </tr>
                <tr>
                  <td class="tdLabel">Cheque Number </td>
                  <td><input name="check_cheque_no"style="width:120px;" type="text" value="<?=$check_cheque_no?>" /></td>
                  <td align="right">Bank Name </td>
                  <td><input name="check_bank" type="text" id="check_bank"  value="<?=$check_bank?>" /><? //=bank_dropdown('check_bank',$check_bank)?></td>
                </tr>
                <tr>
                  <td class="tdLabel">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td align="right">&nbsp;</td>
                  <td><input name="export" type="checkbox" id="export" value="1" />
Export to CSV </td>
                </tr>
                <tr>
                  <td class="tdLabel">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              
			  <!--
			   <tr>
                  <td class="tdLabel">Cheque Date from </td>
                  <td><? #=get_date_picker("check_date1", $check_date1)?></td>
                  <td align="right"><span class="tdLabel">Cheque Date To</span></td>
                  <td><? #=get_date_picker("check_date2", $check_date2)?></td>
                </tr>
                <tr>
                  <td class="tdLabel">&nbsp;</td>
                  <td> </td>
                  <td align="right">Type</td>
                  <td> 
                  <? #=checktype_dropdown("check_type", $check_type)?></td>
                </tr>
                <tr>
                  <td>Rece <span class="tdLabel">Date from</span></td>
                  <td><? #=get_date_picker("rec_date1", $rec_date1)?></td>
                  <td align="right">Rece <span class="tdLabel"> Date To</span></td>
                  <td align="left" valign="middle"><? #=get_date_picker("rec_date2", $rec_date2)?></td>
                </tr>
                <tr>
                  <td valign="top">Amount</td>
                  <td valign="top"><input name="check_amount" style="width:120px;"type="text" value="<? #=$check_amount?>" /></td>
                  <td align="right" valign="top">Payment Mode: </td>
                  <td align="left" valign="top"><span class="tableDetails">
                    <? #=payment_mode_dropdown('check_payment_mode',$check_payment_mode)?>
                  </span><br /></td>
                </tr>
                <tr>
                  <td valign="top">Refer ID</td>
                  <td valign="top"><input name="referid" type="text" value="<? //=$referid?>" size="20" /></td>
                  <td align="right" valign="top">Rec User ID</td>
                  <td align="left" valign="top"><input name="check_rec_id" style="width:120px;"type="text" value="<? #=$check_rec_id?>" /></td>
                </tr>
                <tr>
                  <td valign="top">Closing</td>
                  <td valign="top"><?
		 
		#echo make_dropdown("select close_id , close_id from ngo_closing where close_status='Active' order by close_id desc", 'check_closeid', $check_closeid,  'class="txtbox"  style="width:120px;"','--select--');
		?></td>
                  <td align="right" valign="top">&nbsp;</td>
                  <td align="left" valign="top"><input name="export2" type="checkbox" id="export2" value="1" />
Only Duplicate Record</td>
                </tr> -->
              </table>
              <br />

            </form>
            <div align="right">  <a href="cheque_f.php">Create New Cheque </a></div>
              <!--<a href="cheque_auto_f.php">Auto Generated PDC Cheque </a>&nbsp;|&nbsp;
            &nbsp;|&nbsp; <a href="cheque_import.php">Import Cheque List</a>&nbsp;|&nbsp; <a href="cheque_updated_import.php">Import Updated Cheque List</a></div>-->
            <? if(mysqli_num_rows($result)==0){?>
            <div class="msg">Sorry, no records found.</div>
            <? } else{ ?>
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
            <!--action="cheque_print_single.php"-->
            <form method="post" name="form1" id="form1" >
              <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
                <tr>
                  <!-- <th width="5%" align="left" nowrap="nowrap">Sl No </th>-->
                  <th width="5%" align="left" nowrap="nowrap">User ID </th>
                  <th width="7%" align="left" nowrap="nowrap">Name </th>
                  <th width="8%" align="left" nowrap="nowrap">Mobile</th>
			      <th width="8%" align="left" nowrap="nowrap">Check Type </th>
                  <th width="7%" align="left" nowrap="nowrap">Cheque No </th>
                  <th width="8%" align="left" nowrap="nowrap">Cheque Date </th>
                  <th width="6%" align="left" nowrap="nowrap">Amount </th>
                  <th width="4%" align="left" nowrap="nowrap">Bank </th>
                  <th width="5%" align="left" nowrap="nowrap">Status</th>
                  <th width="5%" align="left" nowrap="nowrap">Rec ID </th>
                  <th width="16%" align="left" nowrap="nowrap">Rec name </th>
                  <th width="6%">Rec mobile. </th>
                  <th width="6%"   >Rec Date </th>
                  <th width="3%"   >Mode</th>
				  <th width="3%"   >Pay-For</th>
                  <th width="4%"   >Edit by </th>
                  <th width="4%"   >Print</th>
                  <th width="2%"   > </th>
                  <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$duplicate  = db_scalar("select count(*) from ngo_cheque where check_userid='$check_userid' and  check_amount='$check_amount'");
	if ($duplicate>=2) { $error='bgcolor="#FF2020"';$css='tdLabel'; }
	
 ?>
                <tr class="<?=$css?>"  <?=$error?>>
                  <!-- <td nowrap="nowrap"><? //=$check_id?></td>-->
                  <td nowrap="NOWRAP"><?=$u_username?></td>
                  <td nowrap="NOWRAP"><?=$u_fname ?></td>
                  <td nowrap="NOWRAP"><?=$u_mobile?></td>
				  <td nowrap="NOWRAP"><?=$check_type ?></td>
                  <td nowrap="NOWRAP"><?=$check_cheque_no ?></td>
                  <td nowrap="NOWRAP"><?=date_format2($check_date)?></td>
                  <td nowrap="NOWRAP"><?=$check_amount?></td>
                  <td nowrap="NOWRAP"><?=$check_bank?></td>
                  <td nowrap="NOWRAP"><?=$check_status?></td>
                  <td nowrap="NOWRAP"><?=$check_rec_id?></td>
                  <td nowrap="NOWRAP"><? if ($check_rec_name!='') { echo $check_rec_name;} else { echo db_scalar("select u_fname  from ngo_users where u_id='$check_rec_id'");}?></td>
                  <td align="center" nowrap="nowrap"><? if ($check_contact!='') { echo $check_contact;} else { echo db_scalar("select u_mobile  from ngo_users where u_id='$check_rec_id'");}?>
                    <? //=$check_contact?></td>
                  <td align="center" nowrap="nowrap"><?=date_format2($check_rec_date)?></td>
                  <td align="center" nowrap="nowrap"><?=$check_payment_mode ?></td>
                  <td align="center" nowrap="nowrap"><?=$check_for ?></td>
                  <td align="center" nowrap="nowrap"><?=$check_editby ?></td>
                  <td align="center" nowrap="nowrap"><?=$check_print ?></td>
                  <!-- <td align="center"><a href="cheque_print.php?check_id=<? //=$check_id?>" target="_blank">Print</a></td>-->
                  <td align="center" nowrap="nowrap"><a href="cheque_f.php?check_id=<?=$check_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                  <td align="center" nowrap="nowrap"><input name="arr_check_ids[]" type="checkbox" id="arr_check_ids[]" value="<?=$check_id?>" /></td>
                </tr>
                <? }
?>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right" valign="top"  colspan="5" height="5"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" valign="top" >
				  <!--<table width="200" border="0" cellpadding="1" cellspacing="0" class="tableSearch">
                    <tr>
                      <td align="right">Cloging ID:</td>
                      <td><?
		 
		#echo make_dropdown("select close_id , close_id from ngo_closing where close_status='Active' order by close_id desc", 'closeid', $closeid,  'class="txtbox"  style="width:120px;"','--select--');
		?></td>
                    </tr>
                    <tr>
                      <td align="right">Payment for : </td>
                      <td><input name="check_for" type="text" value="<?=$check_for?>" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input name="Submit_Closing" type="image" id="Submit_Closing" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_check_ids[]')"/></td>
                    </tr>
                  </table>-->
                  <br /></td>
                  <td width="25%" align="center" valign="top" ><table width="322" border="0" cellpadding="1" cellspacing="0" class="tableSearch">
                    <tr>
                      <td width="74" align="right">Receiver ID: </td>
                      <td width="134"><input name="rec_id2" type="text" id="rec_id2" value="<?=$rec_id2?>" />
                        <?=checkstatus_dropdown('check_status2',$check_status2)?></td>
                    </tr>
                    <tr>
                      <td align="right">&nbsp; </td>
                      <td><input name="Submit" type="image" id="Submit" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_check_ids[]')"/></td>
                    </tr>
                   <!-- <tr>
                      <td colspan="2" align="left" valign="baseline"><input name="return_cheque" type="checkbox" id="return_cheque" value="1" />
                        Add to return check list </td>
                      </tr>-->
                  </table></td>
                  <td width="23%" align="right" valign="top" ><table width="200" border="0" align="center" cellpadding="1" cellspacing="0" class="tableSearch">
                    <tr>
                      <td align="right">Remark:</td>
                      <td><input name="check_remark" type="text" value="<?=$check_remark?>" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><input name="Remark" type="image" id="Remark" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_check_ids[]')"/></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                 <!-- <td width="11%" align="center" valign="middle" class="tableSearch" >
				  <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_check_ids[]')"/></td>-->
                  <td width="16%" align="center" valign="middle" class="tableSearch" ><input name="Send_SMS" type="image" id="Send_SMS" src="images/buttons/send_sms.gif" onclick="return updateConfirmFromUser('arr_check_ids[]')"/>
                     <!-- <br />
                    <input name="Print2" type="image" id="Print2" src="images/buttons/cheque_print2.gif" onclick="return printConfirmFromUser('arr_check_ids[]')"/>-->
                    <br />
                    <input name="Print" type="image" id="Print" src="images/buttons/cheque_print.gif" onclick="return printConfirmFromUser('arr_check_ids[]')"/>
                  <br />                  </td>
                </tr>
              </table>
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
