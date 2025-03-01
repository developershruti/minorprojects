<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
if(is_post_back()) {
 
  if (isset($_REQUEST['Update']) || isset($_REQUEST['Update_x']) ) {
 
		  	$sql_gen = "select * from ngo_users_bid  where  bid_plan='$bid_plan' and bid_date='$bid_date' and bid_status='Win' ";
 			$result_gen = db_query($sql_gen);
			while($line_gen = mysqli_fetch_array($result_gen)) {
  				@extract($line_gen);
			
			//print "<br> =  $draw_status : $bid_number : $bid_draw_no"; 
			
			$today_count = db_scalar("select count(pay_id) from ngo_users_payment where pay_topupid='$bid_id' and pay_plan='WINING_BONUS'   and pay_userid = '$bid_userid' ");
		if ($today_count==0) {
				if ($bid_plan==1 ) {$pay_rate = 40; } 
				else if ($bid_plan==2 ) {$pay_rate = 60; }
				else if ($bid_plan==3 ) {$pay_rate = 100; }
		  		$pay_amount = ($bid_amount/100) * $pay_rate;
				if($pay_amount>0){
				$msg.= $u_id.' ,';
				$pay_for ="Bonus on winning Bid No $bid_draw_no, Dated : $line_gen[bid_date] ";
				 $sql = "insert into ngo_users_payment set pay_group='WORKING', pay_drcr='Cr', pay_userid = '$bid_userid',pay_refid = '$bid_draw_no' ,pay_topupid='$bid_id' ,pay_plan='WINING_BONUS'   ,pay_for = '$pay_for' ,pay_ref_amt='$bid_amount' ,pay_unit = '%' ,pay_rate = '$pay_rate', pay_amount = '$pay_amount' ,pay_date=ADDDATE('$bid_date',INTERVAL 18 DAY) ,pay_datetime =ADDDATE(now(),INTERVAL 750 MINUTE),pay_admin='$_SESSION[sess_admin_login_id]' ";
				 
				db_query($sql);
				
				}
				
  			} 
				/////////////////////////
			  
   			} 
 		}
 	#header("Location: ".$_SERVER['HTTP_REFERER']);
	#exit;
 } 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Biding Summary  </div></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content"> 
            <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
              <table width="500"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                <tr align="center">
                  <th colspan="2">Search</th>
                </tr>
                <tr>
                  <td width="125" align="right" class="tdLabel"><span class="td_box">Bidding  Module<span class="error">*</span></span></td>
                  <td width="365"><span class="td_box">
                    <?
 						 $sql ="select  utype_id, utype_name from ngo_users_type where utype_status='Active'   ";  
						echo make_dropdown($sql, 'bid_plan', $bid_plan,  'class="txtbox" style="width:200px;" alt="select" emsg="Please Select Pin "', 'Please select');
							?>
                  </span></td>
                </tr>
                <tr>
                  <td  align="right" valign="top">Bid Date </td>
                  <td><?=get_date_picker("bid_date", $bid_date)?></td>
                </tr>
               
                <tr>
                  <td align="right">&nbsp;</td>
                  <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                    <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
                </tr>
              </table>
            </form>
			 
         
            <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
              <table width="500"  border="0" align="center" cellpadding="0" cellspacing="1" class="tableList">
                <tr>
                  <th width="174" align="center" >Biding No</th>
					<th width="204" align="center" >Bider Count </th>
					<th width="204" align="center" >Biding Total Amount </th>
			    </tr>
                <?
				//,  bid_number 
	$sql = "select sum(bid_amount) as total_amount, count(*) as total_bidder from ngo_users_bid   where bid_plan='$bid_plan' and bid_date='$bid_date' and bid_status='Win' group by bid_plan ";
	$result = db_query($sql);
	while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line);
  	$css = ($css=='trOdd')?'trEven':'trOdd';
  ?>
	<tr class="<?=$css?>">
		<td align="center" nowrap="nowrap"><?=$bid_number?> </td>
		<td align="center" nowrap="nowrap"><?=$total_bidder?> </td>
		<td align="center" nowrap="nowrap"><?=$total_amount?></td>
	</tr>
  <? }  ?>
              </table>
           <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
				 <td align="right" valign="middle" nowrap="nowrap"  >  </td>
 				    <td align="left" valign="middle" nowrap="nowrap"  >
					<input name="bid_date" type="hidden" id="bid_date" value="<?=$bid_date?>" />
					<input name="bid_plan" type="hidden" id="bid_plan" value="<?=$bid_plan?>" />
					 </td> 
                </tr>
                
                <tr>
                  <td  align="center" valign="middle" nowrap="nowrap"  >Submit to create Winner Bonus</td>
                  <td align="left" valign="middle" nowrap="nowrap"  ><input name="Update" type="image" id="Update" src="images/buttons/submit.gif"  /></td>
                </tr>
              </table>  
            </form>
            
            <? include("paging.inc.php");?>
          </td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
