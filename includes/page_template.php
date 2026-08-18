<?php
require("includes/begin_cookie.php");

$invalid_login = false;
$invalid_login_reason = "";
$should_log_in = false;
$should_sign_up = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["form_type"]) || (($_POST["form_type"] == "signup" || $_POST["form_type"] == "login")) &&
        (!isset($_POST["username"]) || !isset($_POST["password"])
        || !isset($_POST["email"])
        || !isset($_POST["dateofbirth"]))) {
        $invalid_login = true;
        $invalid_login_reason = "Incorrect post data.";
    } else {
        switch ($_POST["form_type"]) {
            case "login": {
                $should_sign_up = false;
                $should_log_in = true;
                break;
            }
            case "signup": {
                $should_sign_up = true;
                $should_log_in = true;
                break;
            }
            case "image":
            case "profile_select": {
                break;
            }
        }
        if ($_POST["form_type"] == "signup" || $_POST["form_type"] == "login") {
            $userdata = [
                "username" => $_POST["username"],
                "password" => base64_encode($_POST["password"]),
                "email" => $_POST["email"],
                "dateofbirth" => $_POST["dateofbirth"],
                "following" => json_encode([]),
                "profile" => 0,
            ];
        }
        $form_type = $_POST["form_type"];
    };
}
require("includes/sql_login.php");

// This assigned cookie data will modify sql_login, which runs afterwards.\

$ok_to_sign_up = true;
if ($should_sign_up) {
    // should have posted and therefore have inserted data
    {
        try {
            $stmt = $pdo->prepare(
                "SELECT * FROM emregtable
                    WHERE username = ?"
            );
            $stmt->execute([ $_POST["username"] ]);
            $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ok_to_sign_up = is_null($fetch) || $fetch == false;
        } catch (PDOException $ex) {
            $invalid_login = true;
            $invalid_login_reason = "User already exists";
            $ok_to_sign_up = false; 
        }
    }
    if ($ok_to_sign_up) {
        // must be isset($_POST)
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO emregtable
                    (`username`, `password`, `dob`, `email`, `following`, `profile`) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([ $userdata["username"], $userdata["password"], $userdata["dateofbirth"], $userdata["email"], $userdata["following"], $userdata["profile"] ]);
        } catch (PDOException $ex) {
            $invalid_login = true;
            $invalid_login_reason = "Cannot insert user";
        }
    } else {
        $should_delete_cookies = true;
        $invalid_login = true;
        $invalid_login_reason = "User already exists";
    }
}
require("includes/end_cookie.php");
require("includes/header.php");
require("includes/nav.php");
?>
<?php if ($invalid_login): ?>
<h2>Login is invalid.</h2>
<h3>Reason: <?php echo $invalid_login_reason; ?></h3>
You may have tried to log in when not signed up, logged in with invalid credentials, or what have you.<br>
<a href="<?php echo "reset_user_data.php" ?>">Reset user data</a>
<?php elseif ($logged_in): ?>
<?php require($page_template); ?>
<?php elseif (!$ok_to_sign_up): ?>
<h2>Not ok to sign up when user <?php echo $userdata["username"]; ?> already exists.</h2>
Try again.
<?php else: ?>
<?php require("includes/try_to_log_in.php"); ?>
<?php endif; ?>
<?php require("includes/footer.php"); ?>