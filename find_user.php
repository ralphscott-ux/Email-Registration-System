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
        switch ($form_type) {
            case "profile_select": {
                $following_decoded = json_decode($following);
                $can_select_user
                break;
            }
            case "add_follower": {
                $following_decoded = json_decode($following);
                array_push($following_decoded, $data["id"]);
                $following = json_encode($following_decoded);
                break;
            }
        }
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
</form>
<?php else: ?>
<h1>Select the desired user below: (Do not click the image)</h1>
<form method=POST action=find_user_head.php>
    <input type="hidden" name="form_type" value="profile_select" />
    <ol>
<?php
    $stmt = $pdo->query("SELECT * FROM emregtable WHERE 1");
    $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
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