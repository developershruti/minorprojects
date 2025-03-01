<?php
include ("../includes/surya.dream.php");
protect_user_page();


/*
if ($_SESSION['sess_security_code2']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code_otp.php");
	 exit;
  }
 #print_r($_POST);
*/
if ($_SESSION['sess_security_code']=='') {
	$_SESSION['sess_back']=basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'];
	 header("location: security_code.php");
	 exit;
}
  
if(is_post_back()){
@extract($_POST);

$oldpassword = ms_form_value($oldpassword);
$newpassword = ms_form_value($newpassword);
$cnfpassword = ms_form_value($cnfpassword);

$query="select u_password2 from ngo_users where u_password2 = '$oldpassword' and u_id= '$_SESSION[sess_uid]'";
$chkpass = db_scalar($query);

if($chkpass==''){
	
	$msgs="Please enter correct old security password";

} else {
    
	if($cnfpassword != $newpassword){
		
		$msgs="Your confirm security password does not match with new security password";
		
		}else{  
			
		$query="update ngo_users set u_password2 = '$newpassword' where u_password2 = '$oldpassword' and u_id= '$_SESSION[sess_uid]'";       
		$res= db_query($query); 
		$msgs="You have succesfully changed your security password";

 		}
	
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
              <h4 class="mb-sm-0">Change Security Password </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Account Management</a></li>
                  <li class="breadcrumb-item active">Change Security Password </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
		 <? include("error_msg.inc.php");?>
          <div class="col-xxl-6 centered">
		  
            <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Change Security Password</h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 <div class="live-preview">
                     <p align="center" style="color:#0000000">
                      <? include("error_msg.inc.php");?>
                    </p>  
              <!-- Form -->   
            <form name="changepassword" method="post" action="<?=$_SERVER['PHP_SELF']?>"  class="forms-sample" enctype="multipart/form-data"  <?= validate_form()?>>
			      <div class="form-group">
                   
				   <label for="exampleInputUsername1">Old Security Password</label>
                  <input type="password" id="oldpassword" name="oldpassword" class="form-control" placeholder="Old Password"  alt="blank" emsg="Please enter old Security password"  />
                </div>

                <div class="form-group">
				<label for="exampleInputUsername1">New Security password</label>
                   
                 <input type="password" name="newpassword" id="newpassword"  class="form-control" alt="blank" emsg="Please enter new password" placeholder="New Security password"  />
                </div>
				

				<div class="form-group">
				<label for="exampleInputUsername1">Confirm Security password</label>
                   
                 <input type="password"   name="cnfpassword" id="cnfpassword"  class="form-control" placeholder="Confirm Password" alt="blank" emsg="Please enter Confirm  Security password"  />
                </div>
                    <!-- /form group -->


                    <!-- Form Group -->
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary text-uppercase">Submit
                        </button>
                       
                    </div>
                    <!-- /form group -->


                </form>
                <!-- /form -->

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
      