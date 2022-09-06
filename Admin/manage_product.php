<?php
require('top.inc.php');

$condition = '';
if ($_SESSION['ADMIN_ROLE'] == 1) {
    $condition = "and p_added_by = '" . $_SESSION['ADMIN_ID'] . "'";
}

$msg = '';
$product_name = '';
$product_price = '';
$product_description = '';
$product_qty = '';
$product_added_by = '';
$product_image = '';
$button_text = 'Add Product';
$image_attribute = 'required';
$disabled = '';

$categories = mysqli_query($con, "select * from category order by cat_id desc");

// check if set id or id is not empty or id is not less then 1 
if (isset($_GET['id']) && ($_GET['id'] == '' || $_GET['id'] < 1)) {
    echo "<script>window.location.href = 'product.php'</script>";
}

// Edit Show Data in Textboxes
if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con, "select * from product where p_id = '$id' $condition");
    if (!mysqli_num_rows($check) > 0) {
        echo "<script>window.location.href = 'product.php'</script>";
    }
    $edit_data =  mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$id' $condition"));
    $product_name = $edit_data['p_name'];
    $product_price = $edit_data['p_price'];
    $product_description = $edit_data['p_description'];
    $product_qty = $edit_data['p_qty'];
    $image_attribute = '';
    $button_text = 'Update Product';
}

// submit form
if (isset($_POST['submit']) && $msg == '') {
    $category_id = get_safe_value($con, $_POST['category_id']);
    $product_name = get_safe_value($con, $_POST['p_name']);
    $product_price = get_safe_value($con, $_POST['p_price']);
    $product_qty = get_safe_value($con, $_POST['p_qty']);
    $product_description = get_safe_value($con, $_POST['p_description']);

    // Image Upload Validation
    if ($_FILES['p_image']['name'] != '') {
        if (strtolower($_FILES['p_image']['type']) == "image/png" || strtolower($_FILES['p_image']['type']) == "image/jpg" || strtolower($_FILES['p_image']['type']) == "image/jpeg" || strtolower($_FILES['p_image']['type']) == "image/jfif") {
            if (!($_FILES['p_image']['size'] <= 1000000)) {
                $msg = "Image size shoud be in 1 mb";
            }
        } else {
            $msg = "Image format not supported";
        }
    }

    // check unique product
    $check_product = mysqli_query($con, "select * from product where p_name = '$product_name'");
    if (mysqli_num_rows($check_product) > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
            $getData = mysqli_fetch_assoc($check_product);
            if ($id == $getData['p_id']) {
            } else {
                $msg = "Product already exists";
            }
        } else {
            $msg = "Product already exists";
        }
    }

    // insert and update product
    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
            if ($_FILES['p_image']['name'] != '') {
                $image = rand(111111111, 999999999) . '_' . $_FILES['p_image']['name'];
                move_uploaded_file($_FILES['p_image']['tmp_name'], IMAGE_SERVER_PATH . $image);
                $update_sql = "update product set p_name = '$product_name',p_price = '$product_price',p_description = '$product_description',p_qty = '$product_qty', p_image = '$image',p_fk_cat = '$category_id' where p_id = '$id' $condition";
            } else {
                $update_sql = "update product set p_name = '$product_name',p_price = '$product_price',p_description = '$product_description',p_qty = '$product_qty',p_fk_cat = '$category_id' where p_id = '$id' $condition";
            }
            $run = mysqli_query($con, $update_sql);
            if ($run) {
                echo "<script>window.location.href = 'product.php';</script>";
            } else {
                $msg = "product not update";
            }
        } else {
            $image = rand(111111111, 999999999) . '_' . $_FILES['p_image']['name'];
            function check_id($con)
            {
                $product_id = 25 . rand(11111, 99999);
                $check_product_id = mysqli_query($con, "select * from product where p_id = $product_id");
                if (mysqli_num_rows($check_product_id) > 0) {
                    check_id($con);
                } else {
                    return $product_id;
                }
            }
            $pro_id = check_id($con);
            $added_on = date('y-m-d h:i:s');
            $added_by = $_SESSION['ADMIN_ID'];
            $res = mysqli_query($con, "INSERT INTO product(p_id,p_name,p_price,p_image,p_description,p_qty,p_status,p_fk_cat,p_added_by,added_on) values('$pro_id','$product_name','$product_price','$image','$product_description','$product_qty',1,'$category_id','$added_by','$added_on')");
            if ($res) {
                move_uploaded_file($_FILES['p_image']['tmp_name'], IMAGE_SERVER_PATH . $image);
                echo "<script>window.location.href = 'product.php';</script>";
            } else {
                $msg = "Product not add";
            }
        }
    }
}


// details work
if (isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) {
    $button_text = 'Cancel';
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con, "select * from product where p_id = '$id'");
    if (!mysqli_num_rows($check) > 0) {
        echo "<script>window.location.href = 'product.php'</script>";
    }
    $details_data =  mysqli_fetch_assoc(mysqli_query($con, "select product.*, admin_user.ad_username from product,admin_user where p_id = '$id' && product.p_added_by = admin_user.ad_id"));
    $product_name = $details_data['p_name'];
    $product_price = $details_data['p_price'];
    $product_description = $details_data['p_description'];
    $product_qty = $details_data['p_qty'];
    $product_added_by = $details_data['ad_username'];
    $product_image = $details_data['p_image'];
    $disabled = 'disabled';
}

?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" class="card" enctype="multipart/form-data">
                    <div class="card-header"><strong>Product</strong><small> Form</small></div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Category</label>
                            <select name="category_id" class="form-control" required <?php echo $disabled ?>>
                                <option value="">Select Category</option>
                                <?php
                                if (mysqli_num_rows($categories) > 0) {
                                    while ($category = mysqli_fetch_assoc($categories)) {
                                        if ($edit_data["p_fk_cat"] == $category["cat_id"] || $details_data["p_fk_cat"] == $category["cat_id"]) {
                                            echo "<option value='$category[cat_id]' selected>$category[cat_name]</option>";
                                        } else if ($category_id == $category["cat_id"]) {
                                            echo "<option value='$category[cat_id]' selected>$category[cat_name]</option>";
                                        } else {
                                            echo "<option value='$category[cat_id]'>$category[cat_name]</option>";
                                        }
                                    }
                                } else {
                                    echo "<option value=''>No category found</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php if ($product_added_by != '' && isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) { ?>
                            <div class="form-group">
                                <label for="company" class=" form-control-label">Added By</label>
                                <input type="text" value="<?php echo $product_added_by ?>" <?php echo $disabled ?> required placeholder="Product Added By" class="form-control">
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Name</label>
                            <input type="text" value="<?php echo $product_name ?>" <?php echo $disabled ?> required placeholder="Enter product name" name="p_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Price</label>
                            <input type="text" value="<?php echo $product_price ?>" <?php echo $disabled ?> required placeholder="Enter product price" name="p_price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Description</label>
                            <textarea type="text" required placeholder="Enter product description" name="p_description" <?php echo $disabled ?> class="form-control"><?php echo $product_description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Qty</label>
                            <input type="number" value="<?php echo $product_qty ?>" <?php echo $disabled ?> required placeholder="Enter product qty" name="p_qty" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php if ($product_image != '') { ?>
                                <img style="height: 200px;width: 394px;object-fit: cover;" src="<?php echo IMAGE_SITE_PATH . $product_image ?>" alt="">
                            <?php } else {
                                echo "<label for='company' class='form-control-label'>Image</label>";
                                echo "<input type='file' name='p_image' $image_attribute class='form-control'>";
                            } ?>
                        </div>
                        <?php if ($button_text == "Cancel") {
                            echo "<a class='btn btn-lg btn-info btn-block' href='product.php'>Cancel</a>";
                        } else {
                            echo "<button id='payment-button' name='submit' type='submit' class='btn btn-lg btn-info btn-block'>
                            <span id='payment-button-amount'>$button_text</span>
                            </button>";
                        }
                        ?>
                        <div style="padding-top: 10px;color: red;font-weight: 600;"><?php echo $msg; ?></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.inc.php');
?>