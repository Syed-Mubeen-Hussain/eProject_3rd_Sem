<?php
require('top.php');
$product = '';
$related_products = '';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($con, $_GET['id']);
    $comments = mysqli_query($con, "select * from product_comment where pc_fk_product_id = '$id' order by pc_id desc");
    $product_sql = mysqli_query($con, "select product.*,category.cat_name from product,category where product.p_id = '$id' and product.p_status = 1 and product.p_fk_cat = category.cat_id and product.p_qty > 0");
    if (mysqli_num_rows($product_sql) > 0) {
        $product = mysqli_fetch_assoc($product_sql);
        $related_products = mysqli_query($con, "select product.*,category.cat_name from product,category where product.p_fk_cat = category.cat_id and category.cat_id = $product[p_fk_cat] and  product.p_id != '$id' and product.p_status = 1 and product.p_qty > 0 limit 4");
    } else {
?>
        <script>
            window.location.href = 'shop.php';
        </script>
    <?php
    }
} else {
    ?>
    <script>
        window.location.href = 'shop.php';
    </script>
    <?php
}

if (isset($_POST['comment_submit'])) {
    if (isset($_SESSION['USER_ID']) && $_SESSION['USER_ID'] != '') {
        $message = get_safe_value($con, $_POST['comment_msg']);
        $added_on = date('y-m-d h:i:s tt');
        $res = mysqli_query($con, "INSERT INTO product_comment(pc_msg,pc_fk_customer_id,pc_fk_product_id,pc_added_on) values ('$message','$_SESSION[USER_ID]','$id','$added_on')");
        if ($res) {
    ?>
            <script>
                window.location.href = window.location.href;
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            window.location.href = 'login.php';
        </script>
        <?php
    }
}
?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Product</li>
                <li class="active"><?php echo $product['p_id'] ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- content-wraper start -->
<div class="content-wraper">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6">
                <!-- Product Details Left -->
                <div class="product-details-left">
                    <div class="product-details-images">
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="<?php echo IMAGE_SITE_PATH . $product['p_image'] ?>" data-gall="myGallery">
                                <img src="<?php echo IMAGE_SITE_PATH . $product['p_image'] ?>" style="height: 522px;object-fit: cover;" alt="product image">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Product Details Left -->
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content pt-60">
                    <div class="product-info">
                        <h2><?php echo $product['p_name'] ?></h2>
                        <span class="product-details-ref">Category: <a href="shop.php?category=<?php echo $product['p_fk_cat'] ?>"><?php echo $product['cat_name'] ?></a></span>
                        <div class="price-box pt-20">
                            <span class="new-price new-price-2">Rs <?php echo $product['p_price'] ?></span>
                        </div>
                        <div class="product-desc m-0">
                            <p>
                                <span>
                                    <?php echo $product['p_description'] ?>.
                                </span>
                            </p>
                        </div>
                        <div class="single-add-to-cart">
                            <form method="POST" style="display: flex;align-items: center;" class="cart-quantity">
                            <input type="hidden" name="p_id" value="<?php echo $product['p_id']?>">
                                <div class="quantity">
                                    <label>Quantity</label>
                                    <select style="height: 47px;" name="qty" id="">
                                        <?php
                                        if ($product['p_qty'] > 0) {
                                            for ($i = 1; $i <= $product['p_qty']; $i++) {
                                                
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        } else {
                                            echo "<option value='0'>0</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button name="addToCart" style="margin-top: 31px;margin-left: 15px;" class="add-to-cart" type="submit">Add to cart</button>
                            </form>
                        </div>
                        <div class="block-reassurance">
                            <ul>
                                <li>
                                    <div class="reassurance-item">
                                        <div class="reassurance-icon">
                                            <i class="fa fa-check-square-o"></i>
                                        </div>
                                        <p>Security Policy (Secure Your Product And Deliver)</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="reassurance-item">
                                        <div class="reassurance-icon">
                                            <i class="fa fa-truck"></i>
                                        </div>
                                        <p>Delivery Policy (Cash On Delivery Available)</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="reassurance-item">
                                        <div class="reassurance-icon">
                                            <i class="fa fa-exchange"></i>
                                        </div>
                                        <p> Return Policy (7 Days Returns)</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wraper end -->
<!-- Begin Product Area -->
<div class="product-area pt-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active"><span>Description</span></a></li>
                    </ul>
                </div>
                <!-- Begin Li's Tab Menu Content Area -->
            </div>
        </div>
        <div id="commentContainer">
            <div>
                <div class="product-description">
                    <span><?php echo $product['p_description'] ?>.</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active"><span>Comments</span></a></li>
                    </ul>
                </div>
                <!-- Begin Li's Tab Menu Content Area -->
            </div>
        </div>
        <div>
            <?php
            if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
            ?>
                <div class="comment-replies mt-4">
                    <div class="d-flex py-2">
                        <img style="width: 50px;height: 50px;object-fit: cover;" class="rounded-circle comment-img" src="<?php echo IMAGE_SITE_PATH . $_SESSION['USER_IMAGE'] ?>">
                        <form method="POST" onsubmit="return commentFormSubmit()" class="flex-grow-1 ms-3" style="width: 100%;">
                            <div class="mb-1" style="display: flex;justify-content: space-between;padding: 0px 13px;">
                                <div><a href="#" class="fw-bold link-dark" style="font-size: 16px;"><?php echo $_SESSION['USER_NAME'] ?></a></div>
                            </div>
                            <div class="form-floating mb-2" style="display: flex;justify-content: space-between;padding: 0px 10px;">
                                <textarea onkeypress="commentType()" name="comment_msg" class="form-control w-100" placeholder="Leave a comment here" id="comment_msg" style="height:7rem;"></textarea>
                            </div>

                            <label style="padding-left: 10px;" for="" id="comment_error" class="error"></label>
                            <div class="review-btn mt-0 mb-10" style="display: flex;justify-content: flex-end;padding-right: 10px;">
                                <button name="comment_submit" class="review-links" style="width: 113px;text-transform: capitalize;    background: #242424;color: #ffffff;height: 40px;font-size: 18px;font-weight: bold;cursor: pointer;border: 0px;" href="javascript:void(0)">Comment</button>
                            </div>
                        </div>
                </div>
        </div>
    <?php } else {
    ?>
        <div class="review-btn mt-20 mb-20">
            <a class="review-links" href="login.php">Write Your Comment</a>
        </div>
    <?php
            } ?>
    <div class="product-reviews p-0 m-0">
        <?php
        if (mysqli_num_rows($comments) > 0) {
            while ($comment = mysqli_fetch_assoc($comments)) {
                $user = mysqli_fetch_assoc(mysqli_query($con, "select * from customer where c_id = '$comment[pc_fk_customer_id]'"));
        ?>
                <div style="margin: 20px 0px;" class="d-flex comment">
                    <img style="width: 50px;height: 50px;object-fit: cover;" class="rounded-circle comment-img" src="<?php echo IMAGE_SITE_PATH . $user['c_image'] ?>">
                    <div style="width: 100%;" class="flex-grow-1 ms-3">
                        <div class="mb-1" style="display: flex;padding: 0px 10px;"><a style="    font-size: 16px;color: black;font-weight: 500;" href="#" class="fw-bold link-dark me-1"><?php echo $user['c_firstname'] . ' ' . $user['c_lastname'] ?></a> <span class="text-muted text-nowrap" style="margin-left: 15px;font-size: 12px;display: flex;align-items: center;"><?php echo $comment['pc_added_on'] ?></div>
                        <div class="mb-2" style="padding: 0px 10px;"><?php echo $comment['pc_msg'] ?>.</div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div>No Comments</div>";
        }
        ?>
    </div>
    </div>
</div>
</div>
<!-- Product Area End Here -->
<!-- Begin Li's Laptop Product Area -->
<section class="product-area li-laptop-product pt-30 pb-50">
    <div class="container">
        <div class="row">
            <!-- Begin Li's Section Area -->
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2>
                        <span>Related Products</span>
                    </h2>
                </div>
                <div class="row">
                    <?php
                    if (mysqli_num_rows($related_products) > 0) {
                        while ($related_product = mysqli_fetch_assoc($related_products)) {
                    ?>
                            <div class="col-lg-3 mt-20">
                                <!-- single-product-wrap start -->
                                <div class="single-product-wrap">
                                    <div style="display: flex;justify-content: center;" class="product-image">
                                        <a href="product.php?id=<?php echo $related_product['p_id'] ?>">
                                            <img style="width: 270px;height: 135px;object-fit: cover;border-radius: 8px;" src="<?php echo IMAGE_SITE_PATH . $related_product['p_image'] ?>" alt="Image">
                                        </a>
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    <a href="shop.php?category=<?php echo $related_product['p_fk_cat'] ?>"><?php echo $related_product['cat_name'] ?></a>
                                                </h5>
                                            </div>
                                            <h4><a class="product_name" href="product.php?id=<?php echo $related_product['p_id'] ?>"><?php echo $related_product['p_name'] ?></a></h4>
                                            <div class="price-box">
                                                <span class="new-price">Rs <?php echo $related_product['p_price'] ?></span>
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <form method="POST">
                                            <input type="hidden" name="p_id" value="<?php echo $related_product['p_id']?>">
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
                    }
                    ?>
                </div>
            </div>
            <!-- Li's Section Area End Here -->
        </div>
    </div>
</section>
<?php
require('footer.php');
?>
<script>
    function commentFormSubmit() {
        let message = document.getElementById('comment_msg').value;
        if (message.trim() == '') {
            document.getElementById("comment_error").innerHTML = "Comment is required";
            return false;
        }
    }
    function commentType(){
        let message = document.getElementById('comment_msg').value;
        if (message.trim() == '') {
            document.getElementById("comment_error").innerHTML = "Comment is required";
        }else{
            document.getElementById("comment_error").innerHTML = "";
        }
    }
</script>