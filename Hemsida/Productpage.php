<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    include_once ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
    /*
    * Bra info
    * https://www.w3schools.com/php/php_superglobals_get.asp
    */
    $productID = $_GET["ProductNumber"];    // Produktnummer från URL

    /* Den här öppnar 404.html om ett produktnummer inte finns */
    if ($productID == NULL) {
        redirect("404.html");
    }
    $conn = server_connect();
    $query_result = $conn->query("SELECT * FROM Products WHERE ProductNumber='$productID'");
    $query_result2 = $conn->query("SELECT * FROM Comments WHERE ProductNumber='$productID'");

    if (!$query_result) {
        echo "Error executing query: (" . $conn->errno . ") " . $conn->error;
    }

    /* Hämta produkten vi söker från resultatet */
    $product = $query_result->fetch_assoc();
    $comment = $query_result2->fetch_assoc();

    // Kolla om produkten faktiskt finns
    if (!$product) {
        $conn->close();
        redirect("404.html");
    }

    /* Rensa resultatet och koppla från servern. */
    mysqli_free_result($query_result);
    mysqli_free_result($query_result2);
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
                <img src="Bilder/1001.jpg">
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
            <div class = "leavereviewdiv">
                <p> Tryck här för att lämna en recension!  </p>
            </div>
            <div id = "reviewdiv">

                <p>  Recensioner  </p>
                
                <table class="review-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo $comment["CustomerID"];?></th>
                        <td><?php echo $comment["rating"];?></td>
                        <td><?php echo $comment["Comment"];?></td>
                        <td>  report   </td>
                    </tr>

                </tbody>
            </table>
                
                
            </div>
        </div>
    </body>
</html>
