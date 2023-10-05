<?php
session_start();

if (!session_destroy()) {
    echo "Error while logging out";
    exit();
} else {
    header("Location: login.php");
}

?>