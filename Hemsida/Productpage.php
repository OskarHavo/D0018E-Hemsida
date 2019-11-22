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


function create_commenttable() {

    $connection = server_connect();
    $comments = $connection->query("SELECT * FROM Comments;");
    while ($comment = $comments->fetch_assoc()) {
        echo "<th>";
        create_comments($connection->query("SELECT * FROM Comments WHERE ProoductType=ProductNumber='$productID'"));
        echo "</th>";
    }
    $connection ->close();
}
function create_comments()
    if ($comment_query->num_rows > 0) {
        while($comment = $comment_query->fetch_assoc()){
           

            echo "<td> . $comment["CustomerID"] . $comment["rating"] . $comment["Comment"]</td>"

        }
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
                <img src="Bilder/<?php echo $product["ProductNumber"]?>.png">
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
                            create_comments();  

                        </tr>

                    </tbody>
                </table>


            </div>
        </div>
    </body>
</html>
