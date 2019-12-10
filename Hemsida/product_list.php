<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
/*
    * Bra info
    * https://www.w3schools.com/php/php_superglobals_get.asp
    */
$productID = "1002";    // Produktnummer från URL

/* Den här öppnar 404.html om ett produktnummer inte finns */
if ($productID == NULL) {
    redirect("404.html");
}
$conn = server_connect();

$comment_query = $conn->query("SELECT * FROM Comments WHERE ProductNumber='$productID';");
$query_result = $conn->query("SELECT * FROM Products WHERE ProductNumber='$productID';");


if (!$query_result || !$comment_query) {
    echo "Error executing query: (" . $conn->errno . ") " . $conn->error;
}

/* Hämta produkten vi söker från resultatet */
$product = $query_result->fetch_assoc();

// Kolla om produkten faktiskt finns
if (!$product || !$product["InStore"]) {
    $conn->close();
    redirect("404.html");
}


$conn->close();
?>
<script>

</script>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body >
        <?php include("navbar.php"); ?>
        <div id="container">

            <?php
            $conn = server_connect();
            $query = $conn->query("SELECT ProductName, ProductNumber, InStock FROM Products WHERE ProductType='".$_GET["category"]."';");
            if ($query->num_rows > 0) {
                while($row = $query->fetch_assoc()) {
                    $productnumber = $row["ProductNumber"];
                    $name = $row["ProductName"];
                    $instock = $row["InStock"];
                    include($_SERVER['DOCUMENT_ROOT']."/product_listing.php");
                }
            }
            ?>

        </div>
    </body>
</html>
