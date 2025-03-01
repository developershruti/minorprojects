<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
//print_r($_POST);
if(is_post_back()) {

//print_r($_POST);
 	$arr_u_ids = $_REQUEST['arr_u_ids'];
	if(is_array($arr_u_ids)) {
		$str_u_ids = implode(',', $arr_u_ids);
			if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ){
			
			if ($msg_group!='SMS') {
				 $sql_update = "update   ngo_users  set  u_description='$sms_text'  where  u_id in ($str_u_ids)" ;
				db_query($sql_update);
 				}
				
			if ($sms_text!='') {
 				if ($msg_group!='NEWS') {
  				$sql_test = "select u_mobile from ngo_users  where u_mobile!='' and u_id in ($str_u_ids) ";
				$result_test = db_query($sql_test);
				$mobile = array();
				while ($line_test= mysqli_fetch_array($result_test)){
					$mobile[]='91'.$line_test[u_mobile];
				}
 				$mobilenumber = implode(",",$mobile);
				
				//send sms to user 
				$message = $sms_text;
			 	$msg = send_sms($mobilenumber,$message);
				 
			 }
   			}
 		}
	}	 
	//header("Location: ".$_SERVER['HTTP_REFERER']);
	//exit;
 }

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_users ";
$sql .= " where  u_mobile!=''  ";
//   u_id in (select u_id from  ngo_users where u_mobile!='' group by u_mobile)
if ($u_id1!='' && $u_id2!='') { $sql .= " and (u_id >= $u_id1 and u_id<=$u_id2) ";}
$sql = apply_filter($sql, $u_fname, $u_fname_filter,'u_fname');

 $sql .= " group by u_mobile  ";

if ($export=='1') { 
 	$arr_columns =array('u_id'=>'Auto ID','u_username'=>'User ID','u_ref_userid'=>'Referer ID' ,'u_fname'=>'First Name' ,'u_address'=>'Address' ,'u_mobile'=>'Mobile' );
 	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}


$order_by == '' ? $order_by = 'u_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "   order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
 
$result_paging = db_query("select  count(*) from  ngo_users where u_mobile!=''  group by u_mobile   ");
$reccnt  = mysqli_num_rows($result_paging);
//$reccnt = db_scalar("select  count(*) from  ngo_users where u_mobile!=''  group by u_mobile   " );

//u_id in (select u_id from  ngo_users where u_mobile!='' group by u_mobile) 


?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Send SMS to User </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content"><form method="post" name="form2" id="form2" onsubmit="return confirm_submit(this)">
      <table width="316"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
          <tr align="center">
            <th>&nbsp;</th>
            <th>Search</th>
            </tr>
                   <tr>
                     <td align="center" class="tdLabel">User ID </td>
                     <td><input name="u_id1" type="text" value="<?=$u_id1?>" size="10" />
                     TO
                     <input name="u_id2" type="text" value="<?=$u_id2?>" size="10" /></td>
                   </tr>
                   <tr>
            <td width="63" align="center" class="tdLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</td>
            <td width="243"><input name="u_fname" type="text" value="<?=$u_fname?>" />
            <?=filter_dropdown('u_fname_filter', $u_fname_filter)?></td>
            </tr>
                   <tr>
                     <td align="center">&nbsp;</td>
                     <td><input name="export" type="checkbox" id="export" value="1" />
Export User List</td>
                   </tr>
                   <tr>
                     <td align="center">&nbsp;</td> <input type="hidden" name="u_id" value="<?=$u_id?>"/>
                     <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                       <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                   </tr>
        </table>
     </form>
	 <div align="center" class="errorMsg"><?=$msg?></div>
      <br/>
            <div align="right"></div>
      <? if(mysqli_num_rows($result)==0){?>
      <div class="msg">Sorry, no records found.</div>
      <? } else{ 
	  $sql_active_user="select count(*) as total_active_user from ngo_users where u_status='Active'";
	  $result_active_user=db_query($sql_active_user);
	  if(mysqli_num_rows($result_active_user)>0){
	  $row_active_user=mysqli_fetch_array($result_active_user);
	  }
	  $inactive_user=$reccnt-$row_active_user['total_active_user'];
	  ?>
	  <div align="left"><strong>Total Users:&nbsp;<?=$reccnt ?>&nbsp;&nbsp; &nbsp;</strong></div>
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
            <th width="8%" nowrap="nowrap">Sl No </th>
			  <th width="8%" nowrap="nowrap">User ID </th>
           
            <th width="15%" nowrap="nowrap"> Name
              <?= sort_arrows('u_fname')?></th>
            <th width="12%" nowrap="nowrap">Mobile </th>
            <th width="30%" nowrap="nowrap">Address
              <?= sort_arrows('u_ip')?></th>
           
            <th width="9%" nowrap="nowrap">Status
              <?= sort_arrows('u_status')?></th>
            <th width="4%"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	$user_full_name=$u_fname." ".$u_lname;
	$ctr++;
?>
          <tr class="<?=$css?>">
		  <td nowrap="nowrap"><?=$ctr?></td>
            <td nowrap="nowrap"><?=$u_id?></td>
             
            <td nowrap="nowrap">  <?=$user_full_name?> </td>
            <td nowrap="nowrap"><?=$u_mobile?></td>
            <td ><?=$u_address?></td>
           
            <td nowrap="nowrap"><?=$u_status?></td>
            <td align="center"><input name="arr_u_ids[]" type="checkbox" id="arr_u_ids[]" value="<?=$u_id?>"/></td>
                </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" style="padding:2px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="53%" align="right"><br />
SMS Text: </td>
                        <td width="34%" align="left"><textarea name="sms_text" cols="60" rows="3"><?=$sms_text?></textarea></td>
                        <td width="11%" align="right">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="right"> Message Group : </td>
                        <td align="left"><label>
                          <select name="msg_group">
                            <option value="SMS">SMS Only</option>
                            <option value="BOTH">SMS and Breaking New</option>
                            <option value="NEWS">Breaking News Only</option>
                          </select>
                        </label></td>
                        <td align="right">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="left"><input name="Submit" type="image" id="Featured" src="images/buttons/submit.gif"  /></td>
                        <td align="right">&nbsp;</td>
                      </tr>
                      
                    </table></td>
                  </tr>
                  <tr>
                    <td align="right" style="padding:2px"><!--	<input name="Featured" type="image" id="Featured" src="images/buttons/featured.gif" onclick="return featuredConfirmFromUser('arr_u_ids[]')"/>
                    <input name="Unfeatured" type="image" id="Unfeatured" src="images/buttons/unfeatured.gif" onclick="return UnfeaturedConfirmFromUser('arr_u_ids[]')"/><input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_u_ids[]')"/>--></td>
                  </tr>
        </table>
       
      </form>
    <? }?>      <? include("paging.inc.php");?>    </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
