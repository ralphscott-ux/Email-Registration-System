<?php 
    function echo_navitem($name, $link) {
        global $pagetitlename;

        if ($pagetitlename == $name) {
            echo "<div class=\"current-page\"><a href=\"$link\">$name</a></div>";
        } else {
            echo "<div class=\"not-current-page\"><a href=\"$link\">$name</a></div>";
        }
    }
?>

<nav>
    <?php
        echo_navitem("MainPage", "../index.php");
        echo_navitem("SecondPage", "../index.php");
    ?>
</nav>