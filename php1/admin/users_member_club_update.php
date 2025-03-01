<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 
	if(is_post_back()) {
		$data=array();
if($level==1){ 	
	$sql_test = "select u_ref_userid ,count(*) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='35' group by u_ref_userid having count(*)>=4 ";
} else if($level==2){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_1) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='35' group by u_ref_userid having sum(member_on_level_1)>=16";
} else if($level==3){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_2) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='35' group by u_ref_userid having sum(member_on_level_2)>=64";
} else if($level==4){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_3) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='35' group by u_ref_userid having sum(member_on_level_3)>=256";
} else if($level==5){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_4) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='35' group by u_ref_userid having sum(member_on_level_4)>=1024";
} else if($level==6){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_5) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='35' group by u_ref_userid having sum(member_on_level_5)>=4096";
} else if($level==7){ 	
	$sql_test = "select u_ref_userid ,sum(member_on_level_6) as total_count from ngo_users, ngo_users_recharge where u_id=topup_userid and topup_amount='35' group by u_ref_userid having sum(member_on_level_6)>=16384";
}
		
		
		
		$result_test = db_query($sql_test);
		while ($line_test= mysqli_fetch_array($result_test)){
			@extract($line_test);
			 print "<br> ====> $u_ref_userid | $total_count";
			$data[$u_ref_userid] =  $total_count ;
			// db_query("update ngo_users set  member_on_level_4='$total_count'   where u_id='$u_userid' ");
		}
		
		//print_r($data);
		
		
		foreach($data as $u_ref_userid => $total_count) {
			//db_query("update ngo_users set  member_on_level_4='$total_count'   where u_id='$u_ref_userid' ");
if($level==1){ 	
	db_query("update ngo_users set  member_on_level_1='$total_count'   where u_id='$u_ref_userid' ");
 } else if($level==2){ 	
	db_query("update ngo_users set  member_on_level_2='$total_count'   where u_id='$u_ref_userid' ");
 } else if($level==3){ 	
	db_query("update ngo_users set  member_on_level_3='$total_count'   where u_id='$u_ref_userid' ");
} else if($level==4){ 	
	db_query("update ngo_users set  member_on_level_4='$total_count'   where u_id='$u_ref_userid' ");
} else if($level==5){ 	
	db_query("update ngo_users set  member_on_level_5='$total_count'   where u_id='$u_ref_userid' ");
} else if($level==6){ 	
	db_query("update ngo_users set  member_on_level_6='$total_count'   where u_id='$u_ref_userid' ");
} else if($level==7){ 	
	db_query("update ngo_users set  member_on_level_7='$total_count'   where u_id='$u_ref_userid' ");
}
echo " <br>$level ========> Ref ID : $u_ref_userid | Count : $total_count ";

			//echo "$u_ref_userid = $total_count<br>";
 		}
	
	}
 

//if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "Rs. " .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Import Payout </div></td>
  </tr>
</table>
 <form name="form1" method="post" enctype="multipart/form-data" <?= validate_form()?>>
   <table width="90%"  border="0" align="center" cellpadding="5" cellspacing="1" class="tableSearch">
    <tr>
       
      <td  colspan="2" class="errorMsg"><?=$msg?></td>
    </tr>
    <tr>
      <td width="23%"  align="right"><strong>Club Level : </strong></td>
      <td><?=array_dropdown($ARR_CLUB_LEVEL, $level, 'level');?> <?php /*?>Qualified Users List<?php */?></td>
    </tr>
  
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
     <td valign="middle">  
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
    </tr>
  </table>
  <br />
  <br />
  </form>
<? include("bottom.inc.php");?>