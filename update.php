<?php
session_start();
include 'dbConfig.php';

// Connect to database
$connection = new mysqli($server, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$imagePath = $_POST['imagePath'];
$country = $_POST['country'];
$bio = $_POST['bio'];
$email = $_SESSION['email'];

$stmt = $connection->prepare("UPDATE users SET country = ?, bio = ?, image_path = ? WHERE email = ?");
$stmt->bind_param("ssss", $country, $bio, $imagePath, $email);

if ($stmt->execute()) {
    $_SESSION["update_message"] = 'Profile updated!';
    header("Location: userProfile.php");
    exit;
} else {
    $_SESSION["update_message"] = 'Something went wrong, please try again.';
    header("Location: updateProfile.php");
    exit;
}

$connection->close();
?>
