<?php
include ("../includes/surya.dream.php");
protect_user_page();
 ///and pay_status='Unpaid'
# $pay_group = 'CW';
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr ";
$sql = " from ngo_users_coin inner join ngo_users on pay_userid=u_id and pay_userid='$_SESSION[sess_uid]' AND pay_group='$pay_group' and pay_status='Paid'";
//AND pay_group='$pay_group'
if ($pay_for!='') {$sql .= " and pay_for='$pay_for' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}
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
            <h1 class="dt-page__title"> Token Statement</h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
          
            <div class="col-xl-12">
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0" >
                  <!-- Tables -->
                  <div class="table-responsive" style="padding:10px;">
                    <p align="center" style="color:#FF0000">
                      <? include("error_msg.inc.php");?>
                    </p>  
           
		  
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="top">
		  
		  <form method="post" name="form" id="contactform" class="forms-sample" >
                       <table border="0" cellpadding="0" cellspacing="0" class="table table-striped" style="width:50%;">
					  
					    <thead> <tr>
                    <th colspan="5"   ><?php echo  $ARR_WALLET_GROUP[$pay_group] ; ?>
                      Search
                      </th>
                  </tr>
				  </thead>
                         
                         <tr>
                          <td width="26%" align="right" > Search Date From: </td>
                          <td width="30%"><strong>
                            <input type="date" value="<?=$datefrom?>" name="datefrom" class="form-control"></strong></td>
							 <td width="26%" align="right" >  Date to: </td>
                          <td width="22%"><strong>
                            <input type="date" value="<?=$dateto?>" name="dateto" class="form-control">  </strong></td>
                          <td width="22%" style="vertical-align:top;">
						  <button type="submit" class="btn btn-primary mr-2" id="send-form">Submit</button>
                        
                          </td>
                        </tr>
                         
                      </table> 
 

                    </form>
					
					</td>
          </tr>
		  
		  <tr>
            <td align="center" valign="top" style="vertical-align:top;">
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
		  
		  
          
         
       
          <tr>
            <td align="center" valign="top" style="vertical-align:top;"><!--main  content table start -->
          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
           <br />
           <tr>
            <td   valign="top"><form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
             <!-- <div align="right" style="margin-right:1000px; float:right;  padding:5px; color:#fff; width:250px; ">
              
              </div>-->
              <? if ($pay_group=='CW') { ?>
              <!--<a class="site-btn" href="my_ewallet_fund_transfer.php?pay_group=<?php ///   echo  $pay_group; ?>" style="margin-left:840px;">
              <?php  ///  echo  $ARR_WALLET_GROUP[$pay_group] ; ?>
              Fund Transfer</a>-->
              <? } ?> 
			   <p style="color:#000; font-size:16px; text-align:center; float:right; width:350px  " class="site-btn"  > Token Balance :
                <?  
					 $acc_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$_SESSION[sess_uid]' AND pay_group='$pay_group' and pay_status='Paid' ") ;
					// echo round($acc_balance); AND pay_group='$pay_group'
					echo  ($acc_balance); 
					 ?>
               </p>
			  <br>
<br>

              <table width="98%" border="0"cellpadding="1" cellspacing="1" class="table table-striped"   >
                <thead>
              	<tr>
					
                <th width="11%" align="center" >Tr. No. </th>
                <!-- <td width="10%" height="23">Pay No. </td>-->
                <th width="13%" align="center" >Tr. Date </th>
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
			 $running_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$_SESSION[sess_uid]'  and pay_id <'$line[pay_id]' AND pay_group='$pay_group' and pay_status='Paid'") ;
			 $acc_balance  = (($running_balance+(double)$line['Cr']) - (double)$line['Dr']);
 			  //$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
               <tr class="<?=$css?>">
                <td align="center" ><?=$line['pay_id']?></td>
                <td align="center" ><?=date_format2($line['pay_date']); ?></td>
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
                <td colspan="6"  align="center" >Token   details not found </td>
               </tr>
               <? } ?>
               <tr>
                <td valign="top"   align="center" colspan="6"><? include("paging.inc.php");?></td>
               </tr>
              </table>
             </form></td>
           </tr>
          </table>
         
     </td>
          </tr>
        </table>
       
	    </td>
          </tr>
        </table>
                    
      </div>
                  <!-- /tables -->
                </div>
                <!-- /card body -->
              </div>
              <!-- /card -->
            </div>
            <!-- /grid item -->
          </div>
          <!-- /grid -->
        </div>
        <!-- Footer -->
        <? include("includes/footer.php")?>
        <!-- /footer -->
      </div>
      <!-- /site content wrapper -->
      <!-- Theme Chooser -->
      <!-- /theme chooser -->
      <!-- Customizer Sidebar -->
      <!-- /customizer sidebar -->
    </main>
  </div>
</div>
<!-- /root -->
<!-- Contact User Information -->
<? include("includes/extra_footer.php")?>
</body>
</html>
