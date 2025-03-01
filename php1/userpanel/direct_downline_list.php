<?php
include ("../includes/surya.dream.php");
protect_user_page();
 // Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_direct_downline_details");
sajax_handle_client_request();
// END Ajax code
// END Ajax code
 
if ($userid=='') {  $u_userid = $_SESSION['sess_uid'];} else {	
  	$u_userid= db_scalar("select u_id from ngo_users where u_username = '$userid'");
}

if ($level=='') { $level=3;}
$ctr=0;
  
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
              <h4 class="mb-sm-0"> Level Team </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);"> Team Members </a></li>
                  <li class="breadcrumb-item active"> Level Team </li>
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
				
				<form action="" method="post" name="form" class="send-form-style2 " id="contactform" >
                     <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:50%">
					   <thead  class="table-light" >
                <tr  >
                    <th colspan="4"  ><?php   ///echo  $ARR_WALLET_GROUP[$pay_group] ; ?> Search </th>
                  </tr>
				  </thead>
                         
                         <tr>
                          <td width="30%" align="right"  nowrap="nowrap" valign="middle"> Date From/To : </td>
                          <td width="30%"><strong>
                            <input type="date" value="<?=$datefrom?>" class="form-control" name="datefrom"></strong></td>
                          <td width="22%"><strong>
                            <input type="date" value="<?=$dateto?>" class="form-control" name="dateto">  </strong></td>
                          <td width="22%" style="vertical-align:top;">
						  <button type="submit" class="btn btn-primary" id="send-form">Submit</button>
                        
                          </td>
                        </tr>
                        <?  ?>
                      </table> 
 

                    </form>
					</td>
          </tr>
          <tr>
            <td align="center" valign="top" style="vertical-align:top;"><!--main  content table start -->
              <table id="scroll-vertical" class="table table-striped dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
			  <thead  class="table-light" >
              	<tr>
						<th align="center">Referral Level </th>
               			<th align="center">Total Member </th>
						<th align="center">Total Active Member </th>
               			<th align="center" > Total Package </th>
                          <th align="center" > Action </th >
                </tr>
				</thead>
                        <?
 			 
if ($u_userid!='') {
	$id = array();
	$id[]=$u_userid;
	//while ($sb!='stop'){
	while ($ctr<$level){
	$ctr++;
	if ($referid=='') {$referid=$u_userid;}
	if($sb!='stop') {  
   $sql_test = "select *  from ngo_users  where  u_ref_userid in ($referid)   and u_status='Active'";
	if (($datefrom!='') && ($dateto!='')){ $sql_test .= " and u_date between '$datefrom' AND '$dateto' "; }
	
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
	if ($count>0) {
			// print "<br> $count = ".$ctr ;
			$refid = array();
 			$topup_total=0;
        
			//print "<br>= ". "select count(DISTINCT(u_id)) from  ngo_users,ngo_users_recharge where topup_userid=u_id  and topup_status='Paid' and u_ref_userid in($referid)";
			$total_users =  db_scalar("select count(*) from  ngo_users where u_ref_userid in($referid) ")+0;
			//$total_users_paid =  db_scalar("select count(*) from  ngo_users,ngo_users_recharge where topup_userid=u_id  and topup_status='Paid' and  topup_amount='30.00' and u_ref_userid in($referid) ")+0;
 			$total_users_paid =  db_scalar("select count(DISTINCT(topup_userid)) from  ngo_users,ngo_users_recharge where topup_userid=u_id  and topup_status='Paid' and u_ref_userid in($referid) ")+0;
       if($ctr==1 && $total_users_paid>=4)         {$sql_level1= "  member_on_level_1 ='$total_users_paid'"; $member_on_level1 = $total_users_paid; }
			else if($ctr==2 && $total_users_paid>=16)   {$sql_level2= " ,member_on_level_2 ='$total_users_paid'"; }
			else if($ctr==3 && $total_users_paid>=64)   {$sql_level3= " ,member_on_level_3 ='$total_users_paid'"; }
			else if($ctr==4 && $total_users_paid>=256)  {$sql_level4= " ,member_on_level_4 ='$total_users_paid'"; }
			else if($ctr==5 && $total_users_paid>=1024) {$sql_level5= " ,member_on_level_5 ='$total_users_paid'"; }
			else if($ctr==6 && $total_users_paid>=4096) {$sql_level6= " ,member_on_level_6 ='$total_users_paid'"; }
			else if($ctr==7 && $total_users_paid>=16384){$sql_level7= " ,member_on_level_7 ='$total_users_paid'"; }
      else if($ctr==8 && $total_users_paid>=32768){$sql_level8= " ,member_on_level_8 ='$total_users_paid'"; }
      

			// count(DISTINCT(u_id))
			///$total_users_paid =  db_scalar("select count(*) from ngo_users_recharge  where   topup_status='Paid' and topup_userid in($referid) ")+0;	
		 $total_investment =  db_scalar("select sum(topup_amount) from ngo_users_recharge ,ngo_users where topup_userid=u_id and topup_status='Paid' and u_ref_userid in($referid) and u_status='Active'")+0;		
			 $grand_total_investment +=  $total_investment;
 			//	$pay_amount = ($total_investment/100)*$pay_rate;
        $css = ($css=='tdOdd')?'tdEven':'tdOdd';
        
 			?>
                        <tr>
                          <td ><?=$ctr?></td>
                          <td ><?=$total_users?> </td> 
						  <td ><?=$total_users_paid?></td>
                          <td ><?=price_format($total_investment)?></td>
                           <td  nowrap="nowrap"><a href="direct_downline_list.php?act=details&levelno=<?=$ctr?>"  class="btn btn-primary btn-sm" >View Details</a></td>
                        </tr>
                        <?
						if ($act=='details' && $levelno==$ctr) { 
			?>
                        <tr >
                          <td align="left"  colspan="6">
						  <table width="100%" border="0"  align="left" cellpadding="1" cellspacing="1" class="table table-striped" >
						      <thead  class="table-light" >
              	<tr>
						 
                                	<th>Sl. No</th>
                                	<th  >Username</th>
                                	<th >Name</th>
                             		<th >Sponsor ID</th>
                                	<th  >Package</th>
                                	<th > Purchase Status</th>
                              
                                <!--<td align="left" >Investment Date</td>-->
                              	</tr>
							</thead>
                              <?
			 }
 			while ($line_test= mysqli_fetch_array($result_test)){  
				$refid[]=$line_test['u_id']; 
			
			if ($act=='details' && $levelno==$ctr) { 
			 
					 if ($line_test['u_id']!='') { $sql_part = " and u_id='$line_test[u_id]' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
				 	if (($datefrom!='') && ($dateto!='')){ $sql_part .= " and u_date between '$datefrom' AND '$dateto' "; }
					 $sql_you  = "select * from ngo_users where 1 $sql_part";
					$result_you  = db_query($sql_you );
					$count_you = mysqli_num_rows($result_you);
					if ($count_you>0) {
 					$ctr2++;
 					$line_you   = mysqli_fetch_array($result_you );
					if ($datefrom!='' && $dateto!='') {  $sql_topup .= " and topup_date between '$datefrom' AND '$dateto' ";} 
					
					$unit_you = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$line_test[u_id]' and topup_status='Paid'  order by topup_id desc limit 0,1  ")+0;
					//$topup_date = db_scalar("select  topup_date from ngo_users_recharge where  topup_userid='$line_test[u_id]' and topup_status='Paid'");
					$sponsor_id = db_scalar("select  u_username from ngo_users where  u_id='$line_you[u_ref_userid]'");
 				  
			 		$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			  ?>
                              <tr  class="<?=$css?>">
                                <td    ><?=$ctr2?></td>
                                <td    ><?=$line_you['u_username']?></td>
                                <td    ><?=$line_you['u_fname']?></td>
                                 <td    ><?=$sponsor_id?></td> 
                                <td    ><?=price_format($unit_you)?></td> 
								<td    ><? if ($unit_you==0)  { ?>
                          <span class="badge bg-danger">Inactive</span>
                          <!-- <img src="assets/images/user_red_icon.png" align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_you['u_id']?>');" />-->
                          <? } else { ?>
                          <span class="badge bg-success">Active</span>
                          <!--<img src="assets/images/user_green_icon.png"   style="width:27px!important;" align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_you['u_id']?>');" />-->
                          <? }  ?></td>
                               <!-- <td   ><? //=date_format2($line_you['u_date'])?></td>-->
                                
                              </tr>
                              <?
			 }
			
 			}
			
 		}
		if ($act=='details' && $levelno==$ctr) { 
		?>
                            </table></td>
                        </tr>
                        <?
		}
///////////////////////////////////////
 			
			
			$refid = array_unique($refid); 
       $referid = implode(",",$refid);
       
 
 		} else {
      $sb='stop';
     
    }
  }
   } 
   
   if($member_on_level1>=4) { 
    // print "update ngo_users set   $sql_level1 $sql_level2 $sql_level3 $sql_level4 $sql_level5 $sql_level6 $sql_level7 $sql_level8   where u_id='$_SESSION[sess_uid]'";
	 /// db_query("update ngo_users set   $sql_level1 $sql_level2 $sql_level3 $sql_level4 $sql_level5 $sql_level6 $sql_level7 $sql_level8   where u_id='$_SESSION[sess_uid]' ");
	}



  }
 
 
			 
 			  ?>
                         <tr  >
                           <td align="right"  colspan="6" ><h6> Grand Total  : <?=price_format($grand_total_investment)?>&nbsp;&nbsp;&nbsp;</h6></td>
                        </tr> 
                      </table>      

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
           