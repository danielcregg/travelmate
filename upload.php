<?php
session_start();
// Include the database configuration file
include 'dbConfig.php';

// Create database connection
$connection = new mysqli($server, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// File upload path
$targetDir = "./uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$email = $_SESSION['email'];

// Get user ID using prepared statement
$stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$userID = "";
if ($row = $result->fetch_assoc()) {
    $userID = $row['id'];
}

if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
    $fileName = basename($_FILES["file"]["name"]);
    // Sanitize filename to prevent directory traversal
    $fileName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $fileName);
    // Add unique prefix to prevent overwrites
    $fileName = uniqid() . '_' . $fileName;
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $caption = $_POST['caption'];

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Insert image file name into database using prepared statement
            $stmt = $connection->prepare("INSERT INTO images (file_name, uploaded_on, caption, OwnerID) VALUES (?, NOW(), ?, ?)");
            $stmt->bind_param("ssi", $fileName, $caption, $userID);
            if ($stmt->execute()) {
                $_SESSION["statusMsg"] = "The file has been uploaded successfully.";
            } else {
                $_SESSION["statusMsg"] = "File upload failed, please try again.";
            }
        } else {
            $_SESSION["statusMsg"] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $_SESSION["statusMsg"] = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
    }
} else {
    $_SESSION["statusMsg"] = 'Please select a file to upload.';
}

$connection->close();
header("Location: gallery.php");
exit;
?>
