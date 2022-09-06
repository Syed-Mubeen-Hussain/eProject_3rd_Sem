<?php
require('top.inc.php');

$condition = '';
$condition1 = '';
if($_SESSION['ADMIN_ROLE'] == 1){
    $condition = "and product.p_added_by = '".$_SESSION['ADMIN_ID']."'";
    $condition1 = "and p_added_by = '".$_SESSION['ADMIN_ID']."'";
}

$res = mysqli_query($con, "select product.*,category.cat_name from product,category where product.p_fk_cat = category.cat_id $condition order by product.added_on desc");
$search = '';
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = get_safe_value($con,$_GET['search']);
    $res = mysqli_query($con, "select product.*,category.cat_name from product,category where product.p_fk_cat = category.cat_id $condition and product.p_name like '$search%' order by product.added_on desc");    
}

if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "status") {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        if ($operation == "deactive") {
            $status = '0';
        } else {
            $status = '1';
        }
        $update_sql = "update product set p_status = '$status' where p_id = '$id' $condition1";
        $run = mysqli_query($con, $update_sql);
        if ($run) {
            echo "<script>window.location.href='product.php'</script>";
        }
    }
}

if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "delete") {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "update product set p_status = 0 where p_id = '$id' $condition1";
        $run = mysqli_query($con, $delete_sql);
        if ($run) {
            echo "<script>window.location.href='product.php'</script>";
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
                    <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Products
                    <form method="GET" style="display: flex;">
                        <input type="text" required value="<?php echo $search?>" name="search" placeholder="Search Name..." class="form-control">
                        <button style="margin-left: 5px;" class="btn btn-info">Search</button>
                        <a href="product.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
                    </form>
                    </h4>
                        <a href="manage_product.php">Add Product</a>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="avatar">Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Category</th>
                                        <th>Employee</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <tr>
                                                <td class="serial"><?php echo $row['p_id'] ?></td>
                                                <td class="avatar">
                                                    <div class="round-img">
                                                    <img style="width: 40px;height: 40px;object-fit: cover;" class="rounded-circle" src="<?php echo IMAGE_SITE_PATH . $row['p_image'] ?>" alt="img">
                                                    </div>
                                                </td>
                                                <td> <span class="name"><?php echo $row['p_name'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['p_price'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['p_qty'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['cat_name'] ?></span> </td>
                                                <td> <span class="name"><?php 
                                                $employee_data = mysqli_query($con,"select * from admin_user where ad_id = '$row[p_added_by]'");
                                                if(mysqli_num_rows($employee_data) > 0){
                                                    $employee = mysqli_fetch_assoc($employee_data);
                                                    if($employee['ad_role'] == 0){
                                                        echo "Admin";
                                                    }else
                                                    {
                                                        echo $employee['ad_email'];
                                                    }
                                                }
                                                  ?>
                                            </span> </td>
                                                <td style="padding-right: 15px;padding-left: 0px;width: 275px;">
                                                    <?php
                                                    if ($row['p_status'] == 1) {
                                                        echo "<a href='?type=status&operation=deactive&id=$row[p_id]' class='badge badge-complete'>Active</a>";
                                                    } else {
                                                        echo "<a href='?type=status&operation=active&id=$row[p_id]' class='badge badge-pending'>Deactive</a>";
                                                    }
                                                    ?>
                                                    <a href="manage_product.php?id=<?php echo $row['p_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                                                    <a href="?type=delete&id=<?php echo $row['p_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                                    <a href="manage_product.php?type=details&id=<?php echo $row['p_id'] ?>"  class="btn btn-sm btn-success">Details</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    }else{
                                        echo "<tr>
                                                <td colspan='8' class='text-center'>No Products Found</td>
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