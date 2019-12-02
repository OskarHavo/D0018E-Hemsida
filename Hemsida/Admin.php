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

    function openAdminForm() {
  document.getElementById("recensionform").style.display = "block";
}

function closeAdminForm() {
  document.getElementById("recensionform").style.display = "none";
}



</script>

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
            
            <div class = "adminpagerubric">
                <a>Adminsida</a>
            
            </div>
            <div class ="adminpagediv">
            
                
                    
                <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA ANVÄNDARE</legend>

                    CustomerID:
                    <input type="text" name="username">
                    
                   
                    <input type="submit" class="knapp" value="Radera användare">
                </fieldset>
                     </form>
                
                <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA ORDER</legend>

                    OrderID:
                    <input type="text" name="username">
                
                   
                    <input type="submit" class="knapp" value="Radera order">
                </fieldset>
                    
                    
            </form>
                    <form class="adminform" action="placeholder.php" method="post">
                <fieldset>
                    <legend>RADERA KOMMENTAR</legend>

                    OrderID:
                    <input type="text" name="username">
                    
                    CustomerID:
                    <input type="text" name="password">
                   
                    <input type="submit" class="knapp" value="Radera kommentar">
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
                    <input type="submit" class="knapp" value="Ändra saldo">
                    <button class="adminformbutton" type="button" onclick="openAdminForm()">Lämna en recension!</button>
                </fieldset>
                     </form>
            <a href="phpmyadmin">Länk till PHPmyAdmin</a>
            </div>
            
            <div class="form-popup" id="recensionform">
                <form action="/bytnamnpåmig.php" class="form-container">
                    <h1>Skriv din recension!</h1>

                    <label for="kommentar"><b>Kommentar:</b></label>
                    <input type="text" placeholder="Lämna din kommentar" name="kommentar" required>

                    <label for="betyg"><b>Betyg:</b></label>
                    <input type="text" placeholder="Ge ett betyg mellan 1-10" name="betyg" required>

                    <button type="submit" class="knapp">Skicka in din recension!</button>
                    <button type="button" class="knapp avbryt" onclick="closeAdminForm()">Stäng formuläret</button>
                </form>
            </div>
        </div>

    </body>
</html>
