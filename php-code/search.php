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

$searchTerm = $_POST['searchTerm'];
$output = "";
$outgoing_id = $_SESSION['email'];
$searchPattern = '%' . $searchTerm . '%';

$stmt = $connection->prepare("SELECT * FROM users WHERE email != ? AND userType = 'tourGuide' AND (name LIKE ? OR country LIKE ?) ORDER BY id DESC");
$stmt->bind_param("sss", $outgoing_id, $searchPattern, $searchPattern);
$stmt->execute();
$query = $stmt->get_result();

if ($query->num_rows > 0) {
    include 'data.php';
} else {
    $output .= "No user found related to your search term.";
}
echo $output;
?>
