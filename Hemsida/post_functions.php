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
        default:
            break;
    }
}
redirect($_SERVER['HTTP_REFERER']);


function shoppingcart_change_product() {
    $conn = server_connect();
    if ($_POST["addproduct"]) {

        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]+1;
        //$quantity = 1;
        $conn->query("UPDATE Orders SET Quantity='".$quantity."' WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."';");
    } else if ($_POST["subtractproduct"]) {
        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]-1;
        //$quantity = 1;
        if ($quantity == 0) {
            $conn->query("DELETE FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."';");
        } else {
            $conn->query("UPDATE Orders SET Quantity='".$quantity."' WHERE OrderID='".$_SESSION["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."';");
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
