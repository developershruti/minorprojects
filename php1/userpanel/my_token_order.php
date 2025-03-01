<?php
include ("../includes/surya.dream.php");
protect_user_page();
  
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users ";
$sql .= " where 1 ";
//if ($id_in!='') { $sql .=" and  u_id in ($id_in)"; }
if ($userid!='') {$sql .=" and u_ref_userid ='$userid'";} else { $sql .=" and u_ref_userid ='$_SESSION[sess_uid]'";}  
if ($u_ref_side!='') { $sql .=" and  u_ref_side='$u_ref_side' "; } 

$sql_count = "select count(*) ".$sql; 
//$sql_count = "select count(*)  from ngo_users where  u_id in ($id_in)"; 
$reccnt = db_scalar($sql_count);



//$sql = "select * from ngo_users where  u_id in ($id_in)   ";

if ($export=='1') { 
	$file_name=$_SESSION[sess_username].'_Direct_Referer_list.txt';
 	$arr_columns =array( 'u_username'=>'Username' ,'u_ref_side'=>'Side','u_fname'=>'First Name' ,'u_address'=>'Address','u_city'=>'City','u_date'=>'DOJ','u_panno'=>'Pan NO');
 	//export_delimited_file($sql, $arr_columns, $file_name, $arr_substitutes='', $arr_tpls='' );
	//exit;
}



$order_by == '' ? $order_by = 'u_id' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;

 


//$sql .=" order by u_id desc limit $start, $pagesize  ";	

$result_gen = db_query($sql);
//$line_gen= mysqli_fetch_array($result_gen);
//@extract($line_gen);


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
            <h1 class="dt-page__title"> RIP TRADE ORDER </h1>
          </div>
          <!-- /page header -->
          <!-- Grid -->
          <div class="row">
            <!-- Grid Item -->
            <div class="col-xl-12">
              
              <div class="dt-card overflow-hidden">
                <!-- Card Body -->
                <div class="dt-card__body p-0">
                  <!-- Tables -->
                  <div class="table-responsive"> 
				   <form action="" method="get">
				   <table width="15%" border="0" class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th colspan="2"  align="left" >Records Per Page:
                          <?=pagesize_dropdown('pagesize', $pagesize);?></th>
                      </tr>
                    </thead>
                  </table>
                 
				    
                 <table width="90%" border="0"   class="table table-striped">
                      <thead>
                        <tr>
                          <th width="14%" class="text-uppercase">&nbsp; User ID </th>
                          <!--<th  width="14%" class="text-uppercase">&nbsp; Coin </th>-->
                          <th width="14%" class="text-uppercase" > Time </th>
                          <th class="text-uppercase" width="14%" >&nbsp; Amount(RIP)</th>
                          <!-- <td  >&nbsp; Mobile</td>-->
                          <th class="text-uppercase" align="center"  >Price($)
	
</th>
                          <th class="text-uppercase" align="center"  >Value($)</th>
                          <th class="text-uppercase" align="center" > Trade </th>
                           
                        </tr>
                      </thead>
                     
					  
					  <tr class="maintxt">
                        <td colspan="7"  class="error" align="center" >No order found </td>
                      </tr>
                      <tr class="maintxt">
                        <td colspan="7"  class="error" align="center" ><? include("paging.inc.php");?></td>
                      </tr>
					  
					  </tbody>
                    </table>
                </form>
                  </div>
                  <!-- /tables -->
                </div>
                <!-- /card body -->
              </div>
              <!-- /card -->
            </div>
            <!-- /grid item -->
            <!-- Grid Item -->
             
            <!-- /grid item -->
            <!-- Grid Item -->
             
            <!-- /grid item -->
            <!-- Grid Item -->
             
            <!-- /grid item -->
            <!-- Grid Item -->
             
            <!-- /grid item -->
            <!-- Grid Item -->
             
            <!-- /grid item -->
            <!-- Grid Item -->
             
            <!-- /grid item -->
            <!-- Grid Item -->
             
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
