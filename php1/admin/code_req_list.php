<?
require_once("../includes/surya.dream.php");
//print_r($_POST);
protect_admin_page2();
if(is_post_back()) {
	$arr_creq_ids = $_REQUEST['arr_creq_ids'];
	if(is_array($arr_creq_ids)) {
		$str_creq_ids = implode(',', $arr_creq_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			 $sql = "delete from ngo_code_req where creq_id in ($str_creq_ids)";
			 db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			//$sql = "update ngo_code set code_status = 'Active' where creq_id in ($str_creq_ids)";
			//db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			//$sql = "update ngo_code set code_status = 'Inactive' where creq_id in ($str_creq_ids)";
			//db_query($sql);
		} else if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ) {
			$sql = "update ngo_code_req set creq_status = '$status' , creq_user='$_SESSION[sess_admin_login_id]' where creq_id in ($str_creq_ids)";
			db_query($sql);
			
			 
		}
	}
	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
}

//$sql = "select *  from ngo_code_req inner join ngo_users on ngo_code_req.creq_userid=ngo_users.u_id  and creq_userid='$_SESSION[sess_uid]'  order by creq_id desc ";

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_code_req inner join ngo_users on ngo_code_req.creq_userid=ngo_users.u_id ";
 /*left join ngo_users on ngo_code.code_userid=ngo_users.u_id */
if ($creq_status!='') {$sql .= " and creq_status='$creq_status' ";}
if (($creq_id_from!='') && ($creq_id_to!='')) {$sql .= " and (creq_userid  between $creq_id_from  and  $creq_id_to )";}
 
//$sql = apply_filter($sql, $code_title, $code_title_filter,'code_title');

$order_by == '' ? $order_by = 'creq_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$total_sql = $sql;
$sql .= "order by $order_by $order_by2 ";

/*if ($export=='1') {
 	$arr_columns =array('code_cate'=>'code_cate','creq_id'=>'creq_id','code_string'=>'code_string','code_usefrom'=>'code_usefrom','code_useto'=>'code_useto','code_is'=>'code_is');
	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}*/


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
       Code    Request List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table width="602" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="602"><table  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
              <tr align="center">
                <th colspan="4">Search</th>
              </tr>
              <tr>
                <td width="79" class="tdLabel">User ID From </td>
                <td width="120"><input name="creq_id_from" type="text"style="width:60px;" value="<?=$creq_id_from?>" />                </td>
                <td width="76">User ID To</td>
                <td width="195"><input name="creq_id_to" style="width:60px;"type="text" value="<?=$creq_id_to?>" />                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                <td align="right">Status </td>
                <td>
				<?=checkstatus_dropdown('creq_status',$creq_status)?>
				 </td>
                 
              </tr>
            </table></td>
            </tr>
        </table>
             </form>
  <!-- <div align="right"> <a href="code_f.php">Add New Code </a></div>-->
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
           <th width="8%"   align="left" nowrap="nowrap">Req ID </th>
		   <th width="9%"   align="left" nowrap="nowrap">User ID </th>
             <th width="11%"  align="left" nowrap="nowrap">Req. Date </th>
			 <th width="5%"   align="left" nowrap="nowrap">Pin </th>
              <th width="12%" align="left" nowrap="nowrap">Pin Details </th>
			  <th width="12%"  align="left" nowrap="nowrap">Bank Name</th>
			  <th width="9%"   align="left" nowrap="nowrap">Amount</th>
               <th width="6%"   align="left" nowrap="nowrap">Date</th>
		      <th width="9%" >Status   </th>
		      <th width="6%"  >Slip</th> 
		      <!--<th width="6%"  align="left" nowrap="nowrap">&nbsp;</th>-->
		  
		     <th width="7%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 
 ?>
          <tr class="<?=$css?>">
            
                        <td nowrap="nowrap"><?=$creq_id?></td>
					    <td nowrap="nowrap"><?=$creq_userid?></td>
						<td nowrap="nowrap"><?=$creq_date?></td>
                         <td nowrap="nowrap"><?=$creq_pin?></td>
 						 <td ><?=$creq_pin_details?></td>
						 <td nowrap="nowrap"><?=$creq_bank?></td>
                        <td nowrap="nowrap"><?=$creq_amount?></td>
 						<td align="center"><?=$creq_bank_date?></td>
						<td align="center"> <?=$creq_status?> </td>
					    <td align="center"><? if($creq_receipt!='') { ?><a href="<?=UP_FILES_WS_PATH.'file:///E|/htdocs/receipt/'.$line['creq_receipt']?>" target="_blank">Slip</a><? } ?></td>
				   <!-- <td align="center"><a href="code_f.php?code_creqid=<?=$creq_id?>&amp;code_userid=<?=$creq_userid?>&amp;code_cunter=<?=$creq_pin?>">Send Pin</a></td>-->
					<td align="center"><input name="arr_creq_ids[]" type="checkbox" id="arr_creq_ids[]" value="<?=$creq_id?>" /></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"> 
			 <?
		//$sql ="select u_id , u_id from ngo_users where u_status='Active' order by u_username";  
		//echo make_dropdown($sql, 'u_id', $u_id,  'class="txtbox"  style="width:120px;"','--Dealocate Code --');
		?>
			 <?=checkstatus_dropdown('status',$status)?>
		       
		<input name="Submit" type="image" id="Submit" src="images/buttons/submit.gif" onclick="return alocateConfirmFromUser('arr_creq_ids[]')"/>
		
		<input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_creq_ids[]')"/>
		 </td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
