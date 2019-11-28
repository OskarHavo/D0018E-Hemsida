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

    <body onload="setSessionID('<?php echo fetchSessionID();?>')">
        <?php include("navbar.php"); ?>
        <div id="container">

            <div id="shoppingcartrubric">
                <p>Min Shoppingvagn<br></p>

                <!-- Fixa formatering på den här tack -->
                <!-- Det blir lite konstigt om vi ska visa en shoppingcart när man inte har en,
                    så därför gjorde jag den här sidan. -->
                <a href="/Home.php">Fortsätt handla</a>
            </div>
        </div>

    </body>
</html>
