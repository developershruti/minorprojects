<?php  include ("includes/surya.dream.php"); 
protect_user_page();

$sql= "select * from ngo_staticpage where static_status='active' and static_page_name='$page' ";
$res= db_query($sql);
$row= mysqli_fetch_array($res);
@extract($row);
 	
if ($static_meta_title!='' ) 	{ $META_TITLE = $static_meta_title; } 
if ($static_meta_keyword!='' )	{ $META_KEYWORD = $static_meta_keyword; } 
if ($static_meta_desc!='' ) 	{ $META_DESC = $static_meta_desc; } 
?>
<!DOCTYPE html>
	<html dir="ltr" lang="en-US">
	<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<title><?=$META_TITLE?></title>

	<?php include("includes/extra_file.inc.php");?>

	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'> 
	<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'> 
	
	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<script src="js/html5.js"></script>
	<![endif]-->

	<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" media="all" href="css/ie.css" />
	<![endif]-->
	
	</head>
	<body>
	<div id="boxed" class="rightsidebar">
 		<div id="wrapper">
 			<!-- .topbar -->
			 <?php include("includes/header.inc.php");?>
			 
			<!-- header -->
			
			<section id="subheader">
				<div class="inner" style="width:980px;">
					<div class="subtitle">
						<!--<h1>About Us</h1>-->
						<?
if (file_exists('images/'.$page.'.jpg')) { 
 ?>
<img src="images/<?=$page?>.jpg" /> 
 <? }  else if ($static_image!='') { ?>             
  <img src="<?=show_thumb(UP_FILES_WS_PATH.'/staticpage/'.$static_image,990,200,'resize')?>"/>
 <? }  ?>
					</div>
					 
				</div>
			</section>
			<!-- #subheader -->
			
			<section class="pagemid">
				<div class="inner">
 						<div class="entry-content">

							<h2><?= $row[static_title] ?></h2>
							 <?= $row[static_desc] ?> 
							
				 
						</div>
						<!-- .entry-content -->
  				</div>
				<!-- .inner -->
			</section>
			<!-- .pagemid -->
			
			 <?php include("includes/footer.inc.php");?>
			<!-- .footer -->		
		</div><!-- .wrapper -->
	</div>
	</body>
	</html>
