<?php
// Include file config.php
require_once "ket_noi.php";
 
// Xác định các biến và khởi tạo với các giá trị trống
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];
    
    // Xác thực tên
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Nhập tên nhân viên.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Nhập lại tên.";
    } else{
        $name = $input_name;
    }
    
    // Xác thực địa chỉ
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Nhập địa chỉ.";     
    } else{
        $address = $input_address;
    }
    
    // Xác thực lương
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Nhập khoản lương.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Khoảng lương là số nguyên.";
    } else{
        $salary = $input_salary;
    }
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Chuẩn bị câu lệnh Update
        $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Liên kết các biến với câu lệnh đã chuẩn bị
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            
            // Thiết lập tham số
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;
            
            // Cố gắng thực thi câu lệnh đã chuẩn bị
            if(mysqli_stmt_execute($stmt)){
                // Update thành công. Chuyển hướng đến trang đích
                header("location: landing.php");
                exit();
            } else{
                echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
            }
        }
         
        // Đóng câu lệnh
        mysqli_stmt_close($stmt);
    }
    
    // Đóng két nối
    mysqli_close($link);
} else{
    // Kiểm tra sự tồn tại của tham số id trước khi xử lý thêm
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Lấy tham số URL
        $id =  trim($_GET["id"]);
        
        // Chuẩn bị câu lệnh select
        $sql = "SELECT * FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Liên kết các biến với câu lệnh đã chuẩn bị
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Thiết lập tham số
            $param_id = $id;
            
            // Cố gắng thực thi câu lệnh đã chuẩn bị
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Lấy hàng kết quả dưới dạng một mảng kết hợp. Vì tập kết quả chỉ chứa một hàng, chúng ta không cần sử dụng vòng lặp while */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Lấy giá trị trường riêng lẻ
                    $name = $row["name"];
                    $address = $row["address"];
                    $salary = $row["salary"];
                } else{
                    // URL không có id hợp lệ. Chuyển hướng đến trang error
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
    }  else{
        // URL không chứa tham số id. Chuyển hướng đến trang error
        header("location: error.php");
        exit();
    }
}
?>