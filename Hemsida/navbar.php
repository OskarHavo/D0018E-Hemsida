<?php
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");


function create_product($product_query) {
    if ($product_query->num_rows > 0) {
        while($product = $product_query->fetch_assoc()) {
            if ($product["InStore"]) {
                echo "<li><a href='Productpage.php?ProductNumber=".$product["ProductNumber"]."'>".$product["ProductName"]."</a></li>";
            }
        }
    }
}

function create_category() {

    $connection = server_connect();
    $categories = $connection->query("SELECT * FROM ProductCategories;");
    while ($category = $categories->fetch_assoc()) {
        echo "<li><a href='product_list.php?category=".$category["Category"]."'>".$category["sitelink"]."</a><ul>";    /* Det här är "Bläckpenna" */
        create_product($connection->query("SELECT * FROM Products where ProductType='".$category["Category"]."';"));
        echo "</ul></li>";
    }
    $connection ->close();
}
?>
<script>

    function openForm() {
        document.getElementById("userform").style.display = "block";
    }

    function closeForm() {
        document.getElementById("userform").style.display = "none";
    } 



</script>

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
                <a href="Userpage.php">Användarsida</a>
            </li>
            <div class="shoppingcart">
                <li>
                    <a href="Shoppingcart.php">
                        <img src="Bilder/shoppingcart.png" width="50px" height="50px" >
                    </a>

                </li>

            </div>
            <div <?php if (!$_SESSION["ShoppingcartID"]) {echo "hidden";} ?>class = "shoppingcartamount">
                <a><?php echo $_SESSION["CartQuantity"];?></a>
            </div>

        </ul>

        <?php
        if (isset($_SESSION["CustomerID"])) {
            include_once($_SERVER['DOCUMENT_ROOT']."/userform.php");
        }
        ?>



    </div>
