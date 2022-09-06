<?php
require('top.php');
$search = '';
$categoriesAndBrand = mysqli_query($con, "select * from category where cat_status = 1");
$totalProduct = mysqli_query($con, "select * from product where p_status = 1 and p_qty > 0");
$totalProductsCount = mysqli_num_rows($totalProduct);
$showProductsInPage = 9;
$page = ceil($totalProductsCount / $showProductsInPage);
$pageNo = 1;
if (isset($_GET['page']) && $_GET['page'] != '') {
    $pageNo = $_GET['page'];
    if ($pageNo < 1) {
?>
        <script>
            window.location.href = 'shop.php';
        </script>
    <?php
    } else if ($pageNo > $page) {
    ?>
        <script>
            window.location.href = 'shop.php';
        </script>
<?php
    }
}

if (isset($_GET['category']) && $_GET['category'] != '') {
    $filterCategory = $_GET['category'] ?? "";
    $sortBy = $_GET['sortBy'] ?? "";
    $sortByQuery = "";
    switch ($sortBy) {
        case "PriceLowToHigh":
            $sortByQuery = "order by p_price asc";
            break;
        case "PriceHighToLow":
            $sortByQuery = "order by p_price desc";
            break;
        case "A-Z":
            $sortByQuery = "order by p_name asc";
            break;
        case "Z-A":
            $sortByQuery = "order by p_name desc";
            break;
        default:
            $sortByQuery = "order by added_on desc";
            break;
    }
    $search = $_GET['search'] ?? "";
    $start_number = ($pageNo - 1) * $showProductsInPage;
    $priceFilter = (isset($_GET['minPrice']) && $_GET['minPrice'] != '' && isset($_GET['maxPrice']) && $_GET['maxPrice'] != '' ? " and p_price between $_GET[minPrice] and $_GET[maxPrice]" : "");
    $res = mysqli_query($con, "select * from product where p_status = 1 and p_qty > 0 and p_fk_cat = '$filterCategory' $priceFilter $sortByQuery limit $start_number, $showProductsInPage");
    $countOfProducts = mysqli_query($con, "select * from product where p_status = 1 and p_qty > 0 and p_fk_cat = '$filterCategory' $priceFilter $sortByQuery");
    $totalProductsCount = mysqli_num_rows($countOfProducts);
    $showProductsInPage = 9;
    $page = ceil($totalProductsCount / $showProductsInPage);

    if ($search != '') {
        $countOfProducts = mysqli_query($con, "select * from product where p_status = 1 and p_qty > 0 and p_name like '$search%' and p_fk_cat = '$filterCategory' $priceFilter $sortByQuery");
        $totalProductsCount = mysqli_num_rows($countOfProducts);
        $showProductsInPage = 9;
        $page = ceil($totalProductsCount / $showProductsInPage);
    }
}else{
$sortBy = $_GET['sortBy'] ?? "";
$sortByQuery = "";
switch ($sortBy) {
    case "PriceLowToHigh":
        $sortByQuery = "order by p_price asc";
        break;
    case "PriceHighToLow":
        $sortByQuery = "order by p_price desc";
        break;
    case "A-Z":
        $sortByQuery = "order by p_name asc";
        break;
    case "Z-A":
        $sortByQuery = "order by p_name desc";
        break;
    default:
        $sortByQuery = "order by added_on desc";
        break;
}
$search = $_GET['search'] ?? ""; // this changes
$start_number = ($pageNo - 1) * $showProductsInPage;
$priceFilter = (isset($_GET['minPrice']) && $_GET['minPrice'] != '' && isset($_GET['maxPrice']) && $_GET['maxPrice'] != '' ? " and p_price between $_GET[minPrice] and $_GET[maxPrice]" : "");
$res = mysqli_query($con, "select * from product where p_status = 1 and p_qty > 0 and p_name like '$search%' $priceFilter $sortByQuery limit $start_number, $showProductsInPage");
if ($search != '') {
    $countOfProducts = mysqli_query($con, "select * from product where p_status = 1 and p_qty > 0 and p_name like '$search%' $priceFilter $sortByQuery");
    $totalProductsCount = mysqli_num_rows($countOfProducts);
    $showProductsInPage = 9;
    $page = ceil($totalProductsCount / $showProductsInPage);
} else {
    $countOfProducts = mysqli_query($con, "select * from product where p_status = 1 and p_qty > 0 $priceFilter $sortByQuery");
    $totalProductsCount = mysqli_num_rows($countOfProducts);
    $showProductsInPage = 9;
    $page = ceil($totalProductsCount / $showProductsInPage);
}
}
?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active"><a href="shop.php">Shop</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Li's Content Wraper Area -->
<div class="content-wraper pt-60 pb-60 pt-sm-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-1 order-lg-2">
                <!-- Li's Banner Area End Here -->
                <!-- shop-top-bar start -->
                <div class="shop-top-bar mt-30">
                    <div class="li-blog-sidebar">
                        <div class="li-sidebar-search-form">
                            <form method="GET" name="searchForm" onsubmit="return ValidateForm()">
                                <?php
                                if (isset($_GET['sortBy']) && $_GET['sortBy'] != '') {
                                ?>
                                    <input type="hidden" name="sortBy" value="<?php echo $_GET['sortBy'] ?>">
                                <?php
                                }
                                if (isset($_GET['category']) && $_GET['category'] != '') {
                                ?>
                                    <input type="hidden" name="category" value="<?php echo $_GET['category'] ?>">
                                <?php
                                }
                                if ((isset($_GET['minPrice']) && $_GET['minPrice'] != '' && isset($_GET['maxPrice']) && $_GET['maxPrice'] != '')) {
                                ?>
                                    <input type="hidden" name="minPrice" value="<?php echo $_GET['minPrice'] ?>">
                                    <input type="hidden" name="maxPrice" value="<?php echo $_GET['maxPrice'] ?>">
                                <?php
                                }
                                ?>
                                <input type="text" value="<?php echo $search ?>" name="search" class="li-search-field" placeholder="Search Product...">
                                <button type="submit" class="li-search-btn"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <!-- product-select-box start -->
                    <div class="product-select-box" style="display: flex;justify-content: center;align-items: center;">
                        <div class="product-short">
                            <p>Sort By:</p>
                            <form method="GET">
                                <?php
                                if (isset($_GET['search']) && $_GET['search'] != '') {
                                ?>
                                    <input type="hidden" name="search" value="<?php echo $_GET['search'] ?>">
                                <?php
                                }
                                if (isset($_GET['category']) && $_GET['category'] != '') {
                                ?>
                                    <input type="hidden" name="category" value="<?php echo $_GET['category'] ?>">
                                <?php
                                }
                                if ((isset($_GET['minPrice']) && $_GET['minPrice'] != '' && isset($_GET['maxPrice']) && $_GET['maxPrice'] != '')) {
                                ?>
                                    <input type="hidden" name="minPrice" value="<?php echo $_GET['minPrice'] ?>">
                                    <input type="hidden" name="maxPrice" value="<?php echo $_GET['maxPrice'] ?>">
                                <?php
                                }
                                ?>
                                <select onchange="this.form.submit()" name="sortBy" class="nice-select">
                                    <?php
                                    if ($sortBy == "PriceLowToHigh") {
                                        echo '<option value="">Default New Products</option>
                                    <option value="PriceLowToHigh" selected>Price (Low &gt; High)</option>
                                    <option value="PriceHighToLow">Price (High &gt; Low)</option>
                                    <option value="A-Z">Name (A - Z)</option>
                                    <option value="Z-A">Name (Z - A)</option>';
                                    } else if ($sortBy == "PriceHighToLow") {
                                        echo '<option value="">Default New Products</option>
                                        <option value="PriceLowToHigh">Price (Low &gt; High)</option>
                                        <option value="PriceHighToLow" selected>Price (High &gt; Low)</option>
                                        <option value="A-Z">Name (A - Z)</option>
                                        <option value="Z-A">Name (Z - A)</option>';
                                    } else if ($sortBy == "A-Z") {
                                        echo '<option value="">Default New Products</option>
                                        <option value="PriceLowToHigh">Price (Low &gt; High)</option>
                                        <option value="PriceHighToLow">Price (High &gt; Low)</option>
                                        <option value="A-Z" selected>Name (A - Z)</option>
                                        <option value="Z-A">Name (Z - A)</option>';
                                    } else if ($sortBy == "Z-A") {
                                        echo '<option value="">Default New Products</option>
                                        <option value="PriceLowToHigh">Price (Low &gt; High)</option>
                                        <option value="PriceHighToLow">Price (High &gt; Low)</option>
                                        <option value="A-Z">Name (A - Z)</option>
                                        <option value="Z-A" selected>Name (Z - A)</option>';
                                    } else {

                                        echo '<option value="">Default New Products</option>
                                        <option value="PriceLowToHigh">Price (Low &gt; High)</option>
                                        <option value="PriceHighToLow">Price (High &gt; Low)</option>
                                        <option value="A-Z">Name (A - Z)</option>
                                        <option value="Z-A">Name (Z - A)</option>';
                                    }
                                    ?>
                                </select>
                            </form>
                        </div>
                    </div>
                    <!-- product-select-box end -->
                </div>
                <!-- shop-top-bar end -->
                <!-- shop-products-wrapper start -->
                <div class="shop-products-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row mb-60">
                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($list = mysqli_fetch_assoc($res)) { ?>
                                            <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                                <!-- single-product-wrap start -->
                                                <div class="single-product-wrap">
                                                    <div class="product-image" style="display: flex;justify-content: center;align-items: center;">
                                                        <a href="product.php?id=<?php echo $list['p_id'] ?>">
                                                            <img style="width: 240px;height: 135px;object-fit: cover;border-radius: 8px;" src="<?php echo IMAGE_SITE_PATH . $list['p_image'] ?>" alt="Li's Product Image">
                                                        </a>
                                                    </div>
                                                    <div class="product_desc">
                                                        <div class="product_desc_info">
                                                            <div class="product-review">
                                                                <h5 class="manufacturer">
                                                                    <?php
                                                                    $category = mysqli_query($con, "select * from category where cat_status = 1");
                                                                    if (mysqli_num_rows($category) > 0) {
                                                                        while ($c = mysqli_fetch_assoc($category)) {
                                                                            if ($c['cat_id'] == $list['p_fk_cat']) {
                                                                                echo "<a href='shop.php?category=$c[cat_id]'>$c[cat_name]</a>";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </h5>
                                                            </div>
                                                            <h4><a class="product_name" href="product.php?id=<?php echo $list['p_id'] ?>"><?php echo $list['p_name'] ?></a></h4>
                                                            <div class="price-box">
                                                                <span class="new-price">Rs <?php echo $list['p_price'] ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="add-actions">
                                                            <form method="POST">
                                                            <input type="hidden" name="p_id" value="<?php echo $list['p_id']?>">
                                                            <input type="hidden" name="qty" value="1">
                                                                <button name="addToCart" style="width: 100%;padding: 7px 0px;border: 1px solid lavender;font-size: 12px;border-radius: 3px;cursor: pointer;" class="addToCartBtn" type="submit">ADD TO CART</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- single-product-wrap end -->
                                            </div>
                                    <?php }
                                    } else {
                                        echo "<div class='col-lg-12 col-md-12 col-sm-12 mt-120' style='display: flex;
                                        justify-content: center;
                                        align-items: center;
                                        font-size: 24px;
                                        font-weight: bold;'>
                                                <div class=''>
                                                    <div>No Products Found</div>
                                                </div>
                                            </div>";
                                    }
                                    ?>


                                </div>
                            </div>
                        </div>
                        <?php
                        if ($page > 1 && mysqli_num_rows($res) > 0) {
                        ?>
                            <div class="paginatoin-area">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <ul class="pagination-box pt-xs-20 pb-xs-15">
                                            <?php
                                            if (isset($_GET['page']) && $_GET['page'] != '' && mysqli_num_rows($res) > 0) {
                                                if ($_GET['page'] > 1) {
                                                    $pageNo = $_GET['page'];
                                                    $prev = $pageNo - 1;
                                            ?>
                                                    <li><a href='?page=<?php echo $prev ?><?php echo (isset($_GET['sortBy']) && $_GET['sortBy'] != '') ? "&sortBy=$_GET[sortBy]" : "" ?><?php echo (isset($_GET['search']) && $_GET['search'] != '') ? "&search=$_GET[search]" : "" ?><?php echo (isset($_GET['category']) && $_GET['category'] != '') ? "&category=$_GET[category]" : "" ?><?php echo (isset($_GET['minPrice']) && $_GET['minPrice'] != '' && isset($_GET['maxPrice']) && $_GET['maxPrice'] != '') ? "&minPrice=$_GET[minPrice]&maxPrice=$_GET[maxPrice]" : "" ?>' class='Previous'><i class='fa fa-chevron-left'></i> Previous</a></li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($page > 1 && mysqli_num_rows($res) > 0) {
                                                for ($i = 1; $i <= $page; $i++) {
                                            ?>
                                                    <li class="<?php echo $_GET['page'] == $i || $pageNo == $i ? 'active' : '' ?>"><a href='?page=<?php echo $i ?><?php echo (isset($_GET['sortBy']) && $_GET['sortBy'] != '') ? "&sortBy=$_GET[sortBy]" : "" ?><?php echo (isset($_GET['search']) && $_GET['search'] != '') ? "&search=$_GET[search]" : "" ?><?php echo (isset($_GET['category']) && $_GET['category'] != '') ? "&category=$_GET[category]" : "" ?><?php echo (isset($_GET['minPrice']) && $_GET['minPrice'] != '' && isset($_GET['maxPrice']) && $_GET['maxPrice'] != '') ? "&minPrice=$_GET[minPrice]&maxPrice=$_GET[maxPrice]" : "" ?>'><?php echo $i ?></a></li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($page > ($_GET['page'] ?? '1') && mysqli_num_rows($res) > 0) {
                                                $pageNo = ($_GET['page'] ?? '1');
                                                $next = $pageNo + 1;
                                            ?>
                                                <li><a href='?page=<?php echo $next ?><?php echo (isset($_GET['sortBy']) && $_GET['sortBy'] != '') ? "&sortBy=$_GET[sortBy]" : "" ?><?php echo (isset($_GET['search']) && $_GET['search'] != '') ? "&search=$_GET[search]" : "" ?><?php echo (isset($_GET['category']) && $_GET['category'] != '') ? "&category=$_GET[category]" : "" ?><?php echo (isset($_GET['minPrice']) && $_GET['minPrice'] != '' && isset($_GET['maxPrice']) && $_GET['maxPrice'] != '') ? "&minPrice=$_GET[minPrice]&maxPrice=$_GET[maxPrice]" : "" ?>' class='Next'><i class='fa fa-chevron-right'></i> Next</a></li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- shop-products-wrapper end -->
            </div>
            <div class="col-lg-3 order-2 order-lg-1">
                <!--sidebar-categores-box start  -->
                <div class="sidebar-categores-box">
                    <div class="sidebar-title">
                        <h2>Filter By</h2>
                    </div>
                    <!-- btn-clear-all start -->
                    <button onclick="window.location.href = 'shop.php'" class="btn-clear-all mb-sm-30 mb-xs-30">Clear all</button>
                    <!-- btn-clear-all end -->
                    <!-- filter-sub-area start -->
                    <div class="filter-sub-area pt-sm-10 pt-xs-10">
                        <h5 class="filter-sub-titel">Categories & Brands</h5>
                        <form class="category-tags">
                            <ul>
                                <?php
                                if (mysqli_num_rows($categoriesAndBrand) > 0) {
                                    while ($category_brand = mysqli_fetch_assoc($categoriesAndBrand)) {
                                        if (isset($_GET['category']) && $category_brand['cat_id'] == $_GET['category']) {
                                            echo "<li class='active'><a style='padding:0px 3px;' href='?category=$category_brand[cat_id]'>" . $category_brand['cat_name'] . "</a></li>";
                                        } else {
                                            echo "<li><a style='padding:0px 3px;' href='?category=$category_brand[cat_id]'>" . $category_brand['cat_name'] . "</a></li>";
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </form>
                    </div>
                    <!-- filter-sub-area end -->
                    <!-- filter-sub-area start -->
                    <div class="filter-sub-area pt-sm-10 pt-xs-10">
                        <h5 class="filter-sub-titel">Price</h5>
                        <div class="size-checkbox">
                            <form method="GET">
                                <?php
                                if (isset($_GET['category']) && $_GET['category'] != '') {
                                ?>
                                    <input type="hidden" name="category" value="<?php echo $_GET['category'] ?>">
                                <?php
                                }
                                if (isset($_GET['search']) && $_GET['search'] != '') {
                                ?>
                                    <input type="hidden" name="search" value="<?php echo $_GET['search'] ?>">
                                <?php
                                }
                                if (isset($_GET['sortBy']) && $_GET['sortBy'] != '') {
                                ?>
                                    <input type="hidden" name="sortBy" value="<?php echo $_GET['sortBy'] ?>">
                                <?php
                                }
                                ?>
                                <input type="number" value="<?php echo isset($_GET['minPrice']) && $_GET['minPrice'] != '' ? $_GET['minPrice'] : 1 ?>" name="minPrice" min='1' style="width: 75px!important;border: 1px solid blue;border-radius: 4px;padding: 5px 0px 5px 10px;" placeholder="Min">
                                <span style="font-size: 20px;">-</span>
                                <input type="number" value="<?php echo isset($_GET['maxPrice']) && $_GET['maxPrice'] != '' ? $_GET['maxPrice'] : 5000 ?>" placeholder="50000" name="maxPrice" min='1' style="width: 75px!important;border: 1px solid blue;border-radius: 4px;padding: 5px 0px 5px 10px;" placeholder="Max">
                                <button type="submit" style="width: 35px;border: 0px;background: lightblue;border-radius: 5px;margin-left: 5px;height: 36px;cursor: pointer;"><img style="width: 100%;padding: 3px;" src="<?php echo IMAGE_SITE_PATH ?>play-solid.svg" alt=""></button>
                            </form>
                        </div>
                    </div>
                    <!-- filter-sub-area end -->

                </div>
            </div>
        </div>
    </div>
    <?php
    require('footer.php');
    ?>
    <script>
        $('input.chk').on('change', function() {
            $('input.chk').not(this).prop('checked', false);
        });

        function ValidateForm() {
            let x = document.forms["searchForm"]["search"].value;
            if (x.trim() == "") {
                return false;
            }
        }
    </script>