<?php

// Load common files
require_once("includes/init.php");

// Ensure user is logged in
requireLogin();

// Ensure tutor ID exists
if (!isset($_GET["id"]))
{
    header("Location: find_tutors.php");
    exit();
}

$iTutorID =
(int)$_GET["id"];

include("includes/header.php");
include("includes/navbar.php");

$sMessage = "";

// Process tutoring request
if (isset($_POST["btnRequest"]))
{
    $sRequestMessage =
    sanitizeInput(
        $_POST["message"]
    );

    if (empty($sRequestMessage))
    {
        $sMessage ="Please enter a message.";
    }
    else
    {
        $iStudentID = $_SESSION["user_id"];

        $sSQL = "INSERT INTO tutor_requests (student_id,tutor_id,request_message)
        VALUES('$iStudentID','$iTutorID','$sRequestMessage')";

        if(mysqli_query($objConnection,$sSQL))
        {
            $sMessage = "Request sent successfully!";
        }
        else
        {
            $sMessage = "Request failed: ".mysqli_error($objConnection);
        }
    }
}

?>

<h2> Request Tutoring </h2>

<?php

// Displays messages
if ($sMessage != "")
{
    echo "<h3>";
    echo $sMessage;
    echo "</h3>";
}

?>

<form method="POST">

<p>
Message to Tutor

<br>

<textarea
name="message"
rows="6"
cols="40"></textarea>

</p>

<p>

<input
type="submit"
name="btnRequest"
value="Send Request">

</p>

</form>

<?php

include("includes/footer.php");

?>