<?php require_once '../config.php'; ?>
<?php include '../model/koneksi.php';?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title><?= SITENAME ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/bootstrap.min.css?v=<?= time(); ?>" />
    <!----css3---->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/custom.css?v=<?= time(); ?>" />
    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet" />

    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />

    <!-- Boostrap Tables CSS -->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/dataTables.bootstrap5.min.css" />
</head>

<body>
    <div class="wrapper">

        <!-- Darken background in mobile view for offcanvas -->
        <div class="body-overlay"></div>

        <!-- Template Navbar + Sidebar -->
        <?php include "../template/navigation.php"; ?>
        <div class="main-content">

            <!-- Heading Dashboard -->
            <?php require_once "../template/heading-dashboard.php"; ?>

            <!-- Notifikasi Status Kelola Karyawan -->
            <?php
                if(isset($_SESSION['msg'])){
            ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <?= $_SESSION['msg']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                    unset($_SESSION['msg']);
                }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="kelola_karyawan.php" method="get" role="form">
                            <input type="hidden" name="kelola" value="Tambah">
                            <button class="btn btn-primary m-4">+ Tambah Karyawan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel data pegawai -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Tabel Karyawan</h3>
                        </div>
                        <!-- PHP Fetch Data -->
                        <div class="card-body">
                            <div class="table-pegawai table-responsive">
                                <table class="table table-striped table-hover data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Nomor HP</th>
                                            <th>Email</th>
                                            <th>Status Karyawan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require_once 'tabelKaryawan.php';
                                            if(isset($_GET['tampil-data'])){
                                                switch($_GET['tampil-data']){
                                                    case 'all':
                                                        tampilTabelKaryawan($konek, "");
                                                        break;
                                                    case 'tetap':
                                                        tampilTabelKaryawan($konek, " WHERE tipe_kar = 'tetap'");
                                                        break;
                                                    case 'kontrak':
                                                        tampilTabelKaryawan($konek, " WHERE tipe_kar = 'kontrak'");
                                                        break;
                                                    case 'magang':
                                                        tampilTabelKaryawan($konek, " WHERE tipe_kar = 'magang'");
                                                        break;
                                                }
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Nomor HP</th>
                                            <th>Email</th>
                                            <th>Status Karyawan</th>
                                            <th>Action</th>
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