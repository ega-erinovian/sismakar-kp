<?php
    session_start();
    date_default_timezone_set("Asia/Jakarta");
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

            <!-- Peringatan Hapus Karyawan -->
            <?php
                if($_POST['kelola'] == 'Delete'){
            ?>
            <div class="alert alert-danger mt-3" role="alert">
                Anda yakin ingin menghapus karyawan ini? Tekan tombol <b>Submit</b> untuk melanjutkan proses
                <b>Hapus</b>
            </div>
            <?php
                }
            ?>

            <!-- Card Kelola Karyawan -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3><?= $_POST['kelola'] ?> Karyawan</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form kelola karyawan -->
                            <form class="row g-3" action="../model/proses_kar.php" method="post"
                                enctype="multipart/form-data">
                                <?php
                                
                                        if(isset($_POST['kelola'])){
                                            if(isset($_POST['tipe-kar'])) $tipeKar = $_POST['tipe-kar'];
                                            // 'Tambah' condition
                                            if($_POST['kelola'] == 'Tambah'){
                                                $id_kar      = "";
                                                $nama        = "";
                                                $divisi      = "";
                                                $jabatan     = "";
                                                $tipe_kar    = $tipeKar;
                                                $tgl_masuk   = date("Y-m-d\TH:i");
                                                $tgl_selesai = date("Y-m-d\TH:i");
                                                $email       = "";
                                                $no_telp     = "";
                                                $alamat      = "";
                                                $jenis_kel   = "";
                                                $status_kar  = "";
                                                $profile_img = "";

                                                if($tipeKar == 'All'){
                                                    $tipe_kar = "";
                                                    $tgl_selesai = 0;
                                                }
                                            }else{
                                                // 'Edit' Condition - Form terisi dengan data didatabase
                                                $query = mysqli_query($konek, "SELECT * FROM karyawan WHERE id_kar = ".$_POST['id_kar']);
                                                while($data=mysqli_fetch_array($query)){
                                                    $id_kar      = $data[0];
                                                    $nama        = $data[1];
                                                    $divisi      = $data[2];
                                                    $jabatan     = $data[3];
                                                    $tipe_kar    = $data[4];
                                                    $tgl_masuk   = date("Y-m-d\TH:i", $data[5]);
                                                    $tgl_selesai = date("Y-m-d\TH:i", $data[6]);
                                                    $email       = $data[7];
                                                    $no_telp     = $data[8];
                                                    $alamat      = $data[9];
                                                    $jenis_kel   = $data[10];
                                                    $status_kar  = $data[11];
                                                }

                                                $tipeKar = $tipe_kar;
                                            }
                                        }
                                    ?>
                                <input type="hidden" name="kelola" value="<?= $_POST['kelola'] ?>" />
                                <input type="hidden" name="tampil_kar" value="<?= $tipeKar ?>" />
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
                                        <?php
                                            // Mengambil nama div & visibility dari tabel divisi
                                            $query = mysqli_query($konek, "SELECT * FROM divisi");
                                            while($data=mysqli_fetch_array($query)){
                                                $nama_div       = $data[1];
                                                $visibility     = $data[2];
                                                // Tampilkan jika visibility = show
                                                if($visibility == 'show'){
                                        ?>
                                        <option <?php if($divisi==$nama_div) echo 'selected'; ?>><?=$nama_div?></option>
                                        <?php
                                            }}
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="inputJabatan" class="form-label">Jabatan</label>
                                    <input type="text" value="<?= $jabatan ?>" name="jabatan" class="form-control"
                                        id="inputJabatan" placeholder="Ex. Supervisor" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputTipe" class="form-label">Tipe Karyawan</label>
                                    <select class="form-control" name="tipe_kar" id="inputTipe"
                                        onchange="findTipeValue()" required>
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
                                        placeholder="YYYY/MM/DDThh:mm" value='<?= $tgl_masuk ?>'>
                                </div>
                                <?php if($tipeKar != 'Tetap'){ ?>
                                <div class='col-12 mb-3 form-group tgl-selesai-wrapper'>
                                    <label class='form-label'>Tanggal Selesai</label>
                                    <input type='datetime-local' class='form-control' name='tgl_selesai' id='tglSelesai'
                                        min='<?= $tgl_masuk ?>' placeholder='YYYY/MM/DDTHH:mm'
                                        value='<?= $tgl_selesai ?>'>
                                </div>
                                <?php } ?>
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

    // Menangkap value jika input select dipilih, kemudian menghilangkan input select tanggal selesai
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