<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
  	


$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from ngo_receive where 1 ";
$sql .= "  and rece_amount >0 ";
// if ($u_id1!='' && $u_id2!='') {  $sql .= " and (u_id >= $u_id1 and u_id<=$u_id2)";   }

//$sql = apply_filter($sql, $u_fname, $u_fname_filter,'u_fname');
if (($datefrom!='') && ($dateto!='')){ $sql .= " and u_date between '$datefrom' AND '$dateto' "; }
//if ($u_utype!='') {  $sql .= " and u_utype='$u_utype' "; }  
  
	
if ($export1=='1') {
 	$arr_columns =array('u_id'=>'User ID','u_fname'=>'First Name','u_lname'=>'Last Name','u_address'=>'Address','u_date'=>'DOJ','offer_d'=>'D','offer_bd'=>'BD','offer_sd'=>'SD','offer_gd'=>'GD','offer_dd'=>'DD','offer_srdd'=>'SrDD','offer_rd'=>'RD','offer_rgd'=>'RGD' ,'offer_total_ref'=>'Total Refrer', 'u_phone'=>'Phone Number', 'u_mobile'=>'Mobile Number');
 	export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' );
	exit;
}
$sql .= " group by rece_rec_date ";
$order_by == '' ? $order_by = 'rece_rec_date' : true;
$order_by2 == '' ? $order_by2 = 'desc' : true;
$sql_count = "select count(*) ".$sql; 
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);

$reccnt = mysqli_num_rows($result);
//$reccnt = db_scalar($sql_count);
  
	 
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead"> Receive Payment summary </div></td>
        </tr>
      </table>
	 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="75%"  >
		   <form method="get" name="form2" id="form2" onsubmit="return confirm_submit(this)">
		  <table width="717"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
            <tr align="center">
              <th colspan="4">Search</th>
            </tr>
           <!-- <tr>
              <td width="112" align="right" class="tdLabel">User ID From/To:</td>
              <td width="135"><input name="u_id1" type="text" value="<?=$u_id1?>" size="8"   />
                <input name="u_id2" type="text" value="<?=$u_id2?>" size="8"   /></td>
              <td align="right">User Post: </td>
              <td width="158"><?
 		//$sql ="select utype_id , utype_name from ngo_users_type where utype_value>0 order by utype_id ";  
		//echo make_dropdown($sql, 'u_utype', $u_utype,  'class="txtbox"  style="width:120px;"','--Select Post--');
		?></td>
              <td width="206">&nbsp;</td>
            </tr>-->
            <tr>
				<td width="132" align="right">Receive Date  from: </td>
				<td width="146"><?=get_date_picker("datefrom", $datefrom)?></td>
				<td width="100"  align="right" valign="top">Receive Date To: </td>
				<td width="321"><?=get_date_picker("dateto", $dateto)?></td>
              <input type="hidden" name="u_id" value="<?=$u_id?>"/>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td  align="right" valign="top">&nbsp;</td>
              <td><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" />
                <input type="image" name="imageField" src="images/buttons/search.gif" /></td>
              </tr>
          </table>
		  </form>
		  </td>
		  <td align="center">&nbsp; </td>
        </tr>
      </table>
    
	
    <div class="msg"><?=$msg?></div>
      <br/>
            <div align="right"></div>
      <? if(mysqli_num_rows($result)==0){?>
      <div class="msg">Sorry, no records found.</div>
      <? } else{ 
	  ?>
      <div align="right"><a href="reward_auto_f.php">  </a> &nbsp;&nbsp;&nbsp;Showing Records: <?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of <?= $reccnt?> </div>
      <div>Records Per Page: <?=pagesize_dropdown('pagesize', $pagesize);?> </div>
       <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
        <br />
         <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
          <tr>
            <th width="54" nowrap="nowrap">Receive Date 
              <?= sort_arrows('rece_rec_date')?></th>
            <th width="1" nowrap="nowrap"> D(Entry - Amount) </th>
            <th width="1" nowrap="nowrap"> BD(Entry - Amount) </th>
            <th width="1" nowrap="nowrap"> SD(Entry - Amount) </th>
            <th width="1" nowrap="nowrap">GD(Entry - Amount) </th>
            <th width="1" nowrap="nowrap"> DD(Entry - Amount) </th>
            <th width="1" nowrap="nowrap"> SDD(Entry - Amount) </th>
            <th width="1" nowrap="nowrap">RD(Entry - Amount)</th>
            <th width="1" nowrap="nowrap">RGD(Entry - Amount)</th>
            <th width="1" nowrap="nowrap">  Total(Entry - Amount)</th>
            <th width="1">&nbsp;</th>
            <th width="1"><input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
          </tr>
          <?
while ($line_raw = mysqli_fetch_array($result)) {
  	$css = ($css=='trOdd')?'trEven':'trOdd';
 	  $sql_det =" select u_utype, count(u_utype)as totaluser, sum(rece_amount) as totalamount  from ngo_receive, ngo_users where rece_userid=u_id and rece_rec_date='$line_raw[rece_rec_date]'  group by rece_rec_date,u_utype";
	  $result_det = db_query($sql_det);
	  
	  $rec_user_total=0;
	  $rec_amount_total=0;
	  while ($line_det = mysqli_fetch_array($result_det)) {
	  if($line_det[u_utype]==1){ $receive_d =$line_det[totaluser].' - '.$line_det[totalamount];}
	  else if($line_det[u_utype]==2){ $receive_bd =$line_det[totaluser].' - '.$line_det[totalamount];}
	  else if($line_det[u_utype]==3){ $receive_dd =$line_det[totaluser].' - '.$line_det[totalamount];}
	  else if($line_det[u_utype]==4){ $receive_gd =$line_det[totaluser].' - '.$line_det[totalamount];}
	  else if($line_det[u_utype]==5){ $receive_dd =$line_det[totaluser].' - '.$line_det[totalamount];}
	  else if($line_det[u_utype]==6){ $receive_srdd =$line_det[totaluser].' - '.$line_det[totalamount];}
	  else if($line_det[u_utype]==7){ $receive_rd =$line_det[totaluser].' - '.$line_det[totalamount];}
	  else if($line_det[u_utype]==8){ $receive_rgd =$line_det[totaluser].' - '.$line_det[totalamount];}
	  
	 $rec_user_total += $line_det[totaluser];
	 $rec_amount_total += $line_det[totalamount];
	  }
	  $receive_total = $rec_user_total.' - '.$rec_amount_total;
?>
          <tr class="<?=$css?>">
            <td nowrap="nowrap"><?=date_format2($line_raw[rece_rec_date])?></td>
            <td align="left" nowrap="nowrap"><?=$receive_d?>  </td>
            <td align="center" nowrap="nowrap"><?=$receive_bd?></td>
            <td align="center" nowrap="nowrap"><?=$receive_sd?></td>
            <td align="center" nowrap="nowrap"><?=$receive_gd?></td>
            <td align="center" nowrap="nowrap"><?=$receive_dd?></td>
            <td align="center" nowrap="nowrap"><?=$receive_srdd?></td>
            <td align="center" nowrap="nowrap"><?=$receive_rd?></td>
            <td align="center" nowrap="nowrap"><?=$receive_rgd?></td>
            <td align="center" nowrap="nowrap"><?=$receive_total?></td>
            <td align="center"><a href="../admrgn/offer_referer_f.php?offer_id=<?=$offer_id?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
            <td align="center"><input name="arr_u_ids[]" type="checkbox" id="arr_u_ids[]" value="<?=$u_id?>"/></td>
           </tr>
          <? }
?>
        </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" valign="top" style="padding:2px">
					<!--         -->
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
				  <td align="right" valign="top" style="padding:2px">
				    <table  border="0" align="right" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="288" align="right" class="tdData">Reward :
                          <input type="text" name="offer_reward_update" value="<?=$offer_reward_update?>" /></td>
                      </tr>
                    </table>
				    <br />					</td>
					
					 <td align="right" valign="top" style="padding:2px"><input name="Deactivate" type="image" id="Deactivate" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_u_ids[]')"/>   </td>
                  </tr>
				  </table>
					<!--         -->
					</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top" style="padding:2px">
					
				<!--	<input name="Featured" type="image" id="Featured" src="images/buttons/featured.gif" onclick="return featuredConfirmFromUser('arr_u_ids[]')"/>
                    <input name="Unfeatured" type="image" id="Unfeatured" src="images/buttons/unfeatured.gif" onclick="return UnfeaturedConfirmFromUser('arr_u_ids[]')"/><input name="Delete" type="image" id="Delete" src="images/buttons/delete.gif" onclick="return deleteConfirmFromUser('arr_u_ids[]')"/>-->


                    </td>
                  </tr>
        </table>
		  <? }
?>
      </form>
    <? include("paging.inc.php");?> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
