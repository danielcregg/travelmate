<?php
session_start();

if (isset($_SESSION['email'])) {
    // Include the database configuration file
    include_once 'dbConfig.php';

    // Create database connection
    $connection = new mysqli($server, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $logout_email = $_SESSION['email'];
    $status = "Offline now";

    $stmt = $connection->prepare("UPDATE users SET status = ? WHERE email = ?");
    $stmt->bind_param("ss", $status, $logout_email);
    $stmt->execute();

    $connection->close();

    session_unset();
    session_destroy();
}

header("Location: index.php");
exit;
?>
