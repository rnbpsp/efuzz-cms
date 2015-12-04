<?php
//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["quiz"]))
{
    /*$json = json_decode($_POST["quiz"]);
    echo $json;
    die();*/
    //$jason = json_encode($_POST["quiz"]);
    $quiz_schema = array(
                'question' => "",
                'tags' => "",
                'type' => "",
                'choices' => "",
                'c_answer' => "",
                't_answer' => int
        );
    //$dbaccess->add_quiz($_POST["quiz"]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Quizzes</title>
        <script src="scripts/jquery-1.11.3.min.js"></script>
        <script src="scripts/jquery-deparam.min.js"></script>
        <style>
            body {
                margin: 12.5%;
            }
            #quiz_header {
                text-align: center;
            }
            .question {
                box-sizing: border-box;
                border: 1px solid black;
                margin: 16px 0;
                padding: 16px;
                width: 100%;
            }
            .question_text {
                box-sizing:border-box;
                width: 100%;
            }
            .text_answer {
                display: block;
            }
            form {
                border: 1px solid black;
                /*margin: 16px 0;*/
                padding: 16px;
                width: 100%;
                text-align: left;
            }
            .error {
                border: 1px red solid;
            }
        </style>
    </head>
    <body>
        <div id="quiz_header">
            <h1>Quiz Form</h1>
            <input id="quiz_title" type="text" placeholder="Quiz Title" />
        </div>
        <input type="button" id="add_questions" value="Add question" />
        <input type="button" id="done" value="Done" />
        <script src="pages/quizzes/add.js"></script>
    </body>
</html>