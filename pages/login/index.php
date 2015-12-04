<?php
//$_SESSION['page'] = 'login';

$ispost = false;
$teach_pass_err = '';
$stud_uname_err = $stud_pass_err = '';
$sign_name_err = $sign_uname_err = $sign_pass_err = $sign_gender_err = '';
if ( $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['type'] ) )
{
    /*if (!isset($_POST['type']))
    {
        //require 'error/undefined.html';
        //die();
        require 'design.php'
    }*/
    function require_input($vars)
    {
        foreach ($vars as $var)
            if (!isset($_POST[$var]))
                return false;
        return true;
    }
    function check_len($var, $min_len, $max_len)
    {
        $len = strlen($_POST[$var]);
        if ($len<$min_len || $len>$max_len)
            return ' length should be between ' . $min_len . ' and ' . $max_len . ' characters';
        return '';
    }
    function require_filled($var, $min_len, $max_len)
    {
        if (empty($_POST[$var]))
            return ' is required';
        return check_len($var, $min_len, $max_len);
    }
    $ispost = true;
    switch($_POST['type'])
    {
        case 'teacher':
            if ( empty($_POST['pass']) )
                $teach_pass_err = "Type password";
            else //if ( $admin_pass == $_POST['pass'] )
                if ( $dbaccess->login("admin", $_POST['pass'], session_id()) )
            {
                //require 'admin.php';
                //die();

                //if ( $dbaccess->login("admin", $_POST["pass"]) )
                //$dbaccess->do_login("admin", session_id());
                //$page = 'dashboard';
                //return;
                header("location: ?p=dash");
                die();
            }
            else {
                $teach_pass_err = 'Wrong Password';
            }
            break;
        case 'student':
            /*$required_fields = array('uname','pass');
            if ( !require_input($required_fields) )
            {
                require 'error/undefined.html';
                die();
            }*/
            if ( empty($_POST['uname']) )
            {
                $stud_uname_err = 'Type Username';
                break;
            }
            else
            {
                /*$uname=$_POST['uname'];
                $sql="SELECT * FROM stud_data WHERE uname='$uname'";
                $result = $conn->query($sql);
                $stud_uname_err = 'Username Does Not Exist';
                if ($result->num_rows > 0)
                    while($row = $result->fetch_assoc()) {
                        foreach ($row as $val)
                            if ( strcasecmp($val, $uname)==0 ) {
                                $stud_uname_err = '';
                                echo $val;
                                break;
                            }
                    }*/

                if ( !$dbaccess->uname_exists($_POST['uname']) )
                {
                    $stud_uname_err = 'Username Does Not Exist';
                }
                else
                {
                    if ( empty($_POST['pass']) )
                        $stud_pass_err = 'Type Password';

                    else if ( $dbaccess->login($_POST['uname'], $_POST['pass'], session_id()) )
                    {
                        //$page = 'dashboard';
                        //return;
                        header("location: ?p=dash");
                        die();
                    }
                    else
                    {
                        $stud_pass_err = 'Wrong password';
                    }
                        /*$pass=$_POST['pass'];
                        $stud_pass_err = 'Wrong password';
                        $sql="SELECT * FROM stud_data WHERE uname='$uname'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0)
                            while($row = $result->fetch_assoc()) {
                                foreach ($row as $val)
                                    if ($val == $_POST['pass']) {
                                        echo $val;
                                        //header("Location: modules.php");
                                        //die();
                                        $page = 'dashboard';
                                        return;
                                    }
                            }
                        */
                }
            }

            break;
        case 'signup':
            $required_fields = array('fname','lname','uname','pass','pass2');
            /*if ( !require_input($required_fields) )
            {
            require 'error/undefined.html';
            die();
            }*/
            if (empty($_POST['gender']))
            {
                $sign_gender_err = 'Gender required';
            }
            else
                switch ($_POST['gender'])
                {
                    case 'male':
                    case 'female':
                        break;
                    default:
                        //require 'error/undefined.html';
                        //die();
                        $sign_gender_err = 'Select your gender';
                }
            $fret = require_filled('fname', 2, 256);
            $lret = require_filled('lname', 2, 256);
            if ($fret)
                $sign_name_err = 'Name' . $fret;
            else if ($lret)
                $sign_name_err = 'Name' . $lret;
            else if ( preg_match('/[^A-Za-z]/', $_POST['fname']) ||
                    preg_match('/[^A-Za-z]/', $_POST['lname']) )
                $sign_name_err = htmlentities('Only letters (A-Z, a-z) are allowed');
            $ret = require_filled('uname', 8, 32);
            if ($ret)
                $sign_uname_err = 'Username' . $ret;
            //else if (strtolower($_POST["uname"])=="admin")
            //    $sign_uname_err = '"admin not allowed for username"' . $ret;
            $ret = require_filled('pass', 8, 24);
            if ($ret)
                $sign_pass_err = 'Password' . $ret;
            else if ( !preg_match('/[A-Za-z]/', $_POST['pass']) ||
                    !preg_match('/[^A-Za-z0-9]/', $_POST['pass']) ||
                    !preg_match('/[0-9]/', $_POST['pass']) )
                $sign_pass_err = 'Password should contain atleast a letter, a number and a special character';
            else if ( empty($_POST['pass2']) )
                $sign_pass_err = 'Retype password';
            else if ($_POST['pass'] != $_POST['pass2'])
                $sign_pass_err = htmlentities("Passwords don't match");
            /*$sql = "SELECT uname FROM stud_data";
            $result = $conn->query($sql);
            //echo mysqli_num_rows($result);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    foreach ($row as $val)
                        //echo $val; "<br>";
                        if ($val == $_POST['uname'])
                            $sign_uname_err= 'Username already exist';
                }
            }*/
            if ($dbaccess->uname_exists($_POST['uname']))
                $sign_uname_err= 'Username already exist';

            if ( empty($sign_name_err) && empty($sign_uname_err) &&
                    empty($sign_pass_err) && empty($sign_gender_err) )
            {
                $fname=$_POST['fname'];
                $lname=$_POST['lname'];
                $uname=$_POST['uname'];
                $pass=$_POST['pass'];
                $gender=$_POST['gender'];
                //$encrypted_pass=md5($pass);
                //$encrypted_pass = password_hash($pass, PASSWORD_DEFAULT);
                /*$sql = "INSERT INTO stud_data (fname, lname, uname, pass, gender)
						    VALUES ('$fname', '$lname', '$uname', '$encrypted_pass', '$gender')";
                if ($conn->query($sql) === TRUE)
                    echo "New record created successfully";
                else
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    */
                $ret = $dbaccess->add_user($fname, $lname, $uname, $pass, $gender, 's');
                if (!$ret)
                    require 'error/signup.php';
                
                header("location: ?p=login");
                die();
            }
            break;
        default:
            break;
            //require 'error/login.php';
            //die();
    }
}

foreach (array('pass','uname','fname','lname','pass2','gender') as $var)
    if ( empty($_POST[$var]) )
        $_POST[$var] = '';
    else
        $_POST[$var] = htmlentities($_POST[$var]);
                    /*htmlspecialchars*/
require 'design.php';
?>
