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
</head>

<body>
    <div class="wrapper">
        <!-- Darken background in mobile view for offcanvas -->
        <div class="body-overlay"></div>

        <!-- Template Navbar + Sidebar -->
        <?php require_once "../template/navigation.php"; ?>
        <div class="main-content">

            <!-- Header 'Sistem Manajemen Karyawan -->
            <?php require_once "../template/heading-dashboard.php"; ?>

            <!-- Card kelola admin -->
            <div class="row">
                <div class="col-12">
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
                    <div class="card">
                        <div class="card-header">
                            <h3>Edit Data Admin</h3>
                            <small id="emailHelp" class="form-text text-muted">Username and Password input do not
                                allow spacing and special character such as (@), (!), (""), etc </small>
                        </div>
                        <div class="card-body">
                            <!-- Form Kelola Admin -->
                            <form class="row g-3" action="../model/proses_admin.php" method="post"
                                enctype="multipart/form-data">
                                <?php
                                    $query = mysqli_query($konek, "SELECT * FROM admin WHERE id_admin=$_SESSION[id_admin]");
                                    while($data=mysqli_fetch_array($query)){
                                        $id_admin      = $data[0];
                                        $username      = $data[1];
                                        $password      = $data[2];
                                    }
                                ?>
                                <input type="hidden" name="id_admin" value="<?= $id_admin ?>">
                                <div class=" col-12 mb-3">
                                    <label for="inputNama" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="inputUsername"
                                        placeholder="ex. John Doe" name="username" value="<?= $username ?>" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputPass" class="form-label">New Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control"
                                            aria-label="Text input with checkbox" id="inputPass"
                                            placeholder="Enter New Password" name="pass">
                                        <div class="input-group-append">
                                            <a class="btn input-group-text" id="show_hide_pass"><i
                                                    class="material-icons">visibility_off</i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputConfPass" class="form-label">Confirm New Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control"
                                            aria-label="Text input with checkbox" id="inputConfPass"
                                            placeholder="Enter New Password">
                                        <div class="input-group-append">
                                            <a class="btn input-group-text" id="show_hide_conf"><i
                                                    class="material-icons">visibility_off</i></a>
                                        </div>
                                    </div>
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
    <!-- jQuery -->
    <script src="../<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script src="../<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script src="../<?= URL_JS ?>/popper.min.js"></script>
    <script src="../<?= URL_JS ?>/bootstrap.min.js"></script>
    <script src="../<?= URL_JS ?>/script.js"></script>

    <!-- Show or Hide Password JS -->
    <script>
    // Password
    $(document).ready(function() {
        $("#show_hide_pass").on("click", function(e) {
            e.preventDefault();
            if ($("#inputPass").attr("type") == "password") {
                $("#inputPass").attr("type", "text");
                $("#show_hide_pass .material-icons").text("visibility");
            } else {
                $("#inputPass").attr("type", "password");
                $("#show_hide_pass .material-icons").text("visibility_off");
            }
        });
    });

    // Password Confirmation
    $(document).ready(function() {
        $("#show_hide_conf").on("click", function(e) {
            e.preventDefault();
            if ($("#inputConfPass").attr("type") == "password") {
                $("#inputConfPass").attr("type", "text");
                $("#show_hide_conf .material-icons").text("visibility");
            } else {
                $("#inputConfPass").attr("type", "password");
                $("#show_hide_conf .material-icons").text("visibility_off");
            }
        });
    });
    </script>

    <!-- Prevent special characters on input form -->
    <script>
    // Username
    $(document).ready(function() {
        $(document).on("keyup", "#inputUsername", function() {
            $("#inputUsername").val($("#inputUsername").val().replace(/[^a-zA-Z0-9\s]/gi, '').replace(
                /[_\s]/g, ''));
        });
    });

    // Password
    $(document).ready(function() {
        $(document).on("keyup", "#inputPass", function() {
            $("#inputPass").val($("#inputPass").val().replace(/[^a-zA-Z0-9\s]/gi, '').replace(
                /[_\s]/g, ''));
        });
    });

    // Password Confirmation
    $(document).ready(function() {
        $(document).on("keyup", "#inputConfPass", function() {
            $("#inputConfPass").val($("#inputConfPass").val().replace(/[^a-zA-Z0-9\s]/gi, '').replace(
                /[_\s]/g, ''));
        });
    });
    </script>
</body>

</html>