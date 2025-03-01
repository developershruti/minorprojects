<?
require_once('../includes/surya.dream.php');
 $arr_error_msgs = array(); 
 $arr_success_msgs = array(); 
if(is_post_back()) {
 
if ($upvid_type=='') { $arr_error_msgs[] = "Youtube Video Title is required!";}
if ($upvid_post_url=='') { $arr_error_msgs[] = "Youtube Video Code is required!";}


$pending_count = db_scalar("select count(*) from ngo_users_promo_video where upvid_post_url = '$upvid_post_url' and upvid_status!='Rejected' ")+0;
if ($pending_count>0) { $arr_error_msgs[] = "This Post URL has already been submitted";}


$pending_count = db_scalar("select count(*) from ngo_users_promo_video where upvid_userid = '$_SESSION[sess_uid]' and upvid_type = '$upvid_type' and upvid_status='New' ")+0;
if ($pending_count>0) { $arr_error_msgs[] = "It looks like a request has already been submitted for this post. Please wait until it is processed. ";}

$_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//check if there is no error
		
 if (count($arr_error_msgs) ==0) { 
 	$upvid_type = ms_form_value($upvid_type);
	$upvid_post_url = ms_form_value($upvid_post_url);
   	
	
	/*if($upvid_id!='') {
		$sql = "update ngo_users_promo_video set  upvid_userid = '$_SESSION[sess_uid]', upvid_title = '$upvid_title', upvid_youtube_video_code = '$upvid_youtube_video_code',upvid_youtube_video_total_view = '$upvid_youtube_video_total_view',upvid_youtube_channel_name = '$upvid_youtube_channel_name',upvid_youtube_promoter_name = '$upvid_youtube_promoter_name',upvid_youtube_promoter_contact = '$upvid_youtube_promoter_contact' , upvid_description = '$upvid_description' , upvid_status = 'Inactive'  where upvid_id = $upvid_id";
		db_query($sql);
	} else{*/
		$sql = "insert into ngo_users_promo_video set  upvid_userid = '$_SESSION[sess_uid]', upvid_type = '$upvid_type', upvid_post_url = '$upvid_post_url',upvid_promoter_name = '$_SESSION[sess_fname]', upvid_status = 'New', upvid_datetime=ADDDATE(now(),INTERVAL 0 MINUTE) ";
		db_query($sql);
 	/*}*/
	// $msg ="Your Video Added Successfully";
	$arr_success_msgs[] = "Your request submitted successfully";
	$_SESSION['arr_success_msgs'] = $arr_success_msgs;
	/* header("Location: added_videos.php");
	 exit; */
 }


 }

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
          <? include("error_msg.inc.php");?>
          <div class="col-xxl-6 centered">
            <div class="card newbordercolor">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"> Bounty Request</h4>
              </div>
              <!-- end card header -->
              <div class="card-body">
                <div class="live-preview">
                  <!-- Form -->
                  <p style="color:#FF0000">
                    <? include("error_msg.inc.php");?>
                    <? ///=$msg;?>
                  </p>
                  <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?> class="forms-sample">
                    <p> Post Type :</p>
                    <? echo array_dropdown($ARR_SOCIAL_REQUEST_TYPE, $upvid_type, 'upvid_type',' style="width:100%;" class="form-control" alt="select" emsg="Please Select Post Type"  required');
 //=join_mode_dropdown('u_join_mode',$u_join_mode,'alt="select" emsg="Please select Account Type"')?> <br>
                    <p> Post URL :</p>
                    <input name="upvid_post_url" type="text" id="upvid_post_url" value="<?=$upvid_post_url?>" alt="blank" emsg="Please enter Post URL " placeholder='Enter Post URL Ex : https://xxxxxxx.xxx' class="form-control"  required>
                    <input type="hidden" name="upvid_id" value="<?=$upvid_id?>">
                    <br>
                    <button type="submit" class="btn btn-primary active" >Submit</button>
                  </form>
                  <!-- /form -->
                </div>
              </div>
            </div>
          </div>
        </div>
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
 			$sql = "select * from ngo_users_promo_video where upvid_userid = '$_SESSION[sess_uid]' and upvid_status='New' ";
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
