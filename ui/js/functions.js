var hiddenflag = 0;
var flag2 = 0;

function showHide(id) {
   var e = document.getElementById(id);
   if(e.style.visibility == 'visible')
      e.style.visibility = 'hidden';
   else
      e.style.visibility = 'visible';
}

function hide(id)
{
   var e = document.getElementById(id);
   e.style.visibility = 'hidden';
}

function show(id)
{
   var e = document.getElementById(id);
   e.style.visibility = 'visible';
   window.event.stopPropagation();
}


// Copyright 2006-2007 javascript-array.com

var timeout	= 500;
var closetimer	= 0;
var ddmenuitem	= 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 


function popit(file, width, height)
{
   // Default parameters
   width = width   || 650;
   height = height || 400;
   
   window.open(file, "New Window", "width=" + width + ",height=" + height + ",location=no,menubar=no,status=no,resizable=no,scrollbars=yes")
   
   return false;
}
