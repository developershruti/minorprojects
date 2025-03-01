<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
 
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;




$columns = "select pay_date ";
$sql = " from ngo_users_ewallet where pay_group='CW' and pay_plan='BIDING' ";
//and u_status='Active'
 
#if ($bid_gameno!='') 	{$sql .= " and bid_gameno='$bid_gameno' ";} 
#if ($bid_draw_no!='') 	{$sql .= " and bid_draw_no='$bid_draw_no' ";}
#if ($bid_date!='') 		{$sql .= " and bid_date='$bid_date' ";}
if (($datefrom!='') && ($dateto!='')){ $sql .= " and pay_date between '$datefrom' AND '$dateto' "; }

$sql .= "  group by pay_date  ";
 
$order_by == '' ? $order_by = 'pay_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= " order by $order_by $order_by2 ";

$sql 	.= "limit $start, $pagesize ";
$sql 	= $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);


?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Users Coin details </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="750"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="4">Advance Search</th>
                </tr>
                
                <tr>
                  <td width="118" align="right"> Date from: </td>
                  <td width="131"><?=get_date_picker("datefrom", $datefrom)?></td>
                  <td width="90"  align="right" valign="top">  Date To: </td>
                  <td width="128"><?=get_date_picker("dateto", $dateto)?></td>
                </tr>
                <tr>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                  <td  align="right" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </form>
			 <? if(mysqli_num_rows($result)==0){?>
             <div class="msg">Sorry, no records found.</div>
            <? } else{ 
 	  ?> 	
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
               
                  <th width="15%" >Trade Date</th>
                  <th width="33%" >Trade Amount </th>
 				  <th width="29%" >Wining Amount</th>
				  <th width="29%" >Difference</th>
                </tr>
                <?
while ($line_raw = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$line = ms_display_value($line_raw);
	@extract($line);
	$css = ($css=='trOdd')?'trEven':'trOdd';
 	$total_trade_amount  += $trade_amount= db_scalar("SELECT SUM(IF(pay_drcr='Dr',pay_amount,'')) as balance FROM ngo_users_ewallet where pay_group='CW' and pay_plan='BIDING' and pay_date='$pay_date' ");
	$total_trade_win 	 += $trade_win = db_scalar("SELECT  SUM(IF(pay_drcr='Cr',pay_amount,'')) as balance FROM ngo_users_ewallet where pay_group='CW' and pay_plan='TRADE_REWARD' and pay_date='$pay_date' ");
 	$trade_balance = $trade_amount - $trade_win;
	
	$total_trade_amount  += $trade_amount;
	$total_trade_win 	 += $trade_win;
	$total_grand_balance += $trade_balance;
	
	//$sql_history = "insert into ngo_users_bid_history set bid_gameno='$bid_gameno',  bid_draw_no = '$winning_number',bid_desc = '$bid_desc' ,bid_date =ADDDATE(now(),INTERVAL 330 MINUTE),bid_datetime =ADDDATE(now(),INTERVAL 330 MINUTE)";

	
  ?>
                <tr class="<?=$css?>">
 				  <td nowrap="nowrap"><?=$pay_date?></td>
                  <td nowrap="nowrap"><div align="center"><?=price_format($trade_amount)?></div></td>
                  <td nowrap="nowrap"><div align="center"><?=price_format($trade_win)?></div></td>
				  <td nowrap="nowrap"><div align="center"><?=price_format($trade_balance)?></div></td>
                </tr>
                <? }
?>

				<tr class="<?=$css?>">
 				  <td nowrap="nowrap"> <strong>Grand Summary :</strong> </td>
                  <td nowrap="nowrap"><div align="center"><strong><?=price_format($total_trade_amount)?></strong></div></td>
                  <td nowrap="nowrap"><div align="center"><strong><?=price_format($total_trade_win)?></strong></div></td>
				  <td nowrap="nowrap"><div align="center"><strong><?=price_format($total_grand_balance)?></strong></div></td>
                </tr>
              </table>
              
			  
            </form>
            
            <? }?>
            <? include("paging.inc.php");?>          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
