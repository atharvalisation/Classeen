<?php
session_start();
include_once './php/config.php';

$password = "gpmadminpanelpassword123";
$encrypt_password = password_hash($password, PASSWORD_ARGON2ID);

// Use prepared statements to prevent SQL injection
$insert = "INSERT INTO signup(fullName, email, password, role, otp, uniqueId, status, year)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($con, $insert);
if ($stmt) {
    $fullName = 'admin';
    $email = 'admin@example.com';
    $role = 'admin';
    $otp = '111111';
    $uniqueId = '0';
    $status = 'active';
    $year = 'admin';

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ssssssss", $fullName, $email, $encrypt_password, $role, $otp, $uniqueId, $status, $year);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($con);
}

// Close the connection
mysqli_close($con);
?>
