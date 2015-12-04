<?php
$cwd = getcwd();
if (!$cwd)
    require 'error/cwd.php';

set_include_path(get_include_path() . PATH_SEPARATOR . $cwd);

session_start();

/*
TESTBED
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['p']))
    switch($_GET['p'])
    {
        case 'grades':
            require 'pages/grades/design.php';
            break;
        default:
            require 'pages/dashboard/index.php';
            break;
    }
else
    require 'pages/dashboard/index.php';

die();
 */

// for as long as setup is not complete,
// this will evaluate to true
if ( !file_exists('config/config.php') )
    require 'config/setup.php';

require 'config/config.php';

// sanity check
if (empty($dbhost) ||
    empty($dbname) ||
    !isset($dbuser) ||
    !isset($dbpass) ||
    !isset($dbprefix) )
{
    require 'error/config.php';
}

require 'dbaccess_mysqli.php';

try {
    $dbaccess = new dbaccess_mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbprefix);
}
catch (Exception $e) {
    require 'error/dbaccess.php';
}

if ( !empty($_SESSION['LAST_ACTIVITY']) &&
    (time() - $_SESSION['LAST_ACTIVITY'] > (60*120)) )
{
    require 'login/index.php';
}

// check which page we are in
$page = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['p']))
    $page = $_GET['p'];
else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['p']))
    $page = $_POST['p'];

$page = strtolower($page);

/*$valid_pages = array('setup', 'login', 'dashboard', 'modules', 'grades', 'quizzes');
if (array_search($page, $valid_pages) === false)
$page = '';
 */

if( $page === 'login' || empty($page) )
{
    require 'pages/login/index.php';
    die();
}

// check if logged in before getting access to these pages
$uname = $dbaccess->check_login(session_id());
if (empty($uname))
    require 'pages/login/index.php';
else
    switch ( $page )
    {
        case 'logout':
            $dbaccess->logout($uname);
            header("location: ?p=dash");
            die();
        case 'modules':
            require 'pages/modules/modules.php';
            die();
        case 'quiz':
            require 'pages/quizzes/index.php';
            die();
        case 'grades':
            die();
        case 'profile':
        case 'dash':
        default:
            //        require 'pages/login/index.php';
            require 'pages/dashboard/index.php';
            die();
    }
?>
