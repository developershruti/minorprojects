<?
require_once("../includes/surya.dream.php");
//print_r($_POST);
if(is_post_back()) {
	$arr_contact_ids = $_REQUEST['arr_contact_ids'];
	if(is_array($arr_contact_ids)) {
		$str_contact_ids = implode(',', $arr_contact_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_contact_us where contact_id in ($str_contact_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_contact_us set code_status = 'Active' where contact_id in ($str_contact_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_contact_us set code_status = 'Inactive' where contact_id in ($str_contact_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Alocate']) || isset($_REQUEST['Alocate_x']) ) {
			$sql = "update ngo_contact_us set code_userid = '$u_id'  where code_is='Available' and contact_id in ($str_contact_ids)";
			db_query($sql);
			
			 
		}
	}
	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_contact_us  ";
$sql .= " where 1 ";
/*left join ngo_users on ngo_contact_us.code_userid=ngo_users.u_id */
if ($contact_name!='') {$sql .= " and contact_name like '%$contact_name%' ";}
 
//$sql = apply_filter($sql, $code_title, $code_title_filter,'code_title');

$order_by == '' ? $order_by = 'contact_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$total_sql = $sql;
$sql .= "order by $order_by $order_by2 ";
 

$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Complain  List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="602"><table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
              <tr align="center">
                <th colspan="3">Search</th>
              </tr>
              <tr>
                <td width="91" class="tdLabel">Name</td>
                <td width="150"><input name="contact_name" type="text" class="txtLight" value="<?=$contact_name?>" />                </td>
                <td width="83"></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                <td align="right">&nbsp;</td>
                <input type="hidden" name="contact_id" value="<?=$contact_id?>"/>
              </tr>
            </table></td>
            </tr>
        </table>
             </form>
   <div align="right"> <a href="code_f.php"> </a></div>
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
             <th width="13%" align="left" nowrap="nowrap">Name </th>
			  <th width="8%" align="left" nowrap="nowrap"><span class="maintxt">Mobile </span></th>
              <th width="16%" align="left" nowrap="nowrap"><span class="maintxt">Email </span></th>
			   <th width="16%" align="left" nowrap="nowrap"><span class="maintxt">City </span></th>
			  
			  <th width="33%" align="left" nowrap="nowrap"><span class="maintxt">Message </span></th>
			  <th width="8%" align="left" nowrap="nowrap"> Date </th>
		       <th width="3%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 
 ?>
          <tr class="<?=$css?>">
                        <td  ><?=$contact_name?></td>
                          <td  ><?=$contact_mobile?></td>
 						 <td  ><?=$contact_email?></td>
						  <td  ><?=$contact_subject?></td>
					      
				        <td align="left"><?=$contact_comments?></td>
					<td align="center"> <?=date_format2($contact_date)?> </td>
					<td align="center"><input name="arr_contact_ids[]" type="checkbox" id="arr_contact_ids[]" value="<?=$contact_id?>" /></td>
                </tr>
          <? }
?>
        </table>
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"> <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_contact_ids[]')"/> 
		</td>
          </tr>
        </table> 
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
