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
 
 <table width="800" border="0" cellspacing="1" cellpadding="1">
   <tr>
    <td colspan="6" height="1px" bgcolor="#333333"></td>
   </tr><tr>
    <td nowrap="nowrap" ><span class="style2">ID No</span></td>
    <td nowrap="nowrap" class="style2" >Name </td>
    <td nowrap="nowrap" class="style2" >Address</td>
    <td nowrap="nowrap" class="style2" >City</td>
    <td nowrap="nowrap" class="style2" >State</td>
    <td nowrap="nowrap" class="style2" >Contact No</td>
   </tr>
   <tr>
    <td colspan="6" height="1px" bgcolor="#333333"></td>
   </tr>
   <?
 while ($line_raw = mysqli_fetch_array($result)) {
	 @extract($line_raw);
 ?>
 
  <tr>
    <td width="10%" nowrap="nowrap" > <?=$u_id?> </td>
    <td width="21%" nowrap="nowrap" ><?=$u_fname ." ".$u_lname?></td>
    <td width="15%" ><?=$u_address?></td>
    <td width="18%" nowrap="nowrap" ><?=$u_city ?></td>
    <td width="18%" nowrap="nowrap" ><?=$u_state?></td>
    <td width="18%" nowrap="nowrap" ><?=$u_mobile?></td>
   </tr>
    <tr>
    <td colspan="6" height="1px" bgcolor="#cccccc"></td>
   </tr>
   <? } ?>
</table>
 