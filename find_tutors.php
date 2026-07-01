<?php

// Initialise system
require_once("includes/init.php");

include("includes/header.php");
include("includes/navbar.php");

// Get search input
$sSearch = "";

if(isset($_GET["search"]))
{
    $sSearch = sanitizeInput($_GET["search"]);
}


// Fetches approved tutors only
$sSQL = "SELECT *FROM users INNER JOIN tutor_profiles ON users.user_id = tutor_profiles.user_id WHERE approval_status = 'Approved'
AND ( username LIKE '%$sSearch%' OR qualification LIKE '%$sSearch%' OR bio LIKE '%$sSearch%')";

$objResult = mysqli_query($objConnection, $sSQL);

?>

<div class="container">

<h2>Find Tutors</h2>

<form method="GET">

    <input type = "text" name = "search" placeholder = "Search tutors..." value="<?php echo $sSearch; ?>">

    <input type = "submit" value = "Search">

</form>

<br>

<?php if(mysqli_num_rows($objResult) == 0) { ?>

    <p>No tutors found.</p>

<?php } else { ?>

    <?php while($objTutor = mysqli_fetch_assoc($objResult)) { ?>

        <div class="card">

            <h3>👤 <?php echo $objTutor["username"]; ?></h3>

            <p><b>Qualification:</b> <?php echo $objTutor["qualification"]; ?></p>

            <p><b>Hourly Rate:</b> R<?php echo $objTutor["hourly_rate"]; ?></p>

            <p><?php echo $objTutor["bio"]; ?></p>

            <p>
                <a href="view_tutor.php?id=<?php echo $objTutor["user_id"]; ?>">
                    <button>View Profile</button>
                </a>
            </p>

        </div>

    <?php } ?>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>