<?php
include ("../includes/surya.dream.php");
//protect_user_page();

$sql = "select *  from ngo_deposit_req inner join ngo_users on ngo_deposit_req.creq_userid=ngo_users.u_id  and creq_userid='$_SESSION[sess_uid]'  order by creq_id desc ";
$result = db_query($sql);
 
 
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
            <h1 class="dt-page__title">Deposit Request List </h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
            <div class="col-xl-12">
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0">
                  <!-- Tables -->
                  <div class="table-responsive">
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped">
                      <thead>
                        <tr >
                          <th width="15%" class="text-uppercase" >Date </th>
                          <th width="20%" class="text-uppercase">Payment Mode</th>
                          <th width="20%" class="text-uppercase">UTR No</th>
                          <th width="16%" class="text-uppercase" >Amount USD </th>
                          <th width="16%" class="text-uppercase" >Amount INR </th>
                          <!--
				 		<th width="12%" class="text-uppercase">&nbsp;</th>
				 		<th width="12%" class="text-uppercase" >&nbsp; </th> 
             	<th width="16%" class="text-uppercase" >&nbsp;Deposit Date </th>
             -->
                          <th width="9%"  class="text-uppercase">&nbsp;</th>
                        </tr>
                      </thead>
                      <?
 			if (mysqli_num_rows($result)>0){
			while ($line= mysqli_fetch_array($result)){;
 			 ?>
                      <tr class="maintxt" style="border-color: #e3dede; ">
                        <td><?=date_format2($line['creq_date']);?>
                        </td>
                        <td><?=$line['creq_bank'];?></td>
                        <td><?=$line['creq_txnno'];?></td>
                        <td><?=$line['creq_amountusd'];?>
                        </td>
                        <td><?=$line['creq_amount'];?>
                        </td>
                        <td><?=$line['creq_status'];?></td>
                        <!--	<td><a href="<?=UP_FILES_WS_PATH.'/receipt/'.$line['creq_receipt']?>" target="_blank" class="btn btn-primary btn-sm mr-2 mb-2">View Slip</a></td>
 			
           	<td><? //=date_format2($line['creq_bank_date']);?>  </td>
           <td><? if ($line['creq_status']=='New Request') {?> <a href="deposit_request.php?creq_id=<?=$line['creq_id'];?>"  class="btn btn-primary btn-sm mr-2 mb-2">Edit</a> <? } ?></td> -->
                      </tr>
                      <? } } else {?>
                      <tr class="maintxt" style="border-color: #e3dede; ">
                        <td colspan="9" class="error" align="center" >Deposit request not found </td>
                      </tr>
                      <? } ?>
                    </table>
                  </div>
                  <!-- /tables -->
                </div>
                <!-- /card body -->
              </div>
              <!-- /card -->
            </div>
           
          </div>
          <!-- /grid -->
        </div>
        <!-- Footer -->
        <? include("includes/footer.php")?>
        <!-- /footer -->
      </div>
      
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
<? include("includes/extra_footer.php")?>
</body>
</html>
