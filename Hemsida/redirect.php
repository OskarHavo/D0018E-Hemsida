<?php
/* Källa: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php*/
function redirect($url, $statusCode = 303) {
    header('Location: ' . $url, true, $statusCode);
    die();
}
?>
