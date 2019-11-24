<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $connection = server_connect();
        $key = validate_user($_POST["username"],$_POST["password"],$connection);
        $connection->close();

        if (!$key) {
            redirect("Login.php");
        } else {
            redirect("Userpage.php?sessionID=".$key);
        }
    } else {
        $session = $_GET["sessionID"];
        if(!$session) {
            redirect("Login.php");
        } else if (!verifySession($session)) {
            redirect("Login.php");
        }
    }

    /*
    if (!$session) {
        $connection = server_connect();
        $key = validate_user($_POST["username"],$_POST["password"],$connection);
        $connection->close();


        if (!$key) {
            redirect("Login.php");
        } else {
            redirect("Userpage.php?sessionID=".$key);
        }

    }
    else if (!verifySession($session)) {
        //redirect("404.php");

    }*/
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

            <div id="userpagerubric">
                <p>Mina Ordrar(#0003)</p>
            </div>

            <table class="userpage-table">
                <tbody>
                    <tr>
                        <th scope="row">Ordernummer</th>
                        <td>Produkter<td>
                        <td>Pris</td>
                    </tr>

                </tbody>
            </table>
            <div id="userpagelowerdiv">
                <p><a href="logout.php">Logga ut</a></p>
            </div>


        </div>


    </body>
</html>
