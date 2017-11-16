<?php
if(!isset($_SESSION)){
    session_start();
}

if(session_destroy()) // Destroying All Sessions
{
header("Location: ../index.php"); // Redirecting To Home Page
}
?>