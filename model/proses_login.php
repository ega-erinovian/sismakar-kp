<?php
    session_start();
    
    include '../model/koneksi.php';

    if($_POST['aksi'] == 'Login'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $query = mysqli_query($konek , "SELECT * FROM admin WHERE username='$username'");
        while($data=mysqli_fetch_array($query)){
            $id_admin      = $data[0];
            $username      = $data[1];
            $pass          = $data[2];
        }
    
        if(password_verify($password, $pass)){
            $_SESSION["id_admin"]   =$id_admin;
            $_SESSION["username"]   =$username;
            $_SESSION["pass"]       =$pass;
    
            header('Location:../index.php');
        }else {
            $_SESSION['login'] = "Username atau Password salah.";
            header('Location:../login.php');
        }
    }else if($_POST['aksi'] == 'Logout'){
        session_unset();
        session_destroy();
        session_write_close();
        header('Location:../login.php');
    }