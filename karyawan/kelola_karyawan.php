<?php include '../config.php'; ?>

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

            <!-- Card Kelola Karyawan -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3><?= $_GET['kelola'] ?> Karyawan</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form kelola karyawan -->
                            <form class="row g-3" action="../model/proses_kar.php" method="post"
                                enctype="multipart/form-data">
                                <?php
                                        if(isset($_GET['kelola'])){
                                            // 'Tambah' condition - form dikosongkan
                                            if($_GET['kelola'] == 'Tambah'){
                                                $id_kar      = "";
                                                $nama        = "";
                                                $divisi      = "";
                                                $jabatan     = "";
                                                $tipe_kar    = "";
                                                $tgl_masuk   = "";
                                                $tgl_selesai = "";
                                                $email       = "";
                                                $no_telp     = "";
                                                $alamat      = "";
                                                $jenis_kel   = "";
                                                $status_kar  = "";
                                                $profile_img = "";
                                            }
                                        }
                                    ?>
                                <input type="hidden" name="kelola" value="<?= $_GET['kelola'] ?>" />
                                <input type="hidden" name="id_kar" value="<?= $id_kar ?>">
                                <div class="col-12 mb-3">
                                    <label for="inputNama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" value="<?= $nama ?>" name="nama"
                                        id="inputNama" placeholder="ex. John Doe" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="inputDivisi" class="form-label">Divisi</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="divisi" required>
                                        <option value="0" disabled selected>Pilih Divisi</option>
                                        <option <?php if($divisi=="Front-End Developer") echo 'selected'; ?>>Front-End
                                            Developer</option>
                                        <option <?php if($divisi=="Back-End Developer") echo 'selected'; ?>>Back-End
                                            Developer</option>
                                        <option <?php if($divisi=="Network Engineer") echo 'selected'; ?>>Network
                                            Engineer</option>
                                        <option <?php if($divisi=="Finance") echo 'selected'; ?>>Finance
                                        </option>
                                        <option <?php if($divisi=="Marketing") echo 'selected'; ?>>Marketing</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="inputJabatan" class="form-label">Jabatan</label>
                                    <input type="text" value="<?= $jabatan ?>" name="jabatan" class="form-control"
                                        id="inputJabatan" placeholder="Ex. Supervisor" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputTipe" class="form-label">Tipe Karyawan</label>
                                    <select class="form-control" name="tipe_kar" id="inputTipe" required>
                                        <option disabled selected>Pilih Tipe Pegawai</option>
                                        <option <?php if($tipe_kar=="Tetap") echo 'selected'; ?>>Tetap
                                        </option>
                                        <option <?php if($tipe_kar=="Kontrak") echo 'selected'; ?>>Kontrak
                                        </option>
                                        <option <?php if($tipe_kar=="Magang") echo 'selected'; ?>>Magang
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3 form-group">
                                    <label class="form-label">Tanggal Masuk</label>
                                    <input type="datetime-local" class="form-control" name="tgl_masuk" id="tgl_masuk"
                                        placeholder="YYYY/MM/DDThh:mm" value='<?= date("Y-m-d\TH:i",$tgl_masuk);?>'>
                                </div>
                                <div class="col-12 mb-3 form-group">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="datetime-local" class="form-control" name="tgl_selesai"
                                        id="tgl-selesai" placeholder="YYYY/MM/DDTHH:mm"
                                        value="<?= date("Y-m-d\TH:i", $tgl_selesai);?>"
                                        min="<?= date("Y-m-d\TH:i", $tgl_masuk);?>">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail" value="<?= $email ?>"
                                        name="email" placeholder="ex. email@email.com" required>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="inputNumber" class="form-label">No. Telp</label>
                                    <input type="number" class="form-control" id="inputNumber" value="<?= $no_telp ?>"
                                        name="no_telp" placeholder="Ex. 081212341234" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputAlamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="inputAlamat" value="<?= $alamat ?>"
                                        name="alamat" placeholder="ex. Jalan jalan, Sleman, DIY" required>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="inputJenisKelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="inputJenisKelamin" name="jenis_kel" required>
                                        <option disabled selected>Pilih Jenis Kelamin</option>
                                        <option <?php if($jenis_kel=="Laki-laki") echo 'selected'; ?>>Laki-laki</option>
                                        <option <?php if($jenis_kel=="Perempuan") echo 'selected'; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="inputStatus" class="form-label">Status Karyawan</label>
                                    <select class="form-control" id="inputStatus" name="status_kar" required>
                                        <option <?php if($status_kar=="Aktif") echo 'selected'; ?>>Aktif</option>
                                        <option <?php if($status_kar=="Tidak Aktif") echo 'selected'; ?>>Tidak Aktif
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="uploadImg">Upload Foto</label>
                                        <input type="file" class="form-control-file" id="uploadImg" name="profile_img"
                                            accept=".jpg,.gif,.png,.webp">
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
    <script type="text/javascript" src="../<?= URL_JS ?>/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/popper.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="../<?= URL_JS ?>/script.js"></script>
</body>

</html>