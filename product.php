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
            <p style="opacity: 0.7;">???? b??n: <?php echo $row_product['sold'] ?></p>
            <p><?php echo $row_product['infor'] ?></p>
            <h2 ><?php echo $row_product['price_discount'] ?><sup>??</sup></h2>
            <p style="opacity: 0.7; margin-top:-10px;" class="price_original_product"><?php echo $row_product['price_original'] ?><sup>??</sup></p>
            <form method="post">
              <input type="hidden" name="name_product" value="<?php echo $row_product['title']?>">
              <input type="hidden" name="id_product" value="<?php echo $row_product['id']?>">
              <input type="hidden" name="image" value="<?php echo $row_product['image']?>">
              <input type="hidden" name="price" value="<?php echo $row_product['price_discount']?>">
              <input type="hidden" name="amount" value="1">
              <input name="addCart" type="hidden">
                <button class="get_button" onclick="myFunction()">
                  <i class="ti-shopping-cart">
                      <span>Th??m v??o gi??? h??ng</span>
                  </i>
                </button>
            <p id="demo"></p>
            </form>
            <div class="card">
            <h4 style="margin: 20px 0 10px 0;"><b>CH??NG T??I</b> CAM K???T</h4>
            <div class="commit"><p><i class='ti-truck'></i>Giao h??ng to??n qu???c</p></div>
            <div class="commit"><p><i class='ti-money'></i>Gi?? c??? c???nh tranh</p></div>
            <div class="commit"><p><i class='ti-gift'></i> Khuy???n m???i h???p d???n</p></div>
            <div class="commit"><p><i class='ti-check-box'></i>Ho??n ti???n 200% n???u ph??t hi???n h??ng gi???</p></div>
            </div>
        </div>

        <script>
          function myFunction() {
            document.getElementById("demo").innerHTML = "Hello World";
          }
        </script>

        <div class="infor-detail-product">
            <h1>Th??ng tin s???n ph???m</h1>
            <table class="infor-detail-table">
                <tr>
                  <td>T??n s???n ph???m</td>
                  <td><?php echo $row_product['title'] ?></td>
                </tr>
                <tr>
                  <td>T??c gi???</td>
                  <td><?php echo $row_product['author'] ?></td>
                </tr>
                <tr>
                  <td>NXB</td>
                  <td><?php echo $row_product['publisher'] ?></td>
                </tr>
                <tr>
                  <td>S??? trang</td>
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