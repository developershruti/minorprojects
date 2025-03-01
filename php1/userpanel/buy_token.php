<?php
include ("../includes/surya.dream.php");
protect_user_page();

  
 
//  $SITE_CSS = $_SESSION[sess_css];

?>
  <!DOCTYPE html>
<html lang="en">
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
          <div class="profile">
            <!-- Profile Banner -->
            <div class="profile__banner">
              <!-- Profile Banner Top -->
              <div class="profile__banner-detail">
                <!-- Avatar Wrapper -->
                <div class="dt-avatar-wrapper">
                  <!-- Avatar -->
                  <?
									  // print UP_FILES_FS_PATH.'/profile/'.$u_photo ;
								  if (($u_photo!='')&& (file_exists(UP_FILES_FS_PATH.'/profile/'.$u_photo))) { 
								 
								  ?>
											     <img src="<?=UP_FILES_WS_PATH.'/profile/'.$u_photo?>"   class="dt-avatar dt-avatar__shadow size-90 mr-sm-4">	<!--<img src="<?=show_thumb(UP_FILES_WS_PATH.'/profile/'.$u_photo,100,150,'resize')?>" align="center" />-->
												<? }  else { ?>
												<img src="images/no_pic.png"  align="center"    class="dt-avatar dt-avatar__shadow size-90 mr-sm-4" width=""/>
												<? }  ?> 
                  <!-- /avatar -->
                  <!-- Info -->
                  <div class="dt-avatar-info"> <span class="dt-avatar-name display-4 mb-2 font-weight-light"><?=$u_fname?></span> <span class="f-16"><?=$u_email?></span> </div>
                  <!-- /info -->
                </div>
                <!-- /avatar wrapper -->
                 
              </div>
              <!-- /profile banner top -->
              <!-- Profile Banner Bottom -->
               
              <!-- /profile banner bottom -->
            </div>
            <!-- /profile banner -->
            <!-- Profile Content -->
            <div class="profile-content">
              <!-- Grid -->
              <div class="row">
                <!-- Grid Item -->
                <div class="col-xl-4 order-xl-2">
                  <!-- Grid -->
                  <div class="row">

                  
                    <!-- Grid Item -->
                     
                    <!-- /grid item -->
                    <!-- Grid Item -->
                    <div class="col-xl-12 col-md-6 col-12 order-xl-1">
                      <!-- Card -->
                      <div class="dt-card dt-card__full-height">
                        <!-- Card Header -->
                         
                        <!-- /card header -->
                        <!-- Card Body -->
                        <? /// include("includes/right.php")?>
						
						<div class="dt-card__body">
						 <div class="dt-card__heading">
                            <h3 class="dt-card__title"> E-WALLET BALANCE : <?  
					 $acc_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' AND pay_group='$pay_group' and pay_status='Paid' ") ;
					// echo round($acc_balance); AND pay_group='$pay_group'
					echo price_format($acc_balance); 
					 ?></h3>
                          </div>
 					       
						 
						   
 					      <div class="media"> <br>
<br>

                            <!-- Media Body --> 
                              <table width="150px;" style="margin-top:25px; " class="table table-striped table-bordered table-advance table-hover">
                                   <thead><tr>
								   			<th>Token Details</th>
								   </tr>
								   </thead>
 								   
								    <tbody>
									<tr>
                                        <td align="left" style="text-align:left;">Token Name&nbsp;&nbsp;&nbsp;:  Rest In Piece </td>
 										</tr>
                                     <tr>
                                        <td  align="left" style="text-align:left;">Token Symbol : RIP </td>
										</tr>
										
                                     <?php /*?><tr>
                                        <td  align="left" style="text-align:left;">Total Supply&nbsp;&nbsp;&nbsp;:  20,000,000 EPT</td>
										</tr><?php */?> 
                                    
                                </tbody></table> 
                            <!-- /media body -->
                          </div>
						  
						  
						   
                       
					   
					   
					   
                        </div>
						
                        <!-- /card body -->
                      </div>
                      <!-- /card -->
                    </div>
                    <!-- /grid item -->
                  </div>
                  <!-- /grid -->
                </div>
                <!-- /grid item -->
                <!-- Grid Item -->
                <div class="col-xl-8 order-xl-1">
                  <!-- Card -->
                  <div class="card">
                    <!-- Card Header -->
                    <div class="card-header card-nav bg-transparent border-bottom d-sm-flex justify-content-sm-between">
                      <h3 class="mb-2 mb-sm-n5">BUY RIP TOKEN </h3>
                       
                    </div>
                    <!-- /card header -->
                    <!-- Card Body -->
                     <div class="dt-card__body">

                <!-- Form -->  <p align="center" style="color:#FF0000"> <? include("error_msg.inc.php");?>   <?=$msgs?> </p>
            <form method="post" name="form" id="contactform"  action="#" class="forms-sample"  enctype="multipart/form-data"  <?= validate_form()?>>
			
			<div class="form-group"> <span for="exampleInputUsername1">Amount (RIP)</span>
                  <input name="creq_amount" type="text" class="form-control" id="creq_amount"  value="<?=$creq_amount?>" alt="number" placeholder="Amount (RIP)" required/>
                </div>
			      <div class="form-group"> <span for="exampleInputUsername1">Price</span>
                  <input name="creq_bank" type="text"  class="form-control" id="creq_bank"  value="<?=$creq_bank?>" alt="blank" placeholder="Price" required/>
                </div>
                <div class="form-group"> <span for="exampleInputUsername1">Net Amount</span>
                  <input name="creq_bank_acc" type="text" class="form-control" id="creq_bank_acc"  value="<?=$creq_bank_acc?>" alt="blank" placeholder="Net Amount" required/>
                </div>
                
                    <!-- /form group -->

                    <!-- Form Group -->
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary text-uppercase">Coming Soon </button>
                       
                    </div>
                    <!-- /form group -->


                </form>
                <!-- /form -->

            </div>
                    <!-- /card body -->
                  </div>
                  <!-- /card -->
                  <!-- Card -->
                   
                  <!-- /card -->
                  <!-- Card -->
                   
                  <!-- /card -->
                </div>
                <!-- /grid item -->
              </div>
              <!-- /grid -->
            </div>
            <!-- /profile content -->
          </div>
        </div>
        <!-- Footer -->
        
        <!-- /footer --> <? include("includes/footer.php")?>
      </div>
      
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
 
<!-- /contact user information -->
<!-- masonry script -->

 <? include("includes/extra_footer.php")?>
</body>
 
</html>

			