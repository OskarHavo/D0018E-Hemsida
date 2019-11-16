<?php
/* Källa: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php*/
function server_connect() {
    // Koppla upp mot servern.
    $servername = "localhost";
    $username = "customer";
    $password = "";
    $dbname = "website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kolla om uppkopplingen gick bra.
    if ($conn->connect_error) {
        redirect("/404.html");   // Error 404
    }

    return $conn;
}

function validate_password($username, $password, $connection) {
    //$stmt = $connection->prepare("select Password from Accounts where CustomerID= ?");
    if (!($stmt = $connection->prepare("select Password from Accounts where '1'='1';"))) {
        echo "Prepare failed: (" . $connection->errno . ") " . $connection->error;
    }
    //$stmt->bindParam('s',$username);
    if (!$stmt->bindParam('s',$username)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    //$stmt->execute();
/*
    $query_result = $connection->query("select Password from Accounts where CustomerID='".$username."';");

    if (!$query_result) {
        echo "Error executing query: (" . $connection->errno . ") " . $connection->error;
    }
    $hash_password = $query_result->fetch_assoc();
    $salt = explode("$", $hash_password["Password"])[3];
    $crypto_password = crypt($password,'$6$rounds=5000$'.$salt.'$');

    if ($crypto_password == $hash_password["Password"]) {
        echo "password is correct";
    } else {
        echo "password did not match <br>";
        echo "password: ". $crypto_password."<br>";
        echo "hash: ". $hash_password["Password"];
    }
    */
}
?>
