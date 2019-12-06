<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
if (!isset($_SESSION["CustomerID"])) {
    redirect("Login.php");
}
$conn = server_connect();

if ($_SESSION["ShoppingcartID"] == NULL) {
    $conn->close();
    redirect("Shoppingcart_empty.php");
}

if ($_GET["delete_cart"]=="TRUE") {
    empty_cart();
}

function empty_cart() {
    global $conn;
    $conn->query("UPDATE Accounts set ShoppingcartID = NULL WHERE CustomerID='".$_SESSION["CustomerID"]."';");
    $conn->query("DELETE FROM Orders WHERE OrderID='".$_SESSION["ShoppingcartID"]."';");
    $conn->query("DELETE FROM OrderNumbers WHERE OrderID='".$_SESSION["ShoppingcartID"]."';");
    $_SESSION["ShoppingcartID"] = NULL;
    redirect("Shoppingcart_empty.php");
}

$conn->close();
function create_cart() {
    //global $user;
    global $total_cost;
    global $can_buy;
    $can_buy = TRUE;

    $conn = server_connect();
    $shoppingcart = $conn->query("SELECT Orders.Quantity, Products.ProductName,Products.ProductPrice,Products.InStock,Products.ProductNumber FROM Orders INNER JOIN Products ON Products.ProductNumber=Orders.ProductNumber WHERE Orders.CustomerID='".$_SESSION["CustomerID"]."' AND Orders.Price IS NULL AND Orders.OrderID='".$_SESSION["ShoppingcartID"]."';
");
    if ($shoppingcart->num_rows > 0) {
        while ($product = $shoppingcart->fetch_assoc() ) {
            if (($product["InStock"] - $product["Quantity"]) < 0) {
                $can_buy = FALSE;
            }
            $product_cost = $product["ProductPrice"]*$product["Quantity"];
            $total_cost = $total_cost + $product_cost;
            echo "<tr";
            if ($product["InStock"] - $product["Quantity"] < 0) {

            }
            echo "<tr>";
            echo    "<td>".$product["ProductName"]."</td>";
            echo    "<td>"."<form action='post_functions.php' method='post'> <input type='hidden' value='cart_change_product' name='post_ID'><button  class='plussknapp' type='submit' name='addproduct' value='".$product["ProductNumber"]."'>"."</button></form>"."</td>";
            echo    "<td>".$product["Quantity"]."</td>";
            echo    "<td>"."<form action='post_functions.php' method='post'> <input type='hidden' value='cart_change_product' name='post_ID'><button class='minusknapp' type='submit' name='subtractproduct' value='".$product["ProductNumber"]."'>"."</button></form>"."</td>";
            echo    "<td>".$product_cost.":-</td>";
            echo    "<td>"."<form action='post_functions.php' method='post'> <input type='hidden' value='cart_change_product' name='post_ID'><button class='deleteproduktknapp' type='submit' name='deleteproduct'"; 
            echo "</tr>";
        }
    } else {
        $conn->query("UPDATE Accounts set ShoppingcartID = NULL WHERE CustomerID='".$_SESSION["CustomerID"]."';");
        $conn->query("DELETE FROM OrderNumbers WHERE OrderID='".$_SESSION["ShoppingcartID"]."';");
        $_SESSION["ShoppingcartID"] = NULL;
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

    <body >
        <?php include("navbar.php"); ?>
        <div id="container">

            <div id="shoppingcartrubric">
                <p>Min Shoppingvagn</p>
            </div>
            <div id="shoppingcartdiv">
                <table class="shoppingcart-table">
                    <tbody>
                        <tr><td>Produkt</td><td> </td><td>Antal</td><td> </td><td>Kostnad</td></tr>
                        <?php
                        create_cart();
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="shoppingcartcheckout">
                <p>Total Summa: <?php echo $total_cost;?> :-</p>
            </div>
            <div class= "liteknapp" id="tömshoppingcartdiv">
                <a href="Shoppingcart.php?delete_cart=TRUE">Töm</a>
            </div>

            <div class= "liteknapp" id="shoppingcartcheckoutbutton">
                <a <?php
                   if ($can_buy) {
                       echo "href='checkout.php";
                       if ($_SESSION["ShoppingcartID"]) {
                           echo '?OrderID='.$_SESSION["ShoppingcartID"];
                       }
                       echo "'";
                   } else {
                       echo "href='#'";
                   }
                   ?>><?php
                    if ($can_buy) {
                        echo "Köp";
                    } else {
                        echo " Minska antal";
                    }
                    ?></a>
            </div>

        </div>

    </body>
</html>
