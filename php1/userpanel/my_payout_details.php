<?php
include ("../includes/surya.dream.php");
protect_user_page();
 ///and pay_status='Unpaid'
// if ($pay_plan=='') { $pay_plan ='DIRECT';}
/*$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$sql = " select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr   from ngo_users_payment inner join ngo_users on pay_userid=u_id   and pay_userid='$_SESSION[sess_uid]'  " ;
//if ($topup_id!='') {$sql_part .= " and pay_topupid='$topup_id' ";}
if ($pay_plan!='') {$sql_part .= " and pay_plan='$pay_plan' ";}
if (($datefrom!='') && ($dateto!='')){ $sql_part .= " and pay_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}

$order_by == '' ? $order_by = 'pay_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql .= $sql_part . "  order by $order_by $order_by2 ";
$result = db_query($sql);

*/ 

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr ";
$sql = " from ngo_users_payment inner join ngo_users on pay_userid=u_id and pay_userid='$_SESSION[sess_uid]'  "; // and pay_group='$pay_group'
//AND pay_group='$pay_group' AND pay_group='$pay_group' and pay_status='Paid'
if ($pay_for!='') {$sql .= " and pay_for='$pay_for' ";}
if ($pay_plan!='') {$sql .= " and pay_plan='$pay_plan' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}
if ($pay_for!='') {$sql_part .= " and pay_for='$pay_for' ";}
$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

 


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
<head>
<? include("includes/extra_head.php")?>
</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
  <? include("includes/header.inc.php")?>
  <!-- ========== App Menu ========== -->
  <? include("includes/sidebar.php")?>
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0">
                <?=$ARR_PAYMENT_TYPE[$pay_plan];?> History
                <? ///=$_GET['pay_plan']?>
              </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);"><? if($pay_plan=='FUND_WITHDRAW'){ ?>Withdraw <? } else {  ?> Earnings <? } ?></a></li>
                  <li class="breadcrumb-item active">
                    <?=$ARR_PAYMENT_TYPE[$pay_plan];?>
                    Details </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <!--end row-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card newbordercolor">
              <div class="card-body">
                <? include("error_msg.inc.php");?>
                
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2"  class="td_box">
                  <tr>
                    <td  valign="top" height="250"><!--main  content table start -->
                      <? /*if ($topup_id='') { echo ' <div align="left" class="subtitle">Topup Ref No :'.$topup_id;} */?>
                      <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
					  <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead  >
                      <tr>
                        <th colspan="2"   >Records Per Page :
                          <?=pagesize_dropdown('pagesize', $pagesize);?></th>
                      </tr>
                    </thead>
                  </table>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  >
                          <tr valign="top" >
                            <td  align="center"><br>
                              <table width="100%" border="0" cellpadding="1" cellspacing="2" class="table table-striped">
                                <thead class="table-light">
                                  <tr>
                                    <!-- <td width="12%" height="20" align="left" valign="top" class="tdhead"><strong>TR No. </strong></td>
                     <td width="10%" height="23">Pay No. </td>-->
                                    <th width="10%" align="left" valign="top" > Dated </th>
                                    <th width="40%" align="left" valign="top" > &nbsp;Transaction Description </th>
                                    <? if($pay_plan=='FUND_WITHDRAW') { ?>
                                    <th width="30%" align="left" valign="top"  > Txn Details </th>
                                    <? } ?>
                                     <th width="10%" align="left" valign="top"  > Status </th>
                                    <!-- <td width="54%" align="left" valign="top" ><strong>&nbsp;Business Used </strong></td>-->
                                    <th width="10%" align="left" valign="top"  > &nbsp;Amount </th>
                                  </tr>
                                </thead>
                                <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result)){;
			$ctr++;
 			if ($line['pay_drcr']=='Dr') { $amount =$line['Dr']; } 
			else if($line['pay_drcr']=='Cr') { $amount =$line['Cr']; } 
 			 $total_cr +=$amount;
			 $total_ref +=$line['pay_ref_amt'];
			
 			 $css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                                <tr class="<?=$css?>">
                                  <!-- <td height="18" align="left" valign="top" ><? //=$line['pay_id']?></td>-->
                                  <td align="left" valign="top" nowrap="nowrap">
								  <? if($pay_plan=='DAILY_WINING_PROFITS'){ ?>
								  <?=datetime_format($line['pay_datetime']); ?>
								  <? } else { ?>
								  <?=date_format2($line['pay_date']); ?>
								  <? } ?>
								  </td>
                                  <td align="left" valign="top" nowrap="nowrap"><?=$line['pay_for']; ?></td>
                                  <? if($pay_plan=='FUND_WITHDRAW') { ?>
                                  <td align="left" valign="top"><?=$line['pay_transaction_no']; ?></td>
                                  <? } ?>
                                  <td align="left" valign="top"><? if($line['pay_status']=='Paid') { ?><span class="badge bg-success"><?=$line['pay_status'];?></span><? } else if($pay_plan=='FUND_WITHDRAW') {  ?><span class="badge bg-danger">InProcess</span> <? } ?></td>
                                  <!-- <td align="left" valign="top"><?=price_format($line['pay_ref_amt']);?> </td>-->
                                  <td align="left" valign="top"><?=price_format($amount);?>
                                  </td>
                                </tr>
                                <? } ?>
                                <tr   >
                                  <td   align="right" valign="top" class="td_box"></td>
                                  <td  align="right" valign="top" class="td_box">&nbsp;</td>
                                  <td  align="right" valign="top" class="td_box" <? if($pay_plan=='FUND_WITHDRAW') {  ?> colspan="2" <? } ?>><strong>Total Amount : </strong></td>
                                  <td  align="left" valign="top" class="td_box"><strong>
                                    <?=price_format($total_cr);?>
                                    </strong></td>
                                </tr>
                                <? }  else { ?>
                                <tr class="maintxt">
                                  <td colspan="5" class="smalltxt" align="center" >Transaction details not found </td>
                                </tr>
                                <? } ?>
                                <tr>
                                  <td valign="top"   align="center" colspan="5"><? include("paging.inc.php");?></td>
                                </tr>
                              </table>
                              <br>
                              <br>
                            </td>
                          </tr>
                        </table>
                      </form>
                      <!--main content table end -->
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <!--end col-->
        </div>
        <!--end row-->
      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <? include("includes/footer.php")?>
  </div>
  <!-- end main content-->
</div>
<!-- END layout-wrapper -->
<? include("includes/extra_footer.php")?>
</body>
</html>
