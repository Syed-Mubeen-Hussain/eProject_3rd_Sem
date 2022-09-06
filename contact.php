<?php
require('top.php');
$msg = '';
if (isset($_POST['submit'])) {
    $name = get_safe_value($con, $_POST['cont_name']);
    $email = get_safe_value($con, $_POST['cont_email']);
    $subject = get_safe_value($con, $_POST['cont_subject']);
    $message = get_safe_value($con, $_POST['cont_message']);

    $added_on = date('y-m-d h:i:s');
    $res = mysqli_query($con, "INSERT INTO contact(cont_name,cont_email,cont_subject,cont_message,added_on) values('$name','$email','$subject','$message','$added_on')");
    if ($res) {
?>
        <script>
            swal({
                    title: "Form Has Been Submitted!",
                    text: "Thank you",
                    icon: "success",
                    button: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = 'index.php';
                    } else {
                        window.location.href = 'index.php';
                    }
                });
        </script>
<?php
    } else {
        $msg = 'Something went wrong';
    }
}
?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Contact</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Contact Main Page Area -->
<div class="contact-main-page mt-60 mb-40 mb-md-40 mb-sm-40 mb-xs-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-0 col-md-12 order-2 order-lg-1">
                <div class="contact-form-content pt-sm-55 pt-xs-55">
                    <h3 class="contact-page-title">Contact Us</h3>
                    <div class="contact-form">
                        <form id="formData" method="post">
                            <div class="form-group">
                                <label>Your Name <span class="required">*</span></label>
                                <input type="text" required name="cont_name" id="cont_name" required>
                            </div>
                            <div class="form-group">
                                <label>Your Email <span class="required">*</span></label>
                                <input type="email" required name="cont_email" id="cont_email" required>
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" required name="cont_subject" id="cont_subject">
                            </div>
                            <div class="form-group mb-30">
                                <label>Your Message</label>
                                <textarea required name="cont_message" id="cont_message"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="submit" style="cursor: pointer;" value="submit" class="li-btn-3" name="submit">send</button>
                            </div>
                        </form>
                    </div>
                    <p class="form-messege"><?php echo $msg?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Main Page Area End Here -->
<?php
require('footer.php');
?>
<script>
    $('#formData').validate({
        rules: {
            cont_name: {
                required: true,
                minlength:3,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            cont_email: {
                required: true,
                email: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            cont_subject: {
                required: true,
                minlength:3,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            cont_message: {
                required: true,
                minlength:3,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
        },
        messages: {
            cont_name: {
                required: "Name is required",
                minlength: "minimum 3 letters"
            },
            cont_email: {
                required: "Email is required",
                email: "Invalid email"
            },
            cont_subject: {
                required: "Subject is required",
                minlength: "minimum 3 letters"
            },
            cont_message: {
                required: "Message is required",
                minlength:"minimum 3 letters"
            },
        }
    });

    $("#submit").click(function() {
        if ($("#formData").valid()) {}
    });
</script>