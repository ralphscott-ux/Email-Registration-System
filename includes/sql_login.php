<?php
require(__DIR__ . "/decode_date.php");

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

$logged_in = isset($_COOKIE["userdata"]);

$username = null;
$password = null;
$email = null;
$following = null;
$dateofbirth = null;
$profile = null;

if (!$invalid_login) {
    if ($logged_in) {
        $mycookie = json_decode($_COOKIE["userdata"]);
        if (isset($mycookie->username)
            && isset($mycookie->password)
            && isset($mycookie->email)
            && isset($mycookie->dateofbirth)
            && isset($mycookie->profile)
            && isset($mycookie->following)) {
            $username = $mycookie->username;
            $password = $mycookie->password;
            $dateofbirth = decodeDate($mycookie->dateofbirth);
            $profile = $mycookie->profile;
            $following = $mycookie->following;

            if ($should_sign_up) {
                $stmt = $pdo->prepare("SELECT * FROM emregtable WHERE username = ?");
                $stmt->execute([ $username ]);
                $data = $stmt->fetch();
                if (!is_null($data)) $invalid_login = true;
                else {
                    $_COOKIE["userdata"] = json_encode($data); // directly dump data
                    setcookie("userdata", $_COOKIE["userdata"]);
                }
            } else if ($should_log_in) {
                $stmt = $pdo->prepare("SELECT * FROM emregtable WHERE username = ?");
                $stmt->execute([ $username ]);
                $data = $stmt->fetch();
                if (is_null($data) || $data["password"] != $password || $data["dob"] != $dateofbirth) {
                    $invalid_login = true;
                } else {
                    $_COOKIE["userdata"] = json_encode($data); // directly dump data
                    setcookie("userdata", $_COOKIE["userdata"]);
                }
            }
        } else {
            $invalid_login = true;
        }
    }
}
?>