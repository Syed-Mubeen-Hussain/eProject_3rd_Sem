<?php
require('top.inc.php');
isAdmin();
$msg = '';
$contact_name = '';
$contact_email = '';
$contact_subject = '';
$contact_message = '';
$contact_added_on = '';

// check if set id or id is not empty or id is not less then 1 
if (isset($_GET['id']) && ($_GET['id'] == '' || $_GET['id'] < 1)) {
    echo "<script>window.location.href = 'contact.php'</script>";
}

// details work
if (isset($_GET['id']) && !($_GET['id'] == '' || $_GET['id'] < 1) && (isset($_GET['type']) && $_GET['type'] != '')) {
    $id = get_safe_value($con, $_GET['id']);
    $check = mysqli_query($con,"select * from contact where cont_id = '$id'");
    if(!mysqli_num_rows($check) > 0){
        echo "<script>window.location.href = 'contact.php'</script>";
    }
    $details_data =  mysqli_fetch_assoc(mysqli_query($con, "select * from contact where cont_id = '$id'"));
    $contact_name = $details_data['cont_name'];
    $contact_email = $details_data['cont_email'];
    $contact_subject = $details_data['cont_subject'];
    $contact_message = $details_data['cont_message'];
    $contact_added_on = $details_data['added_on'];
}else{
    echo "<script>window.location.href = 'contact.php'</script>";
}

?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" class="card">
                    <div class="card-header"><strong>Contact</strong><small> Form</small></div>
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Name</label>
                            <input type="text" value="<?php echo $contact_name ?>" disabled required placeholder="contact name" name="cont_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Email</label>
                            <input type="text" value="<?php echo $contact_email ?>" disabled required placeholder="contact email" name="cont_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Subject</label>
                            <input type="text" value="<?php echo $contact_subject ?>" disabled required placeholder="contact subject" name="cont_subject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Message</label>
                            <textarea name="cont_message" disabled required placeholder="contact message" cols="30" rows="3" class="form-control"><?php echo $contact_message ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="company" class=" form-control-label">Date</label>
                            <input type="text" value="<?php echo $contact_added_on ?>" disabled required placeholder="Date" name="date" class="form-control">
                        </div>
                        <a class='btn btn-lg btn-info btn-block' href='contact.php'>Cancel</a>
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