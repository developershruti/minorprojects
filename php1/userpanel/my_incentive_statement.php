<?php
include ("../includes/surya.dream.php");
$PAGE='Incentive  Statement';
protect_user_page();
 ///and pay_status='Unpaid'

//$pay_group='';
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr ";
$sql = " from ngo_users_payment inner join ngo_users on pay_userid=u_id and pay_userid='$_SESSION[sess_uid]' AND pay_group='$pay_group'  ";
 //
// $sql = " select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr  from ngo_users_payment inner join ngo_users on pay_userid=u_id   and pay_userid='$_SESSION[sess_uid]'  " ;
//if ($topup_id!='') {$sql_part .= " and pay_topupid='$topup_id' ";}
if ($pay_for!='') {$sql .= " and pay_for='$pay_for' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}
//if ($pay_group!='') 			{$sql .= " and pay_group='$pay_group' ";}

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);

 
 $_SESSION['arr_error_msgs'] = $arr_error_msgs;
 
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
              <h4 class="mb-sm-0">Autopool Income   Summary </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Autopool Chart </a></li>
                  <li class="breadcrumb-item active">Autopool Income Summary </li>
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
   
   Earning Statement 
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p> 
	
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="top">
			
			<form name="search" action=""   class="forms-sample" method="get">
                <table width="650" border="0" cellpadding="0" cellspacing="0" class="table table-striped">
                <thead>
				  <tr>
                    <th colspan="4" ><?php   ///echo  $ARR_WALLET_GROUP[$pay_group] ; ?> Search </th>
                  </tr>
				  </thead>
                  <tr>
                    <td width="26%" align="right"> Date From/To : </td>
                    <td width="30%"><strong>
                      <input type="date" value="<?=$datefrom?>" name="datefrom" class="form-control">
                      </strong></td>
                    <td width="22%"><strong>
                      <input type="date" value="<?=$dateto?>" name="dateto" class="form-control">
                      </strong></td>
                    <td width="22%" style="vertical-align:top;"><input type="submit" name="Submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;"  class="btn btn-primary mr-2" />
                    </td>
                  </tr>
                  <?  ?>
                </table>
              </form></td>
          </tr>
          <tr>
            <td align="center" valign="top" style="vertical-align:top;"><!--main  content table start -->
             <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
                     <!-- <div align="right" style="  float:right;  padding:5px; color:#ff4f4f; width:350px; ">
                        <h5 style="color:#ff4f4f; font-size:16px;" >
                          <? ///=$ARR_PAYMENT_GROUP[$pay_group]?>
                         Earning Balance :
                          <?  
							  // 
					// $acc_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' ") ;
					 //AND pay_group='$pay_group'
					// echo round($acc_balance);
 					//echo round($acc_balance,2 ); 
					 ?>
                        </h5>
                      </div><br>-->

                      <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                        <tr>
                          <td width="12%"  align="left"  nowrap="nowrap"> Records Per Page: </td>
                          <td width="5%"  align="left"  nowrap="nowrap"><?=pagesize_dropdown('pagesize', $pagesize);?>
                          </td>
                          <td width="60%"  align="right" ><div align="right"> Showing Records:
                              <?= $start+1?>
                              to
                              <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?>
                              of
                              <?= $reccnt?>
                            </div></td>
                        </tr>
                      </table>
                     <br>

					 
					 <table width="100%" cellpadding="1" cellspacing="1" class="table table-striped"   >
                         <thead>
              <tr>
                          <th align="center" >Tr. No.</th>
                           <th align="center" >Tr. Date</th>
                          <th >&nbsp;Transaction details</th>
                          <th >&nbsp;Credit</th>
                          <th >&nbsp;Debit</th>
                          <th >&nbsp;Balance</th>
						 
                        </tr>
						</thead>
                        <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result)){;
			$ctr++;
 			
 			$total_dr += (double)$line['Dr'];
			$total_cr += (double)$line['Cr'];
			// AND pay_group='$pay_group'
			 $running_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment where pay_userid='$_SESSION[sess_uid]' and pay_id <='$line[pay_id]' AND pay_group='$pay_group' ") ;
			 //AND pay_group='$pay_group'
			// $acc_balance  = (($running_balance+$line['Cr']) -$line['Dr'])+0 ;
 			  //$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                        <tr class="<?=$css?>">
                          <td align="center" ><?=$line['pay_id']?></td>
                          <td align="center" ><?=date_format2($line['pay_date']); ?></td>
                          <td align="left" ><?=$line['pay_for']; ?></td>
                          <td align="center" ><?=($line['Cr']);?>
                          </td>
                          <td align="center" ><?=($line['Dr']);?>
                          </td>
                          <td align="center" ><? //=round($acc_balance,2 );?>
                            <?=price_format($running_balance);?>
                          </td>
                        </tr>
                        <? 
					  
					  } ?>
                        <? }  else { ?>
                        <tr class="maintxt">
                          <td colspan="9"  align="center" >Transaction   details not found </td>
                        </tr>
                        <? } ?>
                        <tr>
                          <td valign="top"   align="center" colspan="8"><? include("paging.inc.php");?></td>
                        </tr>
                      </table> 
                    </form>
					
					
					 
			  
			  
              <!--main content table end -->
            </td>
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
