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
            // Send message to log_activity table
            if($username != $tmp_username){
                $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited admin_$id_admin username to $username', '', '$id_admin');";
                $result = mysqli_query($konek, $query);
            }

            if($password != ""){
                if(!password_verify($password, $tmp_password)){
                    $query = "INSERT INTO log_activity VALUE ('', '$waktu', 'Edited admin_$id_admin password', '', '$id_admin');";
                    $result = mysqli_query($konek, $query);
                }
            }
            
            $_SESSION['login'] = "Data updated successfully."; // send message to database log_activities
        }else{
            $_SESSION['login'] = mysqli_error($konek);
        }
        header('Location:../login.php');
    }