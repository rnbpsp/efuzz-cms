<!DOCTYPE html>
<html>
<head>
    <title>E-Fuzz</title>
    <link rel="stylesheet" href="/min/f=efuzz/style.css">
    <script type="text/javascript" src="/min/b=efuzz/jslib&amp;f=jquery-1.11.3.min.js,jquery.ba-hashchange.min.js"></script>
</head>
<body>
    <img id="board_bkg" src="blak bord.png" alt="Board">
    <img id="speech_bubble" src="sky.png" alt="">
    <div id="teacher_login_form">
        <form id="form_input_login" action="index.php#teacher" method=POST>
            <input type=hidden name="type" value="teacher">
            <span class="err_txt"><?php echo $teach_pass_err ?></span><br>
            <input id="login_pass" type=password name="pass" value="" placeholder="System Password"><br>
            <input type=submit value="Login"><br><br>
        </form>
    </div>
    <div id="student_login_form">
        <form id="form_input_login" action="index.php#student" method=POST>
            <input type=hidden name="type" value="student">
            <span class="err_txt"><?php echo $stud_uname_err; ?></span><br>
            <input id="login_uname" type=text name="uname" value="<?php echo $_POST['uname']; ?>" placeholder="Username"><br>
            <span class="err_txt"><?php echo $stud_pass_err; ?></span><br>
            <input id="login_pass" type=password name="pass" value="" placeholder="Password"><br>
            <input type=submit value="Login"><br><br>
            <a href="#signup"><input type=button value="Sign Up"></a>
        </form>
    </div>
    <div id="signup_form">
        <form id="form_input_signup" action="index.php#signup" method=POST>
            <input type=hidden name="type" value="signup">
            <span class="err_txt"><?php echo $sign_name_err ?></span><br>
            <input class="half_input" type=text name="fname" value="<?php echo $_POST['fname']; ?>" placeholder="First Name">
            <input class="half_input" type=text name="lname" value="<?php echo $_POST['lname']; ?>" placeholder="Last Name"><br>
            <span class="err_txt"><?php echo $sign_uname_err ?></span><br>
            <input type=text name="uname" value="<?php echo $_POST['uname']; ?>" placeholder="Username"><br>
            <span class="err_txt"><?php echo $sign_pass_err ?></span><br>
            <input class="half_input" type=password name="pass" value="" placeholder="Password">
            <input class="half_input" type=password name="pass2" value="" placeholder="Confirm Password"><br>
            <span class="err_txt"><?php echo $sign_gender_err; ?></span><br>
            <input type=radio name=gender value=female <?php if ($_POST['gender']=='female') echo 'checked'; ?>>Female
            <input type=radio name=gender value=male <?php if ($_POST['gender']=='male') echo 'checked'; ?>>Male<br><br>
            <input type=submit value="Sign Up">
            <input id="but_reset" type=button value="Reset">
            <input id="but_cancel" type=button value="Cancel">
        </form>
    </div>
    <a href="#teacher"><img id="teacher_logo" src="teacher.png" alt="Teacher Login"></a>
    <a href="#student"><img id="student_logo" src="student.png" alt="Student Login"></a>
    <img id="efuzz_logo" src="efuzzfont.png" alt="efuzz Logo">
    <script src="/min/f=script.js"></script>
</body>
</html>
