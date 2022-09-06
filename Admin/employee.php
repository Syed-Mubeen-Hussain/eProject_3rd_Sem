<?php
require('top.inc.php');
isAdmin();
$res = mysqli_query($con, "select * from admin_user where ad_role = 1 order by ad_id desc");
$search = '';
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = get_safe_value($con,$_GET['search']);
    $res = mysqli_query($con, "select * from admin_user where ad_role = 1 and ad_username like '$search%' order by ad_id desc");
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
        $update_sql = "update admin_user set ad_status = '$status' where ad_id = '$id' and ad_role = 1";
        $run = mysqli_query($con, $update_sql);
        if ($run) {
            echo "<script>window.location.href='employee.php'</script>";
        }
    }
}

if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "delete") {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "update admin_user set ad_status = 0 where ad_id = '$id'";
        $run = mysqli_query($con, $delete_sql);
        if ($run) {
            echo "<script>window.location.href='employee.php'</script>";
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
                    <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Employees
                    <form method="GET" style="display: flex;">
                        <input type="text" required value="<?php echo $search?>" name="search" placeholder="Search Username..." class="form-control">
                        <button style="margin-left: 5px;" class="btn btn-info">Search</button>
                        <a href="employee.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
                    </form>
                    </h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <tr>
                                                <td class="serial"><?php echo $row['ad_id'] ?></td>
                                                <td> <span class="name"><?php echo $row['ad_username'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['ad_email'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['ad_mobile'] ?></span> </td>
                                                <td style="padding-right: 15px;padding-left: 0px;width: 275px;">
                                                <?php
                                                    if ($row['ad_status'] == 1) {
                                                        echo "<a href='?type=status&operation=deactive&id=$row[ad_id]' class='badge badge-complete'>Active</a>";
                                                    } else {
                                                        echo "<a href='?type=status&operation=active&id=$row[ad_id]' class='badge badge-pending'>Deactive</a>";
                                                    }
                                                    ?>
                                                    <a href="?type=delete&id=<?php echo $row['ad_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                                    <a href="manage_employee.php?type=details&id=<?php echo $row['ad_id'] ?>" class="btn btn-sm btn-success">Details</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr>
                                                <td colspan='5' class='text-center'>No Employees Found</td>
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