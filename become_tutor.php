<?php

// Load system configuration and helper functions
require_once("includes/init.php");

// Restrict access: only logged-in users can apply
if (!isset($_SESSION["user_id"]))
{
    header("Location: login.php");
    exit();
}


// Load layout components
include("includes/header.php");
include("includes/navbar.php");


// Message holder (success / error feedback)

$sMessage = "";


// HANDLE FORM SUBMISSION
if (isset($_POST["btnTutor"]))
{
    // Sanitize input to prevent XSS attacks
    $sBio = sanitizeInput($_POST["bio"]);
    $sQualification = sanitizeInput($_POST["qualification"]);
    $sExperience = sanitizeInput($_POST["experience"]);
    $dHourlyRate = $_POST["hourly_rate"];


    // Validation: ensure no empty fields
    if (
        empty($sBio) ||
        empty($sQualification) ||
        empty($sExperience) ||
        empty($dHourlyRate)
    )
    {
        $sMessage = "Please complete all fields.";
    }
    else
    {
        $iUserID = $_SESSION["user_id"];

    
        // Inserts tutor application into database
        // approval_status defaults to "Pending"
        $sSQL = "
        INSERT INTO tutor_profiles
        (
            user_id,
            bio,
            qualification,
            experience,
            hourly_rate
        )
        VALUES
        (
            '$iUserID',
            '$sBio',
            '$sQualification',
            '$sExperience',
            '$dHourlyRate'
        )";

        // Execute query and return feedback
        if (mysqli_query($objConnection, $sSQL))
        {
            $sMessage = "Tutor application submitted successfully!";
        }
        else
        {
            $sMessage = "Application failed: " . mysqli_error($objConnection);
        }
    }
}

// Display system messages
if ($sMessage != "")
{
    echo "<h3>$sMessage</h3>";
}

?>

<div class="container">

    <h2>Become a Tutor</h2>

    <!-- Tutor application form -->
    <form method="POST">

        <p>
            Biography
            <br>
            <textarea name="bio" rows="5" cols="40"></textarea>
        </p>

        <p>
            Qualification
            <br>
            <input type="text" name="qualification">
        </p>

        <p>
            Experience
            <br>
            <textarea name="experience" rows="5" cols="40"></textarea>
        </p>

        <p>
            Hourly Rate (R)
            <br>
            <input type="number" name="hourly_rate" step="0.01">
        </p>

        <p>
            <input type="submit" name="btnTutor" value="Apply">
        </p>

    </form>

</div>

<?php
include("includes/footer.php");
?>