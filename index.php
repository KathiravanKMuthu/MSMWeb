<?php
if(!isset($_SESSION)){
    session_start();
}  
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: views/admin_login.php");
	exit;
}  
?>