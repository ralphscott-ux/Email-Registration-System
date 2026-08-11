<?php
$pagetitlename = "ResetUserData";

$invalid_login = false;

$posted = $_SERVER["REQUEST_METHOD"] == "POST"; 
if ($posted) {
    setcookie("userdata", "", time() - 3600, "", "/");
}
require("includes/header.php");
require("includes/nav.php");
?>
<?php if ($posted): ?>
<h2>Success!</h2>
User data has been deleted.
<?php else: ?>
<form method="POST" action="reset_user_data.php">
    <button type="submit">Click this button to reset your user data.</button>
</form> 
<?php endif; ?>
<?php require("includes/footer.php"); ?>