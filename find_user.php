<?php
    require("includes/images.php");
    $posted = $_SERVER["REQUEST_METHOD"] == "POST";
    $data = null;
    $can_select_user = true;

    if ($posted) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM emregtable WHERE username = ?");
            $stmt->execute([ $_POST["profile_selected"] ]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $e) {
            echo "Incorrect post data. Try again.";
            exit;
        }
        $following_decoded = json_decode($following);
        switch ($form_type) {
            case "profile_select": {
                break;
            }
            case "add_follower": {
                if ($_POST["following_or_not"] == "yes") {
                    array_push($following_decoded, $data["id"]);
                } else {
                    $key = array_search($data["id"], $following_decoded);
                    if ($key !== false) {
                        unset($following_decoded[$key]);
                        $following_decoded = array_values($following_decoded);
                    }
                }
                $following = json_encode($following_decoded);
                $userdata["following"] = $following;
                try {
                    $stmt = $pdo->prepare("UPDATE emregtable SET following = ? WHERE username = ? AND password = ?");
                    $stmt->execute([ $following, $username, $password ]);
                } catch (PDOException $ex) {
                    echo "FAILED TO DETECT INVALID LOGIN: ASSERTION FAILED";
                    exit;
                }
                break;
            }
        }
        $can_select_user = !in_array($data["id"], $following_decoded);
    }
?>

<?php if ($posted): ?>
<form method=POST action=find_user_head.php>
    <input type="hidden" name="form_type" value="add_follower" />
    <input type="hidden" name="profile_selected" value="<?php echo $data['username']; ?>" />
<h1><?php echo $data["username"]; ?></h1>
<?php echo_image($data["profile"], 50); ?>
<p>Email: <?php echo $data["email"]; ?></p>
<p>Age: <?php $now = new DateTime(); echo $now->diff(decodeDate($data["dob"]))->format("%Y years old"); ?></p>
<?php if ($can_select_user): ?>
    <input type="hidden" name="following_or_not" value="yes" />
    <button type=submit>Follow user</button>
<?php else: ?>
    <input type="hidden" name="following_or_not" value="no" />
    <button type=submit>Unfollow user</button>
<?php endif; ?>
</form>
<?php else: ?>
<h1>Select the desired user below: (Do not click the image)</h1>
<form method=POST action=find_user_head.php>
    <input type="hidden" name="form_type" value="profile_select" />
    <ol>
<?php
    try {
        $stmt = $pdo->query("SELECT * FROM emregtable WHERE 1");
        $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "FAILED TO DUMP DATABASE DATA";
    }
    foreach ($fetch as $row) {
        $uname = $row["username"];
        echo "<li>";
        echo_image($row["profile"], 50);
        echo " " . htmlspecialchars($row["email"]) .
        " <button name=profile_selected value=\"" . htmlspecialchars($uname) . "\">" . htmlspecialchars($uname) . "</button>";
        echo "</li>";
    }
?>
    </ol>
</form>
<?php endif; ?>