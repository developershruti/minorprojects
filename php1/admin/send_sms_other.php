<?
require_once("../includes/surya.dream.php");
protect_admin_page2();
//print_r($_POST);
if(is_post_back()) {
@extract ($_POST);
//print_r($_POST);
#$arr_u_ids = $_REQUEST['arr_u_ids'];
#if(is_array($arr_u_ids)) {
#$str_u_ids = implode(',', $arr_u_ids);
if(isset($_REQUEST['Submit']) || isset($_REQUEST['Submit_x']) ){
  	$message =$sms_text;
	$msg = send_sms($mobilenumber,$message);
 }

} 



?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../includes/general.js"></script>
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="pageHead"><div id="txtPageHead">
       Send SMS to Other Number </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="content"> 
	  <br/>
             <div align="left" class="errorMsg"><?=$msg?></div>
      
      <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="padding:2px"><table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
                      <tr>
                        <td align="right" class="headSection">Mobile Number </td>
                        <td align="left" class="tableDetails"> 
                          <textarea name="mobilenumber" cols="60" rows="3"><?=$mobilenumber?></textarea>
                          <br />
                          <span class="errorMsg">Please enter (91+mobile number) with comma separated <br />
like (919899237424 etc)</span></td>
                      </tr>
                      <tr>
                        <td width="25%" align="right" class="headSection">SMS Text </td>
                        <td width="75%" align="left"><textarea name="sms_text" cols="60" rows="3"><?=$sms_text?></textarea></td>
                      </tr>
                      
                      <tr>
                        <td align="right">&nbsp;</td>
                        <td align="left"><input name="Submit" type="image" id="Featured" src="images/buttons/submit.gif"  /></td>
                      </tr>
                      
                    </table></td>
                  </tr>
                  
        </table>
       
      </form>
   </td>
  </tr>
</table>

<? include("bottom.inc.php");?>
