<?php include ("../includes/surya.dream.php"); 
@extract($_GET);   
$pagesize = 10;
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users_promo_video where (upvid_status!='Inactive' or upvid_status!='Rejected')   "; ///comp_status='Active'  and
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
 <style>
/*.tooltip {
  position: relative;
  display: inline-block;
  opacity: 1;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
  
}*/
#myInput, #myInput:hover, #myInput:focus { border:none!important; background:none!important;  pointer-events: none!important; border-color: none!important;
    -webkit-box-shadow: none!important;
    box-shadow: none!important; width: 168%;}

#myInput::selection {
     
    background-color: #fff;
	border-color:#eee;
	color:#000;
} 
</style>
</head>
<body class="dt-layout--default dt-sidebar--fixed dt-header--fixed">
<!-- Loader -->
<? include("includes/loader.php")?>
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
        <div class="dt-content">
          <router-outlet></router-outlet>
          <app-crypto-dashboard _nghost-ugy-c43="" class="ng-star-inserted">
            <div _ngcontent-ugy-c43="" class="dt-page__header">
              <h1 _ngcontent-ugy-c43="" class="dt-page__title"> All Promotional Videos  </h1>
            </div>
             <div _ngcontent-ugy-c43="" class="row">
			  <?
		if (mysqli_num_rows($result)>0) { 
	while($line= (mysqli_fetch_array($result)))	{
	@extract($line);
 	 $css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
 			  <div _ngcontent-ugy-c43="" class="col-xl-6">
			 
                <section-balance-portfolio _ngcontent-ugy-c43="" fullheight="" gxcard="" _nghost-ugy-c44="" class="dt-card dt-card__full-height">
				 
					
                  <card-header _ngcontent-ugy-c44="" class="mb-4 dt-card__header">
                    <!---->
                    <card-heading _ngcontent-ugy-c44="" _nghost-ugy-c30="" class="dt-card__heading">
                      <h3 _ngcontent-ugy-c44="" class="dt-card__title">
                         <span _ngcontent-ugy-c44="" class="align-bottom"><?=$upvid_title?> </span></h3>
                    </card-heading>
                    <!--<card-tool _ngcontent-ugy-c44="" _nghost-ugy-c32="" class="dt-card__tools"><a _ngcontent-ugy-c44="" class="dt-card__more" href="javascript:void(0)">
                      <gx-icon _ngcontent-ugy-c44="" class="mr-2 icon icon-circle-add-o" name="circle-add-o"></gx-icon>
                      Add New </a></card-tool>-->
					  
                  </card-header>
                  <card-body _ngcontent-ugy-c44="" class="pb-4 dt-card__body" _nghost-ugy-c31="">
                    <div _ngcontent-ugy-c44="" class="row no-gutters">
					
				<iframe width="100%" height="350"
src="https://www.youtube.com/embed/<?=$upvid_youtube_video_code?>">
</iframe>
                     
                    </div>
                 
                  </card-body>
                </section-balance-portfolio>
              </div>
			  
			  
			   <?
 } 
 } else {   ?> <p> Record  not  found! </p>
                  
                  <?
 }  
?> 
<p align="center"> <? include("paging.inc.php");?> </p>
             </div>
           </app-crypto-dashboard>
        </div>
		 <? include("includes/footer.php")?>
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
<!-- /contact user information -->
<!-- masonry script -->
<? include("includes/extra_footer.php")?>
</body>
</html>
