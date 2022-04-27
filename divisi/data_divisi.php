<?php
    session_start();
    include '../config.php'; 

    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = ACCESS_DENIED;
        header('Location:../login.php');
    }
    // Kondisi jika tab dinonaktif selama waktu yang ditentukan maka session akan di destroy
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        session_destroy();
        session_unset();
    }

    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time

    include '../model/koneksi.php';
?>

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
    <link rel="stylesheet" href="../<?= URL_CSS ?>/dataTables.bootstrap5.min.css?v=<?= time(); ?>" />
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

            <!-- Notifikasi Status Kelola Divisi -->
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

            <!-- Tombol tambah divisi -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="kelola_divisi.php" method="post" role="form">
                            <button class="btn btn-primary btn-lg m-4" name="kelola" value="Tambah">+ Tambah
                                Divisi</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel data pegawai -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Tabel Divisi</h3>
                        </div>
                        <!-- PHP Fetch Data -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover data-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Nama Divisi</th>
                                            <th>Visibility</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = mysqli_query($konek, "SELECT * FROM divisi");
                                            while($data=mysqli_fetch_array($query)){
                                                $id_divisi      = $data[0];
                                                $nama_div       = $data[1];
                                                $visibility     = $data[2];
                                        ?>
                                        <tr>
                                            <td><?=$nama_div?></td>
                                            <td><?=$visibility?></td>
                                            <td>
                                                <form action='../divisi/kelola_divisi.php' method='post'>
                                                    <input type="hidden" name="id_divisi" value="<?=$id_divisi?>" />
                                                    <button type='submit' class='btn btn-primary btn-sm' name="kelola"
                                                        value="Edit"><i class="material-icons">edit</i></button>
                                                    <button type='submit' class='btn btn-danger btn-sm' name="kelola"
                                                        value="Delete"><i class="material-icons">delete</i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                            };
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama Divisi</th>
                                            <th>Visibility</th>
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