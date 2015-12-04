
var lastHash = "#";
var modeHash = "";

$(window).hashchange( function(){
	var hash = location.hash;
		$("#teacher_login_form").css("display", "none");
		$("#student_login_form").css("display", "none");
		$("#signup_form").css("display", "none");
		$("#speech_bubble").css("display", "none");
		$("#teacher_logo").css("display", "inline");
		$("#student_logo").css("display", "inline");
		
	if (hash=="#student") {
		//$("#teacher_logo").addClass("teacher_away");
		$("#teacher_logo").css("display", "none");
		$("#student_login_form").css("display", "inline");
		$("#speech_bubble").css("display", "block");
		modeHash="stud";
	}
	else if (hash=="#teacher") {
		//$("#student_logo").addClass("student_away");
		$("#student_logo").css("display", "none");
		$("#teacher_login_form").css("display", "inline");
		$("#speech_bubble").css("display", "block");
		modeHash="teach";
	}
	else if (hash=="#signup") {
		$("#signup_form").css("display", "inline");
		$("#speech_bubble").css("display", "block");
		$("#teacher_logo").css("display", "none");
	}
	else {
		modeHash="";
		location.hash = "";
	}
	
	lastHash = hash;
});

$(document).ready(function(){
	lastHash = location.hash;
	location.hash = "#";
	$("#efuzz_logo").css({left: "8%", opacity: "1", animation: "efuzz_animation 2s"});
	location.hash=lastHash;
	
	resetButton = function(form){
		$(form).not(':button, :submit, :reset, :hidden').removeAttr('checked').removeAttr('selected');
		$(form).not(':checkbox, :radio, select').val('');
	};
	
	$("#but_reset").click(function(){
		resetButton("form");
		$(".err_txt").text("");
	});
	$("#but_cancel").click(function(){
		resetButton("form");
		$(".err_txt").text("");
		location.hash = "";
	});
});


