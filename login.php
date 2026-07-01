<?php
require_once("includes/init.php");

include("includes/header.php");
include("includes/navbar.php");

$sMessage = "";
$sEmail = "";
$sPassword = "";

/* LOGIN PROCESS */
if (isset($_POST["btnLogin"]))
{
    $sEmail = sanitizeInput($_POST["email"]);
    $sPassword = $_POST["password"];

    // Validate input
    if (empty($sEmail) || empty($sPassword))
    {
        $sMessage = "Please fill in all fields.";
    }
    else
    {
        // Check if user exists
        $sSQL = "SELECT * FROM users WHERE email='$sEmail'";
        $objResult = mysqli_query($objConnection, $sSQL);

        if (mysqli_num_rows($objResult) == 0)
        {
            $sMessage = "Email not found.";
        }
        else
        {
            $objUser = mysqli_fetch_assoc($objResult);

            // Verify password
            if (password_verify($sPassword, $objUser["password"]))
            {
                $_SESSION["user_id"] = $objUser["user_id"];
                $_SESSION["username"] = $objUser["username"];
                $_SESSION["role"] = $objUser["role"];
                $_SESSION["email"] = $objUser["email"];

                $sMessage = "Login successful!";
            }
            else
            {
                $sMessage = "Incorrect password.";
            }
        }
    }
}
?>

<div class="container">
<h2>Login</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="btnLogin" value="Login">
</form>

</div>

<?php include("includes/footer.php"); ?>