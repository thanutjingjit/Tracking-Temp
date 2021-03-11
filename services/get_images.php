<?php
require 'dbconfig.php';

$sql = "SELECT file_name FROM `image`";
$query = $conn->query($sql);

$imgs = [];
while ($row = mysqli_fetch_assoc($query)) {
    array_push($imgs, $row['file_name']);
}

echo join(",", $imgs);
