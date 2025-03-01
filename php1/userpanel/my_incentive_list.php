<?php
include ("includes/surya.dream.php");
protect_user_page();
 
$sql = " select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr  from ngo_users_payment inner join ngo_users on pay_userid=u_id   and pay_userid='$_SESSION[sess_uid]'   " ;
//if ($topup_id!='') {$sql_part .= " and pay_topupid='$topup_id' ";}
if ($pay_plan!='') {$sql_part .= " and pay_plan='$pay_plan' ";}
if ($pay_group!='') {$sql_part .= " and pay_group='$pay_group' ";}
if (($datefrom!='') && ($dateto!='')){ $sql_part .= " and pay_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}

$order_by == '' ? $order_by = 'pay_id' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
$sql .= $sql_part . "  order by $order_by $order_by2 ";
$result = db_query($sql);


?>
<!DOCTYPE html>
<html lang="zxx">
    
  
   <? include("includes/extra_file.inc.php")?>  
    <body >

            <!--preloader start-->
        <? include("includes/loader.php")?>
   <!--preloader end-->
    <!--==================================
    ===== Header  Top Start ==============
    ===================================-->
        <? include("includes/header.inc.php")?>  
    <!--==================================
    <!--==================================
    ===== header Section End ===========
    ===================================-->

    <!--==================================
    ===== Breadcrumb Section Start ===========
    ===================================-->
    <section class="breadcrumb-section section-bg-clr5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h2>Income Statement</h2>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Income Statement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==================================
    ===== Breadcrumb Section End ===========
    ===================================-->

    <!--==================================
    ===== Contact Form Section Start ===========
    ===================================-->

    <section class="contact-form-section contact-form-section2 section-padding">
        <div class="container">
            <div class="row">
			  
			 
                <div class="col-md-12">
                    <aside class="blog-aside">

                         
                         <div class="widget widget-categories">
                            <h4>View your Income Statement Details</h4>
        
		    
              <? //if ($topup_id!='') { echo ' <div align="left" class="subtitle">Topup Ref No :'.$topup_id;} ?>
              
			   <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
                     <table width="100%" align="center" border="0" cellpadding="1" cellspacing="1" class="td_box">
                      <tr  class="tdhead">
                         <!--<th width="11%" align="center"><strong>Transaction ID. </strong></th>
                        <th width="10%" height="23">Pay No. </th>-->
                        <th width="20%" align="center">Income Date </th>
                        <th width="40%">&nbsp;Income details </th>
                       <!-- <th width="11%">Processor</th>-->
                        <th width="11%">&nbsp;Earning </th>
                        <th width="11%">&nbsp;Withdraw </th>
                        <th width="11%">&nbsp;Balance </th>
                      </tr>
                      <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result)){;
			$ctr++;
 			 
 			$total_dr += $line['Dr'];
			$total_cr += $line['Cr'];
			$total_balance  = $total_cr -$total_dr ;
			$css = ($css=='tdEven')?'tdOdd':'tdEven';
 			 
			 ?>
                    <tr class="<?=$css?>">
                        <!--<td align="center"><? //=$line['pay_id']?></td>-->
                         <td align="center" ><?=date_format2($line['pay_date']); ?></td>
                        <td><?=$line['pay_for']; ?></td>
                       <!-- <td><?=$line['pay_group'];?></td>-->
                        <td><?=price_format($line['Cr']);?> </td>
                        <td><?=price_format($line['Dr']);?> </td>
						
                        <td><?=price_format($total_balance) ;?></td>
                      </tr>
                      <? } ?>
				      <tr class="td_box">
                        <td></td>
                        
                        <td align="right" class="subtitle"> Total :</td>
                        <td class="subtitle"><strong>
                          <?=price_format($total_cr);?>
                        </strong></td>
                        <td class="subtitle"><strong>
                          <?=price_format($total_dr);?>
                        </strong></td>
                        <td class="subtitle"><?=price_format($total_balance) ;?></td>
                        
                      </tr>
                     
                      <? }  else { ?>
                      <tr class="maintxt">
                        <td colspan="10" class="error" align="center" ><br>Transaction  not found! </td>
                      </tr>
                      <? } ?>
                      <tr>
                        <td valign="top"   align="center" colspan="9"><? include("paging.inc.php");?></td>
                      </tr>
                    </table>
                </form>
             
              
			
			
			 
			 

  	
        </div>
                             
                             

                    </aside>
                </div>
				    
            </div>  
        </div>
    </section>

    <!--==================================
    ===== Contact Form Section End ===========
    ===================================-->


    <!--==================================
    ===== Footer Section Start ===========
    ===================================-->

        <!-- Footer section start -->
         <? include("includes/footer.inc.php")?>
<!--==================================
    =============== Js File ===========
    ===================================-->
<!--jquery script load-->
<? include("includes/extra_footer.inc.php")?>