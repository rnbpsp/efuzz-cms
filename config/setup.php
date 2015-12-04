<?php
/*
	
	require_once "tools.php";
	
	$require_input(array());
	
*/
    // verify write access
    /*$config_file = fopen('config/config.php', 'w');
    if (!$config_file)
    {
        require 'error/setup.php';
        die();
    }*/

    // TODO?
    // if session id differs from last activity, show error, rerun

    $admin_pass = "";
	$dbhost = "";
	$dbname = "";
	$dbuser = "";
	$dbpass = "";
	
	$admin_pass_err = '';
	$dbhost_err = '';
	$dbname_err = '';
	$dbuser_err = '';
	$dbpass_err = '';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$admin_pass = $_POST['admin_pass'];
		
		if (empty($admin_pass))
			$admin_pass_err = 'Field required';
		
		$dbhost = $_POST['dbhost'];
		if (empty($dbhost))
			$dbhost_err = 'Field required';
		
		$dbname = $_POST['dbname'];
		if (empty($dbname))
			$dbname_err = 'Field required';
		
		$dbuser = $_POST['dbuser'];
		$dbpass = $_POST['dbpass'];
		$dbprefix = $_POST['dbprefix'];

        if (empty($admin_pass_err) &&
            empty($dbhost_err) &&
            empty($dbname_err) &&
            empty($dbuser_err) &&
            empty($dbpass_err) )
        {
            // TODO
            // check if we can create a table and insert values
            require 'dbaccess_mysqli.php';
            try {
                $db = new dbaccess_mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbprefix);
                if (!$db->isValid())
                {
                    require 'error/setup.php';
                }
                // create tables

                // check if tables already exist
                // happens if setup is run due to corrupted config file
                // or if it is incorrectly editted manually
                //if (!$db->check_table('user_data'))
                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}user_data (
                            user_id INT(6) UNSIGNED AUTO_INCREMENT,
                            uname VARCHAR(32) NOT NULL,
                            fname VARCHAR(30) NOT NULL,
                            lname VARCHAR(30) NOT NULL,
                            gender CHAR(1) NOT NULL,
                            type CHAR(1) NOT NULL,
                            pass VARCHAR(255) NOT NULL,
                            login VARCHAR(255) NOT NULL,
                            PRIMARY KEY (user_id) )"
                            );
                $ret = $db->get_error();

                if ($db->uname_exists("admin"))
                    $db->change_password("admin", $admin_pass);
                else
                    $ret = $db->add_user("Admin", "neto", "f", "admin", $admin_pass, "t");

                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}quiz_data (
                                    quiz_id INT(6) UNSIGNED AUTO_INCREMENT,
                                    title VARCHAR(255) NOT NULL,
                                    added TIMESTAMP(4) NOT NULL,
                                    PRIMARY KEY (quiz_id) )"
                                    );
                $ret = $db->get_error();

                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}question_data (
                                    question_id INT(6) UNSIGNED AUTO_INCREMENT,
                                    quiz_id INT(6) UNSIGNED NOT NULL,
                                    question VARCHAR(1023) NOT NULL,
                                    type CHAR(1) NOT NULL,
                                    answer VARCHAR(127) NOT NULL,
                                    PRIMARY KEY (question_id),
                                    FOREIGN KEY (quiz_id)
                                        REFERENCES {$dbprefix}quiz_data(quiz_id)
                                    )");
                $ret = $db->get_error();

                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}question_tags (
                                    tag_id INT(6) UNSIGNED AUTO_INCREMENT,
                                    name VARCHAR(256) NOT NULL,
                                    PRIMARY KEY (tag_id)
                                    )");
                $ret = $db->get_error();

                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}question_tag_match (
                                    tag_id INT(6) UNSIGNED NOT NULL,
                                    question_id INT(6) UNSIGNED NOT NULL,
                                    FOREIGN KEY (tag_id)
                                        REFERENCES {$dbprefix}question_tags(tag_id),
                                    FOREIGN KEY (question_id)
                                        REFERENCES {$dbprefix}question_data(question_id)
                                    )");
                $ret = $db->get_error();

                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}question_choices (
                                    choice_id INT(6) UNSIGNED AUTO_INCREMENT,
                                    choice VARCHAR(1024) NOT NULL,
                                    question_id INT(6) UNSIGNED NOT NULL,
                                    answer BIT(1) NOT NULL,
                                    PRIMARY KEY (choice_id),
                                    FOREIGN KEY (question_id)
                                        REFERENCES {$dbprefix}question_data(question_id)
                                    )");
                $ret = $db->get_error();

                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}quiz_answers (
                                    user_id INT(6) UNSIGNED AUTO_INCREMENT,
                                    question_id INT(6) UNSIGNED NOT NULL,
                                    choice_id INT(6) UNSIGNED NOT NULL,
                                    answer VARCHAR(127) NOT NULL,
                                    FOREIGN KEY (question_id)
                                        REFERENCES {$dbprefix}question_data(question_id),
                                    FOREIGN KEY (choice_id)
                                        REFERENCES {$dbprefix}question_choices(choice_id),
                                    FOREIGN KEY (user_id)
                                        REFERENCES {$dbprefix}user_data(user_id)
                                    )");
                $ret = $db->get_error();

                $ret = $db->query("CREATE TABLE IF NOT EXISTS {$dbprefix}quiz_results (
                                    uname VARCHAR(256) NOT NULL,
                                    quiz_id INT(6) UNSIGNED NOT NULL,
                                    grade SMALLINT(2) NOT NULL,
                                    taken TIMESTAMP(4) NOT NULL,
                                    FOREIGN KEY (quiz_id)
                                        REFERENCES {$dbprefix}quiz_data(quiz_id)
                                    )");
                $ret = $db->get_error();

                $config_file = fopen('config/config.php', 'w');
                if (!$config_file)
                {
                    require 'error/setup.php';
                    die();
                }

                //                \$admin_pass = '$admin_pass';
                fwrite($config_file, "<?php
                                \$dbhost = '$dbhost';
                                \$dbname = '$dbname';
                                \$dbuser = '$dbuser';
                                \$dbpass = '$dbpass';
                                \$dbprefix = '$dbprefix';
                                ?>");
                
                fclose($config_file);
                
                //return;
                header( 'Location: ?p=login' );
                die();
            }
            catch (Exception $e) {
                // code will continue if an exception is thrown
            }
        }
	}

    //fclose($config_file);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Setup EFuzz</title>
		<style>
			.has-error {
				background: red;
				color: white;
			}
			#setup_form {
				position: absolute;
				width: 100%;
				text-align: center;
				font-size:32px;
			}
			#setup_form input {
				text-align: center;
				font-size:32px;
			}
		</style>
	</head>
	<body>
		<form id="setup_form" method=POST action="index.php">
			<span style="color:red"><?php echo $admin_pass_err; ?></span><br>
			<input type=password name=admin_pass placeholder="Admin Password" value="<?php echo $admin_pass; ?>"><br>
			<span style="color:red"><?php echo $dbhost_err; ?></span><br>
			<input type=text name=dbhost placeholder="Database Host" value="<?php echo $dbhost; ?>"><br>
			<span style="color:red"><?php echo $dbname_err; ?></span><br>
			<input type=text name=dbname placeholder="Database Name" value="<?php echo $dbname; ?>"><br>
			<span style="color:red"></span><br>
			<input type=text name=dbuser placeholder="Database Username" value="<?php echo $dbuser; ?>"><br>
            <span style="color:red"></span><br>
            <input type=password name=dbpass placeholder="Database Password" value="<?php echo $dbpass; ?>"><br>
            <span style="color:blue">Optional table prefix useful for running multiple installations of effuzz on the same db</span><br>
            <input type=text name=dbprefix placeholder="Table prefix" value="<?php echo $dbpass; ?>"><br>
			<?php 
				echo '<input type=submit value="Submit">';
			?>
		</form>
	</body>
</html>
<?php 
/*unlink(realpath('config/config.php'));*/
die(); 
?>