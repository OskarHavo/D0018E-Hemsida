<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>

    <body >
        <?php include("navbar.php"); ?>
        <div id="container">

            <div id="shoppingcartrubric">
                <p>Min Shoppingvagn</p>
            </div>

            <table class="shoppingcart-table">
                <tbody>
                    <tr>
                        <th scope="row">Bild</th>
                        <td>Produktnamn</td>
                        <td>Antal<td>
                        <td>Pris</td>
                        <td>kryss</td>
                    </tr>

                </tbody>
            </table>  
            <div id="shoppingcartcheckout">
                <p>Total Summa = x kr</p>
            </div>
            <div id="shoppingcartcheckoutbutton">
                <p>Check out</p>
            </div>


        </div>

    </body>
</html>
