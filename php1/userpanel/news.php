<?php include ("includes/surya.dream.php"); 
#protect_user_page();
 $PAGE='NEWS';
@extract($_GET);
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_news where news_status='Active'  ";
if (!$keyword=='') { $sql .= " and news_title like '%$keyword%'"; }
$sql_count = "select count(*) ".$sql; 
$sql .= "order by news_datetime desc";
$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
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
          <h2>Latest News</h2>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li>Latest News</li>
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
    ===== Blog Single Section Start ===========
    ===================================-->
<section class="blog-single-section section-padding">
        <div class="container">
            <div class="row">
			<div class="col-md-2">&nbsp;</div>
                <div class="col-md-8" style="border:solid #eee 2px; padding-top:15px;">
                    <div class="blog-wrapper">
                        <div class="blog-content">
						<?
	while($line= (mysqli_fetch_array($result)))	{
	@extract($line);
 	?>
                            <div class="blog-thumb"> <?  if (($line[news_image]!='')&& (file_exists(UP_FILES_FS_PATH.'/news/'.$line[news_image]))) {  ?>
                    <!--<img src="<? //=show_thumb(UP_FILES_WS_PATH.'/news/'.$line[news_image],65,65,'height')?>" align="center" />-->
					<img src="<?=UP_FILES_WS_PATH.'/news/'.$line[news_image];?>"/>
					<? }  ?><!--<img src="assets/images/blogs/13.jpg" alt="blog">--></div>
                            <div class="blog-text">
                                <div class="blog-header">
                                    <h3> <?=$news_title?><!--Together we can make a Difference--></h3>
                                    <?php /*?><ul>
                                        <li>
                                            <p>Date:</p>
                                            <span>February 22,2018</span>
                                        </li>
                                        <li>
                                            <p>Posted by:</p>
                                            <span>Amelia Lee</span>
                                        </li>
                                        <li>
                                            <p>Comments:</p>
                                            <span>3</span>
                                        </li>
                                        <li>
                                            <p>Category:</p>
                                            <span>Marketing</span>
                                        </li>
                                    </ul><?php */?>
                                </div>
                                <div class="blog-desc">
                                    <p><?=$news_desc?></p>
                                    
                                    
                                    
                                </div>
                                <? } ?> 
                            </div>
                        </div>
                         
                         
                    </div>
                </div>
				<div class="col-md-2">&nbsp;</div>
                  
            </div>
        </div>
    </section>
<!--==================================
    ===== Blog Section End ===========
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
</body>
</html>
