<?php
    $quiz_page = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['q']))
        $quiz_page = $_POST['q'];
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['q']))
        $quiz_page = $_GET['q'];

    switch($quiz_page)
    {
        case 'take':
        case 'list':
        case 'del':
        case 'add':
            require 'pages/quizzes/add.php';
            die();
        default:
            break;
    }
    /*
require 'add.php';
require 'list.php';
require 'take.php';
require 'edit.php';
 */?>
<!DOCTYPE html>
<html>
<head>
    <title>Quizzes</title>
    <script src="scripts/jquery-1.11.3.min.js"></script>
</head>
<body style="text-align:center; margin-top:64px;">
    <input id="add_quiz" type="button" value="Add quiz" />
    <script>
        $("#add_quiz").click(function () {
            window.location.href = "?p=quiz&q=add";
        });
    </script>
</body>
</html>
