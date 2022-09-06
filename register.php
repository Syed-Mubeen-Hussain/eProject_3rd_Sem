<?php
require('top.php');
$msg = '';
$firstname = '';
$lastname = '';
$age = '';
$phone = '';
$gender = '';
$address = '';
$email = '';
$password = '';
$cpassword = '';

if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    echo "<script>window.location.href = 'index.php'</script>";
}

if (isset($_POST['submit'])) {
    $firstname = get_safe_value($con, $_POST['fname']);
    $lastname = get_safe_value($con, $_POST['lname']);
    $age = get_safe_value($con, $_POST['age']);
    $phone = get_safe_value($con, $_POST['phone']);
    $gender = get_safe_value($con, $_POST['gender']);
    $address = get_safe_value($con, $_POST['address']);
    $email = get_safe_value($con, $_POST['email']);
    $password = get_safe_value($con, $_POST['password']);
    $cpassword = get_safe_value($con, $_POST['cpassword']);

    if ($password != $cpassword) {
        $msg = 'Password and confirm password not same';
    }

    $check_username = mysqli_query($con, "select * from customer where c_email = '$email'");
    if (mysqli_num_rows($check_username) > 0) {
        $msg = 'Email already exists';
    }

    if ($msg == '') {
        if (strtolower($_FILES['image']['type']) == 'image/png' || strtolower($_FILES['image']['type']) == 'image/jpg' || strtolower($_FILES['image']['type']) == 'image/jpeg' || strtolower($_FILES['image']['type']) == 'image/jfif') {
            $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            $added_on = date('y-m-d h:i:s');
            $res = "INSERT INTO customer(c_firstname,c_lastname,c_age,c_phone,c_gender,c_address,c_image,c_email,c_password,c_status,added_on) values('$firstname','$lastname','$age','$phone','$gender','$address','$image','$email','$password',1,'$added_on')";
            $run = mysqli_query($con, $res);
            if ($run) {
                move_uploaded_file($_FILES['image']['tmp_name'], IMAGE_SERVER_PATH . $image);
?>
                <script>
                    swal({
                            title: "Register Successfully",
                            text: "Thank you for registration",
                            icon: "success",
                            button: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                window.location.href = 'login.php';
                            } else {
                                window.location.href = 'login.php';
                            }
                        });
                </script>
<?php
            } else {
                $msg = "Something went wrong try again";
            }
        } else {
            $msg = 'Image format not supported';
        }
    }
}

?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active">Register</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<div class="page-section mb-60">
    <div class="container">
        <div class="row" style="justify-content: center;">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mt-50">
                <form id="formData" method="POST" enctype="multipart/form-data">
                    <div class="login-form">
                        <h4 class="login-title">Register</h4>
                        <div class="row">
                            <div class="col-md-6 col-12 mb-20">
                                <label>First Name</label>
                                <input class="mb-0" name="fname" value="<?php echo $firstname ?>" required type="text" placeholder="First Name">
                            </div>
                            <div class="col-md-6 col-12 mb-20">
                                <label>Last Name</label>
                                <input class="mb-0" name="lname" value="<?php echo $lastname ?>" required type="text" placeholder="Last Name">
                            </div>
                            <div class="col-md-12 mb-20">
                                <label>Age*</label>
                                <input class="mb-0" name="age" value="<?php echo $age ?>" required type="number" placeholder="Age">
                            </div>
                            <div class="col-md-12 mb-20">
                                <label>Phone*</label>
                                <input class="mb-0" name="phone" value="<?php echo $phone ?>" required type="number" placeholder="Phone">
                            </div>
                            <div class="col-md-12 mb-20">
                                <label>Gender*</label>
                                <select required style="border: 1px solid #999999;background: transparent;" name="gender" id="">
                                    <?php
                                    if ($gender == "Male") {
                                        echo "<option value='Male' selected>Male</option>
                                            <option value='Female'>Female</option>";
                                    } else if ($gender == "Female") {
                                        echo "<option value='Male'>Male</option>
                                            <option value='Female' selected>Female</option>";
                                    } else {
                                        echo "<option value=''>Select Gender</option>
                                        <option value='Male'>Male</option>
                                            <option value='Female'>Female</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-20">
                                <label>Address</label>
                                <textarea required style="border: 1px solid #999999;background: transparent;" name="address" id="" cols="10" placeholder="Address" rows="2"><?php echo $address ?></textarea>
                            </div>
                            <div class="col-md-12 mb-20">
                                <label>Image</label>
                                <input required type="file" name="image" id="">
                            </div>
                            <div class="col-md-12 mb-20">
                                <label>Email Address*</label>
                                <input class="mb-0" name="email" value="<?php echo $email ?>" required type="email" placeholder="Email Address">
                            </div>
                            <div class="col-md-6 mb-20">
                                <label>Password</label>
                                <input class="mb-0" name="password" id="password" value="<?php echo $password ?>" required type="password" placeholder="Password">
                            </div>
                            <div class="col-md-6 mb-20">
                                <label>Confirm Password</label>
                                <input class="mb-0" name="cpassword" value="<?php echo $cpassword ?>" required type="password" placeholder="Confirm Password">
                            </div>
                            <div class="col-12">
                                <button name="submit" id="submit" style="cursor: pointer;" class="register-button mt-0">Register</button>
                            </div>
                        </div>
                        <div style="color:red!important;font-weight: 600;margin-top: 10px;"><?php echo $msg ?></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>
<script>
    $('#formData').validate({
        rules: {
            fname: {
                required: true,
                minlength: 3,
                maxlength: 20,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            lname: {
                required: true,
                minlength: 3,
                maxlength: 20,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            age: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            phone: {
                required: true,
                minlength: 11,
                maxlength: 11,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            gender: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            address: {
                required: true,
                minlength: 3,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            image: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            email: {
                required: true,
                email: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            password: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            cpassword: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
                equalTo: "#password"
            }
        },
        messages: {
            fname: {
                required: "First name is required",
                minlength: "minimum 3 letters",
                maxlength: "maximum 20 letters"
            },
            lname: {
                required: "Last name is required",
                minlength: "minimum 3 letters",
                maxlength: "maximum 20 letters"
            },
            age: {
                required: "Age is required",
            },
            phone: {
                required: "Phone number is required",
                minlength: "minimum 11 letters",
                maxlength: "maximum 11 letters",
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            gender: {
                required: "Gender is required",
            },
            address: {
                required: "Address is required",
                minlength: "minimum 3 letters"
            },
            image: {
                required: "Image is required",
            },
            email: {
                required: "Email is required",
                email: "Invalid email",
            },
            password: {
                required: "Password is required"
            },
            cpassword: {
                required: "Confirm password is required",
                equalTo: "Password is not macth"
            }
        }
    });

    $("#submit").click(function() {
        if ($("#formData").valid()) {}
    });
</script>