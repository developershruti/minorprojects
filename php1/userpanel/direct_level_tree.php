<?php
set_time_limit(0);
include ("../includes/surya.dream.php");
$a='downline-tree';
 // Ajax code 
require_once(SITE_FS_PATH."/includes/Sajax.php");
sajax_init();
// $sajax_debug_mode = 1;
sajax_export("get_direct_downline_details");
sajax_handle_client_request();
// END Ajax code
protect_user_page();

if ( $_GET['u_id']!='') {
 	$q = db_scalar("select u_username from ngo_users where u_id = '$_GET[u_id]'");
	#$q = $_GET[u_id] ;
	if ($q=='') {$q =  $_SESSION['sess_username'] ;}
  } 
  
if ($q!=''){
$u_userid = $_SESSION['sess_uid'];
if ($u_userid!='') {
	$id = array();
	$id[]=$u_userid;
	while ($sb!='stop'){
	if ($referid=='') {$referid=$u_userid;}
	$sql_test = "select u_id  from ngo_users  where  u_ref_userid in ($referid)  ";
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
 

$sql = "select * from ngo_users where  u_id='$userid'   ";
$result = db_query($sql);
$line= mysqli_fetch_array($result);
@extract($line);


#$u_id_a = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$userid' and u_ref_side='A' limit 0,1");
#$u_id_b = db_scalar("select u_id from ngo_users where  u_sponsor_id ='$userid' and u_ref_side='B' limit 0,1");


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
   	x_get_direct_downline_details('downline_details', userid, do_get_direct_downline_details_cb);
 
 }
function do_get_direct_downline_details_cb(z) {
	//alert(z);
  	//document.getElementById('loading').innerHTML = "";
	//document.getElementById('loading').innerHTML = z;
	userid = document.form1.current_id.value;
	document.getElementById(userid).innerHTML = z;
   }
  //------check username availability code END------------------------------------------------
</script>
<script language="JavaScript" type="text/javascript" src="includes/general.js"></script>
<style type="text/css">
.tree { position:relative; margin-top:10px; min-height:20px;  /* z-index:20;  */ color:#fff;  text-decoration:none; } 
.tree_arrow { position:relative; margin-top:0px; min-height:20px;    color:#000;  text-decoration:none}
a.info{   position:relative; margin-left:auto; min-height:20px; margin:auto;      z-index: 999;  color:#000;  text-decoration:none}
a.info:hover{z-index:999999;}
a.info span{display: none}
a.info:hover span{   display:block;  position:absolute;   top:2em; left:-10em; width:25em;   border:1px solid #0cf; background:#000000;  color:#fff;    text-align: left}
/*td {padding:3px;}*/
.error {  font-size: 12px;	text-transform: none;	color: #FFFFFF;}

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
  
              <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="td_box">
                <tr>
                  <td   align="center" valign="top" > <table border="0" align="center" cellpadding="0" cellspacing="0" class=""  >
                <tr>  
                  <td  align="center" valign="top">
				 
				  <table  width="100%"   border="0" align="center" cellpadding="2" cellspacing="2" class="table">
                      <tr>
                        <td align="center"  class="maintxt"><input name="q" type="text"  value="<?=$q?>"/></td>
                     
                        <td align="center"  class="maintxt"><input type="submit" name="Submit" value="Search"  class="button"/></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
             </td>
                </tr>
               
				
                <tr>
                  <td align="center" valign="top" >
				 
				  <table   border="0" align="center"  cellpadding="0" cellspacing="0"  >
                      <tr>
                        <td align="center"  colspan="7"><? 
					  if ($u_id!='') { $sql_part = " and u_id= '$u_id' ";} else {$sql_part = " and u_id= '$_SESSION[sess_uid]' ";}
					  $sql_you  = "select * from ngo_users where 1 $sql_part";
					  $result_you  = db_query($sql_you );
					  $line_you   = mysqli_fetch_array($result_you );
					  $unit_you = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_you[u_id]'")+0;
							
					
 					  ?>
                          <div class="smalltxt" align="center" > <strong>
                            <?=$line_you['u_username']?>
                            </strong> </div>
                          <a class="info"  href="direct_level_tree.php?u_id=<?=$line_you['u_id']?>">
                          <? if ($unit_you>0)  { ?>
                          <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_you['u_id']?>');"/>
                          <? } else { ?>
                          <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_you['u_id']?>');" />
                          <? }  ?>
                          <span class="smalltxt">
                          <div align="center"  id="<?=$line_you['u_id']?>" class="error" > </div>
                          </span> </a> </td>
                      </tr>
                      <tr>
                        <td colspan="7" align="center" ><img src="images/tree_arrow.gif" width="450" /></td>
                      </tr>
                      <!--22222222222222222222222222-->
                      <tr >
                        <td width="3" ></td>
                        <td width="242" align="center" ><? 
					  $sql_a  = "select * from ngo_users where   u_ref_userid = '$line_you[u_id]' ";
					 // $a=0+$_GET['page']*2 ;		
					 $a=0+ $_GET['page'] ;
					  $sql_a .="limit   $a ,1";
					  $result_a  = db_query($sql_a );
					  if (mysqli_num_rows($result_a)>0) { 
					  $line_a   = mysqli_fetch_array($result_a );
					  $unit_a 	= db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_a[u_id]'")+0;
					  ?>
                          <div class="smalltxt" align="center" > <strong>
                            <?=$line_a['u_username']?>
                            </strong> </div>
                          <a class="info"  href="direct_level_tree.php?u_id=<?=$line_a['u_id']?>">
                          <? if ($unit_a>0)  { ?>
                          <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a['u_id']?>');"/>
                          <? } else { ?>
                          <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a['u_id']?>');" />
                          <? }  ?>
                          <span class="smalltxt">
                          <div align="center"  id="<?=$line_a['u_id']?>" class="error" > </div>
                          </span> </a>
                          <? } else { ?>
                          <div class="smalltxt" align="center" > <strong>Available</strong> </div>
                          <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                          <? } ?>
                        </td>
                        <td width="24" ></td>
                        <td width="243" align="center" ><? 
					  $sql_b  = "select * from ngo_users where  u_ref_userid= '$line_you[u_id]' ";
							
							//$b=1+$_GET['page']*2 ;
							$b=1+ $_GET['page'] ;
 							$sql_b .="limit $b,1";
						  $result_b  = db_query($sql_b );
					  if (mysqli_num_rows($result_b)>0) { 
					  $line_b   = mysqli_fetch_array($result_b );
					  $unit_b = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_b[u_id]'")+0;
					  ?>
                          <div class="smalltxt" align="center" > <strong>
                            <?=$line_b['u_username']?>
                            </strong> </div>
                          <a class="info"  href="direct_level_tree.php?u_id=<?=$line_b['u_id']?>">
                          <? if ($unit_b>0)  { ?>
                          <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b['u_id']?>');"/>
                          <? } else { ?>
                          <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b['u_id']?>');" />
                          <? }  ?>
                          <span class="smalltxt">
                          <div align="center"  id="<?=$line_b['u_id']?>" class="error" > </div>
                          </span> </a>
                          <? } else { ?>
                          <div class="smalltxt" align="center"> <strong> Available</strong> </div>
                          <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                          <? } ?>
                        </td>
                        <td width="35"></td>
                        <td width="222" align="center" ><? 
														$sql_c  = "select * from ngo_users where  u_ref_userid= '$line_you[u_id]' ";
														//$c=2+$_GET['page']*2 ;
														$c=2+ $_GET['page'] ;
														$sql_c .="limit $c,1";
														$result_c  = db_query($sql_c );
														if (mysqli_num_rows($result_c)>0) { 
														$line_c   = mysqli_fetch_array($result_c );
														$unit_c = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_c[u_id]'")+0;
					        ?>
                          <div class="smalltxt" align="center" > <strong>
                            <?=$line_c['u_username']?>
                            </strong> </div>
                          <a class="info"  href="direct_level_tree.php?u_id=<?=$line_c['u_id']?>">
                          <? if ($unit_c>0)  { ?>
                          <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c['u_id']?>');"/>
                          <? } else { ?>
                          <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c['u_id']?>');" />
                          <? }  ?>
                          <span class="smalltxt">
                          <div align="center"  id="<?=$line_c['u_id']?>" class="error" > </div>
                          </span> </a>
                          <? } else { ?>
                          <div class="smalltxt" align="center"> <strong> Available</strong> </div>
                          <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                          <? } ?>
                          <? //=$line_c[u_id]?>
                        </td>
                        <td width="5"></td>
                      </tr>
                      <tr >
                        <td width="3" ></td>
                        <td width="242" align="center" ><? //if ($line_a[u_id]!='') {
					
					 ?>
                          <table width="93%" border="0" align="center" cellpadding="1" cellspacing="0">
                            <tr>
                              <td colspan="7" align="center" ><img src="images/tree_arrow2.gif" width="180"  /></td>
                            </tr>
                            <tr>
                              <td width="1" ></td>
                              <td width="55" align="center" nowrap="nowrap" ><? 
					  $sql_a2_1  = "select * from ngo_users where  u_ref_userid= '$line_a[u_id]'  ";
 					$sql_a2_1 .="limit 0,1";
					  $result_a2_1  = db_query($sql_a2_1 );
					  if (mysqli_num_rows($result_a2_1)>0) { 
					  $line_a2_1   = mysqli_fetch_array($result_a2_1 );
					 $unit_a2_1 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_a2_1[u_id]'")+0;
					  ?>
                                <div class="smalltxt" align="center"  ><strong><?=$line_a2_1['u_username']?></strong></div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_a2_1['u_id']?>">
                                <? if ($unit_a2_1>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a2_1['u_id']?>');"/>
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a2_1['u_id']?>');" />
                                <? }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_a2_1['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="center"  > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="5" ></td>
                              <td width="55" align="right" nowrap="nowrap" ><? 
					  $sql_a2_2  = "select * from ngo_users where  u_ref_userid= '$line_a[u_id]' ";
						 
							$sql_a2_2 .="limit 1,1";
					  $result_a2_2  = db_query($sql_a2_2 );
					  if (mysqli_num_rows($result_a2_2)>0) { 
					  $line_a2_2   = mysqli_fetch_array($result_a2_2 );
					  $unit_a2_2 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_a2_2[u_id]'")+0;
					  
					  ?>
                                <div class="smalltxt" align="right" > <strong>
                                  <?=$line_a2_2['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_a2_2['u_id']?>">
                                <? if ($unit_a2_2>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a2_2['u_id']?>');"/>&nbsp;&nbsp;
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a2_2['u_id']?>');" />&nbsp;&nbsp;
                                <?  }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_a2_2['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /></a>
                                <? } ?>
                              </td>
                              <td width="27"></td>
                              <td width="50" align="right" nowrap="nowrap"><? 
					  $sql_a2_3  = "select * from ngo_users where  u_ref_userid= '$line_a[u_id]'  ";
							 
							 $sql_a2_3 .="limit 2,1";
					  $result_a2_3  = db_query($sql_a2_3 );
					  if (mysqli_num_rows($result_a2_3)>0) { 
					  $line_a2_3   = mysqli_fetch_array($result_a2_3 );
					  $unit_a2_3 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_a2_3[u_id]'")+0;
					  
					  ?>
                                <div class="smalltxt" align="right" > <strong>
                                  <?=$line_a2_3['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_a2_3['u_id']?>">
                                <? if ($unit_a2_3>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a2_3['u_id']?>');"/>&nbsp;&nbsp;
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_a2_3['u_id']?>');" />&nbsp;&nbsp;
                                <?  }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_a2_3['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"     align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="1"></td>
                            </tr>
                          </table>
                          <?   
					  
					  //}  ?>
                        </td>
                        <td width="24" ></td>
                        <td width="243" align="center" ><? //if ($line_b[u_id]!='') {
					
								 ?>
                          <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
                            <tr>
                              <td colspan="7" align="center"  ><img src="images/tree_arrow2.gif" width="180"  /></td>
                            </tr>
                            <tr>
                              <td width="42" ></td>
                              <td  width="95" align="center" ><? 
					  $sql_b2_1  = "select * from ngo_users where  u_ref_userid= '$line_b[u_id]'  ";
		     $sql_b2_1 .="limit 0,1";
						  $result_b2_1  = db_query($sql_b2_1 );
					  if (mysqli_num_rows($result_b2_1)>0) { 
					  $line_b2_1   = mysqli_fetch_array($result_b2_1 );
					  $unit_b2_1 =db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_b2_1[u_id]'")+0; 
					  ?>
                                <div class="smalltxt" align="center"  > <strong>
                                  <?=$line_b2_1['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_b2_1['u_id']?>">
                                <? if ($unit_b2_1>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b2_1['u_id']?>');"/>
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b2_1['u_id']?>');" />
                                <? }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_b2_1['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="center"  > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="-1" ></td>
                              <td width="83" align="right" ><? 
				 	  $sql_b2_2  = "select * from ngo_users where  u_ref_userid= '$line_b[u_id]'  ";
			 
							 $sql_b2_2 .="limit 	1,1";
					  $result_b2_2  = db_query($sql_b2_2 );
					  if (mysqli_num_rows($result_b2_2)>0) { 
					  $line_b2_2   = mysqli_fetch_array($result_b2_2 );
					  $unit_b2_2 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_b2_2[u_id]'")+0;
					  ?>
                                <div class="smalltxt" align="right" > <strong>
                                  <?=$line_b2_2['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_b2_2['u_id']?>">
                                <? if ($unit_b2_2>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b2_2['u_id']?>');"/>
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b2_2['u_id']?>');" />
                                <? }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_b2_2['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="65"></td>
                              <td width="48" align="right" ><? 
				 	  $sql_b2_3  = "select * from ngo_users where  u_ref_userid= '$line_b[u_id]'  ";
									 
							 $sql_b2_3 .="limit 2,1";
					  $result_b2_3  = db_query($sql_b2_3 );
					  if (mysqli_num_rows($result_b2_3)>0) { 
					  $line_b2_3   = mysqli_fetch_array($result_b2_3 );
					  $unit_b2_3 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_b2_3[u_id]'")+0;
					  ?>
                                <div class="smalltxt" align="right" > <strong>
                                  <?=$line_b2_3['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_b2_3['u_id']?>">
                                <? if ($unit_b2_3>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b2_3['u_id']?>');"/>
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_b2_3['u_id']?>');" />
                                <? }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_b2_3['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="79"></td>
                            </tr>
                          </table>
                          <?  
					  
					 // } 		 ?>
                        </td>
                        <td width="35"></td>
                        <td width="222" align="center" ><table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
                            <tr>
                              <td colspan="7" align="center"  ><img src="images/tree_arrow2.gif" width="180"  /></td>
                            </tr>
                            <tr>
                              <td width="42" ></td>
                              <td  width="95" align="center" ><? 
					  $sql_c2_1  = "select * from ngo_users where  u_ref_userid= '$line_c[u_id]'  ";
							
							 
							$sql_c2_1 .="limit 	0,1";
						  $result_c2_1  = db_query($sql_c2_1 );
					  if (mysqli_num_rows($result_c2_1)>0) { 
					  $line_c2_1   = mysqli_fetch_array($result_c2_1 );
					  $unit_c2_1 =db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_c2_1[u_id]'")+0; 
					  ?>
                                <div class="smalltxt" align="center"  > <strong>
                                  <?=$line_c2_1['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_c2_1['u_id']?>">
                                <? if ($unit_c2_1>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c2_1['u_id']?>');"/>
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c2_1['u_id']?>');" />
                                <? }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_c2_1['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="center"  > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="-1" ></td>
                              <td width="83" align="right" ><? 
				 	  $sql_c2_2  = "select * from ngo_users where  u_ref_userid= '$line_c[u_id]'  ";
							 
							 $sql_c2_2 .="limit 1,1";
					  $result_c2_2  = db_query($sql_c2_2 );
					  if (mysqli_num_rows($result_c2_2)>0) { 
					  $line_c2_2   = mysqli_fetch_array($result_c2_2 );
					  $unit_c2_2 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_c2_2[u_id]'")+0;
					  ?>
                                <div class="smalltxt" align="right" > <strong>
                                  <?=$line_c2_2['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_c2_2['u_id']?>">
                                <? if ($unit_c2_2>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c2_2['u_id']?>');"/>
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c2_2['u_id']?>');" />
                                <? }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_c2_2['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="65"></td>
                              <td width="48" align="right" ><? 
				 	  $sql_c2_3  = "select * from ngo_users where  u_ref_userid= '$line_c[u_id]'  ";
								 
					  $sql_c2_3 .="limit 2,1";
					  $result_c2_3  = db_query($sql_c2_3 );
					  if (mysqli_num_rows($result_c2_3)>0) { 
					  $line_c2_3   = mysqli_fetch_array($result_c2_3 );
					  $unit_c2_3 = db_scalar("select round(sum(topup_amount),0) from ngo_users_recharge where  topup_userid='$line_c2_3[u_id]'")+0;
					  ?>
                                <div class="smalltxt" align="right" > <strong>
                                  <?=$line_c2_3['u_username']?>
                                  </strong> </div>
                                <a class="info"  href="direct_level_tree.php?u_id=<?=$line_c2_3['u_id']?>">
                                <? if ($unit_c2_3>0)  { ?>
                                <img src="images/tree_green.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c2_3['u_id']?>');"/>
                                <? } else { ?>
                                <img src="images/tree_red.png"  align="middle" border="0" onMouseOver="do_get_direct_downline_details('<?=$line_c2_3['u_id']?>');" />
                                <? }  ?>
                                <span class="smalltxt">
                                <div align="center"  id="<?=$line_b2_3['u_id']?>" class="error" > </div>
                                </span> </a>
                                <? } else { ?>
                                <div class="smalltxt" align="right" > <strong>Available</strong> </div>
                                <a href="registration.php"><img src="images/tree_gray.png"    align="middle" border="0" /> </a>
                                <? } ?>
                              </td>
                              <td width="79"></td>
                            </tr>
                          </table></td>
                        <td width="5"></td>
                      </tr>
                    </table>
                    <br /></td>
                  <br />
                  <br />
                </tr>
              </table>
              <?
				$count_raman=db_scalar("select  count(*) from ngo_users where  u_ref_userid = '$line_you[u_id]'"); ?>
              <p style=" font-size:16px; margin-left:auto; margin-right:auto; text-align:center; " >
                <? if ($count_raman!=0 ){?>
                Next Page:
				 <a href="direct_level_tree.php?u_id=<?=$u_id?>" style="padding-left:3px;color:#FF0000">1</a>
                <? } ?>
                <? $count_raman=$count_raman-1; 
					 for ($i = 2; $i < $count_raman; $i++) {
				 ?>
                <a href="direct_level_tree.php?u_id=<?=$u_id?>&page=<?=$i?>" style="padding-left:3px;color:#FF0000"> <? echo $i;?></a>
                <? } ?>
              </p>
            </form><br>
<br>
<br>
<br>
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
