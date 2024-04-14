<?php
    session_start();
    if(isset($_SESSION['email'])) {
        header('location: ./main.php?page=announcements');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/favicon.png" sizes="80x80">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="./common/forms.css">
    <title>SIGN IN</title>
</head>

<body>
    <section>
        <div class="container">
            <div class="user signInBox">
                <div class="imgBx">
                    <img src="./images/login-min.jpg" id="image" alt="">
                </div>
                <div class="formBx">
                    <form action="#" method="POST">
                        <div id="loading"></div>
                        <h3 class="logo">Gov. Polytechnic Miraj</h3>
                        <h2>SIGN IN</h2>
                        <input required type="text" placeholder="Enter Phone no." name="email" id="email">
                        <div class="wrap-icons">
                            <input required type="password" placeholder="Enter password" name="password">
                            <small class="show-hide">🙈</small>
                        </div>
                        <input type="submit" value="Login" class="login">
                        <p class="signup">Don't have an account ? <a href="./index.php">SIGN UP</a></p>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-balls"></div>
    </section>
    <script src="./javascript/eye-dropdown.js"></script>
    <script type="module" src="./javascript/signin.js"></script>
    <script>
        let compressImage = document.querySelector('#image');
        let qualityImage = document.createElement('img');

        qualityImage.src = './images/login.jpg';
        qualityImage.onload = function() {
            compressImage.src = this.src;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
