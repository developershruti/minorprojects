<?
require_once('../includes/surya.dream.php');
 $arr_error_msgs = array(); 
if(is_post_back()) {
 
if ($upvid_title=='') { $arr_error_msgs[] = "Youtube Video Title is required!";}
if ($upvid_youtube_video_code=='') { $arr_error_msgs[] = "Youtube Video Code is required!";}
if ($upvid_youtube_video_total_view=='') { $arr_error_msgs[] = "Youtube Video Total View is required!";}
if ($upvid_youtube_channel_name=='') { $arr_error_msgs[] = "Youtube Channel Name is required!";}
if ($upvid_youtube_promoter_name=='') { $arr_error_msgs[] = "Promoter Name is required!";}
if ($upvid_youtube_promoter_contact=='') { $arr_error_msgs[] = "Promoter Contact No. is required!";}
   
 $_SESSION['arr_error_msgs'] = $arr_error_msgs;
		//check if there is no error
		
		if (count($arr_error_msgs) ==0) { 

	$upvid_title = ms_form_value($upvid_title);
	$upvid_youtube_video_code = ms_form_value($upvid_youtube_video_code);
	$upvid_youtube_video_total_view = ms_form_value($upvid_youtube_video_total_view);
	$upvid_youtube_channel_name = ms_form_value($upvid_youtube_channel_name);
	$upvid_youtube_promoter_name = ms_form_value($upvid_youtube_promoter_name);
	$upvid_youtube_promoter_contact = ms_form_value($upvid_youtube_promoter_contact);
	 
	
	
  	if($upvid_id!='') {
		$sql = "update ngo_users_promo_video set  upvid_userid = '$_SESSION[sess_uid]', upvid_title = '$upvid_title', upvid_youtube_video_code = '$upvid_youtube_video_code',upvid_youtube_video_total_view = '$upvid_youtube_video_total_view',upvid_youtube_channel_name = '$upvid_youtube_channel_name',upvid_youtube_promoter_name = '$upvid_youtube_promoter_name',upvid_youtube_promoter_contact = '$upvid_youtube_promoter_contact' , upvid_description = '$upvid_description' , upvid_status = 'Inactive'  where upvid_id = $upvid_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_users_promo_video set  upvid_userid = '$_SESSION[sess_uid]', upvid_title = '$upvid_title', upvid_youtube_video_code = '$upvid_youtube_video_code',upvid_youtube_video_total_view = '$upvid_youtube_video_total_view',upvid_youtube_channel_name = '$upvid_youtube_channel_name',upvid_youtube_promoter_name = '$upvid_youtube_promoter_name',upvid_youtube_promoter_contact = '$upvid_youtube_promoter_contact'  , upvid_description = '$upvid_description',upvid_datetime=now() ,upvid_status='Inactive'";
		db_query($sql);
 	}
	// $msg ="Your Video Added Successfully";
	$arr_error_msgs[] = "Your Video Added Successfully";
	$_SESSION['arr_error_msgs'] = $arr_error_msgs;
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
            <h1 class="dt-page__title" > Post Your Video </h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
           <div class="col-xl-2"></div>
            <div class="col-xl-8">
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0" >
                  <!-- Tables -->
                  <div class="table-responsive" style="padding:10px;">
                             <p style="color:#FF0000"><? include("error_msg.inc.php");?>  <? ///=$msg;?></p>
                                    <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?> class="forms-sample">
            <p > Youtube Video Title</p>
                                   <input name="upvid_title" type="text" id="upvid_title" value="<?=$upvid_title?>"  alt="blank" emsg="Please enter Video Title" placeholder='Video Title' class="form-control" required>
			  
				
				
				<br>

  <p > Youtube Video Code   :  Ex. https://www.youtube.com/watch?v=<span style="color:#FF0000;">abcdefghij</span> </p>
                                   <input name="upvid_youtube_video_code" type="text" id="upvid_youtube_video_code" value="<?=$upvid_youtube_video_code?>"  alt="blank" emsg="Please enter Video Code" placeholder='Video Code' class="form-control" required>
								  <p style="color:#CCCCCC"> (Enter above highlighted In Red Code of your video only)</p>
								   <br>

					<br>

  <p > Youtube Video Total View </p>
                                   <input name="upvid_youtube_video_total_view" type="text" id="upvid_youtube_video_total_view" value="<?=$upvid_youtube_video_total_view?>"  alt="blank" emsg="Please enter Video Total View " placeholder='Video Total View ' class="form-control" required>
								   <br>
								   
								   
	 <p > Youtube Channel Name</p>
                                   <input name="upvid_youtube_channel_name" type="text" id="upvid_youtube_channel_name" value="<?=$upvid_youtube_channel_name?>"  alt="blank" emsg="Please enter Youtube Channel Name " placeholder='Youtube Channel Name' class="form-control" required>
								   <br>								   
	 <p > Promoter Name </p>
                                   <input name="upvid_youtube_promoter_name" type="text" id="upvid_youtube_promoter_name" value="<?=$upvid_youtube_promoter_name?>"  alt="blank" emsg="Please enter Youtube Channel Name " placeholder='Youtube Channel Name' class="form-control" required>
								   <br>						
	 <p > Promoter Contact No. </p>
                                   <input name="upvid_youtube_promoter_contact" type="text" id="upvid_youtube_promoter_contact" value="<?=$upvid_youtube_promoter_contact?>"  alt="blank" emsg="Please enter Promoter Contact No." placeholder='Promoter Contact No.' class="form-control" required>
								   <br>					
                                      <p > Video Short Description  </p>
                                          <textarea name="upvid_description" cols="30" rows="4"  class="form-control" id="upvid_description" alt="blank" emsg="Please enter Your Feedback " required><?=$upvid_description?></textarea> 
                                        
                                         <input type="hidden" name="upvid_id" value="<?=$upvid_id?>"><br>

                                              
                                                            <button type="submit" class="btn btn-primary active" >Submit</button>
															
															 
                                                     
                                    </form>
                               
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
			       
  