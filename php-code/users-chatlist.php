<?php
session_start();
// Include the database configuration file
include_once '../dbConfig.php';

// Create database connection
$connection = new mysqli($server, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$outgoing_id = $_SESSION['email'];

$stmt = $connection->prepare("SELECT * FROM users WHERE email != ? AND userType = 'tourGuide' ORDER BY id DESC");
$stmt->bind_param("s", $outgoing_id);
$stmt->execute();
$query = $stmt->get_result();

$output = "";
if ($query->num_rows == 0) {
    $output .= "No users are available to chat";
} else {
    include_once "data.php";
}
echo $output;
?>
