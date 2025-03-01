<?php include_once"../includes/surya.dream.php";


//print_r($_SESSION);
protect_admin_page2();



 
 ?>
<link href="styles.css" rel="stylesheet" type="text/css">
<?php include("top.inc.php");?>
<TABLE width="100%" border=0 align="center" cellPadding=0 cellSpacing=1 bgColor=#FD7D5F>
 <TR>
  <TD  
            align=left 
          height=38><TABLE cellSpacing=0 cellPadding=0 width="30%" border=0 >
    <TR >
     <TD align=left width="93%"><div class="tableForm" id="txtPageHead">Company Profit & Loss</div></TD>
    </TR>
   </TABLE></TD>
 </TR>
 <TR>
  <TD vAlign=top align=middle bgColor=#ffffff><TABLE width="100%" border=0 align="center" cellPadding=0 cellSpacing=0>
    <TBODY>
     <TR>
      <TD align=left><br />
       <form  name="search" method="get">
        <table width="800"   border="0" align="center"  cellpadding="5" cellspacing="5" class="tableList">
         <tr>
          <td>Topup from:</td>
          <td><?=get_date_picker("datefrom", $datefrom)?></td>
          <td>Topup To:</td>
          <td><?=get_date_picker("dateto", $dateto)?></td>
          <td ><input name="adfs" type="submit" class="wpcf7-form-control wpcf7-submit uk-button readon uk-button-primary"  value="Submit" />
          </td>
          <td>&nbsp;</td>
         </tr>
        </table>
       </form>
	    
       <table width="90%"   border="0" align="center"  cellpadding="5" cellspacing="5" class="tableList">
        <tr>
         <td align="right">
		 <div align="center"> <h1> Topup Details </h1></div>
		 <table width="90%"  border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" class="tableList" align="center">
           <tr class="tdhead">
            <th width="13%" align="center">Package Name </th>
            <th width="15%" align="right"> Total Plan Cost</th>
           </tr>
           <?
 				$sql_hc="SELECT topup_plan,  SUM(topup_amount) as plan_cost  FROM ngo_users_recharge where 1  ";
 				if (($datefrom!='') && ($dateto!='')){ $sql_hc.=" and topup_date between '$datefrom' AND '$dateto'  ";}
				$sql_hc.=" group by topup_plan order by topup_plan asc";
				
				$result_hc=db_query($sql_hc);
				if (mysqli_num_rows($result_hc)) { 
				while ($row_hc=mysqli_fetch_array($result_hc  ,MYSQLI_ASSOC)){
 				@extract($row_hc);
        $total_plan_cost+=$row_hc['plan_cost'];
  
 					  ?>
           <tr>
            <td align="right"  ><?php   echo   $row_hc['topup_plan'] ; ?></td>
            <td align="right"><?php   echo  price_format($row_hc['plan_cost']+0); ?>
            </td>
           </tr>
           <? } ?>
           <tr class="headSection" >
            <td align="right"  >Total :</td>
            <td align="right"  ><?php   echo  price_format($total_plan_cost+0); ?></td>
           </tr>
           <? } else {   ?>
           <tr>
            <td align="center" colspan="2"  height="50" class="error"><br>
             No Transaction Found </td>
           </tr>
           <? }   ?>
          </table></td>
         <td align="right">
		 <div align="center"> <h1> Income Details </h1></div>
		 <table width="90%"  border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" class="tableList" align="center">
           <tr class="tdhead">
            <th width="13%" align="center">Payout Name</th>
            <th width="15%" align="right"> Total Credit</th>
            <th width="15%" align="right"> Total Debit</th>
            <th width="15%" align="right"> Total Balance</th>
           </tr>
           <?
				$sql_hc2="SELECT pay_plan , SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit  , SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit , (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_payment  where pay_userid in (select u_id from ngo_users where u_status='Active') ";
				
				if (($datefrom!='') && ($dateto!='')){ $sql_hc2.=" and pay_date between '$datefrom' AND '$dateto'  ";}
				$sql_hc2.=" group by pay_plan ";
				
				$result_hc2=db_query($sql_hc2);
 				
				if (mysqli_num_rows($result_hc2)) { 
				while ($row_hc2=mysqli_fetch_array($result_hc2  ,MYSQLI_ASSOC)){
 				$grand_total_credit+=$row_hc2['credit'];
        $grand_total_debit+=$row_hc2['debit'];
        $grand_total_balance+=$row_hc2['balance'];
			 

 					  ?>
           <tr>
            <td align="right"  ><?php  echo  $row_hc2['pay_plan']   ; ?></td>
            <td align="right"  ><?php  echo  price_format($row_hc2['credit']+0); ?></td>
            <td align="right"  ><?php  echo  price_format($row_hc2['debit']+0); ?></td>
            <td align="right"  ><?php  echo  price_format($row_hc2['balance']+0); ?></td>
           </tr>
           <? } ?>
           <tr class="headSection" >
            <td align="right"  >   </td>
            <td align="right"  ><?php   echo  price_format($grand_total_credit+0); ?></td>
            <td align="right"  ><?php   echo  price_format($grand_total_debit+0); ?></td>
            <td align="right"  ><?php   echo  price_format($grand_total_balance+0); ?></td>
           </tr>
           <? } else {   ?>
           <tr>
            <td align="center" colspan="7" height="50" class="error"><br>
             No Transaction Found </td>
           </tr>
           <? }    ?>
          </table></td>
        </tr>
       </table>
	  
	    <table width="90%"   border="0" align="center"  cellpadding="5" cellspacing="5" class="tableList">
        <tr>
         <td align="left" width="50%"> 
		 <div align="center"> <h1> Deposit  Wallet Details </h1></div>
		  <table width="90%"  border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" class="tableList" align="center">
           <tr class="tdhead">
            <th width="13%" align="center">Group Name</th>
            <th width="15%" align="right"> Total Credit</th>
            <th width="15%" align="right"> Total Debit</th>
            <th width="15%" align="right"> Total Balance</th>
           </tr>
           <?
				$sql_cw="SELECT pay_group , SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit  , SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit , (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_group='DW' ";
				//pay_group='CW'
				if (($datefrom!='') && ($dateto!='')){ $sql_cw.=" and pay_date between '$datefrom' AND '$dateto'  ";}
				$sql_cw.=" group by pay_group ";
				
				$result_cw=db_query($sql_cw);
 				
				if (mysqli_num_rows($result_cw)) { 
					while ($row_cw=mysqli_fetch_array($result_cw  ,MYSQLI_ASSOC)){
					$grand_total_credit_cw+=$row_cw['credit'];
					$grand_total_debit_cw+=$row_cw['debit'];
					$grand_total_balance_cw+=$row_cw['balance'];
    ?>
           <tr>
            <td align="right"  ><?php  echo  $ARR_WALLET_GROUP[$row_cw['pay_group']]  ; ?></td>
            <td align="right"  ><?php  echo  price_format($row_cw['credit']+0); ?></td>
            <td align="right"  ><?php  echo  price_format($row_cw['debit']+0); ?></td>
            <td align="right"  ><?php  echo  price_format($row_cw['balance']+0); ?></td>
           </tr>
           <? } ?>
           <tr class="headSection" >
            <td align="right"  >   </td>
            <td align="right"  ><?php   echo  price_format($grand_total_credit_cw+0); ?></td>
            <td align="right"  ><?php   echo  price_format($grand_total_debit_cw+0); ?></td>
            <td align="right"  ><?php   echo  price_format($grand_total_balance_cw+0); ?></td>
           </tr>
           <? } else {   ?>
           <tr>
            <td align="center" colspan="7" height="50" class="error"><br>
             No Transaction Found </td>
           </tr>
           <? }    ?>
          </table> </td>
		  <td align="left" width="50%"> 
		 <div align="center"> <h1> Capital  Wallet Details </h1></div>
		  <table width="90%"  border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" class="tableList" align="center">
           <tr class="tdhead">
            <th width="13%" align="center">Group Name</th>
            <th width="15%" align="right"> Total Credit</th>
            <th width="15%" align="right"> Total Debit</th>
            <th width="15%" align="right"> Total Balance</th>
           </tr>
           <?
				$sql_cw="SELECT pay_group , SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit  , SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit , (SUM(IF(pay_drcr='Cr',pay_amount,''))-SUM(IF(pay_drcr='Dr',pay_amount,''))) as balance FROM ngo_users_ewallet where pay_group='CW'  ";
				//pay_group='CW'
				if (($datefrom!='') && ($dateto!='')){ $sql_cw.=" and pay_date between '$datefrom' AND '$dateto'  ";}
				$sql_cw.=" group by pay_group ";
				
				$result_cw=db_query($sql_cw);
 				
				if (mysqli_num_rows($result_cw)) { 
					while ($row_cw=mysqli_fetch_array($result_cw  ,MYSQLI_ASSOC)){
					$grand_total_credit_cw+=$row_cw['credit'];
					$grand_total_debit_cw+=$row_cw['debit'];
					$grand_total_balance_cw+=$row_cw['balance'];
    ?>
           <tr>
            <td align="right"  ><?php  echo  $ARR_WALLET_GROUP[$row_cw['pay_group']]  ; ?></td>
            <td align="right"  ><?php  echo  price_format($row_cw['credit']+0); ?></td>
            <td align="right"  ><?php  echo  price_format($row_cw['debit']+0); ?></td>
            <td align="right"  ><?php  echo  price_format($row_cw['balance']+0); ?></td>
           </tr>
           <? } ?>
           <tr class="headSection" >
            <td align="right"  >   </td>
            <td align="right"  ><?php   echo  price_format($grand_total_credit_cw+0); ?></td>
            <td align="right"  ><?php   echo  price_format($grand_total_debit_cw+0); ?></td>
            <td align="right"  ><?php   echo  price_format($grand_total_balance_cw+0); ?></td>
           </tr>
           <? } else {   ?>
           <tr>
            <td align="center" colspan="7" height="50" class="error"><br>
             No Transaction Found </td>
           </tr>
           <? }    ?>
          </table> </td>
        <!-- <td align="right" valign="top">&nbsp;
		 
		 <div align="center"> <h1>Total Issue Funds </h1></div>
		 <table width="90%"  border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" class="tableList" align="center">
           <tr class="tdhead">
            <th width="13%" align="center">Admin Fund</th>
            <th width="15%" align="right"> BTC Fund </th>
            <th width="15%" align="right"> Total Fund</th>
           </tr>
		   <?
		  /* $admin_fund = db_scalar("select sum(pay_amount) from ngo_users_ewallet where pay_drcr='Cr' and pay_plan = 'ADM_FUND'");
		    $admin_fund_debit = db_scalar("select sum(pay_amount) from ngo_users_ewallet where pay_drcr='Dr' and pay_plan = 'ADM_FUND'");
		   $btc_fund = db_scalar("select sum(pay_amount) from ngo_users_ewallet where pay_drcr='Cr' and pay_plan = 'BTC_RECEIVE'");
		   $withdraw_fund = db_scalar("select sum(pay_amount) from ngo_users_payment where pay_drcr='Dr' and pay_plan = 'BANK_WITHDRAW' and pay_status='Paid'");
		   $total_balance = ($admin_fund +$btc_fund) - $admin_fund_debit;*/
		   ?>x
		    <tr>
            <td align="right"  ><?php echo price_format($admin_fund +0);?></td>
            <td align="right"  ><?php echo price_format($btc_fund +0); ?></td>
            <td align="right"  ><?php  echo  price_format($total_balance); ?></td>
           </tr>
		   
		    <tr>
            <td align="right"  >Rs. <?php echo ($admin_fund*70); ?></td>
            <td align="right"  >Rs. <?php echo ($btc_fund*70) ; ?></td>
            <td align="right"  >Rs. <?php  echo  (($total_balance)*70); ?></td>
           </tr>
		   <tr>
            <td align="left" colspan="3"  > <strong>Total Withdraw Fund</strong></td>
           
           </tr>
		   <tr>
            <td align="right"  > <?php echo price_format($withdraw_fund); ?></td>
            <td align="right"  >Rs. <?php echo ($withdraw_fund*70) ; ?></td>
            <td align="right"  >Balance Rs : <?php  echo  ((($total_balance)-$withdraw_fund)*70); ?></td>
           </tr>
		   
		   </table>
		   
		 
		 
		 <div align="center"> <h1> Activation Wallet Details </h1></div>
		 <table width="90%"  border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" class="tableList" align="center">
           <tr class="tdhead">
            <th width="13%" align="center">Payout Name</th>
            <th width="15%" align="right"> Total Credit</th>
            <th width="15%" align="right"> Total Debit</th>
           </tr>
           <?
				/*$sql_hc2="SELECT pay_plan , SUM(IF(pay_drcr='Cr',pay_amount,'')) as credit  , SUM(IF(pay_drcr='Dr',pay_amount,'')) as debit FROM ngo_users_ewallet where pay_group='AW' ";
				
				if (($datefrom!='') && ($dateto!='')){ $sql_hc2.=" and pay_date between '$datefrom' AND '$dateto'  ";}
				$sql_hc2.=" group by pay_plan ";
 				$result_hc2=db_query($sql_hc2);
 				if (mysqli_num_rows($result_hc2)) { 
				while ($row_hc2=mysqli_fetch_array($result_hc2  ,MYSQLI_ASSOC)){
 				$grand_total_credit_aw+=$row_hc2['credit'];
				$grand_total_debit+=$row_hc2['debit'];
  			 ?>
           <tr>
            <td align="right"  ><?php  echo $ARR_WALLET_TYPE[$row_hc2['pay_plan']]  ; ?></td>
            <td align="right"  ><?php  echo  price_format($row_hc2['credit']+0); ?></td>
            <td align="right"  ><?php  echo  price_format($row_hc2['debit']+0); ?></td>
           </tr>
           <? } ?>
           <tr class="headSection" >
            <td align="right"  >Balance :
             <?php   echo  price_format($grand_total_credit-$grand_total_debit); ?>
            </td>
            <td align="right"  ><?php   echo  price_format($grand_total_credit+0); ?></td>
            <td align="right"  ><?php   echo  price_format($grand_total_debit+0); ?></td>
           </tr>
           <? } else {   ?>
           <tr>
            <td align="center" colspan="7" height="50" class="error"><br>
             No Transaction Found </td>
           </tr>
           <? }*/    ?>
          </table> 
		</td>-->
        </tr>
       </table>
       <!-- <table width="90%"   border="0" align="center"  cellpadding="5" cellspacing="5" class="tableList">
        <tr>
         <td align="right">&nbsp;
          <h2>Overall % of out Going Business : </h2></td>
         <td align="left">&nbsp;
          <h2>
           <?  echo round(($grand_total_net/ $total_plan_cost)*100,2);
			   
			   ?>
           %  (Exclude all taxes and admin charges)</h2></td>
        </tr>
       </table>-->
       <br />
      </TD>
     </TR>
    </TBODY>
   </TABLE></TD>
 </TR>
</TABLE>
<? include("bottom.inc.php");?>
