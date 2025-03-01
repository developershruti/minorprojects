<?
@extract($_SESSION);
if(is_array($_SESSION['arr_error_msgs']) && count($_SESSION['arr_error_msgs'])>0) { ?>

<? foreach($_SESSION['arr_error_msgs'] as $err_msg){?><div class="alert alert-danger" role="alert"><?=$err_msg?></div><? }?>

<? } $_SESSION['arr_error_msgs']=''; ?>

<?  if(is_array($_SESSION['arr_success_msgs']) && count($_SESSION['arr_success_msgs'])>0) { ?>

 
  <? foreach($_SESSION['arr_success_msgs'] as $success_msg){?><div class="alert alert-success" role="alert"><?=$success_msg?></div> <? }?>
 
 
<? } $_SESSION['arr_success_msgs']=''; ?>

<? if($msgs!=''){ ?>
<div class="alert alert-danger" role="alert"> <?=$msgs?></div>
<? } ?> 