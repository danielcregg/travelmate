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

    $outgoing_id = $_SESSION['email'];
    $incoming_id = mysqli_real_escape_string($connection, $_POST['incoming_id']);
    $output = "";

    $stmt = $connection->prepare("SELECT * FROM messages
            LEFT JOIN users ON email = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?) OR
            (outgoing_msg_id = ? AND incoming_msg_id = ?) ORDER BY msg_id ASC");
    $stmt->bind_param("ssss", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
    $stmt->execute();
    $query = $stmt->get_result();

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . htmlspecialchars($row['msg']) . '</p>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <img src="' . htmlspecialchars($row['image_path']) . '" alt="">
                                <div class="details">
                                   <p>' . htmlspecialchars($row['msg']) . '</p>
                                </div>
                            </div>';
            }
        }
        echo $output;
    }

} else {
    header("Location: ../login.php");
    exit;
}
?>
