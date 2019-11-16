<?php
/* Hur man skriver in användare och lösenord:
*  1. Skriv in data i formuläret.
*  2. Klicka på "send" knappen.
*  3. När sidan laddas om kollar man om det finns input,
*   annars ber man användaren att skriva in igen.
*/
    include ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $connection = server_connect();
        /* Om man kommer hit så har användaren skrivit in data. */

        //$connection->query("INSERT INTO Accounts VALUES ('".$_POST["name"]."','".crypt($_POST["password"],'$6$rounds=5000$'.rand(1000000,1000000000).'$')."')");
        //echo "data has been sent!";
        //validate_password($_POST["name"], $_POST["password"], $connection);
    }
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
    <form action="test.php" method="post">
        Name: <input type="text" name="name"><br>
        Password: <input type="text" name="password"><br>
        salt: <input type="text" name="salt"> <br>
        <input type="submit">
    </form>

        Welcome <?php echo $_POST["name"]; ?><br>
        <!-- Your email address is: <?php echo $_POST["email"]; ?> -->
        Your encrypted name is <?php echo crypt($_POST["password"],'$6$rounds=5000$'.rand(1000000,1000000000).'$');?>

    </body>
</html>

