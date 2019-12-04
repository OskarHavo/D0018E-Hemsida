<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

    //require_login();
    if (!isset($_SESSION["CustomerID"])) {
        redirect("Home.php");
    }
    if ($_SESSION["root"]) {
        redirect("Admin.php?");
    }
    /*if ($user["root"]) {
        redirect("Admin.php?sessionID=".$user["SessionID"]);
    }*/

    $orderID = $_GET["OrderID"];
    //$user = get_session_username();
    $session = $_GET["sessionID"];
    if ($orderID) {
        $connection = server_connect();
        $connection->query("UPDATE Accounts set ShoppingcartID = NULL WHERE CustomerID='".$_SESSION["CustomerID"]."';");

        $shoppingcart = $connection->query("SELECT Orders.Quantity, Products.ProductName,Products.ProductPrice,Products.ProductNumber FROM Orders INNER JOIN Products ON Products.ProductNumber=Orders.ProductNumber WHERE Orders.CustomerID='".$_SESSION["CustomerID"]."' AND Orders.Price IS NULL AND Orders.OrderID='".$orderID."'");
        if ($shoppingcart->num_rows > 0) {
            while ($product = $shoppingcart->fetch_assoc() ) {
                $connection->query("UPDATE Orders SET Price='".$product["ProductPrice"]."' WHERE ProductNumber='".$product["ProductNumber"]."' AND OrderID='".$orderID."';");
                $connection->query("UPDATE Products SET InStock = Instock-".$product["Quantity"]." WHERE ProductNumber=".$product["ProductNumber"].";");
            }
        }

         redirect("Userpage.php?sessionID=". $session);
    } else {
        redirect("Home.php");
    }

?>




<!DOCTYPE html>
<html>
</html>
