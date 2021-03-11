<!DOCTYPE html>
<html lang="en">


<head>


    <?php
    require '../services/dbconfig.php';
    require './components/head.php';
    ?>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<?php
if (!isset($_SESSION['id'])) {
    header("Refresh:0; login.php");
    return;
}
$name = '';
if (isset($_GET['name']))
    $name = $_GET['name'];
$sql = "SELECT *,
(SELECT temp FROM temp WHERE user_id = user.id ORDER BY id DESC LIMIT 1) as temp
 FROM user";
$result = $conn->query($sql);
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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ข้อมูลรายชื่อ</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อ</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>อีเมล</th>
                                            <th>สถานะ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= $row['firstname'] . ' ' . $row['lastname'] ?></td>
                                                <td><?= $row['tel'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td><?php
                                                    if ($row['temp'])
                                                        echo $row['temp'] > 37.5 ? "<span style='color: red;'>Danger</span>" : "<span style='color: green;'>Safe</span>";
                                                    else
                                                        echo "<span style='color: orange;'>No temp</span>";
                                                    ?>

                                                </td>
                                                <td>
                                                    <a href="user-detail.php?id=<?= $row['id'] ?>" class="btn btn-success btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                        <span class="text">ดูข้อมูล</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        setTimeout(() => {
            $('input[type=search]').val(<?= json_encode($name) ?>);
        }, 100);
    </script>
</body>

</html>