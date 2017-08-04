function updateClock ( )
 {
	var d = new Date();
	var n = d.toTimeString();
  	
   	$("#clock").html(n);
   	  	
 }

$(document).ready(function()
{
   setInterval('updateClock()', 1000);
});