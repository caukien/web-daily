<?php
// Kiểm tra sự tồn tại của tham số id trước khi xử lý thêm
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include file config.php
    require_once "ket_noi.php";
    
    // Chuẩn bị câu lệnh Select
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Liên kết các biến với câu lệnh đã chuẩn bị
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Thiết lập tham số
        $param_id = trim($_GET["id"]);
        
        // Cố gắng thực thi câu lệnh đã chuẩn bị
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Lấy hàng kết quả dưới dạng một mảng kết hợp. Vì tập kết quả chỉ chứa một hàng, chúng tôi không cần sử dụng vòng lặp while */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Lấy giá trị trường riêng lẻ
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // URL không chứa tham số id hợp lệ. Chuyển hướng đến trang error
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
        }
    }
     
    // Đóng câu lệnh
    mysqli_stmt_close($stmt);
    
    // Đóng kết nối
    mysqli_close($link);
} else{
    // URL không chứa tham số id. Chuyển hướng đến trang error
    header("location: error.php");
    exit();
}
?>