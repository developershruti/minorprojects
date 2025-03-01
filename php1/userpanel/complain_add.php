<?
require_once('../includes/surya.dream.php');
if(is_post_back()) {
 

$comp_title = ms_form_value($comp_title);
$comp_desc = ms_form_value($comp_desc);
 

	if($comp_id!='') {
		$sql = "update ngo_complain set  comp_userid = '$_SESSION[sess_uid]', comp_title = '$comp_title', comp_desc = '$comp_desc'  where comp_id = $comp_id";
		db_query($sql);
	} else{
		$sql = "insert into ngo_complain set  comp_userid = '$_SESSION[sess_uid]', comp_title = '$comp_title' , comp_date = now() , comp_desc = '$comp_desc',comp_datetime=now() ";
		db_query($sql);
 



$message="
 
Complain for- ". $comp_title ."

Complain from- ".$_SESSION[sess_username]."  

Complain  desc- ". $comp_desc."  
 
The ". SITE_NAME ."  team ";
 
 			$EMAIL_ADDRESS = ADMIN_EMAIL;
			//$EMAIL_ADDRESS = "surya.dream@gmail.com";
			$HEADERS  = "MIME-Version: 1.0 \n";
			$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
			$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
			$SUBJECT  = "support ticket posted on ". SITE_NAME;
 			@mail($EMAIL_ADDRESS, $SUBJECT, $message,$HEADERS);


$message="
 

Dear ". $u_username .",

Thanks for informing us your problem. The support staffs will attend the complain soon.

Please send your feed back always for the continuous monitoring and updation of the process.


Regards

". SITE_NAME ."  team 

  ";
		$EMAILL_REC= $_SESSION['sess_uemail'];
		if ($EMAILL_REC!='') {
			$HEADERS  = "MIME-Version: 1.0 \n";
			$HEADERS .= "Content-type: text/plain; charset=iso-8859-1 \n";
			$HEADERS .= "From:  <".ADMIN_EMAIL.">\n";
			$SUBJECT  = "Thanks for submit a support ticket";
			@mail($EMAILL_REC, $SUBJECT, $message,$HEADERS);
		}
	}
	$msg ="Complain sent successfully.";
	header("Location: complain.php");
	exit;
}

$comp_id = $_REQUEST['comp_id'];
if($comp_id!='') {
	$sql = "select * from ngo_complain where comp_id = '$comp_id'";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_array($result)) {
		//$line = ms_form_value($line_raw);
		@extract($line_raw);
	}
}
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
              <h4 class="mb-sm-0">Create Ticket </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Support Ticket  </a></li>
                  <li class="breadcrumb-item active">Create Ticket </li>
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
                <h4 class="card-title mb-0 flex-grow-1">Create Support Request</h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 
                <div class="live-preview">
 
 
  
                    <p align="center" style="color:#0000000">
                      <? include("error_msg.inc.php");?>
                    </p>  
   

                <!-- Form -->  <p align="center" style="color:#FF0000"> <? include("error_msg.inc.php");?>   <?=$msgs?> </p> 
  
  
    
                               
                                    <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?> class="forms-sample">
                                     
									   
										 
										 
                                       <p > Subject : </p>
                                   <input name="comp_title" type="text" id="comp_title" value="<?=$comp_title?>"  alt="blank" emsg="Please enter Subject Line" class="form-control" required>
                                        </tr>
                                       <!-- <tr>
                                          <td width="180" align="left" class="tdLabel">Complain  Date </td>
                                          <td width="486" class="tdData"><input name="comp_date" type="text" id="comp_date" value="<?=$comp_date?>"  alt="blank" emsg="Please enter complain date" />
                                          yyyy-mm-dd </td>
                                        </tr>-->

                                        <p class="form-label" > Message : </p>
                                          <textarea name="comp_desc" cols="30" rows="4"  class="form-control" id="comp_desc" alt="blank" emsg="Please enter complain description" required><?=$comp_desc?></textarea> 
                                        
                                         <input type="hidden" name="comp_id" value="<?=$comp_id?>">

                                              
                                                            <button type="submit" class="btn btn-primary active mt-2" >Submit</button>
															
															 
                                                     
                                    </form>
                               
  </div>
                 
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
         