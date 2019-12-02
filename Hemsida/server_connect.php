<?php

/* Källa: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php*/
function server_connect($username="customer",$password="") {
    // Koppla upp mot servern.
    $servername = "localhost";
    //$username = "customer";
    //$password = "";
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

/*
*  Här vore det bra om vi får till ett prepared statement.
*  Det behövs inte, men det täpper ju till ett par säkerhetshål.
*/
function validate_user($username, $password, $connection) {
    //$stmt = $connection->prepare("select Password from Accounts where CustomerID= ?");
    /*if (!($stmt = $connection->prepare("select Password from Accounts where '1'='1';"))) {
        echo "Prepare failed: (" . $connection->errno . ") " . $connection->error;
    }
    //$stmt->bindParam('s',$username);
    if (!$stmt->bindParam('s',$username)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }*/
    //$stmt->execute();
    /*
    $query_result = $connection->query("select Password from Accounts where CustomerID='".$username."';");

    if (!$query_result) {
        echo "Error executing query: (" . $connection->errno . ") " . $connection->error;
        return;
    }*/


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

        $root_query = $connection->query("SELECT root FROM Accounts where CustomerID='".$_POST["username"]."';");
        $root = $root_query->fetch_assoc();
        $_SESSION["root"] = $root["root"];
        $connection->close();
    } else if (!isset($_SESSION["CustomerID"])) {
        redirect("Login.php");

    }
}

?>
