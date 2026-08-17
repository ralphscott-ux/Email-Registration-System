<?php
require("includes/decode_date.php");

$host = 'db';
$dbname = 'emregsys';
$user = 'root';
$pass = 'EmailRegistration1234'; // Directly, written in
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = null; // global scope.

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "SERVER FAILURE: " . $e->getMessage() . " CODE " . $e->getCode();
    exit;
}

// Handle cookies

$logged_in = !is_null($userdata) && !$should_reset;

$username = null;
$password = null;
$email = null;
$following = null;
$dateofbirth = null;
$profile = null;

if (!$invalid_login) {
    if ($logged_in) {
        if (isset($userdata["username"])
            && isset($userdata["password"])) {
            $username = $userdata["username"];
            $password = $userdata["password"];
            try {
                if ($should_sign_up) {
                    $stmt = $pdo->prepare("SELECT * FROM emregtable WHERE username = ? AND password = ?");
                    $stmt->execute([ $username, $password ]);
                    $data = $stmt->fetch();
                    if (!is_null($data) || data == true) {
                        $invalid_login = true;
                        $invalid_login_reason = "Could not sign up when user already exists.";
                    } else {
                        $userdata = $data;
                        $userdata["dateofbirth"] = decodeDate($userdata["dob"]);
                        $dateofbirth = $userdata["dateofbirth"];
                        $profile = $data["profile"];
                        $following = $data["following"];
                        $email = $data["email"];
                    }
                } else {
                    $stmt = $pdo->prepare("SELECT * FROM emregtable WHERE username = ? AND password = ?");
                    $stmt->execute([ $username, $password ]);
                    $data = $stmt->fetch();
                    if (is_null($data) || $data == false) {
                        $invalid_login = true;
                        $invalid_login_reason = "User does not exist.";
                    } else {
                        $userdata = $data;
                        $userdata["dateofbirth"] = $userdata["dob"];
                        $dateofbirth = decodeDate($userdata["dateofbirth"]);
                        $profile = $data["profile"];
                        $following = $data["following"];
                        $email = $data["email"];
                    }
                }
            } catch (PDOException $ex) {
                $invalid_login = true;
                $invalid_login_reason = "User does not exist";
            }
        } else {
            $invalid_login = true;
            $invalid_login_reason = "Invalid cookies `" . json_encode($userdata) . "`";
        }
    }
}
?>