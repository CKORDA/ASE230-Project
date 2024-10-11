<?php
require_once('functions.php');
session_destroy();
header("Location: index.php"); // Redirect to the homepage or login page
exit();
?>