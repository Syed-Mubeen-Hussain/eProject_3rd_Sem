<?php
require('top.inc.php');
isAdmin();
$res = mysqli_query($con, "select * from orders order by added_on desc");
$search = '';
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = get_safe_value($con, $_GET['search']);
    $search_str = substr($search, 8);
    $res = mysqli_query($con, "select * from orders where o_id = '$search_str' order by added_on desc");
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
                                <a href="order.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
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
                                        <th class="product-name"><span class="nobr">End Date</span></th>
                                        <th class="product-name"><span class="nobr">Customer Id</span></th>
                                        <th class="product-stock-stauts"><span class="nobr"> Payment Method </span></th>
                                        <th class="product-stock-stauts" style="text-align: left;"><span class="nobr"> Status </span></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <tr>
                                                <td class="product-add-to-cart">
                                                    <?php echo $row['order_id_show'] ?>
                                                </td>
                                                <td class="product-name"><?php echo $row['added_on'] ?></td>
                                                <td class="product-name"><?php echo $row['o_end_date'] ?></td>
                                                <td class="product-name"><?php echo $row['o_fk_cus_id'] ?></td>
                                                <td class="product-name"><?php
                                                                            if ($row['cash_payment'] == 1) {
                                                                                echo "Cash On Delivery";
                                                                            } else if ($row['credit_card_number'] != '' && $row['credit_card_pin'] != '') {
                                                                                echo "Credit Card";
                                                                            } else {
                                                                                echo "No Payment Method";
                                                                            }
                                                                            ?></td>
                                                <td>
                                                    <?php echo $row['o_status'] ?>
                                                </td>
                                                <td class="product-name" style="display: flex;justify-content: space-between;">
                                                    <a href="manage_order.php?type=details&id=<?php echo $row['o_id'] ?>" class="btn btn-sm btn-success">Details</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr>
                                                <td colspan='7' style='text-align:center;'>No Orders Found</td>
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