<?php
session_start();

if (isset($_SESSION['first_name'])) {
    session_unset();
    session_destroy();
}
header("Location: index.php");
exit;

