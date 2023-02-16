<!---------Main-->
<div id="category">
        <div class="category-left">
            <h1 class="category-title-text">Danh mục</h1>
            <ul class="category-list">  
                <?php
                    $sql_category = mysqli_query($con, 'SELECT * FROM category ORDER BY id ASC'); 
                    while($row_category = mysqli_fetch_array($sql_category))
                    {
                ?> 
                <li>
                    <a href="index.php?quanly=danhmuc&id=<?php echo $row_category['id'] ?>">
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
                            <li><a href="index.php?quanly=danhmuccon&id=<?php echo $row_subCategory['id'] ?>">
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
            <div class="category-title">
            <?php
                $count = 0;
                $id_category = 0;
                $id_subcategory = 0;
                $quanly = 0; 
                $id = 0;
                if(isset($_GET['quanly'])){
                    $quanly = $_GET['quanly'];
                    $id = $_GET['id'];
                }
                if($quanly == 'danhmuc'){
                    $id_category  = $id;
                }
                else{
                    $id_subcategory  = $id;
                } 

                $arr_subcategory = array();

                if($id_category > 0){
                    $sql_subcategory = mysqli_query($con, "SELECT * FROM subCategory WHERE category_id = '$id_category'");
                    $sql_titlecategory = mysqli_query($con, "SELECT * FROM category WHERE id = '$id_category'");
                    while($row_titlecategory = mysqli_fetch_array($sql_titlecategory))
                    {   
                        $list = $row_titlecategory['name'];
                    }
                }
                else if($id_subcategory > 0){
                    $sql_subcategory = mysqli_query($con, "SELECT * FROM subCategory WHERE id = '$id_subcategory'");
                    $sql_titlecategory = mysqli_query($con, "SELECT category.* FROM category, subCategory 
                                                        WHERE category.id = category_id AND subCategory.id = '$id_subcategory'");
                    while($row_titlecategory = mysqli_fetch_array($sql_titlecategory))
                    {   
                        $list = $row_titlecategory['name'];
                        $list .= "\t\\\t";
                    }
                    $sql_titleSubCategory = mysqli_query($con, "SELECT * FROM subCategory WHERE id = '$id_subcategory'");
                    while($row_titleSubCategory = mysqli_fetch_array($sql_titleSubCategory))
                    {   
                        $list .= $row_titleSubCategory['name'];
                    }
                } 
                else{
                    $sql_subcategory = mysqli_query($con, "SELECT * FROM subCategory");
                    $list = 'Tất cả danh mục';
                }
                ?>
                <h1 class="category-title-text"><?php echo $list ?></h1>
            </div>
            <div class="category-right-filter">
                <form action="" method="post">
                    <input class="get_button" type="submit" name="top_seller" value="Bán chạy">
                    <input class="get_button" type="submit" name="newest" value="Mới nhất">
                    <input class="get_button" type="submit" name="price_desc" value="Giá cao nhất">
                    <input class="get_button" type="submit" name="price_asc" value="Giá thấp nhất">
                </form>
            </div>

            <div class="line-border"></div>
            <div class="category-right-content">
            <?php
                while($row_subcategory = mysqli_fetch_array($sql_subcategory))
                {   
                    $id_subcategory = $row_subcategory['id'];
                    array_push($arr_subcategory, $id_subcategory);
                }

                if(isset($_POST['top_seller'])){
                    $sql_product = mysqli_query($con, "SELECT * FROM product ORDER BY sold DESC");
                }
                else if(isset($_POST['newest'])){
                    $sql_product = mysqli_query($con, "SELECT * FROM product ORDER BY id DESC");
                }
                else if(isset($_POST['price_desc'])){
                    $sql_product = mysqli_query($con, "SELECT * FROM product ORDER BY price_discount DESC");
                }
                else if(isset($_POST['price_asc'])){
                    $sql_product = mysqli_query($con, "SELECT * FROM product ORDER BY price_discount ASC");
                }
                else{ 
                    $sql_product = mysqli_query($con, "SELECT * FROM product ORDER BY id DESC");
                }
                while($row_product = mysqli_fetch_array($sql_product))
                {
                    if(in_array($row_product['subCategory_id'], $arr_subcategory)){
                    $count++;
                ?>
                <div class="category-right-content-item">
                    <a href="product.php?id=<?php echo $row_product['id'] ?>">
                        <img src="<?php echo $row_product['image'] ?>" alt="" >
                        <h1><?php echo $row_product['title'] ?></h1>
                    </a>
                    <p class="price_discount"><?php echo $row_product['price_discount'] ?><sup>đ</sup></p>
                    <p style="opacity: 0.8;" class="price_original"><?php echo $row_product['price_original'] ?><sup>đ</sup></p>
                </div>
                <?php 
                    }
                }
                ?>
            </div>
        </div>

    </div>