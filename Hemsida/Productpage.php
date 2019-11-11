<?php
    /* Källa: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php*/
    function redirect($url, $statusCode = 303) {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
?>
<?php
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "website";
    $productID = $_GET["ProductNumber"];    // Produktnummer från URL

    // Koppla upp mot servern.
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kolla uppkopplingen.
    if ($conn->connect_error) {
            redirect("404.html");
    }

    /*
    * Bra info
    * https://www.w3schools.com/php/php_superglobals_get.asp
    */

    /* Den här öppnar 404.html om ett produktnummer inte finns */
    if ($productID == NULL) {
        redirect("404.html");
    }

    $sql_query = "SELECT * FROM Products WHERE ProductNumber='".$productID."'";
    $query_result = $conn->query($sql_query);

    $product = $query_result->fetch_assoc();


    //while($row = $query_result->fetch_assoc()) {
    //        echo "Produkt: ".$row["ProductName"]." Färg: ".$row["ProductColor"]." Produktnummer: ".$row["ProductNumber"]." Pris: ".$row["ProductPrice"]." I lager: ".$row["InStock"]."<br>";
    //}
    //echo $query_result["ProductNumber"];
    //$conn->close();
    //echo $query_result["ProductNumber"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">


    </head>
    <body>
        <div id="container">

            <div id="header">

                <h1>Pencil.in</h1>
                <h3>Botemedlet mot dåliga pennor</h3>
            </div>

            <div class="nav">

                <ul>

                    <li>
                        <a href="Home.html">Hem</a>
                    </li>
                    <li>
                        <a>Bläckpennor</a>
                        <ul>
                            <li><a href="Productpage.php?ProductNumber=1001">Penna1</a></li>
                            <li><a href="Productpage.php?ProductNumber=1002">Penna2</a></li>
                            <li><a href="Productpage.php?ProductNumber=1003">Penna3</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Blyertspennor</a>
                        <ul>
                            <li><a href="Productpage.php?ProductNumber=2001">Penna1</a></li>
                            <li><a href="Productpage.php?ProductNumber=2002">Penna2</a></li>
                            <li><a href="Productpage.php?ProductNumber=2003">Penna3</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Resevoarpennor</a>
                        <ul>
                            <li><a href="Productpage.php?ProductNumber=3001">Penna1</a></li>
                            <li><a href="Productpage.php?ProductNumber=3002">Penna2</a></li>
                            <li><a href="Productpage.php?ProductNumber=3003">Penna3</a></li>
                        </ul>
                    </li>

                    <li>
                         <a href="User.html">Användarsida</a>
                    </li>
                    <div class="shoppingcart">
                        <li>
                            <a href="Shoppingcart.html">
                                <img src="shoppingcart.png" width="50px" height="50px" >
                            </a>

                        </li>

                    </div>

                </ul>


            </div>


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
                        <td><?php echo $product["ProductPrice"]?> kr</td>
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
<?php
    mysql_free_result($query_result);
?>