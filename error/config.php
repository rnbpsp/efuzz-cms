<?php
    $error_title = 'ERROR: Config File Corrupted';
    $error_text = "Either the config file is corrupted or it's not set up properly.<br />" .
                    'Delete "config.php" from root of your efuzz installation to rerun setup.<br />' .
                    'No data will be deleted.';
   
    require 'error.php';
?>
