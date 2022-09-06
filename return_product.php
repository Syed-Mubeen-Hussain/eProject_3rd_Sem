<?php
require('top.php');
$msg = '';
$order_id = '';
$product_id = '';
$reason = '';
$order_id_show = '';

if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    $customer_id = $_SESSION['USER_ID'];
    if (isset($_GET['o_id']) && $_GET['o_id'] != '') {
        if (isset($_GET['p_id']) && $_GET['p_id'] != '') {
            $order_id = get_safe_value($con, $_GET['o_id']);
            $check_order = mysqli_query($con, "select * from orders where o_id = '$order_id' and o_fk_cus_id = '$customer_id'");
            if (mysqli_num_rows($check_order) > 0) {
                $order = mysqli_fetch_assoc(mysqli_query($con, "select * from orders where o_id = '$order_id' and o_fk_cus_id = '$customer_id'"));
                $product_id = get_safe_value($con, $_GET['p_id']);
                $check_product = mysqli_query($con, "select * from product where p_id = '$product_id'");
                if (mysqli_num_rows($check_product) > 0) {
                    if ($order['o_end_date'] > date('Y-m-d h:i:s')) {
                        if (isset($_POST['submit'])) {
                            $reason = get_safe_value($con, $_POST['reason']);
                            $res = mysqli_query($con, "INSERT into return_product(re_fk_product_id,re_fk_order_id,re_fk_customer_id,re_reason,re_status)values('$product_id','$order_id','$customer_id','$reason','Pending')");
                            if ($res) {
                                $order_details = mysqli_query($con, "select * from order_details order by od_id desc");
                                if (mysqli_num_rows($order_details) > 0) {
                                    while ($order_detail = mysqli_fetch_assoc($order_details)) {
                                        if ($order_id == $order_detail['od_fk_o']) {
                                            $p_id = $order_detail['od_fk_product_id'];
                                            break;
                                        }
                                    }
                                }
                                $order_id2 = mysqli_fetch_assoc($check_order);
                                $order_id_show = $order_id2['order_id_show'];
                                $added_on = date('y-m-d h:i:s');
                                $message = "Your Return Product Is Pending Order Id #" . $order_id_show . " Product Id #" . $product_id . "";
                                mysqli_query($con, "INSERT INTO notifications(n_text,n_fk_customer_id,added_on) values('$message','$customer_id','$added_on')");
?>
                                <script>
                                    swal({
                                            title: "Successfull Submitted!",
                                            icon: "success",
                                            button: true,
                                        })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                window.location.href = 'index.php';
                                            } else {
                                                window.location.href = 'index.php';
                                            }
                                        });
                                </script>
                        <?php
                            }
                        }
                    } else {
                        ?>
                        <script>
                            window.location.href = 'order.php';
                        </script>
                    <?php
                    }
                } else {
                    ?>
                    <script>
                        window.location.href = 'order.php';
                    </script>
                <?php
                }
            } else {
                ?>
                <script>
                    window.location.href = 'order.php';
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                window.location.href = 'order.php';
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            window.location.href = 'order.php';
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
?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active">Return Product</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Login Content Area -->
<div class="page-section mb-60">
    <div class="container">
        <div class="row" style="justify-content: center;">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30 mt-50">
                <!-- Login Form s-->
                <form method="POST">
                    <div class="login-form">
                        <h4 class="login-title">Return Product <span class="text-info">#<?php echo $product_id ?></span></h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label>Reason*</label>
                                <textarea required name="reason" id="" cols="10" placeholder="Enter Your Reason" rows="3"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button style="cursor: pointer;" name="submit" type="submit" class="register-button mt-0">Submit</button>
                            </div>
                        </div>
                        <div style="color:red!important;font-weight: 600;margin-top: 10px;"><?php echo $msg ?></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login Content Area End Here -->
<?php
require('footer.php');
?>