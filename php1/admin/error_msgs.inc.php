  <? if(is_array($arr_error_msgs) && count($arr_error_msgs)>0) {?>
  <div class="errorMsg" style="font-size:12px;"> 
  <? foreach($arr_error_msgs as $err_msg){?>
  <br><?=$err_msg?> 
  <? }?>
  </div>
  <? }?>