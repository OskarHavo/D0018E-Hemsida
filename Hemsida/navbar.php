<?php
include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");

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
        echo "<li><p>".$category["sitelink"]."</p><ul>";    /* Det här är "Bläckpenna" */
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
                <!--<a href="Home.php">Hem</a> -->
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

        </ul>

        <button class="openFormButton" id="userformbutton" onclick="openForm()">Du är inloggad som användare XXX</button>
    </div>

    <div class="form-popup" id="userform">
        <form action="logout.php" class="form-container">
            <h1>Du är inloggad som XXX</h1>

            <button type="submit" class="knapp">Logga ut!</button>
            <button type="button" class="knapp avbryt" onclick="closeForm()">Avbryt</button>
        </form>
    </div> 




</div>
