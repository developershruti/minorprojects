<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
//print_r($_POST);
if(is_post_back()) {
	$arr_pdist_ids = $_REQUEST['arr_pdist_ids'];
	if(is_array($arr_pdist_ids)) {
		$str_pdist_ids = implode(',', $arr_pdist_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
  			#$sql = "delete from ngo_proudct_dist where pdist_id in ($str_pdist_ids)";
			#db_query($sql);
 		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			//$sql = "update ngo_proudct_dist set pdist_status = 'Active' where pdist_id in ($str_pdist_ids)";
			//db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			//$sql = "update ngo_proudct_dist set pdist_status = 'Inactive' where pdist_id in ($str_pdist_ids)";
			//db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_proudct_dist, ngo_users   ";
$sql .= " where  pdist_userid=u_id ";



if ($u_username!='') {
	$u_id = db_scalar("select u_id from ngo_users where u_username = '$u_username'");
	$sql .= " and  pdist_userid  ='$u_id' ";
}

if (($pdist_id_from!='') && ($pdist_id_to!='')) {$sql .= " and (pdist_userid  between $pdist_id_from  and  $pdist_id_to )";}
if ($pdist_cheque_no!='') {$sql .= " and  pdist_cheque_no ='$pdist_cheque_no' ";}
if ($pdist_date!='') {$sql .= " and  pdist_date ='$pdist_date' ";}
if ($pdist_bank!='') {$sql .= " and  pdist_bank ='$pdist_bank' ";}
if ($pdist_status!='') {$sql .= " and  pdist_status  ='$pdist_status' ";}

//$sql = apply_filter($sql, $pdist_title, $pdist_title_filter,'pdist_title');

if ($export2=='1') {
 	$export_id = array();
	$export_id[]=0;
	$export_sql= "select pdist_userid,  count(*) as counter ".$sql . "  group by  pdist_userid ";
 	$export_result = db_query($export_sql);
	while ($line_export = mysqli_fetch_array($export_result)) {
 		if ($line_export[counter]>=2) {
			///print "<br>.  userID=". $line_export[check_userid]."  --- counter=".$line_export[counter];
		 	$export_id[] = $line_export[pdist_userid];}
 	}
	$export_ids = implode(",",$export_id);
 
	$export_sql2 = "   from  ngo_proudct_dist , ngo_users where ngo_proudct_dist.pdist_userid=ngo_users.u_id and pdist_userid in ($export_ids ) order by pdist_userid asc ";
	//$export_sql2 = "   from  ngo_proudct_dist where  pdist_userid in ($export_ids ) order by pdist_userid asc ";
	$arr_columns =array('u_username'=>'User ID','u_fname'=>'User Name','pdist_date'=>'Date','pdist_rec_id'=>'Rec ID','pdist_rec_name'=>'Rec Name','pdist_rec_date'=>'Rec Date','pdist_contact'=>'Contact','pdist_product'=>'Product');
 
 	  export_delimited_file($export_sql2, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	  exit;
}



$order_by == '' ? $order_by = 'pdist_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";

if ($export=='1') {
 	$arr_columns =array('pdist_userid'=>'User ID','pdist_date'=>'Date','pdist_rec_id'=>'Rec ID','pdist_rec_name'=>'Rec Name','pdist_rec_date'=>'Rec Date','pdist_contact'=>'Contact','pdist_product'=>'Product');
	 export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	 exit;
}


$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Product Distribution   List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table width="489"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="4">Search</th>
          </tr>
 		  <tr>
 		    <td class="tdLabel">User ID </td>
 		    <td><input name="u_username"style="width:120px;" type="text" value="<?=$u_username?>" /></td>
 		    <td>Status</td>
 		    <td><?=checkstatus_dropdown('pdist_status',$pdist_status)?></td>
 		    </tr>
 		  <tr>
 		    <td width="95" class="tdLabel">Auto User ID From </td>
 		    <td width="137"><input name="pdist_id_from"style="width:120px;" type="text" value="<?=$pdist_id_from?>" /></td>
 		    <td width="97">Auto User ID To </td>
 		    <td width="142"><input name="pdist_id_to" style="width:120px;"type="text" value="<?=$pdist_id_to?>" /></td>
 		    </tr>
 		  <tr>
            <td class="tdLabel">Rec Date </td>
            <td><?=get_date_picker("pdist_date", $pdist_date)?><!--<input name="pdist_bank" type="text" id="pdist_bank"style="width:120px;" value="<? // =$pdist_bank?>" />--></td>
            <td>&nbsp;</td>
            <td><!--<input name="pdist_status" type="text" id="pdist_status"style="width:120px;" value="<? //=$pdist_status?>" />-->
              <input name="export" type="checkbox" id="export" value="1" />
Export to CSV </td>
 		</tr>
          
		  <tr>
            <td>&nbsp;</td>
                 <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                 <td align="right">&nbsp;</td>
                 <td><input name="export2" type="checkbox" id="export2" value="1" />
Only Duplicate Record </td>
		   </tr>
        </table>
     </form>
   <div align="right"> <a href="product_dist_f.php">Issue New Product </a></div>
            <? if(mysqli_num_rows($result)==0){?>
      <div class="msg">Sorry, no records found.</div>
      <? } else{ ?>
      <div align="right"> Showing Records:
        <?= $start+1?>
        to
        <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?>
        of
        <?= $reccnt?>
      </div>
      <div>Records Per Page:
        <?=pagesize_dropdown('pagesize', $pagesize);?>
      </div>
      <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="6%" align="left" nowrap="nowrap">Sl No </th>
            <th width="6%" align="left" nowrap="nowrap">User ID </th>
			 <th width="9%" align="left" nowrap="nowrap">User Name </th>
			 <th width="9%" align="left" nowrap="nowrap">Rec  Date </th>
			  <th width="8%" align="left" nowrap="nowrap">Product</th>
			  <th width="22%" align="left" nowrap="nowrap">Status</th>
              <th width="7%" align="left" nowrap="nowrap">Rec ID. </th>
              <th width="15%" align="left" nowrap="nowrap">Received by</th>
              <th width="11%">Contact No. </th>
              <th width="4%">&nbsp;</th>
              <th width="3%"><input name="pdist_all" type="checkbox" id="pdist_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	  $duplicate  = db_scalar("select count(*) from ngo_proudct_dist where pdist_userid='$pdist_userid' ");
	if ($duplicate>=2) { $error='bgcolor="#FF2020"';$css='tdLabel'; }
 ?>
            <tr class="<?=$css?>"  <?=$error?>>
            <td nowrap="nowrap"><?=$pdist_id?></td>
            <td nowrap="nowrap"><?=$u_username?></td>
                        <td nowrap="nowrap"><?=$u_fname?></td>
                        <td nowrap="nowrap"><?=date_format2($pdist_rec_date)?></td> 
						 <td nowrap="nowrap"><?=$pdist_product?></td>
						<td nowrap="nowrap"><?=$pdist_status?></td>
                        <td nowrap="nowrap"><?= db_scalar("select u_username from ngo_users where u_id='$pdist_rec_id' "); ?></td>
                        <td nowrap="nowrap"><? if ($pdist_rec_name=='') { echo db_scalar("select u_fname from ngo_users where u_id='$pdist_rec_id' ");} else { echo $pdist_rec_name;}?></td>
                        <td align="center"><?=$pdist_contact?></td>
                        <td align="center"><a href="product_dist_f.php?pdist_id=<?=$pdist_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
                    <td align="center"><input name="arr_pdist_ids[]" type="checkbox" id="arr_pdist_ids[]" value="<?=$pdist_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"><!--<input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_pdist_ids[]')"/>--></td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
