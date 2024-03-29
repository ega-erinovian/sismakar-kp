<?php
    session_start();
    require_once 'config.php';
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = ACCESS_DENIED;
        header('Location:login.php');
    }
    
    // Kondisi jika tab dinonaktif selama waktu yang ditentukan maka session akan di destroy
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        session_unset();
        session_destroy();
    }
    
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time
    
    include 'model/koneksi.php';
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
    <link rel="stylesheet" href="<?= URL_CSS ?>/bootstrap.min.css?v=<?= time(); ?>" />
    <!---- CSS ---->
    <link rel="stylesheet" href="<?= URL_CSS ?>/custom.css?v=<?= time(); ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet" />

    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">

        <!-- Darken background in mobile view for offcanvas -->
        <div class="body-overlay"></div>

        <!-- ========== Start Sidebar ========== -->

        <nav id="sidebar">
            <!-- Heading Sidebar -->
            <div class="sidebar-header">
                <img src=<?= RUMAHWEB_LOGO ?> class="img-fluid" />
            </div>

            <!-- List link -->
            <ul id="sidebar-link" class="list-unstyled components">
                <!-- Dashboard Link -->
                <li id="sidebar-link-item">
                    <a href="index.php" class="dashboard">
                        <i class="material-icons">dashboard</i><span>Dashboard</span>
                    </a>
                </li>

                <!-- Dropdown Data Karyawan -->
                <li class="dropdown">
                    <a href="#dropdownKaryawan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i
                            class="material-icons"> table_chart </i><span>Data Karyawan</span></a>
                    <ul class="collapse list-unstyled menu" id="dropdownKaryawan">
                        <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                            <li>
                                <button type="submit" class="btn btn-link" value="All" name="tipe-kar">Semua
                                    Karyawan</button>
                            </li>
                            <li>
                                <button type="submit" class="btn btn-link" value="Tetap" name="tipe-kar">Karyawan
                                    Tetap</button>
                            </li>
                            <li>
                                <button type="submit" class="btn btn-link" value="Kontrak" name="tipe-kar">Karyawan
                                    Kontrak</button>
                            </li>
                            <li>
                                <button type="submit" class="btn btn-link" value="Magang" name="tipe-kar">Karyawan
                                    Magang</button>
                            </li>
                        </form>
                    </ul>
                </li>

                <hr />

                <li class="dropdown">
                    <a href="#dropdownAdmin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i
                            class="material-icons"> person </i><span>Admin</span></a>
                    <ul class="collapse list-unstyled menu text-dark" id="dropdownAdmin">
                        <li>
                            <a href="admin/kelola_admin.php"><i class="material-icons">edit</i>Edit Profile</a>
                        </li>
                        <li>
                            <a href="admin/log_admin.php"><i class="material-icons">history</i>Log Activity</a>
                        </li>
                        <li>
                            <a href="divisi/data_divisi.php"><i class="material-icons">groups</i>Kelola Divisi</a>
                        </li>
                        <li>
                            <form action="model/proses_login.php" method="POST" enctype="multipart/form-data">
                                <button class="btn btn-link btn-block" name="aksi" value="Logout" type="submit">
                                    <i class="material-icons">logout</i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- ========== End Sidebar ========== -->

        <div id="content">

            <!-- ========== Start Navbar ========== -->
            <div class="top-navbar">
                <nav class="navbar">
                    <div class="container-fluid justify-content-start align-items-center">
                        <!-- Tombol untuk toggle sidebar -->
                        <button type="button" id="sidebarCollapse"
                            class="d-xl-block d-lg-block d-md-none d-none transparent">
                            <span class="material-icons"> menu </span>
                        </button>

                        <!-- Heading Navbar -->
                        <a class="navbar-brand" href="index.php">
                            <h4><strong>Dashboard</strong></h4>
                        </a>

                        <!-- Tombol untuk toggle sidebar - Mobile view -->
                        <button id="sidebarCollapse" class="d-inline-block d-lg-none ml-auto more-button" type="button"
                            data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="material-icons">menu</span>
                        </button>
                    </div>
                </nav>
            </div>
            <!-- ========== End Navbar ========== -->

            <!-- ========== Start Main Content ========== -->

            <div class="index main-content">
                <!-- Heading Dashboard -->
                <?php require_once "template/heading-dashboard.php"; ?>

                <!-- Card Navtabs Announcement, About, &  Organizaional Structure -->
                <div class="navbar-tabs">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item nav-announce">
                                        <a href="#announce-tab" class="nav-link active" role="tab"
                                            data-toggle="tab">Announcement</a>
                                    </li>
                                    <li class="nav-item nav-about">
                                        <a href="#about" class="nav-link" role="tab" data-toggle="tab">About</a>
                                    </li>
                                    <li class="nav-item nav-org-structure">
                                        <a href="#org-struct" class="nav-link" role="tab" data-toggle="tab">Organization
                                            Structure</a>
                                    </li>
                                </ul>
                                <!-- Card announcement selesai masa kerja karyawan -->
                                <div class="tab-content">
                                    <div class="announcement-content tab-pane active" role="tabpanel" id="announce-tab">
                                        <div class="p-4">
                                            <h1> Announcement </h1>
                                            <div class="announce-item">
                                                <?php
                                                    $query = mysqli_query($konek, "SELECT * FROM karyawan");
                                                    while($data=mysqli_fetch_array($query)){
                                                        $id_kar      = $data[0];
                                                        $nama        = $data[1];
                                                        $tgl_selesai = $data[6];
                                                        $status_kar  = $data[11];
                                                        
                                                        if($tgl_selesai > 0){
                                                            if($tgl_selesai < time() && $status_kar == "Aktif"){
                                                                $_SESSION['announce'] = "Karyawan_".$id_kar.": <b>".$nama."</b> sudah mencapai tanggal selesai masa kerja.";
                                                ?>
                                                <div class="alert alert-danger alert-dismissible fade show mr-1"
                                                    role="alert">
                                                    <form action="karyawan/detail_karyawan.php" method="get"
                                                        enctype="multipart/form-data">
                                                        <span><?= $_SESSION['announce']; ?></span>
                                                        <button class="btn btn-danger btn-sm ml-2" type="submit"
                                                            value=<?= $id_kar ?> name="id_kar"> <b>See Detail</b>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <?php
                                                            }else{
                                                ?>
                                                <p>No announcement currently</p>
                                                <?php
                                                            }
                                                            unset($_SESSION['announce']);
                                                        }}
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card about -->
                                    <div class="about-content tab-pane" role="tabpanel" id="about">
                                        <div class="about-container p-4">
                                            <h1>About</h1>
                                            <p>Didirikan pada tahun 2002 di Yogyakarta, Rumahweb Indonesia tumbuh
                                                menjadi salah satu perusahaan hosting terbesar di Indonesia yang kini
                                                melayani lebih dari 14.000 domain pelanggan. Berawal dari 1 server, kini
                                                Rumahweb telah memiliki lebih dari 30 server untuk melayani hosting dan
                                                VPS/Cloud.
                                                <br>
                                                Pertumbuhan ini tidak lepas dari penanaman sikap dan kesadaran bahwa
                                                bisnis ini dibangun atas kepercayaan pelanggan terhadap Rumahweb
                                                sehingga seluruh aktivitas yang ada didalamnya hanya bertujuan untuk
                                                satu hal saja, yakni menjamin kepercayaan pelanggan terhadap Rumahweb
                                                dapat kami jaga dengan segala konsekuensinya. Harga mati sebuah komitmen
                                                yang kami tanamkan diseluruh jajaran manajemen dan karyawan.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Card organizational structure -->
                                    <div class="exc-leader-content tab-pane" role="tabpanel" id="org-struct">
                                        <div class="row m-4">
                                            <div class="card-deck">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <img src="assets/img/exc-leader/PakYusuf.webp"
                                                            alt="profile-pict">
                                                        <h5 class="card-title mt-3"><b>Yusuf Nurrachman</b></h5>
                                                        <p class="card-text">CEO/CMO</p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <img src="assets/img/exc-leader/BuYeni.webp" alt="profile-pict">
                                                        <h5 class="card-title mt-3"><b>Yeni Wibawandarsih</b></h5>
                                                        <p class="card-text">CFO</p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <img src="assets/img/exc-leader/PakHisam.webp"
                                                            alt="profile-pict">
                                                        <h5 class="card-title mt-3"><b>Hisam</b></h5>
                                                        <p class="card-text">CIO</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-4">
                                            <div class="card-deck">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <img src="assets/img/exc-leader/PakAgung.webp"
                                                            alt="profile-pict">
                                                        <h5 class="card-title mt-3"><b>Agung Priaprabakti</b></h5>
                                                        <p class="card-text">NOC Manager</p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <img src="assets/img/exc-leader/PakTriyadi.webp"
                                                            alt="profile-pict">
                                                        <h5 class="card-title mt-3"><b>Triyadi</b></h5>
                                                        <p class="card-text">Technical Support Manager</p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <img src="assets/img/exc-leader/PakTulusCahyono.webp"
                                                            alt="profile-pict">
                                                        <h5 class="card-title mt-3"><b>Tulus Cahyono</b></h5>
                                                        <p class="card-text">Sales Operations Manager</p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <img src="assets/img/exc-leader/PakNanag.webp"
                                                            alt="profile-pict">
                                                        <h5 class="card-title mt-3"><b>Nanang Ardinanto</b></h5>
                                                        <p class="card-text">Billing Operation Manager</p>
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

                <!-- Card Jumlah Karyawan -->
                <?php
                    // Mengambil jumlah seluruh karyawan
                    $getTotal =  mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS total_kar FROM karyawan WHERE status_kar='Aktif'"));                    
                    
                    // Mengambil jumlah array tiap tipe karyawan
                    $getJmlTipeTetap = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS tetap FROM karyawan WHERE tipe_kar = 'Tetap' AND status_kar='Aktif'"));
                    $getJmlTipeKontrak = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS kontrak FROM karyawan WHERE tipe_kar = 'Kontrak ' AND status_kar='Aktif'"));
                    $getJmlTipeMagang = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS magang FROM karyawan WHERE tipe_kar = 'Magang' AND status_kar='Aktif'"));
                ?>
                <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-warning">
                                        <span class="material-icons">
                                            groups
                                        </span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Total Karyawan</strong></p>
                                    <h3 class="card-title">
                                        <?php if(isset($getTotal['total_kar'])) echo $getTotal['total_kar']; else echo 0 ; ?>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-info">info</i>
                                        <button type="submit" class="btn btn-link" value="All" name="tipe-kar">See
                                            detailed report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-rose">
                                        <span class="material-icons">
                                            group
                                        </span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Karyawan Tetap</strong></p>
                                    <h3 class="card-title">
                                        <?php if(isset($getJmlTipeTetap['tetap'])) echo $getJmlTipeTetap['tetap']; else echo 0; ?>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-info">info</i>
                                        <button type="submit" class="btn btn-link" value="Tetap" name="tipe-kar">See
                                            detailed report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-success">
                                        <span class="material-icons">
                                            group
                                        </span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Karyawan Kontrak</strong></p>
                                    <h3 class="card-title">
                                        <?php if(isset($getJmlTipeKontrak['kontrak'])) echo $getJmlTipeKontrak['kontrak']; else echo 0; ?>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-info">info</i>
                                        <button type="submit" class="btn btn-link" value="Kontrak" name="tipe-kar">See
                                            detailed report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-gray">
                                        <span class="material-icons">
                                            group
                                        </span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Karyawan Magang</strong></p>
                                    <h3 class="card-title">
                                        <?php if(isset($getJmlTipeMagang['magang'])) echo $getJmlTipeMagang['magang']; else echo 0; ?>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-info">info</i>
                                        <button type="submit" class="btn btn-link" value="Magang" name="tipe-kar">See
                                            detailed report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-row justify-content-between">
                                <b>Jumlah Karyawan Tiap Divisi</b> <span class="material-icons me-5">equalizer</span>
                            </div>
                            <!-- Card bar chart jumlah Karyawan tiap divisi -->
                            <?php
                                $query = mysqli_query($konek, "SELECT * FROM divisi");
                                while($data=mysqli_fetch_array($query)){
                                    $namaDivisi[] = $data[1];
                                    $visibility[] = $data[2];
                                }

                                if(isset($namaDivisi)){
                                    // Mengambil jumlah array tiap divisi + setting bar chart divisi
                                    for($i=0; $i<sizeof($namaDivisi); $i++){
                                        $getJmlDivisiQuery[$i] = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS jml_div FROM karyawan WHERE divisi = '".$namaDivisi[$i]."' AND status_kar='Aktif'"));
                                        if($visibility[$i] != 'hide'){
                                            $dataPoints[] = array("y" => $getJmlDivisiQuery[$i]['jml_div'], "label" => $namaDivisi[$i] );
                                        }
                                    }
                            ?>
                            <div class="card-body">
                                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                            </div>
                            <?php } else{ ?>
                            <div class="card-body">
                                Data divisi tidak ditemukan
                            </div>
                            <?php
                            }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== End Main Content ========== -->
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script src="<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
    // Setting Bar Chart
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Jumlah Karyawan Tiap Divisi"
            },
            axisY: {
                title: "Jumlah Karyawan"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## Karyawan",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
    </script>
    <script src="<?= URL_JS ?>/bootstrap.min.js"></script>
    <script src="<?= URL_JS ?>/popper.min.js"></script>
    <script src="<?= URL_JS ?>/script.js"></script>

</body>

</html>