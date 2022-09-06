<?php
require('top.inc.php');
$msg = '';
$btn_disabled = '';
$current_password = '';
$new_password = '';
$confirm_password = '';
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
    $customer_id = $_SESSION['ADMIN_ID'];
    if (isset($_POST['submit'])) {
        $current_password = get_safe_value($con, $_POST['current_password']);
        $new_password = get_safe_value($con, $_POST['new_password']);
        $confirm_password = get_safe_value($con, $_POST['confirm_password']);
    
        $current_password_check = mysqli_query($con, "select * from admin_user where ad_password = '$current_password' and ad_id = '$customer_id'");
        if (mysqli_num_rows($current_password_check) > 0) {
            if($new_password == $confirm_password){
                $update_password = mysqli_query($con,"update admin_user set ad_password = '$new_password' where ad_id = '$customer_id'");
                if($update_password){
                    $btn_disabled = 'disabled';
                    $msg = 'Password Change Successfully';
                    ?>
                    <script>
                        setTimeout(() => {
                            window.location.href = 'dashboard.php';
                        }, 2000);
                    </script>
                    <?php
                }else{
                    $msg = 'password not change';        
                }
            }else{
                $msg = 'New password and confirm password is not match';    
            }
        } else {
            $msg = 'Invalid current password';
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
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row" style="justify-content: center;">
            <div class="col-lg-12">
                <form method="POST" class="card">
                    <div class="card-header"><strong>Change Password</strong><small> Form</small></div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Current Password</label>
                            <input type="text" value="<?php echo $current_password ?>" required placeholder="current password" name="current_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">New Password</label>
                            <input type="text" value="<?php echo $new_password ?>" required placeholder="new password" name="new_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Confirm Password</label>
                            <input type="text" value="<?php echo $confirm_password ?>" required placeholder="confirm password" name="confirm_password" class="form-control">
                        </div>
                        <button id="payment-button" <?php echo $btn_disabled?> name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">Change Passoword</span>
                        </button>
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