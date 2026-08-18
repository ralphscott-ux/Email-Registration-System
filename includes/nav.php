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
<h1>Email Registration System for Businesses (for a school project)</h1>

<nav>
    <?php
        echo_navitem("MainPage", "index.php");
        echo_navitem("About", "about_head.php");
        echo_navitem("ChangeProfile", "change_profile_head.php");
        echo_navitem("FindUser", "find_user_head.php");
        echo_navitem("UsersFollowing", "following_head.php");
        echo_navitem("ResetUserData", "reset_user_data.php");
    ?>
</nav>