<?php
require('top.inc.php');
isAdmin();
$res = mysqli_query($con, "select * from category order by cat_id desc");
$search = '';
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = get_safe_value($con,$_GET['search']);
    $res = mysqli_query($con, "select * from category where cat_name like '$search%' order by cat_id desc");
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
        $update_sql = "update category set cat_status = '$status' where cat_id = '$id'";
        $run = mysqli_query($con, $update_sql);
        if ($run) {
            echo "<script>window.location.href='category.php'</script>";
        }
    }
}

if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "delete") {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "update category set cat_status = 0 where cat_id = '$id'";
        $run = mysqli_query($con, $delete_sql);
        if ($run) {
            echo "<script>window.location.href='category.php'</script>";
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
                        <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Categories
                    <form method="GET" style="display: flex;">
                        <input type="text" required value="<?php echo $search?>" name="search" placeholder="Search Name..." class="form-control">
                        <button style="margin-left: 5px;" class="btn btn-info">Search</button>
                        <a href="category.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
                    </form>
                    </h4>
                        <a href="manage_category.php">Add Category</a>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="avatar">Image</th>
                                        <th>Name</th>
                                        <th>Products</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $countOfProducts = 0;
                                    ?>
                                            <tr>
                                                <td class="serial"><?php echo $row['cat_id'] ?></td>
                                                <td class="avatar">
                                                    <div class="round-img">
                                                        <img style="width: 40px;height: 40px;object-fit: cover;" class="rounded-circle" src="<?php echo IMAGE_SITE_PATH . $row['cat_image'] ?>" alt="img">
                                                    </div>
                                                </td>
                                                <td> <span class="name"><?php echo $row['cat_name'] ?></span> </td>
                                                <?php
                                                $products = mysqli_query($con, "select * from product");
                                                if (mysqli_num_rows($products) > 0) {
                                                    while ($p = mysqli_fetch_assoc($products)) {
                                                        if ($p['p_fk_cat'] == $row['cat_id']) {
                                                            $countOfProducts += 1;
                                                        }
                                                    }
                                                }
                                                if ($countOfProducts == 0) {
                                                    echo "<td> <span class='product'>0</span> </td>";
                                                } else {
                                                    echo "<td> <span class='product'>$countOfProducts</span> </td>";
                                                }
                                                ?>
                                                <td style="padding-right: 15px;padding-left: 0px;width: 275px;">
                                                    <?php
                                                    if ($row['cat_status'] == 1) {
                                                        echo "<a href='?type=status&operation=deactive&id=$row[cat_id]' class='badge badge-complete'>Active</a>";
                                                    } else {
                                                        echo "<a href='?type=status&operation=active&id=$row[cat_id]' class='badge badge-pending'>Deactive</a>";
                                                    }
                                                    ?>
                                                    <a href="manage_category.php?id=<?php echo $row['cat_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                                                    <a href="?type=delete&id=<?php echo $row['cat_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                                    <a href="manage_category.php?type=details&id=<?php echo $row['cat_id'] ?>" class="btn btn-sm btn-success">Details</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr>
                                                <td colspan='5' class='text-center'>No Categories Found</td>
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