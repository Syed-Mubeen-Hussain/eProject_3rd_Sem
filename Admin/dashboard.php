<?php
require('top.inc.php');
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_ROLE'] == 0) {
    $category_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from category"));
    $product_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from product"));
    $customer_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from customer"));
    $contact_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from contact"));
    $admin_user_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from admin_user where ad_role = 1"));
    $orders_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from orders"));
?>

    <div class="content pb-0">
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Dashboard
                            </h4>
                            <div class="container my-5">
                                <div class="row" style="justify-content: center;">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $category_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Categories</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $product_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Products</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $customer_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Customers</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $contact_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Contacts</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $admin_user_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Employees</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $orders_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Orders</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_ROLE'] == 1) {
    $product_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from product where p_added_by = '$_SESSION[ADMIN_ID]'"));
    $orders_count = mysqli_fetch_assoc(mysqli_query($con, "select count(*) as count from employee_orders where eo_fk_emp_id = '$_SESSION[ADMIN_ID]'"));
?>
    <div class="content pb-0">
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title" style="font-size: 23px;font-weight: bold;display:flex;justify-content: space-between;">Dashboard
                            </h4>
                            <div class="container my-5">
                                <div class="row" style="justify-content: center;">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $product_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Products</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="stat-content" style="display: flex;justify-content: center;">
                                                        <div class="text-left dib">
                                                            <div class="stat-text text-center" style=color:darkcyan;font-weight:600;"><span class="count"><?php echo $orders_count['count'] ?></span></div>
                                                            <div class="stat-heading" style=font-weight:600;>Orders</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    echo "<script>window.location.href = 'login.php'</script>";
}
?>
<?php
require('footer.inc.php');
?>