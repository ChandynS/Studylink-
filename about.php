<?php

// Load system configuration, database, and helpers
require_once("includes/init.php");

// Load reusable layout components
include("includes/header.php");
include("includes/navbar.php");

?>

<div class="container">

    <!-- Page Title -->
    <h2>About StudyLink</h2>

    <!-- Platform description -->
    <p>
        StudyLink is a Customer-to-Customer (C2C) tutoring platform
        that connects students and tutors.
    </p>

    <p>
        Students can search for tutors and request lessons,
        while tutors can create profiles and manage requests.
    </p>

    <p>
        The platform aims to make finding academic assistance
        simple, affordable and convenient.
    </p>

    <br>

</div>

<?php

// Load footer layout
include("includes/footer.php");
?>