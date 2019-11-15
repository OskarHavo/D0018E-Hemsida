<?php
    /* Källa: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php*/
    function redirect($url, $statusCode = 303) {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
?>
<?php
    /*
    * Bra info
    * https://www.w3schools.com/php/php_superglobals_get.asp
    */
    $productID = $_GET["ProductNumber"];    // Produktnummer från URL

    /* Den här öppnar 404.html om ett produktnummer inte finns */
    if ($productID == NULL) {
        redirect("404.html");
    }


    // Koppla upp mot servern.
    $servername = "localhost";
    $username = "customer";
    $password = "";
    $dbname = "website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kolla om uppkopplingen gick bra.
    if ($conn->connect_error) {
        redirect("404.html");   // Error 404
    }

    $query_result = $conn->query("SELECT * FROM Products WHERE ProductNumber='$productID'");

    /* Hämta produkten vi söker från resultatet */
    $product = $query_result->fetch_assoc();

    // Kolla om produkten faktiskt finns
    if (!$product) {
        $conn->close();
        redirect("404.html");
    }

    /* Rensa resultatet och koppla från servern. */
    mysqli_free_result($query_result);
    $conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include("navbar.php"); ?>
        <div id="container">

            <div id="product">
                <img src="Penna1.jpg">
            </div>
            <table class="responsive-table">
                <caption><?php echo $product["ProductName"];?></caption>
                <tbody>
                    <tr>
                        <th scope="row">Produktyp</th>
                        <td><?php echo $product["ProductType"];?></td>
                    </tr>
                    <tr>
                        <th scope="row">Färg</th>
                        <td><?php echo $product["ProductColor"]?></td>
                    </tr>
                    <th scope="row"><BR>&nbsp;</BR></th>
                    <td></td>
                    <tr>
                        <th scope="row">Pris</th>
                        <td><?php echo $product["ProductPrice"]?> :-</td>
                    </tr>
                    <tr>
                        <th scope="row">Lagerstatus</th>
                        <td>
                            <?php
                                if ($product["InStock"] == 0) {
                                    echo "Slut i lager";
                                } else {
                                    echo $product["InStock"]. " st";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Artikelnummer</th>
                        <td><?php echo $product["ProductNumber"]?></td>
                    </tr>

                </tbody>
            </table>

            <div class= "buyButton">

                <p> Köp </p>

            </div>

            <div id = "reviewdiv">

                <p>  Lämna en recension!    </p>
            </div>
        </div>
    </body>
</html>
