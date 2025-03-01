<?
require_once("../includes/surya.dream.php");
//print_r($_POST);
protect_admin_page2();
if(is_post_back()) {
	$arr_code_ids = $_REQUEST['arr_code_ids'];
	if(is_array($arr_code_ids)) {
		$str_code_ids = implode(',', $arr_code_ids);
		if(isset($_REQUEST['Delete']) || isset($_REQUEST['Delete_x']) ) {
			$sql = "delete from ngo_code where code_id in ($str_code_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update ngo_code set code_status = 'Active' where code_id in ($str_code_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update ngo_code set code_status = 'Inactive' where code_id in ($str_code_ids)";
			db_query($sql);
		} else if(isset($_REQUEST['Alocate']) || isset($_REQUEST['Alocate_x']) ) {
			$sql = "update ngo_code set code_userid = '$u_id'  where code_is='Available' and code_id in ($str_code_ids)";
			db_query($sql);
			 
		}
	}
	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
}


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_code  ";
$sql .= " where code_is='Used' ";
/*left join ngo_users on ngo_code.code_userid=ngo_users.u_id */


if ($code_user!='') 		{$sql .= " and code_user='$code_user' ";}
if ($code_status!='')		 	{$sql .= " and code_status='$code_status' ";}
if ($code_cate!='') 		{$sql .= " and code_cate='$code_cate' ";}
if (($code_id_from!='') && ($code_id_to!='')) 		{$sql .= " and (code_userid  between $code_id_from  and  $code_id_to )";}
else if (($code_id_from!='') && ($code_id_to=='')) 	{$sql .= " and  code_userid ='$code_id_from' ";}
#if (($code_slno_from!='') && ($code_slno_to!='')) 	{$sql .= " and (code_id>= $code_slno_from  and code_id<=$code_slno_to )";}
//if ($code_usefrom!='') {$sql .= " and  code_usefrom ='$code_usefrom' ";
if (($code_usefrom!='') && ($code_useto!='')) 		{$sql .= " and (code_usefrom  between $code_usefrom  and  $code_useto )";} 
if ($code_group!='') 		{$sql .= " and  code_group ='$code_group' ";}
//$sql = apply_filter($sql, $code_title, $code_title_filter,'code_title');

if ($code_username!='') {
	$userid = db_scalar("select u_id from ngo_users where u_username = '$code_username'");
	$sql .= " and  code_userid ='$userid' ";
 }
 
 if ($code_transfer_userid!='') {
	$transfer_userid = db_scalar("select u_id from ngo_users where u_username = '$code_transfer_userid'");
	$sql .= " and  code_transfer_userid ='$transfer_userid' ";
 }
//$sql = apply_filter($sql, $code_title, $code_title_filter,'code_title');


if ($u_sponsor_id!=''){
$u_userid = db_scalar("select u_id from ngo_users where u_username = '$u_sponsor_id'");
 
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
if ($id_in!='') {
		$sql .= " and code_userid in ($id_in)  "; 
 	}
  }
}




$order_by == '' ? $order_by = 'code_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$total_sql = $sql;
$sql .= "order by $order_by $order_by2 ";

if ($export=='1') {
 	//$arr_columns =array('code_cate'=>'code_cate','code_id'=>'code_id','code_string'=>'code_string','code_usefrom'=>'code_usefrom','code_useto'=>'code_useto','code_is'=>'code_is');
	$arr_columns =array('code_id'=>'code_id','code_cate'=>'code_cate','code_string'=>'code_string','code_is'=>'code_is','code_use_name'=>'code_use_name','code_use_userid'=>'code_use_userid','code_status'=>'code_status' ,'code_userid'=>'code_userid','code_date'=>'code_date','code_usefrom'=>'code_usefrom','code_useto'=>'code_useto','code_group'=>'code_group');	

	
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
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Used Code    List </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content">
             <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
        <br />
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="602"><table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
              <tr align="center">
                <th colspan="6">Search</th>
              </tr>
              <tr>
                <td width="131" align="right" class="tdLabel">Receive Username:</td>
                <td width="151"><input name="code_username" class="txtLight" type="text" value="<?=$code_username?>" /></td>
                <td   align="right">Transfer By  Username </td>
                <td width="124"><input name="code_transfer_userid" class="txtLight" type="text" value="<?=$code_transfer_userid?>" /></td>
                <td width="88" align="right"  >Downline UserID: </td>
                <td width="127"  ><input name="u_sponsor_id" type="text" value="<?=$u_sponsor_id?>" size="20" /></td>
              </tr>
              <tr>
                <td align="right" class="tdLabel">Auto User ID From/To : </td>
                <td><input name="code_id_from" type="text" class="txtLight" value="<?=$code_id_from?>" size="15" />
                    <input name="code_id_to" type="text" class="txtLight" value="<?=$code_id_to?>" size="15" /></td>
                <td width="117" align="right"><span class="tdLabel"> </span> E-Pin Group :</td>
                <td><input name="code_group" class="txtLight" type="text" value="<?=$code_group?>" /></td>
                <td align="right"><span class="tdLabel"> </span> Created By:</td>
                <td><input name="code_user" class="txtLight" type="text" value="<?=$code_user?>" /></td>
              </tr>
              <tr>
                <td align="right" class="tdLabel">Issue Date From : </td>
                <td><?=get_date_picker("code_usefrom", $code_usefrom)?></td>
                <td align="right"><span class="tdLabel">Issue Date To : </span></td>
                <td><?=get_date_picker("code_useto", $code_useto)?></td>
                <td align="right">Status  :</td>
                <td><select name="code_status">
                    <option value="" selected="selected">All</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select></td>
              </tr>
              <tr>
                <td align="right" class="tdLabel"><strong> E-Pin Type : </strong> </td>
                <td><?
		 $sql ="select utype_id , utype_name from ngo_users_type order by utype_id asc";  
		 echo make_dropdown($sql, 'code_cate', $code_cate,  'class="txtbox"  style="width:120px;"','--select--');
		?></td>
                <td align="right"><span class="tdLabel">
                  <!--Plan:-->
                  <?
			#echo array_dropdown( $ARR_PLAN_TYPE, $code_plan,'code_plan', 'class="txtbox"  style="width:120px;"','--select--');
			?>
                </span></td>
                <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                <td align="right">&nbsp;</td>
                <td><input name="export" type="checkbox" id="export" value="1" />
                  Export To CSV</td>
              </tr>
            </table></td>
            <td width="248" valign="top">
			<!--<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
              <?
			   
			  /*
			  $sql_post ="select utype_id , utype_name from ngo_users_type  where utype_status='Active' order by utype_id "; 
			  $result_post = db_query($sql_post);
			  while ($line_post = mysqli_fetch_array($result_post)) {
			  
			 // "select count(code_cate) from ngo_code where code_cate=$line_post[utype_id]"
			  ?>
 			  <tr>
                <td align="right"> 
                  <?=$line_post[utype_name] ?>
                : </td>
                <td>&nbsp;<strong> <?=$total_count = db_scalar("select count(code_cate) $total_sql  and code_cate=$line_post[utype_id]");?></strong> </td>
              </tr>
			  <? 
			  $gtotal += $total_count;
			  } */?>
			  <tr>
                <td align="right"> <span class="style1">
                 Grand Total
                : </span></td>
                <td class="txtTotal" nowrap="nowrap">&nbsp; <?=$gtotal;?> </td>
              </tr>
            </table>--></td>
          </tr>
        </table>
             </form>
  <!-- <div align="right"> <a href="code_f.php">Add New
         Code      </a></div>-->
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
             <th width="5%" align="left" nowrap="nowrap">Cat</th>
			  <th width="8%" align="left" nowrap="nowrap">Code slno </th>
			 <th width="14%" align="left" nowrap="nowrap">Code</th>
              <th width="5%" align="left" nowrap="nowrap">Code is</th>
			 <th width="12%" align="left" nowrap="nowrap">Used Name</th>
			 <th width="5%" align="left" nowrap="nowrap">Used ID</th>
			
             <th width="7%" align="left" nowrap="nowrap">Status            </th>
		     <th width="8%">AlocatedID </th>
		     <th width="18%">Issue Date </th> 
		     <th width="14%" align="left" nowrap="nowrap">Expire Date </th>
		     <th width="4%">Group</th>
		     <th width="6%">Created By </th>
		     <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	 
 ?>
          <tr class="<?=$css?>">
                        <td nowrap="nowrap"><?=$code_cate?></td>
						 <td nowrap="nowrap"><?=$code_id?></td>
						<td nowrap="nowrap"><?=$code_string?></td>
                         <td nowrap="nowrap"><?=$code_is?></td>
 						 <td nowrap="nowrap"><?=$code_use_name?></td>
						 <td nowrap="nowrap"><?=$code_use_userid?></td>
                        <td nowrap="nowrap"><?=$code_status?></td>
 						<td align="center"><?=$code_userid?></td>
						<td align="center"><?=$code_usefrom?></td>
 						<td align="center"><?=$code_useto?></td>
					    <td align="center"><?=$code_group?></td>
				        <td align="center"><?=$code_user?></td>
			        <td align="center"><input name="arr_code_ids[]" type="checkbox" id="arr_code_ids[]" value="<?=$code_id?>" /></td>
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
		<!--<input style="width: 50px;" name="u_id"  type="text">        
		<input name="Alocate" type="image" id="Alocate" src="images/buttons/code_alocate.gif" onclick="return alocateConfirmFromUser('arr_code_ids[]')"/> 
		<input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_code_ids[]')"/>
		<input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_code_ids[]')"/>
		 <input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_code_ids[]')"/>-->
		</td>
          </tr>
        </table>
            </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
