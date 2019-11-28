<?php
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $connection = server_connect();
        $key = validate_user($_POST["username"],$_POST["password"],$connection);
        $connection->close();

        if (!$key) {
            redirect("Login.php");
        } else {
            redirect("Userpage.php?sessionID=".$key);
        }
        $connection->close();
        $user = $_POST["username"];
    } else {
        $session = $_GET["sessionID"];
        if(!$session) {
            redirect("Login.php");
        } else if (!($user = verifySession($session))) {
            redirect("Login.php");
        }
    }






function create_cart() {
    global $user;
    $conn = server_connect();
    $cart_query = $conn->query("SELECT ShoppingcartID FROM Accounts WHERE CustomerID='".$user."';");
    if ($cart_query->num_rows > 0) {
        $cartID = $cart_query->fetch_assoc();

        $shoppingcart = $conn->query("SELECT Orders.Quantity, Products.ProductName,Products.ProductPrice FROM Orders INNER JOIN Products ON Products.ProductNumber=Orders.ProductNumber WHERE Orders.CustomerID='".$user."' AND Orders.Price IS NULL;
");
        if ($shoppingcart->num_rows > 0) {
            while ($product = $shoppingcart->fetch_assoc() ) {
                echo "<tr>";
                echo    "<td>".$product["ProductName"]."</td>";
                echo    "<td>".$product["Quantity"]."</td>";
                echo    "<td>".$product["ProductPrice"]."</td>";
                echo "</tr>";
            }
        }
    }
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
                    <?php
                    create_cart()
                    ?>
                </tbody>
            </table>  
             </div>
            
            <div id="shoppingcartcheckout">
                <p>Total Summa = x kr</p>
            </div>
            <div id="shoppingcartcheckoutbutton">
                <p>Slutför köp</p>
            </div>


        </div>

    </body>
</html>
