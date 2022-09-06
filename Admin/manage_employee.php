<?php
require('top.inc.php');
isAdmin();
$msg = '';
$employee_firstname = '';
$employee_lastname = '';
$employee_email = '';
$employee_username = '';
$employee_password = '';
$employee_mobile = '';

// check if set id or id is not empty or id is not less then 1 
if (isset($_GET['id']) && ($_GET['id'] == '' || $_GET['id'] < 1)) {
    echo "<script>window.location.href = 'employee.php'</script>";
}

// details work
if (isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) {
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con,"select * from admin_user where ad_id = '$id' and ad_role = 1 ");
    if(!mysqli_num_rows($check) > 0){
        echo "<script>window.location.href = 'employee.php'</script>";
    }
    $details_data =  mysqli_fetch_assoc(mysqli_query($con, "select * from admin_user where ad_id = '$id' and ad_role = 1"));
    $employee_firstname = $details_data['ad_firstname'];
    $employee_lastname = $details_data['ad_lastname'];
    $employee_email = $details_data['ad_email'];
    $employee_username = $details_data['ad_username'];
    $employee_password = $details_data['ad_password'];
    $employee_mobile = $details_data['ad_mobile'];
}else{
    echo "<script>window.location.href = 'employee.php'</script>";
}

?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" class="card">
                    <div class="card-header"><strong>Employee</strong><small> Form</small></div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="company" class=" form-control-label">First Name</label>
                            <input type="text" value="<?php echo $employee_firstname ?>" disabled required placeholder="employee first name" name="ad_firstname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Last Name</label>
                            <input type="text" value="<?php echo $employee_lastname ?>" disabled required placeholder="employee last name" name="ad_lastname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Email</label>
                            <input type="text" value="<?php echo $employee_email ?>" disabled required placeholder="employee email" name="ad_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Phone</label>
                            <input type="number" value="<?php echo $employee_mobile ?>" disabled required placeholder="employee phone" name="ad_mobile" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Username</label>
                            <input type="text" value="<?php echo $employee_username ?>" disabled required placeholder="employee username" name="ad_username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Password</label>
                            <input type="text" value="<?php echo $employee_password ?>" disabled required placeholder="employee password" name="ad_password" class="form-control">
                        </div>
                        <a class='btn btn-lg btn-info btn-block' href='employee.php'>Cancel</a>
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