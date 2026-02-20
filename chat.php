<?php
// Include the database configuration file
include_once 'dbConfig.php';

// Create database connection
$connection = new mysqli($server, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <!--CSS -->
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    
    <!--title -->
    <title>Chat List | Travel Mate</title>
    <link rel="shortcut icon" type="image/png" href="/img/TRavel-Mate-favicon.png">

</head>
<body>
<?php include 'navbar.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>
<img src="img/user-banner.png" class="img-fluid" alt="">
<div class="myWrapper">
<section class="chat-area">
    <header>
        <?php
        $user_email = isset($_GET['user_email']) ? $_GET['user_email'] : '';
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        ?>
    <div class="content">
             <a class="back-icon" href="chatlist.php"><i class="bi bi-arrow-left"></i></a>
            <img src="<?php echo htmlspecialchars($row['image_path'] ?? ''); ?>" alt="">
            <div class="details">
                <span><?php echo htmlspecialchars($row['name'] ?? ''); ?></span>
                <p><?php echo htmlspecialchars($row['status'] ?? ''); ?></p>
            </div>
    </div>
    </header>
    <div class="chat-box">
        
    </div>

    <form action="#" class="typing-area">
        <input name="outgoing_id" type="text" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" hidden>
        <input name="incoming_id" class="incoming_id" type="text" value="<?php echo htmlspecialchars($user_email); ?>" hidden>
        <input name="message" class="input-field" type="text" placeholder="Type a message here...">
        <button><i class="bi bi-cursor-fill"></i></button>
    </form>
</section>

</div>


<!-- footer -->
<script src="assets/chat.js"></script>
<?php include 'footer.php';?>