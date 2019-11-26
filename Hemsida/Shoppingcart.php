<?php
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

$conn = server_connect();

$cart_query = $conn->query("SELECT * FROM Orders WHERE CustomerID='robin';");

/*
    Vi behöver få produkternas pris och namn också
*/
 function create_cart() {
        global $cart_query;
        if ($cart_query->num_rows > 0) {
            while($cart = $cart_query->fetch_assoc()){
                echo "<tr><td>".$cart["ProductNumber"]. "</td><td>".$cart["ProductNumber"]." </td><td>Betyg: ".$cart["ProductNumber"] ."</td></tr>";
            }
        } else {
            echo "denna ska ner";
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

            <table class="shoppingcart-table">
                <tbody>
                    <?php
                    create_cart()
                    ?>
                </tbody>
            </table>  
            <div id="shoppingcartcheckout">
                <p>Total Summa = x kr</p>
            </div>
            <div id="shoppingcartcheckoutbutton">
                <p>Slutför köp</p>
            </div>


        </div>

    </body>
</html>
