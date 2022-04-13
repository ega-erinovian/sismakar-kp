<?php
    session_start();
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = "Anda harus login untuk mengakses halaman ini";
        header('Location:login.php');
    }
    
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        session_destroy();
        session_unset();
    }
    
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time
    
    require_once 'config.php'; 
    include 'model/koneksi.php';
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
    <link rel="stylesheet" href="<?= URL_CSS ?>/bootstrap.min.css?v=<?= time(); ?>" />
    <!----css3---->
    <link rel="stylesheet" href="<?= URL_CSS ?>/custom.css?v=<?= time(); ?>" />
    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

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

        <!-- Sidebar  -->
        <nav id="sidebar">
            <!-- Heading Sidebar -->
            <div class="sidebar-header">
                <img src="https://i1.wp.com/2017.jakarta.wordcamp.org/files/2017/10/logo-rumahweb-panjang-tr-1.png?fit=1000%2C259&ssl=1"
                    class="img-fluid" />
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
                        <li>
                            <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                                <button type="submit" class="btn btn-link" value="all" name="tampil-data">Semua
                                    Karyawan</button>
                            </form>
                        </li>
                        <li>
                            <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                                <button type="submit" class="btn btn-link" value="tetap" name="tampil-data">Karyawan
                                    Tetap</button>
                            </form>
                        </li>
                        <li>
                            <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                                <button type="submit" class="btn btn-link" value="kontrak" name="tampil-data">Karyawan
                                    Kontrak</button>
                            </form>
                        </li>
                        <li>
                            <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                                <button type="submit" class="btn btn-link" value="magang" name="tampil-data">Karyawan
                                    Magang</button>
                            </form>
                        </li>
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
                            <form action="model/proses_login.php" method="POST" enctype="multipart/form-data">
                                <button class="btn btn-link btn-block" name="aksi" value="Logout" type="submit">
                                    <i class="material-icons">logout</i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="content">
            <!-- Navbar -->
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

            <!-- Main Content -->
            <div class="index main-content">
                <!-- Heading Dashboard -->
                <?php require_once "template/heading-dashboard.php"; ?>

                <!-- Card Jumlah Karyawan -->
                <?php
                    // Mengambil jumlah seluruh karyawan
                    $getTotal =  mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS total_kar FROM karyawan"));                    
                    
                    // Mengambil jumlah array tiap tipe karyawan
                    $getJmlTipeTetap = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS tetap FROM karyawan WHERE tipe_kar = 'Tetap'"));
                    $getJmlTipeKontrak = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS kontrak FROM karyawan WHERE tipe_kar = 'Kontrak'"));
                    $getJmlTipeMagang = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS magang FROM karyawan WHERE tipe_kar = 'Magang'"));
                ?>
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
                                    <a href="karyawan/data_karyawan.php?tampil-data=all">See detailed report</a>
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
                                    <a href="karyawan/data_karyawan.php?tampil-data=tetap">See detailed report</a>
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
                                    <a href="karyawan/data_karyawan.php?tampil-data=kontrak">See detailed report</a>
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
                                    <a href="karyawan/data_karyawan.php?tampil-data=magang">See detailed report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card bar chart jumlah Karyawan tiap divisi -->
                <?php
                    // Array nama-nama divisi
                    $namaDivisi = [
                        "Technical Support", 
                        "Developer", 
                        "NOC",
                        "Sales",
                        "Finance",
                        "Marketing",
                        "Billing",
                    ];
                    
                    // Mengambil jumlah array tiap divisi
                    for($i=0; $i<sizeof($namaDivisi); $i++){
                        $getJmlDivisiQuery[$i] = mysqli_fetch_assoc(mysqli_query($konek, "SELECT COUNT(*) AS jml_div FROM karyawan WHERE divisi = '".$namaDivisi[$i]."'"));
                    }

                    $dataPoints = array(
                        array("y" => $getJmlDivisiQuery[0]['jml_div'], "label" => $namaDivisi[0] ),
                        array("y" => $getJmlDivisiQuery[1]['jml_div'], "label" => $namaDivisi[1] ),
                        array("y" => $getJmlDivisiQuery[2]['jml_div'], "label" => $namaDivisi[2] ),
                        array("y" => $getJmlDivisiQuery[3]['jml_div'], "label" => $namaDivisi[3] ),
                        array("y" => $getJmlDivisiQuery[4]['jml_div'], "label" => $namaDivisi[4] ),
                        array("y" => $getJmlDivisiQuery[5]['jml_div'], "label" => $namaDivisi[5] ),
                        array("y" => $getJmlDivisiQuery[6]['jml_div'], "label" => $namaDivisi[6] ),
                    );
                ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-row justify-content-between">
                                Jumlah Karyawan Tiap Divisi <span class="material-icons me-5">equalizer</span>
                            </div>
                            <div class="card-body">
                                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Navtabs About + Organizaional Structure -->
                <div class="navbar-tabs">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item nav-about">
                                        <a href="#about" class="nav-link active" role="tab" data-toggle="tab">About</a>
                                    </li>
                                    <li class="nav-item nav-org-structure">
                                        <a href="#org-struct" class="nav-link" role="tab" data-toggle="tab">Organization
                                            Structure</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="about-content tab-pane active" role="tabpanel" id="about">
                                        <div class="about-container p-4">
                                            <h1>About</h1>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Sem et tortor
                                                consequat id porta nibh venenatis. Sagittis orci a scelerisque purus
                                                semper. Nunc consequat interdum varius sit amet mattis vulputate enim
                                                nulla. Curabitur vitae nunc sed velit. Quis imperdiet massa tincidunt
                                                nunc pulvinar sapien et ligula. Feugiat pretium nibh ipsum consequat. Eu
                                                consequat ac felis donec. Turpis in eu mi bibendum. Egestas fringilla
                                                phasellus faucibus scelerisque eleifend donec pretium. Mattis rhoncus
                                                urna neque viverra justo nec ultrices dui sapien. Quam nulla porttitor
                                                massa id. Tincidunt nunc pulvinar sapien et. Auctor eu augue ut lectus
                                                arcu bibendum. Condimentum lacinia quis vel eros donec. Nunc lobortis
                                                mattis aliquam faucibus. Leo a diam sollicitudin tempor id eu nisl nunc
                                                mi. Potenti nullam ac tortor vitae purus faucibus ornare suspendisse
                                                sed. Nunc faucibus a pellentesque sit amet porttitor eget dolor. Eget
                                                nunc lobortis mattis aliquam faucibus purus.</p>
                                        </div>
                                    </div>
                                    <div class="org-structure-content tab-pane" role="tabpanel" id="org-struct">
                                        <img class="p-4"
                                            src="https://sdn-117gresik.sch.id/wp-content/uploads/2021/02/Salinan-dari-Minarsihs.pd_.sd-President_COO_20210218_113442.png"
                                            alt="struktur-organisasi" width="100%">
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
    <script src="<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script src="<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
    // Bar Chart
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