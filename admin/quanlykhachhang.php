<?php
    include_once('../assets/database/connect.php');
?>

<?php 
    if(isset($_POST['submit'])){
        $phone = $_GET['sua'];
        $name = $_POST['name'];
        $phonenew = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $purchase = $_POST['purchase'];
        $sql_update_customer = mysqli_query($con, "UPDATE list_customer SET name = '$name', phone = '$phonenew', email = '$email', 
                                                                            address = '$address', purchase = '$purchase' WHERE phone = '$phone'");           
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Admin</title>
</head>
<body>
    <?php
        include_once('./dashboard.php');
    ?>
    <div class="left-customer">
        <form action="" method="POST">
            <label>Tìm khách hàng:</label>
            <input type="search" name="phone" placeholder="Số điện thoại">
            <input type="submit" name="search" value="Tìm kiếm">
        </form>
        <table width="40%" class="admin-table">
            <tr class="row1">
                <th style="width:2%">STT</th>
                <th style="width:12%">Tên</th>
                <th style="width:12%">SĐT</th>
                <th style="width:20%">Email</th>
                <th style="width:25%">Địa chỉ</th>
                <th style="width:10%">Tổng tiền</th>
                <th>Thao tác</th>
            </tr>
            <?php
                if(isset($_POST['search'])){
                    $phone = $_POST['phone'];
                    $sql_customer = mysqli_query($con, "SELECT * FROM list_customer WHERE phone LIKE '%$phone%'"); 
                }
                else{
                    $sql_customer = mysqli_query($con, "SELECT * FROM list_customer");
                }
                $count = 0;
                while($row_customer = mysqli_fetch_array($sql_customer)){
                    $count++;
            ?>
            <tr>
                <td><?php echo $count ?></td>
                <td><?php echo $row_customer['name'] ?></td>
                <td><?php echo $row_customer['phone'] ?></td>
                <td><?php echo $row_customer['email'] ?></td>
                <td><?php echo $row_customer['address'] ?></td>
                <td><?php echo number_format($row_customer['purchase']) ?></td>
                <td>
                    <a class="get_button" href="?xoa=<?php echo $row_customer['phone'] ?>">Xóa</a>
                    <a class="get_button" href="?sua=<?php echo $row_customer['phone'] ?>">Sửa</a>
                </td>
            </tr>
            <?php 
            }
            ?>
            
        </table>
    </div>
    <div class="right-customer">
        <?php
            if(isset($_GET['xoa'])){
                $phone = $_GET['xoa'];
                $sql_customer = mysqli_query($con, "DELETE FROM list_customer WHERE phone = '$phone'"); 
            }
            if(isset($_GET['sua'])){
                $phone = $_GET['sua'];
                $sql_select_customer = mysqli_query($con, "SELECT * FROM list_customer WHERE phone = '$phone'"); 
                while($row_select_customer = mysqli_fetch_array($sql_select_customer)){
        ?>
            <form action="" method="post">
                <label>Tên:</label>
                <input type="text" name="name" value="<?php echo $row_select_customer['name'] ?>" placeholder="Tên">
                <label>SĐT:</label>
                <input type="text" name="phone" value="<?php echo $row_select_customer['phone'] ?>" placeholder="SĐT">
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo $row_select_customer['email'] ?>" placeholder="Email">
                <label>Địa chỉ:</label>
                <input type="text" name="address" value="<?php echo $row_select_customer['address'] ?>" placeholder="Địa chỉ">
                <label>Tổng tiền:</label>
                <input type="text" name="purchase" value="<?php echo $row_select_customer['purchase'] ?>" placeholder="Tổng tiền">
                <input type="submit" name="submit" value="Cập nhật">
            </form>
        <?php
                }
            }
        ?>
    </div>

</body>
</html>