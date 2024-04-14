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
    <link rel="stylesheet" href="./common/forms.css">
    <link rel="icon" type="image/png" href="images/favicon.png" sizes="80x80">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>SIGN UP</title>
</head>

<body>
    <section>
        <div class="container">
            <div class="user signInBox">
                <div class="imgBx">
                    <img src="./images/signup-min.jpg" id="image" alt="">
                </div>
                <div class="formBx">
                    <form action="#" method="POST">
                        <div id="loading"></div>
                        <h3 class="logo">Gov. Polytechnic Miraj</h3>
                        <h2>SIGN UP</h2>
                        <input required type="text" placeholder="Enter Student Enrollment" name="enroll">
                        <input required type="text" placeholder="Enter Student Name" name="fullName">
                        <input required type="text" placeholder="Enter Parent Ph no." name="email">
                        <div class="wrap-icons">
                            <input required type="password" placeholder="Enter password" name="password">
                            <small class="show-hide">🙈</small>
                        </div>
                        <div class="oneline">
                            <div class="wrap-icons">
                                <select name="role" onclick="checkrole(this)">
                                    <option value="parent">Parent</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                                <i class="fas fa-chevron-down drop-down"></i>
                            </div>
                            <div class="wrap-icons">
                                <select name="year">
                                    <option value="fy">FY</option>
                                    <option value="sy">SY</option>
                                    <option value="ty">TY</option>
                                </select>
                                <i class="fas fa-chevron-down drop-down"></i>
                            </div>
                        </div>
                        <input type="submit" value="Sign Up" name="login" class="signUpButton">
                        <p class="signup">Already have an account<a href="./sign-in.php">SIGN IN</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="bg-balls"></div>
    <script>
        let compressImage = document.querySelector('#image');
        let qualityImage = document.createElement('img');

        qualityImage.src = './images/signup.jpg';
        qualityImage.onload = function() {
            compressImage.src = this.src;
        }
    </script>
    <script src="./javascript/eye-dropdown.js"></script>
    <script src="./javascript/signup.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
