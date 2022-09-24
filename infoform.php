<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "code_info.php" ?>
    <meta charset="UTF-8">
    <title>Thông tin nhân viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Thông tin nhân viên</h1>
                    </div>
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Lương</label>
                        <p class="form-control-static"><?php echo $row["salary"]; ?></p>
                    </div>
                    <p><a href="landing.php" class="btn btn-primary">Trở lại trang chủ</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>