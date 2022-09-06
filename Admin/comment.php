<?php
require('top.inc.php');
isAdmin();
$res = mysqli_query($con, "select * from product_comment order by pc_id desc");
$search = '';
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = get_safe_value($con,$_GET['search']);
    $res = mysqli_query($con, "select * from product_comment where pc_id like '$search%' order by pc_id desc");
}

if (isset($_GET['type'])) {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == "delete") {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "delete from product_comment where pc_id = '$id'";
        $run = mysqli_query($con, $delete_sql);
        if ($run) {
            echo "<script>window.location.href='comment.php'</script>";
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
                    <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Products Comments
                    <form method="GET" style="display: flex;">
                        <input type="text" required value="<?php echo $search?>" name="search" placeholder="Search Id..." class="form-control">
                        <button style="margin-left: 5px;" class="btn btn-info">Search</button>
                        <a href="contact.php" style="margin-left: 5px;" class="btn btn-danger">Reset</a>
                    </form>
                    </h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Message</th>
                                        <th style="width: 102px;">Product Id</th>
                                        <th style="width: 115px;">Customer Id</th>
                                        <th style="width: 175px;">Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                            <tr>
                                                <td class="serial"><?php echo $row['pc_id'] ?></td>
                                                <td> <span class="name"><?php echo $row['pc_msg'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['pc_fk_product_id'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['pc_fk_customer_id'] ?></span> </td>
                                                <td> <span class="name"><?php echo $row['pc_added_on'] ?></span> </td>
                                                <td style="padding-right: 15px;padding-left: 0px;">
                                                    <a href="?type=delete&id=<?php echo $row['pc_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "<tr>
                                                <td colspan='5' class='text-center'>No Product Comments Found</td>
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