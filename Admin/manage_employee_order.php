<?php
require('top.inc.php');

$msg = '';
$status = '';
$order_id_show = $_SESSION['ORDER_ID_SHOW'] != '' ? $_SESSION['ORDER_ID_SHOW'] : 0;

// check if set id or id is not empty or id is not less then 1 
if (isset($_GET['id']) && ($_GET['id'] == '' || $_GET['id'] < 1)) {
    echo "<script>window.location.href = 'employee_order.php'</script>";
}

// details work
if (isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) {
    $id = get_safe_value($con, $_GET['id']);
    $res =  mysqli_query($con, "select * from employee_orders where eo_id = '$id'");
    if(mysqli_num_rows($res) < 1){
        ?>
        <script>
            window.location.href = 'employee_order.php';
        </script>
        <?php
    }
} else {
    echo "<script>window.location.href = 'employee_order.php'</script>";
}


?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Order Details</h4>
                        <p class="m-0 pt-2">Order Id : <?php echo $order_id_show ?></p>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th class="avatar">Product Image</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Product Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        $order = mysqli_fetch_assoc($res);
                                        $order_details = mysqli_query($con, "select * from employee_order_details where eod_fk_o = '$order[eo_id]'");
                                        while ($order_detail = mysqli_fetch_assoc($order_details)) {
                                            $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$order_detail[eod_fk_product_id]'"));
                                            $total_amount = $product['p_price'] * $order_detail['eod_product_qty'];
                                    ?>
                                            <tr>
                                                <td class="serial"><?php echo $product['p_id'] ?></td>
                                                <td class="avatar">
                                                    <div class="round-img">
                                                        <img style="width: 40px;height: 40px;object-fit: cover;" class="rounded-circle" src="<?php echo IMAGE_SITE_PATH . $product['p_image'] ?>" alt="img">
                                                    </div>
                                                </td>
                                                <td> <span class="name"><?php echo $product['p_name'] ?></span> </td>
                                                <td> <span class="name"><?php echo $product['p_price'] ?></span> </td>
                                                <td> <span class="name"><?php echo $order_detail['eod_product_qty'] ?></span> </td>
                                                <td> <span class="name"><?php echo $product['p_price'] * $order_detail['eod_product_qty'] ?></span> </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr>
                                                <td colspan='6' class='text-center'>No Product Found</td>
                                            </tr>";
                                    } ?>
                                    <tr>
                                        <td colspan="6">
                                            <div>
                                                <div style="text-align: left;">
                                                    <b>Status</b> : <?php echo $order['eo_status'] ?>
                                                </div>
                                                <div style="text-align: left;margin-top: 5px;">
                                                    <b>Total Amount</b> : <?php echo 'Rs ' . $total_amount ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.inc.php');
?>