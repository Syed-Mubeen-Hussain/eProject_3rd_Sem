<?php
include('connection.inc.php');
include('function.inc.php');
$msg = '';
$firstname = '';
$lastname = '';
$email = '';
$phone = '';
$username = '';
$password = '';

if (isset($_POST['submit'])) {
    $firstname = get_safe_value($con, $_POST['ad_firstname']);
    $lastname = get_safe_value($con, $_POST['ad_lastname']);
    $email = get_safe_value($con, $_POST['ad_email']);
    $phone = get_safe_value($con, $_POST['ad_mobile']);
    $username = get_safe_value($con, $_POST['ad_username']);
    $password = get_safe_value($con, $_POST['ad_password']);

    $check_username = mysqli_query($con, "select * from admin_user where ad_username = '$username'");
    if (mysqli_num_rows($check_username) > 0) {
        $msg = 'Username already exists';
    }

    if ($msg == '') {
        $res = "INSERT INTO admin_user(ad_firstname,ad_lastname,ad_email,ad_username,ad_password,ad_role,ad_mobile,ad_status) values('$firstname','$lastname','$email','$username','$password',1,'$phone',1)";
        $run = mysqli_query($con, $res);
        if ($run) {
            echo '<script>window.location.href = "login.php"</script>';
        } else {
            $msg = "Something went wrong try again";
        }
    }
}
?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Register - Arts Stationary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <style>
      label.error {
         text-transform: capitalize;
         margin: 0px;
      }
   </style>
</head>

<body style="background-color: #100d2a;">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-form mt-10">
                    <form id="formData" action="" method="POST">
                        <h1 style="font-weight: bold;font-family: sans-serif;" class="text-center mb-3">Registration</h1>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" value="<?php echo $firstname?>" name="ad_firstname" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" value="<?php echo $lastname?>" name="ad_lastname" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo $email?>" name="ad_email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" value="<?php echo $phone?>" name="ad_mobile" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" value="<?php echo $username?>" name="ad_username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" value="<?php echo $password?>" name="ad_password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" id="submit" style="font-size: 20px;padding: 10px;font-weight: 600;" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Register</button>
                    </form>
                    <div style="color:red!important;font-weight: 600;margin-top: 10px;"><?php echo $msg ?></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="assets/js/popper.min.js" type="text/javascript"></script>
    <script src="assets/js/plugins.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
<script>
   $('#formData').validate({
      rules: {
        ad_firstname: {
            required: true,
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_lastname: {
            required: true,
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_email: {
            required: true,
            email:true,
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_mobile: {
            required: true,
            minlength:11,
            maxlength:11,
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_username: {
            required: true,
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_password: {
            required: true,
            normalizer: function(value) {
               return $.trim(value);
            }
         },
      },
      messages: {
        ad_firstname: {
            required: "First name is required",
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_lastname: {
            required: "Last name is required",
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_email: {
            required: "Email is required",
            email:"Invalid email",
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_mobile: {
            required: "Mobile is required",
            minlength:"Minimum 11 letters",
            maxlength:"Maximum 11 letters",
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_username: {
            required: "Username is required",
            normalizer: function(value) {
               return $.trim(value);
            }
         },
         ad_password: {
            required: "Password is required",
            normalizer: function(value) {
               return $.trim(value);
            }
         },
      }
   });

   $("#submit").click(function() {
      if ($("#formData").valid()) {}
   });
</script>