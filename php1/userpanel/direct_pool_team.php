<?php
include ("../includes/surya.dream.php");
protect_user_page();
///exit;
/* if ($userid=='') {  $u_userid = $_SESSION[sess_uid];} else {
  	$u_userid= db_scalar("select u_id from ngo_users where u_username = '$userid'");
}*/

 $u_userid = $_SESSION['sess_uid'];

if ($level=='') { $level=10;}
$ctr=0;
  
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
            <h1 class="dt-page__title"> <?=$ARR_POOL_GROUP[$pool];?></h1>
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
                    <? include("error_msg.inc.php");?>
   
 
    <!--<div align="left" style="width:90%; margin-left:60px;"><h2>Auto Pool Rank (Star <?=$pool?>) Report </h2></div>-->
       <div align="left" style="width:100%;padding:10px;float:left"> 
	      My Pool  :  <?=array_dropdown($ARR_POOL_GROUP,$pool,"pool",  'class="form-control" style=" width:250px;" onchange="location.href=\''.$_SERVER['PHP_SELF'].'?pool=\'+this.value" '); ?>
	   </div>
	 
	  <br>

	   <form id="form1" name="form1" method="get" style="" action="">
      <table width="100%" align="center" border="0" cellpadding="1" cellspacing="1"  class="table table-striped"   >
	   <thead>
      <tr  class="tdhead">
       <th width="6%" align="center" valign="top" nowrap="nowrap" >Pool Level No</th>
       <th width="10%" align="center" valign="top"  > Total User Required</th>
       <!--<th width="10%" align="center" valign="top"  > Total Users Achived</th>-->
	   <th width="10%" align="center" valign="top"  > Pool Income</th>
       <th width="10%" align="center" valign="top"  > Status</th>
      </tr>
	  </thead>
      <?
 		
if ($u_userid!='') {

	array( 'AUTO_POOL_ROZI_GOLD'=>'Auto Pool Rozi Gold Income','AUTO_POOL_ROZI_PLATINUM'=>'Auto Pool Rozi Platinum Income','AUTO_POOL_ROZI_DIAMOND'=>'Auto Pool Rozi Diamond Income','AUTO_POOL_ROZI_ELITE'=>'Auto Pool Rozi Elite Income','AUTO_POOL_ROZI_CROWN'=>'Auto Pool Rozi Crown Income','AUTO_POOL_ROZI_MASTER'=>'Auto Pool Rozi Master Income','AUTO_POOL_ROZI_CLUB'=>'Auto Pool Rozi Club Income' );



if ($pool=='' || $pool==1) {$pool_amount=30; $pool=1; $pool_income = "AUTO_POOL_ROZI_GOLD"; }
else if ($pool==2) {$pool_amount=50;  $pool=2; $pool_income = "AUTO_POOL_ROZI_PLATINUM";}
else if ($pool==3) {$pool_amount=100;  $pool=3; $pool_income = "AUTO_POOL_ROZI_DIAMOND";}
else if ($pool==4) {$pool_amount=500;  $pool=4; $pool_income = "AUTO_POOL_ROZI_ELITE";}
else if ($pool==5) {$pool_amount=1000;  $pool=5; $pool_income = "AUTO_POOL_ROZI_CROWN";}
else if ($pool==6) {$pool_amount=2500;  $pool=6; $pool_income = "AUTO_POOL_ROZI_MASTER";}
else if ($pool==7) {$pool_amount=5000;  $pool=7; $pool_income = "AUTO_POOL_ROZI_CLUB";}
else if ($pool==8) {$pool_amount=10000;  $pool=8; $pool_income = "AUTO_POOL_DIAMOND_INCOME";}
else if ($pool==9) {$pool_amount=20000;  $pool=9; $pool_income = "AUTO_POOL_ANTIMATTER_INCOME";}
else if ($pool==10) {$pool_amount=40000;  $pool=10; $pool_income = "AUTO_POOL_RAZOO_CLUB_INCOME";}

	$id = array();
	$id[]=$u_userid;
	$required =1;
	//while ($sb!='stop'){
	if ($referid=='') {$referid=$u_userid;}
 	while ($ctr<$level){
	$ctr++;
	$required = $required*4;
	if ($referid!='') {/*
	 $sql_test = "select *  from ngo_users  where  u_sponsor_id in ($referid)  order by u_id asc ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
	if ($count>0) {
  	$str_count = db_scalar("select count(*) from ngo_users  where  u_sponsor_id in ($referid) and u_id in (select topup_userid from ngo_users_recharge where topup_amount='$pool_amount') ");
			$str_count2 = $str_count2+$str_count;
 			while ($line_test= mysqli_fetch_array($result_test)){  
					$refid[]=$line_test[u_id]; 
			 }
			$refid = array_unique($refid); 
			$referid = implode(",",$refid);
			
 		}
		*/} else {
			/*$referid='';
			$count=0;*/
		}
 			///ORGINAL CODE if ($str_count2>=$required) { $status='Achieved';} else {$status='Pending';} 
 			$running_balance = $str_count2-$required;
	   /// $pool_income =  db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid ='$u_userid' and pay_plan_level ='$ctr' and pay_plan='$pool_income' ")+0;
	  /// echo "select sum(pay_amount) from ngo_users_payment where pay_userid ='$_SESSION[sess_uid]' and pay_plan_level ='$ctr' and pay_plan='$pool_income' <br/> ";
	      $pool_earning =  db_scalar("select sum(pay_amount) from ngo_users_payment where pay_userid ='$_SESSION[sess_uid]' and pay_plan_level ='$ctr' and pay_plan='$pool_income' ")+0;
			///print $pool_income ;
			if ($pool_earning>0) { $status='Achieved';} else {$status='Pending';} 
			?>
			<tr class="thead">
			<td align="center" valign="top" >Level <?=$ctr?>
			</td>
			<td align="center" valign="top" ><?=$required?> </td>
			<!--<td align="center" valign="top" >
			<? /// if ($str_count2>=$required) { echo $required;} //else { echo $running_balance;} ?>
			<!--total : <? //=$count?> | Paid : <?=$str_count?>  | Balance : <? ///=$running_balance?>  
			</td>-->
			<td align="center" valign="top" ><?=price_format($pool_earning)?> </td>
			<td align="center" valign="top" ><?=$status?>
			</td>
			</tr>
      <?
		
 		 
			
	 } 
  }
 
 
			 
 			  ?>
      <!-- <tr  >
            <td   colspan="5"  ></td>
            <td align="right"  colspan="2" > Total Investment :</td>
            <td width="18%" align="left"  ><?=price_format($total_business)?>            </td>
          </tr>-->
     </table>
    </form> 
	
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
     