<?php
    $link = mysqli_connect("localhost", "root", "", "nhanvien");
    //kiem tra ket noi
    if($link === false){
        die("Ket noi that bai" . mysqli_connect_error());
    }
    // echo "Ket noi thanh cong. HOST:" . mysqli_get_host_info($link);
    //dong ket noi
    // mysqli_close($link);

    //them
    
?>