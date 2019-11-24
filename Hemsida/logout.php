<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");


    $connection = server_connect();
    logout($connection);
    redirect("Home.php");
?>
