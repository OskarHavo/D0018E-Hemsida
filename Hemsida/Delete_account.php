<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

if (!isset($_SESSION["CustomerID"])) {
    redirect("Login.php");
}

$connection = server_connect();
$connection->query("DELETE FROM Comments WHERE CustomerID='".$_SESSION["CustomerID"]."'");
$connection->query("DELETE FROM Orders WHERE CustomerID='".$_SESSION["CustomerID"]."'");
$connection->query("DELETE FROM OrderNumbers WHERE CustomerID='".$_SESSION["CustomerID"]."'");
$connection->query("DELETE FROM Accounts WHERE CustomerID='".$_SESSION["CustomerID"]."'");
$connection->close();
redirect("logout.php");
?>
