<?php
    require("includes/images.php");
?>

<h1>Users following:</h1>
<ol>
<?php
    $stmt = $pdo->prepare("SELECT * FROM emregtable WHERE JSON_CONTAINS(?, CAST(id AS JSON))");
    $stmt->execute([ $userdata["following"] ]);
    $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fetch as $row) {
        $uname = $row["username"];
        echo "<li>";
        echo_image($row["profile"], 50);
        echo " " . htmlspecialchars($row["email"]);
        if (in_array($userdata["id"], json_decode($row["following"]))) {
            echo " (Is following you)";
        } else {
            echo " (Does not follow you back)";    
        }
        if ($userdata["id"] == $row["id"]) {
            echo " (Is you!)";
        }
        echo "</li>";
    }
?>
</ol>
</form>