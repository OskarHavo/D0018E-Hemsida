<?php
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

    session_unset();
    session_destroy();
    $connection = server_connect();
    logout($connection);

    redirect("Home.php");

?>
