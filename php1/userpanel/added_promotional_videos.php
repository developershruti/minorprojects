<?php include ("../includes/surya.dream.php"); 
@extract($_GET);
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users_promo_video where upvid_userid = '$_SESSION[sess_uid]' "; ///comp_status='Active'  and
///if (!$keyword=='') { $sql .= " and comp_title like '%$keyword%'"; }
$sql_count = "select count(*) ".$sql; 
$sql .= "order by upvid_datetime desc";
$sql .= " limit $start, $pagesize ";
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
            <h1 class="dt-page__title" > My Promotional Videos</h1>
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
	   
  <p align="center" style="color:#FF0000"> <? include("error_msg.inc.php");?>    </p>
<!--Main table start -->
  <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="0"    >
      <tr>
        <td   align="center" valign="top" class="maintxt"  >  
		<?php /*?><table width="99%" >
            <tr>
                        <td height="15" colspan="2" class=""><strong class="black">  &nbsp;My Message List</strong></td>
					
              <td align="right">Write to Help Desk <a href="complain_add.php">Click Here</a></td>
            </tr>
                      
                     
           
          </table><?php */?><br/>
          <table width="99%"  cellpadding="2" cellspacing="2"  class="table table-striped"  >
            <thead>
              <tr>
                     
                      <th align="left" valign=" "> Video Title </th>
					  <th align="left" valign=" "> Video <!--Code--> </th>
					  <th align="left" valign=" "> Total View </th>
					  <th align="left" valign=" "> Channel Name </th>
					  <th align="left" valign=" "> Promoter Name </th>
					  <th align="left" valign=" "> Promoter Contact No. </th>
					  <th align="left" valign=" "> Posted Date </th>
					  <th align="left" valign=" "> Status </th>
                     </tr>
                  </thead>
                  <?
		if (mysqli_num_rows($result)>0) { 
	while($line= (mysqli_fetch_array($result)))	{
	@extract($line);
 	 $css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                    <tr class="<?=$css?>">
					
					
					  <td width="20%" align="left" valign=" "> <?=$upvid_title?></td>
					  <td width="15%" align="left" valign=" "><iframe width="220" height="155"
src="https://www.youtube.com/embed/<?=$upvid_youtube_video_code?>">
</iframe>  </td>
					  <td width="10%" align="left" valign=" "> <?=$upvid_youtube_video_total_view?> </td>
					  <td width="10%" align="left" valign=" "> <?=$upvid_youtube_channel_name?> </td>
					  <td width="10%" align="left" valign=" "> <?=$upvid_youtube_promoter_name?> </td>
					  <td width="10%" align="left" valign=" "> <?=$upvid_youtube_promoter_contact?> </td>
					  <td width="10%" align="left" valign=" "> <?=date_format2($upvid_datetime)?>  </td>
					  <td width="10%" align="left" valign=" ">  <? if($upvid_status=='Inactive') { ?>
					  Pending
					  <? } else { ?>
					  <?=$upvid_status?>
					  
					  <? }  ?>
					  
					  
					  <? ///=$upvid_status?> </td>
					 
					
					 
                    <?php /*?><td valign="top"  nowrap="nowrap"><a href="complain_details.php?comp_id=<?=$comp_id?>" class="btn btn-primary btn-sm mr-2 mb-2">Click For Details&nbsp; II</a> &nbsp; <a href="#top" class="btn btn-primary btn-sm mr-2 mb-2">Go To Top</a> </td><?php */?>
                  </tr>
                  <?
 } 
 } else {   ?>
                  <tr>
                  <tr>
                    <td valign="top" class="error" align="center" colspan="8"> Record  not  found!. </td>
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
			       
  