<?php
// Load system core (DB, sessions, helpers)
require_once("includes/init.php");

// Load page layout
include("includes/header.php");
include("includes/navbar.php");

// Ensure user is logged in
requireLogin();

// Get current user ID
$userID = $_SESSION["user_id"];

/* fetches conversations and shows all users who have chatted with the logged-in user*/
$sSQL = 
"SELECT DISTINCT u.user_id, u.username FROM users u JOIN messages m ON (u.user_id = m.sender_id 
OR u.user_id = m.receiver_id WHERE u.user_id != $userID AND (m.sender_id = $userID OR m.receiver_id = $userID)";

$objResult = mysqli_query($objConnection, $sSQL);
?>

<h2>Messages</h2>

<?php while($row = mysqli_fetch_assoc($objResult)) {

$otherID = $row["user_id"];

/*
counts unread messages
*/
$sUnreadSQL = "SELECT COUNT(*) AS unread FROM messages WHERE sender_id = $otherID AND receiver_id = $userID AND is_read = 0";

$unreadResult = mysqli_query($objConnection, $sUnreadSQL);
$unread = mysqli_fetch_assoc($unreadResult)["unread"];
?>

<div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

    <h3>
        <?php echo $row["username"]; ?>

        <?php if($unread > 0) { ?>
            <span style="background:red;color:white;padding:3px 8px;border-radius:50%;">
                <?php echo $unread; ?>
            </span>
        <?php } ?>
    </h3>

    <!-- Opens chat with selected user -->
    <a href="chat.php?id=<?php echo $otherID; ?>">
        Open Chat
    </a>

</div>

<?php } ?>

<?php include("includes/footer.php"); ?>