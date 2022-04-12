<?php
    session_start();
    
    // Kondisi jika belum login - akan dikirim lagi ke login.php
    if (!isset($_SESSION["username"])) {
        $_SESSION['login'] = "Anda harus login untuk mengakses halaman ini";
        header('Location:../login.php');
    }
    
    include 'koneksi.php';
    
    if(isset($_POST)){
        $id_admin   = $_POST['id_admin'];
        $username   = $_POST['username'];
        $password   = $_POST['pass'];

        $query = mysqli_query($konek, "SELECT * FROM admin WHERE id_admin = $_SESSION[id_admin]");
        while($data=mysqli_fetch_array($query)){
            $tmp_id_admin      = $data[0];
            $tmp_username      = $data[1];
            $tmp_password      = $data[2];
        }
        // Hashing password
        if($password != ""){
            $password   = password_hash($password, PASSWORD_DEFAULT);
        }

        // Lanjut proses UPDATE ke database
        if($password != ""){
            $query = "UPDATE `admin` SET `username`='$username',`pass`='$password' WHERE id_admin = '$id_admin'";
        }else{
            $query = "UPDATE `admin` SET `username`='$username' WHERE id_admin = '$id_admin'";
        }
        
        if(mysqli_query($konek, $query)){
            $_SESSION['msg'] = "Data Updated Successfully"; // send message to database log_activities
        }else{
            $_SESSION['msg'] = mysqli_error($konek);
        }
        header('Location: ../admin/kelola_admin.php');
    }