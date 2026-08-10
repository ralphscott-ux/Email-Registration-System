<?php if ($invalid_login): ?>
<?php elseif ($logged_in): ?>
<?php require("mainpage.php"); ?>
<?php else: ?>
<h1>You are not logged in yet.</h1>
<h2>Log in:</h2>
<form method="POST" action="index.php">
    <input type="hidden" name="form_type" value="login" />
</form>
<h2>Sign up:</h2>
<form method="POST" action="index.php">
    <input type="hidden" name="form_type" value="signup" />
</form>
<?php endif; ?>