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
                <p>Din shoppingvagn är tom<br></p>

                <div id="emptyshoppingcartdiv">
  
                <a href="/Home.php">Fortsätt handla genom att klicka på texten här!</a>
                </div>
            </div>
        </div>

    </body>
</html>
