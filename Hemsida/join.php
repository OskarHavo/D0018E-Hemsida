<?php
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

function user_join() {
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $connection = server_connect();

        if (strlen($_POST["username"]) < 5) {
            echo "<p>Välj ett användarnamn med minst 5 karaktärer.</p>";
            return;
        }

        if (!find_user($_POST["username"], $connection)) {
            add_user($_POST["username"], $_POST["password"], $connection);
            $key = validate_user($_POST["username"], $_POST["password"], $connection);
            redirect("Userpage.php?sessionID=".$key);
        } else {
            echo "<p>Användaren är tagen</p>";
        }


        $connection->close();
    }
}
if ($_POST["action"] == "register") {
    user_join();
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

        <div class=logindiv>
            <form action="Userpage.php" method="post">
                <fieldset>
                    <legend>Skapa konto!</legend>

                    Username:<br>
                    <input type="text" name="username">
                    <br>
                    Password: <br>
                    <input type="password" name="password">
                    <br>
                    <input type="hidden" name="action" value="register">
                    <input type="submit" class = "knapp" value="Skapa konto">
                </fieldset>
            </form>
        </div>


    </body>
</html>
