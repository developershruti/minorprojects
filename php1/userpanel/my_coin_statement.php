<?php
include ("includes/surya.dream.php");
protect_user_page();
 ///and pay_status='Unpaid'
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
//$pay_group='CW';
$columns = "select  *, (IF(pay_drcr='Dr',pay_amount,'')) AS Dr,  (IF(pay_drcr='Cr',pay_amount,'')) AS Cr ";
$sql = " from ngo_users_coin inner join ngo_users on pay_userid=u_id and pay_userid='$_SESSION[sess_uid]' AND pay_group='$pay_group_coin'  ";
//AND pay_group='$pay_group'
if ($pay_for!='') {$sql .= " and pay_for='$pay_for' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }
//if ($pay_status!='') {$sql_part .= " and pay_status='$pay_status' ";}
if ($pay_for!='') {$sql_part .= " and pay_for='$pay_for' ";}
if (($datefrom!='') && ($dateto!='')){ $sql_part .= " and pay_date between '$datefrom' AND '$dateto' "; }


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
<? include("includes/extra_file.inc.php")?>
<body>
<!-- Page Preloder -->
<? include("includes/loader.php")?>
<!--====== Header Section Start ======-->
<? include("includes/top_header.php")?>
<!-- MAINMENU-AREA START-->
<? include("includes/header.inc.php")?>
<!--====== Header Section End ======-->
<!--====== Hero Section Start ======-->
<section style="background-image:url(assets/images/quote-baaner.png);" class="page-top">
  <div class="overlay"></div>
  <div class="page-top-info">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1><?=$ARR_COIN_GROUP[$pay_group_coin];?> Statement</h1>
           <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$ARR_COIN_GROUP[$pay_group_coin];?> Statement</li>
            </ol>
        </div>
      </div>
    </div>
  </div>
</section>
<!--====== Hero Section End ======-->
<!-- ==== Contact Section Start ==== -->
<section class="quote-section fix" >
  <div class="container pt100">
    <div class="row">
      <div class="quote-body">
        <div class="contact-section fix " id="contact">
          <div class="container pt100 mb100">
            <div class="row">
              <div class="col-md-12 col-md-offset-0">
                <div class="row">
                  
				  
                  <div class="col-md-12 col-sm-8">
 
 
 
       
       <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  >
        <tr>
         <td align="center" valign="top"> 
          <form name="search" action="" method="get">
           <table width="800" border="0" cellpadding="1" cellspacing="1" class="table table-striped table-hover text-none" style="width:60%" >
           <thead>
		    <tr>
             <th colspan="5" class="subtitle">&nbsp;Search </th>
            </tr>
			</thead>
            <tr>
             <td align="right" nowrap="nowrap">  Date From : </td>
             <td><strong>
              <?=get_date_picker("datefrom", $datefrom)?>
              </strong></td>
             <td width="151" align="right" nowrap="nowrap">  Date To :</td>
             <td width="198"><strong>
              <?=get_date_picker("dateto", $dateto)?>
              </strong></td>
            </tr>
            <?  ?>
            <tr bgcolor="#FFFFFF">
             
             <td colspan="4" style="text-align:center;"><input type="hidden" name="pay_group" value="<?=$pay_group?>"   />
              <input type="submit" name="Submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;"  class="site-btn transition-ease hero" /></td>
            </tr>
           </table>
          </form>  
         </td>
        </tr>
        <tr>
         <td align="center" valign="top" height="300"  ><!--main  content table start -->
      
	  
           <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
            <tr>
            <td   valign="top">
			 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-hover text-left"  >
           <thead>
		    <tr>
            
			<td   valign="top"><div align="right" style="margin-left:0px; float:left;  padding:0px; color:#fff; width:250px; ">
               <h5 style="color:#fff; font-size:16px;" >Today Coin Rate :  <?   $coin_rate = db_scalar("SELECT  sett_value FROM ngo_setting where sett_code='COIN_RATE' ");
			echo price_format($coin_rate ); 
			?> </h5>
              </div> </td>
			<td   valign="top"><div align="right" style="margin-right:10px; float:center;  padding:5px; color:#fff; width:250px; ">
               <h5 style="color:#fff; font-size:16px;" > Coin  Balance :
                <?  
					 $acc_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$_SESSION[sess_uid]' AND pay_group='$pay_group_coin' ") ;
					// echo round($acc_balance); AND pay_group='$pay_group'
					echo round($acc_balance,2 ); 
					 ?>
               </h5>
              </div> </td>
			  <td   valign="top"><div align="right" style="margin-right:10px; float:right;  padding:5px; color:#fff; width:250px; ">
               <h5 style="color:#fff; font-size:16px;" > Coin  Value :
                <?  
 					echo price_format($acc_balance*$coin_rate ); 
					 ?>
               </h5>
              </div> </td>
			</tr>
			 <thead>
			</table>
			
              
              <form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
              <table width="100%" border="0"cellpadding="1" cellspacing="1" class="table table-striped table-hover text-left"   >
               <thead>
			   <tr >
                <!--  <th width="11%" align="center" ><strong>Tr. No. </strong></th>
               <td width="10%" height="23">Pay No. </td>-->
                <th width="13%" align="center" ><strong>Tr. Date </strong></th>
                <th width="40%" ><strong>&nbsp;Naration </strong></th>
                <th width="11%" ><strong>&nbsp;Coin Credit </strong></th>
                <th width="12%" ><strong>&nbsp;Coin Debit </strong></th>
                <th width="12%" ><strong>&nbsp;Coin Balance </strong></th>
               </tr>
			    </thead>
               <?
			$total_count = mysqli_num_rows($result);
 			if ($total_count>0){
 			while ($line= mysqli_fetch_array($result, MYSQLI_ASSOC)){;
			$ctr++;
 			
 			$total_dr += $line['Dr']+0;
			$total_cr += $line['Cr']+0;
			/// AND pay_group='$pay_group'
			 $running_balance =db_scalar("SELECT (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_coin where pay_userid='$_SESSION[sess_uid]'  and pay_id <'$line[pay_id]' AND pay_group='$pay_group_coin'") ;
			 $acc_balance  = (($running_balance+$line['Cr']) -$line['Dr'])+0 ;
 			  //$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
               <tr class="<?=$css?>">
                <!--<td align="center" ><?=$line['pay_id']?></td>-->
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
                <td colspan="6"  align="center" >Coin details not found </td>
               </tr>
               <? } ?>
               <tr>
                <td valign="top"   align="center" colspan="6"><? include("paging.inc.php");?></td>
               </tr>
              </table>
             </form></td>
           </tr>
          </table>
          <!--main content table end -->
         </td>
        </tr>
       </table>
	  

	  
	  </div>
				   
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ==== Footer Massege Section Start ==== -->
<!-- ==== Footer Massege Section End ==== -->
<!-- Footer -->
<? include("includes/footer.inc.php")?>
<!-- end Footer -->
<!--====== Javascripts & Jquery ======-->
<? include("includes/extra_footer.inc.php")?>
</body>
</html>

	  
	  
	  