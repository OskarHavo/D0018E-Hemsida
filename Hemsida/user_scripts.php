<?php
/* Den här funktionen skapar en "form" som gör samma sak som knappen där man loggar in.
*  Ganska ineffektivt att användaren måste valideras för varje sida som personen besöker,
*  men vi skulle ju inte använda kakor.
*
*/
function user_link($url,$text, $user) {
    echo "<form action=".$url." method='post'>
                <fieldset>
                    <input type='hidden' name='username' value='".$user["CustomerID"]."' >
                    <input type='hidden' name='password' value='".$user["Password"]."'>
                    <input type='submit' value='".$text."'>
                </fieldset>
            </form>";
}


?>
