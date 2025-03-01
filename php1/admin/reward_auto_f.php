<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
//  check_userid, check_bank, check_amount, check_inword, check_date, check_status, check_rec_name, check_rec_date from  
 //print_r($_POST);
	if ($check_userid1!='' && $check_userid2!='') {
	 $sql_test="select * from ngo_users ,ngo_reward_ref  where u_id=offer_userid and offer_total_ref>=11 and u_id >= $check_userid1 and u_id<=$check_userid2 ";
	$result_test = db_query($sql_test);
		if (mysqli_num_rows($result_test)>0) {
			$msg ='Qualified User id : ';
			while ($line_test= mysqli_fetch_array($result_test)){
			$check_userid = $line_test[u_id];
 			$check_type = 'REWARD';
 			$check_date = "ADDDATE('$line_test[u_date]',INTERVAL 0 DAY)";
			$check_remark = "total referer = $total_referer  post $line_test[u_utype_value]  ";
			
			$total_referer = db_scalar("select count(*) from ngo_users where u_ref_userid='$line_test[u_id]' and u_utype>=$line_test[u_utype]  ");
			// Post wise amount 
			$check_amount='';
			$check_inword='';
			if ($line_test[u_utype]==1 && $total_referer>=11) {
 				$check_amount = 3079;
				$check_inword =  convert_number($check_amount). " only" ;
			} else if ($line_test[u_utype]==2 && $total_referer>=11){
				$check_amount = 6158;
				$check_inword =  convert_number($check_amount). " only" ;
			}else if ($line_test[u_utype]==3 && $total_referer>=11){
				$check_amount = 11932;
				$check_inword =  convert_number($check_amount). " only" ;
			}else if ($line_test[u_utype]==4 && $total_referer>=11){
				$check_amount = 29248;
				$check_inword =  convert_number($check_amount). " only" ;
			}else if ($line_test[u_utype]==5 && $total_referer>=11){
				$check_amount = 49645;
				$check_inword =  convert_number($check_amount). " only" ;
			}else if ($line_test[u_utype]==6 && $total_referer>=11){
				$check_amount = 78544;
				$check_inword =  convert_number($check_amount). " only" ;
			}else if ($line_test[u_utype]==7 && $total_referer>=21){
				$check_amount = 33449;
				$check_inword =  convert_number($check_amount). " only" ;
			}else if ($line_test[u_utype]==8 && $total_referer>=21){
				$check_amount = 9828;
				$check_inword =  convert_number($check_amount). " only" ;
			}
			
 		$total_rec_cheque = db_scalar("select count(check_userid) from ngo_cheque where check_userid = '$check_userid' and check_amount='$check_amount' and check_type='$check_type'");
 			if ($total_rec_cheque==0 && $check_amount>0 && $total_referer>=11) {
		 	if ($Submit=='Generate All Qualified Users Cheque') {
		   	$sql = "insert into ngo_cheque set  check_userid='$check_userid',check_type='$check_type' ,check_bank='$check_bank'  ,check_amount='$check_amount' ,check_inword='$check_inword' ,check_cheque_no='$check_cheque_no', check_date=$check_date , check_remark='$check_remark' ";
			db_query($sql);
			} 
			$msg .= $check_userid.' ,';
			}
			}	 
		}
	}
}

$sql = "select * from ngo_cheque where  check_id ='$check_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);

if ($_POST[Submit_Convert]=='Convert In Word') { $check_inword = "" .convert_number($check_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">Auto Generated Reward Achiver Current Date Cheque </div></td>
  </tr>
</table>
<div align="right"><a href="cheque_list.php">Back to Bill List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="check_id" value="<?=$check_id?>"  />
  <table width="90%" height="200" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
    <tr>
      
      <td width="78%" colspan="2" class="errorMsg"><?=$msg?></td>
    </tr>
    <tr>
      <td align="right"><strong>User ID From /To: </strong></td>
      <td class="tableDetails"><input name="check_userid1" type="text" id="check_userid1" value="<?=$check_userid1?>" size="15" alt="blank" emsg="Please enter user id   from " />
        <input name="check_userid2" type="text" id="check_userid2" value="<?=$check_userid2?>" size="15" alt="blank" emsg="Please enter user id to" /></td>
    </tr>
    <tr>
      <td align="right" valign="top"><strong> Amount : </strong></td> 
      <td class="tableDetails">D=3079, BD=6158, SD=11932, GD=29248 , DD=49645, SrDD=78544, RD=33449 , RGD=9828 </td>
    </tr>
    <tr>
      <td align="right"><strong>Bank Name:</strong></td>
      <td class="tableDetails"><?=bank_dropdown('check_bank',$check_bank)?></td>
    </tr>
  <tr>
      <td align="right"><strong>Cheque Date :</strong></td>
      <td class="tableDetails">Current Date  </td>
    </tr>
    <tr>
      <td align="right"><strong>Cheque Type :</strong></td>
      <td class="tableDetails"> REWARD </td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">&nbsp;</td>
      <td class="tableDetails"><input type="submit" name="Submit" value="Generate All Qualified Users Cheque" />
        <input name="Submit" type="submit" id="Submit" value="No Show User ID Only" /></td>
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