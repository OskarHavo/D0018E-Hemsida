<?php
        session_start();
	    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
	    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
	
	    login();
        if ($_SESSION["root"]) {
            redirect("Admin.php");
        }
	
	function create_orders() {
	    //global $user;
	    $connection = server_connect();
	    $query = $connection->query("SELECT OrderID, Quantity, ProductNumber, Price FROM Orders WHERE CustomerID='".$_SESSION["CustomerID"]."' AND Price IS NOT NULL;");
	    if ($query->num_rows > 0) {
	        while ($row = $query->fetch_assoc()) {
	            /* Det här är bara en massa <tr> med <td> inuti. */
	            echo "<tr>";
	            echo    "<td>".$row["OrderID"]."</td>"; 
        	    echo    "<td>".$row["ProductNumber"]."</td>"; 
	            echo    "<td>".$row["Quantity"]."</td>";
	            echo    "<td>".$row["Price"]*$row["Quantity"].":-</td>";
	            echo "</tr>";
	        }
	    }
	
	    $connection->close();
	}
	?>
<script>
function taBortKontoKnapp() {
  confirm("Är du säker att du vill ta bort ditt konto?");
}
</script>
	<!DOCTYPE html>
	<html>
	    <head>
	        <meta charset="utf-8">
	        <link rel="stylesheet" href="style.css">
	        <script src="javascripts.js"></script>
	    </head>
	
	    <body >
	
	
	        <?php include("navbar.php"); ?>
	
	          <div id="container">
	
	            <div id="userpagerubric">
	                <p>Mina Ordrar (<?php echo $_SESSION["CustomerID"];?>)</p>
                    
	            </div>
	
	            <div id="orderdiv">
	            <table class="userpage-table">
	                <tbody>
	                    <tr>
	                        <th scope="row">Ordernummer</th>
                            <th>Produktnummer</th>
	                        <th>Antal</th>
	                        <th>Pris</th>
	                    </tr>
	                    <?php
	                        create_orders();
	                    ?>
	                </tbody>
	
	            </table>
	            </div>
	            <div class= "liteknapp" id="logoutdiv">
	                <p><a href="logout.php">Logga ut</a></p>
	            </div>
                <form action="Delete_account.php">
                    <button class="cancelaccountdiv liteknapp" onclick="taBortKontoKnapp()">
                  
                  <p>Ta bort konto</p>
                  </button>
                </form>

	
	
	        </div>
	
	
	    </body>
	</html>
