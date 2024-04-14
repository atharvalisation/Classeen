<?php 
    session_start();
    include_once './config.php';
    if(isset($_SESSION['uniqueId'])) {
        $outgoiing_id = $_SESSION['uniqueId'];
        $incoming_id = $_POST['incoming_id'];
        $message = mysqli_real_escape_string($con, $_POST['message']);
        
        $encryptionKey = "8fe4d50f2c9eb6a16c8e21548bde4e7a079703192354ab4a52b0d3f217720005";
        $cipher = 'aes-256-cbc';
        $options = 0;
        $encrypt_Message = openssl_encrypt($message, $cipher, $encryptionKey, $options, $encryptionKey);

        $sql = "INSERT INTO chat(incoming_msg_id, outgoing_msg_id, message)
        VALUES('$incoming_id','$outgoiing_id','$encrypt_Message')";
        $sql_query = mysqli_query($con, $sql);
        if(!$sql_query) { 
            echo 'Failed to send chat';
        }
    }else {
        header('location: ../sign-in.php');
    }
?>
