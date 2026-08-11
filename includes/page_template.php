<?php

$invalid_login = false;
$should_log_in = false;
$should_sign_up = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"])
        || !isset($_POST["email"])
        || !isset($_POST["dateofbirth"])
        || !isset($_POST["form_type"])) {
        $invalid_login = true;
    } else {
        $should_log_in = true;
        switch ($_POST["form_type"]) {
            case "login": { $should_sign_up = false; break; }
            case "signup": { $should_sign_up = true; break; }
        }
        $_COOKIE["userdata"] = json_encode([
            "username" => $_POST["username"],
            "password" => base64_encode($_POST["password"]),
            "email" => $_POST["email"],
            "dateofbirth" => $_POST["dateofbirth"],
            "following" => json_encode([]),
            "profile" => 0,
        ]);
        setcookie("userdata", $_COOKIE["userdata"]);
    };
}
require(__DIR__ . "/sql_login.php");

require(__DIR__ . "/header.php");
require(__DIR__ . "/nav.php");
// This assigned cookie data will modify sql_login, which runs afterwards.\
if ($should_sign_up) {
    // must be isset($_POST)
    $stmt = $pdo->prepare(
        "INSERT INTO emregtable
            (`username`, `password`, `dob`, `email`, `following`, `profile`) VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([ $_POST["username"], base64_encode($_POST["password"]), $_POST["dateofbirth"], $_POST["email"], json_encode([]), 0 ]);
}
?>
<?php if ($invalid_login): ?>
<h2>Login is invalid.</h2>
You may have tried to log in when not signed up, logged in with invalid credentials, or what have you.<br>
<a href="<?php echo __DIR__ . "/../reset_user_data.php" ?>">Reset user data</a>
<?php elseif ($logged_in): ?>
<?php require(__DIR__  . "/../" . $page_template); ?>
<?php else: ?>
<?php require(__DIR__ . "/try_to_log_in.php"); ?>
<?php endif; ?>
<?php require(__DIR__ . "/footer.php"); ?>