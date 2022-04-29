<?php 
    session_start();
    require_once '../config.php';
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = ACCESS_DENIED;
        header('Location:../login.php');
    }
    
    include '../model/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/icon-rmwb.png" style="object-fit: cover;">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title><?= SITENAME ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/bootstrap.min.css?v=<?php echo time(); ?>" />
    <!----css3---->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/custom.css?v=<?php echo time(); ?>" />
    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet" />

    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />

    <!-- Boostrap Tables CSS -->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/dataTables.bootstrap5.min.css?v=<?php echo time(); ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Darken background in mobile view for offcanvas -->
        <div class="body-overlay"></div>

        <!-- Template Navbar + Sidebar -->
        <?php require_once "../template/navigation.php"; ?>
        <div class="log-admin main-content">

            <!-- Header 'Sistem Manajemen Karyawan' -->
            <?php require_once "../template/heading-dashboard.php"; ?>

            <!-- Card Log Aktivitas Admin -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="log-content container-fluid py-4">
                            <h1 class="text-center"><?= $_SESSION['username'] ?></h1>
                            <!-- Tabel Log Aktivitas Admin -->
                            <div class="table-pegawai table-responsive p-2 pb-3">
                                <table class="table table-striped table-hover log-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Desc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Tab Log Aktivitas Karyawan -->
                                        <?php
                                            date_default_timezone_set("Asia/Jakarta");
                                            $query = mysqli_query($konek, "SELECT * FROM log_activity WHERE id_admin = $_SESSION[id_admin]");
                                            while($data=mysqli_fetch_array($query)){
                                                $id_kar      = $data[0];
                                                $timestamp   = $data[1];
                                                $deskripsi   = $data[2];
                                            ?>
                                        <tr>
                                            <td><?= date("Y-m-d H:i:s", $timestamp);?></td>
                                            <td><?= $deskripsi ?></td>
                                        </tr>
                                        <?php }; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Time</th>
                                            <th>Desc</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script src="../<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script src="../<?= URL_JS ?>/script.js"></script>
    <script src="../<?= URL_JS ?>/bootstrap.min.js"></script>
    <script src="../<?= URL_JS ?>/popper.min.js"></script>
    <script src="../<?= URL_JS ?>/jquery.dataTables.min.js"></script>
    <script src="../<?= URL_JS ?>/dataTables.bootstrap5.min.js"></script>

</body>

</html>