<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = ACCESS_DENIED;
        header('Location:../login.php');
    }
?>

<nav id="sidebar">
    <!-- Heading Sidebar -->
    <div class="sidebar-header">
        <img src=<?= RUMAHWEB_LOGO ?> class="img-fluid" />
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
                <form action="../karyawan/data_karyawan.php" method="get" enctype="multipart/form-data">
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
                    <a href="../admin/kelola_admin.php"><i class="material-icons">edit</i>Edit Profile</a>
                </li>
                <li>
                    <a href="../admin/log_admin.php"><i class="material-icons">history</i>Log Activity</a>
                </li>
                <li>
                    <a href="../divisi/data_divisi.php"><i class="material-icons">groups</i>Kelola Divisi</a>
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