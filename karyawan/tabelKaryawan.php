<?php
    function tampilTabelKaryawan($konek, $tipeKar){
        if($tipeKar == 'All'){
            $query = mysqli_query($konek, "SELECT * FROM karyawan");
        }else{
            $query = mysqli_query($konek, "SELECT * FROM karyawan WHERE tipe_kar = '".$tipeKar."'");
        }
        
        while($data=mysqli_fetch_array($query)){
            $id_kar      = $data[0];
            $nama        = $data[1];
            $divisi      = $data[2];
            $jabatan     = $data[3];
            $tipe_kar    = $data[4];
            $email       = $data[7];
            $no_telp     = $data[8];
            $status_kar  = $data[11];
            if($tipeKar == "All"){
                echo "
                <tr>
                    <td>$nama</td>
                    <td>$no_telp</td>
                    <td>$email</td>
                    <td>$divisi</td>
                    <td>$jabatan</td>
                    <td>$status_kar</td>
                    <td>$tipe_kar</td>";
            }else{
                echo "
                <tr>
                    <td>$nama</td>
                    <td>$no_telp</td>
                    <td>$email</td>
                    <td>$divisi</td>
                    <td>$jabatan</td>
                    <td>$status_kar</td>";
            }
                echo "<td>
                        <form action='../karyawan/detail_karyawan.php' method='GET'>
                            <button type='submit' class='btn btn-primary btn-sm' value='$id_kar' name='id_kar'>detail</button>
                        </form>
                    </td>
                </tr>";   
        }
    }