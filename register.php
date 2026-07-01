<?php

/* Allows new users to create a StudyLink account. */

// Load system configuration, database connection and helper functions
require_once("includes/init.php");

// Load common page layout
include("includes/header.php");
include("includes/navbar.php");

/* initialize variables */
$sUsername = "";
$sFirstName = "";
$sLastName = "";
$sEmail = "";
$sPhone = "";
$sPassword = "";
$sConfirmPassword = "";

$sMessage = "";

/* Process registration */
if (isset($_POST["btnRegister"]))
{
    // Sanitize user input
    $sUsername = sanitizeInput($_POST["username"]);
    $sFirstName = sanitizeInput($_POST["first_name"]);
    $sLastName = sanitizeInput($_POST["last_name"]);
    $sEmail = sanitizeInput($_POST["email"]);
    $sPhone = sanitizeInput($_POST["phone"]);

    // Passwords are not sanitized because they are hashed
    $sPassword = $_POST["password"];
    $sConfirmPassword = $_POST["confirm_password"];

    /*  validate all fields   */
    if (
        empty($sUsername) ||
        empty($sFirstName) ||
        empty($sLastName) ||
        empty($sEmail) ||
        empty($sPhone) ||
        empty($sPassword) ||
        empty($sConfirmPassword)
    )
    {
        $sMessage = "Please fill in all fields.";
    }
    elseif ($sPassword != $sConfirmPassword)
    {
        $sMessage = "Passwords do not match.";
    }
    elseif (!filter_var($sEmail, FILTER_VALIDATE_EMAIL))
    {
        $sMessage = "Invalid email address.";
    }
    else
    {
        /* Check for duplicate email */
        $sSQL = "SELECT * FROM users WHERE email='$sEmail'";
        $objResult = mysqli_query($objConnection, $sSQL);

        if (mysqli_num_rows($objResult) > 0)
        {
            $sMessage = "Email already exists.";
        }
        else
        {
            /* Check for duplicate username */

            $sSQL = "SELECT * FROM users WHERE username='$sUsername'";
            $objResult = mysqli_query($objConnection, $sSQL);

            if (mysqli_num_rows($objResult) > 0)
            {
                $sMessage = "Username already exists.";
            }
            else
            {
                /* Encrypt password before saving */
                $sHashedPassword = password_hash($sPassword, PASSWORD_DEFAULT);

                /* Create new user */
                $sSQL = "INSERT INTO users (username, first_name, last_name, email, password, phone)
                VALUES('$sUsername','$sFirstName','$sLastName','$sEmail','$sHashedPassword','$sPhone')";

                if (mysqli_query($objConnection, $sSQL))
                {
                    $sMessage = "Registration successful!";
                }
                else
                {
                    $sMessage = "Registration failed.";
                }
            }
        }
    }
}

/* display system messagee */
if ($sMessage != "")
{
    echo "<div class='success'>$sMessage</div>";
}

?>

<div class="container">

<h2>Create Account</h2>

<form method="POST">

    <label>Username</label>
    <input type="text" name="username" value="<?php echo $sUsername; ?>">

    <label>First Name</label>
    <input type="text" name="first_name" value="<?php echo $sFirstName; ?>">

    <label>Last Name</label>
    <input type="text" name="last_name" value="<?php echo $sLastName; ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?php echo $sEmail; ?>">

    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo $sPhone; ?>">

    <label>Password</label>
    <input type="password" name="password">

    <label>Confirm Password</label>
    <input type="password" name="confirm_password">

    <input type="submit" name="btnRegister" value="Register">

</form>

</div>

<?php include("includes/footer.php"); ?>

