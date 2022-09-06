<?php
require('top.inc.php');
isAdmin();
$msg = '';
$customer_firstname = '';
$customer_lastname = '';
$customer_age = '';
$customer_phone = '';
$customer_gender = '';
$customer_address = '';
$customer_email = '';
$customer_password = '';
$customer_image = '';
$button_text = '';
$image_attribute = 'required';
$disabled = '';

$categories = mysqli_query($con, "select * from customer order by c_id desc");

// check if set id or id is not empty or id is not less then 1 
if (isset($_GET['id']) && ($_GET['id'] == '' || $_GET['id'] < 1)) {
    echo "<script>window.location.href = 'customer.php'</script>";
}

// Edit Show Data in Textboxes
if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con,"select * from customer where c_id = '$id'");
    if(!mysqli_num_rows($check) > 0){
        echo "<script>window.location.href = 'customer.php'</script>";
    }
    $edit_data =  mysqli_fetch_assoc(mysqli_query($con, "select * from customer where c_id = '$id'"));
    $customer_firstname = $edit_data['c_firstname'];
    $customer_lastname = $edit_data['c_lastname'];
    $customer_age = $edit_data['c_age'];
    $customer_phone = $edit_data['c_phone'];
    $customer_gender = $edit_data['c_gender'];
    $customer_address = $edit_data['c_address'];
    $customer_email = $edit_data['c_email'];
    $customer_password = $edit_data['c_password'];
    $image_attribute = '';
    $button_text = 'Update customer';
}

// submit form
if (isset($_POST['submit']) && $msg == '') {
    $customer_firstname = get_safe_value($con, $_POST['c_firstname']);
    $customer_lastname = get_safe_value($con, $_POST['c_lastname']);
    $customer_age = get_safe_value($con, $_POST['c_age']);
    $customer_phone = get_safe_value($con, $_POST['c_phone']);
    $customer_gender = get_safe_value($con, $_POST['c_gender']);
    $customer_address = get_safe_value($con, $_POST['c_address']);
    $customer_email = get_safe_value($con, $_POST['c_email']);
    $customer_password = get_safe_value($con, $_POST['c_password']);

    // Image Upload Validation
    if ($_FILES['c_image']['name'] != '') {
        if (strtolower($_FILES['c_image']['type']) == "image/png" || strtolower($_FILES['c_image']['type']) == "image/jpg" || strtolower($_FILES['c_image']['type']) == "image/jpeg") {
            if (!($_FILES['c_image']['size'] <= 1000000)) {
                $msg = "Image size shoud be in 1 mb";
            }
        } else {
            $msg = "Image format not supported";
        }
    }

    // check unique customer
    $check_customer = mysqli_query($con, "select * from customer where c_email = '$customer_email'");
    if (mysqli_num_rows($check_customer) > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
            $getData = mysqli_fetch_assoc($check_customer);
            if ($id == $getData['c_id']) {
            } else {
                $msg = "Customer already exists";
            }
        }
    }

    // update customer
    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '' && !isset($_GET['type'])) {
            if ($_FILES['c_image']['name'] != '') {
                $image = rand(111111111, 999999999) . '_' . $_FILES['c_image']['name'];
                move_uploaded_file($_FILES['c_image']['tmp_name'], IMAGE_SERVER_PATH . $image);
                $update_sql = "update customer set c_firstname = '$customer_firstname',c_lastname = '$customer_lastname',c_age = '$customer_age',c_phone = '$customer_phone',c_gender = '$customer_gender',c_address = '$customer_address',c_image = '$image',c_email = '$customer_email',c_password = '$customer_password'  where c_id = '$id'";
            } else {
                $update_sql = "update customer set c_firstname = '$customer_firstname',c_lastname = '$customer_lastname',c_age = '$customer_age',c_phone = '$customer_phone',c_gender = '$customer_gender',c_address = '$customer_address',c_email = '$customer_email',c_password = '$customer_password'  where c_id = '$id'";
            }
            $run = mysqli_query($con, $update_sql);
            if ($run) {
                echo "<script>window.location.href = 'customer.php';</script>";
            } else {
                $msg = "Customer not update";
            }
        }
    }
}


// details work
if (isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) {
    $button_text = 'Cancel';
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con,"select * from customer where c_id = '$id'");
    if(!mysqli_num_rows($check) > 0){
        echo "<script>window.location.href = 'customer.php'</script>";
    }
    $details_data =  mysqli_fetch_assoc(mysqli_query($con, "select * from customer where c_id = '$id'"));
    $customer_firstname = $details_data['c_firstname'];
    $customer_lastname = $details_data['c_lastname'];
    $customer_age = $details_data['c_age'];
    $customer_phone = $details_data['c_phone'];
    $customer_gender = $details_data['c_gender'];
    $customer_image = $details_data['c_image'];
    $customer_address = $details_data['c_address'];
    $customer_email = $details_data['c_email'];
    $customer_password = $details_data['c_password'];
    $disabled = 'disabled';
}

?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" class="card" enctype="multipart/form-data">
                    <div class="card-header"><strong>Customer</strong><small> Form</small></div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="company" class=" form-control-label">First Name</label>
                            <input type="text" value="<?php echo $customer_firstname ?>" <?php echo $disabled ?> required placeholder="Enter customer first name" name="c_firstname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Last Name</label>
                            <input type="text" value="<?php echo $customer_lastname ?>" <?php echo $disabled ?> required placeholder="Enter customer last name" name="c_lastname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Age</label>
                            <input type="text" value="<?php echo $customer_age ?>" <?php echo $disabled ?> required placeholder="Enter customer age" name="c_age" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Phone</label>
                            <input type="number" value="<?php echo $customer_phone ?>" <?php echo $disabled ?> required placeholder="Enter customer phone" name="c_phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Gender</label>
                            <select <?php echo $disabled ?>  name="c_gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Address</label>
                            <textarea type="text" required placeholder="Enter customer address" name="c_address" <?php echo $disabled ?> class="form-control"><?php echo $customer_address ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Email</label>
                            <input type="email" value="<?php echo $customer_email ?>" <?php echo $disabled ?> required placeholder="Enter customer email" name="c_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Password</label>
                            <input type="text" value="<?php echo $customer_password ?>" <?php echo $disabled ?> required placeholder="Enter customer password" name="c_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php if ($customer_image != '') { ?>
                                <img style="height: 200px;width: 394px;object-fit: cover;" src="<?php echo IMAGE_SITE_PATH . $customer_image ?>" alt="">
                            <?php } else {
                                echo "<label for='company' class='form-control-label'>Image</label>";
                                echo "<input type='file' name='c_image' $image_attribute class='form-control'>";
                            } ?>
                        </div>
                        <?php if ($button_text == "Cancel") {
                            echo "<a class='btn btn-lg btn-info btn-block' href='customer.php'>Cancel</a>";
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