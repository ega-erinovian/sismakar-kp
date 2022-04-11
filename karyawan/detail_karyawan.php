<?php require_once '../config.php'; ?>
<?php include '../model/koneksi.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
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

        <!-- Template navbar -->
        <?php require_once "../template/navigation.php"; ?>

        <!-- Template 'Sistem Manajemen Karyawan' -->
        <div class="detail-karyawan main-content">
            <?php require_once "../template/heading-dashboard.php"; ?>

            <!-- Navtabs Detail Karyawan -->
            <div class="navbar-tabs">
                <div class="row mb-3">
                    <div class="col">
                        <div class="card">
                            <ul class="nav nav-tabs">
                                <li class="nav-item nav-detail">
                                    <a href="#detail" class="nav-link active" role="tab" data-toggle="tab">Detail
                                        Karyawan</a>
                                </li>
                                <li class="nav-item nav-log">
                                    <a href="#log-activity" class="nav-link" role="tab" data-toggle="tab">Log
                                        Activity</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- Tab Detail Karyawan -->
                                <div class="detail-content tab-pane active m-5" role="tabpanel" id="detail">
                                    <div class="container-fluid">
                                        <?php
                                            $query = mysqli_query($konek, "SELECT * FROM karyawan WHERE id_kar = $_GET[id_kar]");
                                            while($data=mysqli_fetch_array($query)){
                                                $id_kar      = $data[0];
                                                $nama        = $data[1];
                                                $divisi      = $data[2];
                                                $jabatan     = $data[3];
                                                $tipe_kar    = $data[4];
                                                $tgl_masuk   = $data[5];
                                                $tgl_selesai = $data[6];
                                                $email       = $data[7];
                                                $no_telp     = $data[8];
                                                $alamat      = $data[9];
                                                $jenis_kel   = $data[10];
                                                $status_kar  = $data[11];
                                                $profile_img = $data[12];
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src='../assets/img/<?= $profile_img ?>' alt="pas-foto"
                                                    class="mb-3 img-fluid">
                                                <form action="kelola_karyawan.php" method="get" role="form">
                                                    <input type="hidden" name="id_kar" value="<?= $id_kar ?>">
                                                    <button type="submit" class="btn btn-success mb-3" nama="kelola"
                                                        value="Edit">Edit Karyawan</button>
                                                </form>
                                                <form action="kelola_karyawan.php" method="get" role="form">
                                                    <input type="hidden" name="id_kar" value="<?= $id_kar ?>">
                                                    <button type="submit" class="btn btn-danger mb-3" name="kelola"
                                                        value="Delete">Delete Karyawan</button>
                                                </form>
                                            </div>
                                            <div class="col detail-isi">
                                                <h1><?= $nama ?></h1>
                                                <h2><?= $divisi ?></h2>
                                                <hr>
                                                <table class="table table-borderless table-responsive table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Status</span>
                                                            </td>
                                                            <td class="detail-bio" style="font-weight: 900"><span
                                                                    id="status_kar"><?= $status_kar ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Jabatan</span></td>
                                                            <td><?= $jabatan ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Tipe</span></td>
                                                            <td class="detail-bio"><?= $tipe_kar ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Tanggal masuk</span>
                                                            </td>
                                                            <td class="detail-bio">
                                                                <?php
                                                                    echo(date("Y-m-d H:i:s",$tgl_masuk));
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Tanggal Selesai</span>
                                                            </td>
                                                            <td class="detail-bio">
                                                                <?= date("Y-m-d H:i:s",$tgl_selesai); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Email</span></td>
                                                            <td class="detail-bio"><?= $email ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>No. Telp</span></td>
                                                            <td><?= $no_telp ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Jenis Kelamin</span>
                                                            </td>
                                                            <td class="detail-bio"><?= $jenis_kel ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-keterangan"><span>Alamat</span></td>
                                                            <td class="detail-bio"><?= $alamat ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- Tab Log Aktivitas Karyawan -->
                                <div class="log-content tab-pane" role="tabpanel" id="log-activity">
                                    <div class="container-fluid py-4">
                                        <h1 class="text-center"><?= $nama ?></h1>
                                        <div class="table-log-karyawan table-responsive p-2 pb-3">
                                            <table class="table table-striped table-hover log-table"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Desc</th>
                                                        <th>Admin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>2022-03-09 14:00:10</td>
                                                        <td>Created Karyawan[1]</td>
                                                        <td>Admin_1</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2022-03-09 15:03:15</td>
                                                        <td>Edited Karyawan[1] Name to "Shyla Georgie Irvin"
                                                        </td>
                                                        <td>Admin_1</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2023-01-09 12:00:15</td>
                                                        <td>Edited Karyawan[1] Division to "Frontend Developer"
                                                        </td>
                                                        <td>Admin_2</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2023-01-09 12:10:05</td>
                                                        <td>Edited Karyawan[1] Division to "Backend Developer"
                                                        </td>
                                                        <td>Admin_1</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Desc</th>
                                                        <th>Admin</th>
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
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script src="../<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script src="../<?= URL_JS ?>/bootstrap.min.js"></script>
    <script src="../<?= URL_JS ?>/popper.min.js"></script>
    <script src="../<?= URL_JS ?>/script.js"></script>
    <script src="../<?= URL_JS ?>/jquery.dataTables.min.js"></script>
    <script src="../<?= URL_JS ?>/dataTables.bootstrap5.min.js"></script>

</body>

</html>