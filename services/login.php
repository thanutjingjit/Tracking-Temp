<?php
require 'dbconfig.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
        }
        echo "<script>
            setTimeout(()=>{AlertSweet('เข้าสู่ระบบ','', 'success')}, 200)
        </script>";
        header("Refresh: 2; ../backoffice.php");
    } else {
        echo "<script>
            setTimeout(()=>{AlertSweet('ไม่มีชื่อในระบบ', '', 'error')}, 200)
        </script>";
        header("Refresh: 2; ../login.php");
    }
} else {
    echo "<script>
        setTimeout(()=>{AlertSweet('ผิดพลาด', '', 'error')}, 200)
    </script>";
    header("Refresh: 2; ../login.php");
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="../sweetalert.js"></script>