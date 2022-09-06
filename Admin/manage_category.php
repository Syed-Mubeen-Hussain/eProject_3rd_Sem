<?php
require('top.inc.php');
isAdmin();
$msg = '';
$category_name = '';
$category_image = '';
$image_attribute = 'required';
$button_text = 'Add Category';

if (isset($_GET['id']) && ($_GET['id'] == '' || $_GET['id'] < 1)) {
    echo "<script>window.location.href = 'category.php'</script>";
}

if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con,"select * from category where cat_id = '$id'");
    if(!mysqli_num_rows($check) > 0){
        echo "<script>window.location.href = 'category.php'</script>";
    }
    $edit_data =  mysqli_fetch_assoc(mysqli_query($con, "select * from category where cat_id = '$id'"));
    $category_name = $edit_data['cat_name'];
    $image_attribute = '';
    $button_text = 'Update Category';
}

if (isset($_POST['submit']) && $msg == '') {
    $category_name = get_safe_value($con, $_POST['cat_name']);

    if ($_FILES['cat_image']['name'] != '') {
        if (strtolower($_FILES['cat_image']['type']) == "image/png" || strtolower($_FILES['cat_image']['type']) == "image/jpg" || strtolower($_FILES['cat_image']['type']) == "image/jpeg") {
            if (!($_FILES['cat_image']['size'] <= 1000000)) {
                $msg = "Image size shoud be in 1 mb";
            }
        } else {
            $msg = "Image format not supported";
        }
    }

    $check_category = mysqli_query($con, "select * from category where cat_name = '$category_name'");
    if (mysqli_num_rows($check_category) > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
            $getData = mysqli_fetch_assoc($check_category);
            if ($id == $getData['cat_id']) {
            } else {
                $msg = "Category already exists";
            }
        } else {
            $msg = "Category already exists";
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
            if ($_FILES['cat_image']['name'] != '') {
                $image = rand(111111111, 999999999) . '_' . $_FILES['cat_image']['name'];
                move_uploaded_file($_FILES['cat_image']['tmp_name'], IMAGE_SERVER_PATH . $image);
                $update_sql = "update category set cat_name = '$category_name', cat_image = '$image' where cat_id = '$id'";
            } else {
                $update_sql = "update category set cat_name = '$category_name' where cat_id = '$id'";
            }
            $run = mysqli_query($con, $update_sql);
            if ($run) {
                echo "<script>window.location.href = 'category.php';</script>";
            } else {
                $msg = "Category not update";
            }
        } else {
            $image = rand(111111111, 999999999) . '_' . $_FILES['cat_image']['name'];
            $res = mysqli_query($con, "INSERT INTO category(cat_name,cat_image,cat_status) values('$category_name','$image',1)");
            if ($res) {
                move_uploaded_file($_FILES['cat_image']['tmp_name'], IMAGE_SERVER_PATH . $image);
                echo "<script>window.location.href = 'category.php';</script>";
            } else {
                $msg = "Category not add";
            }
        }
    }
}

if (isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) {
    $image_attribute = 'readonly';
    $button_text = 'Cancel';
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con,"select * from category where cat_id = '$id'");
    if(!mysqli_num_rows($check) > 0){
        echo "<script>window.location.href = 'category.php'</script>";
    }
    $details_data =  mysqli_fetch_assoc(mysqli_query($con, "select * from category where cat_id = '$id'"));
    $category_name = $details_data['cat_name'];
    $category_image = $details_data['cat_image'];
}

?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <form id="formData" method="POST" class="card" enctype="multipart/form-data">
                    <div class="card-header"><strong>Category</strong><small> Form</small></div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Name</label>
                            <input type="text" value="<?php echo $category_name ?>" required placeholder="Enter category name" name="cat_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php if ($category_image != '') { ?>
                                <img style="height: 200px;width: 394px;object-fit: cover;" src="<?php echo IMAGE_SITE_PATH . $category_image ?>" alt="">
                            <?php } else {
                                echo "<label for='company' class='form-control-label'>Image</label>";
                                echo "<input type='file' $image_attribute name='cat_image' class='form-control'>";
                            } ?>
                        </div>
                        <?php if ($button_text == "Cancel") {
                            echo "<a class='btn btn-lg btn-info btn-block' href='category.php'>Cancel</a>";
                        } else {
                            echo "<button id='payment-button' id='submit' name='submit' type='submit' class='btn btn-lg btn-info btn-block'>
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