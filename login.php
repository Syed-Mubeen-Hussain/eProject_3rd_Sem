<?php
require('top.php');
$msg = '';
$email = '';
$password = '';

if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    echo "<script>window.location.href = 'index.php'</script>";
}

if (isset($_POST['submit'])) {
    $email = get_safe_value($con, $_POST['email']);
    $password = get_safe_value($con, $_POST['password']);
    $res = mysqli_query($con, "select * from customer where c_email = '$email' and c_password = '$password'");
    if (mysqli_num_rows($res) > 0) {
        $UserData = mysqli_fetch_assoc($res);
        $_SESSION['USER_LOGIN'] = 'yes';
        $_SESSION['USER_ID'] = $UserData['c_id'];
        $_SESSION['USER_IMAGE'] = $UserData['c_image'];
        $_SESSION['USER_NAME'] = $UserData['c_firstname'] . ' ' . $UserData['c_lastname'];
?>
        <script>
            window.location.href = 'index.php';
        </script>
<?php
    } else {
        $msg = "Invalid username or password";
    }
}
?>

<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active">Login</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Login Content Area -->
<div class="page-section mb-60">
    <div class="container">
        <div class="row" style="justify-content: center;">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30 mt-50">
                <!-- Login Form s-->
                <form id="formData" method="POST">
                    <div class="login-form">
                        <h4 class="login-title">Login</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label>Email Address*</label>
                                <input class="mb-0" value="<?php echo $email ?>" required type="email" name="email" placeholder="Email Address">
                            </div>
                            <div class="col-12 mb-20">
                                <label>Password</label>
                                <input class="mb-0" value="<?php echo $password ?>" required type="password" name="password" placeholder="Password">
                            </div>
                            <div class="col-md-12">
                                <button style="cursor: pointer;" id="submit" name="submit" type="submit" class="register-button mt-0">Login</button>
                            </div>
                        </div>
                        <div style="color:red!important;font-weight: 600;margin-top: 10px;"><?php echo $msg ?></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login Content Area End Here -->
<?php
require('footer.php');
?>
<script>
    $('#formData').validate({
        rules: {
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
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Invalid email",
            },
            password: {
                required: "Password is required"
            },
        }
    });

    $("#submit").click(function() {
        if ($("#formData").valid()) {}
    });
</script>