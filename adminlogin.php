<?php
    session_start();
    include_once './php/config.php';

    // Check if the form is submitted
    if(isset($_POST['submit'])) {
        // Retrieve username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM signup WHERE role = 'admin'";
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if(password_verify($password, $user['password'])) {
                $_SESSION['adminlogin'] = true;
                header('Location: admin_page.php'); 
                exit;
            } else {
                echo "<script>alert('Invalid username or password');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: 200% auto;
            animation: gradient 10s linear infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"]  {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #f4f4f4;
            font-size: 16px;
        }
        
        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="number"],
        input[type="password"] {
            color: #aaa;
        }
        
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 20px 0;
            border: none;
            border-radius: 5px;
            background: linear-gradient(to right, #ff5f6d, #ffc371);
            font-size: 16px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        input[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="color: #333;">Admin Login</h2>
        <form action="#" method="POST">
            <input type="text" name="username" placeholder="Enter Username">
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" value="Login" name="submit">
        </form>
    </div>
    <div class="modal-overlay">
        <div class="modal-content">
        </div>
    </div>
</body>
</html>
