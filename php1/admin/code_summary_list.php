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
$sql = " from ngo_users , ngo_code where  u_id=code_userid ";
//$sql .= " where   1 ";
 
if ($u_username!='') {$sql .= " and  u_username ='$u_username' ";}
if (($pdist_id_from!='') && ($pdist_id_to!='')) {$sql .= " and (u_id  between $u_id_from  and  $u_id_to )";}
if ($u_status!='') {$sql .= " and  u_status  ='$u_status' ";}
 
  $sql .= " group by u_id  "; 
 
$order_by == '' ? $order_by = 'u_id' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
$sql_count = "select count(*) ".$sql; 

$sql1 = $columns.$sql;
$result1 = db_query($sql1);
$reccnt = mysqli_num_rows($result1);

$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;

$result = db_query($sql);
//$reccnt = db_scalar($sql_count);
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Pin Code Summary List </div></td>
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
 		    <td class="tdLabel">Username</td>
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
            <td>&nbsp;</td>
                 <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
              <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                 <td align="right">&nbsp;</td>
                 <td>&nbsp;</td>
		   </tr>
        </table>
     </form>
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
				<th width="6%" align="left" nowrap="nowrap">ID </th>
				<th width="6%" align="left" nowrap="nowrap">User ID <?= sort_arrows('u_id')?></th>
				<th width="9%" align="left" nowrap="nowrap">User Name <?= sort_arrows('u_username')?></th>
				<th width="9%" align="left" nowrap="nowrap">City <?= sort_arrows('u_city')?></th>
				<th width="8%" align="left" nowrap="nowrap">Mobile</th>
				<th width="22%" align="left" nowrap="nowrap">Status <?= sort_arrows('u_status')?></th>
				<th width="7%" align="left" nowrap="nowrap">Available Pin </th>
				<th width="15%" align="left" nowrap="nowrap">Used Pin </th>
				<th width="11%">Total Pin </th>
              </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	  $available  = db_scalar("select count(*) from ngo_code where code_userid='$u_id' and code_is='Available' ");
	  $used  = db_scalar("select count(*) from ngo_code where code_userid='$u_id' and code_is='Used'");
	if ($duplicate>=2) { $error='bgcolor="#FF2020"';$css='tdLabel'; }
	 $total_available +=  $available;
	 $total_used +=  $used;
 ?>
            <tr class="<?=$css?>"  <?=$error?>>
            <td nowrap="nowrap"><?=$u_id?></td>
            <td nowrap="nowrap"><?=$u_username?></td>
                        <td nowrap="nowrap"><?=$u_fname?></td>
                        <td nowrap="nowrap"><?=$u_city?></td> 
						 <td nowrap="nowrap"><?=$u_mobile?></td>
						<td nowrap="nowrap"><?=$u_status?></td>
                        <td nowrap="nowrap"><?=$available; ?></td>
                        <td nowrap="nowrap"><?=$used?></td>
                        <td align="center"><?=$available+$used?></td>
                </tr>
          <? }
?>
      <tr  >
            
						<td colspan="6" nowrap="nowrap" align="right">Total</td>
                        <td nowrap="nowrap"><?=$total_available; ?></td>
                        <td nowrap="nowrap"><?=$total_used?></td>
                        <td align="center"><?=$total_available+$total_used?></td>
                </tr>
	  
	  
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
