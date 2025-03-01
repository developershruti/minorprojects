<?php
include ("../includes/surya.dream.php");

$PAGE='my tree';
protect_user_page();

// Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_direct_downline_details");
sajax_handle_client_request();
// END Ajax code




 if ($userid=='') {  $u_userid = $_SESSION['sess_uid'];} else {
  	$u_userid= db_scalar("select u_id from ngo_users where u_username = '$userid'");
 } 
 
// $u_userid = $_SESSION[sess_uid];
if ($level=='') { $level=1;}
$ctr=0;

  
  
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
<head>
<? include("includes/extra_head.php")?>

<script language="javascript">
<? sajax_show_javascript(); ?>
 
 //------check username availability code start------------------------------------------------
function do_get_direct_downline_details(userid) {
	document.getElementById(userid).innerHTML = "Loading...";
	document.form1.current_id.value=userid;
	 
	//document.getElementById('loading').innerHTML = "Loading...";
 	//var username	= document.registration.user_username.value;
   	x_get_direct_downline_details('direct_downline_details', userid, do_get_direct_downline_details_cb);
 
 }
function do_get_direct_downline_details_cb(z) {
	 // alert(z);
  	//document.getElementById('loading').innerHTML = "";
	//document.getElementById('loading').innerHTML = z;
	userid = document.form1.current_id.value;
	document.getElementById(userid).innerHTML = z;
   }
  //------check username availability code END------------------------------------------------
 </script>
 
<style type="text/css">
.tree { position:relative; margin-top:10px; min-height:20px;  /* z-index:20;  */ color:#000;  text-decoration:none; } 
.tree_arrow { position:relative; margin-top:0px; min-height:20px;    color:#000;  text-decoration:none}
a.info{   position:relative; margin-left:auto; min-height:20px; margin:auto;      z-index: 999;  color:#000;  text-decoration:none}
a.info:hover{z-index:999999;}
a.info span{display: none}
a.info:hover span{   display:block;  position:absolute;   top:2em; left:-10em; width:25em;   border:1px solid #0cf;  background-color:rgba(255,255,255,0.7); color:#000;    text-align: left}
/*td {padding:3px;}*/
.error {  font-size: 12px;	text-transform: none;	color: #FF0000;}
td { border:none!important;}
/* Default Css  end */


</style>
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
              <h4 class="mb-sm-0">Sponsored List</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Network </a></li>
                  <li class="breadcrumb-item active">Sponsored List</li>
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
			  
			      
        <form id="form1" name="form1" method="get" action="">
          <input type="hidden" name="current_id" value="" />
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="td_box"   >
		 
            <tr>
              <td align="center"  ><table   border="0" align="center" cellpadding="2" cellspacing="2"  class="td_box2" >
                  <tr  >
                    <td  align="center"   width="165px" height="150px"><?
 			   	if ($u_userid!='') {$sql_part =" and u_id ='$u_userid'";} else { $sql_part =" and u_id ='$_SESSION[sess_uid]'";}  

				$sql_me  = "select * from ngo_users where 1 $sql_part  ";
				$result_me  = db_query($sql_me );
				$line_me   = mysqli_fetch_array($result_me);
			   ?>
                      <div class="smalltxt" align="center" style="background:#34495e; height:20px; color:#fff;" >
                   User Id   
                      </div>
					   <div class="txtbox_1"align="center" >
                  <strong> <?=$line_me['u_username']?></strong>
                      </div>
					  <div class="smalltxt" align="center" style="background:#34495e; height:20px; color:#fff;" >
                   Name
                      </div>
					   <div class="txtbox_1" align="center" >
                  <strong> <?=$line_me['u_fname']?></strong>
                      </div>
					  
                      <a class="info" href="direct_tree.php?userid=<?=$line_you['u_username']?>">
                      <?
				  $unit_me = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_me[u_id]'")+0;
				
				 if ($unit_me>0)  { ?>
                      <img src="images/tree_green.png"   align="middle" border="0"  onmouseover="do_get_direct_downline_details('<?=$line_me['u_id']?>');" />
                      <? } else { ?>
                      <img src="images/tree_red.png"   align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_me['u_id']?>');" />
                      <? }  ?>
                      <span class="smalltxt">
                      <div align="left" id="<?=$line_me['u_id']?>"  > </div>
                      </span> </a> </td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td  align="center"  height="1"><hr /><br>  
			   
			  
			              </td>
            </tr>
            <?
 			 
if ($u_userid!='') {
	$id = array();
	$id[]=$u_userid;
	//while ($sb!='stop'){
	while ($ctr<$level){
	$ctr++;
	if ($referid=='') {$referid=$u_userid;}
	 $sql_test = "select *  from ngo_users  where  u_ref_userid in ($referid)  order by u_id asc  ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			// print "<br> $count = ".$ctr ;
			$refid = array();
			$ctr0=1;
			$ctr2=0;
			?>
          <!--  <tr >
              <td  width="80"  align="left"  class="tdhead"> Level
                <?=$ctr?></td>
            </tr>-->
            <tr>
              <td align="left" valign="top" class=" " ><table   style="padding-left:3px;"  align="left" cellpadding="2" cellspacing="2"  class="td_box2" height="250px" >
                  <tr  >
                    <?
 			while ($line_test= mysqli_fetch_array($result_test)){
 				$refid[]=$line_test['u_id'];
				$ctr2++;
				$ctr3=1;
				$ctr3++;
				
			?>
                    <td align="center" valign="top" class="td_box2" width="165px"  ><? 
					  if ($line_test['u_id']!='') { $sql_part = " and u_id='$line_test[u_id]' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
					  $sql_you  = "select * from ngo_users where 1 $sql_part";
					  $result_you  = db_query($sql_you );
					  $line_you   = mysqli_fetch_array($result_you );
					  $unit_you = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_test[u_id]'")+0;
 					  ?>
                      <div class="smalltxt" align="center" >
                       <strong> Team :  <?=$ctr0++?> </strong>                      </div>
					  <table class="td_box" width="100%"  style="font-size:11px;">
					<tr>
					<td width="33%" align="center" class=" " style="background:#34495e; height:20px; color:#fff;">  
					
                       User Id </td>
					   </tr>
					   <tr>
					   
					  <td width="100%"  align="center"> <?=$line_you['u_username']?></td></tr>
					   
					   <tr>
					<td width="33%" align="center" style="background:#34495e; height:20px; color:#fff;">  
					
                       Name </td>
					   </tr><tr>
					  <td width="100%"align="center"> <?=$line_you['u_fname']?></td></tr>
					   </table>
                      <a class="info"  href="direct_tree.php?userid=<?=$line_you['u_username']?>">
                      <? if ($unit_you>0)  { ?>
                      <img src="images/tree_green.png"    align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_you['u_id']?>');" />
                      <? } else { ?>
                      <img src="images/tree_red.png"  align="middle" border="0"  onmouseover="do_get_direct_downline_details('<?=$line_you['u_id']?>');" />
                      <? }  ?>
					
                      </div>
                      <div class="smalltxt" align="center" > 
					  <?   $total_direct_ref_count=$line_you['u_id']?>
					 [<? 
					 
				 
				
				echo downline_ids_count_sk($total_direct_ref_count);
					 
					  ?> ]                      </div>
                      <span class="smalltxt">
                      <div align="left" id="<?=$line_you['u_id']?>" class="red" > </div>
                      </span> </a> </a></td>
                    <?
			 if ($ctr2>=5) { echo "</tr><tr>" ;$ctr2=0;} 
			 
			 
			}
			echo " </tr></table> </td> </tr>";
			$refid = array_unique($refid); 
		 	$referid = implode(",",$refid);
 		}
	 } 
  }
 
 
			 
 			  ?>
                </table></td>
            </tr>
          </table>
        </form>
		
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
