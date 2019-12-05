<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

if (!isset($_SESSION["CustomerID"])) {
    redirect("logout.php");
}

$connection = server_connect();
$query = $connection->query("SELECT MAX(OrderID) AS cartID FROM Orders WHERE CustomerID='".$_SESSION["CustomerID"]."' AND ProductNumber='".$_POST["ProductNumber"]."';");
$orderID = ($query->fetch_assoc())["cartID"];
if ($orderID== NULL) {
    redirect("Home.php");
}

$connection->query("INSERT INTO Comments VALUES('".$_SESSION["CustomerID"]."','".$orderID."','".$_POST["ProductNumber"]."','".$_POST["comment"]."','".$_POST["rating"]."');");
$connection->close();
redirect($_SERVER['HTTP_REFERER']);
?>
