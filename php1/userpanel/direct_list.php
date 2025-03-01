<?php
include ("../includes/surya.dream.php");
protect_user_page();
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users ";
$sql .= " where 1 ";
//if ($id_in!='') { $sql .=" and  u_id in ($id_in)"; }
if ($userid!='') {$sql .=" and u_ref_userid ='$userid'";} else { $sql .=" and u_ref_userid ='$_SESSION[sess_uid]'";}  
if ($u_ref_side!='') { $sql .=" and  u_ref_side='$u_ref_side' "; } 

$sql_count = "select count(*) ".$sql; 
//$sql_count = "select count(*)  from ngo_users where  u_id in ($id_in)"; 
$reccnt = db_scalar($sql_count);
 //$sql = "select * from ngo_users where  u_id in ($id_in)   ";
if ($export=='1') { 
	$file_name=$_SESSION[sess_username].'_Direct_Referer_list.txt';
 	$arr_columns =array( 'u_username'=>'Username' ,'u_ref_side'=>'Side','u_fname'=>'First Name' ,'u_address'=>'Address','u_city'=>'City','u_date'=>'DOJ','u_panno'=>'Pan NO');
 	//export_delimited_file($sql, $arr_columns, $file_name, $arr_substitutes='', $arr_tpls='' );
	//exit;
}
 
$order_by == '' ? $order_by = 'u_id' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
//$sql .=" order by u_id desc limit $start, $pagesize  ";	
$result_gen = db_query($sql);
//$line_gen= mysqli_fetch_array($result_gen);
//@extract($line_gen);
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
              <h4 class="mb-sm-0">Referral Team</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Team Members </a></li>
                  <li class="breadcrumb-item active">Referral Team</li>
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
                <form action="" method="get">
                  <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead  >
                      <tr>
                        <th colspan="2"   >Records Per Page :
                          <?=pagesize_dropdown('pagesize', $pagesize);?></th>
                      </tr>
                    </thead>
                  </table>
                  <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead class="table-light">
                      <tr>
                        <th width="14%" class="text-uppercase">SL No.</th>
                        <th  width="14%" class="text-uppercase">User ID</th>
                        <th width="14%" class="text-uppercase" > Name</th>
                        
                        <!-- <td  >Mobile</td>-->
                        <th class="text-uppercase" >Mobile</th>
                        <th class="text-uppercase" >Email</th>
						<th class="text-uppercase" width="14%" >Joining  Date</th>
                        <th class="text-uppercase" ><!--Current Cycle--> Status </th>
                        <?php /*?> <th width="14%"  > Topup Date </th><?php */?>
                        <?php /*?> <th width="15%"  >  Status </th><?php */?>
                      </tr>
                    </thead>
                    <?
 		  /*	$sql_gen = "select * from ngo_users where  u_status='Active' ";
			if ($u_id!='') {  $sql_gen .= " and u_ref_userid='$u_id' "; }  else { $sql_gen .= " and u_ref_userid='$_SESSION[sess_uid]' "; }
			$sql_gen .=" order by u_id desc limit $start, $pagesize  ";	
  			 //print $sql_gen;
			$result_gen = db_query($sql_gen);*/
			$total_ref=mysqli_num_rows($result_gen);
			if ($total_ref>0){
			$ctr = $start;
			while ($line_gen= mysqli_fetch_array($result_gen)){;
			$ctr++;
			
 			$sql_topup= "select * from ngo_users_recharge where topup_userid='$line_gen[u_id]'  ";
			$res_topup= db_query($sql_topup);
			$row_topup= mysqli_fetch_array($res_topup);
  			$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                    <tbody>
                      <tr   class="<?=$css?>">
                        <td ><?=$ctr;?></td>
                        <td ><a href="direct_list.php?userid=<?=$line_gen['u_id'];?>"></a>
                          <?=$line_gen['u_username'];?>
                        </td>
                        <td ><?=$line_gen['u_fname']." ".$line_gen['u_lname'];?></td>
                       
                        <!--  <td ><?=$line_gen['u_mobile'];?></td>-->
                        <td ><?=$line_gen['u_mobile'];?> 
						
						
						</td>
                        <td nowrap="nowrap" > <?  if($line_gen['u_verify_email_status'] == 'Verified'){ ?><i class="ri-mail-check-fill text-success"></i>
						<? } else {  ?><i class="ri-mail-close-fill text-danger"></i>
						<? }   ?> <?=$line_gen['u_email'];?></td>
						 <td  nowrap="nowrap" ><?=date_format2($line_gen['u_date']);?></td>
                        <td  colspan="2"><? 
					  
					  
					  $unit_you = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_gen[u_id]' and topup_status='Paid'")+0;
						 //echo   binary_total_date($u_id_a ,"","")+0;
						 
						 
						 
						    ?>
                          <? if ($unit_you==0)  { ?>
                          <span class="badge bg-danger">Inactive</span>
                          <!-- <img src="assets/images/user_red_icon.png" align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_you['u_id']?>');" />-->
                          <? } else { ?>
                          <span class="badge bg-success">Active</span>
                          <!--<img src="assets/images/user_green_icon.png"   style="width:27px!important;" align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_you['u_id']?>');" />-->
                          <? }  ?>
                          <? ///  echo $row_topup[topup_amount]; ?></td>
                        <?php /*?><td ><?  echo date_format2($row_topup[topup_date]); ?></td><?php */?>
                        <?php /*?>  <td ><?  echo $row_topup[topup_status]; ?></td><?php */?>
                      </tr>
                      <? } } else {?>
                      <tr class="maintxt">
                        <td colspan="7"  class="error"  >No Member found </td>
                      </tr>
                      <? } ?>
                      <tr class="maintxt">
                        <td colspan="7"  class="error"  ><? include("paging.inc.php");?></td>
                      </tr>
                    </tbody>
                  </table>
                </form>
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
