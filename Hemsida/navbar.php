<?php

    // Koppla upp mot servern.
    $servername = "localhost";
    $username = "customer";
    $password = "";
    $dbname = "website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kolla om uppkopplingen gick bra.
    if ($conn->connect_error) {
        redirect("404.html");   // Error 404
    }

    $query_result = $conn->query("SELECT ProductName FROM Products WHERE ProductNumber='$productID'");

    /* Hämta produkten vi söker från resultatet */
    $product = $query_result->fetch_assoc();

    // Kolla om produkten faktiskt finns
    if (!$product) {
        $conn->close();
        redirect("404.html");
    }

    /* Rensa resultatet och koppla från servern. */
    mysqli_free_result($query_result);
    $conn->close();

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
                    <li>
                        <a>Bläckpennor</a>
                        <ul>
                            <li><a href="Productpage.php?ProductNumber=1001"><?php echo "SELECT ProductName FROM Products WHERE ProductNumber='1001'";?></a></li>
                            <li><a href="Productpage.php?ProductNumber=1002"><?php echo "SELECT ProductName FROM Products WHERE ProductNumber='1002'";?></a></li>
                            <li><a href="Productpage.php?ProductNumber=1003"><?php echo "SELECT ProductName FROM Products WHERE ProductNumber='1003'";?></a></li>
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
