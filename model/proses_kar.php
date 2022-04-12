<?php
    session_start();
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = "Anda harus login untuk mengakses halaman ini";
        header('Location:../login.php');
    }
    include 'koneksi.php';

    // Proses Karyawan
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

        switch($_POST['kelola']){
            case 'Tambah':
                $query = "INSERT INTO karyawan VALUE ('', '$nama', '$divisi', '$jabatan', '$tipe_kar', '$tgl_masuk', '$tgl_selesai', '$email', '$no_telp', '$alamat', '$jenis_kel', '$status_kar', '$new_img_name')";
                if(mysqli_query($konek, $query)){
                    $_SESSION['msg'] = "Data Added Successfully"; // send message to table log_activities
                }else{
                    $_SESSION['msg'] = mysqli_error($konek);
                }
                header('Location: ../karyawan/data_karyawan.php?tampil-data=all');
                break;
            case 'Edit':
                if($img_ext != ''){
                    // Mengambil data profile_img
                    $profile_img = mysqli_fetch_assoc(mysqli_query($konek, "SELECT profile_img FROM karyawan WHERE `id_kar` = $id_kar"));
                    
                    // Jika nama img berbeda dengan yang didatabase, maka file sebelumnya akan dihapus
                    if($profile_img != $new_img_name){
                        $path = realpath('../assets/img/'.$profile_img['profile_img']);
                        unlink($path);
                    }
                    $query = "UPDATE karyawan SET `nama`='$nama', `divisi`='$divisi', `jabatan`='$jabatan', `tipe_kar`='$tipe_kar', `tgl_masuk`='$tgl_masuk', `tgl_selesai`='$tgl_selesai', `email`='$email', `no_telp`='$no_telp', `alamat`='$alamat', `jenis_kel`='$jenis_kel', `status_kar`='$status_kar', `profile_img`='$new_img_name' WHERE `id_kar` = $id_kar";            
                }else{
                    $query = "UPDATE karyawan SET `nama`='$nama', `divisi`='$divisi', `jabatan`='$jabatan', `tipe_kar`='$tipe_kar', `tgl_masuk`='$tgl_masuk', `tgl_selesai`='$tgl_selesai', `email`='$email', `no_telp`='$no_telp', `alamat`='$alamat', `jenis_kel`='$jenis_kel', `status_kar`='$status_kar' WHERE `id_kar` = $id_kar";            
                }
                
                if(mysqli_query($konek, $query)){
                    $_SESSION['msg'] = "Data Updated Successfully"; // send message to table log_activities
                }else{
                    $_SESSION['msg'] = mysqli_error($konek);
                }
                
                header('Location: ../karyawan/data_karyawan.php?tampil-data=all');
                break;
            case 'Delete':
                $profile_img = mysqli_fetch_assoc(mysqli_query($konek, "SELECT profile_img FROM karyawan WHERE id_kar='$_POST[id_kar]'"));
                $query = "DELETE FROM `karyawan` WHERE `id_kar` = '$_POST[id_kar]'";
                $path = realpath('../assets/img/'.$profile_img['profile_img']);
                if(is_writable($path)){
                    if(unlink($path)){
                        if(mysqli_query($konek, $query)){
                            $_SESSION['msg'] = "Data Deleted Successfully"; // send message to database log_activities
                        }else{
                            $_SESSION['msg'] = mysqli_error($konek);
                        }
                    }else{
                        $_SESSION['msg'] = "Data cannot be deleted, image not found, delete the data using MySQL";
                    }
                }
                header('Location: ../karyawan/data_karyawan.php?tampil-data=all');
                break;
        }
}