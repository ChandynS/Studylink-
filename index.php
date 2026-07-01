<?php
require_once("includes/init.php");

// Layout
include("includes/header.php");
include("includes/navbar.php");
?>

<!-- HERO SECTION -->
<div style="text-align:center; padding:60px 20px;">

    <h1>Welcome to StudyLink</h1>

    <p>Connect with qualified tutors or become one today.</p>

    <!-- Navigation buttons -->
    <a href="find_tutors.php">
        <button>Find Tutors</button>
    </a>

    <a href="become_tutor.php">
        <button>Become a Tutor</button>
    </a>

</div>

<!-- FEATURES -->
<div class="container">

    <h2>Why StudyLink?</h2>

    <div class="card">
        <h3>Qualified Tutors</h3>
        <p>All tutors are verified.</p>
    </div>

    <div class="card">
        <h3>Affordable Learning</h3>
        <p>Budget-friendly tutoring.</p>
    </div>

    <div class="card">
        <h3>Fast Booking</h3>
        <p>Instant communication with tutors.</p>
    </div>

</div>

<?php include("includes/footer.php"); ?>