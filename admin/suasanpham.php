<?php
    include_once('../assets/database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Xử lý sản phẩm</title>
</head>
<body>
    <div class="sua-san-pham">
        <form action="./quanlysanpham.php" method="post">
            <?php 
                if(isset($_GET['chinhsua'])){
                    $id = $_GET['chinhsua'];
                    $sql_product = mysqli_query($con, "SELECT * FROM product WHERE id = '$id'");
                    while($row_product = mysqli_fetch_array($sql_product)){
            ?>
            <label>Tên sản phẩm</label>
            <input type="text" name="title" value="<?php echo $row_product['title'] ?>" placeholder="Tên sản phẩm">
            <label>Danh mục</label> 
            <select id="select-category" name="category">
                <?php
                    $sql_select_category = mysqli_query($con, "SELECT * FROM category"); 
                    while($row_select_category = mysqli_fetch_array($sql_select_category))
                    {
                ?>
                    <option value="<?php echo $row_select_category['id'] ?>"><?php echo $row_select_category['name'] ?></option>
                <?php
                    }
                ?>
            </select>
            
            <label>Danh mục con</label>
            <select class="select-subcategory" name="subcategory_id">
                <?php
                    $sql_select_subcategory = mysqli_query($con, "SELECT * FROM subcategory"); 
                    while($row_select_subcategory = mysqli_fetch_array($sql_select_subcategory))
                    {
                ?>
                    <option value="<?php echo $row_select_subcategory['id'] ?>"><?php echo $row_select_subcategory['name'] ?></option>
                <?php
                    }
                ?>
            </select>
            <label>Giá gốc</label>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="number" name="price_original" value="<?php echo $row_product['price_original'] ?>" placeholder="Giá gốc">
            <label>Giá khuyến mãi</label>
            <input type="number" name="price_discount" value="<?php echo $row_product['price_discount'] ?>" placeholder="Giá khuyến mãi">
            <label>Giới thiệu sản phẩm</label>
            <textarea name="infor" value="<?php echo $row_product['infor'] ?>" placeholder="Giới thiệu sản phẩm..." style="height:50px;width:100%"></textarea>
            <label>Tác giả</label>
            <input type="text" name="author" value="<?php echo $row_product['author'] ?>" placeholder="Tác giả">
            <label>NXB</label>
            <input type="text" name="publisher" value="<?php echo $row_product['publisher'] ?>" placeholder="NXB">
            <label>Số trang</label>
            <input type="number" name="print_length" value="<?php echo $row_product['print_length'] ?>" placeholder="Số trang">
            <label>Ảnh</label>
            <input type="file" value="<?php echo $row_product['image'] ?>" name="image">
            <label>Số lượng trong kho</label>
            <input type="text" name="amount" value="<?php echo $row_product['amount'] ?>" placeholder="Số lượng trong kho">
            <label>Mô tả sản phẩm</label>
            <textarea name="description" value="<?php echo $row_product['description'] ?>" placeholder="Mô tả sản phẩm..." style="height:100px;width:100%"></textarea>
            <?php
                }
            }
            ?>
            <input type="submit" name="submit_modify" value="Submit">
        </form>
    </div>   
</body>
</html>