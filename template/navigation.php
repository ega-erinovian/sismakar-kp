<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = "Anda harus login untuk mengakses halaman ini";
        header('Location:../login.php');
    }
    
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        session_destroy();
        session_unset();
    }
    
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time
?>

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
            <a href="../index.php" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
        </li>

        <!-- Dropdown Data Karyawan -->
        <li class="dropdown">
            <a href="#dropdownKaryawan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i
                    class="material-icons"> table_chart </i><span>Data Karyawan</span></a>
            <ul class="collapse list-unstyled menu" id="dropdownKaryawan">
                <li>
                    <form action="../karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                        <input type="hidden" value="all" name="tampil-data">
                        <button type="submit" class="btn btn-link">Semua Karyawan</button>
                    </form>
                </li>
                <li>
                    <form action="../karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                        <input type="hidden" value="tetap" name="tampil-data">
                        <button type="submit" class="btn btn-link">Karyawan Tetap</button>
                    </form>
                </li>
                <li>
                    <form action="../karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                        <input type="hidden" value="kontrak" name="tampil-data">
                        <button type="submit" class="btn btn-link">Karyawan Kontrak</button>
                    </form>
                </li>
                <li>
                    <form action="../karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
                        <input type="hidden" value="magang" name="tampil-data">
                        <button type="submit" class="btn btn-link">Karyawan Magang</button>
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
                    <a href="#"><i class="material-icons">edit</i>Edit Profile</a>
                </li>
                <li>
                    <a href="#"><i class="material-icons">history</i>Log Activity</a>
                </li>
                <li>
                    <form action="../model/proses_login.php" method="POST" enctype="multipart/form-data">
                        <button class="btn btn-link btn-block" name="aksi" value="Logout" type="submit">
                            <i class="material-icons">logout</i>Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Page Content  -->
<div id="content">
    <!-- Navbar -->
    <div class="top-navbar">
        <nav class="navbar">
            <div class="container-fluid justify-content-start align-items-center">
                <!-- Tombol untuk toggle sidebar -->
                <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-none d-none transparent">
                    <span class="material-icons"> menu </span>
                </button>

                <!-- Heading Navbar -->
                <a class="navbar-brand" href="../index.php">
                    <h4><strong>Dashboard</strong></h4>
                </a>

                <!-- Tombol untuk toggle sidebar - Mobile view -->
                <button id="sidebarCollapse" class="d-inline-block d-lg-none ml-auto more-button" type="button"
                    data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="material-icons">menu</span>
                </button>
            </div>
        </nav>
    </div>