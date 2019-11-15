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
        redirect("404.html");   // Error 404
    }
    return $conn;
}

function validate_password($username, $password) {
    $connection = server_connect();
    $query_result = $connection->query("select Password from Accounts where UserID='robin';");
    if (!$query_result) {
        echo "Error executing query: (" . $connection->errno . ") " . $connection->error;
    }
    $product = $query_result->fetch_assoc();
    $salt = explode("$", $password)[3];
    $crypto_password = crypt($password,'$6$rounds=5000$'.$salt.'$');

    if ($crypto_password == $hash_password) {
        echo "password is correct";
    }
}
?>
