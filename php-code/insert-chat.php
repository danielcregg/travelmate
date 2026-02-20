<?php
session_start();
if (isset($_SESSION['email'])) {
    include_once '../dbConfig.php';
    // Create database connection
    $connection = new mysqli($server, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $outgoing_id = $_POST['outgoing_id'];
    $incoming_id = $_POST['incoming_id'];
    $message = $_POST['message'];

    if (!empty($message)) {
        $stmt = $connection->prepare("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $incoming_id, $outgoing_id, $message);
        $stmt->execute();
    }

} else {
    header("Location: ../login.php");
    exit;
}
?>
