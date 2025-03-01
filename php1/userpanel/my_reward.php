<?php
include ("../includes/surya.dream.php");
protect_user_page();
 
//print_r($_SESSION);
$sql = "select * from ngo_rewards where  rewa_status='Active'  ";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);
 
//print_r($line);

//  $SITE_CSS = $_SESSION[sess_css];
//print $_SESSION['sess_status'];
 
 
$win_rewaid = db_scalar("select win_rewaid from ngo_rewards_winner  where  win_userid='$_SESSION[sess_uid]'");
 
	
	
	
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
              <h4 class="mb-sm-0">Reward List</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Home </a></li>
                  <li class="breadcrumb-item active">Reward List </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <!--end row-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <? include("error_msg.inc.php");?>
				
				
     <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
        <tr>
          <td  align="right" class="maintxt"><a href="my_reward_redeem.php" >&nbsp;&nbsp;&nbsp;Reward Redeem&nbsp;&nbsp;&nbsp;</a> </td>
        </tr>
        <tr>
          <td height="400" align="center" valign="top"  ><br>
          <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
              <tr class="tdhead" >
                <!-- <th width="150" align="left" nowrap="nowrap" class="subtitle">&nbsp;</th>-->
                <th width="280" align="left" nowrap="nowrap" class="tdhead">&nbsp;Reward Name</th>
                <th width="120" align="left" nowrap="nowrap" class="tdhead">&nbsp;Pair's </th>
                <th width="120" align="left" nowrap="nowrap" class="tdhead">&nbsp;Expire Date</th>
                <th width="120" align="left" nowrap="nowrap" class="tdhead">&nbsp;Status</th>
              </tr>
              <?
		//$total_ref = db_scalar("select count(u_ref_userid) from ngo_users where u_ref_userid='$_SESSION[sess_uid]'");
		//$dateFrom = db_scalar("select u_date from ngo_users where u_id='$_SESSION[sess_uid]'");
		// $sql_part = " and topup_date between '2013-01-01' AND '2013-01-31' "; 
//$u_id_a = db_scalar("select u_id from ngo_users  where u_status='Active' and  u_sponsor_id ='$_SESSION[sess_uid]' and u_ref_side='A' limit 0,1");
//$u_total_a = binary_total_paid_ids($u_id_a,$sql_part);
//$u_id_b = db_scalar("select u_id from ngo_users  where u_status='Active' and u_sponsor_id ='$_SESSION[sess_uid]' and u_ref_side='B' limit 0,1");
//$u_total_b = binary_total_paid_ids($u_id_b,$sql_part);
	 
	//print " ==  $u_total_a - $u_total_b "; 
		// select * from ngo_rewards where rewa_total_id<=200 order by rewa_total_id desc limit 0,1
		$result_rewa = db_query("select * from ngo_rewards_winner  where  win_userid='$_SESSION[sess_uid]' and win_rewaid='$rewa_id ' ");
		$line_rewa = mysqli_fetch_array($result_rewa);
 
// print "  a=$u_total_a , |  b= $u_total_b        ";
 
$sql = "select * from ngo_rewards  where rewa_status='Active' ";
$result = db_query($sql);
while($line_raw = mysqli_fetch_array($result)){
	$line = ms_display_value($line_raw);
	@extract($line);
	$ctr++;
	//$dateto =  db_scalar("select ADDDATE('$dateFrom',INTERVAL $rewa_total_days DAY) u_date from ngo_users where u_id='$_SESSION[sess_uid]'"); 

 $css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
              <tr class="<?=$css?>">
                <!-- <td  class="maintxt" > <img src="images/<?=$rewa_product?>" width="150"></td>-->
                <td   >&nbsp; <?=$rewa_name?> </td>
                <td  >&nbsp; <?=$rewa_total_id_show?> </td>
                <td   >&nbsp; <?=date_format2($rewa_exp_date)?> </td>
                <td   >&nbsp;
                  <? 
 					if ($win_rewaid!='') {
  						if  ($win_rewaid==$rewa_id) { echo '<span class="green">Redeemed</span>'; } 
					} else { 
 						if (($u_total_a>=$rewa_total_id) && ($u_total_b>=$rewa_total_id)) { echo '<span class="green">Achived</span>';} else { echo 'Pending';}
 					// echo '<br>  ids='.$rewa_total_id.'tot_ref='.$total_ref;
					}
  				?></td>
              </tr>
              <? 
		 
		 } ?>
            </table></td>
        </tr>
        <tr>
          <td  align="left" valign="top" class="subtitle">Note : <br>
            1.  1 ID eligible only for one highest reward. <br>
            2.  Reward request open 24 X 7. <br>
            3.  Only one reward can be redeem balance will be lapse. <br>
             <br>
            <br>
            <br>
            <br></td>
        </tr>
      </table>
      <!--main content table end -->
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
</b ody>
</html>
