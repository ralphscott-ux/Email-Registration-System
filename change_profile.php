<?php
    require("includes/images.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $set = null;
        for ($i = 0; $i < count($image_array); $i += 1) {
            if (isset($_POST[(string) $i . "_x"])) {
                $set = $i;
                break;
            }
        }
        // guard
        if (is_null($set)) {
            echo "FAILURE: website served incorrect data. unable to recover.";
            exit;
        }
        $userdata["profile"] = $set;
        try {
            $stmt = $pdo->prepare("UPDATE emregtable SET profile = ? WHERE username = ? AND password = ?");
            $stmt->execute([ $set, $username, $password ]);
        } catch (PDOException $ex) {
            $should_delete_cookies = true;
        }
    }
?>
<h1>Change profile here:</h1>
<form action=change_profile_head.php method=POST>
    <input type=hidden name=form_type value=image>
    <?php
        for ($i = 0; $i < count($image_array); $i += 1) {
            echo_image($i, 200);
        }
    ?>
</form>