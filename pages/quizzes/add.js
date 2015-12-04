// <reference path="../../scripts/jquery-1.11.3.min.js" />

var question_template = $(
    '<form class="question">' +
        '<input type="button" class="remove_question" value="Remove question" />' +
        //'<input class="question_text" type="text" placeholder="Question/Problem" /><br />' +
        '<textarea class="question_text" placeholder="Question/Problem"></textarea>' +
        '<input type="text" class="question_tags" placeholder="Comma (,) separated tags" /><br />'+
        '<select class="question_type">' +
            '<option class="default_type" value="n" seleted>Select answer type</option>' +
            '<option value="m">Multiple choice</option>' +
            '<option value="i">Text entry</option>' +
            '<option value="s">Text entry (case sensitive)</option>' +
            '<!--option value="tm">Text entry (manually checked)</option-->' +
            '<!--option value="mm">Multiple line text entry (manually checked)</option-->' +
        '</select>' +
        //'<div class="choices"></div>' +
    '</form>'
);

var choices_template = $(
    '<div class="choices">' +
        '<span>Select the answer using the radio buttons</span>' +
        '<div class="choice">' +
            '<input type="radio" name="choice" checked />' +
            '<input type="text" placeholder="Choice content" value="" />' +
            '<input type="button" class="remove_choice" value="remove" />' +
            '<br />' +
        '</div>' +
        //'<br />' +
        '<input type="button" class="add_choices" value="Add choices" />' +
    '</div>'
);

var multiple_choice_template = $(
    '<div class="choice">' +
        '<input type="radio" name="choice" />' +
        '<input type="text" placeholder="Choice content" value="" />' +
        '<input type="button" class="remove_choice" value="remove" />' +
        '<br />' +
    '</div>'
);

var text_entry_template = $(
    '<input class="text_answer" type=text name="answer" placeholder="Answer">'
);

$(document).ready(function () {
    $("#add_questions").before(question_template.clone());
});

$("body").on("change", ".question_type", function () {
    $(".default_type", this).attr('disabled', 'disabled');

    //$(this).parent().find(".choices").remove();


    if ($("option:selected", this).val() == "m") { // multiple choice
        //$(this).parent().find(".choices").html(choices_template.clone());
        //$(this).parents(".question").find(".answer_box").html(choices_template);
        $(this).parent().find(".text_answer").remove();
        $(this).after(choices_template.clone());
    } else {
        //$(this).parent().find(".choices").remove();
        //$(".choices", $(this).parents(".question")).remove();
        //$(this).parent().find(".choices").html('');
        $(this).parent().find(".choices").remove();

        var num = $(this).parent().find(".text_answer").length;
        if (!num)
            $(this).after(text_entry_template.clone());
    }
});

$("body").on("click", ".add_choices", function () {
    //$(this).parents(".question").find(".choices").append(multiple_choice_template.clone());
    // before the <br />
    $(this).before(multiple_choice_template.clone());
    //$(this).parent().find(".choice:last").after(multiple_choice_template.clone());
    //$(this).
});


$("body").on("click", ".remove_choice", function () {
    var parent = $(this).parent();
    if ($(this).parents(".choices").find('.choice').length < 2)
        parent.before(multiple_choice_template.clone());

    parent.remove();
});

$("body").on("click", ".remove_question", function () {
    $(this).parent().remove();
    if (!$(".question").length)
        $("#done").val("Cancel");
});

$("#add_questions").click(function () {
    //$("body").append(question_template);
    $(this).before(question_template.clone());
    $("#done").val("Done");
});

$("#done").click(function () {
    //$("body").append(question_template);
    //$(this).before(question_template.clone());
    //$(".question_type:has(option([value='sa']))").parent().css("border", "1px red solid");

    $(".error").toggleClass("error");

    var quiz_title = $.trim($("#quiz_title").val());
    if (!quiz_title.length)
        $("#quiz_title").addClass("error");

    var err_qtype = $('.question_type').filter(function () {
        return $(this).val() === 'n';
    });
    //err_qtype.css("border", "1px red solid");
    err_qtype.addClass("error");
    err_qtype.parent().addClass("error");

    var err_qtxt = $('.question_text').filter(function () {
        return !$.trim($(this).val()).length;
    });
    //err_qtxt.css("border", "1px red solid");
    err_qtxt.addClass("error");
    err_qtxt.parent().addClass("error");

    var err_qtags = $('.question_tags').filter(function () {
        //return !$.trim($(this).val()).length;
        var ret = true;
        var tags = $(this).val().split(",");
        $.each(tags, function () {
            if ($.trim(this).length > 0)
                ret = false;
        });
        return ret;
    });
    //err_qtags.css("border", "1px red solid");
    err_qtags.addClass("error");
    err_qtags.parent().addClass("error");

    var err_form = $(".choices").filter(function () {
        return ($(".choice", this).length < 2 ||
            !$("input[type='radio']:checked", this).length)
    });
    err_form.addClass("error");
    err_form.parent().addClass("error");
    
    var err_choice = $(".choice").filter(function () {
        return !$.trim($("input[type='text']", this).val());
    });
    err_choice.addClass("error");
    err_choice.parents(".question").addClass("error");

    var err_ans = $(".text_answer").filter(function () {
        return !$.trim($(this).val());
    });
    err_ans.addClass("error");
    err_ans.parent().addClass("error");

    if (!err_qtype.length &&
        !err_qtxt.length &&
        !err_qtags.length &&
        !err_form.length &&
        !err_choice.length &&
        !err_ans.length &&
        quiz_title.length > 0)
    {
        // no errors
        // post
        var question_data = [];

        $(".question").each(function () {
            console.log($(this).serialize());
            var question = {
                question: "",
                tags: [],
                type: "",
                choices: [],
                c_answer: 0,
                t_answer: ""
            };
            /*var type = $(this).find(".question_type").val();
            var choices = [];
            var c_answer = 0;
            var t_answer = '';
            */

            question.question = $.trim($(this).find(".question_text").val());

            var tags = $(this).find(".question_tags").val().split(",");
            $.each(tags, function () {
                var tag = $.trim(this);
                if (tag.length > 0)
                    question.tags.push(tag);
            });

            var type = $(".question_type", this).find(":selected").val();
            question.type = type;

            switch (type)
            {
                case 'm':
                    $(this).find(".choice").each(function (c_index) {
                        var val = $("input[type=text]", this).val();
                        question.choices.push($.trim(val));
                        if ( $(this).find("input[type='radio']:checked").length > 0 )
                            question.c_answer = c_index;
                    });
                    break;
                case 'i':
                case 's':
                    question.t_answer = $.trim($(this).find(".text_answer").val());
                    break;
                default:
                    break;
            }
            //post_string.append();
            question_data.push(question);
        });

        var post_obj = {
            p: "quiz",
            q: "add",
            quiz:  { title: quiz_title, questions: question_data }
        };
        //var jason = JSON.stringify(post_obj);
        var post_param = $.param(post_obj);
        //var cal = decodeURIComponent(post_param);
        var post_deparam = $.deparam(post_param);
        //var post_url = document.location.protocol + "//" + document.location.hostname + document.location.pathname;
        var post_url = window.location.href
                        .replace(window.location.search, "")
                        .replace(window.location.hash, "");
        var url = window.location.pathname;
        if (!url.length)
            url = '/';
        url = url.substring(0, url.lastIndexOf('/')+1) + 'post.php';
        url = window.location.origin + url;
        var ret = $.post(
                    '',
                    post_obj,
                    function (data, state, xhr) {
                        $("#done").val("Success");
                        //window.location = xhr.getResponseHeader('Location')
                    })
                .fail(function () {
                    $("#done").val("Error: Cannot send data, click to try again");
                })
                .done(function () {
                    $("#done").val("Done: ?");
                })
                ;
    }
});
