<?php
include ("includes/surya.dream.php");
protect_user_page();
 
//if ($u_userid=='') { $u_userid = $_SESSION[sess_uid];}
if ($u_ref_side!='') {
 	$u_userid = db_scalar("select u_id from ngo_users where u_ref_side='$u_ref_side' and  u_sponsor_id = '$_SESSION[sess_uid]'");
} else  { $u_userid = $_SESSION[sess_uid];}

 		
if ($u_userid!='') {
	$id = array();
	$id[]=$u_userid;
	while ($sb!='stop'){
	if ($referid=='') {$referid=$u_userid;}
	$sql_test = "select u_id  from ngo_users  where  u_sponsor_id in ($referid)  ";
	$result_test = db_query($sql_test);
	$count = mysqli_num_rows($result_test);
		if ($count>0) {
			//print "<br> $count = ".$ctr++;
			$refid = array();
			while ($line_test= mysqli_fetch_array($result_test)){
				$id[]=$line_test[u_id];
				$refid[]=$line_test[u_id];
			}
			 $refid = array_unique($refid); 
			 $referid = implode(",",$refid);
		} else {
			$sb='stop';
		}
	 } 
	$id = array_unique($id); 
	$id_in = implode(",",$id);
 }
 


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users ";
$sql .= " where 1 ";
if ($id_in!='') { $sql .=" and  u_id in ($id_in)"; }  else { $sql .=" and  u_id=''";} 
// if ($u_ref_side!='') { $sql .=" and  u_ref_side='$u_ref_side' "; } 

 $sql_count = "select count(*) ".$sql; 
//$sql_count = "select count(*)  from ngo_users where  u_id in ($id_in)"; 
  $reccnt = db_scalar($sql_count);
 //$sql = "select * from ngo_users where  u_id in ($id_in)   ";
 
if ($export=='1') { 
	//$file_name=$_SESSION[sess_username].'_downline_list.txt';
 	//$arr_columns =array( 'u_username'=>'Username' ,'u_ref_side'=>'Side','u_fname'=>'First Name' ,'u_address'=>'Address','u_city'=>'City' ,'u_date'=>'DOJ');
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
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>
<?=SITE_URL?>
</title>
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
      <h1>Total Downline List</h1>
      <h3>View Your Total Downline List </h3>
    </div>
    <div class="twelve column breadcrumb">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li class="current-page"><a href="#">Total Downline List</a></li>
      </ul>
    </div>
  </div>
</section>
<!-- pagetitle end here -->
<!-- content section start here -->
<section class="content-wrapper">
  <div class="row">
    <div class="four column mobile-two">
      <div class="note-folded"style="width:950px;">
        <h4>Total Downline List</h4>
        <p>
        <table width="100%" border="0"   class="">
          <tr>
            <td  class="gray_box" ><!--main  content table start -->
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="td_box"  >
                <tr>
                  <td align="center"><? //include("user_details.inc.php")?>
                    <form  name="search" method="get">
                      <table width="99%"  border="0" align="center" cellpadding="0" cellspacing="0"   >
                        <tr valign="middle" >
                          <!--<td width="36%"  align="right" nowrap="nowrap"><input name="export" type="checkbox" id="export" value="1" /> </td>
                        <td width="11%"  align="left" nowrap="nowrap"> Download Direct Referral List
                        </td>-->
                          <td width="9%" height="37"  align="left"   valign="middle"><select name="u_ref_side" class="txtbox">
                              <option value="">All</option>
                              <option value="A" <? if ($u_ref_side=='A') {echo "selected";}?>>Left Side</option>
                              <option value="B" <? if ($u_ref_side=='B') {echo "selected";}?>>Right Side</option>
                            </select>
                          </td>
                          <td width="21%" nowrap=" "><input name="Download" type="submit" class="button"  value="Submit" />
                          </td>
                          <td width="11%"  >&nbsp;</td>
                          <td width="54%" align="right"   valign="top">Records Per Page: </td>
                          <td width="5%"  valign="top" ><?=pagesize_dropdown('pagesize', $pagesize);?></td>
                        </tr>
                      </table>
                    </form>
                    <table width="100%"   >
                      <tr   class="tdhead">
                        <th width="11%"  align="left"  >&nbsp;Sl No. </th>
                        <th width="15%" align="left"    >&nbsp;&nbsp;User ID </th>
                        <th width="29%" align="left"   > User Name</th>
                        <th width="17%" align="left"  >Sponsor </th>
                        <th width="19%" align="left"   >&nbsp;DOJ</th>
                        <th width="19%" align="left"    >Status</th>
                      </tr>
                      <?
 		  /*	$sql_gen = "select * from ngo_users where  u_status='Active' ";
			if ($u_id!='') {  $sql_gen .= " and u_ref_userid='$u_id' "; }  else { $sql_gen .= " and u_ref_userid='$_SESSION[sess_uid]' "; }
			$sql_gen .=" order by u_id desc limit $start, $pagesize  ";	
  			 //print $sql_gen;
			$result_gen = db_query($sql_gen);*/
			$total_ref=mysqli_num_rows($result_gen);
			if ($total_ref>0){
			$ctr = $start;
			while ($line_gen= mysqli_fetch_array($result_gen)){;
$ctr++;

			$css = ($css=='tdOdd')?'tdEven':'tdOdd';
			 ?>
                      <tr class="<?=$css?>">
                        <td height="20"  >&nbsp;
                          <?=$ctr;?></td>
                        <td  >&nbsp;
                          <?=$line_gen['u_username'];?></td>
                        <td  ><a href="member_direct_list.php?u_id=<?=$line_gen['u_id'];?>" class="tooltip table_icon"></a>
                          <?=$line_gen['u_fname']." ".$line_gen['u_lname'];?>
                        </td>
                        <td  ><?=db_scalar("select u_username from ngo_users where u_id='$line_gen[u_ref_userid]'");  ?></td>
                        <td  >&nbsp;
                          <?=date_format2($line_gen['u_date']);?></td>
                        <td  ><? if ($line_gen[u_status]=='Reject') { echo "Rejected";} else { echo $line_gen[u_status]; }?>
                        </td>
                      </tr>
                      <? } } else {  ?>
                      <tr >
                        <td colspan="6" align="center" >No Member found </td>
                      </tr>
                      <? } ?>
                      <tr >
                        <td colspan="6" align="right" >Total Count:
                          <?=$reccnt?>
                        </td>
                      </tr>
                      <tr >
                        <td colspan="6" align="center" ><? include("paging.inc.php");?></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <br />
              <br />
              <br />
              <br />
              <br />
              <!--main content table end -->
            </td>
          </tr>
        </table>
        </p>
      </div>
    </div>
    <div class="twelve column">
      <hr/>
    </div>
  </div>
</section>
<!-- footer start here -->
<? include("includes/footer.inc.php")?>
</body>
</html>
