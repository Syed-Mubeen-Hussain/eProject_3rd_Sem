<?php
require('top.inc.php');
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
    $employee_id = $_SESSION['ADMIN_ID'];
    $res = mysqli_query($con, "select * from employee_orders where eo_fk_emp_id = '$employee_id' order by added_on desc");
    $search = '';
    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = get_safe_value($con, $_GET['search']);
        $search_str = substr($search, 8);
        $res = mysqli_query($con, "select * from employee_orders where eo_id = '$search_str' and eo_fk_emp_id = '$employee_id' order by added_on desc");
    }
} else {
    echo "<script>window.location.href = 'login.php'</script>";
}
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Orders
                            <form method="GET" style="display: flex;">
                                <input type="text" required value="<?php echo $search ?>" name="search" placeholder="Search Order Id..." class="form-control">
                                <button style="margin-left: 5px;" class="btn btn-info">Search</button>
                                <a href="employee_order.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
                            </form>
                        </h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Id</th>
                                        <th class="product-name"><span class="nobr">Date</span></th>
                                        <th class="product-stock-stauts"><span class="nobr"> Payment Method </span></th>
                                        <th class="product-stock-stauts" style="text-align: left;"><span class="nobr"> Status </span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $order_details = mysqli_query($con, "select * from employee_order_details order by eod_id desc");
                                            if (mysqli_num_rows($order_details) > 0) {
                                                while ($order_detail = mysqli_fetch_assoc($order_details)) {
                                                    if ($row['eo_id'] == $order_detail['eod_fk_o']) {
                                                        $product_id = $order_detail['eod_fk_product_id'];
                                                        break;
                                                    }
                                                }
                                            }
                                    ?>
                                            <?php if (mysqli_num_rows($order_details) > 0) { ?>
                                                <tr>
                                                    <td class="product-add-to-cart">
                                                        <?php
                                                        if ($row['cash_payment'] == 1) {
                                                            echo  '1' . $product_id . $row['eo_id'];
                                                            $_SESSION['ORDER_ID_SHOW'] = '1' . $product_id . $row['eo_id'];
                                                        } else if ($row['credit_card_number'] != '' && $row['credit_card_pin'] != '') {
                                                            echo  '2' . $product_id . $row['eo_id'];
                                                            $_SESSION['ORDER_ID_SHOW'] = '2' . $product_id . $row['eo_id'];
                                                        } else {
                                                            echo  '0' . $product_id . $row['eo_id'];
                                                            $_SESSION['ORDER_ID_SHOW'] = '0' . $product_id . $row['eo_id'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="product-name"><?php echo $row['added_on'] ?></td>
                                                    <td class="product-name"><?php
                                                                                if ($row['cash_payment'] == 1) {
                                                                                    echo "Cash On Delivery";
                                                                                } else if ($row['credit_card_number'] != '' && $row['credit_card_pin'] != '') {
                                                                                    echo "Credit Card";
                                                                                } else {
                                                                                    echo "No Payment Method";
                                                                                }
                                                                                ?></td>
                                                    <td class="product-name" style="display: flex;justify-content: space-between;"><?php echo $row['eo_status'] ?>
                                                        <a href="manage_employee_order.php?type=details&id=<?php echo $row['eo_id'] ?>" class="btn btn-sm btn-success">Details</a>
                                                    </td>
                                                </tr>
                                    <?php } else {
                                                echo "<tr>
                                            <td colspan='4' style='text-align:center;'>No Orders Products</td>
                                            </tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr>
                                                <td colspan='4' style='text-align:center;'>No Orders Found</td>
                                            </tr>";
                                    } ?>
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