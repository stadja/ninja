function hideInfoMessage()
{
	$('.info').hide(1000);
	var messagesHeights = new Array(); // this array will store height for each
	messagesHeight = $('.info').outerHeight(); // fill array
	$('.info').css('top', -messagesHeight); //move element outside viewport
}

function showInfoMessage(text)
{
	$('#info').html(text);
	$('.info').show(1000);
	$('.info').animate({top:"0"}, 1000);
	setTimeout(function(){ $('.info').animate({top: -$(this).outerHeight()}, 1000); }, 3000);
}

function changeFluxRights(select)
{
	var output = new Object();
	output.flux = $(select).attr('id');
	output.cdcs = $(select).val();

	$.post("http://stadja.net:8080/changeFluxRights", output );
}




