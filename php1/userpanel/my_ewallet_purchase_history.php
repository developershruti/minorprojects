<?php
include ("../includes/surya.dream.php");
$pg='afterlogin';
protect_user_page();
 if(is_post_back()) {
	$arr_code_ids = $_REQUEST['arr_code_ids'];
	if(is_array($arr_code_ids)) {
		$str_code_ids = implode(',', $arr_code_ids);
		 if(isset($_REQUEST['Alocate']) || isset($_REQUEST['Alocate_x']) ) {
			$u_id = db_scalar("select  u_id from ngo_users where u_username = '$u_id'");
			$sql = "update ngo_code set code_transfer_userid = '$u_id'  where code_is='Available' and code_transfer_userid=0 and code_id in ($str_code_ids)";
			db_query($sql);
 		 }
}
}

#print_r($_SESSION);
$sql = "select *  from ngo_users_recharge inner join ngo_users on topup_userid=u_id  and topup_userid='$_SESSION[sess_uid]'    " ;
//" and code_transfer_userid=0 order by code_id desc";
#$result = db_query($sql);
 
/*if ($code_is!='') {$sql .= " and code_is='$code_is' ";}
if ($code_cate!='') {$sql .= " and code_cate='$code_cate' ";}
if ($code_transfer_userid!='') {$sql .= " and code_transfer_userid='$code_transfer_userid'";}
//if ($code_usefrom!='') {$sql .= " and  code_usefrom ='$code_usefrom' ";}

if (($code_usefrom!='') && ($code_useto!='')){ $sql .= " and code_usefrom between '$code_usefrom' AND '$code_useto' "; }
*/


$order_by == '' ? $order_by = 'topup_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql .= "order by $order_by $order_by2 ";
$result = db_query($sql);
 
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
              <h4 class="mb-sm-0">Purchased History </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Purchase Wallet</a></li>
                  <li class="breadcrumb-item active">Purchased History </li>
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
 
 
 
  
                  <p align="right" >
                    <? include("error_msg.inc.php");?>
                    <?=$msgs?>
                  </p>
                  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1"  class="table table-striped border-top table-hover mb-0  " >
                    <thead class="table-light">
                      <tr>
                        <th width="20%" align="center" style="text-align:center;">Purchase Date </th>
                        <!--<th width="20%" height="23" align="center" style="text-align:center;" >&nbsp;Ref No</th>-->
                        <th width="20%" height="23" align="center" style="text-align:center;" >&nbsp;Daily Income (%)</th>
                        <th width="20%" height="23" align="center" style="text-align:center;" >&nbsp;Upto Days (Mon-Sat) </th> 
                        <th width="20%" align="center" style="text-align:center;"> Package Amount </th> 
						<th width="20%" align="center" style="text-align:center;"> Status </th>
                      </tr>
                    </thead>
                    <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result)){ 
			$ctr++;
	 
			 $css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                    <tr class="<?=$css?>">	
                      <td align="center" nowrap="nowrap"  ><?=date_format2($line['topup_date']);?></td>
                      <?php /*?><td align="center" nowrap="nowrap"  ><? //=$_SESSION['sess_uid'];?> <?= $line['topup_serialno']; ?> </td><?php */?>
                   <td align="center" nowrap="nowrap"  > <?= $line['topup_rate']; ?>% </td>
                      <td align="center" nowrap="nowrap"  > <?= $line['topup_days_for']; ?> Working Days </td> 
                      <td align="center" nowrap="nowrap" ><?=price_format($line['topup_amount']);?> </td>
					  <td align="center" nowrap="nowrap" >
					  <? if($line['topup_status']=='Paid'){ ?> 
					  <span class="badge bg-danger">Active</span>
					  <? } else { ?>
					  <span class="badge bg-success">Inactive</span>
					  <? }  ?>
					  </td>
                    </tr>
                    <? } ?>
                    <? }  else { ?>
                    <tr   >
                      <td colspan="3" class="smalltxt" align="center" >Package details not found </td>
                    </tr>
                    <? } ?>
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
                