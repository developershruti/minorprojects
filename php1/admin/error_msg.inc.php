<?
@extract($_SESSION);
if(is_array($_SESSION['arr_error_msgs']) && count($_SESSION['arr_error_msgs'])>0) {?>

<!--<div class=" " style="color:#00ff49; text-shadow:#333333 1px 1px 1px; font-size:14px;"> -->
<div class="td_box" style="color: #ff0000; padding-left:5px; border: #ebebea solid 1px;  font-size:12px;"> 
<? foreach($_SESSION['arr_error_msgs'] as $err_msg){?>
 <?=$err_msg?><br />
<? }?>
 
</div>     


<? } $_SESSION['arr_error_msgs']=''; ?>