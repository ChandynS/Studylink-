<?php

require_once("includes/init.php");

include("includes/header.php");
include("includes/navbar.php");

// Validate tutor ID exists in URL
if (!isset($_GET["id"]))
{
    header("Location: find_tutors.php");
    exit();
}

$iUserID = (int)$_GET["id"];

// Get tutor details from DB
$sSQL = "SELECT *FROM users INNER JOIN tutor_profiles ON users.user_id = tutor_profiles.user_id WHERE users.user_id = '$iUserID'";
$objResult = mysqli_query($objConnection, $sSQL);
?>

<div class="container">

<?php if (mysqli_num_rows($objResult) == 0) { ?>
    <h2>Tutor not found.</h2>
<?php } else {

    $objTutor = mysqli_fetch_assoc($objResult);
?>

    <div class="card">

        <h2>👤 <?php echo $objTutor["username"]; ?></h2>

        <hr>

        <p><b>Qualification:</b><br><?php echo $objTutor["qualification"]; ?></p>

        <p><b>Hourly Rate:</b><br>R<?php echo $objTutor["hourly_rate"]; ?></p>

        <p><b>Biography:</b><br><?php echo $objTutor["bio"]; ?></p>

        <p><b>Status:</b><br><?php echo $objTutor["approval_status"]; ?></p>

        <br>

        <!-- Link to chat with tutor -->
        <a href="chat.php?id=<?php echo $objTutor["user_id"]; ?>">
            Message Tutor
        </a>

        <a href="find_tutors.php">
            <button style="margin-left:10px;">← Back to Tutors</button>
        </a>

    </div>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>