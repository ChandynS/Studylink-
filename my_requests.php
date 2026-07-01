<?php


// Load core system
require_once("includes/init.php");


// Ensures only logged-in students access
if (!isset($_SESSION["user_id"]))
{
    header("Location: login.php");
    exit();
}


// Loads page layout
include("includes/header.php");
include("includes/navbar.php");

// Get logged-in student ID
$iStudentID = $_SESSION["user_id"];


// Retrieve all tutoring requests made by this student
$sSQL = "SELECT * FROM tutor_requests INNER JOIN users ON tutor_requests.tutor_id = users.user_id WHERE student_id = '$iStudentID'";

$objResult = mysqli_query($objConnection, $sSQL);

?>

<h2>My Requests</h2>

<?php

// If no requests exist
if (mysqli_num_rows($objResult) == 0)
{
    echo "<p>No requests yet.</p>";
}
else
{
  
    // Loop through each request
    while ($objRequest = mysqli_fetch_assoc($objResult))
    {
?>

<hr>

<h3><?php echo $objRequest["username"]; ?></h3>

<p><b>Status:</b> <?php echo $objRequest["status"]; ?></p>

<p><?php echo $objRequest["request_message"]; ?></p>

<p><b>Requested:</b> <?php echo $objRequest["created_at"]; ?></p>

<?php
    }
}
?>

<?php include("includes/footer.php"); ?>