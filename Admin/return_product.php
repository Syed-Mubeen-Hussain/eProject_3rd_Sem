<?php
require('top.inc.php');
isAdmin();
$res = mysqli_query($con, "select * from return_product order by re_id desc");
$search = '';
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = get_safe_value($con, $_GET['search']);
    $res = mysqli_query($con, "select * from return_product where re_id like '$search%' order by re_id desc");
}

if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "status") {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        $o_id = get_safe_value($con, $_GET['o_id']);
        $check_order = mysqli_fetch_assoc(mysqli_query($con, "select * from orders where o_id = '$o_id'"));
        $p_id = get_safe_value($con, $_GET['p_id']);
        $check_product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$p_id'"));
        if ($check_order['o_id'] == $o_id && $check_product['p_id'] == $p_id) {
            if ($operation == "Approve") {
                $status = 'Pending';
            } else {
                $status = 'Approve';
            }
            $update_sql = "update return_product set re_status = '$status' where re_id = '$id'";
            $run = mysqli_query($con, $update_sql);
            if ($run) {
                $order_details = mysqli_query($con, "select * from order_details order by od_id desc");
                if (mysqli_num_rows($order_details) > 0) {
                    while ($order_detail = mysqli_fetch_assoc($order_details)) {
                        if ($o_id == $order_detail['od_fk_o']) {
                            $p_id = $order_detail['od_fk_product_id'];
                            break;
                        }
                    }
                }
                $added_on = date('y-m-d h:i:s');
               
                $customer_id = mysqli_fetch_assoc(mysqli_query($con, "select * from return_product where re_fk_product_id = '$p_id' and re_fk_order_id = '$o_id'"));
                $message = "Your Return Product Is $status Order Id #" . $check_order['order_id_show'] . " Product Id #" . $p_id . "";
                mysqli_query($con, "INSERT INTO notifications(n_text,n_fk_customer_id,added_on) values('$message','$customer_id[re_fk_customer_id]','$added_on')");
                echo "<script>window.location.href='return_product.php'</script>";
            }
        } else {
?>
            <script>
                window.location.href = 'dashboard.php';
            </script>
<?php
        }
    }
}
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Return Products
                            <form method="GET" style="display: flex;">
                                <input type="text" required value="<?php echo $search ?>" name="search" placeholder="Search Id..." class="form-control">
                                <button style="margin-left: 5px;" class="btn btn-info">Search</button>
                                <a href="return_product.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
                            </form>
                        </h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Order Id</th>
                                        <th>Product Id</th>
                                        <th>Customer Id</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <tr>
                                                <td class="serial"><?php echo $row['re_id'] ?></td>
                                                <td> <span class="name"><?php 
                                                $order_id = mysqli_fetch_assoc(mysqli_query($con,"select * from orders where o_id = '$row[re_fk_order_id]'"));
                                                echo $order_id['order_id_show']; ?></span> </td>
                                                <td> <span class="name"><?php echo $row['re_fk_product_id'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['re_fk_customer_id'] ?></span> </td>
                                                <td style="width: 275px;"> <span class="name"><?php echo $row['re_reason'] ?></span> </td>
                                                <td style="padding-right: 15px;padding-left: 0px;">
                                                    <?php
                                                    if ($row['re_status'] == "Approve") {
                                                        echo "<a href='?type=status&operation=Approve&id=$row[re_id]&o_id=$row[re_fk_order_id]&p_id=$row[re_fk_product_id]' class='badge badge-complete'>Approve</a>";
                                                    } else {
                                                        echo "<a href='?type=status&operation=Pending&id=$row[re_id]&o_id=$row[re_fk_order_id]&p_id=$row[re_fk_product_id]' class='badge badge-info'>Pending</a>";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr>
                                                <td colspan='6' class='text-center'>No Return Products Found</td>
                                            </tr>";
                                    }  ?>
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