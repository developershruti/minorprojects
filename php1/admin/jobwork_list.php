<?
require_once('../includes/surya.dream.php');
//print_r($_POST);
if(is_post_back()) {
	$arr_data_ids = $_REQUEST['arr_data_ids'];
	if(is_array($arr_data_ids)) {
		$str_data_ids = implode(',', $arr_data_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			#$sql = "delete from ngo_users_data where data_id in ($str_data_ids)";
			#db_query($sql);
		} else if(isset($_REQUEST['Fake']) || isset($_REQUEST['Fake_x']) ) {
			$sql = "update ngo_users_data set data_status = 'Fake' where data_id in ($str_data_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Paid']) || isset($_REQUEST['Paid_x']) ) {
			$sql = "update ngo_users_data set data_status = 'Paid' where data_id in ($str_data_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Unpaid']) || isset($_REQUEST['Unpaid_x']) ) {
			$sql = "update ngo_users_data set data_status = 'Unpaid' where data_id in ($str_data_ids)";
			db_query($sql);
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users_data ,ngo_users  where ngo_users_data.data_userid=ngo_users.u_id and u_status!='Banned' ";
$sql .= " ";
//$sql.=" and ngo_users_data.data_catid=mind_product_category.cat_id ";
if ($u_username!='') 		{$sql .= " and u_username='$u_username' ";} 
//$sql = apply_filter($sql, $data_name, $u_name_filter,'data_name');



if ($export=='1') {
//,'u_ref_userid'=>'Refere ID', 'u_sponsor_id'=>'Spill ID'
   	$arr_columns =array(  'u_username'=>'Username','data_name'=>'Shop Name' ,'data_address'=>'Address' ,'data_mobile'=>'Mobile','data_city'=>'City' ,'data_state'=>'State','data_email'=>'Email','data_industry'=>'Industry' ,'data_pancard'=>'Pancard' ,'data_date'=>' Date');
 
export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
exit;
} 

$order_by == '' ? $order_by = ' ngo_users_data.data_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";

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
      Posted Data List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th colspan="3">Search</th>
          </tr>
                   <tr>
            <td width="51" class="tdLabel">Username</td>
            <td width="140"><input name="u_username" type="text" value="<?=$u_username?>" />
            <? //=filter_dropdown('u_name_filter', $u_name_filter)?></td>
			  <td width="191" align="left"><input name="export" type="checkbox" id="export" value="1" /> Export Data List</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
            <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
          </tr>
        </table>
      </form>
      <br />
       <!-- <div align="right"> <a href="products_f.php">Add New Product</a></div>-->
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
            <th width="17%" align="left" nowrap="nowrap">User ID </th>
             <th width="17%" align="left" nowrap="nowrap">Industry  Name <?= sort_arrows('data_name')?></th>
             <th width="15%" align="left" nowrap="nowrap">Name
               <?= sort_arrows('data_name')?></th>
             <th width="15%" align="left" nowrap="nowrap">Mobile<?= sort_arrows('data_mobile')?></th>
 			  <th width="14%" align="left" nowrap="nowrap">City<?= sort_arrows('data_city')?></th>
			  <th width="14%" align="left" nowrap="nowrap">State<?= sort_arrows('data_state')?></th>
			  <th width="17%" align="left" nowrap="nowrap">Date<?= sort_arrows('data_date')?></th>
			  <th width="18%" align="left" nowrap="nowrap">Status<?= sort_arrows('data_status')?></th>
			<!--  <th width="13%" align="left" nowrap="nowrap">&nbsp;</th>-->
              <th width="5%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
              </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
    $css = ($css=='trOdd')?'trEven':'trOdd';
?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=$u_username?></td>
                         <td nowrap="nowrap"><?=$data_industry?></td>
                         <td nowrap="nowrap" align="center"><?=$data_name?></td>
                         <td nowrap="nowrap" align="center"><?=$data_mobile?></td>
						 <td nowrap="nowrap" align="center"><?=$data_city?></td>
						  <td nowrap="nowrap" align="center"><?=$data_state?></td>
						 <td nowrap="nowrap" align="center"><?=$data_date?></td>
                         <td nowrap="nowrap" align="center"><?=$data_status?></td>
           		<!--<td align="center">
						<a href="products_f.php?data_id=<?=$data_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td> -->
						<td align="center"><input name="arr_data_ids[]" type="checkbox" id="arr_data_ids[]" value="<?=$data_id?>" /></td>
              </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px">
			 <input name="Fake" type="image" id="Fake" src="images/buttons/fake.gif" onclick="return updateConfirmFromUser('arr_data_ids[]')"/>
			  <input name="Paid" type="image" id="Paid" src="images/buttons/paid.gif" onclick="return activateConfirmFromUser('arr_data_ids[]')"/>
              <input name="Unpaid" type="image" id="Unpaid" src="images/buttons/unpaid.gif" onclick="return deactivateConfirmFromUser('arr_data_ids[]')"/>
                       <!--   <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_data_ids[]')"/>--> </td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
