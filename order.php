<?php
require('top.php');
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    $order_id_show = '';
    $customer_id = $_SESSION['USER_ID'];
    $orders = mysqli_query($con, "select * from orders where o_fk_cus_id = '$customer_id' and o_status != 'Cancel' order by added_on desc");
} else {
?>
    <script>
        window.location.href = 'login.php';
    </script>
    <?php
}


// cancel order 
if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "status") {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        if ($operation == "cancel_order") {
            $status = 'Cancel';
        }
        $check_order_cancel = mysqli_query($con, "select * from orders where o_id = '$id' and o_status != 'Cancel' and o_fk_cus_id = '$customer_id'");
        if (mysqli_num_rows($check_order_cancel) > 0) {
            $update_sql = "update orders set o_status = '$status' where o_id = '$id' and o_fk_cus_id = '$customer_id'";
            $run = mysqli_query($con, $update_sql);
            if ($run) {
                $added_on = date('y-m-d h:i:s');
                $order_sql = mysqli_fetch_assoc($check_order_cancel);
                $message = "Your Order Has Been $status Order Id #" . $order_sql['order_id_show'] . " ";
                mysqli_query($con, "INSERT INTO notifications(n_text,n_fk_customer_id,added_on) values('$message','$customer_id','$added_on')");
    ?>
                <script>
                    swal({
                            title: "Order Has Been Cancelled Successfully!",
                            icon: "success",
                            button: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                window.location.href = 'order.php';
                            } else {
                                window.location.href = 'order.php';
                            }
                        });
                </script>
<?php
            }
        }
    }
}
?>
<style>
    #main_div {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 500px;
    }

    #main_div #title {
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: 500;
    }

    .list-group {
        border-color: #D0D5DC !important;
    }

    .list-group .list-group-item {
        border-color: #D0D5DC !important;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-weight: 500 !important;
    }

    a.account-card {
        text-decoration: none;
        color: unset;
    }

    a.account-card i.fa {
        font-size: 42px;
        width: 45px;
    }

    a.account-card .card {
        background: #F9FAFB;
        border: 1px solid #D0D5DC;
    }

    a.account-card .card:hover {
        background: #FFFFFF;
    }

    a.account-card .card:active {
        background: #F0F2F5;
    }

    .bg-yellow {
        background: #F5D847;
        color: #222C3A;
    }

    .list-group-item-action {
        background: #F9FAFB;
    }

    .list-group-item-action .fa {
        width: 22px;
    }

    .list-group-item-action .fa.fa-angle-right {
        font-size: 20px;
        position: absolute;
        right: 5px;
        top: 14px;
    }

    .coupon {
        background: #F9FAFB;
        border: 2px dashed #D0D5DC !important;
    }

    .reward-status-box {
        position: relative;
        width: 100%;
        color: #FFFFFF;
        background: #1b8cb2;
        border: 2px solid #38b7e1;
        border-radius: 5px;
    }

    .reward-status-box .reward-status {
        width: 60%;
        background: #38b7e1;
        padding: 15px;
    }

    .reward-status-box .current-status {
        position: absolute;
        right: 15px;
        top: 15px;
        color: #FFFFFF;
    }

    .reward-status-box .current-status-2 {
        position: absolute;
        right: 15px;
        top: 41px;
        color: #FFFFFF;
    }

    .text-orange {
        color: #EC9532 !important;
    }

    .text-carbon {
        color: #222C3A !important;
    }

    .text-pebble {
        color: #79879A !important;
    }

    .text-gray {
        color: #A2ABB9 !important;
    }

    .text-cloud {
        color: #D0D5DC !important;
    }

    .text-blue {
        color: #49AED0 !important;
    }

    .text-gray {
        color: #A2ABB9 !important;
    }

    .text-pale-sky {
        color: #A2ABB9 !important;
    }

    .bg-black {
        background: #111822 !important;
    }

    .bg-snow {
        background: #F9FAFB !important;
    }

    .bg-fog {
        background: #F0F2F5 !important;
    }

    .bb1-cloud {
        border-bottom: 1px solid #D0D5DC;
    }

    .fs-14 {
        font-size: 14px !important;
    }

    .fs-22 {
        font-size: 22px !important;
    }

    .tanga-header .navbar-brand {
        margin-bottom: 5px;
    }

    .tanga-header .nav-link {
        color: #A2ABB9;
    }

    .tanga-header .nav-link:hover {
        color: #FFFFFF;
    }

    .tanga-header .nav-link:active {
        color: #A2ABB9;
    }

    .tanga-navbar {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }


    .tanga-navbar .nav-link {
        white-space: nowrap;
        color: #79879A;
    }

    .tanga-navbar .nav-link:hover {
        color: #354050;
    }

    .tanga-navbar .nav-link:active {
        color: #79879A;
    }

    .btn-primary {
        background: #C62931;
        border-color: #C62931;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #d94950;
        border-color: #d94950;
    }

    .btn-secondary {
        background: #FFFFFF !important;
        color: #354050 !important;
        border-color: #D0D5DC !important;
        cursor: pointer;
    }

    .btn-secondary:hover {
        color: #354050 !important;
        background: #F9FAFB !important;
    }

    .btn-secondary:active {
        color: #79879A !important;
        background: #F0F2F5 !important;
    }

    .btn-secondary:focus {
        color: #79879A !important;
        background: #F0F2F5 !important;
        outline: 0 !important;
    }

    .mobile-nav {
        position: fixed;
        bottom: 0;
        z-index: 50;
        display: block;
        width: 100%;
        background: #111822;
    }

    .mobile-nav a {
        text-decoration: none !important;
        cursor: pointer;
        color: #A2ABB9;
        font-size: 12px;
        width: 20%;
        display: inline-block;
        text-align: center;
        margin: 0 !important;
        padding: 8px 0px 5px 0px;
    }

    .mobile-nav a.active {
        background: #222C3A;
        color: #FFFFFF;
    }

    .mobile-nav a i {
        font-size: 23px;
        display: block;
        margin: 0 auto;
        margin-bottom: 2px;
    }

    .fs-18 {
        font-size: 18px !important;
    }

    .fs-22 {
        font-size: 22px !important;
    }

    .bg-snow {
        background: #F9FAFB !important;
    }

    .card {
        border-color: #D0D5DC !important;
    }

    .text-pebble {
        color: #79879A !important;
    }

    .text-charcoal {
        color: #354050 !important;
    }

    .bottom-drawer {
        position: fixed;
        bottom: 56px;
        width: 100%;
        border-top: 1px solid #D0D5DC;
    }

    .bg-white {
        background: #FFFFFF !important;
    }

    .list-group {
        border-color: #D0D5DC !important;
    }

    .list-group-item {
        border-color: #D0D5DC !important;
    }

    .text-red {
        color: #C62931 !important;
    }

    .text-green {
        color: #00A362 !important;
    }

    .text-link-blue {
        color: #3373cc !important;
    }

    .form-control {
        background: #F9FAFB;
        border-color: #D0D5DC !important;
    }

    .bd-2-cloud {
        border: 2px dashed #D0D5DC;
    }

    .b-1-green {
        border: 2px solid #00A362 !important;
    }

    .br-8 {
        border-radius: 5px;
    }

    .address-radio .address-label {
        padding: 1rem;
        margin-bottom: 0 !important;
    }

    .address-radio [type=radio]:checked,
    .address-radio [type=radio]:not(:checked) {
        position: absolute;
        opacity: 0;
    }

    .address-radio [type=radio]:checked+label,
    .address-radio [type=radio]:not(:checked)+label {
        position: relative;
        padding-left: 50px;
        width: 100%;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #354050;
    }

    .address-radio [type=radio]:checked+label:before,
    .address-radio [type=radio]:not(:checked)+label:before {
        content: "";
        position: absolute;
        left: 1rem;
        top: 1rem;
        width: 20px;
        height: 20px;
        border: 2px solid #D0D5DC;
        border-radius: 50%;
        background: #fff;
    }

    .address-radio [type=radio]:checked+label:after,
    .address-radio [type=radio]:not(:checked)+label:after {
        content: "";
        width: 12px;
        height: 12px;
        background: #00A362;
        position: absolute;
        top: 20px;
        left: 20px;
        border-radius: 50%;
        transition: all 0.2s ease;
    }

    .address-radio [type=radio]:not(:checked)+label:after {
        opacity: 0;
        transform: scale(0);
    }

    .address-radio [type=radio]:checked+label:after {
        opacity: 1;
        transform: scale(1);
    }

    .address-radio [type=radio]:not(:checked)~label p {
        display: none;
    }

    .address-radio [type=radio]:checked~label p {
        display: unset;
    }
</style>
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active"><a href="order.php">Order</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container mt-20">
    <div class="row">
        <div class="col-12">
            <h5 class="text-charcoal hidden-md-up" style="font-size: 40px;margin-bottom: 30px;text-align: center;">Orders</h5>
            <?php
            if (mysqli_num_rows($orders) > 0) {
                while ($order = mysqli_fetch_assoc($orders)) {
                    if ($order['o_status'] == "Pending") {
                        echo " <div style='text-align: right;font-size: 18px;'>
                            <a onclick='return abc()' href='?type=status&operation=cancel_order&id=$order[o_id]'>Cancel Order</a>
                        </div>";
                    }
            ?>
                    <div class="list-group" style="margin-bottom:40px;">
                        <div class="list-group-item p-3 bg-snow" style="position:relative;text-align:center;">
                            <div class="row w-100 no-gutters">
                                <div class="col-6 col-md">
                                    <h6 class="text-charcoal mb-0 w-100" style="font-size: 19px;color: #8383c3!important;">Order Id</h6>
                                    <p class="text-pebble mb-0 w-100 mb-2 mb-md-0" style="font-size: 15px;font-weight: 500;margin-top: 1px;color: #9d9db3!important;">
                                        <?php
                                        echo '#' . $order['order_id_show'];
                                        ?>
                                    </p>
                                </div>
                                <div class="col-6 col-md">
                                    <h6 class="text-charcoal mb-0 w-100" style="font-size: 19px;color: #8383c3!important;">Total</h6>
                                    <p class="text-pebble mb-0 w-100 mb-2 mb-md-0" style="font-size: 15px;font-weight: 500;margin-top: 1px;color: #9d9db3!important;">Rs. <?php echo $order['o_total_amout'] ?></p>
                                </div>
                                <div class="col-6 col-md">
                                    <h6 class="text-charcoal mb-0 w-100" style="font-size: 19px;color: #8383c3!important;">Status</h6>
                                    <p class="text-pebble mb-0 w-100 mb-2 mb-md-0" style="font-size: 15px;font-weight: 500;margin-top: 1px;color: #9d9db3!important;"><?php echo $order['o_status'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 bg-white">
                            <div class="container">
                                <div class="row mt-3 w-100">
                                    <?php
                                    $order_details = mysqli_query($con, "select * from order_details where od_fk_o = '$order[o_id]' order by od_id desc");
                                    if (mysqli_num_rows($order_details) > 0) {
                                        while ($order_detail = mysqli_fetch_assoc($order_details)) {
                                            $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$order_detail[od_fk_product_id]'"));
                                    ?>
                                            <div class="col-12 col-md-12 d-flex" style="padding: 0px 143px;;display: flex;justify-content: space-between;align-items: center;">
                                                <div style="display:flex ;justify-content: center;align-items: center;margin: 10px 0px;">
                                                    <div>
                                                        <img style="width: 105px;height: 105px;object-fit: cover;border-radius: 10px;" src="<?php echo IMAGE_SITE_PATH . $product['p_image'] ?>" alt="img">
                                                    </div>
                                                    <div style="margin-left: 15px;margin-bottom: 8px;">
                                                        <h6 class="text-charcoal mb-2 mb-md-1">
                                                            <span style="font-size:20px;"><?php echo $product['p_name'] ?></span>
                                                        </h6>
                                                        <ul class="list-unstyled text-pebble mb-2 small">
                                                            <li class="" style="font-size:15px;">
                                                                <b>Qty :</b> <?php echo $order_detail['od_product_qty'] ?>
                                                            </li>
                                                        </ul>
                                                        <h6 class="text-charcoal text-left mb-0 mb-md-2" style="font-size:17px;"><b>Rs. <?php echo $product['p_price'] * $order_detail['od_product_qty'] ?></b></h6>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($order['o_end_date'] > date('Y-m-d h:i:s')) {
                                                    if ($order['o_status'] == "Pending" || $order['o_status'] == "Processing") {
                                                ?>
                                                        <div style="display: flex;justify-content: space-around;align-items: center;flex-direction: column;">
                                                            <a style="border: 1px solid blue;padding: 0px 6px;border-radius: 5px;margin: 5px 0px;color: black;" href="return_product.php?o_id=<?php echo $order['o_id'] ?>&p_id=<?php echo $product['p_id'] ?>">Return</a>
                                                            <button onclick="replaceProduct()" style="border: 1px solid blue;padding: 0px 6px;border-radius: 5px;margin: 5px 0px;color: black;background-color: transparent;cursor: pointer;" href="">Replace</button>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "<div class='container'>
                                        <div class='row'>
                                            <div class='col-12 my-5' style='text-align:center;'>
                                            No Orders Details Found
                                            </div>
                                        </div>
                                    </div>";
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='container'>
                        <div class='row'>
                            <div class='col-12 my-5' style='text-align:center;'>
                            No Orders Found
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>


    </div>
</div>


<?php
require('footer.php');
?>

<script>
    function replaceProduct() {
        swal({
            title: "Your Product Replace After 2 Days",
            icon: "success",
            button: true,
        })
    }

    function abc() {
        var confirmMsg = confirm("Are you sure you want to cancel this order");
        if (confirmMsg != '') {
            return true;
        } else {
            return false;
        }
        // swal({
        //         title: "Are you sure?",
        //         text: "You want to cancel this order!",
        //         icon: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //     })
        //     .then((willDelete) => {
        //         if (willDelete != '') {
        //             return true;
        //             console.log("true");
        //         } else {
        //             console.log("false");
        //             return false;
        //         }
        //     });
    }
</script>