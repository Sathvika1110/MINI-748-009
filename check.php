
<?php
session_start();
if ($_GET["username"] == "admin" && $_GET["password"] == "mvsr") {
    $_SESSION['logged_in'] = true;
    header("Location: marks.php");
    exit();
} else {
    echo "Invalid Login";
}
?>