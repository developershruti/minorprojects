<?php
include ("../includes/surya.dream.php");
protect_user_page();

if(is_post_back()) {
 
	@extract($_POST);
	if ($creq_receipt_del !='') {
		@unlink(UP_FILES_FS_PATH.'/receipt/'.$old_creq_receipt);
		$update_creq_receipt = ", creq_receipt=''";
	}


if($_FILES['creq_receipt']['name']!='') {
$name = $_FILES["creq_receipt"]["name"];
$ext = end((explode(".", $name))); # extra () to prevent notice
///exit;


/*if($ext!="jpg" || $ext!="jpeg" || $ext!="png" || $ext!="pdf") {
 	$msgs="Only you can upload .jpg, .jpeg, .pdf and .png file.";
 } */
 
 } 
/*echo $ext;
exit;
	*/
	
	if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='pdf'){
 	if($_FILES['creq_receipt']['name']!='') {
		$creq_receipt_name = str_replace('.'.file_ext($_FILES['creq_receipt']['name']),'',$_FILES['creq_receipt']['name']).'_'.md5(uniqid(rand(), true)).'.'.file_ext($_FILES['creq_receipt']['name']);
		 copy($_FILES['creq_receipt']['tmp_name'], UP_FILES_FS_PATH.'/receipt/'.$creq_receipt_name);
		 $update_creq_receipt = ", creq_receipt='$creq_receipt_name'";
	}
	 
	
  		if ($creq_id!='') {
			$sql = "update ngo_deposit_req set  creq_userid='$_SESSION[sess_uid]' , creq_bank_acc='$creq_bank_acc' ,creq_date=now(),creq_bank='$creq_bank' ,creq_bank_date='$creq_bank_date' ,creq_amount='$creq_amount'  , creq_remark='$creq_remark' $update_creq_receipt   where creq_id='$creq_id'  ";
			db_query($sql);
 		} else {
			$sql = "insert into ngo_deposit_req set   creq_userid='$_SESSION[sess_uid]' , creq_bank_acc='$creq_bank_acc' ,creq_date=now(),creq_bank='$creq_bank' ,creq_bank_date='$creq_bank_date' ,creq_amount='$creq_amount' , creq_remark='$creq_remark' $update_creq_receipt  ";
			db_query($sql);
			   
  		}
 	header("Location: deposit_request_list.php");
	exit;
	
	} else {
	$msgs="Only you can upload .jpg, .jpeg, .pdf and .png file.";
	
	 } 
 
}

$sql = "select * from ngo_deposit_req where  creq_id ='$creq_id'";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);

 
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
                        <div class="dt-card__header pt-6">
                          <!-- Card Heading -->
                          <div class="dt-card__heading">
                            <h3 class="dt-card__title">DEPOSIT REQUEST</h3>
                          </div>
                          <!-- /card heading -->
                        </div>
                        <!-- /card header -->
                        <!-- Card Body -->
                        <? include("includes/right.php")?>
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
                      <h3 class="mb-2 mb-sm-n5">DEPOSIT REQUEST  </h3>
                       
                    </div>
                    <!-- /card header -->
                    <!-- Card Body -->
                     <div class="dt-card__body">

                <!-- Form -->  <p align="center" style="color:#FF0000"> <? include("error_msg.inc.php");?>   <?=$msgs?> </p>
            <form method="post" name="form" id="contactform"  class="forms-sample"  enctype="multipart/form-data"  <?= validate_form()?>>
			      <div class="form-group"> <span for="exampleInputUsername1">Receiving Company</span>
                  <input name="creq_bank" type="text"  class="form-control" id="creq_bank"  value="<?=$creq_bank?>" alt="blank" placeholder="Receiving Company" required/>
                </div>
                <div class="form-group"> <span for="exampleInputUsername1">Receiving Address</span>
                  <input name="creq_bank_acc" type="text" class="form-control" id="creq_bank_acc"  value="<?=$creq_bank_acc?>" alt="blank" placeholder="Receiving Address" required/>
                </div>
                <div class="form-group"> <span for="exampleInputUsername1">Deposit Date (yyyy-mm-dd)</span>
                  <? //=get_date_picker("creq_bank_date", $creq_bank_date)?>
                  <input name="creq_bank_date" type="date"  class="form-control" id="creq_bank_date"  value="<?=$creq_bank_date?>"  placeholder="Deposit Date (yyyy-mm-dd)" required/>
                </div>
                <div class="form-group"> <span for="exampleInputUsername1">Deposit Amount</span>
                  <input name="creq_amount" type="text" class="form-control" id="creq_amount"  value="<?=$creq_amount?>" alt="number" placeholder="Deposit Amount" required/>
                </div>
                <!--
			<tr>
               <td align="right" class="maintxt"> Submit Receipt : </td>
               <td class="tableDetails"><input type="file" name="creq_receipt" /></td>
             </tr>-->
                <? if($creq_receipt!='') { ?>
                <div class="form-group"> <span for="exampleInputUsername1">Receipt</span> <br>
<img src="<?=UP_FILES_WS_PATH.'/receipt/'.$creq_receipt?>" width="50%" /><br />
                  <p align="left" style="color:#FFFFFF">Delete</p>
                  <input type="checkbox" name="creq_receipt_del" value="1" width="25px" style="width:15px; height:15px;"  class="maintxt" />
                  </p>
                  <input type="hidden" name="old_creq_receipt" value="<?=$creq_receipt?>">
                </div>
                <? } ?>
                <div class="form-group"> <span for="exampleInputUsername1">Deposit Receipt (Please upload copy of your receipt)</span><br>

                  <input name="creq_receipt" type="file"  class="form-control" id="creq_receipt" required><br>

                  <textarea name="creq_remark" cols="40" rows="3" required  class="form-control"  id="creq_remark" placeholder="Transaction ID/Hash Code"><?=$creq_remark?>
</textarea>
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

			