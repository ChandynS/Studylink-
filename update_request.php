<?php

require_once("includes/init.php");

// Ensures user is logged in
if (!isset($_SESSION["user_id"]))
{
    header("Location: login.php");
    exit();
}

// Validation required to get parameters
if (isset($_GET["id"]) && isset($_GET["status"]))
{
    // Request ID
    $iRequestID = (int)$_GET["id"];

    // New status (Accepted / Declined)
    $sStatus = $_GET["status"];

    // Only allow safe status values
    if ($sStatus == "Accepted" || $sStatus == "Declined")
    {
        $sSQL = "
        UPDATE tutor_requests
        SET status='$sStatus'
        WHERE request_id='$iRequestID'
        ";

        mysqli_query($objConnection, $sSQL);
    }
}

// Redirects back to tutor requests page
header("Location: tutor_requests.php");
exit();

?>