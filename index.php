<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title><?= SITENAME ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL_CSS ?>/bootstrap.min.css" />
    <!----css3---->
    <link rel="stylesheet" href="<?= URL_CSS ?>/custom.css" />
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
                                <input type="hidden" value="all" name="tampil-data">
                                <button type="submit" class="a btn btn-link">Semua Karyawan</button>
                            </form>
                        </li>
                        <li>
                            <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                                <input type="hidden" value="tetap" name="tampil-data">
                                <button type="submit" class="a btn btn-link">Karyawan Tetap</button>
                            </form>
                        </li>
                        <li>
                            <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                                <input type="hidden" value="kontrak" name="tampil-data">
                                <button type="submit" class="a btn btn-link">Karyawan Kontrak</button>
                            </form>
                        </li>
                        <li>
                            <form action="karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                                <input type="hidden" value="magang" name="tampil-data">
                                <button type="submit" class="a btn btn-link">Karyawan Magang</button>
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
                            <a href="login.php"><i class="material-icons">logout</i>Log out</a>
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

            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script src="<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script src="<?= URL_JS ?>/script.js"></script>
    <script src="<?= URL_JS ?>/bootstrap.min.js"></script>
    <script src="<?= URL_JS ?>/popper.min.js"></script>

</body>

</html>