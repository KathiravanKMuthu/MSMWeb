<?php
/* Database credentials. Assuming you are running MySQL server with default setting (user 'root' with no password) */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'vmm_db');

/* Attempt to connect to MySQL database */
$mysqli_connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli_connection === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

