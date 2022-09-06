<?php
require('top.php');
$msg = '';
$first_name = '';
$last_name = '';
$age = '';
$phone = '';
$gender = '';
$address = '';
$email = '';
$password = '';

if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    $customer_id = $_SESSION['USER_ID'];
    $customer = mysqli_fetch_assoc(mysqli_query($con, "select * from customer where c_id = '$customer_id'"));

    $_SESSION['USER_IMAGE'] = $customer['c_image'];
    if (isset($_POST['submit'])) {
        $first_name = get_safe_value($con, $_POST['first_name']);
        $last_name = get_safe_value($con, $_POST['last_name']);
        $age = get_safe_value($con, $_POST['age']);
        $phone = get_safe_value($con, $_POST['phone']);
        $gender = get_safe_value($con, $_POST['gender']);
        $address = get_safe_value($con, $_POST['address']);
        $email = get_safe_value($con, $_POST['email']);
        $password = get_safe_value($con, $_POST['password']);

        $check_email = mysqli_query($con, "select * from customer where c_email = '$email'");
        $customer_id_check = mysqli_fetch_assoc($check_email);
        if ($customer_id_check['c_id'] == $customer_id) {
            if (is_uploaded_file($_FILES['image']['tmp_name'])) {

                if (strtolower($_FILES['image']['type']) == 'image/png' || strtolower($_FILES['image']['type']) == 'image/jpg' || strtolower($_FILES['image']['type']) == 'image/jpeg' || strtolower($_FILES['image']['type']) == 'image/jfif') {
                    $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];

                    $update_sql = mysqli_query($con, "update customer set c_firstname = '$first_name', c_lastname = '$last_name', c_age = '$age', c_phone = '$phone', c_gender = '$gender', c_address = '$address', c_email = '$email', c_password = '$password',c_image = '$image' where c_id = '$customer_id'");
                    if ($update_sql) {
                        move_uploaded_file($_FILES['image']['tmp_name'], IMAGE_SERVER_PATH . $image);
                        $_SESSION['USER_IMAGE'] = $image;
?>
                        <script>
                            swal({
                                title: "Profile Has Been Updated",
                                icon: "success",
                                button: true,
                            }).then((willDelete) => {
                                if (willDelete) {
                                    window.location.href = 'index.php';
                                } else {
                                    window.location.href = 'index.php';
                                }
                            });
                        </script>
                    <?php
                    }
                } else {
                    $msg = 'Image format not supported';
                }
            } else {
                $update_sql = mysqli_query($con, "update customer set c_firstname = '$first_name', c_lastname = '$last_name', c_age = '$age', c_phone = '$phone', c_gender = '$gender', c_address = '$address', c_email = '$email', c_password = '$password' where c_id = '$customer_id'");
                if ($update_sql) {
                    ?>
                    <script>
                        swal({
                            title: "Profile Has Been Updated",
                            icon: "success",
                            button: true,
                        }).then((willDelete) => {
                            if (willDelete) {
                                window.location.href = 'index.php';
                            } else {
                                window.location.href = 'index.php';
                            }
                        });
                    </script>
    <?php
                }
            }
        } else {
            $msg = 'Email Already Exists';
        }
    }
} else {
    ?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}
?>
<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .account-settings .user-profile {
        margin: 0 0 1rem 0;
        padding-bottom: 1rem;
        text-align: center;
    }

    .account-settings .user-profile .user-avatar {
        margin: 0 0 1rem 0;
    }

    .account-settings .user-profile .user-avatar img {
        width: 90px;
        height: 90px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
    }

    .account-settings .user-profile h5.user-name {
        margin: 0 0 0.5rem 0;
    }

    .account-settings .user-profile h6.user-email {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 400;
        color: #9fa8b9;
    }

    .account-settings .about {
        margin: 2rem 0 0 0;
        text-align: center;
    }

    .account-settings .about h5 {
        margin: 0 0 15px 0;
        color: #007ae1;
    }

    .account-settings .about p {
        font-size: 0.825rem;
    }

    .form-control {
        border: 1px solid #cfd1d8;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        font-size: .825rem;
        background: #ffffff;
        color: #2e323c;
    }

    .card {
        background: #ffffff;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }
</style>
<div class="container">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <img src="<?php echo IMAGE_SITE_PATH . $customer['c_image'] ?>" alt="Maxwell Admin">
                            </div>
                            <h5 class="user-name"><?php echo $customer['c_firstname'] . ' ' . $customer['c_lastname'] ?></h5>
                            <h6 class="user-email"><?php echo $customer['c_email'] ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6 class="mb-2 text-primary">Personal Details</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" value="<?php echo $first_name != '' ? $first_name : $customer['c_firstname'] ?>" name="first_name" class="form-control" placeholder="Enter first name">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" value="<?php echo $last_name != '' ? $last_name : $customer['c_lastname'] ?>" name="last_name" class="form-control" placeholder="Enter first name">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Age</label>
                                <input type="number" name="age" value="<?php echo $age != '' ? $age : $customer['c_age'] ?>" class="form-control" placeholder="Enter age">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="number" name="phone" value="<?php echo $phone != '' ? $phone : $customer['c_phone'] ?>" class="form-control" placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control" id="">
                                    <?php
                                    if ($gender != '') {
                                        if ($gender == "Male") {
                                            echo "<option value='Male' selected>Male</option>";
                                            echo "<option value='Female'>Female</option>";
                                        } else if ($gender == "Female") {
                                            echo "<option value='Male'>Male</option>";
                                            echo "<option value='Female' selected>Female</option>";
                                        }
                                    } else {
                                        if ($customer['c_gender'] == "Male") {
                                            echo "<option value='Male' selected>Male</option>";
                                            echo "<option value='Female'>Female</option>";
                                        } else if ($customer['c_gender'] == "Female") {
                                            echo "<option value='Male'>Male</option>";
                                            echo "<option value='Female' selected>Female</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" value="<?php echo $address != '' ? $address : $customer['c_address'] ?>" class="form-control" placeholder="Enter address">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo $email != '' ? $email : $customer['c_email'] ?>" class="form-control" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" value="<?php echo $password != '' ? $password : $customer['c_password'] ?>" class="form-control" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Change Image</label>
                                <input type="file" name="image" class="form-control" id="">
                            </div>
                        </div>
                        <div style="display: flex;justify-content: flex-end;align-items: center;margin-top:15px;" class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <button type="button" onclick="window.location.href = 'index.php'" id="submit" name="submit" class="mx-1 btn btn-secondary">Cancel</button>
                            <button type="submit" name="submit" class="mx-1 btn btn-primary">Update</button>
                        </div>
                    </form>
                    <label class="error"><?php echo $msg ?></label>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>