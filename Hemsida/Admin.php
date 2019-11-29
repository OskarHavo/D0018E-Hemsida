<?php
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

    require_login();

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
        <script src="javascripts.js"></script>
    </head>

    <body>
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
                   
                    <input type="submit" class="knapp" value="Ändra saldo">
                </fieldset>
                     </form>
            <a href "http://90.224.160.35/phpmyadmin">Länk till PHPmyAdmin</a>
            </div>
            
        </div>

    </body>
</html>
