<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "root";
    $db_name = "sweetwater";


/* Open SQL connection */
function openConnection() {
    global $db_host, $db_user, $db_pass, $db_name;
    $conn = new mysqli($db_host,$db_user,$db_pass,$db_name) or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}
 
/* Close SQL connection */
function closeConnection($conn) {
    $conn -> close();
}
?>