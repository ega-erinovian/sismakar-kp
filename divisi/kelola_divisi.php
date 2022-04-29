<?php
    session_start();
    require_once '../config.php'; 

    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = ACCESS_DENIED;
        header('Location:../login.php');
    }

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
    <link rel="icon" type="image/png" href="assets/img/icon-rmwb.png" style="object-fit: cover;">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title><?= SITENAME ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/bootstrap.min.css?v=<?php echo time(); ?>" />
    <!----css3---->
    <link rel="stylesheet" href="../<?= URL_CSS ?>/custom.css?v=<?php echo time(); ?>" />
    <!-- Google Font -->
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

        <!-- Template Navbar + Sidebar -->
        <?php include "../template/navigation.php"; ?>
        <div class="main-content">

            <!-- Heading Dashboard -->
            <?php require_once "../template/heading-dashboard.php"; ?>

            <!-- Peringatan Hapus Divisi -->
            <?php
                if($_POST['kelola'] == 'Delete'){
            ?>
            <div class="alert alert-danger mt-3" role="alert">
                Anda yakin ingin menghapus divisi ini? Tekan tombol <b>Submit</b> untuk melanjutkan proses
                <b>Hapus</b>
            </div>
            <?php
                }
            ?>

            <!-- Card Kelola Divisi -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3><?= $_POST['kelola'] ?> Divisi</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form kelola Divisi -->
                            <form class="row g-3" action="../model/proses_divisi.php" method="post"
                                enctype="multipart/form-data">
                                <?php

                                        if(isset($_POST['kelola'])){
                                            // 'Tambah' condition
                                            if($_POST['kelola'] == 'Tambah'){
                                                $id_divisi  = "";
                                                $nama_div   = "";
                                                $visibility = "";
                                            }else{
                                                // 'Edit' Condition - Form terisi dengan data didatabase
                                                $query = mysqli_query($konek, "SELECT * FROM divisi WHERE id_divisi = ".$_POST['id_divisi']);
                                                while($data=mysqli_fetch_array($query)){
                                                    $id_divisi  = $data[0];
                                                    $nama_div   = $data[1];
                                                    $visibility = $data[2];
                                                }
                                            }
                                        }
                                    ?>
                                <input type="hidden" name="kelola" value="<?= $_POST['kelola'] ?>" />
                                <input type="hidden" name="id_divisi" value="<?= $id_divisi ?>">
                                <div class="col-12 mb-3">
                                    <label for="inputNama" class="form-label">Nama Divisi</label>
                                    <input type="text" class="form-control" value="<?= $nama_div ?>" name="nama_div"
                                        id="inputNama" placeholder="ex. Network Operation Center" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputTipe" class="form-label">Visibility</label>
                                    <select class="form-control" name="visibility" id="inputVisibility" required>
                                        <option disabled selected>Pilih Visibilitas</option>
                                        <option <?php if($visibility=="show") echo 'selected'; ?>>show
                                        </option>
                                        <option <?php if($visibility=="hide") echo 'selected'; ?>>hide
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12" style="text-align: end;">
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="../<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/popper.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/script.js"></script>
    <script>
    // Image upload size limit
    var MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

    $(document).ready(function() {
        $("#uploadImg").change(function() {
            fileSize = this.files[0].size;
            if (fileSize > MAX_FILE_SIZE) {
                this.setCustomValidity("File must not exceed 5 MB!");
                this.reportValidity();
                this.value = "";
            } else {
                this.setCustomValidity("");
            }
        });
    });

    function findTipeValue() {
        if ($("#inputTipe").val() === "Tetap") {
            $(".tgl-selesai-wrapper").addClass("d-none")
        } else {
            $(".tgl-selesai-wrapper").removeClass("d-none")
        }
    }
    </script>
</body>

</html>