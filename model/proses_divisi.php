<?php
    session_start();
    require_once '../config.php';

    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = ACCESS_DENIED;
        header('Location:../login.php');
    }

    include 'koneksi.php';

    $waktu = time();

    // Mengambil data karyawan dari form
    if(isset($_POST)){
        $id_divisi       = $_POST['id_divisi'];
        $nama_div        = $_POST['nama_div'];
        $visibility      = $_POST['visibility'];

        // Mengambil data karyawan dari database
        $query = mysqli_query($konek, "SELECT * FROM divisi WHERE id_divisi = $id_divisi");
        while($data=mysqli_fetch_array($query)){
            $tmp_id_divisi       = $data[0];
            $tmp_nama_div        = $data[1];
            $tmp_visibility      = $data[2];
        }

        switch($_POST['kelola']){
            case 'Tambah':
                if($visibility != ""){
                    $query = "INSERT INTO divisi VALUE ('', '$nama_div', '$visibility')";
                    if(mysqli_query($konek, $query)){
                        // Mengambil id divisi setelah ditambahkan
                        $id_divisi = mysqli_fetch_assoc(mysqli_query($konek, "SELECT id_divisi FROM divisi WHERE nama_div='$nama_div'"));

                        // Mengirimkan data ke table log_activities
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Created Divisi_$id_divisi[id_divisi]: $nama_div', 0, '$_SESSION[id_admin]');";
                        mysqli_query($konek, $query);

                        $_SESSION['msg'] = "Data Added Successfully"; // send message to table log_activities
                    }else{
                        $_SESSION['msg'] = "Failed Adding Data: ".mysqli_error($konek);
                    }
                }else{
                    $_SESSION['msg'] = "Data Tidak Boleh Kosong";
                    header('Location: ../divisi/data_divisi.php');
                }
                header('Location: ../divisi/data_divisi.php');
                break;
            case 'Edit':
                $query = "UPDATE divisi SET `nama_div`='$nama_div', `visibility`='$visibility' WHERE `id_divisi` = $id_divisi";
                if(mysqli_query($konek, $query)){
                    // Mengecek data yang diubah lalu mengirim pesan ke table log aktivitas
                    // nama divisi
                    if($nama_div != $tmp_nama_div){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Divisi_$id_divisi: $nama_div nama divisi to $nama_div', 0, '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    // visibility
                    if($visibility != $tmp_visibility){
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited Divisi_$id_divisi: $nama_div visibility to $visibility', 0, '$_SESSION[id_admin]');";
                        $result = mysqli_query($konek, $query);
                    }
                    $_SESSION['msg'] = "Data Updated Successfully"; // send message to table log_activities
                }else{
                    $_SESSION['msg'] = "Failed Updating Data: ".mysqli_error($konek);
                }

                header('Location: ../divisi/data_divisi.php');
                break;
            case 'Delete':
                $query = "DELETE FROM `divisi` WHERE `id_divisi` = '$id_divisi'";
                    if(mysqli_query($konek, $query)){
                        // Send message to log_activity table
                        $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Deleted Divisi_$id_divisi $nama_div', 0, '$_SESSION[id_admin]');";
                        mysqli_query($konek, $query);
                        $_SESSION['msg'] = "Data Deleted Successfully"; // send message to database log_activities
                    }else{
                        $_SESSION['msg'] = "Failed Deleting Data: ".mysqli_error($konek);
                    }

                header('Location: ../divisi/data_divisi.php');
                break;
        }
} 