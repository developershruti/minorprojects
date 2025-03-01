<?
require_once('../includes/surya.dream.php');
 $arr_error_msgs = array(); 
 $arr_success_msgs = array(); 
 

 /* $upvid_id = $_REQUEST['upvid_id'];
if($upvid_id!='') { 
	$sql = "select * from ngo_users_promo_video where upvid_id = '$upvid_id' and upvid_userid = '$_SESSION[sess_uid]'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
	  ///$line = ms_form_value($line_raw);
		@extract($line_raw);
	}
 } */ 
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
              <h4 class="mb-sm-0"> Bounty Request</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Social Bounty</a></li>
                  <li class="breadcrumb-item active">Bounty Request </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card newbordercolor">
              <div class="card-body">
                <form action="" method="get">
                   
                  <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead class="table-light">
                      <tr>
                        <th width="14%" class="text-uppercase">SL No.</th>
                         
                        <th width="14%" class="text-uppercase"> Post Type </th>
                         <th class="text-uppercase">Post URL</th>
                         <th class="text-uppercase" width="14%">Post  Date</th>
                        <th class="text-uppercase"> Status </th>
                      </tr>
                    </thead>
                    <tbody>
					
					<? 
 			$sql = "select * from ngo_users_promo_video where upvid_userid = '$_SESSION[sess_uid]' and upvid_status!='New' ";
			$result = db_query($sql);
  			if (mysqli_num_rows($result)>0){
			while ($line= mysqli_fetch_array($result)){;
 			@extract($line);
			$ctr++;
 			 ?>
                      <tr class="tdOdd">
                        <td><?=$ctr;?></td>
                         <td><?=$ARR_SOCIAL_REQUEST_TYPE[$upvid_type]?> </td>
                         <td><?=$upvid_post_url?></td>
                         
                        <td nowrap="nowrap"><?=datetime_format($upvid_datetime)?></td>
                        <td colspan="2">
						<? if($upvid_status=='New'){ ?>
 						<span class="badge bg-primary">Pending</span>
						<? } else if($upvid_status=='Approved'){ ?>
						<span class="badge bg-success">Approved</span>
						<? } else if($upvid_status=='Rejected'){ ?>
						<span class="badge bg-danger">Rejected</span>
						<? } ?>
						
						
						
						</td>
                      </tr>
					<? } ?>
					
					   <? } else {  ?>
					   
					   <? }    ?>  
                    </tbody>
                  </table>
                </form>
              </div>
            </div>
          </div>
          <!-- end col -->
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
