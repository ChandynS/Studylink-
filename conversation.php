//start new chat
<?php

require_once("includes/init.php");

requireLogin();

include("includes/header.php");
include("includes/navbar.php");

/*Gets the chats of both users  */
$otherUserID = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($otherUserID <= 0)
{
    header("Location: inbox.php");
    exit();
}

/* mark messages as read */
$sSQL = " UPDATE messages SET is_read = 1 WHERE sender_id = $otherUserID AND receiver_id = {$_SESSION["user_id"]} ";

mysqli_query($objConnection, $sSQL);

/* sends a message to the other user */
if (isset($_POST["btnSend"]))
{
    $message = sanitizeInput($_POST["message"]);

    if (!empty($message))
    {
        $senderID = $_SESSION["user_id"];

        $sSQL = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($senderID, $otherUserID, '$message')";
        mysqli_query($objConnection, $sSQL);
    }
}

/* Loads messages */
$sSQL = "
SELECT * FROM messages WHERE ( sender_id = {$_SESSION["user_id"]} AND receiver_id = $otherUserID)
OR(sender_id = $otherUserID
AND receiver_id = {$_SESSION["user_id"]})
ORDER BY sent_at ASC";

$objResult = mysqli_query($objConnection, $sSQL);

?>

<h2>Conversation</h2>

<div style="border:1px solid #ccc;padding:10px;height:300px;overflow:auto;">

<?php while($row = mysqli_fetch_assoc($objResult)) { ?>

<p>

<b>

<?php echo ($row["sender_id"] == $_SESSION["user_id"]) ? "You" : "Them"; ?>:

</b>

<?php echo htmlspecialchars($row["message"]); ?>

</p>

<?php } ?>

</div>

<br>

<form method="POST">

<input
type="text"
name="message"
placeholder="Type message..."
required>

<input
type="submit"
name="btnSend"
value="Send">

</form>

<?php include("includes/footer.php"); ?>
