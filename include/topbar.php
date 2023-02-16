<!---------Header-->

<div id="header">
        <ul id="nav">
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
                <ul class="subnav">
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
                        </a></li>
                    <?php
                        }
                    ?>
                </ul>
            </li>
            <?php
            }
            ?>
            
        </ul>
        <div class="search-btn">
            <i class="search-icon ti-search"></i>
        </div>
        <div class="search-btn">
            <a href="./cart.php"><i class="search-icon ti-shopping-cart"></i></a>
        </div>
    </div>