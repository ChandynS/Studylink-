<?php

require_once("includes/init.php");

//Ensure only logged-in tutors access
if (!isset($_SESSION["user_id"]))
{
    header("Location: login.php");
    exit();
}

include("includes/header.php");
include("includes/navbar.php");

// Get logged-in tutor ID
$iTutorID = $_SESSION["user_id"];


// Load incoming tutoring requests for this tutor
$sSQL = "SELECT *FROM tutor_requests INNER JOIN users ON tutor_requests.student_id = users.user_id WHERE tutor_id = '$iTutorID'";
$objResult = mysqli_query($objConnection, $sSQL);
?>

<h2>Incoming Tutoring Requests</h2>

<?php

// If no requests found let user know
if (mysqli_num_rows($objResult) == 0)
{
    echo "<p>No tutoring requests received.</p>";
}
else
{
    // Loop through requests
    while ($objRequest = mysqli_fetch_assoc($objResult))
    {
?>

<hr>

<h3><?php echo $objRequest["username"]; ?></h3>

<p><b>Status:</b> <?php echo $objRequest["status"]; ?></p>

<p><?php echo $objRequest["request_message"]; ?></p>

<p><b>Requested:</b> <?php echo $objRequest["created_at"]; ?></p>

<!-- tutor decides to accept or reject request -->
<p>
    <a href="update_request.php?id=<?php echo $objRequest["request_id"]; ?>&status=Accepted">
        Accept
    </a>
    |
    <a href="update_request.php?id=<?php echo $objRequest["request_id"]; ?>&status=Declined">
        Decline
    </a>
</p>

<?php
    }
}
?>

<?php include("includes/footer.php"); ?>