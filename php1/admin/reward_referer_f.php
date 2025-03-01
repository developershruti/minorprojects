<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 protect_admin_page2();
if(is_post_back()) {
      //  check_userid, check_bank, check_amount, check_inword, check_date, check_status, check_rec_name, check_rec_date from  tm.ngo_cheque
//print_r($_POST);
 		 
 		if ($win_id!='') {
		 	$sql = "update ngo_rewards_winner set  win_rec_userid='$win_rec_userid' ,win_rec_name='$win_rec_name' ,win_rec_date='$win_rec_date'   ,win_rec_contact='$win_rec_contact'  where win_id='$win_id'";
			db_query($sql);
 		} else {
			//$sql = "insert into ngo_cheque set  check_userid='$check_userid',check_type='$check_type' ,check_bank='$check_bank' ,check_cheque_no='$check_cheque_no' ,check_amount='$check_amount' ,check_inword='$check_inword' , check_date='$check_date' , check_status='$check_status', check_rec_id='$check_rec_id', check_rec_name='$check_rec_name', check_rec_date='$check_rec_date',check_contact='$check_contact' ,check_remark='$check_remark'";
			//db_query($sql);
  		}
 	 header("Location: reward_referer.php");
	 exit();
	
	 
	 
	 
}

$sql = "select * from ngo_rewards_winner where   win_id='$win_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);

 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Reward referer Edit </div></td>
  </tr>
</table>
<div align="right"></div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="offer_id" value="<?=$offer_id?>"  />
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
    <tr>
      <td width="22%" height="10"></td>
      <td width="78%"></td>
    </tr>
    <tr>
      <td align="right"><strong>Reward  : </strong></td>
      <td class="tableDetails"><input name="win_reward_desc" type="text" id="win_reward_desc" value="<?=$win_reward_desc?>"   /></td>
    </tr>
	<tr>
      <td align="right"><strong>Amount  : </strong></td>
      <td class="tableDetails"><input name="win_rec_amount" type="text" id="win_rec_amount"  value="<?=$win_rec_amount?>"  /></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">Receiver User ID: </td>
      <td class="tableDetails"><input name="win_rec_userid" type="text" id="win_rec_userid" value="<?=$win_rec_userid?>" ></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">Receiver Name </td>
      <td class="tableDetails"><input name="win_rec_name" type="text" id="win_rec_name" value="<?=$win_rec_name?>" ></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">Receiver Mobile </td>
      <td class="tableDetails"><input name="win_rec_contact" type="text" id="win_rec_contact" value="<?=$win_rec_contact?>" ></td>
    </tr>
    <tr>
      <td align="right" class="tdLabel">Rec Date : </td>
      <td class="tableDetails"><?=get_date_picker("win_rec_date", $win_rec_date)?></td>
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