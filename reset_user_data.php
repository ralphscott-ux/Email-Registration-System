<?php
require("includes/begin_cookie.php");
$posted = $_SERVER["REQUEST_METHOD"] == "POST";

$invalid_login = false;
$invalid_login_reason = "";
$should_log_in = false;
$should_sign_up = false;
$invalid_password = false;
$should_reset = $posted;
require("includes/sql_login.php");
$pagetitlename = "ResetUserData";

if ($posted) {
    try {
        $stmt = $pdo->prepare("DELETE FROM emregtable WHERE password = ?");
        $stmt->execute([ $password ]);
    } catch (PDOException $e) {
        $invalid_password = true;
    }
    $should_delete_cookies = true;
}

require("includes/end_cookie.php");
require("includes/header.php");
require("includes/nav.php");
?>
<?php if ($invalid_password): ?>
<h2>Invalid password found in cookies!</h2>
Please, do not mess with your cookies.
<?php elseif ($posted): ?>
<h2>Success!</h2>
User data has been deleted.
<?php else: ?>
<form method="POST" action="reset_user_data.php">
    <button type="submit">Click this button to reset your user data.</button>
</form> 
<?php endif; ?>
<?php require("includes/footer.php"); ?>