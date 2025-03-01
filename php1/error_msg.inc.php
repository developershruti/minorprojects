<?
@extract($_SESSION);
if(is_array($_SESSION['arr_error_msgs']) && count($_SESSION['arr_error_msgs'])>0) { ?>
<div class="alert alert-danger" role="alert">
<? foreach($_SESSION['arr_error_msgs'] as $err_msg){?><?=$err_msg?><br/><? }?></div>

<? } $_SESSION['arr_error_msgs']=''; ?>

<?  if(is_array($_SESSION['arr_success_msgs']) && count($_SESSION['arr_success_msgs'])>0) { ?>

<div class="alert alert-success" role="alert">
  <? foreach($_SESSION['arr_success_msgs'] as $success_msg){?><?=$success_msg?> <br/><? }?>
</div>
 
<? } $_SESSION['arr_success_msgs']=''; ?>