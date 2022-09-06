<?php
require('top.php');
if (isset($_SESSION['ORDER_ID']) && $_SESSION['ORDER_ID'] != '') {
    $order_id = $_SESSION['ORDER_ID'];
    unset($_SESSION['ORDER_ID']);
} else {
?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php
}
?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Thank You</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Error 404 Area Start -->
<div class="error404-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-wrapper text-center ptb-50 pt-xs-20">
                    <div class="error-text m-0">
                        <h2>Thank You For Order</h2>
                        <p>Your Order Id is <?php echo $order_id?>.</p>
                    </div>
                    <div class="error-button">
                        <a class="m-2" href="order.php">Check Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Error 404 Area End -->
<?php
require('footer.php');
?>