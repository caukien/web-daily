<?php
// Quy trình xóa bản ghi sau khi đã xác nhận
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include file config.php
    require_once "ket_noi.php";
    
    // Chuẩn bị câu lệnh delete
    $sql = "DELETE FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Liên kết các biến với câu lệnh đã chuẩn bị
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Thiết lập tham số
        $param_id = trim($_POST["id"]);
        $param_name = trim($_POST["name"]);
        // Cố gắng thực thi câu lệnh đã chuẩn bị
        if(mysqli_stmt_execute($stmt)){
            // Xóa bản ghi thành công. Chuyển hướng đến trang đích
            header("location: landing.php");
            exit();
        } else{
            echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
        }
    }
     
    // Đóng câu lệnh
    mysqli_stmt_close($stmt);
    
    // Đóng kết nối
    mysqli_close($link);
} else{
    // Kiểm tra sự tồn tại của tham số id
    if(empty(trim($_GET["id"]))){
        // URL không chứa tham số id. Chuyển hướng đén trang error
        header("location: error.php");
        exit();
    }
}
?>