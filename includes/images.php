<?php
    $image_array = [
        "images/0.jpg",
        "images/1.png",
        "images/2.png"
    ];
    function echo_image($id, $size, $should_select = false) {
        global $image_array;
        $file_path = $image_array[$id % count($image_array)];
        if ($should_select) {
            echo "<input type=image name=$id src=\"$file_path\" width=$size height=$size></input>";
        } else {
            echo "<img src=\"$file_path\" width=$size height=$size></img>";    
        } 
    }
?>