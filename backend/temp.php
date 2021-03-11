<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    require '../services/dbconfig.php';
    require './components/head.php';

    if (isset($_GET['temp_id'])) {
        $temp_id = $_GET['temp_id'];
        $sql = "UPDATE temp SET noti = '0' WHERE id = '$temp_id'";
        mysqli_query($conn, $sql);
    }
    ?>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

</head>

<?php
if (!isset($_SESSION['id'])) {
    header("Refresh:0; login.php");
    return;
}
$startDate = null;
$endDate = null;
$whereDate = '';
$whereDay = '';
if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    $start = SetFormatDate($startDate);
    $end = SetFormatDate($endDate);
    $whereDate = "WHERE temp.created_at > '$start' AND temp.created_at < '$end'";
} else if (isset($_GET['amount_day'])) {
    $amount_day = $_GET['amount_day'];
    $whereDay = "WHERE temp.created_at >= NOW() - INTERVAL $amount_day DAY";
}
$sql = "SELECT *,user.id as user_id FROM temp 
LEFT JOIN user ON user.id = temp.user_id
$whereDate $whereDay ORDER BY temp.id DESC";
$result = $conn->query($sql);

// $sql = "SELECT *,user.id as user_id FROM temp 
// LEFT JOIN created_at ON user.id = temp.created_at
// $whereDate ORDER BY created_at DESC";
// $result = $conn->query($sql);
// 
?>
<style>
    .card-temp {
        width: 30%;
        flex: none !important;
    }

    .card-bg-cover {
        height: 200px;
        width: 100%;
        background-position: no-repeat center center fixed;
        background-size: cover;
    }

    @media (max-width: 900px) {

        .card-temp {
            width: 100%;
            margin: 0 !important;
        }
    }
</style>

<body id="page-top" style="font-family: 'Kanit', sans-serif;">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        require './components/nav.php';
        ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                require './components/header.php';
                ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container">
                        <div class="accordion" id="accordionExample">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                ค้นหาด้วยวันที่
                            </button>
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                วันล่าสุด
                            </button>
                            <div class="card">
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="startDate">วันเวลาเริ่ม</label>
                                                <input id="startDate" value="<?= $startDate ?>" onchange="FilterDate()" />
                                                <!-- <input type="email" class="form-control" id="inputEmail4" placeholder="Email"> -->
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="endDate">วันเวลาจบ</label>
                                                <input id="endDate" value="<?= $endDate ?>" onchange="FilterDate()" />
                                                <!-- <input type="password" class="form-control" id="inputPassword4" placeholder="Password"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <a class="btn btn-info" href="temp.php?amount_day=7">7 วันล่าสุด</a>
                                        <a class="btn btn-info" href="temp.php?amount_day=3">3 วันล่าสุด</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('#startDate').datetimepicker({
                                uiLibrary: 'bootstrap4',
                                modal: true,
                                footer: true
                            });
                            $('#endDate').datetimepicker({
                                uiLibrary: 'bootstrap4',
                                modal: true,
                                footer: true
                            });
                        </script>
                    </div>

                    <div class="container mt-3">
                        <?php if (mysqli_num_rows($result)) { ?>
                            <div class="card-deck">
                                <?php

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <div class="card card-temp mb-3">
                                        <div class="card-bg-cover" style="background-image: url(../<?= $row['img'] ?>);"></div>
                                        <div class="card-body">
                                            <h4 class="card-text"><?= $row['user_id'] ? $row['firstname'] . ' ' . $row['lastname'] : 'Unknown' ?></h4>
                                            <p class="card-text">อุณหภูมิ : <?= $row['temp'] ?></p>
                                            <p class="card-text"><small class="text-muted">
                                                    <?= DateThai($row['created_at']) ?></small></p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                        <?php } else {
                        ?>
                            <h2 style="text-align: center;">ไม่มีข้อมูล</h2>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Tracking Temp 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        function FilterDate() {
            const start = $('#startDate').val();
            const end = $('#endDate').val();
            if (start && end) {
                window.location.replace("temp.php?startDate=" + start + "&endDate=" + end);
            }
        }
    </script>
</body>

</html>