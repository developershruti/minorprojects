<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
///print_r($_SESSION);
//$sql  = "select u_id, u_fname ,u_lname ,u_address ,u_phone from ngo_users_payout ,ngo_users where ngo_users_payout.upay_userid=ngo_users.u_id group by u_id, upay_for order by u_id asc limit 0, 20 ";  
$sql =  $_SESSION['sql_add'];
$result = db_query($sql);
?>
 <script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
 <style type="text/css">
<!--
.style2 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; }
-->
 </style>
 
 <table width="90%" border="0" cellpadding="1" cellspacing="0" bgcolor="f8f8f8">
  <tr>
    <td class="style2" >User ID </td>
    <td class="style2" >Name </td>
    <td class="style2" >Closing No. </td>
    <td class="style2" >Total Refe. </td>
    <td class="style2" >&nbsp;</td>
  </tr>
  <?
 while ($line_raw = mysqli_fetch_array($result)) {
	 @extract($line_raw);
 ?>
 
  <tr>
    <td width="9%" >  <?=$u_id?> </td>
    <td width="32%" ><?=$u_fname ." ".$u_lname?></td>
    <td width="9%" ><?=$u_closeid?></td>
    <td width="41%" ><?=db_scalar("select count(u_ref_userid) from ngo_users where u_ref_userid='$u_id'");?></td>
    <td width="9%" >&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="5" height="1" bgcolor="#FFFFFF"> </td>
	</tr>
   <? } ?>
</table>
 