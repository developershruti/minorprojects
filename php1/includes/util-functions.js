//css menu javascript
navHover = function() {
	var lis = document.getElementById("vergedynnav").getElementsByTagName("li");	
	for (var i=0; i<lis.length; i++) {
		lis[i].onmouseover=function() {
			this.className+=" iehover";
		}
		lis[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" iehover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", navHover);
//******************************************************

function clearTip(field)
{    
	if(field.defaultValue == field.value)
	field.value = "";
}

function MsgDeleteRecord()
{
	if(confirm("Are you sure to delete this record?"))
	{	return true;	}
	return false; 
}

function writeTip(field)
{
	if(field.value == "")
		field.value = field.defaultValue;
}

function popup(url)
{
	width = 370;
	height = 345;
	xx = window.screen.width;
	yy = window.screen.height;
	xx = (xx/2) - (width/2);
	yy = (yy/2) - (height);
	style = 'left = ' +  xx + ',top = ' + yy + ',width='+ width +',height=' + height + ',directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,resizable=no';
	newwindow=window.open(url,'name',style);
	if (window.focus) {newwindow.focus()}
}
//popupEventImage
function popupEventImage(id)
{
	width = 500;
	height = 500;
	xx = window.screen.width;
	yy = window.screen.height;
	xx = (xx/2) - (width/2);
	yy = (yy/2) - (height);
	style = 'left = ' +  xx + ',top = ' + yy + ',width='+ width +',height=' + height + ',directories=no,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,resizable=no';
	newwindow=window.open('BigEventImage.aspx?id='+id,'name',style);
	if (window.focus) {newwindow.focus()}
}

function popupEvent(id)
{
	width = 500;
	height = 500;
	xx = window.screen.width;
	yy = window.screen.height;
	xx = (xx/2) - (width/2);
	yy = (yy/2) - (height);
	style = 'left = ' +  xx + ',top = ' + yy + ',width='+ width +',height=' + height + ',directories=no,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,resizable=no';
	newwindow=window.open('EventDetails.aspx?id='+id,'name',style);
	if (window.focus) {newwindow.focus()}
}

function popupEvent(id)
{
	width = 500;
	height = 500;
	xx = window.screen.width;
	yy = window.screen.height;
	xx = (xx/2) - (width/2);
	yy = (yy/2) - (height);
	style = 'left = ' +  xx + ',top = ' + yy + ',width='+ width +',height=' + height + ',directories=no,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,resizable=no';
	newwindow=window.open('EventDetails.aspx?id='+id,'name',style);
	if (window.focus) {newwindow.focus()}
}

function ValdiateMember()
{
    var emailPat =/^[A-Za-z0-9_\-]+([.][A-Za-z0-9_\-]+)*[@][A-Za-z0-9_\-]+([.][A-Za-z0-9_\-]+)+$/
    var strd;
    if(document.frmVergeMembersLogin.TxtUserName.value=="" || document.frmVergeMembersLogin.TxtUserName.value=="Username")
    {
        strd = "Please enter user name";
        alert(strd);
        document.frmVergeMembersLogin.TxtUserName.focus();
        return false;
    }
//    else if (document.frmVergeMembersLogin.TxtUserName.value.match(emailPat) == null)
//	{
//		strd = "Please enter valid user name";
//        alert(strd);
//        document.frmVergeMembersLogin.TxtUserName.focus();
//        return false;
//	}
    if(document.frmVergeMembersLogin.TxtPassword.value=="" || document.frmVergeMembersLogin.TxtPassword.value=="Password")
    {
        strd = "Please enter password";
        alert(strd);
        document.frmVergeMembersLogin.TxtPassword.focus();
        return false;
    }
    return true;
   
}
function ValdiateSearh()
{
    var strd;
    if(document.frmVergeSearch.TxtSearh.value=="" || document.frmVergeSearch.TxtSearh.value=="Search here...")
    {
        strd="Please enter search item";
        alert(strd);
        document.frmVergeSearch.TxtSearh.focus();
        return false;
    }
    if(document.frmVergeSearch.TxtSearh.value.charAt(0)==' ')
    {
        strd="Space not allowed";
        alert(strd);
        document.frmVergeSearch.TxtSearh.focus();
        return false;
    }
    return true;
}

function ValdiateNewsLetter()
{
    var emailPat =/^[A-Za-z0-9_\-]+([.][A-Za-z0-9_\-]+)*[@][A-Za-z0-9_\-]+([.][A-Za-z0-9_\-]+)+$/
    var strd;
   
    if(document.frmVergeNewsLetter.TxtNewsLetter.value=="" || document.frmVergeNewsLetter.TxtNewsLetter.value=="Enter email address.")
    {
        strd="Please enter email address";
        alert(strd);
        document.frmVergeNewsLetter.TxtNewsLetter.focus();
        return false;
    }
    else if (document.frmVergeNewsLetter.TxtNewsLetter.value.match(emailPat) == null)
	{
		strd="Please enter valid email address";
        alert(strd);
        document.frmVergeNewsLetter.TxtNewsLetter.focus();
        return false;
	}
    return true;
   
}

function HideDisplay(id)
{
	if (document.getElementById(id).style.display=="none")
	{
	    document.getElementById(id).style.display = "block";
	}
	else
	{
		document.getElementById(id).style.display = "none";			
	}
}
function ValidateForgotPass()
{
    var emailPat =/^[A-Za-z0-9_\-]+([.][A-Za-z0-9_\-]+)*[@][A-Za-z0-9_\-]+([.][A-Za-z0-9_\-]+)+$/
    var strd;
   
    if(document.frmVergeForgotpass.TxtForgotUserName.value=="" || document.frmVergeForgotpass.TxtForgotUserName.value=="EmailId")
    {
        strd=document.frmVergeForgotpass.MRFForgotpassAddreess.value;
        alert(strd);
        document.frmVergeForgotpass.TxtForgotUserName.focus();
        return false;
    }
    else if (document.frmVergeForgotpass.TxtForgotUserName.value.match(emailPat) == null)
	{
		strd=document.frmVergeForgotpass.MRFValidForgotpass.value;
        alert(strd);
        document.frmVergeForgotpass.TxtForgotUserName.focus();
        return false;
	}
    return true;
}