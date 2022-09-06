<?php
require('top.inc.php');
isAdmin();
$res = mysqli_query($con, "select * from customer order by c_id desc");
$search = '';
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = get_safe_value($con,$_GET['search']);
    $res = mysqli_query($con, "select * from customer where c_email like '$search%' order by c_id desc");
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
        $update_sql = "update customer set c_status = '$status' where c_id = '$id'";
        $run = mysqli_query($con, $update_sql);
        if ($run) {
            echo "<script>window.location.href='customer.php'</script>";
        }
    }
}

if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "delete") {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "update customer set c_status = 0 where c_id = '$id'";
        $run = mysqli_query($con, $delete_sql);
        if ($run) {
            echo "<script>window.location.href='customer.php'</script>";
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
                    <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Customers
                    <form method="GET" style="display: flex;">
                        <input type="text" required value="<?php echo $search?>" name="search" placeholder="Search Email..." class="form-control">
                        <button style="margin-left: 5px;" class="btn btn-info">Search</button>
                        <a href="customer.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
                    </form>
                    </h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="avatar">Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <tr>
                                                <td class="serial"><?php echo $row['c_id'] ?></td>
                                                <td class="avatar">
                                                    <div class="round-img">
                                                        <img style="width: 40px;height: 40px;object-fit: cover;" class="rounded-circle" src="<?php echo IMAGE_SITE_PATH . $row['c_image'] ?>" alt="img">
                                                    </div>
                                                </td>
                                                <td> <span class="name"><?php echo $row['c_firstname'] .' ' .$row['c_lastname'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['c_email'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['c_phone'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['c_gender'] ?></span> </td>
                                                <td style="padding-right: 15px;padding-left: 0px;width: 275px;">
                                                    <?php
                                                    if ($row['c_status'] == 1) {
                                                        echo "<a href='?type=status&operation=deactive&id=$row[c_id]' class='badge badge-complete'>Active</a>";
                                                    } else {
                                                        echo "<a href='?type=status&operation=active&id=$row[c_id]' class='badge badge-pending'>Deactive</a>";
                                                    }
                                                    ?>
                                                    <a href="manage_customer.php?id=<?php echo $row['c_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                                                    <a href="?type=delete&id=<?php echo $row['c_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                                    <a href="manage_customer.php?type=details&id=<?php echo $row['c_id'] ?>" class="btn btn-sm btn-success">Details</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr>
                                                <td colspan='8' class='text-center'>No Customers Found</td>
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