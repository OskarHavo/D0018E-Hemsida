<?php
session_start();
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

$comment_query = $conn->query("SELECT * FROM Comments WHERE ProductNumber='$productID';");
$query_result = $conn->query("SELECT * FROM Products WHERE ProductNumber='$productID';");


if (!$query_result || !$comment_query) {
    echo "Error executing query: (" . $conn->errno . ") " . $conn->error;
}

/* Hämta produkten vi söker från resultatet */
$product = $query_result->fetch_assoc();
$instock = $product["InStock"];
$productnumber = $product["ProductNumber"];
// Kolla om produkten faktiskt finns
if (!$product || !$product["InStore"]) {
    $conn->close();
    redirect("404.html");
}


/*      * Tips: För att komma åt en variabel i en funktion
        * som skapades utanför funktionen så måste man
        * antingen skicka med variabeln som ett argument
        * eller skriva "global <variabel>" inuti funktionen.
        */
function create_comments() {
    global $comment_query;
    global $has_comment;
    if ($comment_query->num_rows > 0) {
        while($comment = $comment_query->fetch_assoc()){
            echo "<tr><td>".$comment["CustomerID"]. "</td><td>".$comment["Comment"]." </td><td>Betyg: ".$comment["rating"] ."</td></tr>";
            if ($comment["CustomerID"] == $_SESSION["CustomerID"]) {
                $has_comment = TRUE;
            }
        }
    } else {
        echo "Var först med att lägga en recension!";
    }
}





/* Rensa resultatet och koppla från servern. */
mysqli_free_result($query_result);
mysqli_free_result($query_result2);
$conn->close();
?>
<script>

    function openFormReview() {
        document.getElementById("recensionform").style.display = "block";
    }

    function closeFormReview() {
        document.getElementById("recensionform").style.display = "none";
    } 


    function greenBuyColor(){
    }


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

            <div id="product">
                <div id="imagediv"><img src="Bilder/<?php echo $product["ProductNumber"]?>.png"></div>

                <div class="list">
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

                    <div id="buy_product">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/buy_product.php");?>
                    </div>

                </div>



            </div>

            <div class = reviewdivrubric>
                <p>  Recensioner  </p>
            </div>    




            <div id = "reviewdiv">

                <table class="review-table">
                    <tbody>
                        <?php
                        create_comments();
                        ?>
                    </tbody>
                </table>

            </div>
            <?php
            if (isset($_SESSION["CustomerID"]) && !$has_comment) {
                echo "<button class='openFormButton' onclick='openFormReview()'>Lämna en recension!</button>";
            }
            ?>
            <!--  https://www.w3schools.com/howto/howto_js_popup_form.asp -->
            <div class="form-popup" id="recensionform">
                <form action="/leave_review.php" class="form-container" method="post">
                    <h1>Skriv din recension!</h1>
                    <label for="kommentar"><b>Kommentar:</b></label>
                    <input type="text" placeholder="Lämna din kommentar" name="comment" required>
                    <label for="betyg"><b>Betyg:</b></label>
                    <input type="number" placeholder="Ge ett betyg mellan 1-10" name="rating" max="10" min="1" required>
                    <input type="hidden" name="ProductNumber" value="<?php echo $product["ProductNumber"];?>">
                    <button type="submit" class="knapp">Skicka in din recension!</button>
                    <button type="button" class="knapp avbryt" onclick="closeFormReview()">Stäng formuläret</button>
                </form>
            </div>
        </div>
    </body>
</html>
