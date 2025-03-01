<?php include ("../includes/surya.dream.php"); 

if (($act=='del') && (!$reply_id=='')){
	#protect_user_page();
	$sql_del="delete from ngo_complain_reply where reply_id='".$reply_id."'";
	db_query($sql_del);
	header("location: complain_details.php?comp_id=$comp_id");
	exit;
}	
if(is_post_back()) {
#protect_user_page();
  		@extract($_POST);
			$u_id = db_scalar("select u_id from ngo_users where u_username = '$reply_userid'");
 		if ($reply_id=='' && $u_id!='') { 
		  	$sql_update="insert into ngo_complain_reply (reply_compid, reply_userid, reply_description,  reply_date , reply_lastupdate, reply_status) values ('$comp_id','$u_id',' $reply_description' ,now(),now(),'Active')";
 		
			db_query($sql_update);
			
			$sql = "update ngo_complain set comp_is='Close' where comp_id='$comp_id' ";
			db_query($sql);
			
			header("location: complain_details.php?comp_id=$comp_id");
			exit;
			
			#} else {
  			#$sql_update="update ngo_complain_reply set reply_userid='$reply_userid',reply_description='$reply_description',   reply_lastupdate=now() where reply_id='".$reply_id."'";
		   #db_query($sql_update);	
		} else {
		
		$msg = "Please enter valid reply by username and your reply.";
		}
		
		
}  
 
@extract($_GET);
$sql = "select * from ngo_complain where comp_status='Active'  and comp_id='$comp_id' ";
$result = db_query($sql);
$line= (mysqli_fetch_array($result));
@extract($line);
?><link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
		 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="td_box">
        <tr>
    <td id="pageHead"><div id="txtPageHead">
       &nbsp;Support Ticket</div></td>
  </tr>
		   
          <tr>
            <td valign="top"> 
			<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
	          <tr>
            <td height="10"  valign="top" ><strong><?=$comp_title?></strong> </td>
          </tr>
          <tr>
            <td valign="top" class="maintxt"><?=ms_display_value($comp_desc)?> </td>
          </tr>
		  <tr>
            <td valign="top" height="25" class="maintxt"><strong>Posted by</strong>  <?=db_scalar("select u_username from ngo_users where  u_id= '$comp_userid'");?>  <strong>Dated :</strong><?=date_format2($comp_datetime)?> </td>
          </tr>
           <tr>
            <td align="right" valign="top" ><p align="right"><a href="complain_list.php" class="maintxt">Back to Support Ticket List</a> </span></p></td>
          </tr>
              </table> </td>
            </tr>
          
          <tr>
            <td valign="top" class="maintxt">
 			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <?
				$sql_comment = "select  * from ngo_complain_reply ,ngo_users where ngo_complain_reply.reply_userid=ngo_users.u_id and reply_status='Active' and reply_compid='$comp_id' order by reply_date asc";
				$result_comment = db_query($sql_comment);
				if ($count_comment= mysqli_num_rows($result_comment) >0){
				?>
              <tr>
            <td valign="top"   class="title"><h2> Support Ticket   Reply</h2> </td>
          </tr>
               
              <?
				}
 				while ($line_comment= mysqli_fetch_array($result_comment))  {
  				?>
              <tr>
                
                <td width="92%" valign="top" class="maintxt"><table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  valign="top" class="maintxt"><?=ms_display_value($line_comment['reply_description']) ?> 
					  
					  <a href="complain_details.php?act=del&reply_id=<?=$line_comment['reply_id']?>&comp_id=<?=$comp_id?>" class="maintxt">Delete Msg</a>
					  </td>
                    </tr>
                    <tr>
                      <td width="41%" class="maintxt"><strong>Reply By : </strong> <?=$line_comment['u_username']?> <strong> Dated : </strong> [ <?=date_format2($line_comment['reply_date'])?> ] </td>
                     </tr>
                     
                </table>
				<hr />
				</td>
              </tr>
            
              
              <? } ?>
            </table></td>
          </tr>
          <tr>
            <td valign="top" class="maintxt">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="form1" id="form1" <?= validate_form()?> >
                                <input type="hidden" name="reply_id" value="<?=$reply_id?>" />
                                <input type="hidden" name="comp_id" value="<?=$comp_id?>" />
			
			<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" id="">
              <tr>
                <td class="title" colspan="2"><a name="comment" id="comment"></a><h2> Post Your Reply</h2> </td>
              </tr>
			   <tr>
                <td class="errorMsg" colspan="2"><?=$msg?></td>
              </tr>
              <tr>
	    <td class="tdLabel">Post Replied By: </td>
	    <td class="tdData"> <input name="reply_userid" type="text" id="reply_userid" value="<?=$reply_userid?>"  alt="blank" class="textfield" />
		
		<?php /*$sql ="select u_id , u_username from ngo_users where u_status='Active'";  
						 echo make_dropdown($sql, 'reply_userid', $reply_userid,  'class="txtbox_red" style="width:150px;" alt="select" emsg="Please Select reply user name"', 'Please select');*/
							?></td>
	    </tr>
               
              <tr>
                <td width="14%">Message : </td>
                <td width="86%"><textarea name="reply_description" cols="50" rows="5" id="reply_description" alt="blank" emsg="Please enter your comment" onFocus="javascript:setobj_name('reply_description')"><?=$edit_description?></textarea></td>
              </tr>
              
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit" value="Submit"  class="button"/></td>
              </tr>
            </table>
			</form>
			</td>
          </tr>
         </table>				 
                 <? include("bottom.inc.php");?>