<?php
require 'dbconfig.php';
if (isset($_POST['user_id']) && isset($_POST['temp']) && isset($_POST['img'])) {
    $user_id = $_POST['user_id'];
    $temp = $_POST['temp'];
    $img = $_POST['img'];
    $temp = str_replace("b'detect", "", $temp); // ตัด string temp จาก arduino
    $temp = substr($temp, 0, 5); // ทำทศนิยม 2 ตำแหน่ง
    $sql = "INSERT INTO `temp`(`temp`, `user_id`,`img`,`noti`) VALUES ('$temp','$user_id','$img','1')";
    $query = $conn->query($sql);
    if ($query) {
        echo 'success';
    } else {
        echo 'error';
    }
}
