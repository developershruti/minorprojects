<?
require_once("../includes/surya.dream.php");
//print_r($_POST);
protect_admin_page2();
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql  = " from ngo_code_log  ";
$sql .= " where log_userid=0 ";
 
if (($log_datefrom!='') && ($log_dateto!='')) 		{$sql .= " and (log_date  between $log_datefrom  and  $log_dateto )";} 
  
if ($log_sent_userid!='') {
	$userid = db_scalar("select u_id from ngo_users where u_username = '$log_sent_userid'");
	$sql .= " and  log_sent_userid ='$userid' ";
 }
 
 
 
$order_by == '' ? $order_by = 'log_id' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;
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
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Available Pin   List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"><form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="892"><table width="72%"  border="0" align="center" cellpadding="1" cellspacing="1" class="tableSearch">
                      <tr align="center">
                        <th colspan="4">Search</th>
                      </tr>
                      <tr>
                        <td width="212" align="right" class="tdLabel">Receiver User ID:</td>
                        <td width="151"><input name="code_username" class="txtLight" type="text" value="<?=$code_username?>" /></td>
                        <td width="165"   align="right">&nbsp;</td>
                        <td width="112">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right" class="tdLabel">Issue Date From : </td>
                        <td><?=get_date_picker("log_datefrom", $log_datefrom)?></td>
                        <td align="right"><span class="tdLabel">Issue Date To : </span></td>
                        <td><?=get_date_picker("log_dateto", $log_dateto)?></td>
                      </tr>
                      <tr>
                        <td align="right" class="tdLabel">&nbsp;</td>
                        <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                          <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                        <td align="right"><span class="tdLabel">
                          <!--Plan:-->
                          </span></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  <td width="256" valign="top"></td>
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
                  <th width="8%" align="left" nowrap="nowrap">Issue Date</th>
                  <th width="11%" align="left" nowrap="nowrap">Rec Username</th>
                  <th width="11%" align="left" nowrap="nowrap">Total Pin Sent </th>
                  <th width="14%">Admin Login ID </th>
                  <th width="5%"> </th>
                 
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
 
 ?>
                <tr class="<?=$css?>">
                  <td nowrap="nowrap"><?=date_format2($log_date)?></td>
                  
                  <td nowrap="nowrap"><?=$log_sent_username?></td>
                  <td align="center"><?=$log_count?></td>
                  <td align="center"><?=$log_user?></td>
                  <td align="center"><a  href="code_list.php?log_id=<?=$log_id?>">Details</a></td>
                </tr>
                <? }
?>
              </table>
              <!--       <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding:2px"> 
			 <?
		//$sql ="select u_id , u_id from ngo_users where u_status='Active' order by u_username";  
		//echo make_dropdown($sql, 'u_id', $u_id,  'class="txtbox"  style="width:120px;"','--Dealocate Code --');
		?>
		<input style="width: 50px;" name="u_id"  type="text">        
		<input name="Alocate" type="image" id="Alocate" src="images/buttons/code_alocate.gif" onclick="return alocateConfirmFromUser('arr_code_ids[]')"/>
		<input name="Activate" type="image" id="Activate" src="images/buttons/activate.gif" onclick="return activateConfirmFromUser('arr_code_ids[]')"/>
		<input name="Deactivate" type="image" id="Deactivate" src="images/buttons/deactivate.gif" onclick="return deactivateConfirmFromUser('arr_code_ids[]')"/>
		<input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_code_ids[]')"/>
		</td>
          </tr>
        </table>-->
            </form>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? } ?>
      <? include("bottom.inc.php");?>
