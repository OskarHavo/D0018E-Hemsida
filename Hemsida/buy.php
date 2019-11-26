
<?php
/* Det här fungerar het enkelt som ett script som lägger till en produkt i varukorgen */
    include_once($_SERVER['DOCUMENT_ROOT']."/redirect.php");
    $productID = $_GET["ProductNumber"];
    //$user = verifySession($_GET["sessionID"]);
    if (!$user) {
        redirect($_SERVER['HTTP_REFERER']);
    }
    $connection = server_connect();
    $username = (($connection->query("SELECT CustomerID FROM Sessions WHERE SessionID=".$sessionID))->fetch_assoc())["CustomerID"];



    /* Återgå till produktsidan, fiffigt va?*/
    //redirect($_SERVER['HTTP_REFERER']);
?>
<!DOCTYPE html>
<html>
    <p>test</p>
</html>
