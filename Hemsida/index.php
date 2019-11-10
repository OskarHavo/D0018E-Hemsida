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
        $sql = "SELECT ProductName FROM Products WHERE ProductType='Bläckpenna'";
        $result = $conn->query($sql);

        /*
        Det här kommer inte funka, eftersom jag har tagit bort privilegier :)
        */
        $sql_invalid = "INSERT INTO Products(ProductName,ProductType,ProductColor, ProductNumber, ProductPrice, InStock) VALUES('DOES_NOT_COMPUTE','NADA','NULL','1111','1111','0');";
        $result_invalid = $conn->query($sql_invalid);

        if ($result->num_rows > 0) {
            // output data of each row
            echo "Våra bläckpennor: <br>";
            while($row = $result->fetch_assoc()) {
                echo "Produkt: ".$row["ProductName"]." Färg: ".$row["ProductColor"]." Produktnummer: ".$row["ProductNumber"]." Pris: ".$row["ProductPrice"]." I lager: ".$row["InStock"]."<br>";
            }

        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </body>
</html>
