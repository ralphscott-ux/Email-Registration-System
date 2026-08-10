<?php
$pagetitlename = "MainPage";
require("includes/header.php");
require("includes/nav.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"])
        || !isset($_POST["email"])
        || !isset($_POST["dateofbirth"])) {
        $invalid_login = true;
    } else {
        setcookie("userdata", json_encode([
            "username" => $_POST["username"],
            "password" => base64_encode($_POST["password"]),
            "email" => $_POST["email"],
            "dateofbirth" => $_POST["dateofbirth"],
        ]));
    };
}
// This assigned cookie data will modify sql_login, which runs afterwards.
require("includes/sql_login.php");

?>
<?php require("includes/footer.php"); ?>