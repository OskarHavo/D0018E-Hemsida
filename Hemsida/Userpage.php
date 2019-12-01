<?php
	    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
	    include_once($_SERVER['DOCUMENT_ROOT']."/server_connect.php");
	
	    require_login();
        if ($user["root"]) {
            redirect("Admin.php?sessionID=".$user["SessionID"]);
        }
	
	function create_orders() {
	    global $user;
	    $connection = server_connect();
	    $query = $connection->query("SELECT OrderID, Quantity, ProductNumber, Price FROM Orders WHERE CustomerID='".$user["CustomerID"]."' AND Price IS NOT NULL;");
	    if ($query->num_rows > 0) {
	        while ($row = $query->fetch_assoc()) {
	            /* Det här är bara en massa <tr> med <td> inuti. */
	            echo "<tr>";
	            echo    "<td>".$row["OrderID"]."</td>";
	            echo    "<td>".$row["ProductNumber"]."</td>";
	            echo    "<td>".$row["Quantity"]."</td>";
	            echo    "<td>".$row["Price"].":-</td>";
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
	
	    <body onload="setSessionID('<?php echo fetchSessionID();?>')">
	
	
	        <?php include("navbar.php"); ?>
	
	          <div id="container">
	
	            <div id="userpagerubric">
	                <p>Mina Ordrar (<?php echo $user["CustomerID"];?>)</p>
                    
	            </div>
	
	            <div id="orderdiv">
	            <table class="userpage-table">
	                <tbody>
	                    <tr>
	                        <th scope="row">Ordernummer</th>
	                        <td>Produktnummer<td>
	                        <td>antal</td>
	                        <td>Pris</td>
	                    </tr>
	                    <?php
	                        create_orders();
	                    ?>
	                </tbody>
	
	            </table>
	            </div>
	            <div id="logoutdiv">
	                <p><a href="logout.php">Logga ut</a></p>
	            </div>
                <button class="cancelaccountdiv" onclick="taBortKontoKnapp()">
                  
                  <p>Ta bort konto</p>
                  </button>
	
	
	        </div>
	
	
	    </body>
	</html>
