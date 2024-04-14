<?php
session_start();
include_once './config.php';

if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($con, $_GET['query']);
    $currentUserEmail = $_SESSION['email'];
    $sql = "SELECT * FROM signup WHERE NOT email = '$currentUserEmail' AND role = 'parent' AND uniqueId LIKE '%$search_query%'";
} else {
    $currentUserEmail = $_SESSION['email'];
    $sql = "SELECT * FROM signup WHERE NOT email = '$currentUserEmail' AND role = 'parent'";
}

$sql_query = mysqli_query($con, $sql);
$result = "";

if(mysqli_num_rows($sql_query) > 0) {
    while($row = mysqli_fetch_assoc($sql_query)) {
        $result .= 
        '
        <div class="parents__box">
            <div class="user__data">
                <h5>'.$row['fullName'].'</h4>
                <p>'.$row['uniqueId'].'</p>
            </div>
            <div class="user__data__check">
                <input type="checkbox" name="users[]" value="'.$row['email'].'" class="email__checkbox">
            </div>
        </div>
        ';
    }
} else {
    $result = "No user found !!";
}

echo $result;
?>
