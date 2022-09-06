<?php
require('top.php');
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    $customer_id = $_SESSION['USER_ID'];
    $cart = mysqli_query($con, "select * from cart where car_fk_cus_id = '$customer_id' order by car_id desc");
} else {
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}

if (isset($_POST['updateQtyBtn'])) {
    $qty = get_safe_value($con, $_POST['updateQty']);
    $product_id = get_safe_value($con, $_POST['id']);
    $product_sql = mysqli_fetch_assoc(mysqli_query($con,"select * from product where p_id = '$product_id'"));
    if($qty > 0){
        if($qty > $product_sql['p_qty']){
            ?>
            <script>
                alert("Product Qty Not Found");
            </script>
            <?php
        }else{
            $res = mysqli_query($con,"update cart set car_product_qty = '$qty' where car_fk_product_id = '$product_id' and car_fk_cus_id = '$customer_id'");
            if($res){
                ?>
                <script>
                    window.location.href = window.location.href;
                </script>
                <?php
            }
        }
    }else{
        ?>
        <script>
            alert("Product Qty Not Found");
        </script>
        <?php   
    }
}

?>
<style>
    #updateQtyBtn {
        border: 0px;
        background: transparent;
        cursor: pointer;
        padding: 0px;
    }

    #updateQtyBtn:hover {
        color: #fed700;
    }
</style>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!--Shopping Cart Area Strat-->
<?php
if (mysqli_num_rows($cart) > 0) {
?>
    <div class="Shopping-cart-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="li-product-remove">remove</th>
                                    <th class="li-product-thumbnail">image</th>
                                    <th class="cart-product-name">Product</th>
                                    <th class="li-product-price">Unit Price</th>
                                    <th class="li-product-quantity">Quantity</th>
                                    <th class="li-product-subtotal">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($c = mysqli_fetch_assoc($cart)) {
                                    $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$c[car_fk_product_id]'"));
                                    $total = 0;
                                    $total += $product['p_price'] * $c['car_product_qty'];
                                ?>
                                    <tr>
                                        <td class="new">
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?php echo $product['p_id'] ?>">
                                                <button style="width: 100%;" class="close" name="removeCartProduct" title="Remove">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="li-product-thumbnail"><a href="product.php?id=<?php echo $product['p_id'] ?>"><img style="width:100px;height: 75px;object-fit: cover;" src="<?php echo IMAGE_SITE_PATH . $product['p_image'] ?>" alt="Image"></a></td>
                                        <td class="li-product-name"><a href="product.php?id=<?php echo $product['p_id'] ?>"><?php echo $product['p_name'] ?></a></td>
                                        <td class="li-product-price"><span class="amount">Rs <?php echo $product['p_price'] ?></span></td>
                                        <td class="quantity" style="width: 50px;">
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?php echo $product['p_id'] ?>">
                                                <select name="updateQty" id="" style="margin-bottom: 8px;">
                                                    <?php
                                                    for ($i = 1; $i <= $product['p_qty']; $i++) {
                                                        if ($c['car_product_qty'] == $i) {
                                                            echo "<option selected value='$i'>$i</option>";
                                                        } else {
                                                            echo "<option value='$i'>$i</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <button id="updateQtyBtn" name="updateQtyBtn">Update</button>
                                            </form>
                                        </td>
                                        <td class="product-subtotal"><span class="amount">Rs <?php echo $total?></span></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <h2>Cart Total</h2>
                                <ul>
                                    <li>Total <span>Rs <?php echo $totalAmount?></span></li>
                                </ul>
                                <a href="checkout.php">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    echo "<div class='Shopping-cart-area pt-60 pb-60'>
            <div class='container'>
                <div class='row'>
                    <div style='text-align: center;font-size: 20px;font-weight: bold;' class='col-12'>
                        No Products In Cart
                    </div>
                </div>
            </div>
        </div>";
}
?>
<!--Shopping Cart Area End-->
<?php
require('footer.php');
?>