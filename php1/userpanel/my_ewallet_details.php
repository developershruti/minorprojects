<?php
include ("includes/surya.dream.php");
protect_user_page();
 ///and pay_status='Unpaid'
 if ($pay_plan=='') { $pay_plan ='DIRECT';}
$sql = " select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr  from ngo_users_ewallet inner join ngo_users on pay_userid=u_id   and pay_userid='$_SESSION[sess_uid]'  " ;
//if ($topup_id!='') {$sql_part .= " and pay_topupid='$topup_id' ";}
if ($pay_plan!='') {$sql_part .= " and pay_plan='$pay_plan' ";}
if (($datefrom!='') && ($dateto!='')){ $sql_part .= " and pay_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}

$order_by == '' ? $order_by = 'pay_date' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
 $sql .= $sql_part . "  order by $order_by $order_by2 ";
$result = db_query($sql);
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?=$META_TITLE?>
</title>
<meta name="keywords" content="<?=$META_KEYWORD?>">
<meta name="description" content="<?=$META_DESC?>" />
<LINK REL="SHORTCUT ICON" HREF="<?=SITE_WS_PATH?>/images/ngo_icon.ico">
<link href="<?=SITE_WS_PATH?>/stylesheet/vergemenu.css" rel="stylesheet" type="text/css">
<link href="<?=SITE_WS_PATH?>/stylesheet/style.css" rel="stylesheet" type="text/css" />
<link href="stylesheet/style.css" rel="stylesheet" type="text/css" />
<link href="<?=SITE_WS_PATH?>/stylesheet/dropdown.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?=SITE_WS_PATH?>/stylesheet/libcss/default.advanced.css" media="all" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/js/jquery/jquery.dropdown.js"></script>
<![endif]-->
<script language="JavaScript" type="text/javascript" src="includes/general.js"></script>
</head>
<body >
<table width="1004" border="0" align="center" cellpadding="0" cellspacing="0" class="main_table">
  <tr>
    <td align="center" ><? include("includes/header.inc.php")?>
    </td>
  </tr>
  <tr>
    <td  align="center" class="maintxt"  ><table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td class="title">&nbsp; Ewallet Account Statement </td>
        </tr>
       
        <tr>
          <td  class="gray_box" >
            <!--main table start-->
   <br />

       
		
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2"   >
          <tr>
            <td    align="center" valign="top" >
      <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2"    >
          <tr>
          <td align="center" valign="top"><form action="" method="get" name="search" id="search">
            <table width="67%" border="0" cellpadding="2" cellspacing="2" class="white_box">
              <tr>
                <td colspan="2" class="subtitle">&nbsp;Search by Date </td>
              </tr>
              <tr>
                <td width="151" align="left">Payment  Date From/To : </td>
                <td width="308" align="left"> 
                  <?=get_date_picker("datefrom", $datefrom)?>
                 
                  <?=get_date_picker("dateto", $dateto)?>                 </td>
              </tr>
              <?  ?>
              <tr>
                <td align="left">&nbsp;</td>
                <td align="left"><!--<a href="payreport.php?payoutno=<?=$payoutno?>" target="_blank">Pay Report </a>-->
                    <input type="hidden" name="pay_plan" value="<?=$pay_plan?>" />
					<input type="submit" name="Submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;"  /></td>
              </tr>
            </table>
          </form></td>
          </tr>
        <tr>
		<td width="82%" align="right" valign="top"> 
            <!--main  content table start -->
            
              <? if ($topup_id!='') { echo ' <div align="left" class="subtitle">Topup Ref No :'.$topup_id;}?>
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"class ="white_box" >
               
              <tr>
                <td height="400" valign="top"><br />
<form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
                  
                  <table width="98%" align="center" border="0" cellpadding="2" cellspacing="2"  class="td_box" >
                      <tr class="tdhead">
                         <!--<td width="12%" height="20" align="left" valign="top"><strong>TR No. </strong></td>
                          <td width="10%" height="23">Pay No. </td>-->
                        <td width="14%" align="left" valign="top"><strong> Dated </strong></td>
                          <td width="54%" align="left" valign="top"><strong>&nbsp;Naration</strong></td>
                          <td width="20%" align="left" valign="top"><strong>&nbsp;Amount</strong></td>
                          </tr>
                    <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result)){;
			$ctr++;
 			if ($line['pay_drcr']=='Dr') { $amount =$line['Dr']; } 
			else if($line['pay_drcr']=='Cr') { $amount =$line['Cr']; } 
 			 $total_cr +=$amount;
			
 			$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                    <tr class="<?=$css?>">
                       <!-- <td align="left" valign="top" height="18"><? //=$line['pay_id']?></td>-->
                         <td align="left" valign="top"><?=date_format2($line['pay_date']); ?></td>
                        <td align="left" valign="top"><?=$line['pay_for']; ?></td>
                        <td align="left" valign="top"><?=price_format($amount);?> </td>
                        </tr>
                    <? } ?>
                    <tr class="maintxt">
                      <td colspan="3" class="smalltxt" align="right" ><table width="350" border="0" align="right">
                        <tr>
                          <td width="206" align="right" valign="top">Total Payout :</td>
                          <td width="134" align="left" valign="top"><strong>
                            <?=price_format($total_cr);?>
                          </strong></td>
                        </tr>
                      </table></td>
                    </tr>
                    
                    <? }  else { ?>
                   
                    <tr class="maintxt">
                      <td colspan="7" class="smalltxt" align="center" >Transaction   details not found </td>
                        </tr>
                    <? } ?>
                    <tr>
                      <td valign="top"   align="center" colspan="6"><? include("paging.inc.php");?></td>
                        </tr>
                    </table>
                  </form><br />
</td>
                </tr>
              </table>
              <!--main content table end -->          </td>
          </tr>
        </table>
		</td></tr>
	  </table>
      <!--main table end -->
      
		 	
			
			</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td  align="center" valign="top" ><? include("includes/footer.inc.php")?>
    </td>
</table>
</body>
</html>
