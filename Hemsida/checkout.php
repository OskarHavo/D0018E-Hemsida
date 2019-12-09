<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

if (!isset($_SESSION["CustomerID"])) {
    redirect("Home.php");
}
if ($_SESSION["root"]) {
    redirect("Admin.php?");
}
$orderID = $_GET["OrderID"];
//$user = get_session_username();
$session = $_GET["sessionID"];
if ($_SESSION["ShoppingcartID"]) {
    $connection = server_connect();
    $connection->query("UPDATE Shoppingcart set CartID = NULL, Quantity=NULL WHERE CustomerID='".$_SESSION["CustomerID"]."';");

    $shoppingcart = $connection->query("SELECT Orders.Quantity, Products.ProductName,Products.ProductPrice,Products.ProductNumber FROM Orders INNER JOIN Products ON Products.ProductNumber=Orders.ProductNumber WHERE Orders.CustomerID='".$_SESSION["CustomerID"]."' AND Orders.Price IS NULL AND Orders.OrderID='".$_SESSION["ShoppingcartID"]."'");
    if ($shoppingcart->num_rows > 0) {
        while ($product = $shoppingcart->fetch_assoc() ) {
            $connection->query("UPDATE Orders SET Price='".$product["ProductPrice"]."' WHERE ProductNumber='".$product["ProductNumber"]."' AND OrderID='".$_SESSION["ShoppingcartID"]."';");
            $connection->query("UPDATE Products SET InStock = Instock-".$product["Quantity"]." WHERE ProductNumber=".$product["ProductNumber"].";");
        }
    }
    $_SESSION["ShoppingcartID"] = NULL;
    redirect("Userpage.php");
} else {
    redirect("Home.php");
}

?>
