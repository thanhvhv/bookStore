<?php
    session_start();
    include_once('../assets/database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Đăng nhập Admin</title>
</head>
<body>
    <div class="login">
        <h2>Đăng nhập</h2>
        <form action="" method="post">
            <label for="">Tài khoản</label>
            <input type="text" name="account" placeholder="Tên đăng nhập">
            <label for="">Mật khẩu</label>
            <input type="password" name="pass" placeholder="Mật khẩu">
            <input type="submit" name="login" value="Đăng nhập">
        </form>
    </div>
    <?php 
    if(isset($_POST['login'])){
        $account = $_POST['account'];
        $pass = $_POST['pass'];
        if($account == '' || $pass == ''){
            echo "Nhập đủ tài khoản và mật khẩu!";
        } else{
            $sql_select_admin = mysqli_query($con, "SELECT * FROM admin WHERE account = '$account' AND password = '$pass' LIMIT 1");
            $count = mysqli_num_rows($sql_select_admin);
            $row_login = mysqli_fetch_array($sql_select_admin);
            if($count > 0){
                $_SESSION ['login'] = $row_login['admin_name'];
                $_SESSION ['admin_id'] = $row_login['id'];
                header('Location: quanlysanpham.php');
            } else{
                echo "Sai tài khoản hoặc mật khẩu!";
            }
        }
    }
?>
    
</body>
</html>