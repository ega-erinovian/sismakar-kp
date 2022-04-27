<?php
    session_start();
    date_default_timezone_set("Asia/Jakarta");
    require_once '../config.php';
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = ACCESS_DENIED;
        header('Location:../login.php');
    }
    
    include 'koneksi.php';

    $waktu = time();

    // Mengambil data karyawan dari database
    $query = mysqli_query($konek, "SELECT * FROM karyawan WHERE id_kar = $_POST[id_kar]");
    while($data=mysqli_fetch_array($query)){
        $tmp_id_kar      = $data[0];
        $tmp_nama        = $data[1];
        $tmp_divisi      = $data[2];
        $tmp_jabatan     = $data[3];
        $tmp_tipe_kar    = $data[4];
        $tmp_tgl_masuk   = $data[5];
        $tmp_tgl_selesai = $data[6];
        $tmp_email       = $data[7];
        $tmp_no_telp     = $data[8];
        $tmp_alamat      = $data[9];
        $tmp_jenis_kel   = $data[10];
        $tmp_status_kar  = $data[11];
        $tmp_profile_img = $data[12];
    }

    // Mengambil data karyawan dari form
    if(isset($_POST)){
        $id_kar      = $_POST['id_kar'];
        $nama        = $_POST['nama'];
        $divisi      = $_POST['divisi'];
        $jabatan     = $_POST['jabatan'];
        $tipe_kar    = $_POST['tipe_kar'];
        $tgl_masuk   = strtotime($_POST['tgl_masuk']);
        $tgl_selesai = strtotime($_POST['tgl_selesai']);
        $email       = $_POST['email'];
        $no_telp     = $_POST['no_telp'];
        $alamat      = $_POST['alamat'];
        $jenis_kel   = $_POST['jenis_kel'];
        $status_kar  = $_POST['status_kar'];
        
        // Img uploading
        if($_FILES['profile_img']['name'] != ""){
            $img_name = $_FILES['profile_img']['name'];
            $tmp_name = $_FILES['profile_img']['tmp_name'];
            
            // Getting image path
            $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
            
            // Clean-up name from prohibited letter 
            $arrNama = explode(' ', $nama);
            
            // Remove name whitespace
            $nameForImg = preg_replace('/\s/','',$nama);

            $new_img_name = md5(rand()).'.'.$img_ext;

            $uploaded_path = '../assets/img/'.$new_img_name;
            move_uploaded_file($tmp_name, $uploaded_path);
        }
        
        switch($_POST['kelola']){
            case 'Tambah':
                $query = "INSERT INTO karyawan VALUE ('', '$nama', '$divisi', '$jabatan', '$tipe_kar', '$tgl_masuk', '$tgl_selesai', '$email', '$no_telp', '$alamat', '$jenis_kel', '$status_kar', '$new_img_name')";
                if(mysqli_query($konek, $query)){
                    // Mengambil id_kar setelah ditambahkan
                    $id_kar = mysqli_fetch_assoc(mysqli_query($konek, "SELECT id_kar FROM karyawan WHERE nama='$nama'"));

                    // Mengirimkan data ke table log_activities
                    $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Created Karyawan_$id_kar[id_kar]: $nama', '$id_kar[id_kar]', '$_SESSION[id_admin]');";
                    mysqli_query($konek, $query);

                    $_SESSION['msg'] = "Data Added Successfully"; // send message to table log_activities
                }else{
                    unlink($uploaded_path);
                    $_SESSION['msg'] = "Failed Deleting Data: ".mysqli_error($konek);
                }
                header('Location: ../karyawan/data_karyawan.php?tipe-kar='.$_POST['tampil_kar']);
                break;
            case 'Edit':
                if($img_ext != ''){
                    // Jika nama img berbeda dengan yang didatabase, maka file sebelumnya akan dihapus
                    if($tmp_profile_img != $new_img_name){
                        $path = realpath('../assets/img/'.$tmp_profile_img);
                        unlink($path);
                    }
                    
                    $query = "UPDATE karyawan SET `nama`='$nama', `divisi`='$divisi', `jabatan`='$jabatan', `tipe_kar`='$tipe_kar', `tgl_masuk`='$tgl_masuk', `tgl_selesai`='$tgl_selesai', `email`='$email', `no_telp`='$no_telp', `alamat`='$alamat', `jenis_kel`='$jenis_kel', `status_kar`='$status_kar', `profile_img`='$new_img_name' WHERE `id_kar` = $id_kar";            
                }else{
                    $query = "UPDATE karyawan SET `nama`='$nama', `divisi`='$divisi', `jabatan`='$jabatan', `tipe_kar`='$tipe_kar', `tgl_masuk`='$tgl_masuk', `tgl_selesai`='$tgl_selesai', `email`='$email', `no_telp`='$no_telp', `alamat`='$alamat', `jenis_kel`='$jenis_kel', `status_kar`='$status_kar' WHERE `id_kar` = $id_kar";            
                }
                
                if(mysqli_query($konek, $query)){
                    // Mengecek data yang diubah lalu mengirim pesan ke table log aktivitas
                    // nama
                    if($nama != $tmp_nama){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar nama to $nama', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // divisi
                    if($divisi != $tmp_divisi){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar divisi to $divisi', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // jabatan
                    if($jabatan != $tmp_jabatan){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar jabatan to $jabatan', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // tipe_kar
                    if($tipe_kar != $tmp_tipe_kar){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar tipe karyawan to $tipe_kar', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // tgl_masuk
                    if($tgl_masuk != $tmp_tgl_masuk){
                        $tgl_masuk = date("Y-m-d H:i:s",$tgl_masuk);
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar tanggal masuk to $tgl_masuk', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // tgl_selesai
                    if($tgl_selesai != $tmp_tgl_selesai){
                        $tgl_selesai = date("Y-m-d H:i:s",$tgl_selesai);
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar tanggal selesai to $tgl_selesai', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // email
                    if($email != $tmp_email){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar email to $email', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // no_telp
                    if($no_telp != $tmp_no_telp){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar nomor telepon to $no_telp', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // alamat
                    if($alamat != $tmp_alamat){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar alamat to $alamat', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // status_kar
                    if($status_kar != $tmp_status_kar){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar stat karyawan to $status_kar', '$id_kar', '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // profile_img
                    if($img_ext != ''){
                        if($tmp_profile_img != $new_img_name){
                            $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Karyawan_$id_kar foto profil to $new_img_name', '$id_kar', '$_SESSION[id_admin]');";
                            $result = mysqli_query($konek, $query);
                        }
                    }
                    $_SESSION['msg'] = "Data Updated Successfully"; // send message to table log_activities
                }else{
                    $_SESSION['msg'] = "Failed Deleting Data: ".mysqli_error($konek);
                }
                
                header('Location: ../karyawan/data_karyawan.php?tipe-kar='.$_POST['tampil_kar']);
                break;
            case 'Delete':
                $query = "DELETE FROM `karyawan` WHERE `id_kar` = '$_POST[id_kar]'";
                $path = realpath('../assets/img/'.$tmp_profile_img);
                if(mysqli_query($konek, $query)){
                    unlink($path);
                    // Send message to log_activity table
                    $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Deleted Karyawan_$id_kar: $nama', '$id_kar', '$_SESSION[id_admin]');";
                    mysqli_query($konek, $query);

                    $_SESSION['msg'] = "Data Deleted Successfully"; // send message to database log_activities
                }else{
                    $_SESSION['msg'] = "Failed Deleting Data: ".mysqli_error($konek);
                }
                header('Location: ../karyawan/data_karyawan.php?tipe-kar='.$_POST['tampil_kar']);
                break;
        }
}