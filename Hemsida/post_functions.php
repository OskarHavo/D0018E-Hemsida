<?php
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
    $conn->query("DELETE FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["deleteproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."'");
    $conn->close();
}

function shoppingcart_change_product() {
    $conn = server_connect();
    if ($_POST["addproduct"]) {

        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]+1;
        //$quantity = 1;
        $conn->query("UPDATE Orders SET Quantity='".$quantity."' WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
    } else if ($_POST["subtractproduct"]) {
        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]-1;
        //$quantity = 1;
        if ($quantity == 0) {
            $conn->query("DELETE FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        } else {
            $conn->query("UPDATE Orders SET Quantity='".$quantity."' WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."' AND CustomerID='".$_SESSION["CustomerID"]."';");
        }
    }else if ($_POST["deleteproduct"]) {
        //delete me senpai
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
</html>
