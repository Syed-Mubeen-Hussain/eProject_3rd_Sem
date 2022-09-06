<?php
require('connection.inc.php');
require('function.inc.php');
$page_title = '';

$categories = mysqli_query($con, "select * from category where cat_status = 1");
$search_categories = mysqli_query($con, "select * from category where cat_status = 1 order by cat_id desc");
$search = $_GET['search'] ?? "";
$notification_count = '';
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    $customer_id = $_SESSION['USER_ID'];
    $notification_count = mysqli_num_rows(mysqli_query($con, "select * from notifications where n_fk_customer_id = '$customer_id'"));
} else {
    $notification_count = 0;
}

if (isset($_POST['removeCartProduct'])) {
    $product_id = get_safe_value($con, $_POST['id']);
    $customer_id = $_SESSION['USER_ID'];
    if ($customer_id > 0) {
        $res = mysqli_query($con, "delete from cart where car_fk_product_id = '$product_id' and car_fk_cus_id = '$customer_id'");
        if ($res) {
?>
            <script>
                window.location.href = window.location.href;
            </script>
<?php
        }
    }
}

// Page Title Set 

$script_name = $_SERVER['SCRIPT_NAME'];
$script_name_arr = explode('/', $script_name);
$my_page = $script_name_arr[count($script_name_arr) - 1];
if ($my_page == "product.php") {
    $product_id = get_safe_value($con, $_GET['id']);
    $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$product_id'"));
    if (mysqli_num_rows(mysqli_query($con, "select * from product where p_id = '$product_id'")) > 0) {
        $page_title = $product['p_name'];
    }
}
if ($my_page == "index.php") {
    $page_title = "Home";
}
if ($my_page == "about.php") {
    $page_title = "About Us";
}
if ($my_page == "contact.php") {
    $page_title = "Contact Us";
}
if ($my_page == "login.php") {
    $page_title = "Login";
}
if ($my_page == "register.php") {
    $page_title = "Register";
}
if ($my_page == "cart.php") {
    $page_title = "Cart";
}
if ($my_page == "profile.php") {
    $page_title = "Profile";
}
if ($my_page == "return_product.php") {
    $page_title = "Return Product";
}
if ($my_page == "notification.php") {
    $page_title = "Notifications";
}
if ($my_page == "faq.php") {
    $page_title = "Faq's";
}
if ($my_page == "shop.php") {
    $page_title = "Shop";
}
if ($my_page == "checkout.php") {
    $page_title = "Checkout";
}
if ($my_page == "thank_you.php") {
    $page_title = "Thank You";
}
if ($my_page == "order.php") {
    $page_title = "Orders";
}

?>
<!doctype html>
<html>

<!-- index28:48-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $page_title . ' - Arts Stationary' ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.jpg">
    <!-- Material Design Iconic Font-V2.2.0 -->
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Font Awesome Stars-->
    <link rel="stylesheet" href="css/fontawesome-stars.css">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="css/meanmenu.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Jquery-ui CSS -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="css/venobox.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Bootstrap V4.1.3 Fremwork CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="css/helper.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Modernizr js -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <style>
        body>div>header>div.header-middle.pl-sm-0.pr-sm-0.pl-xs-0.pr-xs-0>div>div>div.col-lg-9.pl-0.ml-sm-15.ml-xs-15>form>div>ul {
            height: auto;
        }
    </style>
</head>

<body>
    <div id="loading"></div>
    <div class="body-wrapper">
        <!-- Begin Header Area -->
        <header>
            <!-- Begin Header Middle Area -->
            <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Logo Area -->
                        <div class="col-lg-3">
                            <div class="logo pb-sm-30 pb-xs-30">
                                <a href="index.php" style="display: flex;align-items: center;">
                                    <img src="images/favicon.jpg" style="width: 33px;margin-right: 4px;" alt="">
                                    <div style="font-size: 27px;font-weight: bold;">Arts Stationary</div>
                                </a>
                            </div>
                        </div>
                        <!-- Header Logo Area End Here -->
                        <!-- Begin Header Middle Right Area -->
                        <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                            <!-- Begin Header Middle Searchbox Area -->
                            <form action="shop.php" class="hm-searchbox">
                                <select name="category" class="nice-select select-search-category">
                                    <option value="">All</option>
                                    <?php
                                    if (mysqli_num_rows($search_categories) > 0) {
                                        while ($category = mysqli_fetch_assoc($search_categories)) {
                                            if ((isset($_GET['category']) && $_GET['category'] != '') && $_GET['category'] == $category['cat_id']) {
                                                echo "<option selected value='$category[cat_id]'>$category[cat_name]</option>";
                                            } else {
                                                echo "<option value='$category[cat_id]'>$category[cat_name]</option>";
                                            }
                                        }
                                    } ?>
                                </select>
                                <input type="text" value="<?php echo $search ?>" name="search" placeholder="Search Product ...">
                                <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <!-- Header Middle Searchbox Area End Here -->
                            <!-- Begin Header Middle Right Area -->
                            <div class="header-middle-right" style="justify-content: center;">
                                <ul class="hm-menu" style="display: flex;justify-content: space-between;">
                                    <!-- Begin Header Middle Wishlist Area -->
                                    <?php
                                    $totalAmount = 0;
                                    if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
                                        $cart_details = mysqli_query($con, "select * from cart where car_fk_cus_id = '$_SESSION[USER_ID]'");
                                        $cart_count = mysqli_num_rows(mysqli_query($con, "select * from cart where car_fk_cus_id = '$_SESSION[USER_ID]'"));
                                        while ($product_id = mysqli_fetch_assoc($cart_details)) {
                                            $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$product_id[car_fk_product_id]'"));
                                            $totalAmount += $product['p_price'] * $product_id['car_product_qty'];
                                        }
                                    ?>
                                        <!-- Header Middle Wishlist Area End Here -->
                                        <!-- Begin Header Mini Cart Area -->
                                        <li class="hm-minicart">
                                            <!-- <div class="hm-minicart-trigger">
                                                <span class="item-icon"></span>
                                                <span class="cart-item-count"><?php echo $cart_count ?></span>
                                            </div> -->

                                        <li class="hm-wishlist hm-minicart-trigger p-0">
                                            <a href="notification.php" style="background: #e80f0f;color: white;border: none;font-size: 23px;width: 48px;">
                                                <span class="cart-item-count wishlist-item-count"><?php echo $cart_count ?></span>
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                        <div class="minicart" style="z-index: 100000;">
                                            <ul class="minicart-product-list">
                                                <?php
                                                $cart_details_product = mysqli_query($con, "select * from cart where car_fk_cus_id = '$_SESSION[USER_ID]'");
                                                if (mysqli_num_rows($cart_details_product) > 0) {
                                                    while ($product_id = mysqli_fetch_assoc($cart_details_product)) {
                                                        $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$product_id[car_fk_product_id]'"));
                                                ?>
                                                        <li>
                                                            <a href="product.php?id=<?php echo $product['p_id'] ?>" class="minicart-product-image">
                                                                <img style="width: 100%;height: 46px;object-fit: cover;" src="<?php echo IMAGE_SITE_PATH . $product['p_image'] ?>" alt="cart products">
                                                            </a>
                                                            <div class="minicart-product-details">
                                                                <h6><a href="product.php?id=<?php echo $product['p_id'] ?>"><?php echo $product['p_name'] ?></a></h6>
                                                                <span><b>Rs</b><?php echo $product['p_price'] ?> x <?php echo $product_id['car_product_qty'] ?></span>
                                                            </div>
                                                            <form method="POST">
                                                                <input type="hidden" name="id" value="<?php echo $product['p_id'] ?>">
                                                                <button class="close" name="removeCartProduct" title="Remove">
                                                                    <i class="fa fa-close"></i>
                                                                </button>
                                                            </form>
                                                        </li>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<li style='ttext-align: center;
                                                        display: flex;
                                                        justify-content: center;
                                                        align-items: center;
                                                        font-weight: bold;
                                                        border: 0px;
                                                        padding: 0px;
                                                        margin: 0px;'>No Product In Cart</li>";
                                                }
                                                ?>
                                            </ul>
                                            <?php
                                            if (mysqli_num_rows($cart_details_product) > 0) {
                                            ?>
                                                <p class="minicart-total">TOTAL: <span>Rs <?php echo $totalAmount ?></span></p>
                                                <div class="minicart-button">
                                                    <a href="cart.php" class="li-button li-button-fullwidth li-button-dark">
                                                        <span>View Full Cart</span>
                                                    </a>
                                                    <a href="checkout.php" class="li-button li-button-fullwidth">
                                                        <span>Checkout</span>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        </li>
                                        <li class="hm-wishlist">
                                            <a href="notification.php">
                                                <span class="cart-item-count wishlist-item-count"><?php echo $notification_count ?></span>
                                                <i class="fa fa-bell"></i>
                                            </a>
                                        </li>
                                        <li id="profile_check" class="hm-wishlist" style="float: none;">
                                            <img id="profile_image" src="<?php echo IMAGE_SITE_PATH . $_SESSION['USER_IMAGE'] ?>" style="width: 45px;height: 45px;object-fit: cover;border-radius: 50px;cursor: pointer;" alt="">
                                            <div id="profile_details" style="display:none;position: absolute;width: 200px;background: white;z-index: 99;border-radius: 3px;padding: 10px 20px;box-shadow: rgb(0 0 0 / 20%) 0px 1px 2px 2px;top: 50px;right: -82px;">
                                                <div>
                                                    <h4 style="text-align: center;margin-bottom: 8px;"><?php echo $_SESSION['USER_NAME'] ?></h4>
                                                </div>
                                                <hr style="margin: 0px;margin-bottom: 13px;">
                                                <div style="margin: 8px 0px;font-size: 16px;text-align: center;"><a href="profile.php">View Profile</a></div>
                                                <div style="margin: 8px 0px;font-size: 16px;text-align: center;"><a href="order.php">My Orders</a></div>
                                                <div style="margin: 8px 0px;font-size: 16px;text-align: center;"><a href="logout.php">Logout</a></div>
                                            </div>
                                        </li>
                                    <?php
                                    } else {
                                    ?>
                                        <li style="display: flex;justify-content: center;align-items: center;">

                                            <a class="links" href="register.php" style="text-transform: capitalize; height: 45px;line-height: 45px;width: 100px;margin-left: 22px;">Register</a>

                                            <a class="links" href="login.php" style="text-transform: capitalize;height: 45px;line-height: 45px;width: 100px;margin-left: 22px;">Login</a>

                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <!-- Header Mini Cart Area End Here -->
                                </ul>
                            </div>
                            <!-- Header Middle Right Area End Here -->
                        </div>
                        <!-- Header Middle Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Middle Area End Here -->
            <!-- Begin Header Bottom Area -->
            <div class="header-bottom header-sticky d-none d-lg-block d-xl-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Header Bottom Menu Area -->
                            <div class="hb-menu">
                                <nav>
                                    <ul>
                                        <li><a class="menu_link" href="index.php">Home</a></li>
                                        <li><a class="menu_link" href="about.php">About Us</a></li>
                                        <li><a class="menu_link" href="shop.php">Shop</a></li>
                                        <li><a class="menu_link menu_links" href="shop.php">Products</a>
                                            <ul class="hb-dropdown">
                                                <?php
                                                if (mysqli_num_rows($categories) > 0) {
                                                    while ($category = mysqli_fetch_assoc($categories)) {
                                                ?>
                                                        <li><a href="shop.php?category=<?php echo $category['cat_id'] ?>"><?php echo $category['cat_name'] ?></a></li>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a class="menu_link" href="contact.php">Contact</a></li>
                                        <li><a class="menu_link" href="shop.php?minPrice=1&maxPrice=99">Below Rs.99</a></li>
                                        <li><a class="menu_link" href="faq.php">Faq</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Header Bottom Menu Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Bottom Area End Here -->
            <!-- Begin Mobile Menu Area -->
            <div class="mobile-menu-area d-lg-none d-xl-none col-12">
                <div class="container">
                    <div class="row">
                        <div class="mobile-menu">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End Here -->
        </header>
        <?php



        if (isset($_POST['addToCart'])) {
            if (isset($_SESSION['USER_ID']) && $_SESSION['USER_ID'] != '') {
                $id = get_safe_value($con, $_POST['p_id']);
                $qty = $_POST['qty'] ?? 0;
                $customer_id = $_SESSION['USER_ID'];
                $product_qty_check = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$id'"));
                if ($product_qty_check['p_qty'] > 0 && $qty <= $product_qty_check['p_qty'] && $qty > 0) {
                    $check_product = mysqli_query($con, "select * from cart where car_fk_cus_id = '$customer_id' and car_fk_product_id = '$id'");
                    if (mysqli_num_rows($check_product) > 0) {
                        $existing_product_qty = mysqli_fetch_assoc($check_product);
                        $update_qty = mysqli_query($con, "update cart set car_product_qty = $qty where car_fk_product_id = '$id'");
                        if ($update_qty) {
        ?>
                            <script>
                                swal({
                                        title: "Product Add To Cart!",
                                        text: "Check Your Cart",
                                        icon: "success",
                                        button: true,
                                    })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            window.location.href = window.location.href;
                                        } else {
                                            window.location.href = window.location.href;
                                        }
                                    });
                            </script>
                        <?php
                        }
                    } else {
                        $res = mysqli_query($con, "INSERT into cart(car_fk_product_id,car_product_qty,car_fk_cus_id) values('$id','$qty','$customer_id')");
                        if ($res) {
                        ?>
                            <script>
                                swal({
                                        title: "Product Add To Cart!",
                                        text: "Check Your Cart",
                                        icon: "success",
                                        button: true,
                                    })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            window.location.href = window.location.href;
                                        } else {
                                            window.location.href = window.location.href;
                                        }
                                    });
                            </script>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <script>
                        swal({
                            title: "Product out of stock",
                            text: "Select another related product",
                            icon: "error",
                            button: true,
                        });
                    </script>
                <?php
                }
            } else {
                ?>
                <script>
                    window.location.href = 'login.php';
                </script>
        <?php
            }
        }
        ?>