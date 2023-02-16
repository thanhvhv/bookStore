<?php
    include_once('../assets/database/connect.php');
?>

<?php
    if(isset($_GET['xoa'])){
        $code = $_GET['xoa'];
        $sql_order = mysqli_query($con, "DELETE FROM list_order WHERE code = '$code'"); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Xử lý đơn hàng</title>
</head>
<body>
<?php
    include_once('./dashboard.php');
    ?>
    <div class="right-order">
        <h3 style="margin-bottom: 10px;">Chi tiết đơn hàng</h3>
        <form action="" method="post">
            <table class="admin-table">
                <tr class="row1">
                    <th style="width:5%">STT</th>
                    <th style="width:15%">Mã hàng</th>
                    <th style="width:35%">Tên SP</th>
                    <th style="width:5%">SL</th>
                    <th style="width:15%">Giá</th>
                    <th>Tổng</th>
                </tr>
                <?php
                    if(isset($_GET['xem'])){
                        $sum = 0;
                        $count2 = 0;
                        $code = $_GET['xem'];
                        $sql_order = mysqli_query($con, "SELECT * FROM orders WHERE code = '$code' ORDER BY id DESC");
                        while($row_order = mysqli_fetch_array($sql_order)){
                            $count2++;
                            $id = $row_order['product_id'];
                            $sql_product = mysqli_query($con, "SELECT * FROM product WHERE id = '$id'");
                            while($row_product = mysqli_fetch_array($sql_product)){
                                $name_product = $row_product['title'];
                                $price_product = $row_product['price_discount'];
                            }
                            $sum += $price_product * $row_order['amount'];
                ?>
                <tr>
                    <td><?php echo $count2 ?></td>
                    <td ><?php echo $row_order['code'] ?></td>
                    <td ><?php echo $name_product ?></td>
                    <td ><?php echo $row_order['amount'] ?></td>
                    <td ><?php echo $price_product ?></td>
                    <td ><?php echo $price_product * $row_order['amount'] ?></td>
                </tr>
                <?php
                }
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php if(isset($sum)) echo "Tổng tiền" ?></td>
                    <td ><?php if(isset($sum)) echo $sum ?></td>
                </tr>       
            </table>
            <h3 style="margin: 20px 0 10px 0;">Người đặt hàng</h3>
            <table class="admin-table">
            <tr class="row1">
                <th style="width:20%">Tên</th>
                <th style="width:12%">SĐT</th>
                <th style="width:20%">Email</th>
                <th style="width:25%">Địa chỉ</th>
            </tr>
            <?php
                if(isset($_GET['xem'])){
                    $code = $_GET['xem'];
                    $sql_select_listorder = mysqli_query($con, "SELECT * FROM list_order WHERE code = '$code'"); 
                    while($row_select_listorder = mysqli_fetch_array($sql_select_listorder)){
                        $customer_id = $row_select_listorder['customer_id'];
                    }
                    $sql_select_customer = mysqli_query($con, "SELECT * FROM customer WHERE id = '$customer_id'");
                        while($row_select_customer = mysqli_fetch_array($sql_select_customer)){
                
                
            ?>
            <tr>
                <td><?php echo $row_select_customer['name'] ?></td>
                <td><?php echo $row_select_customer['phone'] ?></td>
                <td><?php echo $row_select_customer['email'] ?></td>
                <td><?php echo $row_select_customer['address'] ?></td>
            </tr>
            <?php 
            }
            }
            ?>
            </table>
            <?php
            if(isset($_POST['submit'])){
                $status = $_POST['status'];
                $sql_update = mysqli_query($con, "UPDATE list_order SET status = '$status' WHERE code = '$code'");
            }
        ?>
            <?php
            if(isset($code)){
                $count = 0;
            $sql_listorders = mysqli_query($con, "SELECT * FROM list_order WHERE code = '$code'");
            while($row_listorder = mysqli_fetch_array($sql_listorders))
            {
            ?>
                <input type="radio" name="browser" onclick="myFunction(this.value)" value="1" 
                    <?php if($row_listorder['status'] == 1) echo "checked" ?>>Đã xử lý<br>
                <input type="radio" name="browser" onclick="myFunction(this.value)" value="0"
                <?php if($row_listorder['status'] == 0) echo "checked" ?>>Chưa xử lý<br><br>
            <?php
            }
        }
            ?>
            <input type="hidden" name="status" id="result">
            <input type="submit" name="submit" value="Cập nhật">
            <script>
                function myFunction(browser) {
                document.getElementById("result").value = browser;
                }
            </script>
        </form>


    </div>
    <div class="left-order">
        <h3 style="margin-bottom: 10px;">Danh sách đơn hàng</h3>
        <table class="admin-table">
            <tr class="row1">
                <th style="width:5%">STT</th>
                <th style="width:10%">Mã ĐH</th>
                <th style="width:15%">Tình trạng</th>
                <th style="width:15%">Tên KH</th>
                <th style="width:15%">Ngày đặt</th>
                <th style="width:15%">Ghi chú</th>
                <th>Thao tác</th>
            </tr>
            <?php
            $count = 0;
            $sql_listorders = mysqli_query($con, "SELECT * FROM list_order");
            while($row_listorder = mysqli_fetch_array($sql_listorders))
            {
                $name_customer;
                $count++;
                $id = $row_listorder['customer_id'];
                $sql_customer = mysqli_query($con, "SELECT * FROM customer WHERE id = '$id'");
                while($row_customer = mysqli_fetch_array($sql_customer)){
                    $name_customer = $row_customer['name'];
                }
            ?>
            <tr>
                <td><?php echo $count ?></td>
                <td ><?php echo $row_listorder['code'] ?></td>
                <td >
                    <?php 
                        if($row_listorder['status'] == 0){
                            echo "Chưa xử lý";
                        } else {
                            echo "Đã xử lý";
                        }
                    ?>
                </td>
                <td ><?php echo $name_customer ?></td>
                <td ><?php echo $row_listorder['date'] ?></td>
                <td ><?php echo $row_listorder['note'] ?></td>
                <td><a class="get_button" href="?xoa=<?php echo $row_listorder['code'] ?>">Xóa</a> 
                    <a class="get_button" href="?xem=<?php echo $row_listorder['code'] ?>">Xem</a></td>
            </tr>
            <?php
            }
            ?>    
        </table>
    </div>
<body>
    
</body>
</html>