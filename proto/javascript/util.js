function getUrlParameter(sParam)
{
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++) 
	{
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam) 
		{
			return sParameterName[1];
		}
	}
	return "";
}

function getContentByMetaTagName(c) {
  for (var b = document.getElementsByTagName("meta"), a = 0; a < b.length; a++) {
    if (c == b[a].name || c == b[a].getAttribute("property")) { return b[a].content; }
  } return false;
}


$(window).on('resize load', function() {
  $('body').css({
    "padding-top": $(".navbar").height() + "px"
  });
});


var maxPapersHeight = Math.max.apply(null, $("div.papersElem").map(function ()
{
    return $(this).height();
}).get());

$('div.papersElem').height(maxPapersHeight);