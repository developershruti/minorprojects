<?php
include ("../includes/surya.dream.php");
$pg='afterlogin';
protect_user_page();
 ///and pay_status='Unpaid'
# $pay_group = 'CW';
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
//$sql_gen = "select * from ngo_users_bid  where  bid_status='New' and $bid_column>0 ";

$columns = "select  * ";
$sql = " from ngo_users_bid inner join ngo_users on bid_userid=u_id and bid_userid='$_SESSION[sess_uid]' and bid_status!='New' ";
//AND pay_group='$pay_group'
#if ($pay_for!='') {$sql .= " and pay_for='$pay_for' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and bid_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}
  
$order_by == '' ? $order_by = 'bid_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
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
              <h4 class="mb-sm-0">Played History</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">BigDice Games   </a></li>
                  <li class="breadcrumb-item active">Played History</li>
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
 
 
   
                  <?php  ///echo  $ARR_WALLET_GROUP[$pay_group] ; ?>
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                    <!-- <tr>
            <td align="center" valign="top">
		  
		  <form method="post" name="form" id="contactform" class="forms-sample" >
                       <table border="0" cellpadding="0" cellspacing="0" class="table table-striped border-top table-hover mb-0  " style="width:50%;  ">
					  
					    <thead> <tr>
                    <th colspan="5"  ><?php /// echo  $ARR_WALLET_GROUP[$pay_group] ; ?>
                      Search Transaction 
                      </th>
                  </tr>
				  </thead>
                         
                         <tr>
                          <td width="26%" align="right" nowrap="nowrap" style="vertical-align:middle;" >  Date From: </td>
                          <td width="30%"><strong>
                            <input type="date" value="<?=$datefrom?>" name="datefrom" class="form-control"></strong></td>
							 <td width="26%" align="right" nowrap="nowrap" style="vertical-align:middle;" >  Date to: </td>
                          <td width="22%"><strong>
                            <input type="date" value="<?=$dateto?>" name="dateto" class="form-control">  </strong></td>
                          <td width="22%" style="vertical-align:top;">
						  <button type="submit" class="btn btn-primary mr-2" id="send-form">Search</button>
                        
                          </td>
                        </tr>
                         
                      </table> 
 

                    </form>
					
					</td>
          </tr>
		  -->
                    <tr>
                      <td align="center"  style="vertical-align:top;">
					  
					  <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                    <thead class="table-light">
                            <tr>
                               <th width="15%" height="23">PlayPredict No. </th> 
                              <th width="15%" align="center" >PlayPredict Date </th>
                              <th width="15%" align="center" >&nbsp;Bet On</th>
                              <th width="15%" align="center" >&nbsp;Amount </th>
                              <th width="15%" align="center" >&nbsp;Status </th>
                            </tr>
                          </thead>
                          <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result, MYSQLI_ASSOC)){;
			$ctr++;
 			 
			 ?>
                          <tr class="<?=$css?>">
						    <td align="center" ><?=$line['bid_gameno']; ?></td>
                            <td align="center"  nowrap="nowrap"><?=datetime_format($line['bid_datetime']);?></td>
                            <td align="center" ><? //=$ARR_BID_GROUP[$line['bid_plan']]; ?> <img width="50" src="images/number/<?=$ARR_BID_IMG[$line['bid_plan']]?>"></td>
                            <td align="center" ><?=$line['bid_amount']; ?></td>
                            <td align="center" ><?=$line['bid_status']; ?></td>
                          </tr>
                          <? 
					  
					  } ?>
                          <? }  else { ?>
                          <tr class="maintxt">
                            <td colspan="6"  align="center" >Transaction   details not found </td>
                          </tr>
                          <? } ?>
                          <tr>
                            <td valign="top"   align="center" colspan="6"><? include("paging.inc.php");?></td>
                          </tr>
                        </table>
                        </form></td>
                    </tr>
                  </table>
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
</body>
</html>                