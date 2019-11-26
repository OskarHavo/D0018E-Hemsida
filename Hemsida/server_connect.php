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
    $connection->query("INSERT INTO Accounts VALUES('".$username."','".$crypto_password."');");
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
        $key_query = $connection->query("SELECT * FROM Sessions WHERE CustomerID='".$user["CustomerID"]."';");
        if ($key_query->num_rows > 0) {
            $key = $key_query->fetch_assoc();
            return $key["SessionID"];
        }

        $key = create_session_ID();
        $connection->query("INSERT INTO Sessions values('".$key."','".$user["CustomerID"]."');");

        return $key;
    }
    return NULL;
}

function logout($connection) {
    $session = $_GET["sessionID"];
    //$query = $connection->query("SELECT SessionID FROM Sessions WHERE SessionID=". $session);

    //if ($query->fetch_assoc() == $session) {
    $connection->query("DELETE FROM Sessions WHERE SessionID='". $session."';");
    //}
}

function include_navbar($user) {
    include("navbar.php");
}

function create_session_ID() {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $charsize = strlen($chars);
    $result = "";
    for ($i = 0; $i < 128; $i++) {
        $result .= $chars[rand(0, $charsize-1)];
    }
    return $result;
}


function fetchSessionID() {
    $session = $_GET["sessionID"];
    if (!$session) {

        //return create_session_ID();
        return ;
    } else {
        if (verifySession($session)) {
            return $session;
        }
        return;
    }
}

/*
* Här behöver definitivt ett prepared statement.
* Den här funktionen måste köras innan vi t.ex.
* Lägger till saker i varukorgen.
*/
function verifySession($session) {
    $connection = server_connect();
    $query = $connection->query("SELECT CustomerID FROM Sessions WHERE SessionID='$session';");
    $connection->close();
    if ($query->num_rows == 1) {
        return ($query->fetch_assoc())["CustomerID"];
    } else {
        // throw error;
        return NULL;
    }

}

?>
