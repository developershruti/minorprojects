<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
if(is_post_back()) {
    
	 
	$sql_gen = "select * from ngo_users where 1";	
	$result_gen = db_query($sql_gen);
	while($line_gen = mysqli_fetch_array($result_gen)) { 
 	@extract($line_gen);
	
	
	//	$topup_userid = db_scalar("select u_id from ngo_users  where u_old_userid = '$u_userid'   ");
		$topup_userid = $u_id;
		$topup_count = db_scalar("select count(*) from ngo_users_recharge  where topup_userid = '$u_id' ");	
 
 		if ($topup_count==0  ) {
 
			$result_topup 	= db_query("select * from ngo_users_type  where utype_code = 'LINK1'");
			$line_topup  	= mysqli_fetch_array($result_topup);
			$topup_plan 	= $line_topup['utype_code']; 
			//$topup_days_for = $line_topup['utype_formula'] ;
			$topup_amount2 	= $line_topup['utype_value']  ;
			$topup_amount 	= $line_topup['utype_charges'] ;
  			 
  		$sql = "insert into  ngo_users_recharge set topup_userid = '$topup_userid' ,topup_by_userid='$topup_userid',topup_serialno='1', topup_code='$u_code', topup_plan='$topup_plan' ,topup_rate='$topup_rate' ,topup_amount='$topup_amount',topup_amount2='$topup_amount2',topup_date=ADDDATE(now(),INTERVAL 750 MINUTE)  ,topup_datetime=ADDDATE(now(),INTERVAL 750 MINUTE) ,topup_status='Unpaid' ";
		db_query($sql);
		
 		
			} 
			
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
      <td width="23%"  align="right"><strong>Payment Date  : </strong></td>
      <td width="77%"  class="tableDetails"><input name="pay_date" type="text" id="pay_date"  value="<?=$pay_date?>" /> 
        <span class="errorMsg">(Eg. yyyy-mm-dd)</span> </td>
    </tr>
	
    <tr>
      <td align="right" class="tdLabel"><strong> Select File Name: </strong></td>
      <td class="tableDetails"><input name="photo_image" type="file" id="photo_image" /></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
      <td class="tableDetails"><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
      <td class="tableDetails">&nbsp;</td>
    </tr>
  </table>
  <br />
  <br />
  </form>
<? include("bottom.inc.php");?>