<?php 
    session_start();
    require_once 'config.php'; 
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
    <link rel="stylesheet" href="<?= URL_CSS ?>/bootstrap.min.css?v=<?php echo time(); ?>" />
    <!----css3---->
    <link rel="stylesheet" href="<?= URL_CSS ?>/custom.css?v=<?php echo time(); ?>" />
    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet" />

    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
</head>

<body>
    <section class="login-page">
        <div class="container h-100">
            <!-- Alert saat gagal login -->
            <div class="row">
                <div class="col-12 position-relative">
                    <?php
                        if(isset($_SESSION['login'])){
                    ?>
                    <div class="alert alert-primary alert-dismissible fade show mt-3 w-100 position-absolute"
                        role="alert">
                        <?= $_SESSION['login']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                        session_unset();
                        }
                    ?>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <!-- Card Login -->
                    <div class="card shadow-lg" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <!-- Form Login -->
                            <form action="model/proses_login.php" method="POST" enctype="multipart/form-data">
                                <img src="https://i1.wp.com/2017.jakarta.wordcamp.org/files/2017/10/logo-rumahweb-panjang-tr-1.png?fit=1000%2C259&ssl=1"
                                    class="img-fluid mb-5" />
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="inputUsername">Username</label>
                                    <input type="text" id="inputUsername" class="form-control form-control-lg"
                                        name="username" />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="inputPass">Password</label>
                                    <input type="password" id="inputPass" class="form-control form-control-lg"
                                        name="password" />
                                </div>
                                <button class="btn btn-primary btn-lg btn-block" name="aksi" value="Login"
                                    type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script src="<?= URL_JS ?>/bootstrap.min.js"></script>
    <script src="<?= URL_JS ?>/popper.min.js"></script>
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
    </script>
</body>

</html>