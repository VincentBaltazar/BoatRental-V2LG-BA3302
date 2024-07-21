<?php
session_start(); // Ensure session is started

function checkAuthentication() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: login.php');
        exit();
    }
}
?>
