<?php
    $image_array = [
        "images/0.jpg",
        "images/1.png"
    ];
    function echo_image($id, $size) {
        global $image_array;
        $file_path = $image_array[$id % count($image_array)];
        echo "<input type=image name=$id src=\"$file_path\" width=$size height=$size></input>";
    }
?>