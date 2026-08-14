<?php
$userdata = null;
if (isset($_COOKIE["userdata"])) {
    $userdata = json_decode($_COOKIE["userdata"], true);
}
$should_delete_cookies = false;
?>