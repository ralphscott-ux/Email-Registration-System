<?php
require("includes/decode_date.php");

$host = "db";
$dbname = "emregsys";
$user = "root";
$pass = "EmailRegistration1234"; // Directly, written in
$charset = "utf8mb4";

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

$logged_in = !is_null($userdata);

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

                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (!is_null($data) && count($data) > 0) {
                        $invalid_login = true;
                        $invalid_login_reason = "Could not sign up when user already exists.";
                    } else {
                        $dateofbirth = decodeDate($userdata["dateofbirth"]);
                        $profile = $userdata["profile"];
                        $following = $userdata["following"];
                        $email = $userdata["email"];
                    }
                } else {
                    $stmt = $pdo->prepare("SELECT * FROM emregtable WHERE username = ? AND password = ?");
                    $stmt->execute([ $username, $password ]);
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (is_null($data) || $data == []) {
                        $invalid_login = true;
                        $invalid_login_reason = "User does not exist.";
                    } else {
                        $userdata = $data[0];
                        $userdata["dateofbirth"] = $userdata["dob"];
                        $dateofbirth = decodeDate($userdata["dateofbirth"]);
                        $profile = $userdata["profile"];
                        $following = $userdata["following"];
                        $email = $userdata["email"];
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