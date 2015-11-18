<?php
/*
	
	require_once "tools.php";
	
	$require_input(array());
	
*/
    // verify write access
    $config_file = fopen('config.php', 'w');
    if (empty($config_file))
    {
        require './err/setup_error.html';
        die();
    }

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

        if (empty($admin_pass_err) &&
            empty($dbhost_err) &&
            empty($dbname_err) &&
            empty($dbuser_err) &&
            empty($dbpass_err) )
        {
            fwrite($config_file, "<?php" +
                                "$admin_pass = '" + $admin_pass + "';" +
                                "$dbhost = '" + $dbhost + "';" +
                                "$dbname = '" + $dbname + "';" +
                                "$dbuser = '" + $dbuser + "';" +
                                "$dbpass = '" + $dbpass + "';" +
                                "?>");
            return;
        }
	}
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
			<span style="color:red"><?php echo $admin_pass_err; ?><span><br>
			<input type=password name=admin_pass placeholder="Admin Password" value="<?php echo $admin_pass; ?>"><br>
			<span style="color:red"><?php echo $dbhost_err; ?><span><br>
			<input type=text name=dbhost placeholder="Database Host" value="<?php echo $dbhost; ?>"><br>
			<span style="color:red"><?php echo $dbname_err; ?><span><br>
			<input type=text name=dbname placeholder="Database Name" value="<?php echo $dbname; ?>"><br>
			<span style="color:red"><span><br>
			<input type=text name=dbuser placeholder="Database Username" value="<?php echo $dbuser; ?>"><br>
			<span style="color:red"><span><br>
			<input type=password name=dbpass placeholder="Database Password" value="<?php echo $dbpass; ?>"><br>
			<?php 
				echo '<input type=submit value="Submit">';
			?>
		</form>
	</body>
</html>
<?php die(); ?>