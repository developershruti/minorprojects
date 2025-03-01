<?
include ("../includes/surya.dream.php"); 
 if(is_post_back()) {
     	$sql = "select * from ngo_users where  u_password2 = '$u_password2' and u_id='$_SESSION[sess_uid]'  ";
    
	$result = db_query($sql);
	if ($line= mysqli_fetch_array($result)) {
		@extract($line);
 			$_SESSION['sess_security_code'] = $u_password2;
   			if ($_SESSION['sess_back']!='') {
			 	header("location: ".$_SESSION['sess_back']);
				$_SESSION['sess_back']='';	
				exit;	
			} else {
 				 header("location: myaccount.php");
				 exit;	
 			}
  }else {
  $msgs="You have entered wrong security password.";
  
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
              <h4 class="mb-sm-0">Security Password</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Account Control</a></li>
                  <li class="breadcrumb-item active">Security Password</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
		 <? // include("error_msg.inc.php");?>
          <div class="col-xxl-6 centered">
		  
            <div class="card newbordercolor">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Enter Security Password</h4>
                 
              </div>
              <!-- end card header -->
              <div class="card-body">
                 
                <div class="live-preview">
 
 
  
                    <p align="center" style="color:#0000000">
                      <? include("error_msg.inc.php");?>
                    </p> 
  
    
			<!-- id="form2"--> <p align="center" style="color:#FF0000"> <? // include("error_msg.inc.php");?>   <? //=$msgs?> </p> 
			 <form name="form2" method="post"   id="contactform" class="send-form-style2 send-form-style"  enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
			 
			  <div class="form-group">
			   <label for="exampleInputUsername1">Security Password</label>
                   
                   <input name="u_password2" type="password"  class="form-control"  id="u_password2" size="30" alt="blank" emsg="Please Enter Security Password" />
                </div>
				<br>

				 <div class="form-group mb-0">
                       
                        <input name="Submit2" type="submit"   class="btn btn-primary text-uppercase" value="Submit" />
                    </div>
			
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
