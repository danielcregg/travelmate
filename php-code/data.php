<?php
    while ($row = $query->fetch_assoc()) {
        $incoming_email = $row['email'];

        $stmt2 = $connection->prepare("SELECT * FROM messages WHERE (incoming_msg_id = ? OR outgoing_msg_id = ?)
                AND (outgoing_msg_id = ? OR incoming_msg_id = ?) ORDER BY msg_id DESC LIMIT 1");
        $stmt2->bind_param("ssss", $incoming_email, $incoming_email, $outgoing_id, $outgoing_id);
        $stmt2->execute();
        $query2 = $stmt2->get_result();
        $row2 = $query2->fetch_assoc();

        if ($query2->num_rows > 0) {
            $result = $row2['msg'];
        } else {
            $result = "No message available.";
        }

        $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;
        $you = (isset($row2['outgoing_msg_id']) && $outgoing_id == $row2['outgoing_msg_id']) ? "You: " : "";
        $offline = ($row['status'] == "Offline now") ? "offline" : "";

        $output .= ' <a href="chat.php?user_email=' . htmlspecialchars($row['email']) . '">
                    <div class="content">
                        <img src="' . htmlspecialchars($row['image_path']) . '" alt="">
                        <div class="details">
                        <span>' . htmlspecialchars($row['name']) . ' - <span class="text-muted">' . htmlspecialchars($row['country']) . '</span> </span>
                        <p>' . htmlspecialchars($you . $msg) . '</p>
                        </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="bi bi-circle-fill"></i></div>
                </a>';
    }
?>
