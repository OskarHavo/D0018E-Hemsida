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
    function remove_product($product) {
        $connection = server_connect();

        $connection->close();
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST["function"]) {
            case "remove_product":
                remove_product();
        }
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
            
                
                    
                <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA ANVÄNDARE</legend>

                    CustomerID:
                    <input type="text" name="username">
                    
                   
                    <input type="submit" class="knapp" value="Radera användare"onclick="taBortKontoKnapp()">
                </fieldset>
                     </form>
                
                <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA ORDER</legend>

                    OrderID:
                    <input type="text" name="username">
                
                   
                    <input type="submit" class="knapp" value="Radera order" onclick="taBortKontoKnapp()">
                </fieldset>
                    
                    
            </form>
                    <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA KOMMENTAR</legend>

                    OrderID:
                    <input type="text" name="username">
                    
                    CustomerID:
                    <input type="text" name="password">
                   
                    <input type="submit" class="knapp" value="Radera kommentar" onclick="taBortKontoKnapp()">
                </fieldset>
                    
                    </form>
            <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>ÄNDRA LAGERSALDO</legend>

                    ProduktID:
                    <input type="text" name="username">
                    
                    Lagersaldo:
                    <input type="text" name="password">
                    <input type="hidden" name="function" value="remove_product">
                    <input type="submit" class="knapp" value="Ändra saldo" onclick="taBortKontoKnapp()">
                 
                </fieldset>
                     </form>
            <a href="phpmyadmin">Länk till PHPmyAdmin</a>
            </div>
            
            
        </div>

    </body>
</html>
