<?php
	if (!file_exists('config.php'))
	{
		require 'setup.php';
	}
	
    require 'config.php';

    if (empty($admin_pass) ||
        empty($dbhost) ||
        empty($dbname) )
    {
		require 'error/config.php';
        die();
    }

	echo 'config.php exists';
	
    $dbaccess = new DBaccess();
    if ( !$dbaccess->isValid() )
    {
		require 'error/dbaccess.php';
    }

	session_start();
	
    

    if (!empty($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > (60*120)))
    {
		require 'login/index.php';
    }

    $cur_page = $_SESSION['page'];
	switch ( $cur_page )
	{
        case 'login';
		    require 'login/index.php';
		    die();

        case 'modules':
        case 'quizzes':
        case 'grades':
        case 'profile':
            die();
	}
?>
