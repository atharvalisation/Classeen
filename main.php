<?php
    session_start();
    include_once 'php/get-current-url.php';
    $pageValue = array('announcement', 'defaulters', 'test_marks', 'notices', 'time_table', 'mails');
    $forPage = array('class', 'exam');
    if(!isset($_SESSION['email'])) {
        ?>
            <script>
                location.replace('./sign-in.php');
            </script>
        <?php
    }
    if(!in_array(getName(), $pageValue)) {
        header('location: ./main.php?page=announcement');
    }
    if(getName() == 'time_table' && !(in_array(getForPageName(), $forPage))) {
        header('location: ./main.php?page=time_table&forPage=class');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/favicon.png" sizes="80x80">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="./common/style.css">
    <title>HOME</title>
</head>

<body>
    <header class="header">
        <div class="header__container">
            <a href="./main.php?page=announcement" class="header__logo logo">GPM</a>
            <h3 class="page__name text__color">
            <?php echo removeSpecialCharacters(); ?> 
            Page</h3>
            <div class="header__search">
                <input type="search" onfocus="clearPageRefreshInterval()" onchange="setPageRefreshIntervalIfSearchBarIsEmpty(event)" placeholder="Search" class="header__input">
                <i class="fas fa-search header__icon"></i>
            </div>

            <div class="header__toggle">
                <i class="fas fa-bars nav__icon" id="header-toggle"></i>
            </div>
        </div>
    </header>

    <div class="nav" id="navbar">
        <nav class="nav__container">
            <div class="">
                <a href="./main.php?page=announcement" class="nav__link nav__logo">
                    <i class="fas fa-university fa-2x text__color"></i>
                    <span class="nav__logo-name text__color">GPM</span>
                </a>

                <div class="nav__list">
                    <div class="nav__items">
                        <a href="./main.php?page=announcement" class="nav__link">
                            <i class="fas fa-bullhorn nav__icon"></i>
                            <span class="nav__name">Notice</span>
                        </a>

                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'teacher') {
                            ?>
                        <a href="./main.php?page=defaulters" class="nav__link">
                            <i class="fas fa-ban nav__icon"></i>
                            <span class="nav__name">Defaulters List</span>
                        </a>
                        <?php
                        }
                    ?>

                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'parent') {
                            ?>
                        <a href="./main.php?page=defaulters" class="nav__link">
                            <i class="fas fa-ban nav__icon"></i>
                            <span class="nav__name">Defaulters List</span>
                        </a>
                        <?php
                        }
                    ?>

                        <a href="./main.php?page=test_marks" class="nav__link">
                            <i class="fas fa-file-alt nav__icon"></i>
                            <span class="nav__name">Test Marks</span>
                        </a>

                        <a id="time-table" class="nav__link">
                            <i class="fas fa-book nav__icon"></i>
                            <span class="nav__name">Time Table <i class="fas fa-chevron-down sub-icon" style="margin-left: 10px;"></i></span>
                            <div class="sub-menu">
                                <a href="./main.php?page=time_table&forPage=class" class="sub__menu__item" style="margin-bottom: 15px;">
                                    <i class="far fa-address-book nav__icon"></i>
                                    <span class="nav__name">Class</span>
                                </a>
                                <a href="./main.php?page=time_table&forPage=exam" class="sub__menu__item">
                                    <i class="far fa-clipboard nav__icon"></i>
                                    <span class="nav__name">&nbsp;Exam</span>
                                </a>
                            </div>
                        </a>

                        <a class="nav__link" href="./display-users.php" id="chat" target="_blank">
                            <i class="fas fa-comments nav__icon"></i>
                            <span class="nav__name">Chat</span>
                        </a>

                        <?php
                            if(isset($_SESSION['role']) && $_SESSION['role'] == 'teacher') {
                                ?>
                                    <a class="nav__link" id="messageLink">
                                        <i class="far fa-paper-plane nav__icon"></i>
                                        <span class="nav__name">Message</span>
                                    </a>
                                <?php
                            }
                        ?>

                        <?php
                            if(isset($_SESSION['role']) && $_SESSION['role'] == 'parent') {
                                ?>
                                    <a href="./main.php?page=mails" class="nav__link">
                                        <i class="fas fa-envelope-open-text nav__icon"></i>
                                        <span class="nav__name">Mails</span>
                                    </a>
                                <?php
                            }
                        ?>

                        <a href="./php/logout.php" class="nav__link">
                            <i class="fas fa-sign-out-alt nav__icon"></i>
                            <span class="nav__name">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <main class="main__body">
        <div class="card__container">
            <!-- ADDING DYNAMIC NOTICES -->
        </div>
    </main>

    <!-- POP-UP FORM -->
    <div class="modal__form hidden">
        <div class="close__heading">
            <h3>Add your notice</h3>
            <i class="fas fa-times" id="closeButton"></i>
        </div>
        <form action="#" method="POST">
            <div class="form__control">
                <label for="title">Title</label>
                <input maxlength="50" required type="text" name="title" id="title" placeholder="Enter your title">
                <small class="showCharacters"><span id="currentCharacters">0</span>/<span id="remainingCharacters">50</span></small>
            </div>
            <div class="form__control">
                <label for="message">Message</label>
                <textarea required name="message" id="message" placeholder="Type your message..." name="message" id="" cols="10"
                    rows="5"></textarea>
            </div>
            <?php
                if(removeSpecialCharacters() === 'Time Table') {
                    ?>
                        <div class="form__control">
                            <label for="">Notice For</label>
                            <select required name="notice_type" id="noticeType">
                                <option value="class">Class</option>
                                <option value="exam">Exam</option>
                            </select>
                        </div>
                        <div class="form__control">
                            <label for="">Year</label>
                            <select required name="year" id="year">
                                <option value="FY">FY</option>
                                <option value="SY">SY</option>
                                <option value="TY">TY</option>
                            </select>
                        </div>
                    <?php
                }else {
                    ?>
                        <div class="form__control">
                            <label for="">Notice type</label>
                            <select required name="notice_type" id="noticeType">
                                <option value="announcement">Accouncement</option>
                                <option value="defaulters">Defaulters</option>
                                <option value="test_marks">Test marks</option>
                            </select>
                        </div>
                        <div class="form__control">
                            <label for="">Year</label>
                            <select required name="year" id="year">
                                <option value="FY">FY</option>
                                <option value="SY">SY</option>
                                <option value="TY">TY</option>
                            </select>
                        </div>
                    <?php
                }
            ?>
            <div class="form__control">
                <label for="myFile">Attach your PDF file</label>
                <input type="file" name="my_file" id="myFile">
            </div>
            <button type="submit" class="post__button">POST</button>
        </form>
    </div>
    <div class="overlay hidden"></div>

    <!-- Send Email Pop-Up -->
    <div class="send__mail hidden">
        <div class="close__heading">
            <h3>Send email to recipient</h3>
            <div id="loading"></div>
            <i class="fas fa-times" id="closeSendEmailButton"></i>
        </div>
        <div class="send__mail__container">
            <div class="formBx">
                <form action="#" method="POST" id="sendEmailForm">
                    <div class="form__control">
                        <label for="title">Title</label>
                        <input required type="text" name="title" id="sendMailTitle" placeholder="Enter your title">
                    </div>
                    <div class="form__control">
                        <label for="message">Message</label>
                        <textarea required name="message" id="sendMailMessage" placeholder="Type your message..." name="message" id="" cols="10"
                            rows="7"></textarea>
                    </div>
                    <!-- Search for parent -->
                    <div class="form__control">
                        <label for="search">Search by Enrollment no.</label>
                        <input type="text" id="searchInput" placeholder="Search by Unique ID">
                    </div>
                    <button type="submit" class="post__button" id="sendEmailButton">SEND</button>
                </form>
            </div>
            
            <div class="parents__name">
                <!-- Adding dynamic users -->
            </div>
        </div>
    </div>
    <div class="overlay2 hidden"></div>

    <?php
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'teacher') {
            ?>
                <div class="add__icon">
                    <i class="fas fa-plus" id="addIcon"></i>
                </div>
            <?php
        }
    ?>

    <script src="./javascript/main.js"></script>
    <script src="./javascript/notices.js"></script>
    <script src="./javascript/send-mail.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
