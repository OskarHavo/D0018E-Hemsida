<?php
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/user_scripts.php");

/* Den här koden skapar knapparna till alla kategorier och
*  lägger till alla produkterna. allt detta görs dessutom automatiskt,
*  så om vi lägger till en ny kategori i databasen dyker den upp
*  på hemsidan direkt :D
*/
function create_product($product_query, $user) {
    //$products = $connection->query("SELECT * FROM Products where ProductType='".$category_array[0]."';");
    if ($product_query->num_rows > 0) {
        while($product = $product_query->fetch_assoc()) {
            $url = "Productpage.php?ProductNumber=".$product["ProductNumber"];
            user_link($url,$product["ProductName"], $user);
            //echo "<li><a href='Productpage.php?ProductNumber=".$product["ProductNumber"]."'>".$product["ProductName"]."</a></li>";
        }
    }
}

function create_category($user) {

    $connection = server_connect();
    $categories = $connection->query("SELECT * FROM ProductCategories;");
    while ($category = $categories->fetch_assoc()) {
        echo "<li><a>".$category["sitelink"]."</a><ul>";
        create_product($connection->query("SELECT * FROM Products where ProductType='".$category["Category"]."';"), $user);
        echo "</ul></li>";
    }
    $connection ->close();
}
?>
<div id="container">
    <div id="header">


        <h1>Pencil.in</h1>
        <h3>Botemedlet mot dåliga pennor</h3>
        <p>Användare: <?php echo $user["CustomerID"]; ?></p>


    </div>
    <div class="nav">

        <ul>

            <li>
                <?php user_link("Home.php","Hem", $user);?>
            </li>
            <?php
                create_category($user);
            ?>
            <li>
                <?php user_link("User.php","Användarsida", $user);?>
                <!-- <a href="User.php">Användarsida</a> -->
            </li>
            <li>
                <?php user_link("Home.php","Logga ut", NULL);?>
            </li>
            <div class="shoppingcart">
                <li>
                    <a href="Shoppingcart.php">
                        <img src="Bilder/shoppingcart.png" width="50px" height="50px" >
                    </a>

                </li>

            </div>

        </ul>


    </div>




</div>
