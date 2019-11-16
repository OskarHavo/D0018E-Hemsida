<?php
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");


/* Den här koden skapar knapparna till alla kategorier och
*  lägger till alla produkterna. allt detta görs dessutom automatiskt,
*  så om vi lägger till en ny kategori i databasen dyker den upp
*  på hemsidan direkt :D
*/
function create_product($product_query) {
    //$products = $connection->query("SELECT * FROM Products where ProductType='".$category_array[0]."';");
    if ($product_query->num_rows > 0) {
        while($product = $product_query->fetch_assoc()) {
            echo "<li><a href='Productpage.php?ProductNumber=".$product["ProductNumber"]."'>".$product["ProductName"]."</a></li>";
        }
    }
}

function create_category() {

    $connection = server_connect();
    $categories = $connection->query("SELECT * FROM ProductCategories;");
    while ($category = $categories->fetch_assoc()) {
        echo "<li><a>".$category["sitelink"]."</a><ul>";
        create_product($connection->query("SELECT * FROM Products where ProductType='".$category["Category"]."';"));
        echo "</ul></li>";
    }
    $connection ->close();
}
?>
<div id="container">
    <div id="header">


        <h1>Pencil.in</h1>
        <h3>Botemedlet mot dåliga pennor</h3>


    </div>
    <div class="nav">

        <ul>

            <li>
                <a href="Home.php">Hem</a>
            </li>
            <?php
                create_category();
            ?>
            <li>
                <a href="User.php">Användarsida</a>
            </li>
            <div class="shoppingcart">
                <li>
                    <a href="Shoppingcart.php">
                        <img src="shoppingcart.png" width="50px" height="50px" >
                    </a>

                </li>

            </div>

        </ul>


    </div>




</div>
