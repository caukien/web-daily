<?php
// Include file config.php
require_once "ket_noi.php";
 
// Xác định các biến và khởi tạo các giá trị trống
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Xác thực tên
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Bạn chưa nhập tên.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Tên sai ký tự.";
    } else{
        $name = $input_name;
    }
    
    // Xác thực địa chỉ
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Bạn chưa điền thông tin địa chỉ.";     
    } else{
        $address = $input_address;
    }
    
    // Xác thực lương
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Bạn chưa nhập số lương.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Số lương phải là số thực.";
    } else{
        $salary = $input_salary;
    }
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Chuẩn bị một câu lệnh insert
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Liên kết các biến với câu lệnh đã chuẩn bị
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Thiết lập tham số
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Cố gắng thực thi câu lệnh đã chuẩn bị
            if(mysqli_stmt_execute($stmt)){
                // Tạo bản ghi thành công. Chuyển hướng đến trang đích
                header("location: landing.php");
                exit();
            } else{
                echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
            }
        }
         
        // Đóng câu lệnh
        mysqli_stmt_close($stmt);
    }
    
    // Đóng kết nối
    mysqli_close($link);
}
?>