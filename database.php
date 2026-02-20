<?php
session_start();
include 'dbConfig.php';

// Connect to database
$connection = new mysqli($server, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'registration':
            if ($_POST['password'] === $_POST['confirm_password']) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $userType = $_POST['userType'];
                $status = "Active now";

                $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $check_result = $stmt->get_result();

                if ($check_result->num_rows > 0) {
                    $_SESSION["regis_message"] = 'This email is already registered! Please try again.';
                    header("Location: register.php");
                    exit;
                }

                $stmt = $connection->prepare("INSERT INTO users(email, password, name, userType, status) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $email, $hashedPassword, $name, $userType, $status);

                if ($stmt->execute()) {
                    $_SESSION['username'] = $name;
                    $_SESSION['email'] = $email;

                    if ($userType == 'traveler') {
                        header("Location: index.php");
                        exit;
                    } else {
                        header("Location: userProfile.php");
                        exit;
                    }
                } else {
                    $_SESSION["regis_message"] = 'Something went wrong, please retry.';
                    header("Location: register.php");
                    exit;
                }
            } else {
                $_SESSION["regis_message"] = 'Password and confirm password do not match, please retry.';
                header("Location: register.php");
                exit;
            }
            break;

        case 'login':
            $email = $_POST['email'];
            $password = $_POST['password'];

            $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['username'] = $row['name'];
                    $status = "Active now";

                    $stmt = $connection->prepare("UPDATE users SET status = ? WHERE email = ?");
                    $stmt->bind_param("ss", $status, $row['email']);
                    $stmt->execute();

                    header("Location: index.php");
                    exit;
                } else {
                    $_SESSION["message"] = 'Wrong password';
                    header("Location: login.php");
                    exit;
                }
            } else {
                $_SESSION["message"] = 'No user with that email in database';
                header("Location: login.php");
                exit;
            }
            break;
    }
}

$connection->close();
?>
