<?php
session_start();
/* Den här filen skapades som följd av behovet att
*  göra post-formulär som återgår till samma sida.
*  Egentligen kan alla post formulär skicka data hit,
*  då skulle vi inte behöva ha olika sidor som tar hand
*  om köpfunktionerna t.ex.
*/
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    switch($_POST["post_ID"]) {
        case "cart_change_product":
            shoppingcart_change_product();
            break;
        case "cart_delete_product":
            shoppingcart_delete_product();
        default:
            break;
    }
}
redirect($_SERVER['HTTP_REFERER']);

function shoppingcart_delete_product() {
    $conn = server_connect();
    $quantity = ($conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["deleteproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."'"))->fetch_assoc();
    $conn->query("DELETE FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["deleteproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."'");
    $_SESSION["CartQuantity"] = $_SESSION["CartQuantity"]-$quantity["Quantity"];
    $conn->query("UPDATE Shoppingcart SET Quantity='".$_SESSION["CartQuantity"]."' WHERE CustomerID='".$_SESSION["CustomerID"]."';");
    $conn->close();
}

function shoppingcart_change_product() {
    $conn = server_connect();
    if ($_POST["addproduct"]) {
        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]+1;
        $_SESSION["CartQuantity"] = $_SESSION["CartQuantity"]+1;
        $conn->query("UPDATE Shoppingcart SET Quantity='".$_SESSION["CartQuantity"]."' WHERE CustomerID='".$_SESSION["CustomerID"]."';");
        //$quantity = 1;
        $conn->query("UPDATE Orders SET Quantity=Quantity+1 WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
    } else if ($_POST["subtractproduct"]) {
        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]-1;
        //$quantity = 1;
        if ($quantity == 0) {
            $conn->query("DELETE FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        } else {
            $conn->query("UPDATE Orders SET Quantity=Quantity-1 WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        }
        $_SESSION["CartQuantity"] = $_SESSION["CartQuantity"]-1;
        $conn->query("UPDATE Shoppingcart SET Quantity='".$_SESSION["CartQuantity"]."' WHERE CustomerID='".$_SESSION["CustomerID"]."';");
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
</html>
