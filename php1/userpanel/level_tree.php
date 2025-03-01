<?php
set_time_limit(0);
include ("../includes/surya.dream.php");
// Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_downline_details");
sajax_handle_client_request();
// END Ajax code
protect_user_page();
if ( $_GET['u_id']!='') {
 	$q = db_scalar("select u_username from ngo_users where u_id = '$_GET[u_id]'");
	if ($q=='') {$q =  $_SESSION['sess_username'] ;}
  } 
if ($q!=''){
$u_userid = $_SESSION['sess_uid'];
if ($u_userid!='') {
	$id = array();
	$id[]=$u_userid;
	while ($sb!='stop'){
	if ($referid=='') {$referid=$u_userid;}
	$sql_test = "select u_id  from ngo_users  where  u_sponsor_id in ($referid)  ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test['u_id'];
				$refid[]=$line_test['u_id'];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$id_in = implode(",",$id);
	if ($id_in!='') {
 		$u_id = db_scalar("select u_id from ngo_users where u_username = '$q' and u_id in ($id_in) ");
		if ($u_id=='') { $msg = "Invalid User ID ";}
 	}
	} 
}
 if ($u_id!='') { $userid = $u_id ;} else {$userid =  $_SESSION['sess_uid'] ;}

$sql = "select * from ngo_users where u_id='$userid' ";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);


$u_id_a = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$userid' and u_ref_side='A' limit 0,1");
$u_id_b = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$userid' and u_ref_side='B' limit 0,1");


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="dark" data-body-image="img-1" data-preloader="disable">
<head>
<? include("includes/extra_head.php")?>
<script language="javascript">
<? sajax_show_javascript(); ?>
 
 //------check username availability code start------------------------------------------------
function do_get_downline_details(userid) {
	document.getElementById(userid).innerHTML = "Loading...";
	document.form1.current_id.value=userid;
 // alert(userid+"OKkkk");
	//document.getElementById('loading').innerHTML = "Loading...";
 	//var username	= document.registration.user_username.value;
   	x_get_downline_details('downline_details', userid, do_get_downline_details_cb);
 
 }
function do_get_downline_details_cb(z) {
 	//alert(z);
  	//document.getElementById('loading').innerHTML = "";
	//document.getElementById('loading').innerHTML = z;
	userid = document.form1.current_id.value;
	//alert(userid);
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
                <? include("error_msg.inc.php");?>
       <form id="form1" name="form1" method="get" action="">
                    <input type="hidden" name="current_id" value="" />


          <table width="50%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="td_box" style="margin-left:235px;">
            <tr>
              <td width="100%" align="center" valign="top"><table width="100%"   border="0" align="center" cellpadding="0" cellspacing="4" class="white_box" >
                  <tr class="tdhead">
                    <td width="50%" align="left" valign="top" height="30px" class="maintxt"><strong>User ID : </strong>
                      <?  echo $u_username; ?>
                      </strong></strong></td>
                    <td width="50%" height="30px" align="left" class="maintxt"><strong>Name&nbsp;&nbsp;&nbsp; : </strong><strong>
                      <?  echo $u_fname; ?>
                      </strong></td>
                  </tr>
                </table></td>
            </tr>
            
          </table>
          <table width="99%"  border="0" align="center" cellpadding="3" cellspacing="3">
            <!--<tr>
                  <td valign="top" align="left" class="title"><strong> &nbsp;Welcome,
                    <?  echo $_SESSION['sess_fname']." [".$_SESSION['sess_username']."] "  ;?>
                    </strong> </td>
                </tr>
                <tr>
                  <td  align="center" >  
                    <div class="error">
                      <?=$msg?>
                     
                    Search User ID :
                    <input name="q" type="text"  value="<?=$q?>"/>
                    &nbsp;
                    <input type="submit" name="Submit" value="Submit" />
                  </td>
                </tr>-->
            <tr>
              <td align="center" valign="top" ><table  width="77%"    border="0" align="center"  cellpadding="0" cellspacing="0"  >
                  <tr>
                    <td align="center"  colspan="5" ><? 
					  if ($u_id!='') { $sql_part = " and u_id= '$u_id' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
					  $sql_you  = "select * from ngo_users where 1 $sql_part";
					  $result_you  = db_query($sql_you );
					  $line_you   = mysqli_fetch_array($result_you );
					  $unit_you = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where topup_status='Paid' and topup_userid='$line_you[u_id]'")+0;
 					  ?>
                      <div class="smalltxt" align="center" > <strong>
                        <?=$line_you['u_username']?>
                        </strong> </div>
                      <a class="info"  href="level_tree.php?u_id=<?=$line_you['u_id']?>">
                      <? if ($unit_you>0)  { ?>
                      <img src="images/tree_green.png"  align="middle" border="2" onMouseOver="do_get_downline_details('<?=$line_you['u_id']?>');"/>
                      <? } else { ?>
                      <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_you['u_id']?>');" />
                      <? }  ?>
                      <span class="smalltxt">
                      <div align="left" id="<?=$line_you['u_id']?>" class="error" > </div>
                      </span> </a> </td>
                  </tr>
                  <tr>
                    <td colspan="5" align="center" ><img src="images/tree_arrow.gif" width="450" />&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="181" ></td>
                    <td  width="249" align="left" ><? 
					  $sql_a  = "select * from ngo_users where  u_sponsor_id= '$line_you[u_id]' and u_ref_side='A'";
					  $result_a  = db_query($sql_a );
					  if (mysqli_num_rows($result_a)>0) { 
					  $line_a   = mysqli_fetch_array($result_a );
					  $unit_a = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where topup_status='Paid' and topup_userid='$line_a[u_id]'")+0;
					  ?>
                      <div class="smalltxt" align="left" > <strong>
                        <?=$line_a['u_username']?>
                        </strong> </div>
                      <a class="info"  href="level_tree.php?u_id=<?=$line_a['u_id']?>">
                      <? if ($unit_a>0)  { ?>
                      <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_a['u_id']?>');"/>
                      <? } else { ?>
                      <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_a['u_id']?>');" />
                      <? }  ?>
                      <span class="smalltxt">
                      <div align="left" id="<?=$line_a['u_id']?>" class="error" > </div>
                      </span> </a>
                      <? } else { ?>
                      <div class="smalltxt" align="left" > <strong>Available</strong> </div>
                      <a href="registration.php"><img src="images/tree_gray.png"  align="middle" border="0" /> </a>
                      <? } ?>
                    </td>
                    <td width="1" ></td>
                    <td width="262" align="right" ><? 
					  $sql_b  = "select * from ngo_users where  u_sponsor_id= '$line_you[u_id]' and u_ref_side='B'";
					  $result_b  = db_query($sql_b );
					  if (mysqli_num_rows($result_b)>0) { 
					  $line_b   = mysqli_fetch_array($result_b );
					  $unit_b = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where topup_status='Paid' and topup_userid='$line_b[u_id]'")+0;
					  ?>
                      <div class="smalltxt" align="right" > <strong>
                        <?=$line_b['u_username']?>
                        </strong> </div>
                      <a class="info"  href="level_tree.php?u_id=<?=$line_b['u_id']?>">
                      <? if ($unit_b>0)  { ?>
                      <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_b['u_id']?>');"/>
                      <? } else { ?>
                      <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_b['u_id']?>');" />
                      <? }  ?>
                      <span class="smalltxt">
                      <div align="left" id="<?=$line_b['u_id']?>" class="error" > </div>
                      </span> </a>
                      <? } else { ?>
                      <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                      <a href="registration.php"><img src="images/tree_gray.png"  align="middle" border="0" /> </a>
                      <? } ?>
                    </td>
                    <td width="192"></td>
                  </tr>
                  <tr>
                    <td  colspan="2" valign="top" ><? //if ($line_a['u_id']!='') {
					
					 ?>
                      <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
                        <tr>
                          <td colspan="5" align="center" ><img src="images/tree_arrow2.gif" width="210"  /></td>
                        </tr>
                        <tr>
                          <td width="98" ></td>
                          <td  width="130" align="left" ><? 
					  $sql_a2_1  = "select * from ngo_users where  u_sponsor_id= '$line_a[u_id]' and u_ref_side='A'";
					  $result_a2_1  = db_query($sql_a2_1 );
					  if (mysqli_num_rows($result_a2_1)>0) { 
					  $line_a2_1   = mysqli_fetch_array($result_a2_1 );
					 $unit_a2_1 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where topup_status='Paid' and topup_userid='$line_a2_1[u_id]'")+0;
					  ?>
                            <div class="smalltxt" align="left" > <strong>
                              <?=$line_a2_1['u_username']?>
                              </strong> </div>
                            <a class="info"  href="level_tree.php?u_id=<?=$line_a2_1['u_id']?>">
                            <? if ($unit_a2_1>0)  { ?>
                            <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_a2_1['u_id']?>');"/>
                            <? } else { ?>
                            <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_a2_1['u_id']?>');" />
                            <? }  ?>
                            <span class="smalltxt">
                            <div align="left" id="<?=$line_a2_1['u_id']?>" class="error" > </div>
                            </span> </a>
                            <? } else { ?>
                            <div class="smalltxt" align="left" > <strong>Available</strong> </div>
                            <a href="registration.php?sposnor_id=<?=$line_a['u_id']?>&ref_side=A"><img src="images/tree_gray.png"  align="middle" border="0" /></a>
                            <? } ?>                          </td>
                          <td width="5" ></td>
                          <td width="126" align="right" ><? 
					  $sql_a2_2  = "select * from ngo_users where  u_sponsor_id= '$line_a[u_id]' and u_ref_side='B'";
					  $result_a2_2  = db_query($sql_a2_2 );
					  if (mysqli_num_rows($result_a2_2)>0) { 
					  $line_a2_2   = mysqli_fetch_array($result_a2_2 );
					  $unit_a2_2 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where topup_status='Paid' and topup_userid='$line_a2_2[u_id]'")+0;
					  
					  ?>
                            <div class="smalltxt" align="right" > <strong>
                              <?=$line_a2_2['u_username']?>
                              </strong> </div>
                            <a class="info"  href="level_tree.php?u_id=<?=$line_a2_2['u_id']?>">
                            <? if ($unit_a2_2>0)  { ?>
                            <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_a2_2['u_id']?>');"/>&nbsp;&nbsp;
                            <? } else { ?>
                            <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_a2_2['u_id']?>');" />&nbsp;&nbsp;
                            <?  }  ?>
                            <span class="smalltxt">
                            <div align="left" id="<?=$line_a2_2['u_id']?>" class="error" > </div>
                            </span> </a>
                            <? } else { ?>
                            <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                            <a href="registration.php?sposnor_id=<?=$line_a['u_id']?>&ref_side=B"><img src="images/tree_gray.png"  align="middle" border="0" /> </a>
                            <? } ?>                          </td>
                          <td width="90"></td>
                        </tr>
                      </table>
                      <?   
					  
					  //}  ?>
                    </td>
                    <td ></td>
                    <td  colspan="2" valign="top"  ><? //if ($line_b['u_id']!='') {
					
					 ?>
                      <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
                        <tr>
                          <td colspan="5" align="center"  ><img src="images/tree_arrow2.gif" width="210"  /></td>
                        </tr>
                        <tr>
                          <td width="66" ></td>
                          <td  width="148" align="left" ><? 
					  $sql_b2_1  = "select * from ngo_users where  u_sponsor_id= '$line_b[u_id]' and u_ref_side='A'";
					  $result_b2_1  = db_query($sql_b2_1 );
					  if (mysqli_num_rows($result_b2_1)>0) { 
					  $line_b2_1   = mysqli_fetch_array($result_b2_1 );
					  $unit_b2_1 =db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where topup_status='Paid' and topup_userid='$line_b2_1[u_id]'")+0; 
					  ?>
                            <div class="smalltxt" align="left" > <strong>
                              <?=$line_b2_1['u_username']?>
                              </strong> </div>
                            <a class="info"  href="level_tree.php?u_id=<?=$line_b2_1['u_id']?>">
                            <? if ($unit_b2_1>0)  { ?>
                            <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_b2_1['u_id']?>');"/>
                            <? } else { ?>
                            <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_b2_1['u_id']?>');" />
                            <? }  ?>
                            <span class="smalltxt">
                            <div align="left" id="<?=$line_b2_1['u_id']?>" class="error" > </div>
                            </span> </a>
                            <? } else { ?>
                            <div class="smalltxt" align="left" > <strong>Available</strong> </div>
                            <a href="registration.php?sposnor_id=<?=$line_b['u_id']?>&ref_side=A"><img src="images/tree_gray.png"  align="middle" border="0" /> </a>
                            <? } ?>                          </td>
                          <td width="0" ></td>
                          <td width="130" align="right" ><? 
				 	  $sql_b2_2  = "select * from ngo_users where  u_sponsor_id= '$line_b[u_id]' and u_ref_side='B'";
					  $result_b2_2  = db_query($sql_b2_2 );
					  if (mysqli_num_rows($result_b2_2)>0) { 
					  $line_b2_2   = mysqli_fetch_array($result_b2_2 );
					  $unit_b2_2 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where topup_status='Paid' and topup_userid='$line_b2_2[u_id]'")+0;
					  ?>
                            <div class="smalltxt" align="right" > <strong>
                              <?=$line_b2_2['u_username']?>
                              </strong> </div>
                            <a class="info"  href="level_tree.php?u_id=<?=$line_b2_2['u_id']?>">
                            <? if ($unit_b2_2>0)  { ?>
                            <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_b2_2['u_id']?>');"/>
                            <? } else { ?>
                            <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_downline_details('<?=$line_b2_2['u_id']?>');" />
                            <? }  ?>
                            <span class="smalltxt">
                            <div align="left" id="<?=$line_b2_2['u_id']?>" class="error" > </div>
                            </span> </a>
                            <? } else { ?>
                            <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                            <a href="registration.php?sposnor_id=<?=$line_b['u_id']?>&ref_side=B"><img src="images/tree_gray.png"  align="middle" border="0" /> </a>
                            <? } ?>                          </td>
                          <td width="102"></td>
                        </tr>
                      </table>
                      <?  
					  
					 // }  ?>
                    </td>
                  </tr>
                </table>
                <br /></td>
             
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
