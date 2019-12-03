<?php
    session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

    if (!isset($_SESSION["CustomerID"])) {
        redirect("Login.php");
    }
    if (!$_SESSION["root"]) {
        redirect("logout.php");
    }

    //$_SESSION["CustomerID"] = $user["CustomerID"];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST["function"]) {
            case "change_stock":
                change_stock($_POST["ProductNumber"], $_POST["stock"]);
                break;
            case "remove_comment":
                remove_comment($_POST["ProductNumber"], $_POST["CustomerID"]);
                break;
            case "remove_product":
                remove_product($_POST["ProductNumber"]);
                break;
            default:
        }
    }

    function remove_comment($product,$customer) {
        $connection = server_connect();
        $connection->query("DELETE FROM Comments WHERE CustomerID='".$customer."' AND ProductNumber='".$product."'");
        $connection->close();
    }

    function remove_product($product) {
        $connection = server_connect();
        $connection->query("UPDATE Products SET InStore=FALSE WHERE  ProductNumber='".$product."'");
        $connection->close();
    }

    function change_stock($product, $stock) {
        if ($stock < 0) {
            return;
        }
        $connection = server_connect();
        $connection->query("UPDATE Products SET InStock='".$stock."' WHERE ProductNumber='".$product."';");
        $connection->close();
    }
?>
<script>
function taBortKontoKnapp() {
  confirm("Är du säker att du vill göra detta?");
}

</script>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>

    <body >
        <?php include("navbar.php"); ?>
        <div id="container">
            
            <div class = "adminpagerubric">
                <a>Adminsida</a>
            
            </div>
            <div class ="adminpagediv">
            
                
                <!--
                <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA ANVÄNDARE</legend>

                    CustomerID:
                    <input type="text" name="username">
                    
                   
                    <input type="submit" class="knapp" value="Radera användare"onclick="taBortKontoKnapp()">
                </fieldset>
                     </form> -->
                <!--
                <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA ORDER</legend>

                    OrderID:
                    <input type="text" name="username">
                
                   
                    <input type="submit" class="knapp" value="Radera order" onclick="taBortKontoKnapp()">
                </fieldset>
                    
                    
            </form>-->
                <form class="adminform" action="Admin.php" method="post">
                <fieldset>
                    <legend>RADERA PRODUKT</legend>

                    Produktnummer:
                    <input type="text" name="ProductNumber">

                   <input type="hidden" name="function" value="remove_product">
                    <input type="submit" class="knapp" value="Radera produkt" onclick="taBortKontoKnapp()">
                </fieldset>


            </form>
                    <form class="adminform" action="Admin.php" method="post">
                <fieldset>
                    <legend>RADERA KOMMENTAR</legend>

                    Produktnummer:
                    <input type="text" name="ProductNumber" required>
                    
                    CustomerID:
                    <input type="text" name="CustomerID" required>
                    <input type="hidden" name="function" value="remove_comment">
                    <input type="submit" class="knapp" value="Radera kommentar" onclick="taBortKontoKnapp()">
                </fieldset>
                    
                    </form>
            <form class="adminform" action="Admin.php" method="post">
                <fieldset>
                    <legend>ÄNDRA LAGERSALDO</legend>

                    ProduktID:
                    <input type="text" name="ProductNumber" required >
                    
                    Lagersaldo:
                    <input type="text" name="stock" required >
                    <input type="hidden" name="function" value="change_stock">
                    <input type="submit" class="knapp" value="Ändra saldo" onclick="taBortKontoKnapp()">
                 
                </fieldset>
                     </form>
            <div class = "divdivider"></div>
            <form class="adminform" action="phpmyadmin" method="post">
                <fieldset>
                    <input type="submit" class="knapp" value="Länk till PHPmyAdmin">
                 
                </fieldset>
                     </form>
             <form class="adminform" action="logout.php" method="post">
                <fieldset>
                    <input type="submit" class="knapp" value="Logga Ut">
                 
                </fieldset>
                     </form>
            </div>
            
            
        </div>

    </body>
</html>
