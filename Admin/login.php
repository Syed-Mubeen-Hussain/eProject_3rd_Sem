<?php
include('connection.inc.php');
include('function.inc.php');
$msg = '';

if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
   echo "<script>window.location.href = 'Dashboard.php'</script>";
}

if (isset($_POST['submit'])) {
   $username = get_safe_value($con, $_POST['username']);
   $password = get_safe_value($con, $_POST['password']);
   $res = "select * from admin_user where ad_username = '$username' and ad_password = '$password'";
   $run = mysqli_query($con, $res);
   $count = mysqli_num_rows($run);
   if ($count > 0) {
      $row = mysqli_fetch_assoc($run);
      if ($row['ad_status'] == 0) {
         $msg = "Account deactivated";
      }
      $_SESSION['ADMIN_LOGIN'] = 'yes';
      $_SESSION['ADMIN_ID'] = $row['ad_id'];
      $_SESSION['ADMIN_USERNAME'] = $row['ad_username'];
      $_SESSION['ADMIN_NAME'] = $row['ad_firstname'] . $row['ad_lastname'];
      $_SESSION['ADMIN_ROLE'] = $row['ad_role'];
      echo "<script>window.location.href = 'dashboard.php'</script>";
   } else {
      $msg = "Invalid username or password";
   }
}
?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Login - Arts Stationary</title>
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

<body class="bg-dark">
   <div class="sufee-login d-flex align-content-center flex-wrap">
      <div class="container">
         <div class="login-content">
            <div class="login-form mt-150">
               <form action="" id="formData" method="POST">
                  <h1 style="font-weight: bold;font-family: sans-serif;" class="text-center mb-3">Login</h1>
                  <div class="form-group">
                     <label>Username</label>
                     <input type="text" name="username" class="form-control" placeholder="Username" required>
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" name="password" class="form-control" placeholder="Password" required>
                  </div>
                  <button type="submit" id="submit" style="font-size: 20px;padding: 10px;font-weight: 600;" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Login</button>
               </form>
               <div style="color:red!important;font-weight: 600;margin-top: 10px;"><?php echo $msg ?></div>
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
         username: {
            required: true,
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
         username: {
            required: "Username is required",
         },
         password: {
            required: "Password is required",
         },
      }
   });

   $("#submit").click(function() {
      if ($("#formData").valid()) {}
   });
</script>