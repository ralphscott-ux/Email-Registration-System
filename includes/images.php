<?php
    function echo_image($id, $size) {
        $image_array = [
            "images/0.jpg",
            "images/1.png"
        ];
        $file_path = $image_array[$id % count($image_array)];
        echo "<img src=\"$file_path\" width=$size height=$size></img>";
    }
?>