<?php
session_start();

if (!isset($_SESSION['user_authenticated'])) {
    // User is not authenticated, render the form
    include 'form.php';
} else {
    // User is authenticated, redirect to dashboard
    header("Location: dashboard.php");
    exit();
}
?>
