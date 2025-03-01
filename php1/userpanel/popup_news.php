<?php include ("includes/surya.dream.php"); 
// protect_user_page();
  $sql_page="select * from ngo_staticpage where static_page_name ='popup_news' and static_status='Active' ";
$result_page=db_query($sql_page);
 $row_page=mysqli_fetch_array($result_page);
@extract($row_page);

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>
<?=$META_TITLE?>
</title>
<meta name="keywords" content="<?=$META_KEYWORD?>">
<meta name="description" content="<?=$META_DESC?>" />
<LINK REL="SHORTCUT ICON" HREF="<?=SITE_WS_PATH?>/images/ngo_icon.ico">
<?php include("includes/extra_file.inc.php");?>
 </head>
<body>
     
 
       <img src="images/logo.png" align="left">
	 <table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="td_box2"  >
           <tr>
             <td width="28"  valign="middle"  class="title" >&nbsp;</td>
		  <td width="552"  valign="middle"  class="title" > <?= $static_title ?></td>
		</tr>     
		<tr>
		  <td valign="middle"  >&nbsp;</td>
		  <td valign="middle"  > <?=nl2br($static_desc)?> </td>
		</tr>
	</table>
 
  <!-- .wrapper -->
 
</body>
</html>
