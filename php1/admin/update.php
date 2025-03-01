<?
require_once("../includes/surya.dream.php");

$sql = " select * from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id and u_status!='Banned' and topup_status!='Close' ";
$result = db_query($sql); 
while ($line_raw = mysqli_fetch_array($result)) {
	$line = ms_display_value($line_raw);
	@extract($line); 
 	$total_topup = db_scalar("select sum(topup_amount) from ngo_users_recharge where topup_userid='$u_id'");
 	$total_referer = db_scalar("select count(*) from ngo_users_recharge ,ngo_users  where ngo_users_recharge.topup_userid=ngo_users.u_id and u_status!='Banned' and topup_status!='Close'  and topup_amount>='$topup_amount' and u_ref_userid='$u_id'");
	
	
	if ($total_topup>=1000) {$topup_rate = 17;	 }else { $topup_rate = 15;}
	if ($total_referer>=2) { $topup_rate = $topup_rate +$total_referer;}
	if ($topup_rate>25) {$topup_rate=25;}
	print "<br> $topup_id topup_userid =$u_id , total_referer =$total_referer ,   topup amount =$topup_amount  , topup_rate= $topup_rate"; 
	$sql3 = "update ngo_users_recharge set topup_rate='$topup_rate' where topup_userid = '$u_id'  ";
	db_query($sql3);
	
}
?>
 