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
    <script type="text/javascript" src="./assets/js/js.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
    <!---------Header-->
    <?php
    include_once('./include/topbar.php');
    ?>

    <?php
        $sql_cart = mysqli_query($con, "SELECT * FROM cart ORDER BY id DESC");
    ?>

    
    
    <!---------Cart-->
    <div class="container">
        <h1 class="category-title-text">Giỏ hàng</h1>
        <form action="" method="post">
        <div class="cart-content">
            <div class="left-cart">
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                    <?php
                    $count = 0;
                    $count_product = 0;
                    $total = 0;
                    while($row_fetch_cart = mysqli_fetch_array(($sql_cart))){
                        $count++;
                        $count_product += $row_fetch_cart['amount'] ;
                        $total += $row_fetch_cart['price'] * $row_fetch_cart['amount'] ;
                    ?>
                    <tr>
                        <input type="hidden" name="id_product" value="<?php echo $row_fetch_cart['id_product']?>">
                        <td><img src="<?php echo $row_fetch_cart['image'] ?>" alt=""><p><?php echo $row_fetch_cart['name_product'] ?></p></td>
                        <td><?php echo $row_fetch_cart['price'] ?><sup>đ</sup></td>
                        <td><input type="number" name="amount" value="<?php echo $row_fetch_cart['amount'] ?>" min="1"></td>
                        <td><p><?php echo $row_fetch_cart['price']*$row_fetch_cart['amount'] ?> <sup>đ</sup></p></td>
                        <td><input type="hidden" name="x"><button>X</button></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <div class="right-cart">
                <table>
                    <tr>
                        <th colspan="2">Tổng tiền</th>
                    </tr>                    
                    <tr>
                        <td>Tổng sản phẩm</td>
                        <td><?php echo $count_product ?></td>
                    </tr>
                    <tr>
                        <td>Tổng tiền hàng</td>
                        <td><p><?php echo $total ?><sup>đ</sup></p></td>
                    </tr>
                </table>
                <div class="cart-button">
                    <input type="hidden" name="modifyCard"><button>Cập nhật giỏ hàng</button>
                    <a class="blue-button" href="./index.php">Tiếp tục mua sắm</a>
                    <a class="blue-button" href="./delivery.php">Thanh toán</a>
                </div>
            </div>
        </div>
        </form>

        <?php 
        if(isset($_POST['modifyCard'])){
            $id_product = $_POST['id_product'];
            $amount = $_POST['amount'];
            $sql_cart = mysqli_query($con, "UPDATE cart SET amount = '$amount' WHERE id_product = '$id_product'");
            
        }
        ?>
    </div>  
    <?php
    include_once('./include/footer.php');
    ?>
</body>
</html>