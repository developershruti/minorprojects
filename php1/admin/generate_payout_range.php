<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 
if($payout_for=='ClubIncome') {
 	if ($u_id1!='' && $u_id2!='') { $sql_part .= " and (u_id >= $u_id1 and u_id<=$u_id2)"; }
	if ($datefrom!='' && $dateto!='') {  $sql_part .= " and u_date between '$datefrom' AND '$dateto' ";  } 
  	$sql_gen = "select u_id  ,u_utype ,u_utype_value,u_date,u_total_referer from ngo_users where u_total_referer>=14  and u_status!='Banned' ".$sql_part;
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
		@extract($line_gen);
		
		$payout_count1=db_scalar("select count(upay_id) from ngo_users_payout where upay_userid='$u_id' and upay_closeid='$u_closeid' and upay_for='PoolClubIncome'");
		if ($payout_count1==0) {
		//print "<br>====". $u_total_referer;
		if ($u_total_referer>=14 && $u_total_referer<30){
			$total_id_7 = db_scalar("select count(*) from ngo_users where 1 ".$sql_part );
			$total_pair_7 = db_scalar("select count(*) from ngo_users where u_total_referer>=14  and u_total_referer<=30 ".$sql_part );
			$msg.= $u_id.' ,';
			$upay_amount = ($total_id_7*20)/$total_pair_7;
			 $sql = "insert into ngo_users_payout set  upay_closeid = '$u_closeid', upay_sponsor_level ='1', upay_pono='1', upay_userid = '$u_id',upay_refid = '' ,upay_for = 'PoolClubIncome' ,upay_qty = '$u_utype_value', upay_rate = '20', upay_amount = '$upay_amount' ,upay_datetime =ADDDATE('$u_date',INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql);
		} 
	} else if ($u_total_referer>=30){
			$total_id_15 = db_scalar("select count(*) from ngo_users where 1 ".$sql_part );
			$total_pair_15 = db_scalar("select count(*) from ngo_users where u_total_referer>=14  and u_total_referer<=30 ".$sql_part );
			$msg.= $u_id.' ,';
			$upay_amount = ($total_id_15*40)/$total_pair_15;
			 $sql = "insert into ngo_users_payout set  upay_closeid = '$u_closeid', upay_sponsor_level ='1', upay_pono='1', upay_userid = '$u_id',upay_refid = '' ,upay_for = 'PoolClubIncome' ,upay_qty = '$u_utype_value', upay_rate = '40', upay_amount = '$upay_amount' ,upay_datetime =ADDDATE('$u_date',INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' ";
			db_query($sql);
	
	}	
 		 
	}
}		
		
  
  
  
  
  
  
  
  
  
  
  
 	
	//------------------working payout code start ------------------ 
 	if($payout_for=='Working' || $payout_for=='LevelWorkingIncome') {
 	 // select user list to generate payout for 
	 //&& ($u_id1!='') && ($u_id2!='')
	$sql_gen = "select u_id ,u_ref_userid ,u_closeid ,u_utype ,u_utype_value,u_date from ngo_users where u_ref_userid!=0  and u_status!='Banned'   ";
	if ($u_id1!='' && $u_id2!='') { $sql_gen .= " and (u_id >= $u_id1 and u_id<=$u_id2)"; }
	if ($datefrom!='' && $dateto!='') {  $sql_gen .= " and u_date between '$datefrom' AND '$dateto' ";  } 
  	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) {
	@extract($line_gen);
 	if ($u_ref_userid!='' && $u_ref_userid!=0){
 
#-------- ngo plan working code Start -------------------
		// Direct Income level 1
  	$payout_count1 = db_scalar("select count(upay_id) from ngo_users_payout where  upay_userid = '$u_ref_userid'  and upay_refid = '$u_id' and upay_for='Working' ");
	if ($payout_count1==0) {
		$msg.= $u_id.' ,';
		$workingpayrate1 = db_scalar("select sett_value from ngo_setting where sett_id=19 ");
		$upay_amount = $workingpayrate1*$u_utype_value;
		$sql = "insert into ngo_users_payout set  upay_closeid = '$u_closeid', upay_sponsor_level ='1', upay_pono='1', upay_userid = '$u_ref_userid',upay_refid = '$u_id' ,upay_for = 'Working' ,upay_qty = '$u_utype_value', upay_rate = '$workingpayrate1', upay_amount = '$upay_amount' ,upay_datetime =ADDDATE('$u_date',INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' ";
		db_query($sql);
		
 		// Direct Income level 2
		//print "ID 2 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid' ";
		$u_ref_userid2 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid' and u_status!='Banned'  ");
		if ($u_ref_userid2!='' && $u_ref_userid2!=0){
			$workingpayrate2 = db_scalar("select sett_value from ngo_setting where sett_id=20 ");
			$upay_amount2 = $workingpayrate2*$u_utype_value;
			$sql2 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='2', upay_pono='2'  ,upay_userid='$u_ref_userid2' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate2', upay_amount='$upay_amount2' ,upay_datetime =ADDDATE('$u_date',INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
 			db_query($sql2);
			// Direct Income level 3
			//print "ID 3 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid2' ";
			 $u_ref_userid3 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid2' and u_status!='Banned'  ");
			if ($u_ref_userid3!='' && $u_ref_userid3!=0){
				$workingpayrate3 = db_scalar("select sett_value from ngo_setting where sett_id=21 ");
				$upay_amount3 = $workingpayrate3*$u_utype_value;
				$sql3 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='3',  upay_pono='3', upay_userid='$u_ref_userid3' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate3', upay_amount='$upay_amount3' ,upay_datetime =ADDDATE('$u_date',INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
				db_query($sql3);
				// Direct Income level 4
				//print "ID 4 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid3' ";
 					$u_ref_userid4 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid3' and u_status!='Banned' ");
				if ($u_ref_userid4!='' && $u_ref_userid4!=0){
					$workingpayrate4 = db_scalar("select sett_value from ngo_setting where sett_id=22 ");
					$upay_amount4 = $workingpayrate4*$u_utype_value;
					$sql4 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='4',  upay_pono='4' , upay_userid='$u_ref_userid4' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate4', upay_amount='$upay_amount4' ,upay_datetime =ADDDATE('$u_date',INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
					db_query($sql4);
			  		// Direct Income level 5
					//print "ID 5 =" ."select u_ref_userid from ngo_users where u_id='$u_ref_userid4' ";
					 $u_ref_userid5 = db_scalar("select u_ref_userid from ngo_users where u_id='$u_ref_userid4' and u_status!='Banned' ");
					if ($u_ref_userid5!='' && $u_ref_userid5!=0){
						$workingpayrate5 = db_scalar("select sett_value from ngo_setting where sett_id=23 ");
						$upay_amount5= $workingpayrate5*$u_utype_value;
						$sql5 = "insert into ngo_users_payout set  upay_closeid='$u_closeid', upay_sponsor_level='5', upay_pono='5' , upay_userid='$u_ref_userid5' ,upay_refid='$u_id' ,upay_for='LevelWorkingIncome' ,upay_qty='$u_utype_value', upay_rate='$workingpayrate5', upay_amount='$upay_amount5' ,upay_datetime =ADDDATE('$u_date',INTERVAL 750 MINUTE),upay_admin='$_SESSION[sess_admin_login_id]' "; 
						db_query($sql5);
 					}
				}
 		  	}
 		} 
 	}
	
 
#-------- ngo plan working code end-------------------
		}		
	}
}

	
	// working payout code end 
 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead">Generate Payout </div></td>
        </tr>
      </table>
      <div align="right"><a href="closing_list.php">Back to Closing List</a>&nbsp;</div>
      <div align="left">
        <?=$msg?>
      </div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <table width="423"  border="0" align="center" cellpadding="2" cellspacing="2" class="tableSearch">
          <tr>
            <td align="right" class="tdLabel">&nbsp;</td>
            <td  >&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="tdLabel">User ID From : </td>
            <td  ><input name="u_id1" style="width:120px;" type="text" value="<?=$u_id1?>"  />
            </td>
            <td align="right"> To</td>
            <td><input name="u_id2" style="width:120px;"type="text" value="<?=$u_id2?>"  />
            </td>
          </tr>
          <tr class="tableSearch">
            <td align="right">DOJ From: </td>
            <td><?=get_date_picker("datefrom", $datefrom)?></td>
            <td align="right">DOJ To: </td>
            <td><?=get_date_picker("dateto", $dateto)?></td>
            <input type="hidden" name="u_id" value="<?=$u_id?>"/>
          </tr>
          <tr>
            <td width="75" align="right" class="tdData">Payout Type : </td>
            <td width="121" class="txtTotal"><?
			echo array_dropdown( $ARR_SUPP_PAYMENT_TYPE, $payout_for,'payout_for', 'class="txtbox"  style="width:120px;" alt="select" emsg="Please select payout type"','--select--');
			?></td>
            <td width="63" align="right" class="tdData"><p>Club Name : </p>
            </td>
            <td width="136" class="txtTotal"> 
			 <?
					 
						echo make_dropdown("select utype_id,utype_name from ngo_users_type where  utype_status='Active'", 'utype_id', $utype_id,  'class="txtbox"  style="width:140px;"  " ','--select--');
							?>
			 
			 </td>
          </tr>
          <!-- <tr>
            <td align="right" class="tdData">Poyout No : </td>
            <td class="txtTotal"> 
			<select name="payout_no" style="width:120px;" alt="select" emsg="Please select payout no">
			<option value=""><? //=$ctr?>--Select--</option>
 			<? /* while($ctr<12) { $ctr++; ?>
			<option value="<?=$ctr?>" <? if ($ctr==$payout_no) { echo "selected";} ?>><?=$ctr?></option>
			<?  } */?>
			
			</select>
          
            </td>
            <td class="tdData">&nbsp;</td>
            <td class="txtTotal">&nbsp;</td>
          </tr> -->
		  
		  
		  
          <!--<tr>
            <td align="right" class="tdData">Closing ID :</td>
            <td class="txtTotal"><?
		# $sql ="select close_id , close_id from ngo_closing order by close_id desc";  
		 # echo make_dropdown($sql, 'close_id', $close_id,  'class="txtbox"  style="width:120px;" alt="select" emsg="Please select closing ID "','--select--');
		?></td>
            <td class="tdData">&nbsp;</td>
            <td class="txtTotal">&nbsp;</td>
          </tr> 
         
          <tr>
            <td align="right" class="tdLabel">Grouth % : </td>
            <td><input name="payout_growth"style="width:120px;" type="text" value="<?=$payout_growth?>"  alt="blank" emsg="Please Enter growth %"/>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>-->
          <tr>
            <td align="right" class="tdLabel">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Submit" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
