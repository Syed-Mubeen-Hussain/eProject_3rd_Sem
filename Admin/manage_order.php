<?php
require('top.inc.php');
isAdmin();
$msg = '';
$status = '';
$order_id_show = 0;

// check if set id or id is not empty or id is not less then 1 
if (isset($_GET['id']) && ($_GET['id'] == '' || $_GET['id'] < 1)) {
    echo "<script>window.location.href = 'order.php'</script>";
}

// details work
if (isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) {
    $id = get_safe_value($con, $_GET['id']);
    $res =  mysqli_query($con, "select * from orders where o_id = '$id'");
    if(mysqli_num_rows($res) < 1){
        ?>
        <script>
            window.location.href = 'order.php';
        </script>
        <?php
    }
} else {
    echo "<script>window.location.href = 'order.php'</script>";
}

// status
if (isset($_POST['changeStatus'])) {
    $status = get_safe_value($con, $_POST['changeStatus']);
    $update_sql = mysqli_query($con, "update orders set o_status = '$status' where o_id = '$id'");
    if ($update_sql) {
        $order_sql = mysqli_fetch_assoc(mysqli_query($con, "select * from orders where o_id = '$id'"));
        $added_on = date('y-m-d h:i:s');
        $message = "Your Order Is $status Order Id #" . $order_sql['order_id_show'] . " ";
        $customer_id = $order_sql['o_fk_cus_id'];
        mysqli_query($con, "INSERT INTO notifications(n_text,n_fk_customer_id,added_on) values('$message','$customer_id','$added_on')");
?>
        <script>
            window.location.href = window.location.href;
        </script>
<?php
    }
}

?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Order Details</h4>
                        <p class="m-0 pt-2">Order Id : <?php
                                                        $o = mysqli_fetch_assoc(mysqli_query($con, "select * from orders where o_id = '$id'"));
                                                        echo $o['order_id_show'] ?></p>
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
                                        $order_details = mysqli_query($con, "select * from order_details where od_fk_o = '$order[o_id]'");
                                        while ($order_detail = mysqli_fetch_assoc($order_details)) {
                                            $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$order_detail[od_fk_product_id]'"));
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
                                                <td> <span class="name"><?php echo $order_detail['od_product_qty'] ?></span> </td>
                                                <td> <span class="name"><?php echo $product['p_price'] * $order_detail['od_product_qty'] ?></span> </td>
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
                                                    <b>Status</b> : <?php echo $order['o_status'] ?>
                                                </div>
                                                <div style="text-align: left;margin-top: 5px;">
                                                    <b>Order End Date</b> : <?php echo $order['o_end_date'] ?>
                                                </div>
                                                <div style="text-align: left;margin-top: 5px;">
                                                    <b>Total Amount</b> : <?php echo 'Rs ' . $order['o_total_amout'] ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            <form method="POST">
                                                <select onchange="this.form.submit()" class="form-control" name="changeStatus">
                                                    <?php
                                                    if ($order['o_status'] == "Pending") {
                                                        echo "<option selected value='Pending'>Pending</option>
                                                        <option value='Processing'>Processing</option>
                                                        <option value='Cancel'>Cancel</option>
                                                        <option value='Complete'>Complete</option>";
                                                    } else if ($order['o_status'] == "Processing") {
                                                        echo "<option value='Pending'>Pending</option>
                                                            <option selected value='Processing'>Processing</option>
                                                            <option value='Cancel'>Cancel</option>
                                                            <option value='Complete'>Complete</option>";
                                                    } else if ($order['o_status'] == "Cancel") {
                                                        echo "<option value='Pending'>Pending</option>
                                                            <option value='Processing'>Processing</option>
                                                            <option selected value='Cancel'>Cancel</option>
                                                            <option value='Complete'>Complete</option>";
                                                    } else if ($order['o_status'] == "Complete") {
                                                        echo "<option value='Pending'>Pending</option>
                                                            <option value='Processing'>Processing</option>
                                                            <option value='Cancel'>Cancel</option>
                                                            <option selected value='Complete'>Complete</option>";
                                                    } else {
                                                        echo "<option value='Pending'>Pending</option>
                                                            <option value='Processing'>Processing</option>
                                                            <option value='Cancel'>Cancel</option>
                                                            <option value='Complete'>Complete</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </form>
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