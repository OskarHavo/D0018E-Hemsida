<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
//require_login();
if (!isset($_SESSION["CustomerID"])) {
    redirect("Login.php");
}
$conn = server_connect();
$cart_query = $conn->query("SELECT ShoppingcartID FROM Accounts WHERE CustomerID='".$_SESSION["CustomerID"]."';");
$cartID = $cart_query->fetch_assoc();


if ($cartID["ShoppingcartID"] == NULL) {
    $conn->close();
    redirect("Shoppingcart_empty.php");
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if ($_POST["addproduct"]) {
        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$cartID["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]+1;
        //$quantity = 1;
        $conn->query("UPDATE Orders SET Quantity='".$quantity."' WHERE OrderID='".$cartID["ShoppingcartID"]."' AND ProductNumber='".$_POST["addproduct"]."';");
    } else if ($_POST["subtractproduct"]) {
        $query = $conn->query("SELECT Quantity FROM Orders WHERE OrderID='".$cartID["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."';");
        $quantity = ($query->fetch_assoc())["Quantity"]-1;
        //$quantity = 1;
        if ($quantity == 0) {
            $conn->query("DELETE FROM Orders WHERE OrderID='".$cartID["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."';");
        } else {
            $conn->query("UPDATE Orders SET Quantity='".$quantity."' WHERE OrderID='".$cartID["ShoppingcartID"]."' AND ProductNumber='".$_POST["subtractproduct"]."';");
        }

    }
}
$conn->close();
function create_cart() {
    //global $user;
    global $cartID;
    global $total_cost;
    global $cartID;
    global $can_buy;
    $can_buy = TRUE;
    //$cart_query = $conn->query("SELECT ShoppingcartID FROM Accounts WHERE CustomerID='".$user."';");
    global $cart_query;
    $conn = server_connect();
    $shoppingcart = $conn->query("SELECT Orders.Quantity, Products.ProductName,Products.ProductPrice,Products.InStock,Products.ProductNumber FROM Orders INNER JOIN Products ON Products.ProductNumber=Orders.ProductNumber WHERE Orders.CustomerID='".$_SESSION["CustomerID"]."' AND Orders.Price IS NULL AND Orders.OrderID='".$cartID["ShoppingcartID"]."';
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
            echo "<tr>";
            echo    "<td>".$product["ProductName"]."</td>";
            echo    "<td>"."<form action='Shoppingcart.php' method='post'> <button  class='plussknapp' type='submit' name='addproduct' value='".$product["ProductNumber"]."'>"."</button></form>"."</td>";
            echo    "<td>".$product["Quantity"]."</td>";
            echo    "<td>"."<form action='Shoppingcart.php' method='post'> <button class='minusknapp' type='submit' name='subtractproduct' value='".$product["ProductNumber"]."'>"."</button></form>"."</td>";
            echo    "<td>".$product_cost.":-</td>";
            echo "</tr>";
        }
    } else {
        $conn->query("UPDATE Accounts set ShoppingcartID = NULL WHERE CustomerID='".$_SESSION["CustomerID"]."';");
        $conn->query("DELETE FROM OrderNumbers WHERE OrderID='".$cartID["ShoppingcartID"]."';");
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
            <div class= "liteknapp" id="emptyshoppingcartdiv">
                <p>Töm vagnen 
                </p>
            </div>
            <div class= "liteknapp" id="shoppingcartcheckoutbutton">
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
              <!--  <button class="plussknapp" type="submit" name="knapp"></button>
                <button class="minusknapp" type="submit" name="knapp"></button>
                -->

        </div>

    </body>
</html>
