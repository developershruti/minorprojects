<?php
include ("../includes/surya.dream.php");
protect_user_page();
 /*
$sql = "select *  from ngo_users_payment inner join ngo_users on pay_userid=u_id  and pay_userid='$_SESSION[sess_uid]'" ;
// and pay_status='Unpaid' 
if ($topup_id!='') {$sql .= " and pay_topupid='$topup_id' ";}

$order_by == '' ? $order_by = 'pay_date' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
$sql .= "order by $order_by $order_by2 ";
$result = db_query($sql);
*/
 
?>
 
  <!DOCTYPE html>
<html lang="en">
<head>
<? include("includes/extra_head.php")?>
<? include ("../includes/fvalidate.inc.php"); ?>
 </head>
<body class="dt-layout--default dt-sidebar--fixed dt-header--fixed">
<!-- Loader -->
<?  include("includes/loader.php")?>
<!-- /loader -->
<!-- Root -->
<div class="dt-root">
  <div class="dt-root__inner">
    <!-- Header -->
    <? include("includes/header.inc.php")?>
    <!-- /header -->
    <!-- Site Main -->
    <main class="dt-main">
      <!-- Sidebar -->
      <? include("includes/sidebar.php")?>
      <!-- /sidebar -->
      <!-- Site Content Wrapper -->
      <div class="dt-content-wrapper">
        <!-- Site Content -->
        <div class="dt-content">
          <!-- Page Header -->
          <div class="dt-page__header " style="    border-bottom: 1px solid #ddd;">
            <h1 class="dt-page__title">RIP Transfer     </h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
          
            <div class="col-xl-12">
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0" >
                  <!-- Tables -->
                  <div class="table-responsive" style="padding:10px;">
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p> 
  
  
                      
   
      <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0"  >
         
        <tr>
          <td align="center" valign="top"> 
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-striped"   >
            
           
           <!-- <tr>
              <td colspan="4" class="title">  </td>
            </tr>-->
            <?  ?>
               <thead>
              <tr>
                 <th width="145" class="subtitle">  Description</th>
                   <th width="50" class="subtitle"> Credit </th>
				    <th width="50" class="subtitle"> Debit </th>
					 <th width="50" class="subtitle">  Balance</th> 
					 <?php /*?><th width="154" class="subtitle">  Transfer In Shopping Wallet</th> 
           <th width="100" class="subtitle"> Buy Token</th> 
					  <th width="100" class="subtitle">  Transfer In  Coin Wallet</th> <?php */?>
            <th width="100" class="subtitle">  Transfer In Cash Wallet</th> 
					 <!-- <th width="100" class="subtitle">  Transfer to Flexi Wallet</th>-->
          <th width="100" class="subtitle">  Fund Withdraw</th> 
           <th width="100" class="subtitle">  View Statement</th>
              </tr>
			  </thead>
<?
 
foreach ($ARR_PAYMENT_GROUP as $key=>$value){
if ($key!='') {
  $upay_amount =0;
  $upay_amount_paid=0;

  $sql_hc="SELECT SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit,SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit, (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_group='$key' ";
  $result_hc=db_query($sql_hc);
  $row_hc=mysqli_fetch_array($result_hc);

  $upay_amount = $row_hc['credit'];
  $upay_amount_paid =$row_hc['debit'];
  $upay_amount_balance =$row_hc['balance'];

  $total_amount+= $upay_amount;
  $total_amount_paid+= $upay_amount_paid;

  
	 
?>


                <tr >
                 <td class="maintxt" nowrap="nowrap" style="text-align:left"><b><?=$value?></b></td>
                  <!-- <td class="td_box"><a href="my_incentive_daily_list.php?pay_for=<?=$value?>">Rs.<?=$upay_amount+0?> </a></td>-->
				   <td class="td_box" nowrap> <?=price_format($upay_amount)?> </td>
				   <td class="td_box" nowrap><?=price_format($upay_amount_paid)?></td>
				   <td class="td_box" nowrap><?=price_format($upay_amount-$upay_amount_paid)?></td>
				   <?php /*?> <td class=" "  nowrap="nowrap"   ><a href="my_fund_transfer_ewallet.php?pay_group=<?=$key?>&pay_group2=SW" class="site-btn transition-ease hero" style="color:#000000"> Shopping Wallet</a></td>
					  <td  nowrap="nowrap" style="text-align:center"   ><a href="my_fund_transfer_coin.php?pay_group=<?=$key?>&pay_group2=CW"  class="btn btn-primary btn-sm mr-2 mb-2"> Buy Token</a></td> 
             <td class=" "  nowrap="nowrap" style="text-align:center"   ><a href="my_token_buy?pay_group=<?=$key?>" class="btn btn-primary mb-2" >Buy Token</a></td><?php */?>
					<!--<td  nowrap="nowrap" style="text-align:center"   ><a href="my_fund_transfer_ewallet.php?pay_group=<?=$key?>&pay_group2=RW&rule=WI"  class="btn btn-primary btn-sm mr-2 mb-2"> Transfer in RIP Wallet</a></td>-->
          <td  nowrap="nowrap" style="text-align:center"   ><a href="my_fund_transfer_ewallet.php?pay_group=<?=$key?>&pay_group2=CW&rule=WI"  class="btn btn-primary btn-sm mr-2 mb-2"> Transfer in Cash Wallet</a></td>
          <!--   <td  nowrap="nowrap" style="text-align:center"   ><a href="my_fund_transfer_ewallet.php?pay_group=<?=$key?>&pay_group2=FW"  class="btn btn-primary btn-sm mr-2 mb-2"> Transfer in Flexi Wallet</a></td>-->
					 <td  nowrap="nowrap" style="text-align:center"   ><a href="my_ebank_fund_withdraw.php?pay_group=<?=$key?>&rule=WI"  class="btn btn-primary btn-sm mr-2 mb-2">Fund Withdraw</a></td> 
           <td class=" "  nowrap="nowrap" style="text-align:center"   ><a href="my_incentive_statement.php?pay_group=<?=$key?>&rule=WI" class="btn btn-primary mb-2" > View Statement</a></td>
              </tr>
              <?  }  ?>
 <?		 
 
 }
?>
             
             <tr>
                 <td class=" "><strong>Total Amount</strong></td>
                   <td class="td_box"> <strong><?=price_format($total_amount)?></strong></td>
				    <td class="td_box"> <strong><?=price_format($total_amount_paid)?></strong></td>
					 <td class="td_box"> <strong><?=price_format($total_amount-$total_amount_paid)?></strong></td>
					 <td class="td_box" colspan="3">  </td>
              </tr> 
				 
				 
            <? //} 
				 
				 
				 ?>
          </table>
          <br />
		   <? if ($topup_id!='') { echo ' <div align="left" class="subtitle">Topup Ref No :'.$topup_id;}?>
          <br /></td></tr>
         
      </table>
   </div>
                  <!-- /tables -->
                </div>
                <!-- /card body -->
              </div>
              <!-- /card -->
            </div>
            <!-- /grid item -->
          </div>
          <!-- /grid -->
        </div>
        <!-- Footer -->
        <? include("includes/footer.php")?>
        <!-- /footer -->
      </div>
      <!-- /site content wrapper -->
      <!-- Theme Chooser -->
      <!-- /theme chooser -->
      <!-- Customizer Sidebar -->
      <!-- /customizer sidebar -->
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
<? include("includes/extra_footer.php")?>
</body>
</html>
