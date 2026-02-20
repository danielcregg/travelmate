<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'auth';

// Only initialize session messages if not already set
if (!isset($_SESSION["regis_message"])) {
    $_SESSION["regis_message"] = '';
}
if (!isset($_SESSION["message"])) {
    $_SESSION["message"] = '';
}
?>
