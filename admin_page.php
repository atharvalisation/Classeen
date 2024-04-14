<?php
session_start();
include_once './php/config.php';

if(!isset($_SESSION['adminlogin']) || $_SESSION['adminlogin'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}

// Function to verify user
function verifyUser($userId, $conn) {
    $query = "UPDATE signup SET status = 'active' WHERE uniqueId = $userId";
    mysqli_query($conn, $query);
}

// Function to remove access
function removeAccess($userId, $conn) {
    $query = "UPDATE signup SET status = 'inactive' WHERE uniqueId = $userId";
    mysqli_query($conn, $query);
}

// Function to search records
function searchRecords($search, $conn) {
    $query = "SELECT * FROM signup WHERE uniqueid LIKE '%$search%'";
    return mysqli_query($conn, $query);
}

// Check if search form is submitted
if (isset($_GET['submitSearch'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $result = searchRecords($search, $con);
} else {
    // Fetch all records from the signup table if search form is not submitted
    $query = "SELECT * FROM signup";
    $result = mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./admin_style.css">
    <title>Admin Page</title>
</head>

<body>

    <h1>Admin Page</h1>

    <!-- Search form -->
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search by Full Name">
        <button type="submit" name="submitSearch">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Enrollment No.</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through each row in the result set
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr class="' . strtolower($row['role']) . '">';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['uniqueId'] . '</td>';
                echo '<td>' . $row['fullName'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['role'] . '</td>';
                echo '<td>' . $row['year'] . '</td>';

                // Add the "Verify" button for inactive users
                if ($row['status'] == 'inactive') {
                    echo '<td>
                            <form method="post" action="">
                                <input type="hidden" name="userId" value="' . $row['uniqueId'] . '">
                                <input type="submit" name="verifyUser" value="Grant Access">
                            </form>
                        </td>';
                } else {
                    // Add the "Remove Access" button for active users
                    echo '<td>
                            <form method="post" action="">
                                <input type="hidden" name="userId" value="' . $row['uniqueId'] . '">
                                <input type="submit" name="removeAccess" value="Remove Access">
                            </form>
                        </td>';
                }

                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <?php
    // Process form submission to verify user
    if (isset($_POST['verifyUser'])) {
        $userId = $_POST['userId'];
        verifyUser($userId, $con);
        // Refresh the page to update the status
        header("Location: admin_page.php");
    }

    // Process form submission to remove access
    if (isset($_POST['removeAccess'])) {
        $userId = $_POST['userId'];
        removeAccess($userId, $con);
        // Refresh the page to update the status
        header("Location: admin_page.php");
    }

    // Display message if no records found
    if (isset($_GET['submitSearch']) && mysqli_num_rows($result) == 0) {
        echo '<p>No records found.</p>';
    }
    ?>

</body>

</html>
