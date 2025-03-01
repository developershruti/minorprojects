function checkall(objForm){
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++) {
		if (objForm.elements[i].type=='checkbox') {
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}

function confirm_submit(objForm) {
	return true;
}
function validcheck(name){
var chObj = document.getElementsByName(name);
var result	=	false;
for(var i=0;i<chObj.length;i++){

	if(chObj[i].checked){
	  result=true;
	  break;
	}
}
  if(!result){
    return false;
  }else{
	 return true;
  }
}

function paidConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to paid the users?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function printConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to print the record?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function updateConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to update the record?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}
function deleteConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to delete the record?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function activateConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to activate the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}

function deactivateConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to deactivate the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}
function featuredConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to Featured the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}
function UnfeaturedConfirmFromUser(name)
{		
	////////alert("aaaaaa");
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to Unfeatured the record?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}
function bannedConfirmFromUser(name)
{		
	
	
	if(validcheck(name)==true)
	{
		if(confirm("Are you sure you want to banned the user?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(validcheck(name)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}

function acceptConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to accept the friendship?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}


function alocateConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to alocate these code to this user ?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

function sendsmsConfirmFromUser(name) {		
	////////alert("aaaaaa");
	if(validcheck(name)==true) {
		if(confirm("Are you sure you want to send sms to these users ?")) {
			return true;  
		} else  {
			return false;  
		}
	}
	else if(validcheck(name)==false) {
		alert("Select at least one check box.");		
		return false;
	}
}

<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->

/****************************************
	Barebones Lightbox Template
	by Kyle Schaeffer
	http://www.kyleschaeffer.com
	* requires jQuery
	http://kyleschaeffer.com/tutorials/lightbox-jquery-css/
****************************************/

// display the lightbox
function lightbox(insertContent, ajaxContentUrl){

	// jQuery wrapper (optional, for compatibility only)
	(function($) {
	
		// add lightbox/shadow <div/>'s if not previously added
		if($('#lightbox').size() == 0){
			var theLightbox = $('<div id="lightbox"/>');
			var theShadow = $('<div id="lightbox-shadow"/>');
			$(theShadow).click(function(e){
				closeLightbox();
			});
			$('body').append(theShadow);
			$('body').append(theLightbox);
		}
		
		// remove any previously added content
		$('#lightbox').empty();
		
		// insert HTML content
		if(insertContent != null){
			$('#lightbox').append(insertContent);
		}
		
		// insert AJAX content
		if(ajaxContentUrl != null){
			// temporarily add a "Loading..." message in the lightbox
			$('#lightbox').append('<p class="loading">Loading...</p>');
			
			// request AJAX content
			$.ajax({
				type: 'GET',
				url: ajaxContentUrl,
				success:function(data){
					// remove "Loading..." message and append AJAX content
					$('#lightbox').empty();
					$('#lightbox').append(data);
				},
				error:function(){
					alert('AJAX Failure!');
				}
			});
		}
		
		// move the lightbox to the current window top + 100px
		$('#lightbox').css('top', $(window).scrollTop() + 100 + 'px');
		
		// display the lightbox
		$('#lightbox').show();
		$('#lightbox-shadow').show();
	
	})(jQuery); // end jQuery wrapper
	
}

// close the lightbox
function closeLightbox(){
	
	// jQuery wrapper (optional, for compatibility only)
	(function($) {
		
		// hide lightbox/shadow <div/>'s
		$('#lightbox').hide();
		$('#lightbox-shadow').hide();
		
		// remove contents of lightbox in case a video or other content is actively playing
		$('#lightbox').empty();
	
	})(jQuery); // end jQuery wrapper
	
}