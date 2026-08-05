<?php require("sql_login.php"); ?>
<?php
    echo "<ul>";
    foreach ($pdo->query("SELECT * from table_name") as $it) {
        echo "<li>" . it["password"] . "</li></br>";
    };
    echo "</ul>";
?>