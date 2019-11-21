<?php
include_once ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/user_scripts.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $connection = server_connect();
    echo $_POST["username"]."<br>".$_POST["password"];
    /*
    if ($_POST["new_user"]) {
        $user = find_user($_POST["new_user"] $connection);
        if (!$user) {
            add_user($_POST["new_user"],$_POST["password"] $connection);
        }
    }*/

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
        <p><?php
                if (!$user) {
                    echo "Du är inte inloggad";
                } else {
                    echo "Du är inloggad som ". $user["CustomerID"];
                }
            ?>
        </p>
        <div class=userdiv>
            <form action="User.php" method="post">
                <fieldset>
                    <legend>Logga in!</legend>

                    Username:<br>
                    <input type="text" name="username">
                    <br>
                    Password: <br>
                    <input type="text" name="password">
                    <br>
                    <input type="submit" value="skicka">
                </fieldset>
            </form>
        </div>
        <a href="Home.php">Saknar konto? klicka här!</a>
        <!--<div class=userdiv>
            <form action="User.php" method="post">
                <fieldset>
                    <legend>Skapa en användare!</legend>

                    Username:<br>
                    <input type="text" name="new_user">
                    <br>
                    Password: <br>
                    <input type="text" name="password">
                    <br>
                    <input type="submit" value="skicka">
                </fieldset>
            </form>
        </div> -->
    </body>
</html>
