<?php  include ("includes/surya.dream.php"); 


$sql= "select * from ngo_staticpage where static_status='active' and static_page_name='$page' ";
$res= db_query($sql);
$row= mysqli_fetch_array($res);
@extract($row);
 	
if ($static_meta_title!='' ) 	{ $META_TITLE = $static_meta_title; } 
if ($static_meta_keyword!='' )	{ $META_KEYWORD = $static_meta_keyword; } 
if ($static_meta_desc!='' ) 	{ $META_DESC = $static_meta_desc; } 
?>

  <!DOCTYPE html>
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
 
 <head>
<meta charset="utf-8" />
<meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?=SITE_URL?></title>
<? include("includes/extra_file.inc.php")?>

<!-- IE Fix for HTML5 Tags -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>
<body>
	<!-- header start here -->
	<? include("includes/header.inc.php")?>
    <!-- header end here -->
    
    <!-- pagetitle start here -->
    <section id="pagetitle-container">
    	<div class="row">
        	<div class="twelve column">
            	<h1><?= $row[static_title] ?></h1>
                <h3>A business network for creating contacts and sharing knowledge.</h3>
            </div>
            <div class="twelve column breadcrumb">
            	<ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="current-page"><a href="franchises_list.php"><?= $row[static_title] ?></a></li>
                </ul>
            </div>
        </div>	        
    </section>
    <!-- pagetitle end here -->
      
    <!-- content section start here -->
    <section class="content-wrapper">       
        <div class="row">        	
            <div class="twelve column">
            	
               
                
              <div class="four column mobile-two">
                <div class="note-folded" style="width:920px;">
                    <h4><?= $row[static_title] ?></h4>
                    <div class="td_box"><?= $row[static_desc] ?></div>
                   
                </div>                        
            </div>
                
                <hr/>             
            </div>
            
            
            
            
          
            
           
        </div>             
    </section>
    <!-- content section end here -->
    
    <!-- bottom content start here -->
    
    <!-- bottom content end here -->
    
    <!-- footer start here -->
     <? include("includes/footer.inc.php")?>
</body>

 </html>