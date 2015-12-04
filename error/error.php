<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $error_title ?></title>
    <style>
        body {
            text-align: center;
        }
    <style/>
</head>
<body>
    <?php echo $error_text ?>

</body>
</html>
<?php 
    // all errors die()
    die();
?>