<?php
    include 'koneksi.php';
    session_start();

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
                    $_SESSION['msg'] = "Data Added Successfully"; // send message to database log_activities
                }else{
                    $_SESSION['msg'] = mysqli_error($konek);
                }
                header('Location: ../karyawan/data_karyawan.php?tampil-data=all');
                break;
        }
}