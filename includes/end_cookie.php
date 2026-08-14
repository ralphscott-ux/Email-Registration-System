<?php
    if ($should_delete_cookies) {
        setcookie("userdata", "", time() - 3600, "/");
    } else {
        setcookie("userdata", json_encode($userdata));
    }
?>