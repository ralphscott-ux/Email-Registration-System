<?php

$invalid_login = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"])
        || !isset($_POST["email"])
        || !isset($_POST["dateofbirth"])) {
        $invalid_login = true;
    } else {
        $should_log_in = true;

        setcookie("userdata", [
            "username" => $_POST["username"],
            "password" => base64_encode($_POST["password"]),
            "email" => $_POST["email"],
            "dateofbirth" => $_POST["dateofbirth"],
        ]);
    };
}
require("header.php");
require("nav.php");
// This assigned cookie data will modify sql_login, which runs afterwards.
require("sql_login.php");
?>
<?php if ($invalid_login): ?>
<h2>Login is invalid.</h2>
<a href="../reset_user_data.php">Reset user data</a>
<?php elseif ($logged_in): ?>
<?php require("../" . $page_template); ?>
<?php else: ?>
<?php require("try_to_log_in.php"); ?>
<?php endif; ?>
<?php require("footer.php"); ?>