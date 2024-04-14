<?php
    session_start();
    include_once './config.php';
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $indianPhoneRegex = '/^[789]\d{9}$/';
    if(!empty($email) && !empty($password)) {
        if (filter_var($email)){            
            $search_email = "SELECT * FROM signup WHERE email = '$email'";
            $search_email_query = mysqli_query($con, $search_email);
            if(mysqli_num_rows($search_email_query) > 0) {
                $row = mysqli_fetch_assoc($search_email_query);
                $databasePassword = $row['password'];
                if(password_verify($password, $databasePassword) ) {
                    if($row['status'] == 'active') {
                        $_SESSION['year'] = $row['year'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['email'] = $_SESSION['otpEmail'] = $row['email'];
                        $_SESSION['uniqueId'] = $row['uniqueId'];
                        echo 'success';
                    }else {
                        echo "Account under verification, it will take 2-3 office days to verify your account!";
                    }
                }else {
                    echo "Password isn't matching";
                }
            }else {
                echo 'Phone number not found';
            }
        }else {
            echo "Please enter a valid phone number!";
        }
    }else {
        echo "No field should be empty";
    }
?>
