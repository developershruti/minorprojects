<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 
if(is_post_back()) {
if ($Submit=='Update Reward List') {
$update_datefrom='2014-05-05';
$update_dateto ='2014-06-04';
 
// update all 21 days offer 
 // update all 21 days offer 
	$sql_gen = "select * from ngo_users where u_status='Active'  ";
 	if ($id_in!='') { $sql_gen .= " and u_id in ($id_in) ";} 
	else {
		if ($update_u_id1!='' && $update_u_id2!='') {  $sql_gen  .= " and (u_id >= $update_u_id1 and u_id<=$update_u_id2)";  }
	}
 	if ($update_datefrom!='' && $update_dateto!='') {  $sql_part  = " and topup_date between '$update_datefrom' AND '$update_dateto' ";  } 
 	 
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line);
	// echo "ids===". $line_gen[u_id];
  $line_gen[u_id];
 
$u_userid =$line_gen[u_id];

$u_id_a = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$u_userid' and u_ref_side='A' limit 0,1");
$u_id_b = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$u_userid' and u_ref_side='B' limit 0,1");
if ($update_datefrom!='' && $update_dateto!='') 	{  $sql_part2  = " and topup_date between '$update_datefrom' AND '$update_dateto'  and topup_status='paid' ";  }

 

$total_pair_a  = binary_total_business_date_range($u_id_a , $sql_part2)+0;
$total_pair_b = binary_total_business_date_range($u_id_b , $sql_part2)+0 ;

$total_pair_wicker=0;
if ($total_pair_a>$total_pair_b) 		{ $total_pair_wicker = $total_pair_b;}
elseif ($total_pair_b>$total_pair_a) 	{ $total_pair_wicker = $total_pair_a;}
elseif ($total_pair_a=$total_pair_b)	{ $total_pair_wicker = $total_pair_a;}

  
 // print " <br>===== $line_rew[rewa_total_id] ====> $line_gen[u_id] => strong_leg_business =$total_pair_wicker " ;
 // deduct reedimed pair
   $total_pair_used = db_scalar("select sum(win_used_left) from ngo_rewards_winner where win_userid = '$line_gen[u_id]' ");

   $total_pair_wicker = $total_pair_wicker -$total_pair_used ;
 
  
		$sql_rew = "select * from ngo_rewards where rewa_status='Active' and rewa_total_id <= $total_pair_wicker  and rewa_id not in (select win_rewaid from ngo_rewards_winner where win_userid='$line_gen[u_id]') order by rewa_id asc ";
		$result_rew = db_query($sql_rew);
		while($line_rew = mysqli_fetch_array($result_rew)){
		 $total_required_pair = $line_rew[rewa_total_id];
		 
  			if ($total_pair_wicker >= $total_required_pair) {
				
 				$win_rec_amount    = $line_rew[rewa_price];  
 				$win_used_direct =  $line_rew[rewa_total_id];
 				$msg.= $u_username.'['.$win_rec_amount.'] ,';
				$win_reward_desc ="Reward ".$line_rew[rewa_name];
				
				$reward_count = db_scalar("select count(*) from ngo_rewards_winner where win_userid = '$line_gen[u_id]' and win_rewaid = '$line_rew[rewa_id]' ");
  				if ($reward_count==0) {
			
 				$sql = "insert into ngo_rewards_winner set  win_userid = '$line_gen[u_id]',win_rewaid = '$line_rew[rewa_id]' ,win_reward_desc = '$win_reward_desc' ,win_used_left='$total_required_pair',win_used_right='$total_required_pair',win_used_direct='$win_used_direct' , win_rec_amount = '$win_rec_amount' ,win_date=ADDDATE('$pay_date',INTERVAL 750 MINUTE)  ";
				db_query($sql);
			 	$total_pair_wicker -= $total_required_pair;
			 
			 // print " <br><br>===== $line_rew[rewa_total_id] ====> $line_gen[u_id] => total_pair_wicker = $total_pair_wicker " ;
				}
 			   }
 			
		 }
  	  }	 
	$msg =  $count . " Record updated";
	//header("Location: ".$_SERVER['HTTP_REFERER']);
	//exit;
	}
}	




$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users ,ngo_rewards_winner where u_id=win_userid  ";
$sql .= "  and u_status!='Banned' ";
if ($u_id1!='' && $u_id2!='') {  $sql .= " and (u_id >= $u_id1 and u_id<=$u_id2)";   }

$sql = apply_filter($sql, $u_fname, $u_fname_filter,'u_fname');
if ($win_rewaid!='') 			{$sql .= " and win_rewaid='$win_rewaid' "; }
 if ($u_username!='') 		{$sql .= " and u_username='$u_username' "; }
//if ($u_total_referer!='') 			{$sql .= " and u_total_referer='$u_total_referer' "; }
if (($datefrom!='') && ($dateto!='')){ $sql .= " and u_date between '$datefrom' AND '$dateto' "; }
 
/// downline payout list of a user
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
  	if ($export4=='1') {
 		$arr_columns =array('u_id'=>'User ID','u_ref_userid'=>'Referer ID','u_utype'=>'POST ','u_fname'=>'First Name','u_lname'=>'Last Name','u_address'=>'Address','u_date'=>'DOJ','win_rewaid'=>'Reward ID','win_reward_desc'=>'Reward Desc','win_used_left'=>'Left Leg','win_used_right'=>'Right Leg','win_rec_userid'=>'Rec UserID','win_rec_name'=>'Rec Name','win_rec_date'=>'Rec Date','win_rec_contact'=>'Contact Number');
		export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='');
		exit;
	}
}
 	
if ($export1=='1') {
 	$arr_columns =array('u_id'=>'User ID','u_fname'=>'First Name','u_lname'=>'Last Name','u_address'=>'Address','u_date'=>'DOJ','win_rewaid'=>'Reward ID','win_reward_desc'=>'Reward Desc','win_used_left'=>'Left Leg','win_used_right'=>'Right Leg','win_rec_userid'=>'Rec UserID','win_rec_name'=>'Rec Name','win_rec_date'=>'Rec Date','win_rec_contact'=>'Contact Number');
 	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}

if ($export2=='1') {
 	$arr_columns =array('u_id'=>'User ID','u_fname'=>'User Name' ,'u_address'=>'Address','u_date'=>'DOJ','win_rewaid'=>'Reward ID','win_reward_desc'=>'Reward Desc','win_used_left'=>'Left Leg','win_used_right'=>'Right Leg','win_rec_userid'=>'Rec UserID','win_rec_name'=>'Rec Name','win_rec_date'=>'Rec Date','win_rec_contact'=>'Contact Number');
 	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}
//$sql .= " and u_id in (select u_ref_userid from ngo_users group by u_ref_userid) ";

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
<? include("top.inc.php");?>
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Rewards Achiver List </div></td>
        </tr>
      </table>
	 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="63%"  >
		   <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
		  <table width="629"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
            <tr align="center">
              <th colspan="5">Search</th>
            </tr>
            <tr>
              <td width="112" align="right" class="tdLabel">User ID From/To:</td>
              <td width="185"><input name="u_id1" type="text" value="<?=$u_id1?>" size="8"   />
                <input name="u_id2" type="text" value="<?=$u_id2?>" size="8"   /></td>
              <td align="right">Reward : </td>
              <td><?
 		$sql ="select rewa_id , rewa_name from ngo_rewards where rewa_status='Active'  ";  
		echo make_dropdown($sql, 'win_rewaid', $win_rewaid,  'class="txtbox"  style="width:120px;"','--Select Post--');
		?></td>
              <td width="118"><input name="export1" type="checkbox" id="export1" value="1" />
Export Achiver list </td>
            </tr>
            <tr>
              <td height="26"   align="right" class="tdLabel">Name : </td>
              <td colspan="2"  ><input name="u_fname" type="text" value="<?=$u_fname?>"  size="20" />                <?=filter_dropdown('u_fname_filter', $u_fname_filter)?></td>
              <td  >&nbsp;</td>
              <td  ><input name="export2" type="checkbox" id="export2" value="1" />
Export Reward list </td>
            </tr>
            <tr>
              <td align="right" class="tdLabel">Username  : </td>
              <td><input name="u_username" type="text" value="<?=$u_username?>" /></td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
            </tr>
          </table>
		  </form>
		  </td>
		  <td width="37%" align="center" valign="top">  
		  <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
		    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableSearch">
              <tr>
                <td height="25" colspan="2" class="tableList"><strong>Update Rewards </strong></td>
                </tr>
				<tr>
                <td align="right" valign="middle"> Date From/To:</td>
                <td> 05 May  2014 To 04 June 2014 <? //=get_date_picker("update_datefrom", $update_datefrom)?>
                  <? //=get_date_picker("update_dateto", $update_dateto)?></td>
                </tr>
              <tr>
                <td width="32%" align="right" valign="middle"><span class="tdLabel">User ID From/To:</span></td>
                <td width="68%"><input name="update_u_id1" type="text" value="<?=$update_u_id1?>" size="8">
                  <input name="update_u_id2" type="text" value="<?=$update_u_id2?>" size="8"></td>
                </tr>
             <!-- <tr>
                <td align="right" valign="middle">DOJ from/to:</td>
                <td><? //=get_date_picker("update_datefrom", $update_datefrom)?>
                  <? //=get_date_picker("update_dateto", $update_dateto)?></td>
                </tr>-->
              <tr>
                <td align="right" class="tdData">Update  date: </td>
                <td class="txtTotal"><?=get_date_picker("pay_date", $pay_date)?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit" value="Update Reward List" /></td>
                </tr>
            </table>
	      </form>   </td>
        </tr>
      </table>
    
	
    <div class="msg"><?=$msg?></div>
      <br/>
            <div align="right"></div>
      <? if(mysqli_num_rows($result)==0){?>
      <div class="msg">Sorry, no records found.</div>
      <? } else{ 
	  ?>
      <div align="right">&nbsp;&nbsp;&nbsp;Showing Records: <?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of <?= $reccnt?> </div>
      <div>Records Per Page: <?=pagesize_dropdown('pagesize', $pagesize);?> </div>
       <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <br />
         <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="65" nowrap="nowrap">UserID</th>
            <th width="83" nowrap="nowrap"> Name
              <?= sort_arrows('u_fname')?></th>
            <th width="70" nowrap="nowrap">DOJ
              <?= sort_arrows('u_date')?></th>
            <th width="43" nowrap="nowrap">City</th>
            <th width="43" nowrap="nowrap">Left </th>
            <th width="53" nowrap="nowrap"> Right </th>
            <th width="58" nowrap="nowrap"> Used </th>
            <th width="75">Amount </th>
			 <th width="197">Reward</th>
              <th width="86">Rec ID </th>
             <th width="118">Rec Name </th>
             <th width="108">Rec Mobile </th>
             <th width="94">Rec Date </th>
            <th width="24">&nbsp;</th>
            <th width="28"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$user_full_name=$u_fname." ".$u_lname;
	//db_scalar("select utype_code from ngo_users_type where utype_id='$u_utype'");
?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$u_username?></td>
            <td nowrap="nowrap"><?=$user_full_name?> </td>
            <td nowrap="nowrap"><?=date_format2($u_date)?></td>
            <td align="center" nowrap="nowrap"><?=$u_city?></td>
            <td align="center" nowrap="nowrap"><?=$win_used_left?>  </td>
            <td align="center" nowrap="nowrap"><?=$win_used_right?></td>
            <td align="center" nowrap="nowrap"><?=$win_used_direct?></td>
            <td align="center"><?=$win_rec_amount?></td>
			<td align="center"><?=db_scalar("select rewa_name from ngo_rewards where rewa_id='$win_rewaid'");?></td>
             <td align="center"><?=$win_rec_userid?></td>
            <td align="center"><?=$win_rec_name?></td>
            <td align="center"><?=$win_rec_contact?></td>
            <td align="center" nowrap="nowrap"><?=date_format2($win_rec_date)?></td>
            <td align="center"><a href="reward_referer_f.php?win_id=<?=$win_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
            <td align="center"><input name="arr_u_ids[]" type="checkbox" id="arr_u_ids[]" value="<?=$u_id?>"/></td>
           </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" valign="top" style="padding:2px">
					<!--         -->
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
				  <td align="right" valign="top" style="padding:2px">
				    <table  border="0" align="right" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="288" align="right" class="tdData">Reward :
                          <input type="text" name="offer_reward_update" value="<?=$offer_reward_update?>" /></td>
                      </tr>
                    </table>
				    <br />					</td>
					
					 <td align="right" valign="top" style="padding:2px"><input name="Deactivate" type="image" id="Deactivate" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_u_ids[]')"/>   </td>
                  </tr>
				  </table>
					<!--         -->
					</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" style="padding:2px">
					
				<!--	<input name="Featured" type="image" id="Featured" src="images/buttons/featured.gif" onclick="return featuredConfirmFromUser('arr_u_ids[]')"/>
                    <input name="Unfeatured" type="image" id="Unfeatured" src="images/buttons/unfeatured.gif" onclick="return UnfeaturedConfirmFromUser('arr_u_ids[]')"/><input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_u_ids[]')"/>-->


                    </td>
                  </tr>
        </table>
		  <? }
?>
      </form>
    <? include("paging.inc.php");?> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
