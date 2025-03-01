<?
require_once("../includes/surya.dream.php");
 #print_r($_POST);
 protect_admin_page2();
 

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_referer, ngo_users   ";
$sql .= " where  ref_userid=u_id   ";

  
if ($check_type!='') {$sql .= " and  check_type ='$check_type' ";}
if ($check_rec_id!='') {$sql .= " and  check_rec_id ='$check_rec_id' ";}
if ($check_payment_mode!='') {$sql .= " and  check_payment_mode ='$check_payment_mode' ";}
 
 

$order_by == '' ? $order_by = 'ref_id' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 

$sql .= "order by $order_by $order_by2 ";

if ($export=='1') {
 	 $arr_columns =array('check_id'=>'AutoID','check_userid'=>'UserID','u_fname'=>'User Name','u_utype'=>'Post ID','u_mobile'=>'Mobile','check_type'=>'Cheque Type','check_bank'=>'Bank Name','check_amount'=>'Amount','check_date'=>'Cheque Date','check_cheque_no'=>'Cheque No','check_rec_id'=>'Rec id','check_rec_name'=>'Rec Name','check_rec_date'=>'Rec Date','check_contact'=>'Contact Number','check_status'=>'Status','check_for'=>'Payment For','check_closeid'=>'Closing ID','check_payment_mode'=>'Payment Mode');
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
          <td id="pageHead"><div id="txtPageHead"> PDC/General Cheque    List </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="left"><form method="get" name="form2" id="form2" action="cheque_list.php" onsubmit="return confirm_submit(this)">
           
              <table width="472"  border="0" align="center"  cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="4">Search</th>
                </tr>
                <tr>
                  <td class="tdLabel">User ID From/To </td>
                  <td><input name="check_id_from" type="text"style="width:50px;" value="<?=$check_id_from?>">
                      <input name="check_id_to" style="width:50px;"type="text" value="<?=$check_id_to?>" /></td>
                  <td align="right">Status</td>
                  <td> </td>
                </tr>
                 
                <tr>
                  <td class="tdLabel">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td align="right">&nbsp;</td>
                  <td><input name="export" type="checkbox" id="export" value="1" />
Export to CSV </td>
                </tr>
                <tr>
                  <td class="tdLabel">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
               
              </table>
              <br />

            </form>
            <div align="right">  <a href="cheque_f.php">Create New Cheque </a></div>
              <!--<a href="cheque_auto_f.php">Auto Generated PDC Cheque </a>&nbsp;|&nbsp;
            &nbsp;|&nbsp; <a href="cheque_import.php">Import Cheque List</a>&nbsp;|&nbsp; <a href="cheque_updated_import.php">Import Updated Cheque List</a></div>-->
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
            <!--action="cheque_print_single.php"-->
            <form method="post" name="form1" id="form1" >
              <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
                <tr>
                  <!-- <th width="5%" align="left" nowrap="nowrap">Sl No </th>-->
                  <th width="5%" align="left" nowrap="nowrap">User ID </th>
                  <th width="7%" align="left" nowrap="nowrap">Name </th>
                  <th width="8%" align="left" nowrap="nowrap">Mobile</th>
			      
                  <th width="16%" align="left" nowrap="nowrap">Message </th>
                  <th width="6%">Rec mobile. </th>
                  <th width="6%"   >Rec Date </th>
                  
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
	  
	
 ?>
                <tr class="<?=$css?>"  <?=$error?>>
                  <!-- <td nowrap="nowrap"><? //=$check_id?></td>-->
                  <td nowrap="NOWRAP"><?=$u_username?></td>
                  <td nowrap="NOWRAP"><?=$u_fname ?></td>
                  <td nowrap="NOWRAP"><?=$u_mobile?></td> 
                  <td nowrap="NOWRAP"><?=$ref_message?></td>
                  <td nowrap="NOWRAP"><?=$ref_contact?></td>
                  <td nowrap="NOWRAP"><?=$ref_date?></td>
                   
                </tr>
                <? }
?>
              </table>
              
            </form>
            <? }?>
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
