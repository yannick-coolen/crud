<?php   //config.php
require_once("login.php");
// make connection with database
$con = new mysqli($hn, $un, $pw, $db);
// if connection breaks, send back message
if ($con->connect_error) die ("Fatal Error");

//SET variables into string
function get_post($con, $var) {
    return $con->real_escape_string($_POST[$var]);
}
?>