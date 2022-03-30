<?php
    function tampilTabelKaryawan($konek, $tipeKar){
        $query = mysqli_query($konek, "SELECT * FROM karyawan".$tipeKar);
        while($data=mysqli_fetch_array($query)){
            $id_kar      = $data[0];
            $nama        = $data[1];
            $divisi      = $data[2];
            $jabatan     = $data[3];
            $email       = $data[7];
            $no_telp     = $data[8];
            $status_kar  = $data[11];
            echo "<tr>
                <td>$nama</td>
<td>$divisi</td>
<td>$jabatan</td>
<td>$no_telp</td>
<td>$email</td>
<td>$status_kar</td>
<td>
    <form action='#' method='GET'>
        <input type='hidden' value='$id_kar' name='id_kar'>
        <button type='submit' class='btn btn-primary'>detail</button>
    </form>
</td>
</tr>";
        }
    }