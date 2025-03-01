<?php
include ("../includes/surya.dream.php");
protect_user_page();
 
  
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select u_username,u_fname ,u_city,u_id,u_ref_userid,u_bank_register,ngo_coinpayment.*  ";
$sql = " from ngo_users,ngo_coinpayment where  u_id=pay_userid and u_status='Active' and u_id='$_SESSION[sess_uid]'";
if ($pay_plan!='') 		{$sql .= " and pay_plan='$pay_plan' ";} 
if ($pay_status!='') 	{$sql .= " and pay_status='$pay_status' ";}
if ($pay_group!='') 		{$sql .= " and pay_group='$pay_group' ";}
  
$sql_export = $sql ."  order by pay_userid asc "; 
$sql_export_total = $sql ." group by pay_userid  order by pay_userid asc"; 
$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";
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
              <h4 class="mb-sm-0">USDT Deposit</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">My Wallet</a></li>
                  <li class="breadcrumb-item active">USDT Deposit </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <!--end row-->
       <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
			  
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p>  
                    <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
                      <table width="90%" border="0"   class="table table-bordered">
                        <thead>
                          <tr>
                            <!--<th width="4%" class="tdhead" >Pay ID </th>
			
            <th width="4%" >Group</th>
            <th width="4%" >Ref Amt 1</th>
            <th width="4%" >Ref Amt 2 </th>
            <th width="3%" >Rate</th>-->
                            <th width="6%"  class="tdhead" nowrap="nowrap">Payment Date </th>
                            <th width="7%"  class="tdhead" nowrap="nowrap">Amount </th>
                            <th width="3%"  class="tdhead" nowrap="nowrap">Txn ID</th>
                            <th width="3%" class="tdhead" nowrap="nowrap">Txn Date</th>
                            <th width="4%"  class="tdhead" nowrap="nowrap">Status </th>
                           <!-- <th width="4%"  class="tdhead" nowrap="nowrap">Status Details</th>-->
                          </tr>
                        </thead>
                        <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';

 ?>
                        <tr class="<?=$css?>">
                          <td nowrap="nowrap"><?=date_format2($pay_date)?></td>
                          <!-- 
		     <td nowrap="nowrap"><?=$pay_id?></td>
		   <td nowrap="nowrap"><?=$pay_group?></td>
            <td nowrap="nowrap"><?=$pay_currency1?> <?=($pay_ref_amt1)?></td>
            <td nowrap="nowrap"><?=$pay_currency2?> <?=($pay_ref_amt2)?></td>
            <td nowrap="nowrap"><?=$pay_rate?> </td>-->
                          <td nowrap="nowrap"><?=price_format($pay_amount)?></td>
                          <td nowrap="nowrap"><?=$pay_trnid?></td>
                          <td nowrap="nowrap"><?=date_format2($pay_txn_date)?></td>
                          <td align="center"><?=$pay_status?>
                          </td>
                         <!-- <td align="center"><?=$pay_status_text?>
                          </td>-->
                        </tr>
                        <? }



?>
                      </table>
                    </form>
                    <? include("paging.inc.php");?>
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