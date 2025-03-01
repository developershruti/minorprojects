<?php
include ("../includes/surya.dream.php");
protect_user_page();
 ///and pay_status='Unpaid'
# $pay_group = 'CW';
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr ";
$sql = " from ngo_users_ewallet inner join ngo_users on pay_userid=u_id and pay_userid='$_SESSION[sess_uid]' and pay_group='$pay_group' ";
//AND pay_group='$pay_group' AND pay_group='$pay_group' and pay_status='Paid'
if ($pay_plan!='') {$sql .= " and pay_plan='$pay_plan' ";}

// if ($pay_for!='') {$sql .= " and pay_for='$pay_for' ";}
// if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
// if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}
if ($pay_for!='') {$sql_part .= " and pay_for='$pay_for' ";}
$order_by == '' ? $order_by = 'pay_id' : true;
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
              <h4 class="mb-sm-0">
			  <? if($pay_plan=='SIGNUP_BONUS'){ ?>
			  Sign Up Bonus			  
			  <? } else if($pay_plan=='SIGNUP_REFERRAL_BONUS'){ ?>
			  Sign Up Referral Bonus
			  <? } else if($pay_plan=='BOUNTY_BONUS'){ ?>
			  Self Bounty Bonus
			  <? } else if($pay_plan=='TEAM_BOUNTY_BONUS'){ ?>
			  Referral Bounty Bonus
			  <? } else { ?>
 			  Sign Up Bonus Statement
			  <? } ?>
			  
			  </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Sign Up Bonus </a></li>
                  <li class="breadcrumb-item active">
			<? if($pay_plan=='SIGNUP_BONUS'){ ?>
			  Sign Up Bonus			  
			  <? } else if($pay_plan=='SIGNUP_REFERRAL_BONUS'){ ?>
			  Sign Up Referral Bonus
			  <? } else if($pay_plan=='BOUNTY_BONUS'){ ?>
			  Self Bounty Bonus
			  <? } else if($pay_plan=='TEAM_BOUNTY_BONUS'){ ?>
			  Referral Bounty Bonus
			  <? } else { ?>
 			  Sign Up Bonus Statement
			  <? } ?> </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
       
        <!--end row-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card newbordercolor">
               <div class="card-body">
                  <? include("error_msg.inc.php");?>
  
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="top">
		  
		  <form method="post" name="form" id="contactform" class="forms-sample" >
                       <table border="0" cellpadding="0" cellspacing="0" class="table table-striped" style="width:50%;">
					  
					    <thead class="table-light"> <tr>
                    <th colspan="5"   ><?php echo  $ARR_WALLET_GROUP[$pay_group] ; ?>
                      Search
                      </th>
                  </tr>
				  </thead>
                         
                         <tr>
                          <td width="26%" align="right" > Date From: </td>
                          <td width="30%"><strong>
                            <input type="date" value="<?=$datefrom?>" name="datefrom" class="form-control"></strong></td>
							 <td width="26%" align="right" > Date to: </td>
                          <td width="22%"><strong>
                            <input type="date" value="<?=$dateto?>" name="dateto" class="form-control">  </strong></td>
                          <td width="22%" style="vertical-align:top;">
						   
						   <input type="hidden" value="<?=$pay_group?>" name="pay_group" class="form-control">
						  <input type="hidden" value="<?=$pay_plan?>" name="pay_plan" class="form-control">
						  
						  <button type="submit" class="btn btn-primary mr-2" id="send-form">Submit</button>
                        
                          </td>
                        </tr>
                         
                      </table> 
 

                    </form>
					
					</td>
          </tr>
		  
		  <tr>
            <td align="center" valign="top" style="vertical-align:top;">
		  <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
             <!-- <div align="right" style="margin-right:1000px; float:right;  padding:5px; color:#fff; width:250px; ">
              
              </div>-->
              <? if ($pay_group=='CW') { ?>
              <!--<a class="site-btn" href="my_ewallet_fund_transfer.php?pay_group=<?php ///   echo  $pay_group; ?>" style="margin-left:840px;">
              <?php  ///  echo  $ARR_WALLET_GROUP[$pay_group] ; ?>
              Fund Transfer</a>-->
              <? } ?> 
			   <p style="color:#fff; font-size:16px; text-align:right; float:right; width:100%  " class=" "  > Account Balance :
                <?  
					 $acc_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]' and pay_group='$pay_group'  ") ;
					 //AND pay_group='$pay_group' and pay_status='Paid' 
					// echo round($acc_balance); AND pay_group='$pay_group'
					echo price_format2($acc_balance); 
					 ?>
               </p>
			  <br>
<br>

              <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                <thead class="table-light"> 
              	<tr>
					
                <th width="11%"   >Tr. No. </th>
                <!-- <td width="10%" height="23">Pay No. </td>-->
                <th width="13%"   >Tr. Date </th>
                <th width="40%" >&nbsp;Transaction details </th>
                <th width="11%" >&nbsp;Credit </th>
                <th width="12%" >&nbsp;Debit </th>
                <th width="12%" >&nbsp;Balance  </th>
               </tr>
			   </thead>
               <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result, MYSQLI_ASSOC)){;
			$ctr++;
 			
 			$total_dr += (double)$line['Dr'];
			$total_cr += (double)$line['Cr'];
			/// AND pay_group='$pay_group'
			 $running_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_userid='$_SESSION[sess_uid]'  and pay_id <'$line[pay_id]' ") ;
			 //AND pay_group='$pay_group' and pay_status='Paid'
			 $acc_balance  = (($running_balance+(double)$line['Cr']) - (double)$line['Dr']);
 			  //$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
               <tr class="<?=$css?>">
                <td  ><?=$line['pay_id']?></td>
                <td  ><?=date_format2($line['pay_date']); ?></td>
                <td align="left" ><?=$line['pay_for']; ?></td>
                <td ><?=($line['Cr']);?></td>
                <td ><?=($line['Dr']);?></td>
                <td ><?=round($acc_balance,2 );?></td>
               </tr>
               <? 
					  
					  } ?>
               <!-- <tr>
                        <td></td>
                        <td></td>
                        <td align="right" class="maintxt"> Transaction Total :</td>
                        <td><?= ($total_cr);?></td>
                        <td><?= ($total_dr);?></td>
						<td ><?=round($total_balance,2 );?> </td>
                      </tr>-->
               <? }  else { ?>
               <tr class="maintxt">
                <td colspan="6">Transaction   details not found </td>
               </tr>
               <? } ?>
               <tr>
                <td valign="top"   align="center" colspan="6"><? include("paging.inc.php");?></td>
               </tr>
              </table>
             </form>
       
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
           		 			   