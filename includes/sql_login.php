<?php
$host = 'db';
$dbname = 'emregsys';
$user = 'root';
$pass = 'EmailRegistration1234';
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
        if (isset($mycookie["username"])
            && isset($mycookie["password"])
            && isset($mycookie["email"])
            && isset($mycookie["dateofbirth"])
            && isset($mycookie["profile"])
            && isset($mycookie["following"])) {
            $username = $mycookie["username"];
            $password = $mycookie["password"];
            $dateofbirth = $mycookie["dateofbirth"];
            $profile = $mycookie["profile"];
            $following = $mycookie["following"];
        } else {
            $invalid_login = true;
        }
    }
}
?>