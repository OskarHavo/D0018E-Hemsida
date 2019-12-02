
<?php
    session_start();

    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    if (!isset($_SESSION["CustomerID"])) {
        redirect("Login.php");
    }
    if ($_SESSION["root"]) {
        redirect("Admin.php?sessionID=".$user["SessionID"]);
    }
/* Det här fungerar het enkelt som ett script som lägger till en produkt i varukorgen */

    $productID = $_GET["ProductNumber"];
    //$user = verifySession($_GET["sessionID"])["CustomerID"];

    $connection = server_connect();
    $has_shoppingcart = $connection->query("SELECT ShoppingcartID FROM Accounts WHERE CustomerID='".$_SESSION["CustomerID"]."';");
    $cartID = $has_shoppingcart->fetch_assoc();
    if ($cartID["ShoppingcartID"] == NULL) {
        /* Lägg till en ny order och kundvagn*/
        $connection->query("INSERT INTO OrderNumbers(CustomerID) VALUES('".$_SESSION["CustomerID"]."');");
        $cartquery = $connection->query("SELECT MAX(OrderID) AS cartID FROM OrderNumbers WHERE CustomerID='".$_SESSION["CustomerID"]."';");
        $cartID = $cartquery->fetch_assoc();
        echo $cartID["cartID"];
        $connection->query("UPDATE Accounts SET ShoppingcartID='".$cartID["cartID"]."' WHERE CustomerID='".$_SESSION["CustomerID"]."';");
    } else {
        $cartquery = $connection->query("SELECT ShoppingcartID AS cartID FROM Accounts WHERE CustomerID='".$_SESSION["CustomerID"]."';");
        $cartID = $cartquery->fetch_assoc();
    }

    $product_query = $connection->query("SELECT Quantity FROM Orders WHERE OrderID='".$cartID["cartID"]."' AND ProductNumber='".$productID."';");

    if ($product_query->num_rows > 0) {
        $product = $product_query->fetch_assoc();
        $connection->query("UPDATE Orders SET Quantity='".($product["Quantity"]+1)."' WHERE OrderID='".$cartID["cartID"]."' AND ProductNumber='".$productID."';");
    } else {
        $connection->query("INSERT INTO Orders(OrderID, Quantity,ProductNumber,CustomerID) VALUES('".$cartID["cartID"]."','1','".$productID."','".$_SESSION["CustomerID"]."');");
        echo "I'm not updating properly";
    }

    $connection->close();


    /* Återgå till produktsidan, fiffigt va?*/
    redirect($_SERVER['HTTP_REFERER']);
?>
<!DOCTYPE html>
<html>
    <p>test</p>
</html>
