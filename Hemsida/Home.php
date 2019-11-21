<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

/* Den här koden kollar om det finns en person inloggad */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $connection = server_connect();
    $user = validate_user($_POST["username"],$_POST["password"],$connection);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>

    <body >
        <?php include_navbar($user); ?>

        <div id="container">

            <div class ="blocks">
                <div class="block image1">
                    <div class="layer"></div>
                    <div class="p-container">
                        <p class="img-p">En sida med allt det nya inom pennvärlden. </p>
                    </div>
                </div>
                <div class="block image2">
                    <div class="layer"></div>
                    <div class="p-container">
                        <p class="img-p"> Se all den nya tekniken innan den kommer ut på marknaden.</p>
                    </div>
                </div>
                <div class="block image3">
                    <div class="layer"></div>
                    <div class="p-container">
                        <p class="img-p">Vi har experter inom alla områden för att ge dig en så bra upplevelse som möjligt.</p>
                    </div>
                </div>
                <div class="block image4">
                    <div class="layer"></div>
                    <div class="p-container">
                        <p class="img-p">Få massvis med exklusiva förhandstittar före alla andra.</p>
                    </div>
                </div>
                <div class="block image5">
                    <div class="layer"></div>
                    <div class="p-container">
                        <p class="img-p">Upplev sidan som proffsen föredrar framför allt annat.</p>
                    </div>
                </div>
            </div>

        </div>

    </body>
</html>
