<?php

// Initialise system (session start)
require_once("includes/init.php");

// Remove session variables
session_unset();

// Destroy session completely
session_destroy();

// Redirect to home page
header("Location: index.php");
exit();
?>