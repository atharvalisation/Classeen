<?php
session_start();
include_once "./config.php";

if (isset($_SESSION['uniqueId'])) {
    $outgoing_id = $_SESSION['uniqueId'];
    $incoming_id = mysqli_real_escape_string($con, $_POST['incoming_id']);
    $output = "";
    
    $encryptionKey = "8fe4d50f2c9eb6a16c8e21548bde4e7a"; // Use a shorter key for IV
    $cipher = 'aes-256-cbc';
    $options = 0;

    $sql = "SELECT * FROM chat WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id')
        OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id');";
    $sql_query = mysqli_query($con, $sql);

    if (mysqli_num_rows($sql_query) > 0) {
        while ($row = mysqli_fetch_assoc($sql_query)) {
            // Use a shorter key as IV
            $iv = substr($encryptionKey, 0, 16);
            $decrypted_message = openssl_decrypt($row['message'], $cipher, $encryptionKey, $options, $iv);

            if ($row['outgoing_msg_id'] == $outgoing_id) {
                $output .= '
                        <div class="chat outgoing">
                            <div class="details">
                                <p>' . $decrypted_message . '</p>
                            </div>
                        </div>
                    ';
            } else {
                $output .= '
                        <div class="chat incoming">
                            <div class="details">
                                <p>' . $decrypted_message . '</p>
                            </div>
                        </div>
                    ';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
    }

    echo $output;
} else {
    header('location: ../sign-in.php');
}
?>
