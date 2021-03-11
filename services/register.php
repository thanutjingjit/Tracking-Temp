<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="../js/sweetalert.js"></script>
<?php

require 'dbconfig.php';
if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
    $regis = true;

    // $username = $_POST['username'];
    // $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];

    // $sql = "SELECT id FROM user WHERE username = '$username'";
    // $result = $conn->query($sql);
    // if (mysqli_num_rows($result) > 0) {
    //     echo "a";
    //     echo "<script>setTimeout(()=>{AlertSweet('มี Username นี้ใช้งานแล้ว', '', 'error')}, 200)</script>";
    //     $regis = false;
    //     // header("Refresh: 2; ../register.php");
    // }

    // if ($regis) {

    // $sql = "INSERT INTO `user`( `username`, `password`,`firstname`, `lastname`, `email`, `tel`) 
    //             VALUES ('$username','$password','$firstname','$lastname','$email','$tel')";
    $sql = "INSERT INTO `user`( `firstname`, `lastname`, `email`, `tel`) 
                VALUES ('$firstname','$lastname','$email','$tel')";

    $result = $conn->query($sql);

    if (!$result) {
        echo "<script>
                        setTimeout(()=>{AlertSweet('ผิดพลาด', '', 'error')}, 200)
                    </script>";
        header("Refresh: 2; ../index.php");
    }

    $user_id = $conn->insert_id;
    $count_file = COUNT($_FILES["file"]['name']);

    $sql_img = [];
    //ฟังชั่นก์  resize
    for ($i = 0; $i < $count_file; $i++) {
        // File upload path
        $targetDir = "../uploads/";
        // $fileName = basename($_FILES["file"]["name"][$i]);
        $targetFilePath = $targetDir . basename($_FILES["file"]["name"][$i]);
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $fileName = time() . $i . '-' . $user_id . '.' . $imageFileType;
        $targetFilePatNewName = $targetDir . $fileName;
        $isSucces = false;

        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($imageFileType, $allowTypes)) {

            $images = $_FILES['file']['tmp_name'][$i];
            $resize_image = "../uploads/resize.jpg";
            $width = 800; // กว้าง max

            list($width_, $height_) = getimagesize($images);
            if ($width_ > $width && $width_ > $height_) {
                $size = GetimageSize($images);
                $height = round($width * $size[1] / $size[0]);
                $images_orig = ImageCreateFromJPEG($images);
                $photoX = ImagesX($images_orig);
                $photoY = ImagesY($images_orig);
                $images_fin = ImageCreateTrueColor($width, $height);
                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                ImageJPEG($images_fin, $resize_image);
                ImageDestroy($images_orig);
                ImageDestroy($images_fin);

                $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
                $isMob = is_numeric(strpos($ua, "mobile"));

                if (copy($resize_image, $targetFilePatNewName)) {
                    if ($isMob) {
                        $source = imagecreatefromjpeg($targetFilePatNewName);

                        $rotate = imagerotate($source, -90, 0);

                        imagejpeg($rotate, $targetFilePatNewName);
                    }
                    array_push($sql_img, "('$fileName','$user_id')");
                }
            } else {
                if (move_uploaded_file($images, $targetFilePatNewName)) {
                    array_push($sql_img, "('$fileName','$user_id')");
                }
            }
        }
    }

    $sql = "INSERT INTO `image`(`file_name`, `user_id`) VALUES " . join(',', $sql_img);
    $result = $conn->query($sql);

    if ($result) {
        echo "<script>setTimeout(()=>{AlertSweet('สมัครเรียบร้อย', '', 'success')}, 200)</script>";
        $isSucces = true;
    } else {
        echo "<script>setTimeout(()=>{AlertSweet('ผิดพลาด', '', 'error')}, 200)</script>";
    }
    header("Refresh: 2; ../index.php");
    // }
}

// function resize_image($file, $w, $h, $crop = FALSE)
// {
//     list($width, $height) = getimagesize($file);
//     $r = $width / $height;
//     if ($crop) {
//         if ($width > $height) {
//             $width = ceil($width - ($width * abs($r - $w / $h)));
//         } else {
//             $height = ceil($height - ($height * abs($r - $w / $h)));
//         }
//         $newwidth = $w;
//         $newheight = $h;
//     } else {
//         if ($w / $h > $r) {
//             $newwidth = $h * $r;
//             $newheight = $h;
//         } else {
//             $newheight = $w / $r;
//             $newwidth = $w;
//         }
//     }
//     $src = imagecreatefromjpeg($file);
//     $dst = imagecreatetruecolor($newwidth, $newheight);
//     imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

//     imagejpeg($dst, $dst, 80);
//     return $dst;
// }
?>