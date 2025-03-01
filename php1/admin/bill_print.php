<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
print_r($_SESSION);
//$sql  = "select u_id, u_fname ,u_lname ,u_address ,u_phone from ngo_users_payout ,ngo_users where ngo_users_payout.upay_userid=ngo_users.u_id group by u_id, upay_for order by u_id asc limit 0, 20 "; 
if ($_SESSION[str_bill_ids]=='') { $_SESSION[str_bill_ids]=0; }
$sql = " select * from ngo_bill ,ngo_users  where ngo_bill.bill_userid=ngo_users.u_id and  bill_id in ($_SESSION[str_bill_ids])";
$result = db_query($sql);


?>
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<style type="text/css">
<!--
.style2 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
.style5 {font-size: 12px; font-family: Arial, Helvetica, sans-serif;}
.tableBorder { border: 1px solid #666666; } 
-->
 </style>
<link href="styles.css" rel="stylesheet" type="text/css">
<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"  >
  <?
 while ($line_raw = mysqli_fetch_array($result)) {
	 @extract($line_raw);
 ?>
  <tr>
    <td><table width="800" border="0" align="left" cellpadding="2" cellspacing="3" class="tableBorder">
        <tr>
          <td colspan="2" align="center" class="style2" >Retail Invoice/Cash Memo </td>
        </tr>
        <tr>
          <td colspan="2" align="center" class="style2" >	 <!--	  EVER SMILE TRADEX MARKETING PVT. LTD<span class="headSection"><br />
		 80-A, Ist Floor Main Road, Radhey Puri Extn.<br />
		  Krishna Nagar, Opp. - Karkardooma Court, Delhi - 110051<br />
          </span>--><?
				$sql_comp = "select * from ngo_company ";
 				$result_comp = db_query($sql_comp);
				$line_comp= mysqli_fetch_array($result_comp);
				?>
            <div align="center" class="style2"> <strong>
              <?=$line_comp['comp_name']?>
            </strong> </div>
            <div align="center" class="tableDetails">
              <?=nl2br($line_comp['comp_address'])?>
            </div>
			<div align="center" class="tableDetails">
			  <?//=$line_comp['comp_regno']?>
			  Tin No:<?=$line_comp['comp_tinno'] ?> </div>           </td>
        </tr>
        <tr>
          <td width="47%" ><table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="style2">To,</td>
              </tr>
              <tr>
                <td width="91%" class="tableSearch"><span class="style2">
                  <?=$u_fname ." ".$u_lname?>
                  (User ID :
                  <?=$u_id?>
                  ) </span></td>
              </tr>
              <tr>
                <td class="tableSearch"><span class="style2">
                  <?=$u_address?>
                  </span></td>
              </tr>
              <tr>
                <td class="tableSearch"><span class="style2">
                  <?=$u_city.",".$u_state?>
                  </span></td>
              </tr>
              <tr>
                <td class="tableSearch"><span class="style2">
                  <?=$u_zip?>
                &nbsp; </span></td>
              </tr>
            </table></td>
          <td width="53%" valign="top" ><table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td colspan="2" align="right" class="style2">&nbsp;</td>
              </tr>
              <tr>
                <td width="33%" align="right" class="tableSearch"><strong>Bill Number&nbsp;: </strong>&nbsp; </td>
                <td width="67%" class="tableSearch"><?=$bill_id?>                </td>
              </tr>
              <tr>
                <td align="right" class="tableSearch"><strong>Bill Date&nbsp;:</strong> &nbsp; </td>
                <td class="tableSearch"><?= date_format2($bill_date)?>                </td>
              </tr>
              <tr>
                <td align="right" class="tableSearch">&nbsp;</td>
                <td class="tableSearch"><?=$bill_note?>
                  &nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="style5">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2" ><table width="100%" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="57%" class="tableList"><strong>Description</strong></td>
                <td width="14%" class="tableList"><strong>QTY </strong></td>
                <td width="13%" class="tableList"><strong>Rate</strong></td>
                <td width="16%" class="tableList"><strong>Amount</strong></td>
              </tr>
              <tr>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prod1?>
                  </span></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prodqty1?>
                  </span></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prodrate1?>
                  </span></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prodamt1?>
                  </span></td>
              </tr>
              <tr>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prod2?>
                  </span></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prodqty2?>
                  </span></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prodrate2?>
                  </span></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prodamt2?>
                  </span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="tableSearch"><? if ($bill_tax_rate!='') { echo 'Tax@ '.round($bill_tax_rate,2).'%';}?></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_prodtax?>
                  </span></td>
              </tr>
              <tr>
                <td align="right"><?=$bill_amt_inword?></td>
                <td>&nbsp;</td>
                <td class="tableSearch"><strong>Total : </strong></td>
                <td class="tableSearch"><span class="style5">
                  <?=$bill_amount?>
                  </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="1" colspan="2" align="right" ><table width="300" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td><span class="headSection">For <strong>
              <?=$line_comp['comp_name']?>
              </strong></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="headSection">Authorised Signatory</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="1" colspan="2" align="left" >This is computerised generated invoice. </td>
        </tr>
    </table></td>
  </tr>
   <tr>
    <td  height="100"  > </td>
  </tr>
  
   
  <? } ?>
</table>
