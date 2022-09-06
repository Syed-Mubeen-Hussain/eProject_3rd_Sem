<?php
require('connection.inc.php');
require('function.inc.php');
$page_title = '';
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
} else {
    echo "<script>window.location.href = 'login.php'</script>";
}

$script_name = $_SERVER['SCRIPT_NAME'];
$script_name_arr = explode('/', $script_name);
$my_page = $script_name_arr[count($script_name_arr) - 1];
if ($my_page == "dashboard.php") {
    $page_title = "Dashboard";
}
if ($my_page == "category.php") {
    $page_title = "Categories";
}
if ($my_page == "manage_category.php") {
    $page_title = "Manage Category";
}
if ($my_page == "product.php") {
    $page_title = "Products";
}
if ($my_page == "manage_product.php") {
    $page_title = "Manage Product";
}
if ($my_page == "customer.php") {
    $page_title = "Customers";
}
if ($my_page == "manage_customer.php") {
    $page_title = "Manage Customer";
}
if ($my_page == "contact.php") {
    $page_title = "Contacts";
}
if ($my_page == "manage_contact.php") {
    $page_title = "Manage Contact";
}
if ($my_page == "employee.php") {
    $page_title = "Employees";
}
if ($my_page == "manage_employee.php") {
    $page_title = "Manage Employee";
}
if ($my_page == "order.php") {
    $page_title = "Orders";
}
if ($my_page == "comment.php") {
    $page_title = "Comments";
}
if ($my_page == "manage_order.php") {
    $page_title = "Manage Order";
}
if ($my_page == "return_product.php") {
    $page_title = "Return Products";
}
if ($my_page == "employee_order.php") {
    $page_title = "Orders";
}
if ($my_page == "manage_employee_order.php") {
    $page_title = "Manage Order";
}
?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title . " - Arts Stationary"?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo SITE_PATH . "images/favicon.jpg"?>">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/pe-icon-7-stroke.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="assets/js/custom.js"></script>
</head>

<body>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="menu-title">Menu</li>
                    <li class="menu-item-has-children dropdown">
                        <a href="dashboard.php"> Dashboard</a>
                    </li>
                    <?php
                    if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_ROLE'] == 0) {
                    ?>
                        <li class="menu-item-has-children dropdown">
                            <a href="category.php"> Categories</a>
                        </li>
                    <?php
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_ROLE'] == 1) {
                    ?>
                        <li class="menu-item-has-children dropdown">
                            <a href="product.php"> Products</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="employee_order.php"> Orders</a>
                        </li>
                    <?php
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_ROLE'] == 0) {
                    ?>
                        <li class="menu-item-has-children dropdown">
                            <a href="product.php"> Products</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="customer.php"> Customers</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="contact.php"> Contacts</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="employee.php"> Employees</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="order.php"> Orders</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="return_product.php"> Return Product</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="comment.php"> Product Comments</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </aside>
    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php" style="font-size: 26px;font-weight: bold;color: skyblue;text-align: center;"><?php echo $_SESSION['ADMIN_NAME'] != null ? $_SESSION['ADMIN_NAME'] : "Admin" ?></a>
                    <a class="navbar-brand hidden" href="index.html"><img src="logo.png" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome <span style="color: blue;margin-left: 5px;"><?php echo $_SESSION['ADMIN_USERNAME'] != null ? $_SESSION['ADMIN_USERNAME'] : "Admin" ?></span></a>
                        <div class="user-menu dropdown-menu">
                            <?php
                            if($_SESSION['ADMIN_ROLE'] == 0){
                                ?>
                                <a class="nav-link" style="text-align: center;" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                                <?php
                            }else if($_SESSION['ADMIN_ROLE'] == 1){
                                ?>
                                <a class="nav-link" style="text-align: center;" href="change_password.php">Change Password</a>
                                <a class="nav-link" style="text-align: center;" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>