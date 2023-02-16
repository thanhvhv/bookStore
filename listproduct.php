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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
</head>
<body>

    <?php
    include_once('./include/topbar.php');
    ?>

    <!---------Main-->
    <div id="category">
        <div class="category-left">
            <ul class="category-list">  
                <?php
                    $sql_category = mysqli_query($con, 'SELECT * FROM category ORDER BY id ASC'); 
                    while($row_category = mysqli_fetch_array($sql_category))
                    {
                ?> 
                <li>
                    <a href="">
                        <?php echo $row_category['name'] ?>
                        <i class="down-btn ti-angle-down"></i>
                    </a>
                    <ul class="sub-category">
                        <?php
                            $sqlsubCategory = mysqli_query($con, 'SELECT * FROM subCategory ORDER BY id ASC'); 
                            while($row_subCategory = mysqli_fetch_array($sqlsubCategory))
                            {
                                if ($row_subCategory['category_id'] == $row_category['id'])
                                { 
                        ?>
                            <li><a href="listproduct.php?quanly=danhmuc&id=<?php echo $row_subCategory['id'] ?>">
                                <?php echo $row_subCategory['name']; ?>
                            </a></li>


                            <?php
                                }
                            ?>
                            <?php
                            }
                        ?>
                    </ul>
                </li>
                <?php
                    }
                ?>
            </ul>
        </div>

        <div class="category-right">
            <div class="category-right-title">
                <h1>Danh mục sản phẩm</h1>
            </div>
            <div class="category-right-filter">
                <select name="" id="">
                    <option value="">Săp xếp</option>
                    <option value="">Bán chạy</option>
                    <option value="">Giá cao nhất</option>
                    <option value="">Giá thấp nhất</option>
                    <option value="">Mới nhất</option>
                </select>
            </div>

            <div class="line-border"></div>
            <div class="category-right-content">
                <?php 
                if(isset($_GET['id'])){
                    $id  = $_GET['id'];
                }
                else{
                    $id = '';
                }
                $sql_product = mysqli_query($con, "SELECT product.* FROM product, subCategory WHERE product.subCategory_id = subCategory.id
                AND product.subCategory_id = '$id' ORDER BY product.id DESC");
                while($row_product = mysqli_fetch_array($sql_product))
                {
                ?>

                <div class="category-right-content-item">
                    <img src="<?php echo $row_product['image'] ?>" alt="" >
                    <a href="product.php?id=<?php echo $row_product['id'] ?>">
                    <h1><?php echo $row_product['title'] ?></h1>
                    </a>
                    <p class="price_discount"><?php echo $row_product['price_discount'] ?><sup>đ</sup></p>
                    <p class="price_original"><?php echo $row_product['price_original'] ?><sup>đ</sup></p>
                </div>

                <?php 
                }
                ?>
            </div>
            
            <div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#">1</a>
                <a href="#" class="active">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
              </div>
        </div>

    </div>

    <?php
    include_once('./include/footer.php');
    ?>

</body>
</html>