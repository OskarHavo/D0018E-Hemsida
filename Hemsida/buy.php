
<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
if (!isset($_SESSION["CustomerID"])) {
    redirect("Login.php");
}
if ($_SESSION["root"]) {
    redirect("Admin.php");
}
/* Det här fungerar het enkelt som ett script som lägger till en produkt i varukorgen */

$productID = $_POST["ProductNumber"];
$quantity = $_POST["quantity"];
//$user = verifySession($_GET["sessionID"])["CustomerID"];

$connection = server_connect();
//$has_shoppingcart = $connection->query("SELECT ShoppingcartID FROM Accounts WHERE CustomerID='".$_SESSION["CustomerID"]."';");
//$cartID = $has_shoppingcart->fetch_assoc();
if ($_SESSION["ShoppingcartID"] == NULL) {
    /* Lägg till en ny order och kundvagn*/
    $connection->query("INSERT INTO OrderNumbers(CustomerID) VALUES('".$_SESSION["CustomerID"]."');");
    $cartquery = $connection->query("SELECT MAX(OrderID) AS cartID FROM OrderNumbers WHERE CustomerID='".$_SESSION["CustomerID"]."';");
    $cartID = $cartquery->fetch_assoc();
    $_SESSION["ShoppingcartID"] = $cartID["cartID"];
    $connection->query("UPDATE Shoppingcart SET CartID='".$cartID["cartID"]."', Quantity='".($quantity+$_SESSION["CartQuantity"])."' WHERE CustomerID='".$_SESSION["CustomerID"]."';");
    $_SESSION["CartQuantity"] = $quantity;
} else {
    $_SESSION["CartQuantity"] = $quantity+$_SESSION["CartQuantity"];
    $connection->query("UPDATE Shoppingcart SET Quantity='".($quantity+$_SESSION["CartQuantity"])."' WHERE CustomerID='".$_SESSION["CustomerID"]."';");
}

$product_query = $connection->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$productID."';");

if ($product_query->num_rows > 0) {
    $product = $product_query->fetch_assoc();
    $connection->query("UPDATE Orders SET Quantity='".($product["Quantity"]+$quantity)."' WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$productID."';");
} else {
    $connection->query("INSERT INTO Orders(OrderID, Quantity,ProductNumber,CustomerID) VALUES('".$_SESSION["ShoppingcartID"]."',".$quantity.",'".$productID."','".$_SESSION["CustomerID"]."');");
    //echo "I'm not updating properly";
}

$connection->close();
redirect($_SERVER['HTTP_REFERER']);
?>
