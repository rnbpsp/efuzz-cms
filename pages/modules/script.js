$(window).hashchange( function(){
	if (location.hash.substring(1, 9).toLowerCase() == "youtube=")
	{
		$("#shad").css("display", "inline");
		$("#frame").attr('src', "https://www.youtube.com/embed/" + location.hash.substring(9));
		$("#video").css({display: "inline", opacity: "1", animation: "efuzz_fadeIn 2s"});
		//$("#frame").css("display", "inline");
	}
	else
	if (location.hash.substring(1, 5).toLowerCase() == "ppt=")
	{
		$("#shad").css("display", "inline");
		$("#frame").attr('src', location.hash.substring(5));
		$("#video").css({display: "inline", opacity: "1", animation: "efuzz_fadeIn 2s"});
		//$("#frame").css("display", "inline");
	}
	else
	{
		$("#shad").css("display", "none");
		$("#frame").attr('src', "");
		$("#video").css({display: "none", opacity: "0", animation: ""});
		//if (location.hash == '#')
		//	return;
	}
});

$(document).ready(function(){
	lastHash = location.hash;
	location.hash = "#";
	if (location.hash.substring(1, 9).toLowerCase() == "youtube=" ||
        location.hash.substring(1, 5).toLowerCase() == "ppt=")
		location.hash=lastHash;
});