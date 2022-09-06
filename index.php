<?php
require('top.php');
$categories = mysqli_query($con, "select * from category where cat_status = 1");
$newProducts = mysqli_query($con, "select product.*, category.cat_name from product,category where p_status = 1 and category.cat_id = product.p_fk_cat and product.p_qty > 0 order by added_on desc limit 4");
$category_Products = mysqli_query($con, "select * from category where cat_status = 1");
?>
<!-- Begin Slider With Banner Area -->
<div class="slider-with-banner">
    <div class="container">
        <div class="row">
            <!-- Begin Slider Area -->
            <div class="col-lg-12 col-md-12">
                <div class="slider-area">
                    <div class="slider-active owl-carousel">
                        <!-- Begin Single Slide Area -->
                        <div class="single-slide align-center-left  animation-style-01 bg-1">
                            <div class="slider-progress"></div>
                        </div>
                        <!-- Single Slide Area End Here -->
                        <!-- Begin Single Slide Area -->
                        <div class="single-slide align-center-left animation-style-02 bg-2">
                            <div class="slider-progress"></div>
                        </div>
                        <!-- Single Slide Area End Here -->
                        <!-- Begin Single Slide Area -->
                        <div class="single-slide align-center-left animation-style-01 bg-3">
                            <div class="slider-progress"></div>
                        </div>
                        <!-- Single Slide Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Slider Area End Here -->
            <!-- Begin Li Banner Area -->
            <!-- Li Banner Area End Here -->
        </div>
    </div>
</div>
<!-- Slider With Banner Area End Here -->
<!-- Begin Product Area -->
<div class="product-area pt-60 pb-45">
    <div class="container">
        <div class="col-12 mb-60">
            <div class="li-section-title">
                <h2>
                    <span>Categories</span>
                </h2>
            </div>
        </div>
        <div class="row px-3 pb-3" style="display: flex;justify-content:center;">
            <?php
            if (mysqli_num_rows($categories) > 0) {
                while ($category = mysqli_fetch_assoc($categories)) {
                    $product_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from product where p_fk_cat = '$category[cat_id]'"));
            ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1"><a class="text-decoration-none" href="shop.php?category=<?php echo $category['cat_id'] ?>">
                            <div style="box-shadow: 0px 0px 10px #dbe7eb;border-radius: 11px;" class="cat-item d-flex align-items-center mb-4">
                                <div class="overflow-hidden" style="width:100px;"><img class="img-fluid" style="border-radius: 10px 0px 0px 10px;height: 82px;object-fit: cover;width: 168px;" src="<?php echo IMAGE_SITE_PATH . $category['cat_image'] ?>" alt="website template image"></div>
                                <div class="flex-fill pl-3" style="width: 166px;">
                                    <h6><?php echo $category['cat_name'] ?></h6>
                                    <small class="text-body"><?php echo $product_count['count'] ?> Products</small>
                                </div>
                            </div>
                        </a></div>
            <?php
                }
            } else {
                echo "<div class='col-lg-12 col-md-12 col-sm-12' style='text-align: center;font-size: 15px;'>No Categories Found</div>";
            }
            ?>
        </div>
        <div id="newProductSection"></div>
        <br>
        <br>
        <div class="col-12 mb-10">
            <div class="li-section-title">
                <h2>
                    <span>New Products</span>
                    <span><a style="border: 1px solid lightblue;padding: 5px 10px;font-size: 15px;" href="shop.php">View All</a></span>
                </h2>
            </div>
        </div>
        <div>
            <div class="container p-3">
                <div class="row">
                    <?php
                    if (mysqli_num_rows($newProducts) > 0) {
                        while ($newProduct = mysqli_fetch_assoc($newProducts)) {
                    ?>
                            <div class="col-lg-3">
                                <!-- single-product-wrap start -->
                                <div class="single-product-wrap">
                                    <div style="display: flex;justify-content: center;" class="product-image">
                                        <a href="product.php?id=<?php echo $newProduct['p_id'] ?>">
                                            <img style="width: 270px;height: 135px;object-fit: cover;border-radius: 8px;" src="<?php echo IMAGE_SITE_PATH . $newProduct['p_image'] ?>" alt="Image">
                                        </a>
                                        <span class="sticker">New</span>
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    <a href="shop-left-sidebar.html"><?php echo $newProduct['cat_name'] ?></a>
                                                </h5>
                                            </div>
                                            <h4><a class="product_name" href="product.php?id=<?php echo $newProduct['p_id'] ?>"><?php echo $newProduct['p_name'] ?></a></h4>
                                            <div class="price-box">
                                                <span class="new-price">Rs <?php echo $newProduct['p_price'] ?></span>
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <form method="POST">
                                                <input type="hidden" name="p_id" value="<?php echo $newProduct['p_id'] ?>">
                                                <input type="hidden" name="qty" value="1">
                                                <button name="addToCart" style="width: 100%;padding: 7px 0px;border: 1px solid lavender;font-size: 12px;border-radius: 3px;cursor: pointer;" class="addToCartBtn" type="submit">ADD TO CART</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- single-product-wrap end -->
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='col-lg-12 col-md-12 col-sm-12' style='text-align: center;font-size: 15px;'>No Products Found</div>";
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End Here -->
<!-- Begin Li's Laptop Product Area -->
<?php
if (mysqli_num_rows($category_Products) > 0) {
    while ($categoryProduct = mysqli_fetch_assoc($category_Products)) {
?>
        <div class="product-area pt-60 pb-45">
            <div class="container">
                <div class="col-12 mb-10">
                    <div class="li-section-title">
                        <h2>
                            <span><?php echo $categoryProduct['cat_name'] ?></span>
                            <span><a style="border: 1px solid lightblue;padding: 5px 10px;font-size: 15px;" href="shop.php?category=<?php echo $categoryProduct['cat_id'] ?>">View All</a></span>
                        </h2>
                    </div>
                </div>
                <div>
                    <div class="container p-3">
                        <div class="row">
                            <?php
                            $products = mysqli_query($con, "select product.*, category.cat_name from product,category where p_status = 1 and product.p_fk_cat = $categoryProduct[cat_id] and category.cat_id = product.p_fk_cat and product.p_qty > 0 order by added_on desc limit 4");
                            if (mysqli_num_rows($products) > 0) {
                                while ($product = mysqli_fetch_assoc($products)) {
                            ?>
                                    <div class="col-lg-3">
                                        <!-- single-product-wrap start -->
                                        <div class="single-product-wrap">
                                            <div style="display: flex;justify-content: center;" class="product-image">
                                                <a href="product.php?id=<?php echo $product['p_id'] ?>">
                                                    <img style="width: 270px;height: 135px;object-fit: cover;border-radius: 8px;" src="<?php echo IMAGE_SITE_PATH . $product['p_image'] ?>" alt="Image">
                                                </a>
                                            </div>
                                            <div class="product_desc">
                                                <div class="product_desc_info">
                                                    <div class="product-review">
                                                        <h5 class="manufacturer">
                                                            <a href="shop.php?category=<?php echo $product['p_fk_cat'] ?>"><?php echo $product['cat_name'] ?></a>
                                                        </h5>
                                                    </div>
                                                    <h4><a class="product_name" href="product.php?id=<?php echo $product['p_id'] ?>"><?php echo $product['p_name'] ?></a></h4>
                                                    <div class="price-box">
                                                        <span class="new-price">Rs <?php echo $product['p_price'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="add-actions">
                                                    <form method="POST">
                                                        <input type="hidden" name="p_id" value="<?php echo $product['p_id'] ?>">
                                                        <input type="hidden" name="qty" value="1">
                                                        <button name="addToCart" style="width: 100%;padding: 7px 0px;border: 1px solid lavender;font-size: 12px;border-radius: 3px;cursor: pointer;" class="addToCartBtn" type="submit">ADD TO CART</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single-product-wrap end -->
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<div class='col-lg-12 col-md-12 col-sm-12' style='text-align: center;font-size: 15px;'>No Products Found</div>";
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php }
} ?>
<!-- Li's Trendding Products Area End Here -->
<?php
require('footer.php');
?>