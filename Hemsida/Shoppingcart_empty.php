<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

    //require_login();
    if (!isset($_SESSION["CustomerID"])) {
        redirect("Login.php");
    }

?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>

    <body >
        <?php include("navbar.php"); ?>
        <div id="container">

            <div id="shoppingcartrubric">
                <p>Din shoppingvagn är tom<br></p>

                <div id="emptyshoppingcartdiv">
  
                <form class="adminform" action="Home.php" method="post">
                <fieldset>
                    <input type="submit" class="knapp" value="Fortsätt att shoppa genom att trycka här">
                 
                </fieldset>
                     </form>
                </div>
            </div>
        </div>

    </body>
</html>
