<?php
require_once('functions.php');
session_destroy();
header("Location: signin.php"); // Redirect to the homepage or login page
exit();
?>
