<?
require_once('../includes/surya.dream.php');
protect_admin_page2();
//print date(Ymdhms);
 
if(is_post_back()) {
      //  select `pdist_id`, `pdist_userid`, `pdist_date`, `pdist_rec_id`, `pdist_rec_name`, `pdist_rec_date`, `pdist_contact`, `pdist_product`, `pdist_remark`, `pdist_status` from `eversmiletm`.`ngo_proudct_dist`
//print_r($_POST);
 		if ($_POST[Submit_Convert]!='Convert In Word') { 
		if ($pdist_rec_name=='') { $pdist_rec_name= db_scalar("select u_fname from ngo_users where u_id='$pdist_rec_id' ");}
		
		$pdist_userid = db_scalar("select u_id from ngo_users where u_username = '$pdist_userid'");
		$pdist_rec_id = db_scalar("select u_id from ngo_users where u_username = '$pdist_rec_id'");
		
 		if ($pdist_id!='') {
 		//,pdist_rec_name='$pdist_rec_name' ,pdist_rec_date='$pdist_rec_date' ,pdist_contact='$pdist_contact' , pdist_product='$pdist_product'
			$sql = "update ngo_proudct_dist set  pdist_userid='$pdist_userid' ,pdist_date='$pdist_date', pdist_rec_id='$pdist_rec_id', pdist_rec_name='$pdist_rec_name',pdist_rec_date='$pdist_rec_date' ,pdist_contact='$pdist_contact',pdist_product='$pdist_product' , pdist_remark='$pdist_remark', pdist_status='$pdist_status' where pdist_id='$pdist_id'";
			db_query($sql);
 		} else {
 			$sql = "insert into ngo_proudct_dist set   pdist_userid='$pdist_userid' ,pdist_date='$pdist_date', pdist_rec_id='$pdist_rec_id', pdist_rec_name='$pdist_rec_name',pdist_rec_date='$pdist_rec_date' ,pdist_contact='$pdist_contact',pdist_product='$pdist_product' , pdist_remark='$pdist_remark', pdist_status='$pdist_status'";
			db_query($sql);
  		}
 	header("Location: product_dist_list.php");
	exit;
	
	 
	 
	}
}
if ($pdist_id!='') {
	$sql = "select * from ngo_proudct_dist where  pdist_id ='$pdist_id'";
	$result = db_query($sql);
	$line= mysqli_fetch_array($result);
	@extract($line);
	$pdist_userid = db_scalar("select u_username from ngo_users where u_id = '$pdist_userid'");
	$pdist_rec_id = db_scalar("select u_username from ngo_users where u_id = '$pdist_rec_id'");

}
if ($_POST[Submit_Convert]=='Convert In Word') { $pdist_inword = "Rs. " .convert_number($pdist_amount). " only" ; } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead"> Add / Update Product </div></td>
  </tr>
</table>
<div align="right"><a href="cheque_list.php">Back to Bill List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="pdist_id" value="<?=$pdist_id?>"  />
  <table width="90%" height="200" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
    <tr>
      <td width="22%" height="10"></td>
      <td width="78%"></td>
    </tr>
    <tr>
      <td align="right"><strong>User ID : </strong></td>
      <td class="tableDetails"><input name="pdist_userid" type="text" id="pdist_userid" value="<?=$pdist_userid?>" alt="blank" emsg="Please enter user id " /></td>
    </tr>
    <tr>
      <td align="right" valign="top"><strong> Product : </strong></td>
      <td class="tableDetails"><textarea name="pdist_product" cols="40" rows="3" id="pdist_product" alt="blank" emsg="Please enter Product "><?=$pdist_product?></textarea></td>
    </tr>
  <!--<tr>
      <td align="right"><strong>Distribution  Date :</strong></td>
      <td class="tableDetails"> <? //=get_date_picker("pdist_date", $pdist_date)?>       </td>
    </tr>-->
    <tr>
      <td align="right"><strong>Receiver ID/ Name : </strong></td>
      <td class="tableDetails"><input name="pdist_rec_id" type="text" id="pdist_rec_id"  value="<?=$pdist_rec_id?>" size="10" />
      <input name="pdist_rec_name" type="text" id="pdist_rec_name"  value="<?=$pdist_rec_name?>" /></td>
    </tr>
     <tr>
      <td align="right"><strong>Receive Date : </strong></td>
      <td class="tableDetails"> 
	  <!--<input name="pdist_rec_date" type="text" id="pdist_rec_date"  value="<?=$pdist_rec_date?>" />-->
        <?=get_date_picker("pdist_rec_date", $pdist_rec_date)?>       </td>
    </tr>
	<tr>
      <td align="right"><strong>Contact Number: </strong></td>
      <td class="tableDetails"> 
	  <input name="pdist_contact" type="text" id="pdist_contact"  value="<?=$pdist_contact?>" />       </td>
    </tr>
	<tr>
	  <td align="right"><strong>Status: </strong></td>
	  <td class="tableDetails"><?=checkstatus_dropdown('pdist_status',$pdist_status)?></td>
	  </tr>
	<tr>
      <td align="right"><strong>Remark: </strong></td>
      <td class="tableDetails"> 
	  <textarea name="pdist_remark" cols="50" rows="5" id="pdist_remark"><?=$pdist_remark?></textarea>       </td>
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