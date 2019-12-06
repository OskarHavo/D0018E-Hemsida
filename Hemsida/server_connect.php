<?php

/* Källa: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php*/
function server_connect($username="customer",$password="") {
    // Koppla upp mot servern.
    $servername = "localhost";
    $dbname = "website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kolla om uppkopplingen gick bra.
    if ($conn->connect_error) {
        redirect("/404.html");   // Error 404
    }

    return $conn;
}


function find_user($username, $connection) {
    $query_result = $connection->query("select * from Accounts where CustomerID='".$username."';");
    if (!$query_result) {
        echo "Error executing query: (" . $connection->errno . ") " . $connection->error;
        return NULL;
    }
    $user = $query_result->fetch_assoc();
    if ($username != $user["CustomerID"]) {
        return NULL;
    }
    return $user;
}

function add_user($username, $password, $connection) {
    if (find_user($username,$connection)) {
        echo "The username is already taken";
        return;
    }
    $salt = rand(1000000,1000000000);
    $crypto_password = crypt($password,'$6$rounds=5000$'.$salt.'$');

    $connection->query("insert into Accounts(CustomerID, Password) values('".$username."','".$crypto_password."');");
    # "INSERT INTO Accounts(CustomerID,Password) VALUES('".$username."','".$crypto_password."');"
}


function validate_user($username, $password, $connection) {
    $user = find_user($username, $connection);
    if (!$user) {
        return NULL;
    }
    $salt = explode("$", $user["Password"])[3];
    $crypto_password = crypt($password,'$6$rounds=5000$'.$salt.'$');

    if ($crypto_password == $user["Password"]) {
        return $user;
    }
    return NULL;
}



function login() {
    //global $user;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $connection = server_connect();
        $user = validate_user($_POST["username"],$_POST["password"],$connection);

        //$connection->close();

        if (!$user) {
            redirect("Login.php");
        }
        $_SESSION["CustomerID"] = $_POST["username"];

        $_SESSION["root"] = $user["root"];
        $_SESSION["ShoppingcartID"] = $user["ShoppingcartID"];
        $connection->close();
    } else if (!isset($_SESSION["CustomerID"])) {
        redirect("Login.php");

    }
}

?>
