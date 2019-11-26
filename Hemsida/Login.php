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
                    <legend>Logga in!</legend>

                    Username:<br>
                    <input type="text" name="username">
                    <br>
                    Password: <br>
                    <input type="password" name="password">
                    <br>
                    <input type="submit" class="knapp" value="Logga in">
                </fieldset>
            </form>
            <form action="join.php" method="post">
                <fieldset>

                    <input type="submit" class="knapp" value="Skapa konto?">
                </fieldset>
            </form>
        </div>


    </body>
</html>
