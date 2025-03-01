<?
set_time_limit(0);
require_once('../includes/surya.dream.php');
protect_admin_page2();
 #print_r($_POST);
 

 if(is_post_back()) {
if($pay_group !='' && $pay_amount!='') {

  //$dateto = db_scalar("select DATE_FORMAT(ADDDATE(now(),INTERVAL  570 MINUTE), '%Y-%m-%d')");


$datefrom ='2020-01-01';
$sql_test = "select u_username,u_id,u_ref_userid,ngo_users_recharge.* from ngo_users,ngo_users_recharge where  u_id=topup_userid  and u_status!='Block' and topup_status='Paid' and topup_amount='$topup_amount' ";

//$sql_test = "select u_id,u_username,topup_id,topup_userid,topup_amount,topup_status,topup_date from  ngo_users,ngo_users_recharge  where topup_userid=u_id and topup_amount='$topup_amount' ";

if ($u_id1!='' && $u_id2!='') 	{  $sql_test .= " and (u_id >= $u_id1 and u_id<=$u_id2)";  }
if ($datefrom!='' && $dateto!='') 	{  $sql_test .= " and topup_date between '$datefrom' AND '$dateto' ";  } 
$sql_test .= " and u_id not in (select pay_userid from ngo_users_payment where pay_plan='$pay_group' and pay_plan_level='$pay_plan_level')  "; 

print $sql_test;
$result_test = db_query($sql_test);
while ($line_test= mysqli_fetch_array($result_test)){
@extract($line_test);
if ($u_id!='' && $pay_amount>0 ) { 
 
//////////////////

  $payout_count=db_scalar("select count(*) from ngo_users_payment where  pay_userid = '$topup_userid' and pay_plan_level='$pay_plan_level' and pay_plan='$pay_group' and pay_group='$pay_group'   ");
  
  if ($payout_count==0) {
  $pay_amount = $pay_amount;  ///form amount 
  $pay_rate=100;
  $pay_drcr = 'Cr';
  $msg.= $u_id.' ,';
  
  //print "<br> ===> $topup_userid | $pay_amount";
       // $u_parent_id = db_scalar("select pay_id from ngo_users_payment  order by pay_id desc limit 0,1")+1;
        $pay_id_refno =  'R'.rand(100,999).$u_parent_id.rand(100,999);
        $pay_for = $ARR_AUTO_POOL_INCOME_GROUP[$pay_group]." - Level $pay_plan_level ";  //"Auto Pool Pro Club Level $pay_plan_level Income "; //. 
        $sql22 = "insert into ngo_users_payment set  pay_id_refno='$pay_id_refno',  pay_drcr='$pay_drcr',  pay_userid = '$topup_userid'  ,pay_group='$pay_group',pay_plan='$pay_group',pay_plan_level='$pay_plan_level' ,pay_for = '$pay_for' ,pay_ref_amt='$pay_amount' ,pay_unit = 'F' ,pay_rate = '100', pay_amount = '$pay_amount',pay_status='Paid' ,pay_date='$payment_date' ,pay_datetime =ADDDATE(now(),INTERVAL 330 MINUTE) ";
        $result = db_query($sql22);
        
 
  
  }
////////////////////  
   
	}
   
}
}	 

} 
 
 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
      <?php include("../includes/fvalidate.inc.php");?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="pageHead"><div id="txtPageHead">Pool Income Create </div></td>
        </tr>
      </table>
      <div align="right"><a href="users_payment_list.php">Back to Payment List</a>&nbsp;</div>
      <div align="left" class="errorMsg"><?=$msg?></div>
      <form name="form1" method="post" enctype="application/x-www-form-urlencoded" <?= validate_form()?>>
	  <table width="35%" border="0" align="left" cellpadding="0" cellspacing="0" class="tableList" style="float:center; background:#FFE7BC; border:solid 1px #FFA500; margin-top:5px;">
                <tr>
                  <th width="8%" colspan="3" style="background:#FFA500" >  Pool Income  Create</th>
                </tr>
                            <tr>
            <td align="right" class="tdLabel">Auto ID From/To : </td>
            <td  ><input name="u_id1" style="width:120px;" type="text" value="<?=$u_id1?>" alt="number" emsg="Please enter user auto id from"  />  <input name="u_id2" style="width:120px;"type="text" value="<?=$u_id2?>" alt="number" emsg="Please enter user auto id to" />            </td>
          </tr>
          <tr>
          <td align="right"><span class="tdLabel">Topup Amount:</span></td>
                  <td><!--<input name="topup_amount" style="width:120px;"type="text" value="<?=$topup_amount?>" />-->
				  
				  <select name="topup_amount" class="form-control"  id="topup_amount" style="width:120px;"     alt="select" emsg="Please Select Package"  >

               <option value="" >Select Package</option>
				<option value="30" <? if($topup_amount==30) {?> selected="selected" <? } ?>>Activation $30.00</option>
				<option value="50" <? if($topup_amount==50) {?> selected="selected" <? } ?>>Upgrade $50.00</option> 
                <option value="100" <? if($topup_amount==100) {?>  selected="selected" <? } ?>>Upgrade $100.00</option>
                <option value="500" <? if($topup_amount==500) {?>  selected="selected" <? } ?>  >Upgrade $500.00</option>
               <option value="1000" <? if($topup_amount==1000) {?>  selected="selected" <? } ?>  >Upgrade $1000.00</option>
                <option value="2500" <? if($topup_amount==2000) {?>  selected="selected" <? } ?>  >Upgrade $2000.00</option>
               <option value="5000" <? if($topup_amount==4000) {?>  selected="selected" <? } ?>  >Upgrade $4000.00</option> 
             

              </select>
				  
				  </td></tr>


                <tr>
                  <td width="205" align="right" style="padding:5px;"><!--Transaction Type--> Pool Income Type : </td>
                  <td><?=array_dropdown($ARR_AUTO_POOL_INCOME_GROUP, $pay_group, 'pay_group');?>
                    &nbsp;&nbsp; </td>
                </tr>
                <tr>
                  <td width="205" align="right" style="padding:5px;">Payment For Level : </td>
                  <td><?=array_dropdown($ARR_CLUB_LEVEL, $pay_plan_level, 'pay_plan_level');?>
				  <!-- Level <? ///=$pay_plan_level;?>-->
				   
                    &nbsp;&nbsp; </td>
                </tr>
				  <tr>
                  <td width="205" align="right" style="padding:5px;">Send Club Achieved Amount : </td>
                  <td><input type="text" name="pay_amount" value="<?=$pay_amount?>" alt="number" emsg="Credit/debit amount can not be blank" />
                  </td>
                </tr>
                <tr>
				<td align="right"> Till Topup  Date : </td>
                  <td><?=get_date_picker("dateto", $dateto)?></td>
                <tr>
                <tr>
				<td align="right"> Payment Date : </td>
                  <td><?=get_date_picker("payment_date", $payment_date)?></td>
                <tr>
                  <td width="205" align="right" style="padding:5px;"></td>
                  <td width="86" align="left" style="padding:5px;"> <input name="Submit_Recharge" type="image" id="Submit_Recharge" src="images/buttons/submit.gif" onclick="return updateConfirmFromUser('arr_topup_ids[]')"/> <!--2020-02-26 temp comment--></td> 
                </tr>
              </table>
      </form>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="content">&nbsp;</td>
        </tr>
      </table>
      <? include("bottom.inc.php");?>
