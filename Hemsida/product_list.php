<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/server_connect.php");

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
            if (isset($_GET["category"])) {
                $query = $conn->query("SELECT ProductName, ProductNumber, InStock FROM Products WHERE ProductType='".$_GET["category"]."';");
            } else {
                $query = $conn->query("SELECT ProductName, ProductNumber, InStock FROM Products WHERE ProductName like '%".$_GET["searchname"]."%';");
            }

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
