<?
require_once('../includes/surya.dream.php');
//print date(Ymdhms);
 
if(is_post_back()) {
 //print_r($_POST);
@extract($_POST);

#   bill_id, bill_date, bill_userid, bill_taxable, bill_tax_rate, bill_note, bill_prod1, bill_prodqty1, 
#	bill_prodrate1, bill_prodamt1, bill_prod2, bill_prodqty2, bill_prodrate2, bill_prodamt2, 
#	bill_prodtax from eversmiletm_online.ngo_bill
	 
	$bill_userid = db_scalar("select  u_id from ngo_users where u_username = '$u_ref_userid'");
	
	
		if ($bill_tax_rate!='' && $bill_prodamt2!='') { $bill_prodtax =round((($bill_prodamt2*$bill_tax_rate)/100),0);}
 		$bill_amount = $bill_prodamt1+$bill_prodamt2+$bill_prodtax;
		$bill_amt_inword = "Rs. " .convert_number($bill_amount). " only" ;
		if ($bill_id!='') {
		  	$sql = "update ngo_bill set  bill_date='$bill_date',bill_taxable='$bill_taxable',bill_tax_rate='$bill_tax_rate',bill_note='$bill_note', bill_userid='$bill_userid', bill_topupid='$bill_topupid', bill_prod1='$bill_prod1', bill_prodqty1='$bill_prodqty1', bill_prodrate1='$bill_prodrate1',bill_prodamt1='$bill_prodamt1', bill_prod2='$bill_prod2' , bill_prodqty2='$bill_prodqty2', bill_prodrate2='$bill_prodrate2',bill_prodamt2='$bill_prodamt2' ,bill_prodtax='$bill_prodtax' ,bill_amount='$bill_amount' ,bill_amt_inword='$bill_amt_inword' where bill_id='$bill_id'";
			db_query($sql);
 		} else {
			$sql = "insert into ngo_bill set  bill_date='$bill_date',bill_taxable='$bill_taxable',bill_tax_rate='$bill_tax_rate',bill_note='$bill_note', bill_userid='$bill_userid', bill_topupid='$bill_topupid', bill_prod1='$bill_prod1', bill_prodqty1='$bill_prodqty1', bill_prodrate1='$bill_prodrate1',bill_prodamt1='$bill_prodamt1', bill_prod2='$bill_prod2' , bill_prodqty2='$bill_prodqty2', bill_prodrate2='$bill_prodrate2',bill_prodamt2='$bill_prodamt2' ,bill_prodtax='$bill_prodtax' ,bill_amount='$bill_amount' ,bill_amt_inword='$bill_amt_inword' ";
			db_query($sql);
			$bill_id = mysqli_insert_id();
 		}
		header("Location: bill_list.php");
		exit;
 }



$sql = "select * from ngo_bill where  bill_id ='$bill_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);


?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<?php include("../includes/fvalidate.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Create/Update Bill </div></td>
  </tr>
</table>
<div align="right"><a href="bill_list.php">Back to Bill       List</a>&nbsp;</div>
<form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
<input type="hidden" name="bill_id" value="<?=$bill_id?>"  />
  <table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="tableSearch">
    <tr>
      <td width="49%"><table width="95%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
        <tr>
          <td class="tableDetails"><span class="headSection">To</span> (The Name and address of purchaser if available in case of local sale but compulsorily in case of center sale) </td>
        </tr>
        <tr>
          <td valign="top" class="tableDetails"><span style="padding:2px">
            <?
		//$sql ="select u_id , u_id from ngo_users where u_status='Active' order by  u_id desc";  
		//echo make_dropdown($sql, 'bill_userid', $bill_userid,  'class="txtbox"  style="width:120px;"','--Select User ID --');
		?>
            <input name="bill_userid" type="text" id="bill_userid"  value="<?=$bill_userid?>"  alt="blank" emsg="Please enter user id"/>
          </span></td>
        </tr>
        <tr>
          <td class="tableDetails"> Topup/Recharge ID : <input name="bill_topupid" type="text" id="bill_topupid"  value="<?=$bill_topupid?>"  alt="blank" emsg="Please enter topup/recharge id"/></td>
        </tr>
      </table>
        <br /></td>
      <td width="51%" valign="top"><table width="95%" border="0" align="center" cellpadding="4" cellspacing="0" class="tableSearch">
        
        <tr>
          <td width="48%" align="right" class="tableDetails"><span class="headSection">Bill Number(Auto Generated):</span></td>
          <td width="52%" align="left" class="tableDetails"><input name="bill_id" type="text" id="bill_id"  value="<?=$bill_id?>" disabled="disabled"/></td>
        </tr>
        <tr>
          <td align="right" class="tableDetails"><span class="headSection">Date:</span></td>
          <td align="left" class="tableDetails"> <?=get_date_picker("bill_date", $bill_date)?>
           </td>
        </tr>
        <tr>
          <td align="right" class="headSection">Taxable/Non Taxable </td>
          <td align="left" class="tableDetails"><?=taxable_dropdown('bill_taxable',$bill_taxable)?> </td>
        </tr>
        <tr>
          <td align="right" class="headSection">Tax Rate: </td>
          <td align="left" class="tableDetails"><?=traxrate_dropdown('bill_tax_rate',$bill_tax_rate)?></td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td colspan="2"> 
        <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" class="tableSearch">
        <tr>
          <td width="47%" height="20" class="headSection">Description of goods </td>
          <td width="13%" class="headSection">Quantity</td>
          <td width="16%" class="headSection">Unity Price or Rate </td>
          <td width="16%" class="headSection">Total Amount </td>
        </tr>
         <tr>
          <td><input name="bill_prod1" type="text"  size="30" value="<?=$bill_prod1?>"/></td>
          <td><input name="bill_prodqty1" type="text" size="15" value="<?=$bill_prodqty1?>"/></td>
          <td><input name="bill_prodrate1" type="text"  size="15" value="<?=$bill_prodrate1?>"/></td>
          <td><input name="bill_prodamt1" type="text"   size="15" value="<?=$bill_prodamt1?>"/></td>
        </tr>
        <tr>
          <td><input name="bill_prod2" type="text"  size="30" value="<?=$bill_prod2?>"/></td>
          <td><input name="bill_prodqty2" type="text" size="15" value="<?=$bill_prodqty2?>"/></td>
          <td><input name="bill_prodrate2" type="text"  size="15" value="<?=$bill_prodrate2?>"/></td>
          <td><input name="bill_prodamt2" type="text"   size="15" value="<?=$bill_prodamt2?>"/></td>
        </tr>
        <tr>
          <td class="headSection">&nbsp;</td>
          <td>&nbsp;</td>
          <td><span class="headSection">Tax</span></td>
          <td><input name="bill_prodtax" type="text"   size="15" value="<?=$bill_prodtax?>"/></td>
        </tr>
        <tr>
          <td class="headSection">&nbsp;</td>
          <td>&nbsp;</td>
          <td><span class="headSection">Total Amount </span></td>
          <td><span class="tableDetails">
             <?=$bill_prodtax+$bill_prodamt1+$bill_prodamt2?>
          </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
          <br /></td>
      </tr>
    <tr>
      <td valign="top">&nbsp;&nbsp;This is computerised generated invoice. </td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="49%">&nbsp;</td>
      <td width="51%"><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
  </table>
  <br />
  </form>
<? include("bottom.inc.php");?>