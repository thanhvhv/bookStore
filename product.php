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
    <title>Product</title>
</head>
<body>
    <!---------Header-->
    <?php
    include_once('./include/topbar.php');
    ?>

    <?php 
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else{
            $id = '';
        }
        $sql_product = mysqli_query($con, "SELECT * FROM product WHERE ID = '$id'");
    ?>
    <?php 
        if(isset($_POST['addCart'])){
            $name_product = $_POST['name_product'];
            $id_product = $_POST['id_product'];
            $image = $_POST['image'];
            $price = $_POST['price'];
            $amount = $_POST['amount'];
            $sql_select_cart = mysqli_query($con, "SELECT * FROM CART WHERE id_product = '$id_product'");
            $count = mysqli_num_rows($sql_select_cart);
            if($count > 0){
              $row_productAdded = mysqli_fetch_array($sql_select_cart);
              $amount = $row_productAdded['amount'] + 1;
              $sql_cart = mysqli_query($con, "UPDATE cart SET amount = '$amount' WHERE id_product = '$id_product'");
            }
            else{
              $sql_cart = mysqli_query($con, "INSERT INTO cart (name_product, id_product, image, price, amount) values (
                '$name_product','$id_product','$image','$price','$amount')");
            }
            
        }
    ?>

    <?php 
    while($row_product = mysqli_fetch_array($sql_product))
    {
    ?>
    <!---------Product-->
    <div id="product">  
        <h1 class="category-title-text">Book Store</h1>
        <div class="img-product">
            <img src="<?php echo $row_product['image'] ?>" alt="">
        </div>

        <div class="info-product">
            <h1><?php echo $row_product['title'] ?></h1>
            <p style="opacity: 0.7;">Đã bán: <?php echo $row_product['sold'] ?></p>
            <p><?php echo $row_product['infor'] ?></p>
            <h2 ><?php echo $row_product['price_discount'] ?><sup>đ</sup></h2>
            <p style="opacity: 0.7; margin-top:-10px;" class="price_original_product"><?php echo $row_product['price_original'] ?><sup>đ</sup></p>
            <form method="post">
              <input type="hidden" name="name_product" value="<?php echo $row_product['title']?>">
              <input type="hidden" name="id_product" value="<?php echo $row_product['id']?>">
              <input type="hidden" name="image" value="<?php echo $row_product['image']?>">
              <input type="hidden" name="price" value="<?php echo $row_product['price_discount']?>">
              <input type="hidden" name="amount" value="1">
              <input name="addCart" type="hidden">
                <button class="get_button" onclick="myFunction()">
                  <i class="ti-shopping-cart">
                      <span>Thêm vào giỏ hàng</span>
                  </i>
                </button>
            <p id="demo"></p>
            </form>
            <div class="card">
            <h4 style="margin: 20px 0 10px 0;"><b>CHÚNG TÔI</b> CAM KẾT</h4>
            <div class="commit"><p><i class='ti-truck'></i>Giao hàng toàn quốc</p></div>
            <div class="commit"><p><i class='ti-money'></i>Giá cả cạnh tranh</p></div>
            <div class="commit"><p><i class='ti-gift'></i> Khuyến mại hấp dẫn</p></div>
            <div class="commit"><p><i class='ti-check-box'></i>Hoàn tiền 200% nếu phát hiện hàng giả</p></div>
            </div>
        </div>

        <script>
          function myFunction() {
            document.getElementById("demo").innerHTML = "Hello World";
          }
        </script>

        <div class="infor-detail-product">
            <h1>Thông tin sản phẩm</h1>
            <table class="infor-detail-table">
                <tr>
                  <td>Tên sản phẩm</td>
                  <td><?php echo $row_product['title'] ?></td>
                </tr>
                <tr>
                  <td>Tác giả</td>
                  <td><?php echo $row_product['author'] ?></td>
                </tr>
                <tr>
                  <td>NXB</td>
                  <td><?php echo $row_product['publisher'] ?></td>
                </tr>
                <tr>
                  <td>Số trang</td>
                  <td><?php echo $row_product['print_length'] ?></td>
                </tr>
              </table>
              <p class="line"></p>
              <h2><?php echo $row_product['title'] ?></h2>
              <p> 
              <?php echo $row_product['infor'] ?>

              </p>
        </div>
    </div>

    <?php
    }
    ?>

     <?php
    include_once('./include/footer.php');
    ?>
   
  
</body>
</html>