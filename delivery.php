<?php
    include_once('./assets/database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/fonts/themify-icons/themify-icons.css">
    <script src="./assets/js/js.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
    <!---------Header-->
    <?php
    include_once('./include/topbar.php');
    ?>

    <?php 
        if(isset($_POST['checkout'])){
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $note = $_POST['note'];
            $delivery = $_POST['delivery'];
            $sql_customer = mysqli_query($con, "INSERT INTO customer (name, phone, email, address) values (
                '$name','$phone','$email','$address')");
            if($sql_customer){
                $sql_code = mysqli_query($con, "SELECT code FROM orders");
                while(1){
                    $temp = 0;
                    $code = rand(0,999999);
                    while($sql_select_code = mysqli_fetch_array($sql_code)){
                        if($sql_select_code['code'] == $code){
                            $temp = 1;
                            break;
                        }
                    }
                    if($temp == 0) break;
                }
                $sql_select_customer = mysqli_query($con, "SELECT * FROM customer ORDER BY id DESC LIMIT 1");

                $row_customer = mysqli_fetch_array($sql_select_customer);
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $date = date("Y-m-d G:i:s");
                $customer_id = $row_customer['id'];
                $sql_listorder = mysqli_query($con, "INSERT INTO list_order (code, date, customer_id, note, delivery) 
                                    values ('$code','$date','$customer_id','$note','$delivery')");
                $sql_cart = mysqli_query($con, "SELECT * FROM cart ORDER BY id DESC");
                $sum = 0;
                while($row_fetch_cart = mysqli_fetch_array(($sql_cart))){
                    $product_id = $row_fetch_cart['id_product'];
                    $amount = $row_fetch_cart['amount'];
                    $sql_product = mysqli_query($con, "SELECT * FROM product WHERE id = '$product_id'");
                    while($row_product = mysqli_fetch_array($sql_product)){
                        $sum += $amount * $row_product['price_discount'];
                    }
                    $sql_order = mysqli_query($con, "INSERT INTO orders (code, product_id, amount) values ('$code','$product_id','$amount')");
                }
            }
            $temp = 0;
            $sql_listcustomer = mysqli_query($con, "SELECT * FROM list_customer WHERE phone = '$phone'");
            while($row_listcustomer = mysqli_fetch_array($sql_listcustomer)){
                if(isset($row_listcustomer)){
                    $temp = 1;
                    $sum = $row_listcustomer['purchase'] + $sum;
                    $sql_select_listcustomer = mysqli_query($con, "UPDATE list_customer SET name = '$name', email = '$email', 
                                    address = '$address', purchase = '$sum'");
                }
            }
            if($temp == 0){
                $sql_select_listcustomer = mysqli_query($con, "INSERT INTO list_customer (phone, name, email, address, purchase) values 
                ('$phone','$name','$email','$address','$sum')");
            }    
            
        }
    ?>

    
    <!---------Cart-->
    <div class="container">
        <div class="delivery">
            <div class="info-address">
                <h1>Thông tin giao hàng</h1>
                <form action="#" method="post">
                    <table>
                        <tr>
                            <td>Họ tên:</td>
                            <td><input type="text" name="name"></td>
                        </tr>
                        <tr>
                            <td>SĐT:</td>
                            <td><input type="text" name="phone"></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" name="email"></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td><input type="text" name="address"></td>
                        </tr>
                        <tr>
                            <td>Ghi chú:</td>
                            <td><input type="text" name="note"></td>
                        </tr>
                        <tr>
                            <td>Hình thức trả tiền:</td>
                            <td>
                            <select name="delivery">
                                <option value="0">Thanh toán khi nhận hàng</option>
                                <option value="1">Chuyển khoản trước</option>
                            </select>
                            </td>
                            
                        </tr>
                    </table>
                <div class="delivery-button">
                    <input type="submit" name="checkout" value="Đặt Hàng">
                </div>
                </form>
            </div>
            <div class="list-items-buy">
                <h1>Thông tin đơn hàng</h1>
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                    <?php
                    $count = 0;
                    $count_product = 0;
                    $total = 0;
                    $sql_cart = mysqli_query($con, "SELECT * FROM cart ORDER BY id DESC");
                    while($row_fetch_cart = mysqli_fetch_array(($sql_cart))){
                        $count++;
                        $count_product += $row_fetch_cart['amount'] ;
                        $total += $row_fetch_cart['price'] * $row_fetch_cart['amount'] ;
                    ?>
                    <tr>
                        <input type="hidden" name="id_product" value="<?php echo $row_fetch_cart['id_product']?>">
                        <td><img src="<?php echo $row_fetch_cart['image'] ?>" alt=""><p><?php echo $row_fetch_cart['name_product'] ?></p></td>
                        <td><?php echo $row_fetch_cart['price'] ?><sup>đ</sup></td>
                        <td><?php echo $row_fetch_cart['amount'] ?></td>
                        <td><p><?php echo $row_fetch_cart['price']*$row_fetch_cart['amount'] ?> <sup>đ</sup></p></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <th>Tổng tiền</th>
                        <th></th>
                        <th></th>
                        <th><p><?php echo $total ?><sup>đ</sup></p></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>   

    <?php
    include_once('./include/footer.php');
    ?>
</body>
</html>