<!DOCTYPE html>
<!--
Här är en test som ansluter till servern och hämtar lite data.
Om du märker att det inte finns något username och password: sätt inte dit något.

Just nu går det dessutom bara att använda SELECT på Products.
-->

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
        $servername = "localhost";
        $username = "";
        $password = "";
        $dbname = "website";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM Products WHERE ProductNumber='3003'";
        $result = $conn->query($sql);

        /*
        Det här kommer inte funka, eftersom jag har tagit bort privilegier :)
        */
        $sql_invalid = "INSERT INTO Products(ProductName,ProductType,ProductColor, ProductNumber, ProductPrice, InStock) VALUES('DOES_NOT_COMPUTE','NADA','NULL','1111','1111','0');";
        $result_invalid = $conn->query($sql_invalid);

        if ($result->num_rows > 0) {
            // output data of each row
            echo "Våra reservoarpennor: <br>";
            //while($row = $result->fetch_assoc()) {
            //    echo "Produkt: ".$row["ProductName"]." Färg: ".$row["ProductColor"]." Produktnummer: ".$row["ProductNumber"]." Pris: ".$row["ProductPrice"]." I lager: ".$row["InStock"]."<br>";
            //    echo "<a href='index.php?ProductNumber=".$row['ProductNumber'],"'>penna</a> <br>";
            //}
        } else {
            echo "0 results";
        }

        $test = $result->fetch_assoc();
        echo "hello ".$test["ProductName"];
        //$productCode = mysql_real_escape_string($_SERVER['QUERY_STRING']);

        /*
        * Bra info
        * https://www.w3schools.com/php/php_superglobals_server.asp
        */

        /* Hämta variablerna som finns i URL:en och stoppa in dom i en lista*/
        $query = $_SERVER['QUERY_STRING'];
        parse_str($query,$parse_query);
        //echo $parse_query["ProductNumber"];

        /* Den här öppnar 404.html om ett produktnummer inte finns */
        if ($parse_query["ProductNumber"] == NULL) {
            echo "<meta http-equiv='refresh' content='0;url=404.html'>";
        }

        mysql_free_result($result[0]);
        $conn->close();
        ?>
    </body>
</html>
