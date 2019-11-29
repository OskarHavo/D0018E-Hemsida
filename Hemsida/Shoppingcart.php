<?php
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
require_login();
$conn = server_connect();
$cart_query = $conn->query("SELECT ShoppingcartID FROM Accounts WHERE CustomerID='".$user."';");
$cartID = $cart_query->fetch_assoc();
if ($cartID["ShoppingcartID"] == NULL) {
    redirect("Shoppingcart_empty.php?sessionID=". $_GET["sessionID"]);
}
$conn->close();
function create_cart() {
    global $user;
    global $cartID;
    global $total_cost;
    global $cartID;
    global $can_buy;
    $can_buy = TRUE;
    //$cart_query = $conn->query("SELECT ShoppingcartID FROM Accounts WHERE CustomerID='".$user."';");
    global $cart_query;
    $conn = server_connect();
    $shoppingcart = $conn->query("SELECT Orders.Quantity, Products.ProductName,Products.ProductPrice,Products.InStock FROM Orders INNER JOIN Products ON Products.ProductNumber=Orders.ProductNumber WHERE Orders.CustomerID='".$user."' AND Orders.Price IS NULL AND Orders.OrderID='".$cartID["ShoppingcartID"]."';
");
    if ($shoppingcart->num_rows > 0) {
        while ($product = $shoppingcart->fetch_assoc() ) {
            if (($product["InStock"] - $product["Quantity"]) < 0) {
                $can_buy = FALSE;
            }
            $product_cost = $product["ProductPrice"]*$product["Quantity"];
            $total_cost = $total_cost + $product_cost;
            echo "<tr";
            if ($product["InStock"] - $product["Quantity"] <= 0) {
                /* Det här indikerar att man vill köpa för många av produkten. Ändra stil om du vill.
                *  Det vore även bra om du kan lägga till en knapp för att ta bort en vara. Gör en test
                *  <tr><td>...</td></tr> med knapp där nere; du behöver inte fippla med php:n.
                */
                echo " bgcolor='#FF0000'";
            }
            echo ">";
            echo    "<td>".$product["ProductName"]."</td>";
            echo    "<td>".$product["Quantity"]."</td>";
            echo    "<td>".$product_cost.":-</td>";
            echo "</tr>";
        }
    }
    $conn->close();
}
?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <script src="javascripts.js"></script>
    </head>

    <body onload="setSessionID('<?php echo fetchSessionID();?>')">
        <?php include("navbar.php"); ?>
        <div id="container">

            <div id="shoppingcartrubric">
                <p>Min Shoppingvagn</p>
            </div>
            <div id="shoppingcartdiv">
            <table class="shoppingcart-table">
                <tbody>
                    <tr><td>Produkt</td><td>Antal</td><td>Kostnad</td></tr>
                    <?php
                        create_cart()
                    ?>
                    <!-- Här kan du göra en test med delete knapp, tack.-->
                    <!-- <tr>
                        <td>
                        </td>
                    </tr> -->
                </tbody>
            </table>
            </div>
            <div id="shoppingcartcheckout">
                <p>Total Summa: <?php echo $total_cost;?> :-</p>
            </div>
            <div id="emptyshoppingcartdiv">
                <p>Töm vagnen 
                </p>
            </div>
            <div id="shoppingcartcheckoutbutton">
                <a <?php
                   if ($can_buy) {
                       echo "href='checkout.php";
                       if ($cartID) {
                           echo '?OrderID='.$cartID["ShoppingcartID"];
                       }
                       echo "'";
                   } else {
                       echo "href='#'";
                   }
                   ?>><?php
                    if ($can_buy) {
                        echo "Köp";
                    } else {
                        echo "Slut it lager";
                    }
                    ?></a>
            </div>


        </div>

    </body>
</html>
