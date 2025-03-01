<?
include ("includes/surya.dream.php");
/*$pg='bioscinece';*/
/*echo "update ngo_users set u_online_status='Offline' where  u_id = '$_SESSION[sess_uid]'";
exit;*/
///$online_status = db_query("update ngo_users set u_online_status='Offline' where  u_id = '$_SESSION[sess_uid]'  ");
session_start();
session_destroy();
header("location: index.php");
 
?>