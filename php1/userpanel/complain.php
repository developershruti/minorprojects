<?php include ("../includes/surya.dream.php"); 
@extract($_GET);
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_complain where comp_status='Active'  and comp_userid = '$_SESSION[sess_uid]' ";
if (!$keyword=='') { $sql .= " and comp_title like '%$keyword%'"; }
$sql_count = "select count(*) ".$sql; 
$sql .= "order by comp_datetime desc";
$sql .= " limit $start, $pagesize ";
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
              <h4 class="mb-sm-0">Ticket History </h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Support Ticket </a></li>
                  <li class="breadcrumb-item active">Ticket History </li>
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
                
                <!--Main table start -->
                <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="0"    >
                  <tr>
                    <td   align="center" valign="top" class="maintxt"  ><?php /*?><table width="99%" >
            <tr>
                        <td height="15" colspan="2" class=""><strong class="black">  &nbsp;My Message List</strong></td>
					
              <td align="right">Write to Help Desk <a href="complain_add.php">Click Here</a></td>
            </tr>
           </table><?php */?>
                      <br/>
                      <table width="99%"  cellpadding="2" cellspacing="2"  class="table table-striped"  >
                       <thead class="table-light">
                          <tr>
                            <th width="50%" align="left" valign=" "> Subject </th>
                            <th width="30%" height="10" align="left"  valign=" " class="tdhead" > Posted  Dated </th>
                            <th width="20%" align="left"  valign=" " class="tdhead"  >&nbsp;</th>
                          </tr>
                        </thead>
                        <?
		if (mysqli_num_rows($result)>0) { 
	while($line= (mysqli_fetch_array($result)))	{
	@extract($line);
 	 $css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                        <tr class="<?=$css?>">
                          <td valign="top" ><?=$comp_title?>
                          </td>
                          <td valign="top" ><?=date_format2($comp_datetime)?></td>
                          <td valign="top"  nowrap="nowrap"><a href="complain_details.php?comp_id=<?=$comp_id?>" class="btn btn-primary btn-sm mr-2 mb-2">...</a> &nbsp; <!--<a href="#top" class="btn btn-primary btn-sm mr-2 mb-2">Go To Top</a> --></td>
                        </tr>
                        <?
 } 
 } else { 
 
?>
                        <tr>
                        <tr>
                          <td valign="top" class="error" align="center" colspan="3"> Message  not  found. </td>
                        </tr>
                        <?
 }  
?>
                      </table></td>
                  </tr>
                  <tr>
                    <td valign="top"><? include("paging.inc.php");?></td>
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
