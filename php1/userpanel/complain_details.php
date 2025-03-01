<?php include ("../includes/surya.dream.php"); 

if (($act=='del') && (!$reply_id=='')){
	protect_user_page();
	$sql_del="delete from ngo_complain_reply where reply_id='".$reply_id."'";
	db_query($sql_del);
	header("location: complain_details.php?reply_id=$reply_id");
	exit;
}	
if(is_post_back()) {
protect_user_page();
      @extract($_POST);
      $reply_description = ms_form_value($reply_description);
 		if ($reply_id=='') { 
		  	$sql_update="insert into ngo_complain_reply (reply_compid, reply_userid, reply_description,  reply_date , reply_lastupdate, reply_status) values ('$comp_id','$_SESSION[sess_uid]',' $reply_description' ,now(),now(),'Active')";
			db_query($sql_update);
 			$sql_update2="update ngo_complain set comp_is='Open'  where comp_id='$comp_id'";
			db_query($sql_update2);
			
 		} else {
  			$sql_update="update ngo_complain_reply set reply_description='$reply_description',   reply_lastupdate=now() where reply_id='".$reply_id."'";
			db_query($sql_update);
		}
		
		header("location: complain_details.php?comp_id=$comp_id");
		exit;
}  
 

@extract($_GET);
$sql = "select * from ngo_complain where comp_status='Active'  and comp_id='$comp_id' ";
$result = db_query($sql);
$line= (mysqli_fetch_array($result));
@extract($line);
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
              <h4 class="mb-sm-0">Support Request Details </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Support Request </a></li>
                  <li class="breadcrumb-item active">Support Request Details  </li>
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
                


			 <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0"  class="table table-striped" >
                          <br/>
                          <tr>
                            <td valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table table-striped">
                                <tr>
                                  <td width="50%" align="right"  valign="top" ><strong>Subject : </strong></td>
                                  <td width="50%"  valign="top" class="hadding_blue" ><strong>
                                    <?=$comp_title?>
                                    </strong> </td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top" class="maintxt"><strong>Message Details : </strong></td>
                                  <td valign="top" class="maintxt"><?=ms_display_value($comp_desc)?>                                  </td>
                                </tr>
                                <tr>
                                  <td align="right" valign="top"  class="maintxt"><strong>Posted  Dated :</strong></td>
                                  <td valign="top"  class="maintxt"><?=date_format2($comp_datetime)?>                                  </td>
                                </tr>
                               <?php /*?> <tr>
                                  <td align="right" valign="top" >&nbsp;</td>
                                  <td align="right" valign="top" ><p align="right"><a href="complain.php" class="maintxt">Back to message List </a> </span></p></td>
                                </tr><?php */?>
                              </table><br>
<br>
</td>
                          </tr>
                          <tr>
                            <td valign="top" class="maintxt">
							 
  							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="td_box">
							 <tr class="tdhead">
                                  <th valign="top" > Message Reply </th>
                                </tr>
							
                                <?
				  $sql_comment = "select  * from ngo_complain_reply ,ngo_users where ngo_complain_reply.reply_userid=ngo_users.u_id and reply_status='Active' and reply_compid='$comp_id' order by reply_date asc";
				$result_comment = db_query($sql_comment);
				if ($count_comment= mysqli_num_rows($result_comment) >0){
 				while ($line_comment=  (mysqli_fetch_array($result_comment))) {
  				?>
                                <tr>
                                  <!--<td ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td height="10" width="20%" align="center" ><? /* if (!$line_comment['u_photo']=='') { ?>
                                          <a href="profile.php?userid=<?=$line_comment['u_id']?>"><img src="<?=show_thumb(UP_FILES_WS_PATH.'/profile/'.$line_comment['u_photo'],75,75,'height')?>" border="0"   align="left" class="border_image" style="margin-right:5px;" /></a>
                                          <? } else { ?>
                                          <img src="images/no_pic.gif" width="65" height="65" border="0" align="left" style="margin-right:5px;" />
                                          <? } */?>
                                          
                                        </td>
                                      </tr>
                                    </table></td>-->
                                  <td  valign="top" >
								  
								  <table width="100%" border="0" cellspacing="4" cellpadding="4" class="td_box">
                                      <tr>
                                        <td    valign="top"  ><?=ms_display_value($line_comment['reply_description']) ?></td>
                                      </tr>
                                      <tr>
                                        <td   class="smalltxt"><strong>By:</strong> <?=$line_comment['u_username']?>
                                          &nbsp;&nbsp; <strong>Dated :</strong>  <?=date_format2($line_comment['reply_date'])?> </td>
                                      </tr>
                                    </table>
									 <br><br>

									</td>
                                </tr>
                                
                                
                                <? }} else {  ?>
								 <tr>
                                        <td    valign="top" align="center" class=" "><br>No message  reply posted yet!<br><br>
</td>
                                      </tr>
								 <? }  ?>
								
                              </table></td>
                          </tr>
                          <tr>
                            <td valign="top" class="maintxt"> 
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="form1" id="form1" <?= validate_form()?> >
                                <input type="hidden" name="reply_id" value="<?=$reply_id?>" />
                                <input type="hidden" name="comp_id" value="<?=$comp_id?>" />
                                <table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" class="td_box">
								
								
							 
                                  <tr class="tdhead"  >
                                    <th colspan="2" style="text-align:left"><a name="comment" id="comment"></a> Post Your Message Reply </th>
                                  </tr>
                                  <tr>
                                    <td width="27%">Reply Message</td>
                                    <td width="73%"><textarea name="reply_description" class="form-control" cols="35" rows="5" id="reply_description" alt="blank" emsg="Please enter your comment" onFocus="javascript:setobj_name('reply_description')"><?=$edit_description?>
</textarea></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" name="Submit" value="Submit" class="btn btn-primary active" /></td>
                                  </tr>
                                </table>
                              </form></td>
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
</b ody>
</html>
