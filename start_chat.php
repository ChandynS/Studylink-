<?php

require_once("includes/init.php");

include("includes/header.php");
include("includes/navbar.php");

requireLogin();

$search = "";

/* search usrs*/
if(isset($_GET["search"]))
{
    $search = sanitizeInput($_GET["search"]);
}

$sSQL = "SELECT user_id, username, role FROM users WHERE user_id != {$_SESSION["user_id"]} AND username LIKE '%$search%'";

$objResult = mysqli_query($objConnection, $sSQL);

?>

<h2>Start New Chat</h2>
<form method="GET">
<input type="text" name="search" placeholder="Search users..." value="<?php echo $search; ?>">
<input type="submit" value="Search">
</form>

<br>

<?php while($row = mysqli_fetch_assoc($objResult)) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h3><?php echo $row["username"]; ?></h3>
        <p>Role: <?php echo $row["role"]; ?></p>
        <a href="chat.php?id=<?php echo $row["user_id"]; ?>">
            Message
        </a>
    </div>

<?php } ?>

<?php include("includes/footer.php"); ?>